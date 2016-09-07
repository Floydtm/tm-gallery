<?php
/**
 * Frontend grid content
 * 
 * @package templates/frontend/grid/actions
 */
?>
<div class="tm-pg_front_gallery-justify <?php echo apply_filters( 'tm-pg-gallery-list-class', '' ) ?>" 
	 data-load-more-img="<?php echo $data->pagination['load_more_btn'] ?>">
	<?php do_action( 'tm-pg-justify-rows', $data, 4 ); ?>
</div>
