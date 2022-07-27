<?php
// Exit if called directly
if (!defined('ABSPATH')) {
    exit();
}
/**
 * Register addsocialshare_settings and its sanitization callback. Add Login Radius meta box to pages and posts.
 */
function addsocialshare_options_init(){
	register_setting( 'addsocialshare_setting_options', 'addsocialshare_settings', 'addsocialshare_validate_options' );
}
add_action( 'admin_init', 'addsocialshare_options_init' );
/**
 * Validate plugin options.
 */
function addsocialshare_validate_options($addSocialShareSettings) {
    $message = __('Option updated!');
	$type = 'updated';
	add_settings_error('addsocialshare_option_notice', 'addsocialshare_option', $message, $type);
	return $addSocialShareSettings;
}

/**
 * Display options page.
 */
function addsocialshare_option_page() {
    $addSocialShareSettings = get_option('addsocialshare_settings');
    ?>
    <div class="wrapper">
        <form action="options.php" method="post">
            <?php settings_fields('addsocialshare_setting_options'); ?>
            <div class="header_div">
                <h2><img src="<?php echo plugins_url('images/logo.png', __FILE__); ?>"/>
                    <span>AddSocialShare <?php _e('Settings', 'addsocialshare') ?></span></h2>
            </div>
			<?php settings_errors();?>
            <div class="metabox-holder columns-2" id="post-body">
                <div class="inside">
                    <ul class="ass_tabs">
                        <li class="ass_active" onclick="document.getElementsByClassName('ass_active')[0].classList.remove('ass_active'); this.classList.add('ass_active'); document.getElementById('addSocialShare_sticky').style.display = 'none'; document.getElementById('addSocialShare_inline').style.display = 'table-row';">
                            Inline
                        </li>
                        <li onclick="document.getElementsByClassName('ass_active')[0].classList.remove('ass_active'); this.classList.add('ass_active'); document.getElementById('addSocialShare_sticky').style.display = 'table-row'; document.getElementById('addSocialShare_inline').style.display = 'none';">
                            Sticky
                        </li>
                    </ul>
                    <style>
                        .ass_tabs{margin: 0;margin-bottom: -1px}
                        ul.ass_tabs li {
                            display: inline-block;
                            background: #fff;
                            padding: 5px 20px;
                            color: #000;
                            margin-bottom:0;
                            border-radius: 10px 10px 0px 0px;
                            border: 1px solid #ddd;
                            cursor: pointer;
                        }
                        ul.ass_tabs li.ass_active,
                        ul.ass_tabs li:hover{
                            background: #29d;
                            color:#fff;
                        }
                    </style>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr id="addSocialShare_inline">
                            <td>
                                <div class="stuffbox" style="border-top: 1px solid #ccc;padding:10px;">
                                    <div class="addSocialShareQuestion">
                                        <?php _e('Enable inline sharing?', 'addsocialshare'); ?>
                                    </div>
                                    <div class="addSocialShareYesRadio">
                                        <input type="radio" name="addsocialshare_settings[inline_shareEnable]" value='1' <?php echo!isset($addSocialShareSettings['inline_shareEnable']) || $addSocialShareSettings['inline_shareEnable'] == '1' ? 'checked="checked"' : '' ?> /> <?php _e('Yes', 'addsocialshare') ?>
                                    </div>
                                    <input type="radio" name="addsocialshare_settings[inline_shareEnable]" value="0" <?php echo isset($addSocialShareSettings['inline_shareEnable']) && $addSocialShareSettings['inline_shareEnable'] == '0' ? 'checked="checked"' : '' ?> /> <?php _e('No', 'addsocialshare') ?>
                                    <div class="addSocialShareBorder2"></div>

                                    <div class="addSocialShareQuestion" style="margin-top:10px">
                                        <?php _e("Enter the text that display above the Sharing Interface.", 'addsocialshare'); ?>
                                    </div>
                                    <input type="text" name="addsocialshare_settings[addsocialshare_sharingTitle]" size="60" value="<?php
                                    if (isset($addSocialShareSettings['addsocialshare_sharingTitle'])) {
                                        _e(htmlspecialchars($addSocialShareSettings['addsocialshare_sharingTitle']));
                                    } else {
                                        _e('Share it now!', 'addsocialshare');
                                    }
                                    ?>" />

                                    <div class="addSocialShareBorder2"></div>

                                    <div class="addSocialShareQuestion" style="margin-top:10px">
    <?php _e("Enter code from `Add following line of code in <code>&lt;/body&gt;</code> section of your website`. Get inline sharing code <a href='https://addsocialshare.com/get-code/' target='_blank'>here</a>.", 'addsocialshare'); ?>
                                    </div>
                                    <textarea name="addsocialshare_settings[sharinginline_code]" rows="4"><?php if (isset($addSocialShareSettings['sharinginline_code'])) {
        _e(htmlspecialchars($addSocialShareSettings['sharinginline_code']));
    } ?></textarea>
                                    <div class="addSocialShareBorder2"></div>

                                    <div class="addSocialShareQuestion" style="margin-top:10px">
    <?php _e('Select interface position', 'addsocialshare'); ?> 
                                    </div>
                                    <input type="checkbox" name="addsocialshare_settings[inline_shareTop]" value='1' <?php echo isset($addSocialShareSettings['inline_shareTop']) && $addSocialShareSettings['inline_shareTop'] == 1 ? 'checked' : '' ?>/> <?php _e('Show above the content', 'addsocialshare'); ?> <br /> 
                                    <input type="checkbox" name="addsocialshare_settings[inline_shareBottom]" value='1' <?php echo isset($addSocialShareSettings['inline_shareBottom']) && $addSocialShareSettings['inline_shareBottom'] == 1 ? 'checked' : '' ?>/> <?php _e('Show below the content', 'addsocialshare'); ?> 					    <div class="addSocialShareBorder2"></div>

                                    <div class="addSocialShareQuestion" style="margin-top:10px">
    <?php _e('Where do you wonna display sharing interface?', 'addsocialshare'); ?>
                                    </div>
                                    <input type="checkbox" name="addsocialshare_settings[inline_sharehome]" value='1' <?php echo isset($addSocialShareSettings['inline_sharehome']) && $addSocialShareSettings['inline_sharehome'] == 1 ? 'checked' : '' ?>/> <?php _e('Show on homepage', 'addsocialshare'); ?> <br /> 
                                    <input type="checkbox" name="addsocialshare_settings[inline_sharepost]" value='1' <?php echo isset($addSocialShareSettings['inline_sharepost']) && $addSocialShareSettings['inline_sharepost'] == 1 ? 'checked' : '' ?>/> <?php _e('Show on posts', 'addsocialshare'); ?> 
                                    <br />
                                    <input type="checkbox" name="addsocialshare_settings[inline_sharepage]" value='1' <?php echo isset($addSocialShareSettings['inline_sharepage']) && $addSocialShareSettings['inline_sharepage'] == 1 ? 'checked' : '' ?>/> <?php _e('Show on pages', 'addsocialshare'); ?> <br /> 
                                    <input type="checkbox" name="addsocialshare_settings[inline_shareexcerpt]" value='1' <?php checked('1', @$addSocialShareSettings['inline_shareexcerpt']); ?>/> <?php _e('Show on post excerpts ', 'addsocialshare'); ?>
                                </div>
                            </td>
                        </tr>
                        <tr id="addSocialShare_sticky" style="display:none">
                            <td>
                                <div class="stuffbox" style="border-top: 1px solid #ccc;padding:10px;">
                                    <div class="addSocialShareQuestion">
    <?php _e('Enable sticky sharing?', 'addsocialshare'); ?>
                                    </div>

                                    <div class="addSocialShareYesRadio">
                                        <input type="radio" name="addsocialshare_settings[sticky_shareEnable]" value='1' <?php echo!isset($addSocialShareSettings['sticky_shareEnable']) || $addSocialShareSettings['sticky_shareEnable'] == '1' ? 'checked="checked"' : '' ?> /> <?php _e('Yes', 'addsocialshare') ?>
                                    </div>
                                    <input type="radio" name="addsocialshare_settings[sticky_shareEnable]" value="0" <?php echo isset($addSocialShareSettings['sticky_shareEnable']) && $addSocialShareSettings['sticky_shareEnable'] == '0' ? 'checked="checked"' : '' ?> /> <?php _e('No', 'addsocialshare') ?>

                                    <div class="addSocialShareBorder2"></div>
                                    <div class="addSocialShareQuestion" style="margin-top:10px">
    <?php _e("Enter code from `Add following line of code in <code>&lt;/body&gt;</code> section of your website`. Get sticky sharing code <a href='https://addsocialshare.com/get-code/' target='_blank'>here</a>.", 'addsocialshare'); ?>
                                    </div>
                                    <textarea name="addsocialshare_settings[sharingsticky_code]" rows="4"><?php if (isset($addSocialShareSettings['sharingsticky_code'])) {
        _e(htmlspecialchars($addSocialShareSettings['sharingsticky_code']));
    } ?></textarea>
                                    <div class="addSocialShareBorder2"></div>
                                    <div class="addSocialShareQuestion" style="margin-top:10px">
    <?php _e('Where do you wonna display sharing interface?', 'addsocialshare'); ?>
                                    </div>
                                    <input type="checkbox" name="addsocialshare_settings[sticky_sharehome]" value='1' <?php echo isset($addSocialShareSettings['sticky_sharehome']) && $addSocialShareSettings['sticky_sharehome'] == 1 ? 'checked' : '' ?>/> <?php _e('Show on homepage', 'addsocialshare'); ?> <br /> 
                                    <input type="checkbox" name="addsocialshare_settings[sticky_sharepost]" value='1' <?php echo isset($addSocialShareSettings['sticky_sharepost']) && $addSocialShareSettings['sticky_sharepost'] == 1 ? 'checked' : '' ?>/> <?php _e('Show on posts', 'addsocialshare'); ?> 
                                    <br />
                                    <input type="checkbox" name="addsocialshare_settings[sticky_sharepage]" value='1' <?php echo isset($addSocialShareSettings['sticky_sharepage']) && $addSocialShareSettings['sticky_sharepage'] == 1 ? 'checked' : '' ?>/> <?php _e('Show on pages', 'addsocialshare'); ?> <br /> 
                                    <input type="checkbox" name="addsocialshare_settings[sticky_shareexcerpt]" value='1' <?php checked('1', @$addSocialShareSettings['sticky_shareexcerpt']); ?>/> <?php _e('Show on post excerpts ', 'addsocialshare'); ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <input type="submit" name="save" class="button button-primary" value="<?php _e('Save Changes', 'addsocialshare'); ?>" />
        </form>
    </div>
    <?php
}
