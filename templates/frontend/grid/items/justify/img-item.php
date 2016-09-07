<?php
/**
 * Image item
 *
 * @package templates/frontend/grid/items
 */
?>
<div class="tm_pg_gallery-item <?php echo apply_filters( 'tm-pg-gallery-item-class', '' ) ?>" 
	 data-id="<?php echo $data->ID ?>" data-type="img">
		 <?php $image	 = image_downsize( $data->ID, 'copy' ) ?>
	<a href="<?php echo $image[0] ?>" class="tm_pg_gallery-item_link" data-effect="fadeIn">
		<?php $image	 = image_downsize( $data->ID, 'justify' ) ?>
		<img src="<?php echo $image[0] ?>">
	</a>
</div>
