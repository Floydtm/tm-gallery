<?php
/**
 * Cherry Breadcrumbs class
 * 
 * @package classes/shortcodes
 */

namespace tm_photo_gallery\classes\extensions;

use tm_photo_gallery\classes\lib\FB;
use tm_photo_gallery\classes\Core;

/**
 * Description of Cherry_Breadcrumbs
 */
class Breadcrumbs extends \Cherry_Breadcrumbs {

	/**
	 * Build breadcrumbs trail items array
	 */
	public function build_trail() {
		$this->is_extend = true;

		// do this for all other pages
		$this->add_network_home_link();
		$this->add_site_home_link();

		// do this for all other pages
		$this->add_single_folder();

		/* Add paged items if they exist. */
		$this->add_paged_items();

		/**
		 * Filter final item array
		 * @since  4.0.0
		 * @var    array
		 */
		$this->items = apply_filters( 'cherry_breadcrumbs_items', $this->items, $this->args );
	}

	/**
	 * Add single folder trailings
	 */
	private function add_single_folder() {
		global $post;
		if ( get_option( 'permalink_structure' ) ) {
			$post_parent = get_option( Core::PREFIX . "post_parent" );
			$set_parent	 = get_option( Core::PREFIX . "set_parent" );
		} else {
			$post_parent = isset( $_GET['parent'] ) ? $_GET['parent'] : 0;
			$set_parent	 = isset( $_GET['set'] ) ? $_GET['set'] : 0;
		}
		if ( !empty( $post_parent ) ) {
			$parent = get_post( $post_parent );
			if ( !empty( $parent ) ) {
				$this->_add_item( 'link_format', $parent->post_title, get_permalink( $parent->ID ) );
			}
		}
		if ( !empty( $set_parent ) && !empty($post_parent) ) {
			$set = get_post( $set_parent );
			if ( !empty( $set ) ) {
				$this->_add_item( 'link_format', $set->post_title, get_permalink( $set->ID ) );
			}
		}

		$this->_add_item( 'target_format', get_the_title( $post->ID ) );
		$this->page_title = false;
	}

}
