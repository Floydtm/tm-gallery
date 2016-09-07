<?php
/**
 * Set item
 * 
 * @package templates/frontend/grid/items
 */
?>
<div class="tm_pg_gallery-item <?php echo apply_filters( 'tm-pg-gallery-item-class', '' ) ?>" 
	 data-id="<?php echo $data->ID ?>" data-type="set">
	<a href="<?php do_action( 'tm-pg-the_post_link', $data ) ?>" class="tm_pg_gallery-item_link" data-effect="fadeIn">
		<img src="<?php echo!empty( $data->cover[0] ) ? $data->cover[0] : TM_PG_IMG_URL . 'no-image.png' ?>">
	</a>
	<div>
		<h3>Set</h3>
	</div>
</div>