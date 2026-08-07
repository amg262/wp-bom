<?php
/**
 * HTML rendering for exploded bills of materials.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * Turns an Explosion tree into markup.
 *
 * Every method returns a string rather than echoing, so the same output can be
 * used by a meta box, a shortcode, or a REST response without duplication.
 */
final class Render {

	/**
	 * Format a number as currency using the configured symbol and precision.
	 */
	public static function money( float $value ): string {
		return Settings::currency_symbol() . number_format_i18n( $value, Settings::cost_decimals() );
	}

	/**
	 * Format a quantity, trimming pointless trailing zeros.
	 */
	public static function qty( float $value ): string {
		if ( abs( $value - round( $value ) ) < 0.00001 ) {
			return number_format_i18n( $value, 0 );
		}

		return rtrim( rtrim( number_format_i18n( $value, 4 ), '0' ), '.,' );
	}

	/**
	 * The admin meta-box view: totals, warnings, indented tree and flat list.
	 *
	 * @param array<string, mixed> $tree    Root node.
	 * @param int                  $root_id Assembly the export links should target.
	 */
	public static function admin_explosion( array $tree, int $root_id ): string {
		$summary = Explosion::summary( $tree );

		$html  = '<div class="wpbom-explosion">';
		$html .= self::warnings( $summary );
		$html .= self::totals( $summary );

		$html .= '<h4>' . esc_html__( 'Indented Structure', 'wp-bom' ) . '</h4>';
		$html .= self::tree_table( $tree, true );

		$html .= '<h4>' . esc_html__( 'Flat Part List', 'wp-bom' ) . '</h4>';
		$html .= self::flat_table( Explosion::flatten( $tree, false, false ), true );

		$export_url = Export::url( $root_id, (float) $summary['build_qty'] );

		if ( '' !== $export_url ) {
			$html .= '<p class="wpbom-actions"><a class="button button-secondary" href="' . esc_url( $export_url ) . '">' . esc_html__( 'Export CSV', 'wp-bom' ) . '</a></p>';
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Warning notices for cycles, missing items and depth truncation.
	 *
	 * @param array<string, mixed> $summary Summary from Explosion::summary().
	 */
	public static function warnings( array $summary ): string {
		$html = '';

		if ( ! empty( $summary['has_cycle'] ) ) {
			$html .= '<div class="notice notice-error inline"><p><strong>' . esc_html__( 'Circular reference detected.', 'wp-bom' ) . '</strong> ' . esc_html__( 'An assembly below contains itself, directly or through a sub-assembly. The loop is marked in the tree and excluded from totals.', 'wp-bom' ) . '</p></div>';
		}

		if ( ! empty( $summary['has_missing'] ) ) {
			$html .= '<div class="notice notice-warning inline"><p>' . esc_html__( 'Some line items point at posts that no longer exist. They are shown as missing and counted as zero cost.', 'wp-bom' ) . '</p></div>';
		}

		if ( ! empty( $summary['has_truncated'] ) ) {
			$html .= '<div class="notice notice-warning inline"><p>' . esc_html__( 'The structure is deeper than the configured maximum depth and was truncated. Raise the limit in WP BOM settings to see the rest.', 'wp-bom' ) . '</p></div>';
		}

		return $html;
	}

	/**
	 * The totals strip.
	 *
	 * @param array<string, mixed> $summary Summary from Explosion::summary().
	 */
	public static function totals( array $summary ): string {
		$cells = [
			__( 'Build Qty', 'wp-bom' )     => self::qty( (float) $summary['build_qty'] ),
			__( 'Cost Each', 'wp-bom' )     => self::money( (float) $summary['unit_cost'] ),
			__( 'Total Cost', 'wp-bom' )    => self::money( (float) $summary['total_cost'] ),
			__( 'Weight Each', 'wp-bom' )   => self::qty( (float) $summary['unit_weight'] ),
			__( 'Total Weight', 'wp-bom' )  => self::qty( (float) $summary['total_weight'] ),
			__( 'Lines', 'wp-bom' )         => (string) (int) $summary['line_count'],
			__( 'Unique Parts', 'wp-bom' )  => (string) (int) $summary['unique_parts'],
		];

		$html = '<ul class="wpbom-totals">';

		foreach ( $cells as $label => $value ) {
			$html .= '<li><span class="wpbom-totals-label">' . esc_html( (string) $label ) . '</span><span class="wpbom-totals-value">' . esc_html( $value ) . '</span></li>';
		}

		return $html . '</ul>';
	}

	/**
	 * Indented tree table.
	 *
	 * @param array<string, mixed> $tree  Root node.
	 * @param bool                 $admin Link to edit screens instead of permalinks.
	 */
	public static function tree_table( array $tree, bool $admin = false ): string {
		$html  = '<table class="widefat striped wpbom-table wpbom-tree-table"><thead><tr>';
		$html .= '<th>' . esc_html__( 'Item', 'wp-bom' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Number', 'wp-bom' ) . '</th>';
		$html .= '<th class="wpbom-num">' . esc_html__( 'Qty / Parent', 'wp-bom' ) . '</th>';
		$html .= '<th class="wpbom-num">' . esc_html__( 'Ext. Qty', 'wp-bom' ) . '</th>';
		$html .= '<th class="wpbom-num">' . esc_html__( 'Unit Cost', 'wp-bom' ) . '</th>';
		$html .= '<th class="wpbom-num">' . esc_html__( 'Ext. Cost', 'wp-bom' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Reference', 'wp-bom' ) . '</th>';
		$html .= '</tr></thead><tbody>';

		$rows = '';

		Explosion::walk(
			$tree,
			static function ( array $node ) use ( &$rows, $admin ): void {
				$rows .= self::tree_row( $node, $admin );
			}
		);

		return $html . $rows . '</tbody></table>';
	}

	/**
	 * One row of the indented tree.
	 *
	 * @param array<string, mixed> $node  Node.
	 * @param bool                 $admin Link to edit screens.
	 */
	private static function tree_row( array $node, bool $admin ): string {
		$depth   = (int) $node['depth'];
		$classes = [ 'wpbom-depth-' . min( $depth, 9 ) ];

		if ( $node['cycle'] ) {
			$classes[] = 'wpbom-row-cycle';
		}

		if ( $node['missing'] ) {
			$classes[] = 'wpbom-row-missing';
		}

		if ( PostTypes::ASSEMBLY === $node['type'] ) {
			$classes[] = 'wpbom-row-assembly';
		}

		$indent = str_repeat( '<span class="wpbom-indent"></span>', $depth );
		$link   = $admin ? (string) $node['edit_link'] : (string) $node['permalink'];
		$title  = esc_html( (string) $node['title'] );

		$label = ( '' !== $link && ! $node['missing'] )
			? '<a href="' . esc_url( $link ) . '">' . $title . '</a>'
			: $title;

		if ( $node['cycle'] ) {
			$label .= ' <span class="wpbom-flag wpbom-flag-error">' . esc_html__( 'circular', 'wp-bom' ) . '</span>';
		}

		if ( $node['missing'] ) {
			$label .= ' <span class="wpbom-flag wpbom-flag-error">' . esc_html__( 'missing', 'wp-bom' ) . '</span>';
		}

		if ( $node['truncated'] ) {
			$label .= ' <span class="wpbom-flag">' . esc_html__( 'truncated', 'wp-bom' ) . '</span>';
		}

		if ( PostTypes::ASSEMBLY === $node['type'] ) {
			$label .= ' <span class="wpbom-flag wpbom-flag-type">' . esc_html__( 'assembly', 'wp-bom' ) . '</span>';
		}

		$html  = '<tr class="' . esc_attr( implode( ' ', $classes ) ) . '">';
		$html .= '<td class="wpbom-item-cell">' . $indent . $label . '</td>';
		$html .= '<td>' . esc_html( (string) $node['part_number'] ) . '</td>';
		$html .= '<td class="wpbom-num">' . esc_html( self::qty( (float) $node['qty_per'] ) ) . '</td>';
		$html .= '<td class="wpbom-num">' . esc_html( self::qty( (float) $node['qty_total'] ) ) . ' ' . esc_html( (string) $node['uom'] ) . '</td>';
		$html .= '<td class="wpbom-num">' . esc_html( self::money( (float) $node['unit_cost'] ) ) . '</td>';
		$html .= '<td class="wpbom-num">' . esc_html( self::money( (float) $node['ext_cost'] ) ) . '</td>';
		$html .= '<td>' . esc_html( (string) $node['reference'] ) . '</td>';
		$html .= '</tr>';

		return $html;
	}

	/**
	 * Flat, summed part list.
	 *
	 * @param array<int, array<string, mixed>> $rows  Rows from Explosion::flatten().
	 * @param bool                             $admin Link to edit screens.
	 */
	public static function flat_table( array $rows, bool $admin = false ): string {
		if ( empty( $rows ) ) {
			return '<p>' . esc_html__( 'No parts in this bill of materials yet.', 'wp-bom' ) . '</p>';
		}

		$html  = '<table class="widefat striped wpbom-table wpbom-flat-table"><thead><tr>';
		$html .= '<th>' . esc_html__( 'Number', 'wp-bom' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Part', 'wp-bom' ) . '</th>';
		$html .= '<th class="wpbom-num">' . esc_html__( 'Total Qty', 'wp-bom' ) . '</th>';
		$html .= '<th class="wpbom-num">' . esc_html__( 'Unit Cost', 'wp-bom' ) . '</th>';
		$html .= '<th class="wpbom-num">' . esc_html__( 'Ext. Cost', 'wp-bom' ) . '</th>';
		$html .= '<th>' . esc_html__( 'References', 'wp-bom' ) . '</th>';
		$html .= '</tr></thead><tbody>';

		$total = 0.0;

		foreach ( $rows as $row ) {
			$link  = $admin ? (string) $row['edit_link'] : (string) $row['permalink'];
			$title = esc_html( (string) $row['title'] );

			$label = ( '' !== $link && empty( $row['missing'] ) )
				? '<a href="' . esc_url( $link ) . '">' . $title . '</a>'
				: $title;

			$total += (float) $row['ext_cost'];

			$html .= '<tr>';
			$html .= '<td>' . esc_html( (string) $row['part_number'] ) . '</td>';
			$html .= '<td>' . $label . '</td>';
			$html .= '<td class="wpbom-num">' . esc_html( self::qty( (float) $row['qty_total'] ) ) . ' ' . esc_html( (string) $row['uom'] ) . '</td>';
			$html .= '<td class="wpbom-num">' . esc_html( self::money( (float) $row['unit_cost'] ) ) . '</td>';
			$html .= '<td class="wpbom-num">' . esc_html( self::money( (float) $row['ext_cost'] ) ) . '</td>';
			$html .= '<td>' . esc_html( implode( ', ', array_slice( (array) $row['references'], 0, 12 ) ) ) . '</td>';
			$html .= '</tr>';
		}

		$html .= '</tbody><tfoot><tr>';
		$html .= '<th colspan="4" class="wpbom-num">' . esc_html__( 'Material total', 'wp-bom' ) . '</th>';
		$html .= '<th class="wpbom-num">' . esc_html( self::money( $total ) ) . '</th>';
		$html .= '<th></th>';
		$html .= '</tr></tfoot></table>';

		return $html;
	}
}
