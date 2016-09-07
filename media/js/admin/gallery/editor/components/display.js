/*global _:false,Registry:false,jQuery:false, console:fale*/
Registry.register( "gl-editor-display", ( function ( $ ) {
	"use strict";
	var state;

	function __( value ) {
		return Registry._get( value );
	}

	/**
	 * Create instance
	 * 
	 * @returns {display_L2.createInstance.displayAnonym$0}
	 */
	function createInstance() {
		return {
			_rightScrollContainer: '#tm-pg-sidebar-scroll-container',
			_item: '.tm-pg_gallery_display-type_item',
			_right: '#sidebar-content',
			/**
			 * Display content
			 */
			_content: { },
			/**
			 * Init display
			 * 
			 * @returns {undefined}
			 */
			init: function ( ) {
				// refresh active
				$( state._item + ' a' ).removeClass( 'active' );
				__( 'gl-editor' ).hideSection();
				__( 'gl-editor' ).showSection( 'display' );
				state.initRightScrollbar();
				// set content
				if ( _.isEmpty( state._content ) ) {
					state._content = $.extend( true, { }, __( 'gl-editor' )._gallery.grid );
				}
				// select current grid
				$( state._item + ' a.tm-pg_gallery_display-type_' + state._content.type ).addClass( 'active' );
				// init grid
				state.initGrid();
				// init right
				state.initRight();
			},
			/**
			 * Init grid
			 * 
			 * @returns {undefined}
			 */
			initGrid: function ( ) {
				// On click display grid item
				$( document ).on( 'click', state._item + ' a', state.onClickDisplayGrid.bind( this ) );
				//On change colums
				$( document ).on( 'change', state._right + ' div[data-type="colums"] select',
					state.onChangeColums.bind( this ) );
			},
			/**
			 * On change colums
			 * 
			 * @param {type} e
			 * @returns {undefined}
			 */
			onChangeColums: function ( e ) {
				state._content.colums = $( e.currentTarget ).val();
			},
			/**
			 * On click display grid item
			 * 
			 * @param {Object} e - Mouse event.
			 */
			onClickDisplayGrid: function ( e ) {
				e.preventDefault();
				// refresh active
				$( state._item + ' a' ).removeClass( 'active' );
				// active current
				$( e.currentTarget ).addClass( 'active' );
				state._content.type = $( e.currentTarget ).data( 'type' );
				state.initRight();
			},
			/**
			 * Init right
			 * 
			 * @param {type} type
			 * @returns {undefined}
			 */
			initRight: function ( ) {
				var colums = state._right + ' div[data-type="colums"]';
				$( colums + ' .select2' ).val( state._content.colums );
				// set colums
				if ( !_.isEqual( state._content.type, 'justify' ) ) {
					$( colums + " .select2" ).select2( );
					$( colums ).show();
				} else {
					$( colums ).hide();
				}
			},
			/**
			 * Init scrollbar
			 *
			 * @returns {undefined}
			 */
			initRightScrollbar: function () {
				// init sidebar scrollbar
				var rightHeight = innerHeight - $( state._rightScrollContainer ).offset().top - 30;
				$( state._rightScrollContainer ).height( rightHeight );
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
