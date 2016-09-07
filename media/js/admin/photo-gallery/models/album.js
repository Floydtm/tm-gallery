/* global _ */

Registry.register( "album", ( function ( $ ) {
    "use strict";
    var state;
    function __( value ) {
        return Registry._get( value );
    }
    function createInstance() {
        return {
            tax_name: window.tm_pg_options.tax_names.album,
            post_type: window.tm_pg_options.post_types.album,
            _clone: '#album-term-clone',
            _item: '.tm-pg_album_container',
            /**
             * Init Events
             * 
             * @returns {undefined}
             */
            initEvents: function () {
                var _grid = __( 'grid' ),
                    _right = __( 'pg-right' );
                // On focusout album name input
                $( document ).on( 'focusout', _grid._item.album + '.new input:visible',
                    state.onFocusoutAlbumInput.bind( this ) );
                // On keyup album name input
                $( document ).on( 'keyup', _grid._item.album + '.new input:visible',
                    state.onKeyupAlbumInput.bind( this ) );
                // On click Add to album
                $( document ).on( 'click', _right._slidebar + ' .tm-pg_add-to-album_form > button.tm-pg_btn',
                    state.onClickAddToAlbum.bind( this ) );
                // On click Add to album
                $( document ).on( 'click', _right._slidebar + ' ' + state._item + ' .tm-pg_album-delete',
                    state.onClickDeleteFromAlbum.bind( this ) );
            },
            /**
             * On click delete from album
             * 
             * @param {type} e - Mouse event.
             * @returns {undefined}
             */
            onClickDeleteFromAlbum: function ( e ) {
                e.preventDefault();
                var ids = __( 'pg-right' ).ids,
                    $this = $( e.currentTarget ).parent(),
                    value = $this.data( 'id' ),
                    key = 0;
                state.albumAction( ids, value, key, 'delete_from_folder' );
            },
            /**
             * On click add to album
             * 
             * @param {type} e - Mouse event.
             * @returns {undefined}
             */
            onClickAddToAlbum: function ( e ) {
                e.preventDefault();
                var ids = __( 'pg-right' ).ids,
                    $this = $( e.currentTarget ).parent(),
                    value = $( 'select', $this ).val(),
                    key = 0;
                state.albumAction( ids, value, key, 'add_to_folder' );
            },
            /**
             * On keyup album name input
             * 
             * @param {type} e - Mouse event.
             * @returns {Boolean}
             */
            onKeyupAlbumInput: function ( e ) {
                e.preventDefault();
                if ( e.keyCode === 13 ) {
                    $( e.currentTarget ).blur();
                    return false;
                }
            },
            /**
             * On focusout album name input
             * 
             * @param {type} e - Mouse event.
             * @returns {undefined}
             */
            onFocusoutAlbumInput: function ( e ) {
                e.preventDefault();
                var $this = $( e.currentTarget );
                if ( _.isEmpty( $this.val() ) ) {
                    $this.val( 'Album name' );
                }
                state.addAlbum( $this );
            },
            /**
             * Album action
             * 
             * @param {type} ids
             * @param {type} value
             * @param {type} key
             * @param {type} action
             * @returns {undefined}
             */
            albumAction: function ( ids, value, key, action ) {
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
                                __( 'pg-folder' ).updateFolder( value, 'album' );
                            } );
                        }
                        if ( !_.isUndefined( ids[++key] ) ) {
                            state.albumAction( ids, value, key, action );
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
                    alubums = __( 'pg-content' ).getContent( id ).albums,
                    albumKey = alubums.indexOf( Number( value ) ),
					_content = __( 'pg-content' );
                // add new album
                if ( _.isEqual( -1, albumKey ) ) {
                    alubums.push( Number( value ) );
                }
                // if last action
                if ( _.isEqual( key, ids.length - 1 ) ) {
                    if ( _.isEqual( -1, albumKey ) ) {
                        // add right folder
                        __( 'folder' ).addRightFolder( value, 'album' );
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
                    alubums = _content.getContent( id ).albums,
                    albumKey = alubums.indexOf( Number( value ) );
                if ( !_.isEqual( -1, albumKey ) ) {
                    alubums.splice( albumKey, 1 );
                }
                // if last action
                if ( _.isEqual( key, ids.length - 1 ) ) {
                    if ( !_.isEqual( -1, albumKey ) ) {
                        // add right folder
                        __( 'folder' ).removeRightFolder( value, 'album' );
                    }
                    // show notification
                    _notification.show( 'delete_from_' + $lang.type, $lang.replase );
                    // in folder
                    if ( _folder._ID ) {
                        // remove content if in folder
                        _folder.removeContent( ids, value );
                    }
                    // update folder
                    _folder.updateFolder( value, 'album' );
                    // enable rightbar
                    _content.toggleDisable( false );
                }
            },
            /**
             * Add album
             * 
             * @param {type} $this
             * @param {type} callback
             * @returns {undefined}
             */
            addAlbum: function ( $this, callback ) {
                var $params = { },
                    _grid = __( 'grid' ),
                    _folder = __( 'folder' ),
                    view = _grid.getView(),
                    $parent = $this.parents( '.tm-pg_library_item' );
                if ( _.isEqual( view, 'folder' ) ) {
                    $params.parent = __( 'pg-folder' )._ID;
                }
                $params.type = state.post_type;
                $params.title = $this.val();
                $this.remove();
                // add new album or set
                _folder.addFolder( $params, function ( data ) {
                    $parent.attr( 'data-id', data.id );
                    __( 'pg-content' ).setContent( data.id, '', data.folder, 'album' );
                    _grid.buildItem( data.id );
                    // render right select
                    _folder.renderRightSelect( 'album' );
                    _grid.toggleSelectAllBtn( 'album', 'show' );
                    // callback function
                    if ( !_.isUndefined( callback ) && _.isFunction( callback ) ) {
                        callback( data );
                    }
                    // update folder
                    if ( __( 'pg-folder' )._ID ) {
                        __( 'pg-folder' ).updateFolder( __( 'pg-folder' )._ID, 'set' );
                    }
                    // show notofication
                    __( 'notification' ).show( 'add_album', { name: $params.title } );
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
