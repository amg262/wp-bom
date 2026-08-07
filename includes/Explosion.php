<?php
/**
 * Multi-level BOM explosion.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * Walks an assembly tree and rolls up quantity, cost and weight.
 *
 * The original implementation hand-unrolled three levels of nesting with copied
 * loops and no protection against an assembly that (directly or indirectly)
 * contained itself. This is a single recursive walk with an explicit ancestor
 * path, so a cycle is detected and reported instead of exhausting memory.
 */
final class Explosion {

	/**
	 * Hard ceiling on recursion regardless of settings.
	 */
	public const MAX_DEPTH_LIMIT = 25;

	/**
	 * Per-request memo of resolved post data, keyed by post ID.
	 *
	 * @var array<int, array<string, mixed>|null>
	 */
	private static array $post_cache = [];

	/**
	 * Build the exploded tree for a root item.
	 *
	 * @param int   $root_id   Part or assembly ID.
	 * @param float $build_qty How many of the root are being built.
	 * @param int   $max_depth Maximum nesting depth; 0 uses the configured default.
	 *
	 * @return array<string, mixed>|null Root node, or null if the post is unusable.
	 */
	public static function tree( int $root_id, float $build_qty = 1.0, int $max_depth = 0 ): ?array {
		$root = self::resolve( $root_id );

		if ( null === $root ) {
			return null;
		}

		if ( $max_depth <= 0 ) {
			$max_depth = Settings::max_depth();
		}

		$max_depth = (int) min( max( 1, $max_depth ), self::MAX_DEPTH_LIMIT );
		$build_qty = $build_qty > 0 ? $build_qty : 1.0;

		return self::build_node(
			$root_id,
			$build_qty,
			$build_qty,
			'',
			'',
			0,
			$max_depth,
			[]
		);
	}

	/**
	 * Recursively build one node of the tree.
	 *
	 * @param int      $post_id   Item being expanded.
	 * @param float    $qty_per   Quantity of this item per one of its parent.
	 * @param float    $qty_total Extended quantity for the whole build.
	 * @param string   $reference Reference designator from the parent line.
	 * @param string   $note      Line note from the parent line.
	 * @param int      $depth     Current depth, root is 0.
	 * @param int      $max_depth Depth ceiling.
	 * @param int[]    $path      Ancestor IDs, used for cycle detection.
	 *
	 * @return array<string, mixed>
	 */
	private static function build_node(
		int $post_id,
		float $qty_per,
		float $qty_total,
		string $reference,
		string $note,
		int $depth,
		int $max_depth,
		array $path
	): array {
		$data = self::resolve( $post_id );

		if ( null === $data ) {
			return self::placeholder_node( $post_id, $qty_per, $qty_total, $reference, $note, $depth, 'missing' );
		}

		$node = [
			'id'          => $post_id,
			'title'       => $data['title'],
			'type'        => $data['type'],
			'part_number' => $data['part_number'],
			'revision'    => $data['revision'],
			'uom'         => $data['uom'],
			'status'      => $data['status'],
			'edit_link'   => $data['edit_link'],
			'permalink'   => $data['permalink'],
			'qty_per'     => $qty_per,
			'qty_total'   => $qty_total,
			'reference'   => $reference,
			'note'        => $note,
			'depth'       => $depth,
			'children'    => [],
			'cycle'       => false,
			'missing'     => false,
			'truncated'   => false,
		];

		// A part is always a leaf: its cost and weight come straight off its meta.
		if ( PostTypes::PART === $data['type'] ) {
			$node['unit_cost']   = $data['unit_cost'];
			$node['unit_weight'] = $data['weight'];
			$node['ext_cost']    = $data['unit_cost'] * $qty_total;
			$node['ext_weight']  = $data['weight'] * $qty_total;

			return $node;
		}

		// From here on it is an assembly. Labor is the assembly's own cost floor.
		$unit_cost   = $data['labor_cost'];
		$unit_weight = 0.0;

		if ( $depth >= $max_depth ) {
			$node['truncated']   = true;
			$node['unit_cost']   = $unit_cost;
			$node['unit_weight'] = $unit_weight;
			$node['ext_cost']    = $unit_cost * $qty_total;
			$node['ext_weight']  = 0.0;

			return $node;
		}

		$path[] = $post_id;

		foreach ( Meta::get_items( $post_id ) as $line ) {
			$child_id = $line['item_id'];

			// Cycle: this child is already one of our own ancestors. Record it as
			// a stub so the user can see exactly where the loop closes, and stop.
			if ( in_array( $child_id, $path, true ) ) {
				$node['children'][] = self::placeholder_node(
					$child_id,
					$line['qty'],
					$line['qty'] * $qty_total,
					$line['reference'],
					$line['note'],
					$depth + 1,
					'cycle'
				);
				continue;
			}

			$child = self::build_node(
				$child_id,
				$line['qty'],
				$line['qty'] * $qty_total,
				$line['reference'],
				$line['note'],
				$depth + 1,
				$max_depth,
				$path
			);

			$unit_cost   += $line['qty'] * (float) ( $child['unit_cost'] ?? 0.0 );
			$unit_weight += $line['qty'] * (float) ( $child['unit_weight'] ?? 0.0 );

			$node['children'][] = $child;
		}

		$node['unit_cost']   = $unit_cost;
		$node['unit_weight'] = $unit_weight;
		$node['ext_cost']    = $unit_cost * $qty_total;
		$node['ext_weight']  = $unit_weight * $qty_total;

		return $node;
	}

