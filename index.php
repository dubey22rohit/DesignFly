<?php
/**
 * The main template file
 *This is our blog page
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
					<div class="post-content">
						<div class="main-title">
							<span class="title"><?php echo esc_html__( "LET'S BLOG", 'designfly' ); ?></span>
						</div>
						<div class="post-grid">
							<?php
								while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/content', 'archive' );
							endwhile;
							?>

						</div>
					</div>
					<?php get_sidebar(); ?>
				</div>
				<?php

				the_posts_pagination(
					array(
						'screen_reader_text' => ' ',
						'next_text'          => '<img src="' . get_template_directory_uri() . '/images/right-arrow.svg">',
						'prev_text'          => '<img src="' . get_template_directory_uri() . '/images/left-arrow.svg">',
					)
				);

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
