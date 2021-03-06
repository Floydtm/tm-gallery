<?php
/**
 * Photos grid
 *
 * @package templates/photo-gallery/grid
 */
?>
<!-- Photos -->
<div data-id="photos">
	<div  class="tm-pg_library accordion" >
		<?php $this->render_html( 'photo-gallery/grid/header', array( 'title' => esc_attr( 'Photos', 'tm_gallery' ) ) ); ?> 
		<div class="accordion-content" data-type="img">
			<div class="tm-pg_upload_container"></div>
			<div style="display: flex;">
				<a class="tm-pg_library_grid_header_select_all" href="#">
					<i class="material-icons">check_circle</i>
					<span ><?php esc_attr_e( 'Select all', 'tm_gallery' ) ?></span>
				</a>
			</div>
			<div class="tm-pg_library_grid tm-pg_grid tm-pg_columns-<?php echo $data['colums'] ?>  tm-pg_library_photos " style="display: none">
				<div class="tm-pg_column">
					<div class="tm-pg_library_item_add" data-type="img">
						<a href="#" class="tm-pg_add-item tm-pg_add-photo">
							<i class="material-icons">add</i>
							<?php esc_attr_e( 'Add Photo', 'tm_gallery' ) ?>                
						</a>
					</div>
				</div>
			</div>
			<div class="tm-pg-load-more" style="display: none">
				<a class="tm-pg_btn tm-pg_btn-primary" href="#"><?php esc_attr_e( 'Load more', 'tm_gallery' ) ?></a>
			</div>
		</div>      
	</div>
</div>
