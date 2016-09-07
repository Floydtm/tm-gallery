<?php
/**
 * Structure Gallery Grid
 *
 * @package classes/structure
 */

namespace tm_photo_gallery\classes\structure;

use tm_photo_gallery\classes\Core;

/**
 * Gallery Grid
 */
class Grid {

	/**
	 * Grid content
	 * 
	 * @var type 
	 */
	private $content;

	/**
	 * Grid pading
	 * 
	 * @var type 
	 */
	public $padding;

	/**
	 * Colums
	 * 
	 * @var type 
	 */
	public $colums;

	/**
	 * Grid type
	 * 
	 * @var type 
	 */
	public $type;

	/**
	 * Construct 
	 * 
	 * @param type $id
	 */
	public function __construct( $id ) {
		$this->content	 = Core::get_instance()->get_post_meta( $id, 'grid' );
		$this->padding	 = $this->get_padding();
		$this->colums	 = $this->get_colums();
		$this->type		 = $this->get_type();
	}

	/**
	 * Get padding
	 * 
	 * @param type $id
	 * @return int
	 */
	private function get_padding() {
		return !empty( $this->content['padding'] ) ? (int) ($this->content['padding']) : 5;
	}

	/**
	 * Get colums
	 * 
	 * @param type $id
	 * @return int
	 */
	private function get_colums(  ) {
		return !empty( $this->content['colums'] ) ? (int) ($this->content['colums']) : 3;
	}

	/**
	 * Get type
	 * 
	 * @param type $id
	 * @return type
	 */
	private function get_type(  ) {
		return !empty( $this->content['type'] ) ? $this->content['type'] : 'grid';
	}

}
