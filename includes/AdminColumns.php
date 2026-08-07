<?php
/**
 * Admin list table columns.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * Puts the numbers that matter on the Parts and Assemblies list screens.
 */
final class AdminColumns {

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_filter( 'manage_' . PostTypes::PART . '_posts_columns', [ $this, 'part_columns' ] );
		add_action( 'manage_' . PostTypes::PART . '_posts_custom_column', [ $this, 'part_column' ], 10, 2 );
		add_filter( 'manage_edit-' . PostTypes::PART . '_sortable_columns', [ $this, 'sortable_part_columns' ] );

		add_filter( 'manage_' . PostTypes::ASSEMBLY . '_posts_columns', [ $this, 'assembly_columns' ] );
		add_action( 'manage_' . PostTypes::ASSEMBLY . '_posts_custom_column', [ $this, 'assembly_column' ], 10, 2 );
		add_filter( 'manage_edit-' . PostTypes::ASSEMBLY . '_sortable_columns', [ $this, 'sortable_part_columns' ] );

		add_filter( 'manage_' . PostTypes::BOM . '_posts_columns', [ $this, 'bom_columns' ] );
		add_action( 'manage_' . PostTypes::BOM . '_posts_custom_column', [ $this, 'bom_column' ], 10, 2 );

		add_action( 'pre_get_posts', [ $this, 'sort_query' ] );
	}

	/**
	 * Columns for the Parts list.
	 *
	 * @param array<string, string> $columns Existing columns.
	 *
	 * @return array<string, string>
	 */
	public function part_columns( array $columns ): array {
		return $this->insert_after(
			$columns,
			'title',
			[
				'wpbom_number' => __( 'Number', 'wp-bom' ),
				'wpbom_cost'   => __( 'Unit Cost', 'wp-bom' ),
				'wpbom_stock'  => __( 'On Hand', 'wp-bom' ),
				'wpbom_used'   => __( 'Used In', 'wp-bom' ),
				'wpbom_status' => __( 'Status', 'wp-bom' ),
			]
		);
	}

	/**
	 * Columns for the Assemblies list.
	 *
	 * @param array<string, string> $columns Existing columns.
	 *
	 * @return array<string, string>
	 */
	public function assembly_columns( array $columns ): array {
		return $this->insert_after(
			$columns,
			'title',
			[
				'wpbom_number' => __( 'Number', 'wp-bom' ),
				'wpbom_lines'  => __( 'Lines', 'wp-bom' ),
				'wpbom_cost'   => __( 'Rolled-up Cost', 'wp-bom' ),
				'wpbom_used'   => __( 'Used In', 'wp-bom' ),
				'wpbom_status' => __( 'Status', 'wp-bom' ),
			]
		);
	}

	/**
	 * Columns for the BOM list.
	 *
	 * @param array<string, string> $columns Existing columns.
	 *
	 * @return array<string, string>
	 */
	public function bom_columns( array $columns ): array {
		return $this->insert_after(
			$columns,
			'title',
			[
				'wpbom_root' => __( 'Assembly', 'wp-bom' ),
				'wpbom_qty'  => __( 'Build Qty', 'wp-bom' ),
				'wpbom_cost' => __( 'Total Cost', 'wp-bom' ),
			]
		);
	}

	/**
	 * Insert columns after a known key, preserving order.
	 *
	 * @param array<string, string> $columns Existing columns.
	 * @param string                $after   Key to insert after.
	 * @param array<string, string> $new     Columns to add.
	 *
	 * @return array<string, string>
	 */
	private function insert_after( array $columns, string $after, array $new ): array {
		$result = [];

		foreach ( $columns as $key => $label ) {
			$result[ $key ] = $label;

			if ( $key === $after ) {
				$result += $new;
			}
		}

		// If the anchor was missing, still surface the new columns.
		return $result + $new;
	}

	/**
	 * Render a Parts column.
	 *
	 * @param string $column  Column key.
	 * @param int    $post_id Post ID.
	 */
	public function part_column( string $column, int $post_id ): void {
		switch ( $column ) {
			case 'wpbom_number':
				echo esc_html( $this->number_with_rev( $post_id ) );
				break;

			case 'wpbom_cost':
				echo esc_html( Render::money( Meta::get_float( $post_id, Meta::UNIT_COST ) ) );
				break;

			case 'wpbom_stock':
				$this->render_stock( $post_id );
				break;

			case 'wpbom_used':
				$this->render_used_in( $post_id );
				break;

			case 'wpbom_status':
				$this->render_status( $post_id );
				break;
		}
	}

	/**
	 * Render an Assemblies column.
	 *
	 * @param string $column  Column key.
	 * @param int    $post_id Post ID.
	 */
	public function assembly_column( string $column, int $post_id ): void {
		switch ( $column ) {
			case 'wpbom_number':
				echo esc_html( $this->number_with_rev( $post_id ) );
				break;

			case 'wpbom_lines':
				echo (int) count( Meta::get_items( $post_id ) );
				break;

			case 'wpbom_cost':
				$tree = Explosion::tree( $post_id, 1.0 );
				echo esc_html( Render::money( null === $tree ? 0.0 : (float) $tree['unit_cost'] ) );
				break;

			case 'wpbom_used':
				$this->render_used_in( $post_id );
				break;

			case 'wpbom_status':
				$this->render_status( $post_id );
				break;
		}
	}

	/**
	 * Render a BOM column.
	 *
	 * @param string $column  Column key.
	 * @param int    $post_id Post ID.
	 */
	public function bom_column( string $column, int $post_id ): void {
		$root_id = (int) get_post_meta( $post_id, Meta::ROOT_ID, true );
		$qty     = Meta::get_float( $post_id, Meta::BUILD_QTY );
		$qty     = $qty > 0 ? $qty : 1.0;

		switch ( $column ) {
			case 'wpbom_root':
				if ( $root_id > 0 ) {
					printf(
						'<a href="%s">%s</a>',
						esc_url( (string) get_edit_post_link( $root_id ) ),
						esc_html( get_the_title( $root_id ) )
					);
				} else {
					echo '<span class="wpbom-muted">' . esc_html__( 'Not set', 'wp-bom' ) . '</span>';
				}
				break;

			case 'wpbom_qty':
				echo esc_html( Render::qty( $qty ) );
				break;

			case 'wpbom_cost':
				$tree = $root_id > 0 ? Explosion::tree( $root_id, $qty ) : null;
				echo esc_html( Render::money( null === $tree ? 0.0 : (float) $tree['ext_cost'] ) );
				break;
		}
	}

	/**
	 * Part number plus revision.
	 */
	private function number_with_rev( int $post_id ): string {
		$number   = Meta::get_string( $post_id, Meta::PART_NUMBER );
		$revision = Meta::get_string( $post_id, Meta::REVISION );

		if ( '' === $number ) {
			return '—';
		}

		return '' !== $revision ? $number . ' rev ' . $revision : $number;
	}

	/**
	 * Stock level, flagged when at or below the reorder point.
	 */
	private function render_stock( int $post_id ): void {
		$stock   = Meta::get_float( $post_id, Meta::STOCK_QTY );
		$reorder = Meta::get_float( $post_id, Meta::REORDER_QTY );
		$low     = $reorder > 0 && $stock <= $reorder;

		printf(
			'<span class="%s">%s</span>',
			$low ? 'wpbom-low-stock' : '',
			esc_html( Render::qty( $stock ) )
		);
	}

	/**
	 * Count of parent assemblies, linking to a filtered list.
	 */
	private function render_used_in( int $post_id ): void {
		$parents = Meta::where_used( $post_id );
		$count   = count( $parents );

		if ( 0 === $count ) {
			echo '<span class="wpbom-muted">0</span>';

			return;
		}

		$titles = [];

		foreach ( array_slice( $parents, 0, 5 ) as $parent_id ) {
			$titles[] = get_the_title( $parent_id );
		}

		printf(
			'<span title="%s">%d</span>',
			esc_attr( implode( ', ', $titles ) ),
			(int) $count
		);
	}

	/**
	 * Status badge.
	 */
	private function render_status( int $post_id ): void {
		$status   = Meta::get_string( $post_id, Meta::STATUS );
		$statuses = Meta::statuses();

		if ( '' === $status || ! isset( $statuses[ $status ] ) ) {
			echo '<span class="wpbom-muted">—</span>';

			return;
		}

		printf(
			'<span class="wpbom-badge wpbom-badge-%s">%s</span>',
			esc_attr( $status ),
			esc_html( $statuses[ $status ] )
		);
	}

	/**
	 * Make the number column sortable.
	 *
	 * @param array<string, string> $columns Sortable columns.
	 *
	 * @return array<string, string>
	 */
	public function sortable_part_columns( array $columns ): array {
		$columns['wpbom_number'] = 'wpbom_number';

		return $columns;
	}

	/**
	 * Apply the part-number sort.
	 *
	 * @param \WP_Query $query Current query.
	 */
	public function sort_query( \WP_Query $query ): void {
		if ( ! is_admin() || ! $query->is_main_query() ) {
			return;
		}

		if ( 'wpbom_number' !== $query->get( 'orderby' ) ) {
			return;
		}

		$query->set( 'meta_key', Meta::PART_NUMBER ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		$query->set( 'orderby', 'meta_value' );
	}
}
