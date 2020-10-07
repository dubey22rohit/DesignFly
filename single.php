<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package DesignFly
 */

get_header();
get_template_part( 'template-parts/content', 'portfolio-tax' );
?>
<div id="primary" class="content-area show-sidebar">
		<main id="main" class="site-main">
		<?php
			if ( have_posts() ) :

				?>
				<div class="blog-content">
					<div class="single-post-content">
						<?php
						while ( have_posts() ){
							the_post();

							get_template_part( 'template-parts/content', get_post_type() );
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						}
						?>
					</div>
					<?php get_sidebar(); ?>
				</div>
				<?php

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
