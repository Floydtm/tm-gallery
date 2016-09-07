<?php
/**
 * Image slidebar
 * 
 * @package templates/photo-gallery/slidebar 
 */
?>
<!-- Slidebar Clone -->
<div id="right-image-clone">
	<div class="tm-pg_sidebar_image_container hidden">
		<figure class="tm-pg_sidebar_image">
			<img src="" alt="img">

			<figcaption class="tm-pg_sidebar_image-description hidden">
				<p data-type="filename">
					<span class="name"><?php esc_attr_e( 'File name:', 'tm_gallery' ) ?></span>
					<span class="value"></span>
				</p>
				<p data-type="dimensions">
					<span class="name"><?php esc_attr_e( 'Dimensions:', 'tm_gallery' ) ?></span>
					<span class="value"></span>
				</p>
			</figcaption>
		</figure>
		<div class="tm-pg_hr"></div>
	</div>

	<h5 class="tm-pg_sidebar-title"><?php esc_attr_e( 'Main', 'tm_gallery' ) ?></h5>

	<div class="tm-pg_sidebar_image_main-description">
		<p>
			<label><span><?php esc_attr_e( 'Title', 'tm_gallery' ) ?></span></label>
			<input type="text" name="post_title" value="">
		</p>
		<p>
			<label><span><?php esc_attr_e( 'Description', 'tm_gallery' ) ?></span></label>
			<input type="text" name="post_content" value="">
		</p>
		<p style="display: none">
			<label><span><?php esc_attr_e( 'Link', 'tm_gallery' ) ?></span></label>
			<input type="text" name="link" value="" readonly="">
		</p>
	</div>

	<div class="tm-pg_hr"></div>

	<h5 class="tm-pg_sidebar-title"><?php esc_attr_e( 'Tags', 'tm_gallery' ) ?></h5>

	<div class="tm-pg_sidebar_image-tags_container">
		<div class="tm-pg_sidebar_image-tags">

		</div>

		<label><span><?php esc_attr_e( 'Add tags', 'tm_gallery' ) ?></span></label>
		<form class="tm-pg_input-button_group tm-pg_add-tags_form">

			<input type="text" name="title" value="">
			<button type="submit" class="tm-pg_btn tm-pg_btn-primary"><?php esc_attr_e( 'Add tags', 'tm_gallery' ) ?></button>
		</form>
		<small><?php esc_attr_e( '(Add tags separated by coma)', 'tm_gallery' ) ?></small>

	</div>

	<div class="tm-pg_hr"></div>

	<h5 class="tm-pg_sidebar-title"><?php esc_attr_e( 'Categories', 'tm_gallery' ) ?></h5>

	<div class="tm-pg_sidebar_image-categories_container">
		<div class="tm-pg_sidebar_image-categories ui tm-pg_ui tm-pg_checkbox tm-pg_checkbox-group" 
			 <?php echo empty( $data['categories'] ) ? 'style="display: none"' : 'style="display: block"' ?>>
				 <?php if ( !empty( $data['categories'] ) ) : ?>
					 <?php foreach ( $data['categories'] as $category ) : ?>
					<div class="tm-pg_checkbox-item tm-pg_checkbox-item_categoty">
						<input type="checkbox" id="image-category_<?php echo $category->term_id ?>" name="post_category[]" value="<?php echo $category->term_id ?>" />
						<label for="image-category_<?php echo $category->term_id ?>">
							<span class="checkbox"></span>
							<span class="name"><?php echo $category->name ?></span>

						</label>
						<a class="tm-pg_category-delete" href="#">
							<i class="material-icons">close</i>
						</a>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<label><span><?php esc_attr_e( 'Add categories', 'tm_gallery' ) ?></span></label>
		<form class="tm-pg_input-button_group tm-pg_add-categories_form">
			<input type="text" name="title" value="">
			<button type="submit" class="tm-pg_btn tm-pg_btn-primary"><?php esc_attr_e( 'Add new', 'tm_gallery' ) ?></button>
		</form>
		<small><?php esc_attr_e( '(Add categories separated by coma)', 'tm_gallery' ) ?></small>

	</div>

	<div data-type="album-container" class="hidden">
		<div class="tm-pg_hr"></div>
		<h5 class="tm-pg_sidebar-title"><?php esc_attr_e( 'Album', 'tm_gallery' ) ?></h5>

		<p>
		<div class="tm-pg_sidebar_image-albums">
		</div>

		<label><span><?php esc_attr_e( 'Add to album', 'tm_gallery' ) ?></span></label>

		<form class="tm-pg_input-button_group tm-pg_add-to-album_form">
			<select class="select2" data-placeholder="<?php esc_attr_e( 'Select a album', 'tm_gallery' ) ?>" >
			</select>
			<button type="submit" class="tm-pg_btn tm-pg_btn-primary"><?php esc_attr_e( 'Add album', 'tm_gallery' ) ?></button>
		</form>
		</p>
	</div>

	<div data-type="set-container" class="hidden">
		<div class="tm-pg_hr"></div>

		<h5 class="tm-pg_sidebar-title"><?php esc_attr_e( 'Set', 'tm_gallery' ) ?></h5>

		<p>
		<div class="tm-pg_sidebar_image-sets">
		</div>
		<label><span><?php esc_attr_e( 'Add to set', 'tm_gallery' ) ?></span></label>

		<form class="tm-pg_input-button_group tm-pg_add-to-set_form">
			<select class="select2" data-placeholder="<?php esc_attr_e( 'Select a set', 'tm_gallery' ) ?>" >
			</select>
			<button type="submit" class="tm-pg_btn tm-pg_btn-primary"><?php esc_attr_e( 'Add set', 'tm_gallery' ) ?></button>
		</form>
		</p>
	</div>
</div>