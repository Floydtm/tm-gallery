<?php
/**
 * Grid model
 * 
 * @package classes/models/frontend
 */

namespace tm_photo_gallery\classes\frontend;

use tm_photo_gallery\classes\Model as Model;
use tm_photo_gallery\classes\structure\Album as Single_Album;
use tm_photo_gallery\classes\structure\Set as Single_Set;
use tm_photo_gallery\classes\extensions\Breadcrumbs;
use tm_photo_gallery\classes\lib\FB;

/**
 * Grid model class
 */
class Grid extends Model {

	/**
	 * Const gallery class
	 */
	const gallery_class = 'tm_photo_gallery\classes\structure\Gallery';

	/**
	 * Grid row 
	 * 
	 * @var type 
	 */
	private $row = array();

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
	 * Init actions
	 */
	public static function init_actions() {
		// add filter actions
		self::init_action( 'grid-preloader', 'render_preloader' );
		// add filter actions
		self::init_action( 'grid-filters', 'render_filters' );
		// add filter actions
		self::init_action( 'grid-filter', 'render_filter' );
		// add content actions
		self::init_action( 'grid-content', 'render_content' );
		// add content actions
		self::init_action( 'grid-pagination', 'render_pagination' );
		// add album actions
		self::init_action( 'grid-album', 'render_album' );
		// add set actions
		self::init_action( 'grid-set', 'render_set' );
		// add posts actions
		self::init_action( 'grid-posts', 'render_grid_html', 3 );
		// add posts pagination actions
		self::init_action( 'grid-pagination-block', 'render_gallery_pagination' );
		// add justify rows actions
		self::init_action( 'justify-rows', 'render_justify_rows', 2 );
		// add post link action
		self::add_action( 'the_post_link', 'the_post_link', 'grid' );
	}

	/**
	 * Init action
	 * 
	 * @param type $name
	 * @param type $function
	 * @param type $accepted_args
	 */
	private static function init_action( $name, $function, $accepted_args = 1 ) {
		// add filter actions
		self::add_action( $name, $function, 'grid', 10, $accepted_args );
	}

	/**
	 * Render preloader
	 */
	public function render_preloader() {
		$this->get_view()->render_action_html( 'frontend/grid/preloader' );
	}

	/**
	 * Post type
	 * 
	 * @param type $data
	 */
	public function the_post_link( $data ) {
		$return = get_permalink( $data->ID );
		if ( get_option( 'permalink_structure' ) ) {
			$post_parent = get_option( self::PREFIX . "post_parent" );
		} else {
			$post_parent = $_GET['parent'];
		}
		if ( isset( $data->parent ) ) {
			if ( !empty( $post_parent ) ) {
				if ( get_option( 'permalink_structure' ) ) {
					$return .= "{$post_parent}/{$data->parent}/";
				} else {
					$return = add_query_arg( array(
						'parent'	 => $post_parent,
						'set'	 => $data->parent
					), $return );
				}
			} else {
				if ( get_option( 'permalink_structure' ) ) {
					$return .= "{$data->parent}/";
				} else {
					$return = add_query_arg( array(
						'parent' => $data->parent
					), $return );
				}
			}
		}
		echo $return;
	}

	/**
	 * Cherry breadcrumbs 
	 * 
	 * @param type $is_custom_breadcrumbs - default custom breadcrums trigger. 
	 * @param type $args
	 */
	public function cherry_breadcrumbs( $is_custom_breadcrumbs, $args ) {
		$return = $is_custom_breadcrumbs;
		// check if is gallery page
		if ( $this->is_gallery() ) {
			// inclide breadcrumbs class
			if ( !class_exists( 'tm_photo_gallery\classes\extensions\Breadcrumbs' ) ) {
				require_once TM_PG_CLASSES_PATH . 'extensions/class-cherry-breadcrumbs.php';
			}
			$breadcrums	 = new Breadcrumbs( false, $args );
			$return		 = array( 'items' => $breadcrums->items, 'page_title' => $breadcrums->page_title );
		}
		return $return;
	}

	/**
	 * Render filters
	 *
	 * @param type $data
	 */
	public function render_filters( $data ) {
		$this->get_view()->render_action_html( 'frontend/grid/filters', $data );
	}

	/**
	 * Render filter
	 * 
	 * @param type $data
	 */
	public function render_filter( $data ) {
		$this->get_view()->render_action_html( 'frontend/grid/items/filter', $data );
	}

	/**
	 * Render content
	 *
	 * @param type $data
	 */
	public function render_content( $data ) {
		// get view type
		$type = $data->grid['type'];
		$this->get_view()->render_action_html( "frontend/grid/content/$type-content", $data );
	}

	/**
	 * Render pagination
	 *
	 * @param type $data
	 */
	public function render_pagination( $data ) {
		if ( (int) ($data->posts_count) < (int) ($data->pagination['images_per_page']) ) {
			$data->pagination['show'] = 0;
		}
		$this->get_view()->render_action_html( 'frontend/grid/pagination-block', $data );
	}

	/**
	 * Show pagination
	 *
	 * @param type $posts
	 * @param type $pagination
	 * @param type $output
	 */
	public function render_gallery_pagination( $data ) {
		$params['current']	 = isset( $_POST['grid_page'] ) ? $_POST['grid_page'] : 0;
		$params['count']	 = $data->get_pagination_count();
		$this->get_view()->render_action_html( 'frontend/grid/pagination', $params );
	}

