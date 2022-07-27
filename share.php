<?php
// Exit if called directly
if (!defined('ABSPATH')) {
    exit();
}
$stickyInterfaceContentCount = 0;

function addsocialshare_share_content($content) {
    global $post;
    $addSocialShareMeta = get_post_meta($post->ID, '_addsocialshare_meta', true);
    // if sharing disabled on this page/post, return content unaltered
    if (isset($addSocialShareMeta['sharing']) && $addSocialShareMeta['sharing'] == 1 && !is_front_page()) {
        return $content;
    }
    global $addSocialShareSettings, $ass_interfaceDiv;
    $addSocialShareSettings['addsocialshare_sharingTitle'] = isset($addSocialShareSettings['addsocialshare_sharingTitle']) ? trim($addSocialShareSettings['addsocialshare_sharingTitle']) : '';
    if (isset($addSocialShareSettings['inline_shareEnable']) && $addSocialShareSettings['inline_shareEnable'] == '1') {
        $ass_interfaceDiv = 'ass_interface_' . rand();
        $inlineDiv = "<div><b>" . $addSocialShareSettings['addsocialshare_sharingTitle'] . '</b><div class="' . $ass_interfaceDiv . '"></div></div>';
        if (( ( ( isset($addSocialShareSettings['inline_sharehome']) && current_filter() == 'the_content' ) || ( isset($addSocialShareSettings['inline_shareexcerpt']) && current_filter() == 'get_the_excerpt' ) ) && is_front_page() ) || ( isset($addSocialShareSettings['inline_sharepost']) && is_single() ) || ( isset($addSocialShareSettings['inline_sharepage']) && is_page() )) {
            if (isset($addSocialShareSettings['inline_shareTop']) && isset($addSocialShareSettings['inline_shareBottom'])) {
                $content = $inlineDiv . '<br/>' . $content . '<br/>' . $inlineDiv;
                add_action('wp_footer', 'addsocialshare_inline_share_scripts');
            } else {
                if (isset($addSocialShareSettings['inline_shareTop'])) {
                    $content = $inlineDiv . $content;
                    add_action('wp_footer', 'addsocialshare_inline_share_scripts');
                } elseif (isset($addSocialShareSettings['inline_shareBottom'])) {
                    $content = $content . $inlineDiv;
                    add_action('wp_footer', 'addsocialshare_inline_share_scripts');
                }
            }
        }
    }
    if (isset($addSocialShareSettings['sticky_shareEnable']) && $addSocialShareSettings['sticky_shareEnable'] == '1') {
        // show sticky sharing	
        if (( ( ( isset($addSocialShareSettings['sticky_sharehome']) && current_filter() == 'the_content' ) || ( isset($addSocialShareSettings['sticky_shareexcerpt']) && current_filter() == 'get_the_excerpt' ) ) && is_front_page() ) || ( isset($addSocialShareSettings['sticky_sharepost']) && is_single() ) || ( isset($addSocialShareSettings['sticky_sharepage']) && is_page() )) {
            if (is_front_page()) {
                if (current_filter() == 'the_content') {
                    $compareVariable = '$stickyInterfaceContentCount';
                } elseif (current_filter() == 'get_the_excerpt') {
                    $compareVariable = '$stickyInterfaceContentCount';
                }
                if ($$compareVariable == 0) {
                    add_action('wp_footer', 'addsocialshare_sticky_share_scripts');
                    $$compareVariable++;
                }
            } else {
                add_action('wp_footer', 'addsocialshare_sticky_share_scripts');
            }
        }
    }
    return $content;
}

function addsocialshare_inline_share_scripts() {
    global $addSocialShareSettings, $ass_interfaceDiv;
    $out = preg_replace("/<\/script(.*)<script>/i", "", $addSocialShareSettings['sharinginline_code']);
    $out = preg_replace("/id:\"(.*)\"/i", 'id:".' . $ass_interfaceDiv . '"', $out);
    $out = preg_replace("/<script>/i", '', $out);
    $out = preg_replace("/<\/script>/i", '', $out);
    ?>
    <script>
        var assInlineSharing = document.createElement('script');
        assInlineSharing.src = "<?php _e(plugins_url( 'js/socialshare.min.js?v=8<?php echo ADD_SOCIAL_SHARE_VERSION; ?>', __FILE__ ));?>";
		assInlineSharing.onload = () => {
            var shareInlineInterval = setInterval(() => {
                if (typeof (ass_SocialShare) == 'function') {
                    clearInterval(shareInlineInterval);
    <?php _e($out); ?>
                }
            }, 500);
        }
        document.head.appendChild(assInlineSharing);
    </script>
    <?php
}

function addsocialshare_sticky_share_scripts() {
    global $addSocialShareSettings;
    $out = preg_replace("/<\/script(.*)<script>/i", "", $addSocialShareSettings['sharingsticky_code']);
    $out = preg_replace("/<script>/i", '', $out);
    $out = preg_replace("/<\/script>/i", '', $out);
    ?>
    <script>
        var assStickySharing = document.createElement('script');
        assInlineSharing.src = "<?php _e(plugins_url( 'js/socialshare.min.js?v=8<?php echo ADD_SOCIAL_SHARE_VERSION; ?>', __FILE__ ));?>";
        assStickySharing.onload = () => {
            var shareStickyInterval = setInterval(() => {
                if (typeof (ass_SocialShare) == 'function') {
                    clearInterval(shareStickyInterval);
    <?php _e($out); ?>
                }
            }, 500);
        }
        document.head.appendChild(assStickySharing);
    </script>
    <?php
}

add_filter('the_content', 'addsocialshare_share_content');
add_filter('get_the_excerpt', 'addsocialshare_share_content');
