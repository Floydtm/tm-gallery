<?php

/*
 * Album structure
 *
 * @package classes\structure
 */

namespace tm_photo_gallery\classes\structure;

use tm_photo_gallery\classes\Structure;
use tm_photo_gallery\classes\Core;
use tm_photo_gallery\classes\lib\FB;

/**
 * Album class
 */
class Album extends Structure {

	/**
	 * Default args
	 *
	 * @var type
	 */
	private $default_args = array(
		'pagination',
		'filter',
		'grid',
		'cover_img',
		'tags',
		'categories',
		'sets',
		'img_count',
		'cover_id',
	);

	/**
	 * Cover images
	 *
	 * @var type
	 */
	public $cover_img = array();

	/**
	 * Childs
	 *
	 * @var type
	 */
	public $childs = array(
		'img' => array(),
	);

	/**
	 * Posts
	 *
	 * @var type
	 */
	public $posts = array();

	/**
	 * Posts count
	 *
	 * @var type
	 */
	public $posts_count = 0;

	/**
	 * Tags
	 *
	 * @var type
	 */
	public $tags;

	/**
	 * Categories
	 *
	 * @var type
	 */
	public $categories;

	/**
	 * Sets
	 *
	 * @var type
	 */
	public $sets;

	/**
	 * Img count
	 */
	public $img_count;

	/**
	 * Cover id
	 *
	 * @var type
	 */
	public $cover_id;

	/**
	 * Contruct
	 *
	 * @param type $id
	 */
	public function __construct( $id, $args ) {
		parent::__construct( $id );
		$this->posts		 = $this->get_posts();
		$this->childs		 = $this->get_childs();
		$this->posts_count	 = count( $this->posts );
		$this->init( $args );
	}

	/**
	 * Init album
	 *
	 * @param type $args
	 */
	public function init( $args = false ) {
		$args = ! is_array( $args ) ? $this->default_args : $args;
		// get cover images
		if ( in_array( 'cover_img', $args ) ) {
			$this->cover_img = $this->model( 'folder' )->get_images( $this->id, 'album' );
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
		// get tags
		if ( in_array( 'tags', $args ) ) {
			$this->tags = wp_get_object_terms( $this->id, Core::$tax_names['tag'] );
		}
		// get categories
		if ( in_array( 'categories', $args ) ) {
			$this->categories = wp_get_object_terms( $this->id, Core::$tax_names['category'] );
		}
		// get album sets
		if ( in_array( 'sets', $args ) ) {
			$this->sets = $this->model( 'media' )->get_folders( $this->id, 'set' );
		}
		// get img count
		if ( in_array( 'img_count', $args ) ) {
			$this->img_count = $this->model( 'album' )->get_img_count( $this->id );
		}
		// get cover id
		if ( in_array( 'cover_id', $args ) ) {
			$this->cover_id = (int) ($this->model( 'folder' )->get_cover( $this->id ));
		}
	}

	/**
	 * Get cover
	 *
	 * @return type
	 */
	private function get_cover() {
		return $this->model( 'album' )->get_cover_img( $this->id, 'grid' );
	}

	/**
	 * Get childs
	 *
	 * @return type
	 */
	private function get_childs() {
		$ids	 = $this->get_posts();
		$posts	 = array();
		$return	 = array();
		if ( ! empty( $ids ) ) {
			$posts['img'] = get_posts( $this->model( 'media' )->get_content_params( array(
				'fields'	 => 'ids',
				'post__in'	 => $ids,
			) ) );
			if ( ! is_wp_error( $posts['img'] ) ) {
				for ( $i = count( $ids ); $i >= 0; $i-- ) {
					foreach ( $posts['img'] as $post_id ) {
						if ( ! empty( $ids[ $i ] ) && $post_id == $ids[ $i ] ) {
							$return['img'][] = $ids[ $i ];
						}
					}
				}
			}
		}
		return $return;
	}

	/**
	 * Get all posts
	 *
	 * @param type $pagination
	 * @return type
	 */
	public function get_posts() {
		return array_map( 'intval', get_post_meta( $this->id, Core::$post_types['album'], false ) );
	}
}
