<?php
/**
 * Structure
 * 
 * @package classes
 */

namespace tm_photo_gallery\classes;

use tm_photo_gallery\classes\Core;
use tm_photo_gallery\classes\structure\Grid;
use tm_photo_gallery\classes\structure\Filter;
use tm_photo_gallery\classes\structure\Pagination;
use tm_photo_gallery\classes\lib\FB;

/**
 * Description of Structure
 *
 * @author gellios3
 */
class Structure {

	/**
	 * ID 
	 * 
	 * @var type 
	 */
	public $id;

	/**
	 * Date 
	 *
	 * @var type 
	 */
	public $date;

	/**
	 * Post
	 * 
	 * @var type 
	 */
	public $post;

	/**
	 * Grid
	 * 
	 * @var type 
	 */
	public $grid;

	/**
	 * Filter
	 * 
	 * @var type 
	 */
	public $filter;

	/**
	 * pagination
	 * 
	 * @var type 
	 */
	public $pagination;

	/**
	 * Construct
	 * 
	 * @param type $id
	 */
	public function __construct( $id ) {
		$this->id	 = $id;
		$this->post	 = get_object_vars( get_post( $id ) );
		$this->date	 = $this->get_date();
	}
	
	/**
	 * Get pagination
	 * 
	 * @return type
	 */
	protected function get_pagination() {
		$pagination = new Pagination( $this->id );
		return get_object_vars( $pagination );
	}

	/**
	 * Get filter
	 */
	protected function get_filter() {
		$filter = new Filter( $this->id );
		return get_object_vars( $filter );
	}

	/**
	 * Get date
	 * 
	 * @return type
	 */
	protected function get_date() {
		return mysql2date( esc_attr__( 'F j, Y' ), $this->post['post_date'] );
	}

	/**
	 * Get grid
	 * 
	 * @return type
	 */
	protected function get_grid() {
		$grid = new Grid( $this->id );
		return get_object_vars( $grid );
	}

	/**
	 * Get model
	 * 
	 * @param type $type
	 * @return type
	 */
	protected function model( $type ) {
		return Core::get_instance()->get_model( $type );
	}

	/**
	 * Get post meta
	 * 
	 * @param type $key
	 * @return type
	 */
	protected function get_post_meta( $key, $single = true ) {
		return $this->model( 'model' )->get_post_meta( $this->id, $key, $single );
	}

	/**
	 * Update post meta
	 * 
	 * @param type $key
	 * @param type $value
	 * @return type
	 */
	protected function update_post_meta( $key, $value ) {
		return $this->model( 'model' )->$this->update_post_meta( $this->id, $key, $value );
	}

}
