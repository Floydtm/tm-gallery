<?php
/**
 * Gallery editor topbar
 * 
 * @package templates\gallery\editor\topbar
 */
?>
<div class="tm-pg_body_container tm-pg_library_gallery_container">
	<div class="tm-pg_back-btn">
		<a class="tm-pg_btn tm-pg_btn-default tm-pg_btn_icon" href="#">
			<i class="material-icons">keyboard_backspace</i><?php esc_attr_e( 'Back', 'tm_gallery' ) ?>
		</a>
	</div>
	<div class="tm-pg_gallery_title">
		<div class="tm-pg_page-title">
			<h2></h2>
		</div>
		<div class="tm-pg_gallery_save">
			<a class="tm-pg_btn tm-pg_btn-primary" href="#"><?php esc_attr_e( 'Save gallery', 'tm_gallery' ) ?></a>
		</div>
	</div>
	<div class="tm-pg_gallery_title-tabs">
		<div class="tm-pg_gallery_tabs">
			<a class="active" href="#" data-type="images" ><?php esc_attr_e( 'Images', 'tm_gallery' ) ?></a>
			<a href="#" data-type="display" ><?php esc_attr_e( 'Display', 'tm_gallery' ) ?></a>
			<a href="#" data-type="filters" ><?php esc_attr_e( 'Filters', 'tm_gallery' ) ?></a>
			<a href="#" data-type="pagination" ><?php esc_attr_e( 'Pagination', 'tm_gallery' ) ?></a>
		</div>
	</div>
</div>