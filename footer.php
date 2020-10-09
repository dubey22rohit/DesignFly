<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DesignFly
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">
		<div class="site-footer-text">
				<span class="title"><?php echo esc_html__( "Welcome to D'SIGNfly", 'designfly' ); ?></span>
				<p class="description"><?php echo esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'designfly' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="read-more"><?php echo esc_html__( 'Read more', 'designfly' ); ?></a>
			</div>
			<div class="contact-detail">
				<span class="title"><?php echo esc_html__( 'Contact Us', 'designfly' ); ?></span>
				<p class="description">
					<?php echo esc_html__( 'Street 21 Planet, A-11, dapibus tristique. 123 551', 'designfly' ); ?><br/>
					<?php echo esc_html__( 'Tel: 123 4567890; Fax: 123 456789', 'designfly' ); ?><br/>
					<?php echo esc_html__( 'Email: ', 'designfly' ); ?><span class="email"><?php echo esc_html( 'contactus@designfly.com' ); ?></span>
				</p>
					<div class="social-links">
						<a href="#"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/facebook-cropped.png' ); ?>"></a>
						<a href="#"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/google-cropped.png' ); ?>"></a>
						<a href="#"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/linkedin-cropped.png' ); ?>"></a>
						<a href="#"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/pinterest-cropped.png' ); ?>"></a>
						<a href="#"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/twitter-cropped.png' ); ?>"></a>
					</div>
				
			</div>
		</div>
		<div class = "rtcamp-copyright">
		<span><?php echo esc_html__("© 2020-DESIGNFly| Designed by ",'designfly')?><a  class="copyright-link" target="_blank" href="<?php echo esc_url( 'https://rtcamp.com/' );?>">rtCamp</a></span>
		</div>
	</footer>


<?php wp_footer(); ?>

</body>
</html>
