<?php
/**
 * Meta schema, registration and typed accessors.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * The single source of truth for every custom field the plugin stores.
 *
 * This replaces the plugin's old ACF dependency. Scalar fields are plain post
 * meta; line items are one JSON-ish array under Meta::ITEMS plus a denormalised
 * Meta::CHILD_ID row per child so "where used" is a single indexed meta query
 * instead of a full table scan.
 */
final class Meta {

	// Shared identity fields, on both parts and assemblies.
	public const PART_NUMBER = '_wpbom_part_number';
	public const REVISION    = '_wpbom_revision';
	public const UOM         = '_wpbom_uom';
	public const STATUS      = '_wpbom_status';
	public const NOTES       = '_wpbom_notes';

	// Part-only fields.
	public const UNIT_COST   = '_wpbom_unit_cost';
	public const WEIGHT      = '_wpbom_weight';
	public const STOCK_QTY   = '_wpbom_stock_qty';
	public const REORDER_QTY = '_wpbom_reorder_qty';
	public const LEAD_TIME   = '_wpbom_lead_time';
	public const MPN         = '_wpbom_mpn';

	// Assembly-only fields.
	public const ITEMS      = '_wpbom_items';
	public const CHILD_ID   = '_wpbom_child_id';
	public const LABOR_COST = '_wpbom_labor_cost';

	// BOM document fields.
	public const ROOT_ID  = '_wpbom_root_id';
	public const BUILD_QTY = '_wpbom_build_qty';

	/**
	 * Units of measure offered in the UI.
	 *
	 * @return array<string, string>
	 */
	public static function units(): array {
		return [
			'ea'  => __( 'Each', 'wp-bom' ),
			'set' => __( 'Set', 'wp-bom' ),
			'in'  => __( 'Inch', 'wp-bom' ),
			'ft'  => __( 'Foot', 'wp-bom' ),
			'mm'  => __( 'Millimetre', 'wp-bom' ),
			'm'   => __( 'Metre', 'wp-bom' ),
			'lb'  => __( 'Pound', 'wp-bom' ),
			'kg'  => __( 'Kilogram', 'wp-bom' ),
			'g'   => __( 'Gram', 'wp-bom' ),
			'l'   => __( 'Litre', 'wp-bom' ),
			'gal' => __( 'Gallon', 'wp-bom' ),
			'hr'  => __( 'Hour', 'wp-bom' ),
		];
	}

