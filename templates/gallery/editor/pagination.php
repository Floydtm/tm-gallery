<?php
/**
 * Gallery editor pagination
 * 
 * @package templates/gallery/editor
 */
?>
<h6><?php esc_attr_e( 'Pagination options', 'tm_gallery' ); ?></h6>
<div class="tm-pg_gallery_pagination">
	<div class="tm-pg_gallery_pagination_item" data-type="show">
		<div class="ui tm-pg_ui tm-pg_checkbox">
			<div class="tm-pg_checkbox-item">
				<input type="checkbox" name="show-pagination" id="show-pagination">
				<label for="show-pagination">
					<span class="checkbox"></span>
					<span class="name">	<?php esc_attr_e( 'Show pagination', 'tm_gallery' ); ?></span>
				</label>
			</div>
		</div>
	</div>
	<div class="tm-pg_gallery_pagination_item" data-type="images_per_page">
		<div class="tm-pg_gallery_pagination_item_label" >
			<label><span><?php esc_attr_e( 'Images per page', 'tm_gallery' ); ?></span></label>
		</div>
		<select class="select2" data-placeholder="<?php esc_attr_e( 'Choose images per page', 'tm_gallery' ) ?>" >
			<option value="-1"><?php esc_attr_e( 'Infinity', 'tm_gallery' ) ?></option>
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
		</select>
	</div>
	<div class="tm-pg_gallery_pagination_item" data-type="load_more_btn">
		<div class="ui tm-pg_ui tm-pg_checkbox">
			<div class="tm-pg_checkbox-item">
				<input type="checkbox" name="load-more" id="load-more">
				<label for="load-more">
					<span class="checkbox"></span>
					<span class="name"> <?php esc_attr_e( 'Show "Load more" button ', 'tm_gallery' ); ?>
				</label>
			</div>
		</div>
	</div>
	<div class="tm-pg_gallery_pagination_item" data-type="load_more_grid">
		<div class="ui tm-pg_ui tm-pg_checkbox">
			<div class="tm-pg_checkbox-item">
				<input type="checkbox" name="load-more-img" id="load-more-img">
				<label for="load-more-img">
					<span class="checkbox"></span>
					<span class="name"><?php esc_attr_e( 'Show "Load more" grid', 'tm_gallery' ); ?></span>
				</label>
			</div>
		</div>
	</div>
	<div class="tm-pg_gallery_pagination_item" data-type="pagination_block">
		<div class="ui tm-pg_ui tm-pg_checkbox">
			<div class="tm-pg_checkbox-item">
				<input type="checkbox" name="load-more-page" id="load-more-page">
				<label for="load-more-page">
					<span class="checkbox"></span>
					<span class="name"><?php esc_attr_e( 'Show pagination block', 'tm_gallery' ); ?></span>
				</label>
			</div>
		</div>
	</div>
</div>