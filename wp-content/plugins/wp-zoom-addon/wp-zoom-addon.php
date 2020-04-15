<?php
/**
 * @link              http://elearningevolve.com
 * @since             3.1.2
 * @package           Zoom Video Conferencing on WordPress
 *
 * Plugin Name:       Zoom Video Conferencing on WordPress
 * Plugin URI:        http://elearningevolve.com/products/wordpress-zoom-addon
 * Description:       An extended version of Video Conferencing with Zoom API to allow Zoom meetings directly on your wordpress site
 * Version:           3.1.2
 * Author:            Deepen Bajracharya/Adeel Raza
 * Author URI:        http://elearningevolve.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       video-conferencing-with-zoom-api
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( "Not Allowed Here !" );
}

if( class_exists( 'Video_Conferencing_With_Zoom' ) ) {
	echo "<div class='error'><a target='_blank' href='https://elearningevolve.com/products/wordpress-zoom-integration/'>Zoom Video Conferencing on WordPress</a> is an extended version of the plugin already installed on your site <span style='color:red;'>Video Conferencing with Zoom API</span> and cannot be activated along with this plugin. Please disable plugin <span style='color:red;'>'Video Conferencing with Zoom API'</span> first to proceed.</div>";
	die;
}

$eevolve_constants = array(
	'ZVCW_ZOOM_STORE_URL'	=>	'https://elearningevolve.com',
	'ZVCW_ZOOM_ITEM_NAME'	=>	'Zoom Video Conferencing on WordPress',
	'ZVCW_ZOOM_ITEM_ID'  	=>	2117,
	'ZVCW_ZOOM_PLUGIN_VER'	=>	'3.1.2',
	'ZVCW_ZOOM_PLUGIN_NAME' =>	'Zoom Video Conferencing on WordPress'
);

foreach( $eevolve_constants as $constant => $value ) {
	if( !defined($constant) ) define( $constant, $value );
}

if( !class_exists( 'Zoom_SL_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/Zoom_SL_Plugin_Updater.php' );
}

register_activation_hook( __FILE__, "video_conferencing_zoom_api_activation" );
register_uninstall_hook( __FILE__, "video_conferencing_zoom_api_uninstall" );

function video_conferencing_zoom_api_activation() {
	if ( ! current_user_can( 'activate_plugins' ) )
		return;

	if ( is_plugin_active ( "video-conferencing-with-zoom-api/video-conferencing-with-zoom-api.php" ) ) {

		deactivate_plugins ( plugin_basename( __FILE__ ) );
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		echo "<div class='error'><a target='_blank' href='https://elearningevolve.com/products/wordpress-zoom-integration/'>Zoom Video Conferencing on WordPress</a> is an extended version of the plugin already installed on your site <span style='color:red;'>Video Conferencing with Zoom API</span> and cannot be activated along with this plugin. Please disable plugin <span style='color:red;'>'Video Conferencing with Zoom API'</span> first to proceed.</div>";
		die;
	}
}

function video_conferencing_zoom_api_uninstall() {
	$plugin_options = [ "zoom_api_key", "zoom_api_secret", "zoom_api_meeting_options", "zoom_vanity_url" ];

	foreach($plugin_options as $option) {
		delete_option($option);
	}
}

function video_conferencing_zoom_api_settings_link( $links ) {
	$settings_link = '<a href="admin.php?page=zoom-video-conferencing-settings">' . __( 'Settings' ) . '</a>';
	array_push( $links, $settings_link );
	return $links;
}

$plugin = plugin_basename( __FILE__ );

add_filter( "plugin_action_links_$plugin", 'video_conferencing_zoom_api_settings_link' );

// the main plugin class
require_once dirname( __FILE__ ) . '/includes/video-conferencing-with-zoom-init.php';

add_action( 'plugins_loaded', array( 'Video_Conferencing_With_Zoom', 'instance' ), 99 );
register_activation_hook( __FILE__, array( 'Video_Conferencing_With_Zoom', 'activator' ) );

// setup the updater
$zoom_updater = new Zoom_SL_Plugin_Updater( ZVCW_ZOOM_STORE_URL, __FILE__, array(
	'version' 		=> ZVCW_ZOOM_PLUGIN_VER, 		// current version number
	'license' 		=> 'cb8d8e26d857e43646dfe201bd8f60f7', 	// license key (used get_option above to retrieve from DB)
	'item_name'     => ZVCW_ZOOM_ITEM_NAME, 	// name of this plugin
	'author' 		=> 'Adeel Raza',  // author of this plugin
	'url'           => home_url()
)
);