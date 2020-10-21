<?php
get_header();
get_template_part( 'template-parts/content', 'portfolio-tax' );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="main-title">
				<span><?php echo esc_html__( "D'SIGN IS THE SOUL", 'designfly' ); ?></span>
				<div class="main-title-button">
					<?php
					$terms = get_terms(
						array(
							'taxonomy'   => 'designfly_categories',
							'hide_empty' => false,
							'number'     => 3,
						)
					);

					foreach ( $terms as $term ) { //phpcs:ignore
						?>
						<a class="view-all-button" href="<?php echo esc_url( get_term_link( $term, 'designfly_portfolio' ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
						<?php
					}
					?>
				</div>
			</div>

			<div class="portfolio-block">
				<?php
				if ( have_posts() ) :

					?>
					<div class="portfolio-grid">
					<?php

					while ( have_posts() ) :

						the_post();

						get_template_part( 'template-parts/content', 'portfolio' );

						endwhile;

					?>
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
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_template_part( 'template-parts/content', 'portfolio-modal' );
get_footer();
