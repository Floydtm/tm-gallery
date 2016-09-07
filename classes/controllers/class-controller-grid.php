<?php
/**
 * Controller frontend Grid
 * 
 * @package classes/controllers
 */

namespace tm_photo_gallery\classes\controllers;

use tm_photo_gallery\classes\frontend\Grid;
use tm_photo_gallery\classes\structure\Gallery as Single_Gallery;
use tm_photo_gallery\classes\lib\FB;

/**
 * Controller frontend grid
 */
class Controller_Grid extends \tm_photo_gallery\classes\Controller {

	/**
	 * Intence
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
	 * Action filter
	 */
	public function action_filter_grid() {
		$gallery = new Single_Gallery( $_POST['id'], array(
			'pagination',
			'filter',
			'grid',
			'terms',
			'img_count'
		) );
		if ( !empty( $_POST['term_id'] ) && $_POST['term_id'] != 'all' ) {
			$gallery->posts = $gallery->sort_gallery_by_term_id( $_POST['term_id'], true );
		}
		// render justify
		if ( 'justify' == $gallery->grid['type'] ) {
			$html = Grid::get_instance()->render_justify_rows( $gallery, 4 );
		} else {
			$html = Grid::get_instance()->render_grid_html( $gallery );
		}
		$this->send_json( $this( 'model' )->get_arr( $html, true ) );
	}

	/**
	 * Action get content
	 */
	public function action_get_content() {
		$gallery						 = new Single_Gallery( $_POST['id'], array(
			'pagination',
			'filter',
			'grid',
			'terms',
			'img_count'
		) );
		$gallery->pagination['offset']	 = $_POST['offset'];
		if ( !empty( $_POST['term_id'] ) && $_POST['term_id'] != 'all' ) {
			$gallery->posts = $gallery->sort_gallery_by_term_id( $_POST['term_id'], true );
		}
		// render justify
		if ( 'justify' == $gallery->grid['type'] ) {
			$html = Grid::get_instance()->render_justify_rows( $gallery, 4 );
		} else {
			$html = Grid::get_instance()->render_grid_html( $gallery );
		}
		$this->send_json( $this( 'model' )->get_arr( $html, true ) );
	}

	/**
	 * Action get pagination
	 */
	public function action_get_pagination() {
		$gallery = new Single_Gallery( $_POST['id'], array(
			'pagination',
			'filter',
			'grid',
			'terms',
			'img_count'
		) );
		if ( !empty( $_POST['term_id'] ) && $_POST['term_id'] != 'all' ) {
			$gallery->posts = $gallery->sort_gallery_by_term_id( $_POST['term_id'] );
		}
		// get pagination html
		$html = $this->get_view()->render_html( 'frontend/grid/pagination', array(
			'count'		 => $gallery->get_pagination_count(),
			'current'	 => 0,
		), false );
		$this->send_json( $this( 'model' )->get_arr( $html, true ) );
	}

}
