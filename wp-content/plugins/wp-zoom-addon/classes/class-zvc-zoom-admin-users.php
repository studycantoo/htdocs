<?php
/**
 * Users Controller
 *
 * @since   2.0.0
 * @author  Deepen
 */

class Zoom_Video_Conferencing_Admin_Users {

	public static $message = '';
	public $settings;
	public static $api_version = ZOOM_VIDEO_CONFERENCE_APIVERSION;

	/**
	 * List meetings page
	 *
	 * @since   1.0.0
	 * @changes in CodeBase
	 * @author  Deepen Bajracharya <dpen.connectify@gmail.com>
	 */
	public static function list_users() {
		wp_enqueue_script( 'video-conferencing-with-zoom-api-js' );
		wp_enqueue_script( 'video-conferencing-with-zoom-api-datable-js' );

		wp_enqueue_style( 'video-conferencing-with-zoom-api' );
		wp_enqueue_style( 'video-conferencing-with-zoom-api-datable' );

		//Check if any transient by name is available
		$check_transient = get_transient( '_zvc_user_lists' );
		if ( isset( $_GET['flush'] ) == true ) {
			if ( $check_transient ) {
				delete_transient( '_zvc_user_lists' );
				self::set_message( 'updated', __( "Flushed User Cache!", "video-conferencing-with-zoom-api" ) );
			}
		}

		//Get Template
		//Requiring Thickbox
		add_thickbox();
		require_once ZOOM_VIDEO_CONFERENCE_PLUGIN_VIEWS_PATH . '/admin/tpl-list-users.php';
	}

	/**
	 * Add Zoom users view
	 *
	 * @since   1.0.0
	 * @changes in CodeBase
	 * @author  Deepen Bajracharya <dpen.connectify@gmail.com>
	 */
	public static function add_zoom_users() {
		wp_enqueue_script( 'video-conferencing-with-zoom-api-js' );
		wp_enqueue_script( 'video-conferencing-with-zoom-api-select2-js' );
		wp_enqueue_script( 'video-conferencing-with-zoom-api-timepicker-js' );

		wp_enqueue_style( 'video-conferencing-with-zoom-api-timepick' );
		wp_enqueue_style( 'video-conferencing-with-zoom-api' );
		wp_enqueue_style( 'video-conferencing-with-zoom-api-select2' );

		if ( isset( $_POST['add_zoom_user'] ) ) {
			check_admin_referer( '_zoom_add_user_nonce_action', '_zoom_add_user_nonce' );
			$postData = array(
				'action'     => filter_input( INPUT_POST, 'action' ),
				'email'      => sanitize_email( filter_input( INPUT_POST, 'email' ) ),
				'first_name' => sanitize_text_field( filter_input( INPUT_POST, 'first_name' ) ),
				'last_name'  => sanitize_text_field( filter_input( INPUT_POST, 'last_name' ) ),
				'type'       => filter_input( INPUT_POST, 'type' )
			);

			$created_user = zoom_conference()->createAUser( $postData );
			$result       = json_decode( $created_user );
			if ( ! empty( $result->errors ) ) {
				foreach( $result->errors as $error ) {
					self::set_message( 'error', $error->message );
				}
			} else {
				self::set_message( 'updated', __( "Created a User. Please check email for confirmation. Added user will only appear in the list after approval.", "video-conferencing-with-zoom-api" ) );

				//After user has been created delete this transient in order to fetch latest Data.
				delete_transient( '_zvc_user_lists' );

				/**
				 * Fires after a user has been Created
				 *
				 * @since  2.0.1
				 *
				 * @param ID , EMAIL_ADDRESS
				 */
				do_action( 'zvc_after_create_user', $created_user->id, $created_user->email );
			}
		}

		//Get Template
		require_once ZOOM_VIDEO_CONFERENCE_PLUGIN_VIEWS_PATH . '/admin/tpl-add-user.php';
	}

	static function assign_host_id() {
		wp_enqueue_script( 'video-conferencing-with-zoom-api-js' );
		wp_enqueue_script( 'video-conferencing-with-zoom-api-datable-js' );

		wp_enqueue_style( 'video-conferencing-with-zoom-api' );
		wp_enqueue_style( 'video-conferencing-with-zoom-api-datable' );

		if ( isset( $_POST['saving_host_id'] ) ) {
			check_admin_referer( '_zoom_assign_hostid_nonce_action', '_zoom_assign_hostid_nonce' );

			$host_ids = filter_input( INPUT_POST, 'zoom_host_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
			foreach ( $host_ids as $k => $host_id ) {
				update_user_meta( $k, 'user_zoom_hostid', $host_id );
			}

			self::set_message( 'updated', __( "Saved !", "video-conferencing-with-zoom-api" ) );
		}

		require_once ZOOM_VIDEO_CONFERENCE_PLUGIN_VIEWS_PATH . '/admin/tpl-assign-host-id.php';
	}

	static function get_message() {
		return self::$message;
	}

	static function set_message( $class, $message ) {
		self::$message = '<div class=' . $class . '><p>' . $message . '</p></div>';
	}
}

new Zoom_Video_Conferencing_Admin_Users();