	/**
	 * Lifecycle states offered in the UI.
	 *
	 * @return array<string, string>
	 */
	public static function statuses(): array {
		return [
			'active'    => __( 'Active', 'wp-bom' ),
			'prototype' => __( 'Prototype', 'wp-bom' ),
			'hold'      => __( 'On Hold', 'wp-bom' ),
			'obsolete'  => __( 'Obsolete', 'wp-bom' ),
		];
	}

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_action( 'init', [ $this, 'register_meta' ], 7 );
	}

	/**
	 * Expose scalar meta to the REST API with proper types and auth.
	 */
	public function register_meta(): void {
		$string_fields = [
			self::PART_NUMBER => PostTypes::ITEM_TYPES,
			self::REVISION    => PostTypes::ITEM_TYPES,
			self::UOM         => PostTypes::ITEM_TYPES,
			self::STATUS      => PostTypes::ITEM_TYPES,
			self::MPN         => [ PostTypes::PART ],
		];

		foreach ( $string_fields as $key => $types ) {
			foreach ( $types as $type ) {
				register_post_meta(
					$type,
					$key,
					[
						'type'              => 'string',
						'single'            => true,
						'default'           => '',
						'show_in_rest'      => true,
						'sanitize_callback' => 'sanitize_text_field',
						'auth_callback'     => [ $this, 'can_edit' ],
					]
				);
			}
		}

		$number_fields = [
			self::UNIT_COST   => [ PostTypes::PART ],
			self::WEIGHT      => [ PostTypes::PART ],
			self::STOCK_QTY   => [ PostTypes::PART ],
			self::REORDER_QTY => [ PostTypes::PART ],
			self::LABOR_COST  => [ PostTypes::ASSEMBLY ],
			self::BUILD_QTY   => [ PostTypes::BOM ],
		];

		foreach ( $number_fields as $key => $types ) {
			foreach ( $types as $type ) {
				register_post_meta(
					$type,
					$key,
					[
						'type'              => 'number',
						'single'            => true,
						'default'           => 0,
						'show_in_rest'      => true,
						'sanitize_callback' => [ self::class, 'sanitize_float' ],
						'auth_callback'     => [ $this, 'can_edit' ],
					]
				);
			}
		}

		register_post_meta(
			PostTypes::PART,
			self::LEAD_TIME,
			[
				'type'              => 'integer',
				'single'            => true,
				'default'           => 0,
				'show_in_rest'      => true,
				'sanitize_callback' => 'absint',
				'auth_callback'     => [ $this, 'can_edit' ],
			]
		);

		register_post_meta(
			PostTypes::BOM,
			self::ROOT_ID,
			[
				'type'              => 'integer',
				'single'            => true,
				'default'           => 0,
				'show_in_rest'      => true,
				'sanitize_callback' => 'absint',
				'auth_callback'     => [ $this, 'can_edit' ],
			]
		);

		foreach ( PostTypes::ITEM_TYPES as $type ) {
			register_post_meta(
				$type,
				self::NOTES,
				[
					'type'              => 'string',
					'single'            => true,
					'default'           => '',
					'show_in_rest'      => true,
					'sanitize_callback' => 'wp_kses_post',
					'auth_callback'     => [ $this, 'can_edit' ],
				]
			);
		}
	}

	/**
	 * Meta auth callback.
	 *
	 * @param bool   $allowed   Current decision.
	 * @param string $meta_key  Meta key.
	 * @param int    $object_id Post ID.
	 */
	public function can_edit( bool $allowed, string $meta_key, int $object_id ): bool {
		return current_user_can( 'edit_post', $object_id );
	}

	/**
	 * Coerce any user input into a non-negative float.
	 *
	 * Accepts "1,234.50", "$12.00" and "" without warnings.
	 *
	 * @param mixed $value Raw value.
	 */
	public static function sanitize_float( mixed $value ): float {
		if ( is_array( $value ) ) {
			return 0.0;
		}

		$clean = preg_replace( '/[^0-9.\-]/', '', (string) $value );

		if ( null === $clean || '' === $clean ) {
			return 0.0;
		}

		return max( 0.0, (float) $clean );
	}

	/**
	 * Read a float meta value.
	 */
	public static function get_float( int $post_id, string $key ): float {
		return self::sanitize_float( get_post_meta( $post_id, $key, true ) );
	}

	/**
	 * Read a string meta value.
	 */
	public static function get_string( int $post_id, string $key ): string {
		$value = get_post_meta( $post_id, $key, true );

		return is_scalar( $value ) ? (string) $value : '';
	}

	/**
	 * Read the line items of an assembly.
	 *
	 * Always returns a clean, re-indexed list of
	 * ['item_id' => int, 'qty' => float, 'reference' => string, 'note' => string].
	 *
	 * @return array<int, array{item_id:int, qty:float, reference:string, note:string}>
	 */
	public static function get_items( int $post_id ): array {
		$raw = get_post_meta( $post_id, self::ITEMS, true );

		if ( ! is_array( $raw ) ) {
			return [];
		}

		$items = [];

		foreach ( $raw as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}

			$item_id = isset( $row['item_id'] ) ? absint( $row['item_id'] ) : 0;

			if ( $item_id <= 0 ) {
				continue;
			}

			$items[] = [
				'item_id'   => $item_id,
				'qty'       => isset( $row['qty'] ) ? self::sanitize_float( $row['qty'] ) : 0.0,
				'reference' => isset( $row['reference'] ) ? sanitize_text_field( (string) $row['reference'] ) : '',
				'note'      => isset( $row['note'] ) ? sanitize_text_field( (string) $row['note'] ) : '',
			];
		}

		return $items;
	}

	/**
	 * Persist line items and rebuild the where-used index.
	 *
	 * @param int                       $post_id Assembly ID.
	 * @param array<int, array<string, mixed>> $items   Raw rows.
	 */
	public static function set_items( int $post_id, array $items ): void {
		$clean = [];
		$seen  = [];

		foreach ( $items as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}

			$item_id = isset( $row['item_id'] ) ? absint( $row['item_id'] ) : 0;

			// Drop blank rows, self-references, and anything that isn't a real
			// part or assembly. A self-reference would be an instant cycle.
			if ( $item_id <= 0 || $item_id === $post_id ) {
				continue;
			}

			$item_type = get_post_type( $item_id );

			if ( ! in_array( $item_type, PostTypes::ITEM_TYPES, true ) ) {
				continue;
			}

			$qty = isset( $row['qty'] ) ? self::sanitize_float( $row['qty'] ) : 0.0;

			if ( $qty <= 0 ) {
				$qty = 1.0;
			}

			$clean[] = [
				'item_id'   => $item_id,
				'qty'       => $qty,
				'reference' => isset( $row['reference'] ) ? sanitize_text_field( (string) $row['reference'] ) : '',
				'note'      => isset( $row['note'] ) ? sanitize_text_field( (string) $row['note'] ) : '',
			];

			$seen[ $item_id ] = true;
		}

		if ( empty( $clean ) ) {
			delete_post_meta( $post_id, self::ITEMS );
		} else {
			update_post_meta( $post_id, self::ITEMS, $clean );
		}

		// Rebuild the denormalised child index used by where-used lookups.
		delete_post_meta( $post_id, self::CHILD_ID );

		foreach ( array_keys( $seen ) as $child_id ) {
			add_post_meta( $post_id, self::CHILD_ID, $child_id );
		}
	}

	/**
	 * Assemblies that directly contain the given item.
	 *
	 * @return int[]
	 */
	public static function where_used( int $item_id ): array {
		if ( $item_id <= 0 ) {
			return [];
		}

		$ids = get_posts(
			[
				'post_type'        => PostTypes::ASSEMBLY,
				'post_status'      => [ 'publish', 'draft', 'pending', 'private' ],
				'posts_per_page'   => 200,
				'fields'           => 'ids',
				'no_found_rows'    => true,
				'suppress_filters' => false,
				'meta_query'       => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					[
						'key'   => self::CHILD_ID,
						'value' => $item_id,
					],
				],
			]
		);

		return array_map( 'intval', $ids );
	}
}