	/**
	 * Build a stub node for a missing item or a detected cycle.
	 *
	 * @param int    $post_id   Item ID.
	 * @param float  $qty_per   Quantity per parent.
	 * @param float  $qty_total Extended quantity.
	 * @param string $reference Reference designator.
	 * @param string $note      Line note.
	 * @param int    $depth     Depth.
	 * @param string $reason    Either 'missing' or 'cycle'.
	 *
	 * @return array<string, mixed>
	 */
	private static function placeholder_node(
		int $post_id,
		float $qty_per,
		float $qty_total,
		string $reference,
		string $note,
		int $depth,
		string $reason
	): array {
		$known = self::resolve( $post_id );

		return [
			'id'          => $post_id,
			'title'       => $known['title'] ?? sprintf( /* translators: %d: post ID. */ __( 'Missing item #%d', 'wp-bom' ), $post_id ),
			'type'        => $known['type'] ?? '',
			'part_number' => $known['part_number'] ?? '',
			'revision'    => $known['revision'] ?? '',
			'uom'         => $known['uom'] ?? '',
			'status'      => $known['status'] ?? '',
			'edit_link'   => $known['edit_link'] ?? '',
			'permalink'   => $known['permalink'] ?? '',
			'qty_per'     => $qty_per,
			'qty_total'   => $qty_total,
			'reference'   => $reference,
			'note'        => $note,
			'depth'       => $depth,
			'children'    => [],
			'cycle'       => 'cycle' === $reason,
			'missing'     => 'missing' === $reason,
			'truncated'   => false,
			'unit_cost'   => 0.0,
			'unit_weight' => 0.0,
			'ext_cost'    => 0.0,
			'ext_weight'  => 0.0,
		];
	}

	/**
	 * Flatten a tree into one summed row per distinct item.
	 *
	 * Quantities of the same part appearing in different branches are added
	 * together, which is what a purchasing or picking list actually needs.
	 *
	 * @param array<string, mixed> $node                Root node from tree().
	 * @param bool                 $include_assemblies  Include sub-assemblies as rows.
	 * @param bool                 $include_root        Include the root node itself.
	 *
	 * @return array<int, array<string, mixed>> Rows keyed numerically, sorted by part number.
	 */
	public static function flatten( array $node, bool $include_assemblies = false, bool $include_root = false ): array {
		$rows = [];

		self::collect( $node, $rows, $include_assemblies, $include_root ? 0 : -1 );

		uasort(
			$rows,
			static function ( array $a, array $b ): int {
				$by_number = strcasecmp( (string) $a['part_number'], (string) $b['part_number'] );

				return 0 !== $by_number ? $by_number : strcasecmp( (string) $a['title'], (string) $b['title'] );
			}
		);

		return array_values( $rows );
	}

