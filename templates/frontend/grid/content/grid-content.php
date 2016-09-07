<?php
/**
 * Frontend grid content
 * 
 * @package templates/frontend/grid/actions
 */
?>
<div class="tm-pg_front_gallery-grid <?php echo apply_filters( 'tm-pg-gallery-list-class', '' ) ?>" 
	 data-load-more-img="<?php echo $data->pagination['load_more_btn'] ?>">
	<div class="row">
		<?php do_action( 'tm-pg-grid-posts', $data ); ?>
	</div>
</div>
