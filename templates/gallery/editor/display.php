<?php
/**
 * Gallery editor display
 * 
 * @package templates/gallery/editor
 */
?>
<h6><?php esc_attr_e( 'Choose display type for your gallery', 'tm_gallery' ); ?></h6>
<div class="tm-pg_gallery_display-type tm-pg_grid tm-pg_columns-4">
	<div class="tm-pg_gallery_display-type_item tm-pg_column">
		<a href="#" class="tm-pg_gallery_display-type_grid" data-type="grid">
			<div class="tm-pg_gallery_display-type_image">
				<img src="<?php echo TM_PG_MEDIA_URL ?>icons/display_grid.svg">
			</div>
			<?php esc_attr_e( 'Grid', 'tm_gallery' ); ?>
		</a>
	</div>

	<div class="tm-pg_gallery_display-type_item tm-pg_column">
		<a href="#" class="tm-pg_gallery_display-type_masonry" data-type="masonry">
			<div class="tm-pg_gallery_display-type_image">
				<img src="<?php echo TM_PG_MEDIA_URL ?>icons/display_masonry.svg">
			</div>
			<?php esc_attr_e( 'Masonry', 'tm_gallery' ); ?>		
		</a>
	</div>

	<div class="tm-pg_gallery_display-type_item tm-pg_column">
		<a href="#" class="tm-pg_gallery_display-type_justify" data-type="justify">
			<div class="tm-pg_gallery_display-type_image">
				<img src="<?php echo TM_PG_MEDIA_URL ?>icons/display_masonry.svg">
			</div>
			<?php esc_attr_e( 'Justify', 'tm_gallery' ); ?>		
		</a>
	</div>
</div>