/* global _, tm_pg_options */

Registry.register( "tag", ( function ( $ ) {
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
			_clone: '#tag-clone',
			_item: '.tm-pg_tag_container',
			/**
			 * Init
			 * 
			 * @returns {undefined}
			 */
			init: function (  ) {
				var tagsStr = '', delayTimer,
					selector = __( 'pg-right' )._slidebar;

				/**
				 * On click Add tag
				 * 
				 * @param {Object} e - Mouse event.
				 */
				$( selector ).on( 'click', '.tm-pg_add-tags_form > button.tm-pg_btn', function ( e ) {
					e.preventDefault();
					var $this = $( this ).parent(),
						ids = __( 'pg-right' ).ids,
						key = 0;
					state.tagAction( ids, $( 'input', $this ).val(), key, 'add_term' );
					$( 'input', $this ).val( '' );
				} );

				/**
				 * Search tags on input keyup
				 * 
				 * @param {Object} e - Mouse event.
				 */
				$( selector ).on( "keyup", '.tm-pg_add-tags_form > input', function ( e ) {
					if ( e.keyCode === 13 ) {
						$( 'button.tm-pg_btn', $( this ).parent() ).trigger( 'click' );
						return false;
					}
					clearTimeout( delayTimer );
					var $this = $( this );
					delayTimer = setTimeout( function () {
						if ( _.isEmpty( $this.val() ) ) {
							return false;
						}
						// search isset Tags
						state.searchTag( { q: $this.val() }, function ( $data ) {
							var $clone = $( '#terms-seach' ).children().clone();
							$this.parent().append( $clone );
							$( '.search-res ul.ac_results li:not(".hidden")' ).remove();
							if ( _.isEmpty( $data ) ) {
								return false;
							}
							// bild find tags
							$.each( $data, function ( key, term ) {
								state.buildSearchTags( term, $this.val() );
							} );
							$( '.search-res' ).removeClass( "hidden" );
							// On click find tags
							$( '.search-res ul.ac_results li' ).on( "click", function () {
								var array = $this.val().split( "," ),
									inputText = $this.val();
								tagsStr = $( '.tag-name', $( this ) ).text();
								inputText = inputText.replace( _.last( array ), tagsStr );
								$this.val( inputText ).focus();
								tagsStr = "";
								$( '.search-res' ).addClass( "hidden" );
								$( '.search-res ul.ac_results li:not(".hidden")' ).remove();
							} );
						} );
					}, 1000 );
				} );

				/**
				 * On delete tag
				 */
				$( selector ).on( 'click', state._item + ' .tm-pg_tag-delete', function () {
					var $this = $( this ).parent(),
						ids = __( 'pg-right' ).ids,
						key = 0;
					state.tagAction( ids, $this.data( 'id' ), key, 'delete_term' );
				} );
			},
			/**
			 * Tag action
			 * 
			 * @param {type} ids
			 * @param {type} value
			 * @param {type} key
			 * @param {type} action
			 * @returns {undefined}
			 */
			tagAction: function ( ids, value, key, action ) {
				var $params = { },
					_content = __( 'pg-content' ),
					title;
				if ( value ) {
					$params.value = value;
					$params.id = ids[key];
					$params.action = action;
					$params.type = tm_pg_options.tax_names.tag;
					if ( _.isEqual( action, 'delete_term' ) ) {
						$params.field = 'term_taxonomy_id';
						title = $( state._item + '[data-id="' + value + '"] span' ).text();
					} else {
						$params.field = 'name';
						title = value;
					}
					// disable rightbar
					_content.toggleDisable( true );
					__( 'term' ).termAction( $params, function ( $data ) {
						state.callback( $data, ids, key, action, title );
						if ( !_.isUndefined( ids[++key] ) ) {
							state.tagAction( ids, value, key, action );
						}
					} );
				}
			},
			/**
			 * Callback
			 * 
			 * @param {type} $data
			 * @param {type} ids
			 * @param {type} key
			 * @param {type} action
			 * @param {type} title
			 * @returns {undefined}
			 */
			callback: function ( $data, ids, key, action, title ) {
				var $tags = { },
					id = ids[key],
					_content = __( 'pg-content' );
				_.each( $data, function ( tags ) {
					$tags = tags;
					_content.setContent( id, 'tags', tags );
				} );
				if ( _.isEqual( key, ids.length - 1 ) ) {
					$( __( 'pg-right' )._slidebar + ' ' + state._item ).remove();
					if ( ids.length > 1 && ids.length < 10 ) {
						__( 'term' ).addMultiTerms( 'tags' );
					} else {
						state.addTags( $tags );
					}
					// show right
					_content.toggleDisable( false );
					// show notofication
					if ( _.isEqual( action, 'delete_term' ) ) {
						__( 'notification' ).show( 'delete_tag', { name: title } );
					} else {
						__( 'notification' ).show( 'add_tag', { name: title } );
					}
				}
			},
			/**
			 * Search tag
			 * 
			 * @param {type} $params
			 * @param {type} callback
			 * @returns {undefined}
			 */
			searchTag: function ( $params, callback ) {

				var $args = {
					controller: "term",
					action: "search_term",
					tax: 'post_tag'
				};
				$.extend( $args, $params );
				__( 'common' ).wpAjax( $args,
					function ( data ) {
						if ( !_.isUndefined( callback ) && _.isFunction( callback ) ) {
							callback( data, $params );
						}
					},
					function ( data ) {
						console.warn( 'Some error!!!' );
						console.warn( data );
					}
				);
			},
			/**
			 * Add tags
			 * 
			 * @param {type} tags
			 * @returns {undefined}
			 */
			addTags: function ( tags ) {
				if ( _.isEmpty( tags ) ) {
					return false;
				}
				// set tags
				_.each( tags, function ( value ) {
					var item = $( state._clone ).clone();
					// set id
					item.children().attr( 'data-id', value.term_id );
					// set name
					$( 'span.name', item ).text( value.name );
					// add tag
					$( __( 'pg-right' )._slidebar + ' .tm-pg_sidebar_image-tags' ).append( item.children() );
				} );
			},
			/**
			 * Create search item element
			 * 
			 * @param {type} term
			 * @param {type} searchString
			 * @returns {undefined}
			 */
			buildSearchTags: function ( term, searchString ) {
				var item = $( $( '.search-res ul.ac_results li.hidden' )[0] ).clone();
				item.removeClass( "hidden" );
				var startPosition = term.name.indexOf( searchString );
				var endPosition = startPosition + searchString.length;
				item.attr( 'data-id', term.term_id );
				$( '.tag-name', item ).text( term.name );
				$( '.count', item ).text( term.count );

				if ( startPosition === 0 ) {
					$( '.ac_match', item ).text( term.name.substring( startPosition, endPosition ) );
					$( '.after', item ).text( term.name.substring( endPosition ) );
				} else {
					$( '.ac_match', item ).text( term.name.substring( startPosition, endPosition ) );
					$( '.before', item ).text( term.name.substring( 0, startPosition ) );
					$( '.after', item ).text( term.name.substring( endPosition ) );
				}
				$( '.search-res ul.ac_results' ).append( item );
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
