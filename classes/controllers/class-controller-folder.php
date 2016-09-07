<?php
/**
 * Controller_Folder
 * 
 * @package classes/controllers
 */

namespace tm_photo_gallery\classes\controllers;

use tm_photo_gallery\classes\Controller;

/**
 * Controller folder
 */
class Controller_Folder extends Controller {

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
	 * Action get albums
	 */
	public function action_get_albums() {
		$data					 = array();
		// get albums
		$data['data']['posts']	 = $this( 'album' )->get_albums( array( 'show_all' => 1 ) );
		$data['success']		 = true;
		$this->send_json( $data );
	}

	/**
	 * Actiom get sets
	 */
	public function action_get_sets() {
		$data					 = array();
		// get sets
		$data['data']['posts']	 = $this( 'set' )->get_sets();
		$data['success']		 = true;
		$this->send_json( $data );
	}

	/**
	 * Action update folder
	 */
	public function action_update() {
		$data = $this( 'folder', true )->get_content( $_POST );
		$this->send_json( $data );
	}

	/**
	 * Action add set or album
	 */
	public function action_add_folder() {
		$return = $this( 'folder', true )->add_folder( $_POST );
		$this->send_json( $return );
	}

	/**
	 * Action change cover
	 */
	public function action_change_cover() {
		$return = $this( 'folder', true )->update_cover( $_REQUEST );
		$this->send_json( $return );
	}

	/**
	 * Action add to folder
	 */
	public function action_add_to_folder() {
		$result = $this( 'folder', true )->set_folder_content( array(
			'id'	 => $_POST['id'],
			'value'	 => $_POST['value'],
			'action' => $_POST[self::ACTION]
		) );
		$this->send_json( $result );
	}

	/**
	 * Action add to folder
	 */
	public function action_delete_from_folder() {
		$result = $this( 'folder', true )->set_folder_content( array(
			'id'	 => $_POST['id'],
			'value'	 => $_POST['value'],
			'action' => $_POST[self::ACTION]
		) );
		$this->send_json( $result );
	}

}
