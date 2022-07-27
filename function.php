<?php
// Exit if called directly
if (!defined('ABSPATH')) {
    exit();
}
// plugin options
$addSocialShareSettings = get_option( 'addsocialshare_settings' );

// social share 
require_once( 'share.php' ); 

/** 
 * Shortcode for social sharing.
 */ 
function addsocialshare_shortcode( $params ) {
	$default = array( 
		'style' => '',
		'type' => 'inline',
	);
	extract( shortcode_atts( $default , $params )  );
	$return = '<div ';
	// sharing theme type
	if ( $type == 'sticky' ) {
		$return .= 'class="addSocialSharestickySharing" ';
	}else {
		$return .= 'class="addSocialShareinlineSharing" ';
	}
	// style 
	if ( $style != '' ) {
		$return .= 'style="'.$style.'"';
	}
	$return .= '></div>';
	return $return;
}
add_shortcode( 'addsocialshare_Share', 'addsocialshare_shortcode' );

// replicate Social Login configuration to the subblogs in the multisite network
if ( is_multisite() && is_main_site() ) {
	// replicate the social login config to the new blog created in the multisite network
	function addsocialshare_replicate_settings( $blogId ) {
		global $addSocialShareSettings;
		add_blog_option( $blogId, 'addsocialshare_settings', $addSocialShareSettings );
	}
	add_action( 'wpmu_new_blog', 'addsocialshare_replicate_settings' );
	// update the social login options in all the old blogs
	function addsocialshare_update_old_blogs( $oldConfig ) {
		$newConfig = get_option( 'addsocialshare_settings' );
		if ( isset( $newConfig['multisite_config'] )  && $newConfig['multisite_config'] == '1' ) {
			$blogs = get_blog_list( 0, 'all' );
			foreach ( $blogs as $blog ) {
				update_blog_option( $blog['blog_id'], 'addsocialshare_settings', $newConfig );
			}
		}
	}
	add_action( 'update_option_addsocialshare_settings', 'addsocialshare_update_old_blogs' );
}