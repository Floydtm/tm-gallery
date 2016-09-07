<?php
/*
 * Gallery structure
 *
 * @package classes\structure
 */

namespace tm_photo_gallery\classes\structure;

use tm_photo_gallery\classes\Structure;
use tm_photo_gallery\classes\Core;
use tm_photo_gallery\classes\lib\FB;

/**
 * Gallery class
 */
class Gallery extends Structure {

	/**
	 * Default args
	 *
	 * @var type
	 */
	private $default_args = array(
		'pagination',
		'filter',
		'grid',
		'cover',
		'terms',
		'img_count',
	);

	/**
	 * Cover
	 *
	 * @var type
	 */
	public $cover;

	/**
	 * Types
	 *
	 * @var type
	 */
	private $types = array( 'img', 'album', 'set' );

	/**
	 * Childs array
	 *
	 * @var type
	 */
	public $childs_arr = array();

	/**
	 * Childs
	 *
	 * @var type
	 */
	public $childs = array(
		'img'	 => array(),
		'album'	 => array(),
		'set'	 => array(),
	);

	/**
	 * All posts
	 *
	 * @var type
	 */
	public $posts = array();

	/**
	 * Img count
	 *
	 * @var type
	 */
	public $img_count = 0;

	/**
	 * Posts counts
	 *
	 * @var type
	 */
	public $posts_count = 0;

	/**
	 * Current term id
	 *
	 * @var type
	 */
	public $term_id = 0;

	/*
	 * Sortable terms
	 *
     * @var type
	 */
	public $terms = array();

	/**
	 * Construct
	 *
	 * @param type $id
	 */
	public function __construct( $id, $args ) {
		parent::__construct( $id );
		$this->childs		 = $this->get_childs();
		$this->posts_count	 = $this->get_posts_count();
		$this->init( $args );
	}

	/**
	 * Init gallery
	 */
	public function init( $args = false ) {
		$args = ! is_array( $args ) ? $this->default_args : $args;
		// get gallery cover
		if ( in_array( 'cover', $args ) ) {
			$this->cover = $this->get_cover();
		}
		if ( in_array( 'img_count', $args ) ) {
			$this->img_count = $this->get_img_count();
		}
		// get frontend grid
		if ( in_array( 'grid', $args ) ) {
			$this->grid = $this->get_grid();
		}
		// get frontend filter
		if ( in_array( 'filter', $args ) ) {
			$this->filter = $this->get_filter();
		}
		// get frront end pagination
		if ( in_array( 'pagination', $args ) ) {
			$this->pagination = $this->get_pagination();
		}
		// get gallery tems
		if ( in_array( 'terms', $args ) ) {
			$this->terms = $this->get_filter_terms();
		}
	}

	/**
	 * Get filter terms
	 *
	 * @return type
	 */
	private function get_filter_terms() {
		return $this->get_sortable_terms();
	}

	/**
	 * Get img count
	 *
	 * @return type
	 */
	private function get_img_count() {
		$_img_count	 = 0;
		$childs		 = $this->get_post_meta( 'terms' );
		if ( ! empty( $childs ) ) {
			foreach ( $childs as $type => $_childs ) {
				foreach ( $_childs as $child ) {
					if ( 'img' !== $type ) {
						$_img_count += $this->model( $type )->get_img_count( $child );
					} else {
						$_img_count++;
					}
				}
			}
		}
		return $_img_count;
	}

	/**
	 * Get childs
	 *
	 * @return type
	 */
	private function get_childs() {
		$childs	 = $this->get_post_meta( 'terms' );
		$return	 = $this->childs;
		if ( ! empty( $childs ) ) {
			foreach ( $childs as $type => $arr ) {
				$return[ $type ] = array_map( 'intval', $arr );
			}
		}
		return $return;
	}

