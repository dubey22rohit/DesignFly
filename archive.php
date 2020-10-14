<?php
/**
 * The template for displaying archive pages
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
							<span class="title"><?php the_archive_title(); ?></span>
						</div>
						<div class="post-grid">
							<?php
							while ( have_posts() ) {
								the_post();
								get_template_part( 'template-parts/content', 'archive' );
							};
							?>
						</div>
					</div>
					<?php get_sidebar(); ?>
				</div>
				<?php

				the_posts_pagination(
					array(
						'screen_reader_text' => ' ',
						'next_text'          => '<img src="' . get_template_directory_uri() . '/img/right-arrow.svg">',
						'prev_text'          => '<img src="' . get_template_directory_uri() . '/img/left-arrow.svg">',
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
