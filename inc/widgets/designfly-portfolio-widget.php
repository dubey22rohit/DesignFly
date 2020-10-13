<?php
class DESIGNfly_Portfolio_Widget extends WP_Widget {
	private $default_num = 8;
    public function __construct() {
		parent::__construct(
			'Designfly_Portfolio_Widget', 
			esc_html__( 'DesignFly Custom Portfolios', 'designfly' ),
			array( 'description' => esc_html__( 'Shows Portfolio Images', 'designfly' ) )
		);
	}
    public function widget( $args, $inst ) {
		$posts = get_posts(
			array(
				'post_type'    => 'designfly_portfolio',
				'numberposts'  => (!empty( $inst['num'] ) ? $inst['num'] : $this->default_num ),
				'post_status'  => 'publish',
				'meta_key'     => '_thumbnail_id',
				'meta_compare' => 'EXISTS',
			)
		);
		//FrontEnd
		if ( ! empty( $posts ) ) {

			echo $args['before_widget'];// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
			if ( ! empty( $inst['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $inst['title'] ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			echo '<div class="portfolio-widget-block">'; 

			foreach ( $posts as $post ) {
				echo '<img src="' . get_the_post_thumbnail_url( $post ) . '">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			echo '</div>'; 
			echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		}
	}
	//Backend 
	public function form( $inst ) {
		$title = ( ! empty( $inst['title'] ) ? $inst['title'] : '' );
		$num  = ( ! empty( $inst['num'] ) ? $inst['num'] : $this->default_num );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'designfly' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'num' ) ); ?>"><?php esc_attr_e( 'Number of items:', 'designfly' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'num' ) ); ?>" type="number" value="<?php echo esc_attr( $num ); ?>">
		</p>
		<?php
	}
    public function update( $new_inst, $old_inst ) {
		$inst          = array();
		$inst['title'] = ( ! empty( $new_inst['title'] ) ) ? sanitize_text_field( $new_inst['title'] ) : '';
		$inst['num']  = ( ! empty( $new_inst['num'] ) ) ? sanitize_text_field( $new_inst['num'] ) : $this->default_num;

		return $inst;
	}
}
