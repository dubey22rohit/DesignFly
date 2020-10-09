<div id="search-field">
	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="text" class="search-input" name="s" value="<?php echo esc_html( get_search_query() ); ?>">
		<input type="image" class="search-submit" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/search-icon.png">
	</form>
</div>
