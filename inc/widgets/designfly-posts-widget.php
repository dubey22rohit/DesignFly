<?php
class DESIGNfly_Posts_Widget extends WP_Widget {
	private $default_num = 5;
    private $default_type = 'recent';
    public function __construct() {
		parent::__construct(
			'Designfly_Posts_Widget', 
			esc_html__( 'Designfly Custom Posts', 'designfly' ),
			array( 'description' => esc_html__( 'A Widget to show recent/related/populat posts', 'designfly' ) ) 
		);
	}

	//Front End
	public function widget( $args, $inst ) {
		$qry_args = array(
			'post_type'   => 'post',
			'numberposts' => ( ! empty( $inst['num'] ) ? $inst['num'] : $this->default_num ),
			'post_status' => 'publish',
		);
		
		
		if ( 'recent' === $inst['type'] ) {
			if ( ! is_singular() ) {
				return;
			}
		}
		if ( 'popular' === $inst['type'] ) {
			$qry_args['meta_key'] = 'designfly_post_views_count'; 
			$qry_args['orderby']  = array( 'meta_value_num' => 'DESC' );
		}

		if ( 'related' === $inst['type'] ) {
			if ( ! is_singular() ) {
				return;
			}

			$qry_args['post_not_in'] = array( get_the_ID() );

			$terms = get_terms(
				array(
					'object_ids' => get_the_ID(),
					'hide_empty' => false,
					'fields'     => 'ids',
				)
			);

			$qry_args['category_in'] = $terms;
		}

		$posts = get_posts( $qry_args );

		if ( ! empty( $posts ) ) :

			echo $args['before_widget']; 
			if ( ! empty( $inst['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $inst['title'] ) . $args['after_title']; 
			}
			echo '<div class="designfly-posts-widget-block">'; 

			foreach ( $posts as $post ) {

				?>
				<div class="widget-post-block">
					<?php if ( has_post_thumbnail( $post ) ) : ?>
						<img src="<?php echo esc_url( get_the_post_thumbnail_url( $post ) ); ?>">
					<?php endif; ?>
					<div class="widget-post-details">
						<span class="post-title">
							<a class="post-title-link" href="<?php echo esc_url( get_post_permalink( $post ) ); ?>">
								<?php echo esc_html( get_the_title( $post ) ); ?>
							</a>
						</span>
						<span class="post-meta">
							<?php
							designfly_posted_by( $post );
							echo '&nbsp;'; 
							designfly_posted_on( $post );
							?>
						</span>
					</div>
				</div>
				<?php
			}

			echo '</div>'; 
			echo $args['after_widget']; 

		endif;
	}

	//Backend
	public function form( $inst ) {
		$title = (!empty( $inst['title'] ) ? $inst['title'] : '' );
		$num  = (!empty( $inst['num'] ) ? $inst['num'] : $this->default_num );
		$type  = (!empty( $inst['type'] ) ? $inst['type'] : $this->default_type );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'designfly' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_attr_e( 'Type of Posts:', 'designfly' ); ?></label> 
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
				<option <?php selected( $type, 'popular' ); ?> value="<?php echo esc_attr( 'popular' ); ?>"><?php echo esc_html__( 'Popular Posts', 'designfly' ); ?></option>
				<option <?php selected( $type, 'recent' ); ?> value="<?php echo esc_attr( 'recent' ); ?>"><?php echo esc_html__( 'Recent Posts', 'designfly' ); ?></option>
				<option <?php selected( $type, 'related' ); ?> value="<?php echo esc_attr( 'related' ); ?>"><?php echo esc_html__( 'Related (to current post) Posts', 'designfly' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'num' ) ); ?>"><?php esc_attr_e( 'Number of items:', 'designfly' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'num' ) ); ?>" type="number" value="<?php echo esc_attr( $num ); ?>">
		</p>
		<?php
	}

	
	 //Sanitize
	public function update( $new_inst, $old_inst ) {
		$inst          = array();
		$inst['title'] = (!empty( $new_inst['title'] ) ) ? sanitize_text_field( $new_inst['title'] ) : '';
		$inst['num']  = (!empty( $new_inst['num'] ) ) ? sanitize_text_field( $new_inst['num'] ) : $this->default_num;
		$inst['type']  = (!empty( $new_inst['type'] ) ) ? sanitize_text_field( $new_inst['type'] ) : $this->default_type;

		return $inst;
	}
} 