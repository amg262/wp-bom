<?php
/**
 * Native meta boxes. This is the ACF replacement.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * Every editing surface the plugin adds to the post editor.
 *
 * All fields are plain HTML inputs saved through a single nonce-guarded
 * save_post handler. No third-party field framework is involved.
 */
final class MetaBoxes {

	private const NONCE_ACTION = 'wpbom_save_meta';
	private const NONCE_FIELD  = 'wpbom_nonce';

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save' ], 10, 2 );

		// The classic editor is required for these boxes to be usable; the block
		// editor would hide them behind the panel sidebar and drop the custom UI.
		add_filter( 'use_block_editor_for_post_type', [ $this, 'force_classic_editor' ], 10, 2 );
	}

	/**
	 * Keep the classic editor for BOM post types.
	 *
	 * @param bool   $use       Current decision.
	 * @param string $post_type Post type slug.
	 */
	public function force_classic_editor( bool $use, string $post_type ): bool {
		return in_array( $post_type, PostTypes::all(), true ) ? false : $use;
	}

	/**
	 * Register every meta box.
	 */
	public function add_meta_boxes(): void {
		add_meta_box(
			'wpbom-part-details',
			__( 'Part Details', 'wp-bom' ),
			[ $this, 'render_part_details' ],
			PostTypes::PART,
			'normal',
			'high'
		);

		add_meta_box(
			'wpbom-assembly-details',
			__( 'Assembly Details', 'wp-bom' ),
			[ $this, 'render_assembly_details' ],
			PostTypes::ASSEMBLY,
			'normal',
			'high'
		);

		add_meta_box(
			'wpbom-line-items',
			__( 'Line Items', 'wp-bom' ),
			[ $this, 'render_line_items' ],
			PostTypes::ASSEMBLY,
			'normal',
			'high'
		);

		add_meta_box(
			'wpbom-explosion',
			__( 'Exploded Bill of Materials', 'wp-bom' ),
			[ $this, 'render_explosion' ],
			PostTypes::ASSEMBLY,
			'normal',
			'default'
		);

		add_meta_box(
			'wpbom-bom-source',
			__( 'BOM Source', 'wp-bom' ),
			[ $this, 'render_bom_source' ],
			PostTypes::BOM,
			'normal',
			'high'
		);

		add_meta_box(
			'wpbom-bom-explosion',
			__( 'Exploded Bill of Materials', 'wp-bom' ),
			[ $this, 'render_bom_explosion' ],
			PostTypes::BOM,
			'normal',
			'default'
		);

		foreach ( PostTypes::ITEM_TYPES as $type ) {
			add_meta_box(
				'wpbom-where-used',
				__( 'Where Used', 'wp-bom' ),
				[ $this, 'render_where_used' ],
				$type,
				'side',
				'default'
			);
		}
	}

	/**
	 * Part detail fields.
	 *
	 * @param \WP_Post $post Current post.
	 */
	public function render_part_details( \WP_Post $post ): void {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD );

		$currency = Settings::currency_symbol();

		echo '<div class="wpbom-grid">';

		$this->text_field( $post->ID, Meta::PART_NUMBER, __( 'Part Number', 'wp-bom' ), __( 'Your internal identifier, e.g. BRK-1042.', 'wp-bom' ) );
		$this->text_field( $post->ID, Meta::REVISION, __( 'Revision', 'wp-bom' ), __( 'Drawing or spec revision, e.g. C.', 'wp-bom' ) );
		$this->select_field( $post->ID, Meta::UOM, __( 'Unit of Measure', 'wp-bom' ), Meta::units(), 'ea' );
		$this->select_field( $post->ID, Meta::STATUS, __( 'Status', 'wp-bom' ), Meta::statuses(), 'active' );
		$this->number_field( $post->ID, Meta::UNIT_COST, __( 'Unit Cost', 'wp-bom' ), $currency, '0.0001' );
		$this->number_field( $post->ID, Meta::WEIGHT, __( 'Unit Weight', 'wp-bom' ), '', '0.0001' );
		$this->number_field( $post->ID, Meta::STOCK_QTY, __( 'Quantity On Hand', 'wp-bom' ), '', '0.001' );
		$this->number_field( $post->ID, Meta::REORDER_QTY, __( 'Reorder Point', 'wp-bom' ), '', '0.001' );
		$this->number_field( $post->ID, Meta::LEAD_TIME, __( 'Lead Time (days)', 'wp-bom' ), '', '1' );
		$this->text_field( $post->ID, Meta::MPN, __( 'Manufacturer Part No.', 'wp-bom' ), __( 'The vendor or manufacturer number.', 'wp-bom' ) );

		echo '</div>';

		$this->textarea_field( $post->ID, Meta::NOTES, __( 'Notes', 'wp-bom' ) );
	}

	/**
	 * Assembly header fields.
	 *
	 * @param \WP_Post $post Current post.
	 */
	public function render_assembly_details( \WP_Post $post ): void {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD );

		echo '<div class="wpbom-grid">';

		$this->text_field( $post->ID, Meta::PART_NUMBER, __( 'Assembly Number', 'wp-bom' ), __( 'Your internal identifier, e.g. ASM-200.', 'wp-bom' ) );
		$this->text_field( $post->ID, Meta::REVISION, __( 'Revision', 'wp-bom' ), __( 'Drawing or spec revision.', 'wp-bom' ) );
		$this->select_field( $post->ID, Meta::UOM, __( 'Unit of Measure', 'wp-bom' ), Meta::units(), 'ea' );
		$this->select_field( $post->ID, Meta::STATUS, __( 'Status', 'wp-bom' ), Meta::statuses(), 'active' );
		$this->number_field( $post->ID, Meta::LABOR_COST, __( 'Labor / Overhead Cost', 'wp-bom' ), Settings::currency_symbol(), '0.0001' );

		echo '</div>';

		$this->textarea_field( $post->ID, Meta::NOTES, __( 'Notes', 'wp-bom' ) );
	}

	/**
	 * The repeatable line-item table. This replaces the ACF repeater.
	 *
	 * @param \WP_Post $post Current post.
	 */
	public function render_line_items( \WP_Post $post ): void {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD );

		$items   = Meta::get_items( $post->ID );
		$choices = $this->item_choices( $post->ID );

		echo '<div class="wpbom-items" data-wpbom-items>';

		echo '<p class="wpbom-help">' . esc_html__( 'Add the parts and sub-assemblies that make up this assembly. Sub-assemblies are expanded recursively in the exploded view below.', 'wp-bom' ) . '</p>';

		echo '<table class="widefat wpbom-items-table"><thead><tr>';
		echo '<th class="wpbom-col-handle"><span class="screen-reader-text">' . esc_html__( 'Order', 'wp-bom' ) . '</span></th>';
		echo '<th class="wpbom-col-item">' . esc_html__( 'Item', 'wp-bom' ) . '</th>';
		echo '<th class="wpbom-col-qty">' . esc_html__( 'Qty', 'wp-bom' ) . '</th>';
		echo '<th class="wpbom-col-ref">' . esc_html__( 'Reference', 'wp-bom' ) . '</th>';
		echo '<th class="wpbom-col-note">' . esc_html__( 'Note', 'wp-bom' ) . '</th>';
		echo '<th class="wpbom-col-actions"><span class="screen-reader-text">' . esc_html__( 'Actions', 'wp-bom' ) . '</span></th>';
		echo '</tr></thead>';

		echo '<tbody data-wpbom-rows>';

		if ( empty( $items ) ) {
			echo '<tr data-wpbom-empty><td colspan="6" class="wpbom-empty">' . esc_html__( 'No line items yet.', 'wp-bom' ) . '</td></tr>';
		}

		foreach ( $items as $index => $item ) {
			$this->render_item_row( (string) $index, $item, $choices );
		}

		echo '</tbody></table>';

		echo '<p class="wpbom-actions"><button type="button" class="button button-secondary" data-wpbom-add>' . esc_html__( '+ Add Line Item', 'wp-bom' ) . '</button></p>';

		// Row template consumed by assets/js/wpbom-admin.js when adding a row.
		echo '<script type="text/html" data-wpbom-template>';
		$this->render_item_row( '__index__', [ 'item_id' => 0, 'qty' => 1.0, 'reference' => '', 'note' => '' ], $choices );
		echo '</script>';

		echo '</div>';
	}

	/**
	 * One editable line-item row.
	 *
	 * @param string                                                        $index   Row index or the template placeholder.
	 * @param array{item_id:int, qty:float, reference:string, note:string}  $item    Row values.
	 * @param array<string, array<int, array{id:int,label:string}>>          $choices Grouped item options.
	 */
	private function render_item_row( string $index, array $item, array $choices ): void {
		$name = 'wpbom_items[' . $index . ']';

		echo '<tr class="wpbom-item-row" data-wpbom-row>';

		echo '<td class="wpbom-col-handle"><span class="wpbom-handle dashicons dashicons-menu" aria-hidden="true"></span></td>';

		echo '<td class="wpbom-col-item">';
		echo '<select name="' . esc_attr( $name . '[item_id]' ) . '" class="wpbom-item-select" required>';
		echo '<option value="">' . esc_html__( '— Select a part or assembly —', 'wp-bom' ) . '</option>';

		foreach ( $choices as $group_label => $options ) {
			echo '<optgroup label="' . esc_attr( $group_label ) . '">';

			foreach ( $options as $option ) {
				printf(
					'<option value="%d"%s>%s</option>',
					(int) $option['id'],
					selected( $item['item_id'], $option['id'], false ),
					esc_html( $option['label'] )
				);
			}

			echo '</optgroup>';
		}

		// If the saved item is no longer selectable (trashed, or beyond the
		// choice cap) keep it in the list so saving does not silently drop it.
		if ( $item['item_id'] > 0 && ! $this->in_choices( $item['item_id'], $choices ) ) {
			printf(
				'<option value="%d" selected>%s</option>',
				(int) $item['item_id'],
				esc_html( $this->fallback_label( $item['item_id'] ) )
			);
		}

		echo '</select>';
		echo '</td>';

		echo '<td class="wpbom-col-qty"><input type="number" step="0.0001" min="0" name="' . esc_attr( $name . '[qty]' ) . '" value="' . esc_attr( (string) $item['qty'] ) . '" class="small-text" /></td>';
		echo '<td class="wpbom-col-ref"><input type="text" name="' . esc_attr( $name . '[reference]' ) . '" value="' . esc_attr( $item['reference'] ) . '" class="regular-text" placeholder="' . esc_attr__( 'R1, R2', 'wp-bom' ) . '" /></td>';
		echo '<td class="wpbom-col-note"><input type="text" name="' . esc_attr( $name . '[note]' ) . '" value="' . esc_attr( $item['note'] ) . '" class="regular-text" /></td>';
		echo '<td class="wpbom-col-actions"><button type="button" class="button-link wpbom-remove" data-wpbom-remove>' . esc_html__( 'Remove', 'wp-bom' ) . '</button></td>';

		echo '</tr>';
	}

	/**
	 * Selectable items, grouped by post type.
	 *
	 * @param int $exclude_id Post to leave out, normally the assembly being edited.
	 *
	 * @return array<string, array<int, array{id:int,label:string}>>
	 */
	private function item_choices( int $exclude_id ): array {
		/**
		 * Filters how many items are offered in the line-item dropdown.
		 *
		 * @param int $limit Maximum options per post type.
		 */
		$limit = (int) apply_filters( 'wpbom_item_choices_limit', 1000 );

		$groups = [];

		foreach ( PostTypes::ITEM_TYPES as $type ) {
			$posts = get_posts(
				[
					'post_type'        => $type,
					'post_status'      => [ 'publish', 'draft', 'pending', 'private' ],
					'posts_per_page'   => $limit,
					'orderby'          => 'title',
					'order'            => 'ASC',
					'exclude'          => [ $exclude_id ],
					'no_found_rows'    => true,
					'suppress_filters' => false,
				]
			);

			$label   = PostTypes::PART === $type ? __( 'Parts', 'wp-bom' ) : __( 'Assemblies', 'wp-bom' );
			$options = [];

			foreach ( $posts as $item ) {
				$options[] = [
					'id'    => $item->ID,
					'label' => $this->choice_label( $item ),
				];
			}

			if ( ! empty( $options ) ) {
				$groups[ $label ] = $options;
			}
		}

		return $groups;
	}

	/**
	 * Display label for one selectable item.
	 */
	private function choice_label( \WP_Post $post ): string {
		$number = Meta::get_string( $post->ID, Meta::PART_NUMBER );
		$title  = '' !== $post->post_title ? $post->post_title : __( '(no title)', 'wp-bom' );

		return '' !== $number ? $number . ' — ' . $title : $title;
	}

	/**
	 * Whether an ID appears in the grouped choices.
	 *
	 * @param array<string, array<int, array{id:int,label:string}>> $choices Grouped options.
	 */
	private function in_choices( int $id, array $choices ): bool {
		foreach ( $choices as $options ) {
			foreach ( $options as $option ) {
				if ( (int) $option['id'] === $id ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Label for an item that is not in the choice list any more.
	 */
	private function fallback_label( int $id ): string {
		$post = get_post( $id );

		if ( ! $post instanceof \WP_Post ) {
			/* translators: %d: post ID. */
			return sprintf( __( 'Missing item #%d', 'wp-bom' ), $id );
		}

		/* translators: %s: item title. */
		return sprintf( __( '%s (unavailable)', 'wp-bom' ), $this->choice_label( $post ) );
	}

	/**
	 * Read-only exploded view for an assembly.
	 *
	 * @param \WP_Post $post Current post.
	 */
	public function render_explosion( \WP_Post $post ): void {
		$tree = Explosion::tree( $post->ID, 1.0 );

		if ( null === $tree ) {
			echo '<p>' . esc_html__( 'Save this assembly to see its exploded bill of materials.', 'wp-bom' ) . '</p>';

			return;
		}

		echo Render::admin_explosion( $tree, $post->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in Render.
	}

	/**
	 * Root assembly picker for a BOM document.
	 *
	 * @param \WP_Post $post Current post.
	 */
	public function render_bom_source( \WP_Post $post ): void {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD );

		$root_id   = (int) get_post_meta( $post->ID, Meta::ROOT_ID, true );
		$build_qty = Meta::get_float( $post->ID, Meta::BUILD_QTY );
		$build_qty = $build_qty > 0 ? $build_qty : 1.0;

		$assemblies = get_posts(
			[
				'post_type'        => PostTypes::ASSEMBLY,
				'post_status'      => [ 'publish', 'draft', 'pending', 'private' ],
				'posts_per_page'   => (int) apply_filters( 'wpbom_item_choices_limit', 1000 ),
				'orderby'          => 'title',
				'order'            => 'ASC',
				'no_found_rows'    => true,
				'suppress_filters' => false,
			]
		);

		echo '<table class="form-table" role="presentation"><tbody>';

		echo '<tr><th scope="row"><label for="wpbom-root-id">' . esc_html__( 'Assembly', 'wp-bom' ) . '</label></th><td>';
		echo '<select id="wpbom-root-id" name="wpbom_root_id">';
		echo '<option value="0">' . esc_html__( '— Select an assembly —', 'wp-bom' ) . '</option>';

		foreach ( $assemblies as $assembly ) {
			printf(
				'<option value="%d"%s>%s</option>',
				(int) $assembly->ID,
				selected( $root_id, $assembly->ID, false ),
				esc_html( $this->choice_label( $assembly ) )
			);
		}

		echo '</select>';
		echo '<p class="description">' . esc_html__( 'The top-level assembly this bill of materials is built from.', 'wp-bom' ) . '</p>';
		echo '</td></tr>';

		echo '<tr><th scope="row"><label for="wpbom-build-qty">' . esc_html__( 'Build Quantity', 'wp-bom' ) . '</label></th><td>';
		echo '<input type="number" step="0.0001" min="0" id="wpbom-build-qty" name="wpbom_build_qty" class="small-text" value="' . esc_attr( (string) $build_qty ) . '" />';
		echo '<p class="description">' . esc_html__( 'All quantities and costs below are extended by this number.', 'wp-bom' ) . '</p>';
		echo '</td></tr>';

		echo '</tbody></table>';
	}

	/**
	 * Read-only exploded view for a BOM document.
	 *
	 * @param \WP_Post $post Current post.
	 */
	public function render_bom_explosion( \WP_Post $post ): void {
		$root_id = (int) get_post_meta( $post->ID, Meta::ROOT_ID, true );

		if ( $root_id <= 0 ) {
			echo '<p>' . esc_html__( 'Choose an assembly above, then save, to build the bill of materials.', 'wp-bom' ) . '</p>';

			return;
		}

		$build_qty = Meta::get_float( $post->ID, Meta::BUILD_QTY );
		$tree      = Explosion::tree( $root_id, $build_qty > 0 ? $build_qty : 1.0 );

		if ( null === $tree ) {
			echo '<p>' . esc_html__( 'That assembly no longer exists.', 'wp-bom' ) . '</p>';

			return;
		}

		echo Render::admin_explosion( $tree, $root_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in Render.
	}

	/**
	 * Assemblies that consume the current item.
	 *
	 * @param \WP_Post $post Current post.
	 */
	public function render_where_used( \WP_Post $post ): void {
		$parents = Meta::where_used( $post->ID );

		if ( empty( $parents ) ) {
			echo '<p>' . esc_html__( 'Not used in any assembly yet.', 'wp-bom' ) . '</p>';

			return;
		}

		echo '<ul class="wpbom-where-used">';

		foreach ( $parents as $parent_id ) {
			$edit = get_edit_post_link( $parent_id );

			printf(
				'<li><a href="%s">%s</a></li>',
				esc_url( (string) $edit ),
				esc_html( get_the_title( $parent_id ) )
			);
		}

		echo '</ul>';
	}

	/**
	 * Persist every field this class renders.
	 *
	 * @param int      $post_id Post being saved.
	 * @param \WP_Post $post    Post object.
	 */
	public function save( int $post_id, \WP_Post $post ): void {
		if ( ! in_array( $post->post_type, PostTypes::all(), true ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
			return;
		}

		$nonce = isset( $_POST[ self::NONCE_FIELD ] )
			? sanitize_text_field( wp_unslash( $_POST[ self::NONCE_FIELD ] ) )
			: '';

		if ( '' === $nonce || ! wp_verify_nonce( $nonce, self::NONCE_ACTION ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( in_array( $post->post_type, PostTypes::ITEM_TYPES, true ) ) {
			$this->save_scalar( $post_id, Meta::PART_NUMBER, 'text' );
			$this->save_scalar( $post_id, Meta::REVISION, 'text' );
			$this->save_scalar( $post_id, Meta::UOM, 'choice', array_keys( Meta::units() ) );
			$this->save_scalar( $post_id, Meta::STATUS, 'choice', array_keys( Meta::statuses() ) );
			$this->save_scalar( $post_id, Meta::NOTES, 'html' );
		}

		if ( PostTypes::PART === $post->post_type ) {
			foreach ( [ Meta::UNIT_COST, Meta::WEIGHT, Meta::STOCK_QTY, Meta::REORDER_QTY ] as $key ) {
				$this->save_scalar( $post_id, $key, 'float' );
			}

			$this->save_scalar( $post_id, Meta::LEAD_TIME, 'int' );
			$this->save_scalar( $post_id, Meta::MPN, 'text' );
		}

		if ( PostTypes::ASSEMBLY === $post->post_type ) {
			$this->save_scalar( $post_id, Meta::LABOR_COST, 'float' );

			// An absent key means the box was not rendered (quick edit, REST);
			// only an explicitly submitted empty array clears the items.
			if ( isset( $_POST['wpbom_items'] ) && is_array( $_POST['wpbom_items'] ) ) {
				$raw = wp_unslash( $_POST['wpbom_items'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitised field by field in Meta::set_items().
				Meta::set_items( $post_id, is_array( $raw ) ? array_values( $raw ) : [] );
			}
		}

		if ( PostTypes::BOM === $post->post_type ) {
			if ( isset( $_POST['wpbom_root_id'] ) ) {
				$root_id = absint( wp_unslash( $_POST['wpbom_root_id'] ) );

				if ( $root_id > 0 && PostTypes::ASSEMBLY !== get_post_type( $root_id ) ) {
					$root_id = 0;
				}

				update_post_meta( $post_id, Meta::ROOT_ID, $root_id );
			}

			if ( isset( $_POST['wpbom_build_qty'] ) ) {
				$qty = Meta::sanitize_float( wp_unslash( $_POST['wpbom_build_qty'] ) );
				update_post_meta( $post_id, Meta::BUILD_QTY, $qty > 0 ? $qty : 1.0 );
			}
		}

		Explosion::flush_cache();
	}

	/**
	 * Save one scalar field from $_POST.
	 *
	 * The POST key is the meta key with its leading underscore stripped, so
	 * _wpbom_unit_cost arrives as wpbom_unit_cost.
	 *
	 * @param int      $post_id  Post ID.
	 * @param string   $meta_key Meta key.
	 * @param string   $type     One of text, html, float, int, choice.
	 * @param string[] $allowed  Allowed values when $type is 'choice'.
	 */
	private function save_scalar( int $post_id, string $meta_key, string $type, array $allowed = [] ): void {
		$field = ltrim( $meta_key, '_' );

		if ( ! isset( $_POST[ $field ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Verified in save().
			return;
		}

		$raw = wp_unslash( $_POST[ $field ] ); // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitised below.

		if ( is_array( $raw ) ) {
			return;
		}

		$value = match ( $type ) {
			'float'  => Meta::sanitize_float( $raw ),
			'int'    => absint( $raw ),
			'html'   => wp_kses_post( (string) $raw ),
			'choice' => in_array( (string) $raw, $allowed, true ) ? (string) $raw : ( $allowed[0] ?? '' ),
			default  => sanitize_text_field( (string) $raw ),
		};

		update_post_meta( $post_id, $meta_key, $value );
	}

	/**
	 * Render a text input.
	 */
	private function text_field( int $post_id, string $meta_key, string $label, string $description = '' ): void {
		$field = ltrim( $meta_key, '_' );
		$value = Meta::get_string( $post_id, $meta_key );

		echo '<div class="wpbom-field">';
		echo '<label for="' . esc_attr( $field ) . '">' . esc_html( $label ) . '</label>';
		echo '<input type="text" id="' . esc_attr( $field ) . '" name="' . esc_attr( $field ) . '" value="' . esc_attr( $value ) . '" class="widefat" />';

		if ( '' !== $description ) {
			echo '<p class="description">' . esc_html( $description ) . '</p>';
		}

		echo '</div>';
	}

	/**
	 * Render a number input.
	 */
	private function number_field( int $post_id, string $meta_key, string $label, string $prefix = '', string $step = '0.01' ): void {
		$field = ltrim( $meta_key, '_' );
		$value = Meta::get_float( $post_id, $meta_key );

		echo '<div class="wpbom-field">';
		echo '<label for="' . esc_attr( $field ) . '">' . esc_html( $label ) . '</label>';
		echo '<span class="wpbom-input-group">';

		if ( '' !== $prefix ) {
			echo '<span class="wpbom-prefix">' . esc_html( $prefix ) . '</span>';
		}

		echo '<input type="number" step="' . esc_attr( $step ) . '" min="0" id="' . esc_attr( $field ) . '" name="' . esc_attr( $field ) . '" value="' . esc_attr( (string) $value ) . '" class="widefat" />';
		echo '</span></div>';
	}

	/**
	 * Render a select.
	 *
	 * @param array<string, string> $options Value => label.
	 */
	private function select_field( int $post_id, string $meta_key, string $label, array $options, string $default = '' ): void {
		$field = ltrim( $meta_key, '_' );
		$value = Meta::get_string( $post_id, $meta_key );

		if ( '' === $value ) {
			$value = $default;
		}

		echo '<div class="wpbom-field">';
		echo '<label for="' . esc_attr( $field ) . '">' . esc_html( $label ) . '</label>';
		echo '<select id="' . esc_attr( $field ) . '" name="' . esc_attr( $field ) . '" class="widefat">';

		foreach ( $options as $option_value => $option_label ) {
			printf(
				'<option value="%s"%s>%s</option>',
				esc_attr( (string) $option_value ),
				selected( $value, $option_value, false ),
				esc_html( $option_label )
			);
		}

		echo '</select></div>';
	}

	/**
	 * Render a textarea.
	 */
	private function textarea_field( int $post_id, string $meta_key, string $label ): void {
		$field = ltrim( $meta_key, '_' );
		$value = Meta::get_string( $post_id, $meta_key );

		echo '<div class="wpbom-field wpbom-field-wide">';
		echo '<label for="' . esc_attr( $field ) . '">' . esc_html( $label ) . '</label>';
		echo '<textarea id="' . esc_attr( $field ) . '" name="' . esc_attr( $field ) . '" rows="4" class="widefat">' . esc_textarea( $value ) . '</textarea>';
		echo '</div>';
	}
}
