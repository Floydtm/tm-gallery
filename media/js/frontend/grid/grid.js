/* global _, Registry */

Registry.register( "grid", ( function ( $ ) {
    "use strict";
    var state,
        prefix = '.tm-pg_frontend';
    /**
     * Get prefix object
     *
     * @param {type} value
     * @returns {window.$|$}
     */
    function __$( value ) {
        return $( __s( value ) );
    }

    /**
     * Get prefix selector
     * 
     * @param {type} value
     * @returns {String}
     */
    function __s( value ) {
        if ( _.isUndefined( state.ID ) ) {
            return  prefix + ' ' + value;
        } else {
            return  prefix + '[data-id="' + state.ID + '"] ' + value;
        }
    }

    /**
     * Get Registry
     *
     * @param {type} value
     * @returns {wp.mce.View|*}
     */
    function __( value ) {
        return Registry._get( value );
    }
    /**
     * Get instace
     * 
     * @returns {grid_L3.createInstance.gridAnonym$0}
     */
    function createInstance() {
        return {
            ID: 0,
            _item: '.tm_pg_gallery-item',
            _load: {
                grid: '.tm_pg_gallery-item_show-more',
                btn: '.load-more-button'
            },
            _content: {
                grid: '.tm-pg_front_gallery-grid .row',
                masonry: '.tm-pg_front_gallery-masonry',
                justify: '.tm-pg_front_gallery-justify'
            },
            // pagination
            _pagination: {
                content: '.tm-pg_front_gallery-navigation',
                numbers: '.tm-pg_front_gallery-navigation nav'
            },
            // filter
            _filter: {
                line: {
                    item: '.tm-pg_front_gallery-tabs li a',
                    content: '.tm-pg_front_gallery-tabs'
                },
                dropdown: {
                    item: '.filter-select__list li a',
                    content: '.filter-select'
                }
            },
            // inputs
            _input: {
                term_id: 'input[name="term_id"]',
                term_type: 'input[name="term_type"]',
                offset: 'input[name="offset"]',
                per_page: 'input[name="images_per_page"]',
                count: 'input[name="all_count"]'
            },
            /**
             * Get ID
             * 
             * @param {type} $this
             * @returns {unresolved}
             */
            getID: function ( $this ) {
                return $this.parents( prefix ).data( 'id' );
            },
            /**
             * click Pagination
             * 
             * @param {type} page
             * @param {type} $parent
             * @param {type} callback
             * @returns {undefined}
             */
            clickPagination: function ( page, $parent, callback ) {
                $parent.find( 'a' ).removeClass( 'current' );
                var $offset = __$( state._input.offset ),
                    $images_per_page = __$( state._input.per_page );
                page--;
                $offset.val( $images_per_page.val() * page );
                state.ID = state.getID( $parent );
                state.loadMore( 'replase', function () {
                    if ( page > 0 ) {
                        $parent.find( 'a.prev' ).show();
                    } else {
                        $parent.find( 'a.prev' ).hide();
                    }
                    page++;
                    if ( page < $parent.find( state._pagination.numbers ).data( 'count' ) ) {
                        $parent.find( 'a.next' ).show();
                    } else {
                        $parent.find( 'a.next' ).hide();
                    }
                    // callback
                    if ( !_.isUndefined( callback ) && _.isFunction( callback ) ) {
                        callback();
                    }
                } );
            },
            /**
             * Init
             * 
             * @param {type} id
             * @returns {undefined}
             */
            init: function ( id ) {
                state.ID = id;
                state.checkLoadMore();
                state.initEvents();
                __( 'slider' ).init( id );
            },
            /**
             * Init events
             * 
             * @returns {undefined}
             */
            initEvents: function () {
                var container = prefix + '[data-id="' + state.ID + '"]';
                // on click load more
                $( container ).on( 'click', state._load.grid + ' a', state.onClickLoadMore.bind( this ) );
                // on click load more
                $( container ).on( 'click', state._load.btn + ' a', state.onClickLoadMoreBtn.bind( this ) );
                // on click pagination
                $( container ).on( 'click', state._pagination.content + ' a', state.onClickPagination.bind( this ) );
                // on click filter item
                $( container ).on( 'click', state._filter.dropdown.item, state.onClickFilterItem.bind( this ) );
                // on click filter item
                $( container ).on( 'click', state._filter.line.item, state.onClickFilterItem.bind( this ) );

            },
            /**
             * On load grid
             * 
             * @param {type} e
             * @returns {undefined}
             */
            onLoadGrid: function ( e ) {
                console.log( e );
            },
            /**
             * On click dropdown item
             * 
             * @param {type} e
             * @returns {undefined}
             */
            onClickFilterItem: function ( e ) {
                e.preventDefault();
                state.sortGrid( $( e.currentTarget ) );
            },
            /**
             * On click pagination
             * 
             * @param {type} e
             * @returns {undefined}
             */
            onClickPagination: function ( e ) {
                e.preventDefault();
                var $this = $( e.currentTarget ),
                    $parent = $this.parents( state._pagination.content );
                if ( $this.hasClass( 'current' ) ) {
                    return false;
                }
                if ( $this.hasClass( 'next' ) ) {
                    var page = $parent.find( 'a.current' ).text();
                    state.clickPagination( ++page, $parent, function () {
                        $parent.find( 'a[data-pos="' + page + '"]' ).addClass( 'current' );
                    } );
                } else if ( $this.hasClass( 'prev' ) ) {
                    var page = $parent.find( 'a.current' ).text();
                    state.clickPagination( --page, $parent, function () {
                        $parent.find( 'a[data-pos="' + page + '"]' ).addClass( 'current' );
                    } );
                } else {
                    state.clickPagination( $this.text(), $parent, function () {
                        $this.addClass( 'current' );
                    } );
                }
            },
            /**
             * On click load more btn
             * 
             * @param {type} e
             * @returns {undefined}
             */
            onClickLoadMore: function ( e ) {
                e.preventDefault();
                state.ID = state.getID( $( e.currentTarget ) );
                state.loadMore( 'append' );
                $( e.currentTarget ).parent().remove();
            },
            /**
             * On click load more btn
             * 
             * @param {type} e
             * @returns {undefined}
             */
            onClickLoadMoreBtn: function ( e ) {
                e.preventDefault();                
                state.ID = state.getID( $( e.currentTarget ) );
                __$( state._load.grid ).remove();
                state.loadMore( 'append' );
            },
            /**
             * Update url parameter
             *
             * @param {type} param
             * @param {type} paramVal
             * @returns {undefined}
             */
            updateURLParameter: function ( param, paramVal ) {
                if ( history.pushState ) {
                    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + param + '=' + paramVal;
                    window.history.pushState( { path: newurl }, '', newurl );
                }
            },
            /**
             * Load more images
             *
             * @param {type} type
             * @param {type} callback
             * @returns {undefined}
             */
            loadMore: function ( type, callback ) {
                if ( _.isUndefined( type ) ) {
                    type = 'append';
                }
                var $offset = __$( state._input.offset ),
                    $images_per_page = __$( state._input.per_page ),
                    $term_id = __$( state._input.term_id ),
                    $term_type = __$( state._input.term_type ),
                    view = $( prefix + '[data-id="' + state.ID + '"]' ).data( 'view' );
                if ( _.isEqual( type, 'append' ) && !$offset.val() ) {
                    $offset.val( Number( $offset.val() ) + Number( $images_per_page.val() ) );
                }
                state.getContent( $offset.val(), $images_per_page.val(), $term_id.val(), $term_type.val(), function ( $html ) {
                    // if replase remove previus imgs
                    if ( _.isEqual( type, 'replase' ) ) {
                        __$( state._content[view] ).html( '' );
                    }
                    // add new elements
                    $.each( $html, function ( key, value ) {
                        __$( state._content[view] ).append( value );
                    } );
                    state.checkLoadMore();
                    // calculate grid
                    __( 'slider' ).remove();
                    __( 'slider' ).init( state.ID );
                    // isset pagination
                    if ( __$( state._pagination.content ).length ) {
                        var $current = __$( 'a.current', state._pagination.numbers ).last().next();
                        $current.addClass( 'current' );
                        __$( 'a.next', state._pagination.numbers ).hide();
                        __$( 'a.prev', state._pagination.numbers ).hide();
                    }
                    // callback
                    if ( !_.isUndefined( callback ) && _.isFunction( callback ) ) {
                        callback();
                    }
                } );
            },
            /**
             * Check load more
             *
             * @returns {undefined}
             */
            checkLoadMore: function () {
                var $offset = __$( state._input.offset ),
                    $images_per_page = __$( state._input.per_page ),
                    $term_id = __$( state._input.term_id ),
                    total_count = Number( $( prefix + ' a[data-id="' + $term_id.val() + '"]' ).data( 'count' ) );
                total_count = _.isNaN( total_count ) ? __$( state._input.count ).val() : total_count;
                // add step to offset
                $offset.val( Number( $offset.val() ) + Number( $images_per_page.val() ) );
                // check for last request
                if ( $offset.val() >= total_count ) {
                    __$( state._load.btn ).hide();
                    __$( state._load.grid ).hide();
                } else {
                    __$( state._load.btn ).show();
                    __$( state._load.grid ).show();
                }
            },
            /**
             * Sort grid
             * 
             * @param {type} $this
             * @returns {undefined}
             */
            sortGrid: function ( $this ) {
                state.ID = state.getID( $this );
                var term_id = $this.attr( 'data-id' ),
                    type = $this.attr( 'data-type' ),
                    view = $( prefix + '[data-id="' + state.ID + '"]' ).data( 'view' );
                // filter content
                state.filterContent( term_id, type, function ( $data ) {
                    __$( state._filter.dropdown.content ).removeClass( 'open' );
                    __$( state._filter.dropdown.content ).find( 'li' ).removeClass( 'active' );
                    __$( state._filter.line.content ).find( 'li' ).removeClass( 'active' );
                    $this.parents( 'li' ).addClass( 'active' );
                    // remove previus imgs
                    __$( state._content[view] ).html( '' );
                    // add new elements
                    $.each( $data, function ( key, value ) {
                        __$( state._content[view] ).append( value );
                    } );
                    // update term paramets
                    __$( state._input.term_id ).val( term_id );
                    __$( state._input.term_type ).val( type );
                    __$( state._input.offset ).val( 0 );
                    // check on enable page pagination
                    if ( __$( state._pagination.content ).data( 'load-more-page' ) ) {
                        state.getPagination( term_id, type, function ( html ) {
                            __$( state._pagination.content ).html( html );
                            state.checkLoadMore();
                            // calculate grid
                            __( 'slider' ).remove();
                            __( 'slider' ).init( state.ID );
                        } );
                    } else {
                        state.checkLoadMore();
                        // calculate grid
                        __( 'slider' ).remove();
                        __( 'slider' ).init( state.ID );
                    }
                } );
            },
            /**
             * Filter content
             *
             * @param {type} term_id
             * @param {type} type
             * @param {type} callback
             * @returns {undefined}
             */
            filterContent: function ( term_id, type, callback ) {
                var $params = {
                    action: 'tm_pg_f',
                    post_id: __$( '' ).data( 'post-id' ),
                    fields: 'all'
                },
                $images_per_page = __$( state._input.per_page );
                $params[window.tm_pg_options.action] = 'filter_grid';
                $params.controller = 'grid';
                $params.term_id = term_id;
                $params.id = state.ID;
                $params.type = type;
                $params.images_per_page = $images_per_page.val();
                $params.tm_pg_nonce = window.tm_pg_options.nonce;
                $.post( window.tm_pg_options.ajax_url, $params, function ( data ) {
                    if ( !_.isUndefined( callback ) && _.isFunction( callback ) ) {
                        callback( data.data );
                    }
                } );
            },
            /**
             * Load more
             *
             * @param {type} offset
             * @param {type} images_per_page
             * @param {type} term_id
             * @param {type} type
             * @param {type} callback
             * @returns {undefined}
             */
            getContent: function ( offset, images_per_page, term_id, type, callback ) {
                var $params = {
                    action: 'tm_pg_f',
                    controller: 'grid',
                    shortcode: 'grid',
                    fields: 'all',
                    post_id: __$( '' ).data( 'post-id' ),
                    term_id: term_id,
                    type: type,
                    id: state.ID,
                    offset: offset,
                    images_per_page: images_per_page
                };
                $params.tm_pg_nonce = window.tm_pg_options.nonce;
                $params[window.tm_pg_options.action] = 'get_content';
                $.post( window.tm_pg_options.ajax_url, $params, function ( data ) {
                    if ( data.success && !_.isUndefined( callback ) && _.isFunction( callback ) ) {
                        callback( data.data );
                    }
                } );
            },
            /**
             * Get pagination
             *
             * @param {type} term_id
             * @param {type} type
             * @param {type} callback
             * @returns {undefined}
             */
            getPagination: function ( term_id, type, callback ) {
                var $params = { action: 'tm_pg_f' };
                $params[window.tm_pg_options.action] = 'get_pagination';
                $params.controller = 'grid';
                $params.id = state.ID;
                $params.term_id = term_id;
                $params.type = type;
                $params.tm_pg_nonce = window.tm_pg_options.nonce;
                $.post( window.tm_pg_options.ajax_url, $params, function ( data ) {
                    if ( data.success && !_.isUndefined( callback ) && _.isFunction( callback ) ) {
                        callback( data.data );
                    }
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
