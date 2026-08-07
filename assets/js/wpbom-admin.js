/**
 * WP BOM line-item repeater.
 *
 * Vanilla JS, no build step, no jQuery. The markup is fully rendered by PHP;
 * this only adds/removes rows, reindexes field names, and reorders by drag.
 * With JS disabled every existing row still saves correctly.
 */
( function () {
	'use strict';

	var l10n = window.wpBomL10n || {};

	/**
	 * Rewrite wpbom_items[<n>][field] so indexes stay contiguous after edits.
	 *
	 * @param {HTMLElement} container Wrapper carrying data-wpbom-items.
	 */
	function reindex( container ) {
		var rows = container.querySelectorAll( '[data-wpbom-row]' );

		Array.prototype.forEach.call( rows, function ( row, index ) {
			var fields = row.querySelectorAll( '[name^="wpbom_items["]' );

			Array.prototype.forEach.call( fields, function ( field ) {
				field.name = field.name.replace(
					/wpbom_items\[[^\]]*\]/,
					'wpbom_items[' + index + ']'
				);
			} );
		} );
	}

	/**
	 * Show or hide the "no line items yet" placeholder row.
	 *
	 * @param {HTMLElement} container Wrapper carrying data-wpbom-items.
	 */
	function toggleEmpty( container ) {
		var body = container.querySelector( '[data-wpbom-rows]' );
		if ( ! body ) {
			return;
		}

		var hasRows = body.querySelector( '[data-wpbom-row]' ) !== null;
		var empty = body.querySelector( '[data-wpbom-empty]' );

		if ( ! hasRows && ! empty ) {
			var tr = document.createElement( 'tr' );
			tr.setAttribute( 'data-wpbom-empty', '' );
			tr.innerHTML =
				'<td colspan="6" class="wpbom-empty">' +
				( l10n.emptyRow || 'No line items yet.' ) +
				'</td>';
			body.appendChild( tr );
		} else if ( hasRows && empty ) {
			empty.parentNode.removeChild( empty );
		}
	}

	/**
	 * Append a fresh row built from the PHP-rendered template.
	 *
	 * @param {HTMLElement} container Wrapper carrying data-wpbom-items.
	 */
	function addRow( container ) {
		var template = container.querySelector( '[data-wpbom-template]' );
		var body = container.querySelector( '[data-wpbom-rows]' );

		if ( ! template || ! body ) {
			return;
		}

		var count = body.querySelectorAll( '[data-wpbom-row]' ).length;
		var html = template.innerHTML.split( '__index__' ).join( String( count ) );

		// A <tr> cannot be parsed standalone, so route it through a table.
		var holder = document.createElement( 'table' );
		holder.innerHTML = '<tbody>' + html + '</tbody>';

		var row = holder.querySelector( 'tr' );
		if ( ! row ) {
			return;
		}

		body.appendChild( row );
		toggleEmpty( container );
		reindex( container );

		var select = row.querySelector( 'select' );
		if ( select ) {
			select.focus();
		}
	}

	/**
	 * Remove a row, confirming first if it already has an item selected.
	 *
	 * @param {HTMLElement} container Wrapper carrying data-wpbom-items.
	 * @param {HTMLElement} row       The row to remove.
	 */
	function removeRow( container, row ) {
		var select = row.querySelector( 'select' );
		var filled = select && select.value !== '';

		if ( filled && ! window.confirm( l10n.confirmRemove || 'Remove this line item?' ) ) {
			return;
		}

		row.parentNode.removeChild( row );
		toggleEmpty( container );
		reindex( container );
	}

	/**
	 * Make rows reorderable with the drag handle.
	 *
	 * @param {HTMLElement} container Wrapper carrying data-wpbom-items.
	 */
	function enableDrag( container ) {
		var body = container.querySelector( '[data-wpbom-rows]' );
		if ( ! body ) {
			return;
		}

		var dragging = null;

		body.addEventListener( 'mousedown', function ( event ) {
			var handle = event.target.closest( '.wpbom-handle' );
			if ( ! handle ) {
				return;
			}

			var row = handle.closest( '[data-wpbom-row]' );
			if ( row ) {
				row.draggable = true;
			}
		} );

		body.addEventListener( 'dragstart', function ( event ) {
			dragging = event.target.closest( '[data-wpbom-row]' );

			if ( dragging ) {
				dragging.classList.add( 'wpbom-dragging' );
				event.dataTransfer.effectAllowed = 'move';
				// Firefox needs data set for a drag to start at all.
				event.dataTransfer.setData( 'text/plain', '' );
			}
		} );

		body.addEventListener( 'dragover', function ( event ) {
			if ( ! dragging ) {
				return;
			}

			event.preventDefault();

			var over = event.target.closest( '[data-wpbom-row]' );
			if ( ! over || over === dragging ) {
				return;
			}

			var bounds = over.getBoundingClientRect();
			var after = event.clientY > bounds.top + bounds.height / 2;

			body.insertBefore( dragging, after ? over.nextSibling : over );
		} );

		body.addEventListener( 'dragend', function () {
			if ( ! dragging ) {
				return;
			}

			dragging.classList.remove( 'wpbom-dragging' );
			dragging.draggable = false;
			dragging = null;

			reindex( container );
		} );
	}

	/**
	 * Wire up one line-items container.
	 *
	 * @param {HTMLElement} container Wrapper carrying data-wpbom-items.
	 */
	function init( container ) {
		container.addEventListener( 'click', function ( event ) {
			if ( event.target.closest( '[data-wpbom-add]' ) ) {
				event.preventDefault();
				addRow( container );
				return;
			}

			var remove = event.target.closest( '[data-wpbom-remove]' );
			if ( remove ) {
				event.preventDefault();
				var row = remove.closest( '[data-wpbom-row]' );

				if ( row ) {
					removeRow( container, row );
				}
			}
		} );

		enableDrag( container );
		toggleEmpty( container );
		reindex( container );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		var containers = document.querySelectorAll( '[data-wpbom-items]' );

		Array.prototype.forEach.call( containers, init );
	} );
} )();