	/**
	 * Set cover
	 *
	 * @return type
	 */
	public function get_cover() {
		$image_downsize = '';
		if ( ! empty( $this->childs['set'] ) ) {
			foreach ( $this->childs['set'] as $id ) {
				$image_downsize = $this->model( 'set' )->get_cover_img( $id, 'gallery' );
				if ( ! empty( $image_downsize ) ) {
					break;
				}
			}
		}
		if ( empty( $image_downsize ) && ! empty( $this->childs['album'] ) ) {
			foreach ( $this->childs['album'] as $id ) {
				$image_downsize = $this->model( 'album' )->get_cover_img( $id, 'gallery' );
				if ( ! empty( $image_downsize ) ) {
					break;
				}
			}
		}
		if ( empty( $image_downsize ) && ! empty( $this->childs['img'] ) ) {
			foreach ( $this->childs['img'] as $id ) {
				$image_downsize = image_downsize( $id, 'gallery' );
				if ( ! empty( $image_downsize ) ) {
					break;
				}
			}
		}
		return $image_downsize;
	}

	/**
	 * Get pagination count
	 *
	 * @return type
	 */
	public function get_pagination_count() {
		$count	 = count( $this->get_posts() );
		$return	 = (int) ($count / (int) ($this->pagination['images_per_page']));
		if ( $count > $this->pagination['images_per_page'] ) {
			if ( 0 != ($count % (int) ($this->pagination['images_per_page'])) ) {
				$return++;
			}
		}
		return $return;
	}

	/**
	 * Get posts count
	 *
	 * @return type
	 */
	public function get_posts_count() {
		$return = 0;
		foreach ( $this->types as $type ) {
			$return += count( $this->childs[ $type ] );
		}
		return $return;
	}

	/**
	 * Get all posts
	 *
	 * @return type
	 */
	public function get_all_posts() {
		$return = array();
		foreach ( $this->types as $type ) {
			$return = array_merge( $return, $this->childs[ $type ] );
		}
		return $return;
	}

	/**
	 * Get all posts
	 *
	 * @param type $pagination
	 * @return type
	 */
	public function get_posts( $pagination = false ) {
		if ( empty( $this->posts ) ) {
			$return = $this->get_all_posts();
			if ( $pagination ) {
				$return = $this->model( 'model' )->get_pagination_arr( $return, $this->pagination['images_per_page'], $this->pagination['offset'] );
			}
		} else {
			$return = $this->posts;
		}
		return $return;
	}

	/**
	 * Get sortable terms
	 *
	 * @param type $gallery_id
	 * @param type $filters
	 * @param type $gallery_post_ids
	 * @return type
	 */
	public function get_sortable_terms() {
		// get terms if show filter
		$_terms = array();
		if ( $this->filter['show'] ) {
			$posts = $this->get_posts();
			$_terms = $this->model( 'term' )->get_posts_terms( $posts, Core::$tax_names[ $this->filter['by'] ] );
		}
		if ( ! empty( $_terms ) ) {
			// set curent gallery terms count
			foreach ( $_terms as $key => $term ) {
				$_posts = $this->sort_gallery_by_term_id( $term->term_id );
				if ( empty( $_posts ) ) {
					unset( $_terms[ $key ] );
				} else {
					$_terms[ $key ]->count = count( $_posts );
				}
			}
		}
		return $_terms;
	}

	/**
	 * Sort gallery by term_id
	 *
	 * @param type $term_id
	 */
	public function sort_gallery_by_term_id( $term_id = 0, $pagination = false ) {
		// check term id
		if ( Core::is_ajax() && ! $term_id ) {
			$term_id = $this->term_id;
		} else {
			$this->term_id = $term_id;
		}
		// sort gallery if isset term id
		if ( ! $term_id ) {
			$ids = $this->get_posts( $pagination );
		} else {
			$ids		 = array();
			$term_posts	 = $this->model( 'term' )->get_posts_by_term_id( $term_id, $this->filter['by'] );
			foreach ( $this->get_all_posts() as $id ) {
				foreach ( $term_posts as $t_id ) {
					if ( $id == $t_id ) {
						$ids[] = $id;
					}
				}
			}
			if ( $pagination ) {
				// get pagination posts
				$ids = $this->model( 'model' )->get_pagination_arr( $ids, $this->pagination['images_per_page'], $this->pagination['offset'] );
			}
		}
		return $ids;
	}
}
