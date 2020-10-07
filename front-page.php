<?php
/**
 * The front page
 *
 * The main homepage of the theme. It shows portfolios and link to
 * portfolio archive page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DESIGNfly
 */

get_header();
?>
	<div class="front-header">
		
		<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/slider-image.png">
		<div class="text-block">
			<div><?php echo esc_html__( 'Gearing up the ideas', 'designfly' ); ?></div>
			<p><?php echo esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 'designfly' ); ?></p>
		</div>
	</div>
<?php

get_footer();
