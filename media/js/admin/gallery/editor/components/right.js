/*global _:false,Registry:false,upload:false*/
Registry.register( "gl-editor-right", ( function ( $ ) {
	"use strict";
	var state;
	function __( value ) {
		return Registry._get( value );
	}
	/**
	 * Create Instance
	 * 
	 * @returns {right_L2.createInstance.rightAnonym$0}
	 */
	function createInstance() {
		return {
			// clone
			_clone: '#right-grid',
			_container: '.tm-pg_sidebar_chosen-items',
			_item: '.tm-pg_sidebar_chosen-items .tm-pg_sidebar_chosen-item',
			_header: '.tm-pg_sidebar_chosen-items_header',
			_delete: '.tm-pg_sidebar_chosen-items_delete',
			_deleteAll: '.tm-pg_sidebar_chosen-items_remove-all',
			// content
			_content: {
				img: { },
				album: { },
				set: { }
			},
			/**
			 * Init
			 * 
			 * @param {type} type
			 * @returns {undefined}
			 */
			init: function ( type ) {
				state._content[type] = { };
				if ( !_.isNull( __( 'gl-editor' )._childs ) ) {
					$.each( __( 'gl-editor' )._content[type], function ( key, item ) {
						_.each( __( 'gl-editor' )._childs[type], function ( id ) {
							if ( _.isEqual( Number( key ), Number( id ) ) ) {
								state._content[type][id] = item;
							}
						} );
					} );
				}
			},
			/**
			 * Init grid
			 * 
			 * @returns {undefined}
			 */
			initGrid: function () {
				state.initScrollbar();
				state.toggleHeader();
			},
			/**
			 * Init events
			 * 
			 * @returns {undefined}
			 */
			initEvents: function () {
				//On click right item
				$( document ).on( 'click', state._item, state.onClickRightItem.bind( this ) );
				// On click delete
				$( document ).on( 'click', state._delete, state.onClickDelete.bind( this ) );
				// Delete all
				$( document ).on( 'click', state._deleteAll, state.onClickDeleteAll.bind( this ) );
			},
			/**
			 * On click delete all
			 * 
			 * @param {Object} e - Mouse event.
			 */
			onClickDeleteAll: function ( e ) {
				e.preventDefault();
				var _glEditorGrid = __( 'gl-editor-grid' );
				_.each( $( state._item ), function ( item ) {
					var type = $( item ).data( 'type' ),
						id = $( item ).data( 'id' );
					$( _glEditorGrid._item[type] + '[data-id="' + id + '"]' ).removeClass( 'checked' );
					_glEditorGrid.toggleItem( id, type );
				} );
				__( 'gl-editor-right' ).renderItems();
			},
			/**
			 * On click delete
			 * 
			 * @param {Object} e - Mouse event.
			 */
			onClickDelete: function ( e ) {
				e.preventDefault();
				var _glEditorGrid = __( 'gl-editor-grid' );
				_.each( $( state._item + '.checked' ), function ( item ) {
					var type = $( item ).data( 'type' ),
						id = $( item ).data( 'id' );
					$( _glEditorGrid._item[type] + '[data-id="' + id + '"]' ).removeClass( 'checked' );
					_glEditorGrid.toggleItem( id, type );
				} );
				__( 'gl-editor-right' ).renderItems();
			},
			/**
			 * On click right item
			 * 
			 * @param {type} e
			 * @returns {undefined}
			 */
			onClickRightItem: function ( e ) {
				e.preventDefault();
				$( e.currentTarget ).toggleClass( 'checked' );
				state.toggleHeader();
			},
			/**
			 * Toggle right header
			 * 
			 * @returns {undefined}
			 */
			toggleHeader: function () {
				if ( $( state._item ).hasClass( 'checked' ) ) {
					$( 'h5', state._header ).removeClass( 'hide' );
					$( 'h5 span', state._header ).text( $( state._item + '.checked' ).length );
					$( state._delete, state._header ).removeClass( 'hide' );
				} else {
					$( 'h5', state._header ).addClass( 'hide' );
					$( state._delete, state._header ).addClass( 'hide' );
				}
			},
			/**
			 * Init scrollbar
			 *
			 * @returns {undefined}
			 */
			initScrollbar: function () {
				$( state._container ).css( 'height', '' );
				// init sidebar scrollbar
				var rightHeight = innerHeight - $( state._container ).offset().top - 45;
				if ( $( state._container ).height() > rightHeight ) {
					$( state._container ).height( rightHeight );
				}
			},
			/**
			 * Render items
			 * 
			 * @returns {undefined}
			 */
			renderItems: function () {
				var html = '',
					childs = __( 'gl-editor' )._childs,
					types = __( 'gl-editor-grid' )._types;

				// add right items 
				_.each( types, function ( type ) {
					_.each( childs[type], function ( id ) {
						if ( !_.isUndefined( state._content[type][id] ) ) {
							html += state.addItem( id );
						}
					} );
				} );
				$( state._container ).html( html );
				// build right items
				_.each( types, function ( type ) {
					$.each( state._content[type], function ( id, $item ) {
						if ( $item ) {
							state.buildItem( type, id );
						}
					} );
				} );
				// init grid events
				state.initGrid();
			},
			/**
			 * Add item
			 * 
			 * @param {type} id
			 * @returns {undefined}
			 */
			addItem: function ( id ) {
				var $clone = $( state._clone ).clone();
				$( '.tm-pg_column', $clone ).attr( 'data-id', id );
				return $clone.html();
			},
			/**
			 * Build item
			 * 
			 * @param {type} type
			 * @param {type} id
			 * @returns {undefined}
			 */
			buildItem: function ( type, id ) {
				var $data = state._content[type][id],
					$item = $( state._item + '[data-id="' + id + '"]' );
				$item.attr( 'data-type', type );
				if ( _.isEqual( type, 'img' ) ) {
					$( 'figure img', $item ).attr( 'src', $data.thumbnails.big.url );
					$( 'figure', $item ).removeClass( 'hidden' );
				} else {
					if ( !_.isNull( $data.cover_img.big ) && !_.isEmpty( $data.cover_img.right ) ) {
						$( 'figure', $item ).removeClass( 'hidden' );
						$( 'figure img', $item ).attr( 'src', $data.cover_img.big[0] );
					} else {
						$item.addClass( 'new' );
					}
					$( 'div[data-type="' + type + '"]', $item ).removeClass( 'hidden' );
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



