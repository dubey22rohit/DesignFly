<?php
/**
 * DesignFly functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DesignFly
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'designfly_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function designfly_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on DesignFly, use a find and replace
		 * to change 'designfly' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'designfly', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'designfly' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'designfly_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => get_template_directory_uri() . '/images/rapeatable-bg.png',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'designfly_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function designfly_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'designfly_content_width', 640 );
}
add_action( 'after_setup_theme', 'designfly_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
require get_template_directory() . '/inc/widgets/designfly-portfolio-widget.php';
require get_template_directory() . '/inc/widgets/designfly-posts-widget.php';
require get_template_directory() . '/inc/widgets/designfly-twitter-widget.php';
require get_template_directory() . '/inc/widgets/designfly-facebook-widget.php';
function designfly_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'designfly' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'designfly' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_widget( 'Designfly_Portfolio_Widget' );
	register_widget( 'Designfly_Posts_Widget' );
	register_widget( 'DESIGNfly_Twitter_Widget' );
	register_widget( 'DESIGNfly_Facebook_Widget' );
}
add_action( 'widgets_init', 'designfly_widgets_init' );

require get_template_directory() . '/inc/designfly-twitter-config.php';
new DESIGNfly_Twitter_Configuration();
/**
 * Enqueue scripts and styles.
 */
function designfly_scripts() {
	wp_enqueue_style( 'designfly-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'designfly-theme', get_template_directory_uri() . '/style.css', array(), '1.0' );
	wp_enqueue_script( 'designfly-theme', get_template_directory_uri() . '/js/theme.js', array( 'jquery' ), '1.0', true );
	wp_style_add_data( 'designfly-style', 'rtl', 'replace' );

	wp_enqueue_script( 'designfly-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( is_front_page() || is_post_type_archive( 'designfly_portfolio' ) || is_tax( 'designfly_categories' ) ) {
		wp_enqueue_script( 'designfly-portfolio-modal', get_template_directory_uri() . '/js/portfolio-modal.js', array( 'designfly-theme' ), '1.0', true );
	}
}
add_action( 'wp_enqueue_scripts', 'designfly_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function custom_portfolio_post() {
	$labels = array(
		'name'                     => _x( 'Portfolios', 'Post Type General Name', 'designfly' ),
		'singular_name'            => _x( 'Portfolio', 'Post Type Sigular Name', 'designfly' ),
		'add_new'                  => _x( 'Add New Image', 'Add New', 'designfly' ),
		'add_new_item'             => __( 'Add New Portfolio', 'designfly' ),
		'all_items'                => __( 'All Portfolios', 'designfly' ),
		'new_item'                 => __( 'New Portfolio', 'designfly' ),
		'view_items'               => __( 'View Portfolios', 'designfly' ),
		'view_item'                => __( 'View Portfolio', 'designfly' ),
		'edit_item'                => __( 'Edit Portfolio', 'designfly' ),
		'search_items'             => __( 'Search Portfolios', 'designfly' ),
		'not_found'                => __( 'No portfolios found.', 'designfly' ),
		'not_found_in_trash'       => __( 'No portfolios found in Trash.', 'designfly' ),
		'archives'                 => __( 'Portfolio Archives', 'designfly' ),
		'attributes'               => __( 'Portfolio Attributes', 'designfly' ),
		'insert_into_item'         => __( 'Insert into portfolio', 'designfly' ),
		'filter_items_list'        => __( 'Filter portfolio list', 'designfly' ),
		'items_list'               => __( 'Portfolios list', 'designfly' ),
	);
		

	$args = array(
		'labels'      => $labels,
		'description' => __( 'Portfolios', 'designfly' ),
		'public'      => true,
		'menu_icon'   => 'dashicons-portfolio',
		'has_archive' => true,
		'supports'    => array( 'title', 'thumbnail', 'page-attributes' ),
	);

	register_post_type( 'designfly_portfolio', $args );

	$labels = array(
		'name'          => _x( 'Portfolio Categories', 'Portfolio Categories', 'designfly' ),
		'singular_name' => _x( 'Portfolio Category', 'Portfolio Category', 'designfly' ),
	);

	$args = array(
		'hierarchical' => false,
		'labels'       => $labels,
		'public'       => true,
		'description'  => __( 'lorem ipsum dolor si amet...', 'designfly' ),
	);

	register_taxonomy( 'designfly_categories', array( 'designfly_portfolio' ), $args );
}
add_action( 'init', 'custom_portfolio_post' );

//Read More
function designfly_excerpt_more( $more ) {
	if ( ! is_single() ) {
		$more = sprintf(
			'<a class="read-more" href="%1$s">%2$s</a>',
			get_permalink( get_the_ID() ),
			esc_html__( 'READ MORE', 'designfly' )
		);
	}

	return $more;
}
add_filter( 'excerpt_more', 'designfly_excerpt_more' );
function designfly_excerpt_length( $length ) {
	if ( ! is_single() ) {
		return 35;
	}

	return $length;
}
add_filter( 'excerpt_length', 'designfly_excerpt_length' );
//Comments
function designfly_post_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;// phpcs:ignore
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

	$commenter = wp_get_current_commenter();
	?>
	<<?php echo $tag;// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped?> id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<span class="dashicons dashicons-testimonial"></span>
			<div class="comment-block">
				<footer class="comment-meta">
					<?php
					$author_link = '';
					if ( empty( $comment->comment_author_url ) && ! empty( $comment->user_id ) ) {
						$author_link = '<a href="' . esc_url( get_author_posts_url( $comment->user_id ) ) . '">' . esc_html( get_the_author_meta( 'display_name', $comment->user_id ) ) . '</a>';
					} else {
						$author_link = get_comment_author_link( $comment );
					}

					$author_html  = '<span class="comment-author">' . $author_link . '</span>';
					$said_on_html = ' <span class="said-on">' . esc_html_x( 'said on', 'designfly comment said on', 'designfly' ) . '</span> ';
					$comment_date = get_comment_date( 'F d, Y', $comment ) . ' ' . esc_html_x( 'at', 'designfly comment at', 'designfly' ) . ' ' . get_comment_date( 'H:i a', $comment );

					echo $author_html . $said_on_html . $comment_date;// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					if ( '0' == $comment->comment_approved /*phpcs:ignore*/) { 
						?>
						<em class="comment-awaiting-moderation"><?php echo $moderation_note;// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped?></em>
					<?php }?>
				</footer>

				<div class="comment-content">
					<?php comment_text(); ?>
				</div>

				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'reply_text' => esc_html_x( 'reply', 'comment reply', 'designfly' ),
							'add_below'  => 'div-comment',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
							'before'     => '<div class="reply"><i class="fas fa-share"></i> ',
							'after'      => '</div>',
						)
					)
				);
				?>
			</div>
		</article>
	<?php
}