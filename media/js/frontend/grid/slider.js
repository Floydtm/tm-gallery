/* global Registry */

Registry.register( "slider", ( function ( $ ) {
    "use strict";
    var state,
        prefix = '.tm-pg_frontend';

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
     * get instace
     *
     * @returns {grid_L1.createInstance.gridAnonym$0}
     */
    function createInstance() {
        return {
            container: '',
            gallery: { },
            _content: {
                grid: '.tm-pg_front_gallery-grid .row',
                masonry: '.tm-pg_front_gallery-masonry',
                justify: '.tm-pg_front_gallery-justify'
            },
            _item: 'div.tm_pg_gallery-item[data-type="img"] a',
            __$: function ( value ) {
                return $( state.container + ' ' + value );
            },
            /**
             * Init gallery
             * 
             * @param {type} parent_id
             * @returns {undefined}
             */
            init: function ( parent_id ) {
                state.container = prefix + '[data-id="' + parent_id + '"]';
                var view = $( state.container ).data( 'view' );
                state.__$( state._content[view] ).lightGallery( {
                    selector: state._item,
                    thumbnail: true,
                    animateThumb: true,
                    showThumbByDefault: true,
                    toogleThumb: true,
                    thumbContHeight: 80
                } );
                // Perform any action just before opening the gallery
                state.__$( state._content[view] ).on( 'onBeforeOpen.lg', function ( event ) {
                    $( '#wpadminbar' ).css( 'z-index', '0' );
                } );
                state.__$( state._content[view] ).on( 'onCloseAfter.lg', function ( event ) {
                    $( '#wpadminbar' ).css( 'z-index', '' );
                } );
                state.gallery = state.__$( state._content[view] ).data( 'lightGallery' );
            },
            /**
             * Remove gallery
             * 
             * @returns {undefined}
             */
            remove: function () {
                state.gallery.destroy( true );
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
