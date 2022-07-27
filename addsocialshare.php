<?php
/*
Plugin Name:addsocialshare
Plugin URI: https://wordpress.org/plugins/addsocialshare/
Description: Add Social Sharing to your WordPress website.
Version: 1.0
Author: AddSocialShare Team
Author URI: https://addsocialshare.com
License: GPL2+
*/
// Exit if called directly
if (!defined('ABSPATH')) {
    exit();
}
define('ADD_SOCIAL_SHARE_VERSION',1.0);
require_once( 'function.php' );
require_once( 'admin.php' );

/**
 * Add the addsocialshare menu in the left sidebar in the admin
 */
function addsocialshare_admin_menu(){
	$page = add_menu_page( 'addsocialshare', '<b>AddSocialShare</b>', 'manage_options', 'addsocialshare', 'addsocialshare_option_page', plugins_url( 'images/icon.png', __FILE__ )  );
	add_action( 'admin_print_styles-' . $page, 'addsocialshare_options_page_style' );
}
add_action( 'admin_menu', 'addsocialshare_admin_menu' );

/**
 * Add option Settings css.
 */
function addsocialshare_options_page_style(){
	wp_enqueue_style( 'addsocialshare_options_page_style', plugins_url( 'css/optionsPage.css', __FILE__ ), false, ADD_SOCIAL_SHARE_VERSION);
}

/**
 * Add a settings link to the Plugins page, so people can go straight from the plugin page to the
 * settings page.
 */
function addsocialshare_filter_plugin_actions( $links, $file ) {
	static $thisPlugin;
	if ( ! $thisPlugin ) {
		$thisPlugin = plugin_basename( __FILE__ );
	}
	if ( $file == $thisPlugin ) {
		$settingsLink = '<a href="admin.php?page=addsocialshare">' . __( 'Settings' )  . '</a>';
		array_unshift( $links, $settingsLink ); // before other links
	}
	return $links;
}
add_filter( 'plugin_action_links', 'addsocialshare_filter_plugin_actions', 10, 2 );