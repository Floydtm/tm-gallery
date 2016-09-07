<?php
/**
 * Shortcode grid class
 *
 * @package classes/shortcodes
 */

namespace tm_photo_gallery\classes\shortcodes;

use tm_photo_gallery\classes\Shortcode;
use tm_photo_gallery\classes\structure\Gallery;
use tm_photo_gallery\classes\lib\FB;

/**
 * Class shortcode grid
 */
class Shortcode_Grid extends Shortcode {

	/**
	 * Instance
	 *
	 * @var type
	 */
	protected static $instance;

	/**
	 * Get instance
	 *
	 * @return type
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Show shortcode
	 *
	 * @param type $params
	 */
	public function show_shortcode( $params ) {
		$data = new Gallery( $params['id'] , array( 'pagination', 'filter', 'grid', 'terms', 'img_count' ) );
		return $this->get_view()->render_action_html( 'frontend/grid/index', $data, false );
	}
}
