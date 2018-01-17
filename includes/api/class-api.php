<?php
/**
 * The handle class
 */
class WCCT_API {

	/**
	 * Constructor for WCCT_API class
	 */
	function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_route_feed' ) );
	}
	/**
	 * Register the route
	 *
	 * @return void
	 */
	public function register_route_feed() {
		register_rest_route( 'wcct', 'feed', array(
			'method'	=> 'GET',
			'callback'	=> array( $this, 'get_feed_data' ),
		) );
	}

	/**
	 * Get data for feed
	 *
	 * @return array
	 */
	public function get_feed_data( $data ) {
		$posts	= get_posts( array(
			'post_type'	=> 'product',
		) );

		if ( empty( $posts ) ) {
			return null;
		}

		return $posts;
	}
}