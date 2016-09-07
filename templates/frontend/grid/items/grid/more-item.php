<?php
/**
 * Load more item
 *
 * @package templates/frontend/grid/items
 */
?>
<div class="col-xs-6 col-lg-<?php echo $data->size ?> tm_pg_gallery-item_show-more" 
	<?php echo ! $data->load_more ? 'style="display: none"' : '' ?> >
	<a href="#" class="tm_pg_gallery-item_link_show-more">
		<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 66 66" height="117px" width="117px" class="preloader" style="display:none">
			<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#preloader"></use>
		</svg>
		<span><?php esc_attr_e( 'Show More', 'tm_gallery' ) ?></span>
	</a>
</div>
