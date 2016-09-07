<?php
/**
 * Gallery editor content
 * 
 * @package templates\gallery\editor
 */
?>
<?php $this->render_html( 'gallery/editor/topbar/index' ); ?>

<div data-view="content">
	<div class="tm-pg_body-sidebar_container">
		<h6><?php esc_attr_e( 'Choose images for your gallery', 'tm_gallery' ); ?>:</h6>
		<!-- /Filter -->
		<div class="tm-pg-scroll-cotainer">
			<div id="tm-pg-grid">
				<?php $this->render_html( 'photo-gallery/grid/sets', array( 'colums' => 3 ) ); ?>
				<?php $this->render_html( 'photo-gallery/grid/albums', array( 'colums' => 4 ) ); ?>
				<?php $this->render_html( 'photo-gallery/grid/photos', array( 'colums' => 6 ) ); ?>
			</div>	
			<!-- Editor -->
			<div id="tm-pg-editor"></div>
		</div>
	</div>
	<?php $this->render_html( 'gallery/editor/slidebar/content' ); ?>
	<div class="clear"></div>
</div>
<div data-view="display" style="display: none">
	<div class="tm-pg_gallery_options_container tm-pg_gallery_options_container_display" >
		<?php $this->render_html( 'gallery/editor/display' ); ?>
	</div>
	<?php $this->render_html( 'gallery/editor/slidebar/display' ); ?>
</div>
<div data-view="filters" style="display: none">
	<div class="tm-pg_gallery_options_container">
		<?php $this->render_html( 'gallery/editor/filters' ); ?>
	</div>
</div>
<div data-view="pagination" style="display: none">
	<div class="tm-pg_gallery_options_container" >
		<?php $this->render_html( 'gallery/editor/pagination' ); ?>
	</div>
</div>
