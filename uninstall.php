<?php
// Exit if called directly
if (!defined('ABSPATH')) {
    exit();
}
$addSocialShareSettings = get_option( 'addsocialshare_settings' );
if ( ! isset( $addSocialShareSettings['delete_options'] )  || $addSocialShareSettings['delete_options'] == 1 ) {
	$addSocialShareOption = 'addsocialshare_settings';
	// For Single site
	if ( ! is_multisite()  ) {
		delete_option(  $addSocialShareOption  );
	}else {
		// For Multisite
		global $wpdb;
		$addSocialShare_blog_ids = $wpdb->get_col(  "SELECT blog_id FROM $wpdb->blogs"  );
		$original_blog_id = get_current_blog_id();
		foreach (  $blog_ids as $blog_id  ) {
			switch_to_blog(  $blog_id  );
			delete_site_option( $addSocialShareOption );
		}
		switch_to_blog(  $original_blog_id  );
	}
}