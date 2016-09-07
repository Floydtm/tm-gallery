/* global _, Registry */

Registry.register( "term", ( function ( $ ) {
    "use strict";
    var state;
    function __( value ) {
        return Registry._get( value );
    }
    /**
     * Create instance
     * 
     * @returns {tag_L3.createInstance.tagAnonym$0}
     */
    function createInstance() {
        return {
            /**
             * Multi Add Tags
             * 
             * @param {type} type
             * @param {type} action
             * @returns {undefined}
             */
            addMultiTerms: function ( type, action ) {
                var $terms = [ ],
                    value = 'term_id',
                    ids = __( 'pg-right' ).ids;

                // create all tags array
                _.each( ids, function ( id ) {
                    var _terms = __( 'pg-content' ).getContent( id )[type];
                    if ( !_.isEmpty( _terms ) ) {
                        _.each( _terms, function ( term ) {
                            var index = $terms.indexOf( term );
                            if ( _.isEqual( -1, index ) ) {
                                $terms.push( term );
                            }
                        } );
                    }
                } );
                // calculate terms count and remove it if it not in selected attachments
                $.each( $terms, function ( key, $term ) {
                    var count = 0;
                    _.each( ids, function ( id ) {
                        var _terms = __( 'pg-content' ).getContent( id )[type];
                        if ( !_.isEmpty( _terms ) ) {
                            _.each( _terms, function ( _term ) {
                                if ( !_.isEmpty( $term ) && !_.isEmpty( _term ) ) {
                                    if ( $term[value] === _term[value] ) {
                                        count++;
                                    }
                                }
                            } );
                        }
                    } );

                    if ( !_.isEqual( count, ids.length ) ) {
                        $terms = _.without( $terms, $term );
                    }
                } );

                // unique terms
                if ( !_.isEmpty( $terms ) ) {
                    Array.prototype.getUnique = function () {
                        var u = { }, a = [ ];
                        for ( var i = 0, l = this.length; i < l; ++i ) {
                            if ( u.hasOwnProperty( this[i] ) ) {
                                continue;
                            }
                            a.push( this[i] );
                            u[this[i]] = 1;
                        }
                        return a;
                    };
                    $terms = $terms.getUnique();
                }
                // add term
                switch ( type ) {
                    case 'tags':
                        __( 'tag' ).addTags( $terms );
                        break;
                    case 'categories':
                        __( 'category' ).selectCats( $terms, action );
                        break;
                }
            },
            /**
             *  Term action
             *
             * @param $params
             * @param callback
             */
            termAction: function ( $params, callback ) {
                var $args = {
                    controller: "term",
                    action: $params.action
                };
                $.extend( $args, $params );
                __( 'common' ).wpAjax( $args,
                    function ( data ) {
                        if ( !_.isUndefined( callback ) && _.isFunction( callback ) ) {
                            callback( data );
                        }
                    },
                    function ( data ) {
                        if ( console ) {
                            console.warn( data );
                        }
                        // enable content
                        __( 'pg-content' ).toggleDisable( false );
                        // show notofication
                        __( 'notification' ).show( 'error' );
                    }
                );
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



