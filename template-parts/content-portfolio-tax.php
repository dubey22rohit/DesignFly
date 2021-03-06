<div class="portfolio-taxonomy">
	<div class="portfolio-taxonomy-middle">
		<div class="portfolio-taxonomy-content">
			<?php
			$terms = get_terms(
				array(
					'taxonomy'   => 'designfly_categories',
					'hide_empty' => false,
					'number'     => 3,
				)
			);
			?>
			
			<?php
			foreach ( $terms as $term ) {//phpcs:ignore
				?>
				<div class="portfolio-taxonomy-block">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/images/taxonomy-icons/' ) . esc_html( $term->slug ) . '.png'; ?>">
						<div class="portfolio-taxonomy-details">
							<a href="<?php echo esc_url( get_term_link( $term, 'designfly_portfolio' ) ); ?>">
								<span class="portfolio-taxonomy-title"><?php echo esc_html( $term->name ); ?></span>
							</a>
							<div><p class="portfolio-taxonomy-description"><?php echo esc_html(wp_trim_words( ( $term->description ),10 )); ?></p></div>
						</div>
				</div>
				<?php
			}
			?>

		</div>
	</div>
</div>
