/* global _ */

Registry.register( "set", ( function ( $ ) {
	"use strict";
	var state;
	/**
	 * __ 
	 * 
	 * @param {type} value
	 * @returns {wp.mce.View|*}
	 */
	function __( value ) {
		return Registry._get( value );
	}
	/**
	 * Create instance
	 * 
	 * @returns {set_L3.createInstance.setAnonym$0}
	 */
	function createInstance() {
		return {
			tax_name: window.tm_pg_options.tax_names.set,
			post_type: window.tm_pg_options.post_types.set,
			_clone: '#set-term-clone',
			_item: '.tm-pg_set_container',
			/**
			 * Init Events
			 * 
			 * @returns {undefined}
			 */
			initEvents: function () {
				var _grid = __( 'grid' ),
					_right = __( 'pg-right' );
				// On focusout album name input
				$( document ).on( 'focusout', _grid._item.set + '.new input:visible',
					state.onFocusoutSetInput.bind( this ) );
				// On keyup album name input
				$( document ).on( 'keyup', _grid._item.set + '.new input:visible',
					state.onKeyupSetInput.bind( this ) );
				// On click Add to album
				$( document ).on( 'click', _right._slidebar + ' .tm-pg_add-to-set_form > button.tm-pg_btn',
					state.onClickAddToSet.bind( this ) );
				// On click Add to album
				$( document ).on( 'click', _right._slidebar + ' ' + state._item + ' .tm-pg_set-delete',
					state.onClickDeleteFromSet.bind( this ) );
			},
			/**
			 * On click delete from set
			 * 
			 * @param {type} e
			 * @returns {undefined}
			 */
			onClickDeleteFromSet: function ( e ) {
				var ids = __( 'pg-right' ).ids,
					$this = $( e.currentTarget ).parent(),
					value = $this.data( 'id' ),
					key = 0;
				state.setAction( ids, value, key, 'delete_from_folder' );
			},
			/**
			 * On click add to set
			 * 
			 * @param {type} e
			 * @returns {undefined}
			 */
			onClickAddToSet: function ( e ) {
				e.preventDefault();
				var ids = __( 'pg-right' ).ids,
					$this = $( e.currentTarget ).parent(),
					value = $( 'select', $this ).val(),
					key = 0;
				state.setAction( ids, value, key, 'add_to_folder' );
			},
			/**
			 * On focusout set input
			 * 
			 * @param {type} e - Mouse event.
			 * @returns {undefined}
			 */
			onFocusoutSetInput: function ( e ) {
				e.preventDefault();
				var $this = $( e.currentTarget );
				if ( _.isEmpty( $this.val() ) ) {
					$this.val( 'Set name' );
				}
				state.addSet( $this );
			},
			/**
			 * On keyup set input
			 * 
			 * @param {type} e
			 * @returns {Boolean}
			 */
			onKeyupSetInput: function ( e ) {
				e.preventDefault();
				if ( e.keyCode === 13 ) {
					$( e.currentTarget ).blur();
					return false;
				}
			},
			/**
			 * Set action
			 * 
			 * @param {type} ids
			 * @param {type} value
			 * @param {type} key
			 * @param {type} action
			 * @returns {undefined}
			 */
			setAction: function ( ids, value, key, action ) {
				var $params = { },
					id = ids[key],
					_content = __( 'pg-content' );
				if ( value ) {
					$params.value = id;
					$params.id = value;
					$params.controller = "folder";
					$params.action = action;
					// disable rightbar
					_content.toggleDisable( true );
					__( 'common' ).wpAjax( $params, function () {
						if ( _.isEqual( action, 'delete_from_folder' ) ) {
							state.removeRightCallback( ids, key, value );
						} else {
							state.addRightCallback( ids, key, value, function () {
								var _notification = __( 'notification' ),
									$lang = _notification.getLangData( value );
								// show notification
								_notification.show( 'added_to_' + $lang.type, $lang.replase );
								// update folder
								__( 'pg-folder' ).updateFolder( value, 'set' );
							} );
						}
						if ( !_.isUndefined( ids[++key] ) ) {
							state.setAction( ids, value, key, action );
						}
					} );
				}
			},
			/**
			 * Add album callback
			 * 
			 * @param {type} ids
			 * @param {type} key
			 * @param {type} value
			 * @returns {undefined}
			 */
			addRightCallback: function ( ids, key, value, callback ) {
				var id = ids[key],
					_content = __( 'pg-content' ),
					sets = _content.getContent( id ).sets,
					setKey = sets.indexOf( value );
				// add new album
				if ( _.isEqual( -1, setKey ) ) {
					sets.push( Number( value ) );
				}
				// if last action
				if ( _.isEqual( key, ids.length - 1 ) ) {
					if ( _.isEqual( -1, setKey ) ) {
						// add right folder
						__( 'folder' ).addRightFolder( value, 'set' );
					}
					if ( !_.isUndefined( callback ) && _.isFunction( callback ) ) {
						callback(  );
					}
					// enable rightbar
					_content.toggleDisable( false );
				}
			},
			/**
			 * Remove album callback
			 * 
			 * @param {type} ids
			 * @param {type} key
			 * @param {type} value
			 * @returns {undefined}
			 */
			removeRightCallback: function ( ids, key, value ) {
				var id = ids[key],
					_notification = __( 'notification' ),
					_folder = __( 'pg-folder' ),
					_content = __( 'pg-content' ),
					$lang = _notification.getLangData( value ),
					alubums = _content.getContent( id ).sets,
					albumKey = alubums.indexOf( value );
				if ( !_.isEqual( -1, albumKey ) ) {
					alubums.splice( albumKey, 1 );
				}
				// if last action
				if ( _.isEqual( key, ids.length - 1 ) ) {
					if ( !_.isEqual( -1, albumKey ) ) {
						// add right folder
						__( 'folder' ).removeRightFolder( value, 'set' );
					}
					// show notification
					_notification.show( 'delete_from_' + $lang.type, $lang.replase );
					// in folder
					if ( _folder._ID ) {
						// remove content if in folder
						_folder.removeContent( ids, value );
					}
					// update folder
					_folder.updateFolder( value, 'set' );
					// enable rightbar
					_content.toggleDisable( false );
				}
			},
			/**
			 * Add set
			 * 
			 * @param {type} $this
			 * @param {type} callback
			 * @returns {undefined}
			 */
			addSet: function ( $this, callback ) {
				var $params = { },
					_grid = __( 'grid' ),
					_folder = __( 'folder' ),
					$parent = $this.parents( '.tm-pg_library_item' );
				$params.type = state.post_type;
				$params.title = $this.val();
				$this.remove();
				// add new album or set
				_folder.addFolder( $params, function ( data ) {
					$parent.attr( 'data-id', data.id );
					// add "set" content
					__( 'pg-content' ).setContent( data.id, '', data.folder, 'set' );
					// bild set grid
					_grid.buildItem( data.id );
					// render right select
					_folder.renderRightSelect( 'set' );
					if ( !_.isUndefined( callback ) && _.isFunction( callback ) ) {
						callback( data );
					}
					_grid.toggleSelectAllBtn( 'set', 'show' );
					// show notofication
					__( 'notification' ).show( 'add_set', { name: $params.title } );
				} );
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
