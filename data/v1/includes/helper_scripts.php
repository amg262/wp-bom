<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

/**
 * Created by PhpStorm.
 * User: andy
 * Date: 2/28/17
 * Time: 2:41 AM
 */
// display custom admin notice
/**
 *
 */
function blackhole_tools_admin_notice() {

	$screen = get_current_screen();

	if ( $screen->id === 'toplevel_page_blackhole_settings' ) {

		if ( isset( $_GET[ 'reset-options' ] ) ) {

			if ( $_GET[ 'reset-options' ] === 'true' ) : ?>

                <div class="notice notice-success is-dismissible">
                    <p><?php _e( 'Default settings restored.', 'bbb' ); ?></p>
                </div>

			<?php else : ?>

                <div class="notice notice-error is-dismissible">
                    <p><?php _e( 'No changes made.', 'bbb' ); ?></p>
                </div>

			<?php endif;

		}
	}
}

add_action( 'admin_notices', 'blackhole_tools_admin_notice' );

// display custom admin notice
/**
 *
 */
function shapeSpace_custom_admin_notice() { ?>

    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'Congratulations, you did it!', 'shapeSpace' ); ?></p>
    </div>

<?php }

add_action( 'admin_notices', 'shapeSpace_custom_admin_notice' );

?>
    <div class="updated notice">
        <p>Something has been updated, awesome</p>
    </div>
    <div class="error notice">
        <p>There has been an error. Bummer</p>
    </div>
    <div class="update-nag notice">
        <p>You should really update to achieve some awesome instad of bummer</p>
    </div>
<?php
// my $sanitize_callback function
/**
 * @param $input
 *
 * @return mixed
 */
function my_option_group_validate( $input ) {

	$message = null;
	$type    = null;

	if ( null != $input ) {

		if ( false === get_option( 'my_option' ) ) {

			add_option( 'my_option', $input );
			$message = __( 'Option added! Congrats man.' );
			$type    = 'updated';

		} else {

			update_option( 'my_option', $input );
			$message = __( 'Option updated! Miller time.' );
			$type    = 'updated';

		}

	} else {

		$message = __( 'Oh noes! There was a problem.' );
		$type    = 'error';

	}

	// add_settings_error( $setting, $code, $message, $type )
	add_settings_error( 'my_option_notice', 'my_option_notice', $message, $type );

	return $input;

}

/**
 * Copy image title and save to Alt text field when image is uploaded. Runs anytime
 * an image is uploaded, automatically.
 */

add_filter( 'add_attachment', 'hookus_meet_tookus', 10, 2 );

//add_filter('edit_attachment', 'insert_image_alt_tag', 10, 2);

/**
 * @param $post_ID
 * @param $action
 *
 * @return array|null|\WP_Post
 */
function update_alt_tag( $post_ID, $action ) {

	$attach = wp_get_attachment_url( $post_ID );
	$title  = sanitize_text_field( get_the_title( $post_ID ) );

	if ( $action === 'create' ) {
		if ( ! add_post_meta( $post_ID, '_wp_attachment_image_alt', $title, true ) ) {
			update_post_meta( $post_ID, '_wp_attachment_image_alt', $title );
		}
	} elseif ( $action === 'update' ) {
		update_post_meta( $post_ID, '_wp_attachment_image_alt', $title );

	} elseif ( $action === 'delete' ) {
		delete_post_meta( $post_ID, '_wp_attachment_image_alt', $title );
	}

	return get_post( $post_ID );

}

/**
 * @param $is_update
 *
 * @return array
 */
