<?php
/**
 * Image item
 *
 * @package templates/frontend/grid/items
 */
?>
<div class="tm_pg_gallery-item col-xs-6 col-lg-<?php echo $data->size . ' ' . apply_filters( 'tm-pg-gallery-item-class', '' ) ?>" 
	 data-id="<?php echo $data->ID ?>" data-type="img">
		 <?php $image	 = image_downsize( $data->ID, 'copy' ) ?>
	<a href="<?php echo $image[0] ?>" class="tm_pg_gallery-item_link" data-effect="fadeIn">
		<?php $image	 = image_downsize( $data->ID, 'grid' ) ?>
		<img src="<?php echo $image[0] ?>">
	</a>
</div>
