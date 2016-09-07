<?php
/**
 * Gallery editor display sledebar
 * 
 * @package templates/gallery/slidebar
 */
?>
<div id="tm-pg-sidebar-scroll-container" class="tm-pg_sidebar_container">
	<h5 class="tm-pg_sidebar-title"><?php esc_attr_e( 'Properties', 'tm_gallery' ) ?></h5>
	<div class="tm-pg_hr"></div>
	<div id="sidebar-content">
		<div data-type="colums">
			<div>
				<label><span><?php esc_attr_e( 'Colums count', 'tm_gallery' ); ?></span></label>
			</div>
			<select class="select2" data-placeholder="<?php esc_attr_e( 'Choose colum', 'tm_gallery' ) ?>" >
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>
		</div>
		<div data-type="padding" style="display: none">
			<p>
				<label><span><?php esc_attr_e( 'Padding', 'tm_gallery' ); ?></span></label>
				<input type="text" value="" name="padding">
			</p>
		</div>
	</div>
</div>