<?php
get_header();
?>
	<div class="front-header">
	<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
 
 <div class="carousel-inner" >
   <div class="carousel-item active">
	 <img src="<?php echo get_template_directory_uri();?>/images/slider-image.png"  >
	 <div class="carousel-caption d-none d-md-block">
	   <p class = 'slide_label'><?php echo esc_html__( 'Gearing up the ideas', 'designfly' ); ?></p>
	   <p class = 'slide_text'><?php echo esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 'designfly' ); ?></p>
	 </div>
   </div>
   <div class="carousel-item">
	 <img src="<?php echo get_template_directory_uri()?>/images/slider-image.png" >
	 <div class="carousel-caption d-none d-md-block">
	 <p class = 'slide_label'><?php echo esc_html__( 'Gearing up the ideas', 'designfly' ); ?></p>
	 <p class = 'slide_text'><?php echo esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 'designfly' ); ?></p>
	 </div>
   </div>
   <div class="carousel-item">
	 <img src="<?php echo get_template_directory_uri()?>/images/slider-image.png" >
	 <div class="carousel-caption d-none d-md-block">
	 <p class = 'slide_label'><?php echo esc_html__( 'Gearing up the ideas', 'designfly' ); ?></p>
	 <p class = 'slide_text'><?php echo esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 'designfly' ); ?></p>
	 </div>
   </div>
 </div>
 <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
   <span class="sr-only"><img src="<?php echo get_template_directory_uri()?>/images/cropped/white-left-slider-arrow.png" alt=""></span>
 </a>
 <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
   <span class="sr-only"><img src="<?php echo get_template_directory_uri()?>/images/cropped/white-right-slider-arrow.png" alt=""></span>
 </a>
</div>

		
    </div>
    <?php get_template_part( 'template-parts/content', 'portfolio-tax' ); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="main-title">
				<span><?php echo esc_html__( "D'SIGN IS THE SOUL", 'designfly' ); ?></span>
				<a class="view-all-button" href="<?php echo esc_url( get_post_type_archive_link( 'designfly_portfolio' ) ); ?>"><?php echo esc_html__( 'view all', 'designfly' ); ?></a>
			</div>

			<div class="portfolio-block">
				<?php
				$query = new WP_Query(
					array(
						'post_type'      => 'designfly_portfolio',
						'post_status'    => 'publish',
						'posts_per_page' => 6,
					)
				);

				if ( $query->have_posts() ) :

					?>
					<div class="portfolio-grid">
					<?php

					while ( $query->have_posts() ) :

						$query->the_post();

						get_template_part( 'template-parts/content', 'portfolio' );

						endwhile;

					?>
					</div>
					<?php

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</div>

		</main>
	</div>
<?php
get_template_part( 'template-parts/content', 'portfolio-modal' );
get_footer();
