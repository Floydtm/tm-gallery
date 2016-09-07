<?php
/*
 * Gallery pagination
 *
 * @package classes\structure
 */

namespace tm_photo_gallery\classes\structure;

use tm_photo_gallery\classes\Core;

/**
 * Gallery pagination
 */
class Pagination {

	/**
	 * Filter content
	 *
	 * @var type
	 */
	private $content;

	/**
	 * Show filter
	 *
	 * @var type
	 */
	public $show;

	/**
	 * Show load more button
	 *
	 * @var type
	 */
	public $load_more_btn;

	/**
	 * Show load more grid
	 *
	 * @var type
	 */
	public $load_more_grid;

	/**
	 * Show pagination block
	 *
	 * @var type
	 */
	public $pagination_block;

	/**
	 * offset
	 *
	 * @var type
	 */
	public $offset;

	/**
	 *
	 * @var type
	 */
	public $images_per_page;

	/**
	 *
	 * @param type $id
	 */
	public function __construct( $id ) {
		$this->content			 = Core::get_instance()->get_post_meta( $id, 'pagination' );
		$this->show				 = $this->get_show();
		$this->load_more_btn	 = $this->get_load_more_btn();
		$this->load_more_grid	 = $this->get_load_more_grid();
		$this->pagination_block	 = $this->get_pagination_block();
		$this->offset			 = $this->get_offset();
		$this->images_per_page	 = $this->get_images_per_page();
	}

	/**
	 * Get show
	 *
	 * @return int
	 */
	private function get_show() {
		if ( ! empty( $this->content ) && -1 !== (int) ($this->content['images_per_page']) ) {
			$show = is_string( $this->content['show'] ) ? (int) ($this->content['show']) : 1;
		} else {
			$show = 0;
		}
		return $show;
	}

	/**
	 * Get show
	 *
	 * @return int
	 */
	private function get_pagination_block() {
		return ! empty( $this->content ) && is_string( $this->content['pagination_block'] ) ? (int) ($this->content['pagination_block']) : 1;
	}

	/**
	 * Get load more grid
	 *
	 * @return int
	 */
	private function get_load_more_grid() {
		return ! empty( $this->content ) && is_string( $this->content['load_more_grid'] ) ? (int) ($this->content['load_more_grid']) : 1;
	}

	/**
	 * Get load more btn
	 *
	 * @return int
	 */
	private function get_load_more_btn() {
		return ! empty( $this->content ) && is_string( $this->content['load_more_btn'] ) ? (int) ($this->content['load_more_btn']) : 1;
	}

	/**
	 * Get padding
	 *
	 * @return int
	 */
	private function get_offset() {
		return ! empty( $this->content ) && is_string( $this->content['offset'] ) ? (int) ($this->content['offset']) : 0;
	}

	/**
	 * Get colums
	 *
	 * @return int
	 */
	private function get_images_per_page() {
		return ! empty( $this->content ) && is_string( $this->content['images_per_page'] ) ? (int) ($this->content['images_per_page']) : -1;
	}
}