	/**
	 * Render justify rows
	 * 
	 * @param type $data
	 * @param type $colums
	 */
	public function render_justify_rows( $data, $colums ) {
		$this->row = array();
		$this->render_justify_row( $data, $colums, 0 );
		return $this->row;
	}

	/**
	 * Render justify row
	 * 
	 * @param type $data
	 * @param type $colums
	 * @param type $pos
	 */
	private function render_justify_row( $data, $colums, $pos, $step = 4 ) {
		// return html if ajax
		$output = true;
		if ( $this->is_ajax() ) {
			$output = false;
		}
		$i = $pos;
		if ( $i > 0 ) {
			$colums = $colums + $step;
		}
		$posts		 = array_values( $data->get_posts( true ) );
		$row_posts	 = array();
		while ( $i < $colums ) {
			if ( !empty( $posts[$i] ) ) {
				$row_posts[$i] = $posts[$i];
			}
			$i++;
		}
		if ( !empty( $row_posts ) ) {
			$this->row[] = $this->get_view()->render_action_html( 'frontend/grid/items/justify/row', array(
				'obj'	 => $data,
				'posts'	 => array_values( $row_posts )
			), $output );
			if ( $colums < count( $posts ) ) {
				$this->render_justify_row( $data, $colums, $i );
			}
		}
	}

	/**
	 * Render grid html 
	 * 
	 * @param type $data
	 * @param type $posts
	 * @return type
	 */
	public function render_grid_html( $data, $posts = false, $output = null ) {
		if ( $this->is_ajax() && isset( $_POST['post_id'] ) ) {
			$_post = get_post( $_POST['post_id'] );
		} else {
			$_post = get_post();
		}
		if ( is_null( $output ) ) {
			$output = true;
			// return html if ajax
			if ( $this->is_ajax() ) {
				$output = false;
			}
		}
		$return	 = array();
		$_images = array();
		$_albums = array();
		$_sets	 = array();
		$_posts	 = array();
		// get pagination posts
		$_ids	 = empty( $posts ) ? $data->get_posts( true ) : array_values( $posts );
		// get images
		if ( !empty( $_ids ) ) {
			$_images = get_posts( $this( 'media' )->get_content_params( array( 'post__in' => $_ids ) ) );
			// get albums
			$_albums = get_posts( $this( 'album' )->get_content_params( array( 'post__in' => $_ids ) ) );
			// sets
			$_sets	 = get_posts( $this( 'set' )->get_content_params( array( 'post__in' => $_ids ) ) );
		}
		// merge all posts
		$_posts	 = array_merge( $_images, $_albums, $_sets );
		// calck end key
		end( $_posts );
		$end_key = key( $_posts );
		// get view type
		$type	 = $data->grid['type'];
		// render grid items 
		foreach ( $_posts as $key => $post ) {
			$post->size		 = 12 / $data->grid['colums'];
			$post->parent	 = $_post->ID;
			// get items html
			switch ( $post->post_type ) {
				case self::$post_types['image']:
					$return[]	 = $this->get_view()->render_action_html( "frontend/grid/items/{$type}/img-item", $post, $output );
					break;
				case self::$post_types['album']:
					$post->cover = $this( 'album' )->get_cover_img( $post->ID, $type );
					$return[]	 = $this->get_view()->render_action_html( "frontend/grid/items/{$type}/album-item", $post, $output );
					break;
				case self::$post_types['set']:
					$post->cover = $this( 'set' )->get_cover_img( $post->ID, $type );
					$return[]	 = $this->get_view()->render_action_html( "frontend/grid/items/{$type}/set-item", $post, $output );
					break;
			}
			// check visible load more btn
			if ( empty( $posts ) && $key == $end_key ) {
				$return[] = $this->get_load_more_html( $data, $output, $post );
			} else {
				// check jistify end position
				$all_posts	 = $data->get_posts( true );
				end( $all_posts );
				$_end_key	 = key( $all_posts );
				if ( $all_posts[$_end_key] == $posts[$key] ) {
					$return[] = $this->get_load_more_html( $data, $output, $post );
				}
			}
		}
		return $return;
	}

	/**
	 * Get load more html
	 * 
	 * @param type $data
	 * @param type $output
	 * @param type $post
	 * @return type
	 */
	private function get_load_more_html( $data, $output, $post ) {
		if ( (int) ($data->posts_count) < (int) ($data->pagination['images_per_page']) ) {
			$data->pagination['show'] = 0;
		}
		if ( $data->pagination['show'] && $data->pagination['load_more_grid'] ) {
			$type = $data->grid['type'];
			if ( count( $data->sort_gallery_by_term_id() ) > $data->pagination['images_per_page'] ) {
				$post->load_more = $data->pagination['load_more_grid'];
			}
			return $this->get_view()->render_action_html( "frontend/grid/items/{$type}/more-item", $post, $output );
		}
	}

	/**
	 * Render album html
	 *
	 * @param type $id
	 */
	public function render_album( $id ) {
		$data = new Single_Album( $id, array( 'cover', 'grid' ) );
		$this->get_view()->render_action_html( 'frontend/grid/index', $data );
	}

	/**
	 * Render set html
	 *
	 * @param type $id
	 */
	public function render_set( $id ) {
		$data	 = array();
		$data	 = new Single_Set( $id, array( 'cover', 'grid' ) );
		$this->get_view()->render_action_html( 'frontend/grid/index', $data );
	}

}
