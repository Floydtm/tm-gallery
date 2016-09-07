<?php
/**
 * Gallery editor filters
 * 
 * @package templates/gallery/editor
 */
?>
<h6><?php esc_attr_e( 'Filter options', 'tm_gallery' ); ?></h6>
<div class="tm-pg_gallery_filters">
	<div class="tm-pg_gallery_filters_item" data-type="show">
		<div class="ui tm-pg_ui tm-pg_checkbox">
			<div class="tm-pg_checkbox-item">
				<input type="checkbox" name="show-filter" id="show-filter">
				<label for="show-filter">
					<span class="checkbox"></span>
					<span class="name">	<?php esc_attr_e( 'Show filter', 'tm_gallery' ); ?></span>
				</label>
			</div>
		</div>
	</div>
	<div class="tm-pg_gallery_filters_item" data-type="type">
		<div class="tm-pg_gallery_filters_item_label" >
			<label><span><?php esc_attr_e( 'Filter type', 'tm_gallery' ); ?></span></label>
		</div>
		<select class="select2" data-placeholder="<?php esc_attr_e( 'Choose filter type', 'tm_gallery' ) ?>" >
			<option value="line"><?php esc_attr_e( 'Line', 'tm_gallery' ); ?></option>
			<option value="dropdown"><?php esc_attr_e( 'Dropdown', 'tm_gallery' ); ?></option>
		</select>
	</div>
	<div class="tm-pg_gallery_filters_item" data-type="by">
		<div class="tm-pg_gallery_filters_item_label" >
			<label><span><?php esc_attr_e( 'Filter by', 'tm_gallery' ); ?></span></label>
		</div>
		<select class="select2" data-placeholder="<?php esc_attr_e( 'Choose filter type', 'tm_gallery' ) ?>" >
			<option value="category"><?php esc_attr_e( 'Category', 'tm_gallery' ); ?></option>
			<option value="tag"><?php esc_attr_e( 'Tag', 'tm_gallery' ); ?></option>
		</select>
	</div>
</div>