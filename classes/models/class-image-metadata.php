<?php
/**
 * Image metadata class
 * 
 * @package classes/models
 */

namespace tm_photo_gallery\classes\models;

/**
 * Image metadata class
 */
class Image_metadata extends \tm_photo_gallery\classes\Model {

	protected static $instance;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		parent::__construct();
		/**
		 * Include PHP JPEG Metadata Toolkit
		 */
		require_once( TM_PG_LIBS_PATH . 'PHP_JPEG_Metadata_Toolkit_1.12/JPEG.php' );
		require_once( TM_PG_LIBS_PATH . 'PHP_JPEG_Metadata_Toolkit_1.12/Photoshop_File_Info.php' );
		require_once( TM_PG_LIBS_PATH . 'PHP_JPEG_Metadata_Toolkit_1.12/EXIF.php' );
		require_once( TM_PG_LIBS_PATH . 'PHP_JPEG_Metadata_Toolkit_1.12/XMP.php' );
	}

	/**
	 * Get Img Meta Data
	 *
	 * @param type $filePath
	 *
	 * @return type
	 */
	public function get_img_meta_data( $filePath ) {
		
		// Retrieve the header information from the JPEG file
		$jpeg_header_data		 = get_jpeg_header_data( $filePath );
		// Retrieve EXIF information from the JPEG file
		$Exif_array				 = get_EXIF_JPEG( $filePath );
		// Retrieve XMP information from the JPEG file
		$XMP_array				 = read_XMP_array_from_text( get_XMP_text( $jpeg_header_data ) );
		// Retrieve Photoshop IRB information from the JPEG file
		$IRB_array				 = get_Photoshop_IRB( $jpeg_header_data );
		// Retrieve Photoshop File Info from the three previous arrays
		$new_ps_file_info_array	 = get_photoshop_file_info( $Exif_array, $XMP_array, $IRB_array );
		return $new_ps_file_info_array;
	}

	/**
	 * Set Img Meta Data
	 *
	 * @param $filePath
	 * @param $new_ps_file_info_array
	 *
	 * @return bool
	 */
	public function set_img_meta_data( $filePath, $new_ps_file_info_array ) {
		
		$jpeg_header_data = get_jpeg_header_data( $filePath );
		// Some characters are escaped with backslashes in HTML Posted variable
		// Cycle through each of the HTML Posted variables, and strip out the slashes
		foreach ( $new_ps_file_info_array as $var_key => $var_val ) {
			if ( is_string( $var_val ) ) {
				$new_ps_file_info_array[$var_key] = stripslashes( $var_val );
			}
		}

		// If empty capture date
		if ( empty( $new_ps_file_info_array['date'] ) ) {
			$new_ps_file_info_array['date'] = date( 'Y-m-d', time() );
		} else {
			$new_ps_file_info_array['date'] = date( 'Y-m-d', strtotime( $new_ps_file_info_array['date'] ) );
		}

		// Keywords should be an array - explode it on newline boundarys
		if ( !is_array( $new_ps_file_info_array['keywords'] ) ) {
			$new_ps_file_info_array['keywords'] = explode( "\n", trim( $new_ps_file_info_array['keywords'] ) );
		}

		// Supplemental Categories should be an array - explode it on newline boundarys
		if ( !is_array( $new_ps_file_info_array['supplementalcategories'] ) ) {
			$new_ps_file_info_array['supplementalcategories'] = explode( "\n", trim( $new_ps_file_info_array['supplementalcategories'] ) );
		}

		$new_ps_file_info_array['filename']	 = $filePath;
		// Protect against hackers editing other files
		$path_parts							 = pathinfo( $filePath );
		if ( 0 != strcasecmp( $path_parts['extension'], 'jpg' ) ) {
			return false;
		}
		// Retreive the EXIF, XMP and Photoshop IRB information from
		// the existing file, so that it can be updated
		$Exif_array			 = get_EXIF_JPEG( $filePath );
		$XMP_array			 = read_XMP_array_from_text( get_XMP_text( $jpeg_header_data ) );
		$IRB_array			 = get_Photoshop_IRB( $jpeg_header_data );
		// Update the JPEG header information with the new Photoshop File Info
		$jpeg_header_data	 = put_photoshop_file_info( $jpeg_header_data, $new_ps_file_info_array, $Exif_array, $XMP_array, $IRB_array );
		if ( $jpeg_header_data ) {
			$success = put_jpeg_header_data( $filePath, $filePath, $jpeg_header_data );
		} else {
			$success = false;
		}
		return $success;
	}

}