function batch_update_image_tags( $is_update ) {

	$total = 0;

	$created = 0;

	$updated = 0;

	$deleted = 0;

	$args = [

		'post_type' => 'attachment',

		'numberposts' => - 1,

		'post_status' => null,

		'post_parent' => null, // any parent

	];

	//Get all attachment posts

	$attachments = get_posts( $args );

	//if there are posts

	if ( $attachments ) {

		$sit_settings = get_option( 'sit_settings' );

		if ( $sit_settings[ 'enable_pdf' ] ) {

			$pdf = true;

			$pdf_mine = 'pdf';

		}

		$image_mime = 'image';

		//Loop thru each attachment

		foreach ( $attachments as $post ) {

			//get post data ready,set title var to post title

			setup_postdata( $post );

			$title = sanitize_text_field( get_the_title( $post->ID ) );

			$type = get_post_mime_type( $post->ID );

			$tag = sanitize_text_field( get_post_meta( $post->ID, '_wp_attachment_image_alt', true ) );

			$tag_str = strval( $tag );

			$tag_len = strlen( $tag_str );

			//echo $type;

			if ( strpos( $type, $image_mime ) !== false ) {

				if ( $is_update == true ) {

					//if has post meta for alt tag, update it else add it.

					if ( ! add_post_meta( $post->ID, '_wp_attachment_image_alt', $title, true ) ) {

						if ( ( empty( $tag ) || ( ( $tag_len <= 2 ) && ( $tag_str !== $title ) ) ) ) {

							update_post_meta( $post->ID, '_wp_attachment_image_alt', $title );

							$updated ++;

						}

					} else {

						$created ++; //update counter

					}

				} else {

					//if has post meta for alt tag, update it else add it.

					if ( ! empty( $tag ) ) {

						delete_post_meta( $post->ID, '_wp_attachment_image_alt', $title );

						$deleted ++; //update counter

					} //end add_post_meta

				}

				$total ++;

			}

		} //end foreach

	} //end attachments

	$count = [

		'total' => $total,

		'created' => $created,

		'updated' => $updated,

		'deleted' => $deleted,

	];

	//count of files updated

	return $count;

}


/**
 * Class Pugs_API_Endpoint
 */
class Pugs_API_Endpoint {

	/**
	 * @var string Pug Bomb Headquarters
	 */
	protected $api = 'http://pugme.herokuapp.com/bomb?count=';


	/** Hook WordPress
	 *
	 * @return void
	 */
	public function __construct() {

		add_filter( 'query_vars', [ $this, 'add_query_vars' ], 0 );
		add_action( 'parse_request', [ $this, 'sniff_requests' ], 0 );
		add_action( 'init', [ $this, 'add_endpoint' ], 0 );
	}


	/** Add public query vars
	 *
	 * @param array $vars List of current public query vars
	 *
	 * @return array $vars
	 */
	public function add_query_vars( $vars ) {

		$vars[] = '__api';
		$vars[] = 'pugs';

		return $vars;
	}


	/** Add API Endpoint
	 *    This is where the magic happens - brush up on your regex skillz
	 *
	 * @return void
	 */
	public function add_endpoint() {

		add_rewrite_rule( '^api/pugs/?([0-9]+)?/?', 'index.php?__api=1&pugs=$matches[1]', 'top' );
	}


	/**    Sniff Requests
	 *    This is where we hijack all API requests
	 *    If $_GET['__api'] is set, we kill WP and serve up pug bomb awesomeness
	 *
	 * @return die if API request
	 */
	public function sniff_requests() {

		global $wp;
		if ( isset( $wp->query_vars[ '__api' ] ) ) {
			$this->handle_request();
			exit;
		}
	}


	/** Handle Requests
	 *    This is where we send off for an intense pug bomb package
	 *
	 * @return void
	 */
	protected function handle_request() {

		global $wp;
		$pugs = $wp->query_vars[ 'pugs' ];
		if ( ! $pugs ) {
			$this->send_response( 'Please tell us how many pugs to send.' );
		}

		$pugs = file_get_contents( $this->api . $pugs );
		if ( $pugs ) {
			$this->send_response( '200 OK', json_decode( $pugs ) );
		} else {
			$this->send_response( 'Something went wrong with the pug bomb factory' );
		}
	}


	/** Response Handler
	 *    This sends a JSON response to the browser
	 */
	protected function send_response( $msg, $pugs = '' ) {

		$response[ 'message' ] = $msg;
		if ( $pugs ) {
			$response[ 'pugs' ] = $pugs;
		}
		header( 'content-type: application/json; charset=utf-8' );
		echo json_encode( $response ) . "\n";
		exit;
	}
}


new Pugs_API_Endpoint();

/**
 * Grab latest post title by an author!
 *
 * @param array $data Options for the function.
 *
 * @return string|null Post title for the latest,
 * or null if none.
 */
function my_awesome_func( $data ) {

	$posts = get_posts( [
		                    'author' => $data[ 'id' ],
	                    ] );

	if ( empty( $posts ) ) {
		return null;
	}

	return $posts[ 0 ]->post_title;
}

add_action( /**
 *
 */
	'rest_api_init', function () {

	register_rest_route( 'myplugin/v1', '/author/(?P<id>\d+)', [
		'methods'  => 'GET',
		'callback' => 'my_awesome_func',
	] );
} );