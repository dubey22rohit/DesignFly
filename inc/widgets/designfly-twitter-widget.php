<?php
class DESIGNfly_Twitter_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'DESIGNfly_Twitter_Widget',
			esc_html__( 'DESIGNfly Twitter', 'designfly' ),
			array( 'description' => esc_html__( 'A Widget to show Twitter feeds.', 'designfly' ) )
		);
	}

	/**
	 * Front-end display of widget.*/
	public function widget( $args, $instance ) {
		$tweets = $this->get_tweets( $instance );

		if ( empty( $tweets ) ) {
			return;
		}

		$title = apply_filters( 'widget_title', $instance['title'] );

		$screen_name = get_option( 'designfly_screen_name', 'rtCamp' );
		$follow      = '<div><form method="get" action="https://twitter.com/' . esc_attr( $screen_name ) . '"><button type="submit" class="twitter-follow-button"><span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Follow us', 'designfly' ) . '</button></form></div>';

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $follow . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		// Show tweets.
		foreach ( $tweets as $tweet ) {
			?>
			<div class="designfly-tweet-block">
				<div class="designfly-tweet-block-header">
					<img src="<?php echo esc_url( $tweet['user']['profile_image_url_https'] ); ?>" alt="<?php echo esc_attr( $tweet['user']['name'] ); ?>">
					<div class="designfly-tweet-header-block">
						<div class="designfly-tweet-name-handle">
							<span class="designfly-tweet-name"><?php echo esc_html( $tweet['user']['name'] ); ?></span>
							<span class="designfly-tweet-handle"><a target="_blank" href="<?php echo esc_url( $tweet['user']['url'] ); ?>"><?php echo esc_html( '@' . $tweet['user']['screen_name'] ); ?></a></span>
						</div>
						<span class="designfly-tweet-time"><?php echo esc_html( $this->time2str( $tweet['created_at'] ) ); ?></span>
					</div>
				</div>
				<p class="designfly-tweet-text"><?php echo esc_html( $tweet['text'] ); ?></p>
			</div>
			<?php
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}

	/**
	 * Sanitize widget form values as they are saved.
	*/
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['nots']  = sanitize_text_field( $new_instance['nots'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 */
	public function form( $instance ) {
		$title = ( ! empty( $instance['title'] ) ? $instance['title'] : '' );
		$nots  = ( ! empty( $instance['nots'] ) ? $instance['nots'] : '' );

		$oauth_token = get_option( 'designfly_oauth_token' );
		// Show warning when twitter configuration is not set.
		if ( empty( $oauth_token ) ) {
			echo '<p class="designfly-config-warning"><a target="_blank" href="' . esc_url( admin_url( 'admin.php?page=designfly-twitter-configuration' ) ) . '">' . esc_html__( 'Twitter Configuration', 'designfly' ) . '</a>' . esc_html__( ' is not set, please set them first.', 'designfly' ) . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'designfly' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'nots' ) ); ?>"><?php echo esc_html__( 'Number of Tweets:', 'designfly' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'nots' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'nots' ) ); ?>" type="number" value="<?php echo esc_attr( $nots ); ?>" />
		</p>

		<?php
	}

	/**
	 * Converts timestamp or string time to relative time.*/
	private function time2str( $ts ) {
		if ( ! ctype_digit( $ts ) ) {
			$ts = strtotime( $ts );
		}

		$diff = time() - $ts;

		if ( 0 == $diff ) { // phpcs:ignore

			return 'now';

		} elseif ( $diff > 0 ) {

			$day_diff = floor( $diff / 86400 );
			if ( 0 == $day_diff ) { // phpcs:ignore

				if ( $diff < 60 ) {
					return 'now';
				}
				if ( $diff < 120 ) {
					return '1 min';
				}
				if ( $diff < 3600 ) {
					return floor( $diff / 60 ) . ' min';
				}
				if ( $diff < 7200 ) {
					return '1h';
				}
				if ( $diff < 86400 ) {
					return floor( $diff / 3600 ) . 'h';
				}
			}

			if ( 1 == $day_diff ) { // phpcs:ignore
				return 'Yesterday';
			}
			if ( $day_diff < 7 ) {
				return $day_diff . ' days';
			}
			if ( $day_diff < 31 ) {
				return ceil( $day_diff / 7 ) . ' weeks';
			}
			if ( $day_diff < 60 ) {
				return 'last month';
			}

			return gmdate( 'F Y', $ts );

		} else {

			$diff     = abs( $diff );
			$day_diff = floor( $diff / 86400 );

			if ( 0 == $day_diff ) { // phpcs:ignore

				if ( $diff < 120 ) {
					return '1 min';
				}
				if ( $diff < 3600 ) {
					return floor( $diff / 60 ) . ' min';
				}
				if ( $diff < 7200 ) {
					return '1h';
				}
				if ( $diff < 86400 ) {
					return floor( $diff / 3600 ) . 'h';
				}
			}

			if ( 1 == $day_diff ) { // phpcs:ignore
				return 'Tomorrow';
			}
			if ( $day_diff < 4 ) {
				return gmdate( 'l', $ts );
			}
			if ( $day_diff < 7 + ( 7 - gmdate( 'w' ) ) ) {
				return 'next week';
			}
			if ( ceil( $day_diff / 7 ) < 4 ) {
				return 'in ' . ceil( $day_diff / 7 ) . ' weeks';
			}
			if ( gmdate( 'n', $ts ) === gmdate( 'n' ) + 1 ) {
				return 'next month';
			}

			return gmdate( 'F Y', $ts );
		}
	}

	/**
	 * Gets tweet from tweeter API
	 */
	private function get_tweets( $args ) {
		$consumer_key       = get_option( 'designfly_consumer_key' );
		$consumer_secret    = get_option( 'designfly_consumer_secret' );
		$oauth_token        = get_option( 'designfly_oauth_token' );
		$oauth_token_secret = get_option( 'designfly_oauth_token_secret' );
		$screen_name        = get_option( 'designfly_screen_name', 'rtCamp' );

		// Assign default consumer key when option is empty.
		if ( empty( $consumer_key ) ) {
			global $designfly_consumer_key;
			$consumer_key = $designfly_consumer_key;
		}

		// Assign default consumer secret when option is empty.
		if ( empty( $consumer_secret ) ) {
			global $designfly_consumer_secret;
			$consumer_secret = $designfly_consumer_secret;
		}

		// Stop if token and secret is not provided.
		if ( empty( $oauth_token_secret ) || empty( $oauth_token ) ) {
			return false;
		}

		// User's timeline tweets.
		$twitter_timeline = 'user_timeline';

		$request = array(
			'count'       => ( ! empty( $args['nots'] ) ? $args['nots'] : '1' ),
			'screen_name' => $screen_name,
		);

		$oauth = array(
			'oauth_consumer_key'     => $consumer_key,
			'oauth_nonce'            => time(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_token'            => $oauth_token,
			'oauth_timestamp'        => time(),
			'oauth_version'          => '1.0',
		);

		$oauth = array_merge( $oauth, $request );

		// make base string.
		$base_u_r_i = "https://api.twitter.com/1.1/statuses/$twitter_timeline.json";
		$method     = 'GET';
		$params     = $oauth;

		$r = array();
		ksort( $params );
		foreach ( $params as $key => $value ) {
			$r[] = "$key=" . rawurlencode( $value );
		}
		$base_info     = $method . '&' . rawurlencode( $base_u_r_i ) . '&' . rawurlencode( implode( '&', $r ) );
		$composite_key = rawurlencode( $consumer_secret ) . '&' . rawurlencode( $oauth_token_secret );

		// get oauth signature.
		$oauth_signature          = base64_encode( hash_hmac( 'sha1', $base_info, $composite_key, true ) ); // phpcs:ignore
		$oauth['oauth_signature'] = $oauth_signature;

		$r = 'OAuth ';

		$values = array();
		foreach ( $oauth as $key => $value ) {
			$values[] = "$key=\"" . rawurlencode( $value ) . '"';
		}
		$r .= implode( ', ', $values );

		// Making request.
		$url         = "https://api.twitter.com/1.1/statuses/$twitter_timeline.json?" . http_build_query( $request );
		$result_full = wp_remote_get(
			$url,
			array(
				'method'  => 'GET',
				'headers' => array(
					'Authorization' => $r,
				),
			)
		);

		$json = wp_remote_retrieve_body( $result_full );

		// decode json format tweets.
		$tweets = json_decode( $json, true );

		if ( empty( $tweets ) || ! empty( $tweets['errors'] ) ) {
			return false;
		}

		return $tweets;
	}
}
