/*global _:false,Registry:false,jQuery:false, console:fale*/
Registry.register( "gl-editor-filters", ( function ( $ ) {
	"use strict";
	var state;

	function __( value ) {
		return Registry._get( value );
	}

	/**
	 * Create instance
	 * 
	 * @returns {filters_L2.createInstance.filtersAnonym$0}
	 */
	function createInstance() {
		return {
			_item: '.tm-pg_gallery_filters_item',
			/**
			 * Filter content
			 */
			_content: { },
			/**
			 * Init display
			 * 
			 * @returns {undefined}
			 */
			init: function ( ) {
				var _glEditor = __( 'gl-editor' );
				_glEditor.hideSection();
				_glEditor.showSection( 'filters' );
				// set content
				if ( _.isEmpty( state._content ) ) {
					state._content = $.extend( true, { }, _glEditor._gallery.filter );
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
				$( state._item + '[data-type="show"] #show-filter' ).prop( 'checked', state._content.show );
				$( state._item + '[data-type="type"] .select2' ).val( state._content.type );
				$( state._item + '[data-type="by"] .select2' ).val( state._content.by );
				$( state._item + " .select2" ).select2( );
			},
			/**
			 * Init Event
			 * 
			 * @returns {undefined}
			 */
			initEvents: function () {
				// on Change input
				$( document ).on( 'change', state._item + ' input', state.onChangeInput.bind( this ) );
				// on Change select
				$( document ).on( 'change', state._item + ' select', state.onChangeSelect.bind( this ) );
			},
			/**
			 * On change input
			 * 
			 * @param {type} e
			 * @returns {undefined}
			 */
			onChangeInput: function ( e ) {
				var type = $( e.currentTarget ).parents( state._item ).data( 'type' );
				state._content[type] = ( $( e.currentTarget ).is( ":checked" ) ) ? 1 : 0;
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
