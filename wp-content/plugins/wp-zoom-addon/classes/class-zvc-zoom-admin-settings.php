<?php

/**
 * Registering the Pages Here
 *
 * @since   2.0.0
 * @author  Deepen
 */
class Zoom_Video_Conferencing_Admin_Views {

	public static $message = '';
	public $settings;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'zoom_video_conference_menus' ) );
	}

	/**
	 * Register Menus
	 *
	 * @since   1.0.0
	 * @changes in CodeBase
	 * @author  Deepen Bajracharya <dpen.connectify@gmail.com>
	 */
	public function zoom_video_conference_menus() {
		add_menu_page( 'Zoom', 'Zoom Meetings', 'manage_options', 'zoom-video-conferencing', array( 'Zoom_Video_Conferencing_Admin_Meetings', 'list_meetings' ), 'dashicons-video-alt2', 5 );
		if ( get_option( 'zoom_api_key' ) && get_option( 'zoom_api_secret' ) ) {
				add_submenu_page( 'zoom-video-conferencing', 'Meeting', __( 'Add Meeting', 'video-conferencing-with-zoom-api' ), 'manage_options', 'zoom-video-conferencing-add-meeting', array( 'Zoom_Video_Conferencing_Admin_Meetings', 'add_meeting' ) );
				add_submenu_page( 'zoom-video-conferencing', 'Users', __( 'Users', 'video-conferencing-with-zoom-api' ), 'manage_options', 'zoom-video-conferencing-list-users', array( 'Zoom_Video_Conferencing_Admin_Users', 'list_users' ) );
				add_submenu_page( 'zoom-video-conferencing', 'Add Users', __( 'Add Users', 'video-conferencing-with-zoom-api' ), 'manage_options', 'zoom-video-conferencing-add-users', array( 'Zoom_Video_Conferencing_Admin_Users', 'add_zoom_users' ) );
				add_submenu_page( 'zoom-video-conferencing', 'Reports', __( 'Reports', 'video-conferencing-with-zoom-api' ), 'manage_options', 'zoom-video-conferencing-reports', array( 'Zoom_Video_Conferencing_Reports', 'zoom_reports' ) );
				add_submenu_page( 'zoom-video-conferencing', __( 'Assign Host ID', 'video-conferencing-with-zoom-plank' ),
					 __( 'Assign Host ID', 'video-conferencing-with-zoom-plank' ), 'manage_options', 'zoom-video-conferencing-host-id-assign', array( 'Zoom_Video_Conferencing_Admin_Users', 'assign_host_id' ) );
		}
		add_submenu_page( 'zoom-video-conferencing', 'Settings', __( 'Settings', 'video-conferencing-with-zoom-api' ), 'manage_options', 'zoom-video-conferencing-settings', array( $this, 'zoom_video_conference_api_zoom_settings' ) );
	}


	/**
	 * Zoom Settings View File
	 *
	 * @since   1.0.0
	 * @changes in CodeBase
	 * @author  Deepen Bajracharya <dpen.connectify@gmail.com>
	 */
	public function zoom_video_conference_api_zoom_settings() {
		wp_enqueue_script( 'video-conferencing-with-zoom-api-js' );
		wp_enqueue_style( 'video-conferencing-with-zoom-api' );

		if ( get_option( 'zoom_api_key' ) && get_option( 'zoom_api_secret' ) ) {
			$encoded_users = zoom_conference()->listUsers();
			if ( ! empty( json_decode( $encoded_users )->error ) ) {
				?>
                <div id="message" class="notice notice-error">
                    <p><?php echo json_decode( $encoded_users )->error->message; ?></p>
                </div>
				<?php
			}
		}

		if ( isset( $_POST['save_zoom_settings'] ) ) {
			//Nonce
			check_admin_referer( '_zoom_settings_update_nonce_action', '_zoom_settings_nonce' );
			$zoom_api_key    = filter_input( INPUT_POST, 'zoom_api_key' );
			$zoom_api_secret = filter_input( INPUT_POST, 'zoom_api_secret' );
			$vanity_url = esc_url( filter_input( INPUT_POST, 'vanity_url' ) );
			$zoom_alternative_join = esc_html( filter_input( INPUT_POST, 'zoom_alternative_join' ) );
			$zoom_btn_css_class = esc_html( filter_input( INPUT_POST, 'zoom_btn_css_class' ) );
			$zoom_help_text_disable = filter_input( INPUT_POST, 'zoom_help_text_disable' );
			$zoom_compatiblity_text_disable = filter_input( INPUT_POST, 'zoom_compatiblity_text_disable' );

			update_option( 'zoom_api_key', $zoom_api_key );
			update_option( 'zoom_api_secret', $zoom_api_secret );
			update_option( 'zoom_vanity_url', $vanity_url );
			update_option( 'zoom_alternative_join', $zoom_alternative_join );
			update_option( 'zoom_btn_css_class', $zoom_btn_css_class );
			update_option( 'zoom_help_text_disable', $zoom_help_text_disable );
			update_option( 'zoom_compatiblity_text_disable', $zoom_compatiblity_text_disable );

			//After user has been created delete this transient in order to fetch latest Data.
			delete_transient( '_zvc_user_lists' );
			?>
            <div id="message" class="notice notice-success is-dismissible">
                <p><?php _e( 'Successfully Updated. Please refresh this page.', 'video-conferencing-with-zoom-api' ); ?></p>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e( 'Dismiss this notice.', 'video-conferencing-with-zoom-api' ); ?></span></button>
            </div>
			<?php
		}

		//Get Template
		require_once ZOOM_VIDEO_CONFERENCE_PLUGIN_VIEWS_PATH . '/admin/tpl-settings.php';
	}

	static function get_message() {
		return self::$message;
	}

	static function set_message( $class, $message ) {
		self::$message = '<div class=' . $class . '><p>' . $message . '</p></div>';
	}
}

new Zoom_Video_Conferencing_Admin_Views();
