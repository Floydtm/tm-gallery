<?php
/**
 * Index frontend grid
 * 
 * @package templates/frontend/grid
 */
?>
<?php do_action( 'tm-pg-grid-preloader' ); ?>
<div class="tm-pg_frontend" <?php echo isset( $data->id ) ? "data-id=\"{$data->id}\"" : ''; ?> 
	 data-view="<?php echo $data->grid['type'] ?>" data-post-id="<?php the_ID() ?>">
	<div class="tm-pg_front_gallery <?php echo apply_filters( 'tm-pg-grid-container-class', '' ) ?>">
		<?php do_action( 'tm-pg-grid-filters', $data ); ?>
		<?php do_action( 'tm-pg-grid-content', $data ); ?>
		<?php do_action( 'tm-pg-grid-pagination', $data ); ?>
	</div>
</div>