	/**
	 * Accumulate flattened rows.
	 *
	 * @param array<string, mixed>              $node               Current node.
	 * @param array<int, array<string, mixed>>  $rows               Accumulator, by post ID.
	 * @param bool                              $include_assemblies Include assembly rows.
	 * @param int                               $skip_depth         Depth to skip, -1 skips nothing but the root.
	 */
	private static function collect( array $node, array &$rows, bool $include_assemblies, int $skip_depth ): void {
		$is_root     = 0 === (int) $node['depth'];
		$is_assembly = PostTypes::ASSEMBLY === $node['type'];
		$countable   = ! $node['cycle'] && ( ! $is_assembly || $include_assemblies );

		if ( $countable && ( ! $is_root || 0 === $skip_depth ) ) {
			$id = (int) $node['id'];

			if ( ! isset( $rows[ $id ] ) ) {
				$rows[ $id ] = [
					'id'          => $id,
					'title'       => $node['title'],
					'type'        => $node['type'],
					'part_number' => $node['part_number'],
					'revision'    => $node['revision'],
					'uom'         => $node['uom'],
					'status'      => $node['status'],
					'edit_link'   => $node['edit_link'],
					'permalink'   => $node['permalink'],
					'unit_cost'   => (float) $node['unit_cost'],
					'unit_weight' => (float) $node['unit_weight'],
					'qty_total'   => 0.0,
					'ext_cost'    => 0.0,
					'ext_weight'  => 0.0,
					'references'  => [],
					'missing'     => (bool) $node['missing'],
				];
			}

			$rows[ $id ]['qty_total']  += (float) $node['qty_total'];
			$rows[ $id ]['ext_cost']   += (float) $node['ext_cost'];
			$rows[ $id ]['ext_weight'] += (float) $node['ext_weight'];

			if ( '' !== $node['reference'] ) {
				$rows[ $id ]['references'][] = $node['reference'];
			}
		}

		foreach ( $node['children'] as $child ) {
			self::collect( $child, $rows, $include_assemblies, $skip_depth );
		}
	}

	/**
	 * Headline totals for a tree.
	 *
	 * @param array<string, mixed> $node Root node.
	 *
	 * @return array<string, mixed>
	 */
	public static function summary( array $node ): array {
		$parts = self::flatten( $node, false, false );
		$all   = self::flatten( $node, true, false );

		$has_cycle    = false;
		$has_missing  = false;
		$has_truncate = false;
		$lines        = 0;

		self::walk(
			$node,
			static function ( array $current ) use ( &$has_cycle, &$has_missing, &$has_truncate, &$lines ): void {
				if ( $current['depth'] > 0 ) {
					++$lines;
				}
				$has_cycle    = $has_cycle || (bool) $current['cycle'];
				$has_missing  = $has_missing || (bool) $current['missing'];
				$has_truncate = $has_truncate || (bool) $current['truncated'];
			}
		);

		$total_qty = 0.0;

		foreach ( $parts as $row ) {
			$total_qty += (float) $row['qty_total'];
		}

		return [
			'build_qty'      => (float) $node['qty_total'],
			'unit_cost'      => (float) $node['unit_cost'],
			'total_cost'     => (float) $node['ext_cost'],
			'unit_weight'    => (float) $node['unit_weight'],
			'total_weight'   => (float) $node['ext_weight'],
			'line_count'     => $lines,
			'unique_parts'   => count( $parts ),
			'unique_items'   => count( $all ),
			'total_part_qty' => $total_qty,
			'has_cycle'      => $has_cycle,
			'has_missing'    => $has_missing,
			'has_truncated'  => $has_truncate,
		];
	}

	/**
	 * Depth-first walk over every node.
	 *
	 * @param array<string, mixed> $node     Node to start at.
	 * @param callable             $callback Receives each node.
	 */
	public static function walk( array $node, callable $callback ): void {
		$callback( $node );

		foreach ( $node['children'] as $child ) {
			self::walk( $child, $callback );
		}
	}

	/**
	 * Load and memoise the fields the explosion needs from a post.
	 *
	 * @return array<string, mixed>|null
	 */
	private static function resolve( int $post_id ): ?array {
		if ( array_key_exists( $post_id, self::$post_cache ) ) {
			return self::$post_cache[ $post_id ];
		}

		$post = get_post( $post_id );

		if ( ! $post instanceof \WP_Post || ! in_array( $post->post_type, PostTypes::ITEM_TYPES, true ) ) {
			self::$post_cache[ $post_id ] = null;

			return null;
		}

		self::$post_cache[ $post_id ] = [
			'title'       => $post->post_title,
			'type'        => $post->post_type,
			'part_number' => Meta::get_string( $post_id, Meta::PART_NUMBER ),
			'revision'    => Meta::get_string( $post_id, Meta::REVISION ),
			'uom'         => Meta::get_string( $post_id, Meta::UOM ),
			'status'      => Meta::get_string( $post_id, Meta::STATUS ),
			'unit_cost'   => Meta::get_float( $post_id, Meta::UNIT_COST ),
			'weight'      => Meta::get_float( $post_id, Meta::WEIGHT ),
			'labor_cost'  => Meta::get_float( $post_id, Meta::LABOR_COST ),
			'edit_link'   => (string) get_edit_post_link( $post_id, 'raw' ),
			'permalink'   => (string) get_permalink( $post_id ),
		];

		return self::$post_cache[ $post_id ];
	}

	/**
	 * Drop the memo. Call after writing meta within the same request.
	 */
	public static function flush_cache(): void {
		self::$post_cache = [];
	}
}
