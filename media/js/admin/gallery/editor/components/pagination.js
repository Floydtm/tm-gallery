/*global _:false,Registry:false,jQuery:false, console:fale*/
Registry.register( "gl-editor-pagination", ( function ( $ ) {
	"use strict";
	var state;

	function __( value ) {
		return Registry._get( value );
	}

	/**
	 * Create instance
	 * 
	 * @returns {pagination_L2.createInstance.paginationAnonym$0}
	 */
	function createInstance() {
		return {
			_item: '.tm-pg_gallery_pagination_item',
			/**
			 * Pagination content
			 */
			_content: { },
			/**
			 * Init display
			 * 
			 * @returns {undefined}
			 */
			init: function ( ) {
				__( 'gl-editor' ).hideSection();
				__( 'gl-editor' ).showSection( 'pagination' );
				// set content
				if ( _.isEmpty( state._content ) ) {
					state._content = $.extend( true, { }, __( 'gl-editor' )._gallery.pagination );
				}
				// init content
				state.initContent();
			},
			/**
			 * Init content
			 * 
			 * @returns {undefined}
			 */
			initContent: function () {
				$( state._item + '[data-type="show"] input' ).prop( 'checked', state._content.show );
				$( state._item + '[data-type="images_per_page"] .select2' ).val( state._content.images_per_page );
				$( state._item + '[data-type="load_more_btn"] input' ).prop( 'checked', state._content.load_more_btn );
				$( state._item + '[data-type="load_more_grid"] input' ).prop( 'checked', state._content.load_more_grid );
				$( state._item + '[data-type="pagination_block"] input' ).prop( 'checked', state._content.pagination_block );
				$( state._item + " .select2" ).select2( );
			},
			/**
			 * Init events
			 * 
			 * @returns {undefined}
			 */
			initEvents: function () {
				// On change checkbox
				$( document ).on( 'change', state._item + ' input', state.onChangeCheckbox.bind( this ) );
				// On change select
				$( document ).on( 'change', state._item + ' select', state.onChangeSelect.bind( this ) );
			},
			/**
			 * On change select
			 * 
			 * @param {type} e
			 * @returns {undefined}
			 */
			onChangeSelect: function ( e ) {
				var type = $( e.currentTarget ).parents( state._item ).data( 'type' );
				state._content[type] = $( e.currentTarget ).val();
			},
			/**
			 * On change checkbox
			 * 
			 * @param {type} e
			 * @returns {undefined}
			 */
			onChangeCheckbox: function ( e ) {
				var type = $( e.currentTarget ).parents( state._item ).data( 'type' );
				if ( $( e.currentTarget ).is( ":checked" ) ) {
					state._content[type] = 1;
				} else {
					state._content[type] = 0;
				}
			}
		};
	}

	return {
		getInstance: function () {
			if ( !state ) {
				state = createInstance();
			}
			return state;
		}
	};
} )( jQuery ) );
