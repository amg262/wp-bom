<?php
/**
 * CSV export.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * Streams a flattened bill of materials as CSV via admin-post.php.
 */
final class Export {

	public const ACTION = 'wpbom_export_csv';

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_action( 'admin_post_' . self::ACTION, [ $this, 'download' ] );
	}

	/**
	 * Build a nonce-protected export URL.
	 *
	 * @param int   $post_id Assembly, part or BOM ID.
	 * @param float $qty     Build quantity.
	 */
	public static function url( int $post_id, float $qty = 1.0 ): string {
		if ( $post_id <= 0 || ! current_user_can( 'edit_post', $post_id ) ) {
			return '';
		}

		return wp_nonce_url(
			add_query_arg(
				[
					'action' => self::ACTION,
					'id'     => $post_id,
					'qty'    => $qty > 0 ? $qty : 1.0,
				],
				admin_url( 'admin-post.php' )
			),
			self::ACTION . '_' . $post_id
		);
	}

	/**
	 * Send the CSV.
	 */
	public function download(): void {
		$id  = isset( $_GET['id'] ) ? absint( wp_unslash( $_GET['id'] ) ) : 0;
		$qty = isset( $_GET['qty'] ) ? Meta::sanitize_float( wp_unslash( $_GET['qty'] ) ) : 1.0;

		if ( $id <= 0 ) {
			wp_die( esc_html__( 'Nothing to export.', 'wp-bom' ), '', [ 'response' => 400 ] );
		}

		check_admin_referer( self::ACTION . '_' . $id );

		if ( ! current_user_can( 'edit_post', $id ) ) {
			wp_die( esc_html__( 'You are not allowed to export this bill of materials.', 'wp-bom' ), '', [ 'response' => 403 ] );
		}

		$target = Rest::resolve_target( $id, $qty );
		$tree   = null === $target ? null : Explosion::tree( $target['id'], $target['qty'] );

		if ( null === $tree ) {
			wp_die( esc_html__( 'That item cannot be exploded.', 'wp-bom' ), '', [ 'response' => 404 ] );
		}

		$filename = sanitize_file_name( 'bom-' . $id . '-' . gmdate( 'Ymd-His' ) . '.csv' );

		nocache_headers();
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

		$out = fopen( 'php://output', 'w' );

		if ( false === $out ) {
			wp_die( esc_html__( 'Could not open the output stream.', 'wp-bom' ), '', [ 'response' => 500 ] );
		}

		// Excel needs a BOM to read UTF-8 correctly.
		fwrite( $out, "\xEF\xBB\xBF" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fwrite

		foreach ( self::build_rows( $tree ) as $row ) {
			self::put( $out, $row );
		}

		fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose

		exit;
	}

	/**
	 * Every CSV row for a tree: summary block, blank line, header, then parts.
	 *
	 * Split out from download() so the content can be asserted on without
	 * sending headers or exiting.
	 *
	 * @param array<string, mixed> $tree Root node from Explosion::tree().
	 *
	 * @return array<int, array<int, mixed>>
	 */
	public static function build_rows( array $tree ): array {
		$summary = Explosion::summary( $tree );

		$rows = [
			[ 'Assembly', $tree['title'] ],
			[ 'Build quantity', Render::qty( (float) $summary['build_qty'] ) ],
			[ 'Cost each', (float) $summary['unit_cost'] ],
			[ 'Total cost', (float) $summary['total_cost'] ],
			[ 'Generated', gmdate( 'Y-m-d H:i:s' ) . ' UTC' ],
			[],
			[ 'Part Number', 'Revision', 'Part', 'Type', 'UOM', 'Total Qty', 'Unit Cost', 'Extended Cost', 'Unit Weight', 'Extended Weight', 'References' ],
		];

		foreach ( Explosion::flatten( $tree, false, false ) as $part ) {
			$rows[] = [
				$part['part_number'],
				$part['revision'],
				$part['title'],
				$part['type'],
				$part['uom'],
				$part['qty_total'],
				$part['unit_cost'],
				$part['ext_cost'],
				$part['unit_weight'],
				$part['ext_weight'],
				implode( ' ', (array) $part['references'] ),
			];
		}

		return $rows;
	}

	/**
	 * Write one CSV row.
	 *
	 * The escape parameter is passed explicitly: PHP 8.4 deprecates relying on
	 * its default, and an empty escape is the RFC 4180 behaviour spreadsheets
	 * expect anyway.
	 *
	 * @param resource            $stream Output stream.
	 * @param array<int, mixed>   $row    Field values.
	 */
	private static function put( $stream, array $row ): void {
		fputcsv( $stream, $row, ',', '"', '' );
	}
}
