<?php
/**
 * View file
 *
 * @package classes
 */

namespace tm_photo_gallery\classes;

use tm_photo_gallery\classes\Core;
use tm_photo_gallery\classes\lib\FB;

/**
 * View class
 */
class View {

	/**
	 * data
	 *
	 * @var type
	 */
	private $data;

	/**
	 * instance
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
	 * Print footer scripts
	 */
	public function admin_print_footer_scripts() {
		$screen = get_current_screen();
		switch ( $screen->id ) {
			case 'tm-photo-gallery_page_gallery':
			case 'toplevel_page_tm_pg_media':
				$this->render_html( 'photo-gallery/editor' );
				$this->render_html( 'popups/dialog' );
				$this->render_html( 'photo-gallery/popup/index' );
				break;
		}
	}

	/**
	 * Render html
	 *
	 * @param string $template - template.
	 * @param array  $data - data.
	 * @param bool   $output : true - echo , false - return.
	 *
	 * @return type
	 */
	public function render_html( $template, $data = null, $output = true ) {
		if ( file_exists( $template ) ) {
			$includeFile = $template;
		} else {
			$includeFile = TM_PG_PLUGIN_PATH . 'templates/' . $template . '.php';
		}
		ob_start();
		if ( !empty( $data ) ) {
			$this->data = $data;
		}
		include( $includeFile );
		$out = ob_get_clean();
		if ( $output ) {
			echo $out;
		} else {
			return $out;
		}
	}

	/**
	 * Render action html 
	 * 
	 * @param type $template
	 * @param type $data
	 * @param type $output
	 * @return type
	 */
	public function render_action_html( $template, $data = null, $output = true ) {
		$theme_path = locate_template( Core::PREFIX . "$template.php" );
		if ( $theme_path ) {
			$return = $this->render_html( $theme_path, $data, $output );
		} else {
			$return = $this->render_html( $template, $data, $output );
		}
		return $return;
	}

	/**
	 * Render template html
	 * 
	 * @param type $template
	 */
	public function render_teplate_html( $template ) {
		$theme_path = locate_template( "$template.php" );
		if ( $theme_path ) {
			load_template( $theme_path );
		} else {
			load_template( TM_PG_PLUGIN_PATH . 'templates/' . $template . '.php' );
		}
	}

}
