<?php
//Defining Varaibles
$zoom_api_key = get_option( 'zoom_api_key' );
$zoom_api_secret = get_option( 'zoom_api_secret' );
$zoom_url_enable = get_option( 'zoom_url_enable' );
$zoom_vanity_url = get_option( 'zoom_vanity_url' );
$zoom_alternative_join = get_option( 'zoom_alternative_join' );
$zoom_help_text_disable = get_option( 'zoom_help_text_disable' );
$zoom_compatiblity_text_disable = get_option( 'zoom_compatiblity_text_disable' );
?>
<div class="wrap">
    <h1><?php _e( 'Settings', 'video-conferencing-with-zoom-api' ); ?></h1>

    <?php video_conferencing_zoom_api_show_like_popup(); ?>

    <div class="zvc-row">
        <div class="zvc-position-floater-left">
            <form action="?page=zoom-video-conferencing-settings" method="POST">
                <?php wp_nonce_field( '_zoom_settings_update_nonce_action', '_zoom_settings_nonce' ); ?>
                <h2><strong><?php _e('Please follow', 'video-conferencing-with-zoom-api') ?> <a target="_blank" href="https://elearningevolve.com/blog/zoom-api-keys/"><?php _e('this guide', 'video-conferencing-with-zoom-api') ?> </a> <?php _e('to generate the below API values from your Zoom account', 'video-conferencing-with-zoom-api') ?></strong></h2>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th><label><?php _e( 'API Key', 'video-conferencing-with-zoom-api' ); ?></label></th>
                            <td><input type="password" style="width: 400px;" name="zoom_api_key" id="zoom_api_key" value="<?php echo !empty( $zoom_api_key ) ? esc_html( $zoom_api_key ) : ''; ?>"> <a href="javascript:void(0);" class="toggle-api">Show</a></td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'API Secret Key', 'video-conferencing-with-zoom-api' ); ?></label></th>
                            <td><input type="password" style="width: 400px;" name="zoom_api_secret" id="zoom_api_secret" value="<?php echo !empty( $zoom_api_secret ) ? esc_html ( $zoom_api_secret ) : ''; ?>"> <a href="javascript:void(0);" class="toggle-secret">Show</a></td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Vanity URL', 'video-conferencing-with-zoom-api' ); ?></label></th>
                            <td>
                                <input type="url" name="vanity_url" class="regular-text" value="<?php echo ( $zoom_vanity_url ) ? esc_attr( $zoom_vanity_url ) : ''; ?>">
                                <p class="description">If you are using Zoom Vanity URL then please insert it here else leave it empty.</p>
                                <a href="https://support.zoom.us/hc/en-us/articles/215062646-Guidelines-for-Vanity-URL-Requests">Read more about Vanity URLs</a>
                            </td>
                        </tr>
                        <tr class="alternative-btn-text">
                            <th><label><?php _e( 'Text for alternative meeting join button', 'video-conferencing-with-zoom-api' ); ?></label></th>
                            <td>
                                <input type="text" name="zoom_alternative_join" class="regular-text" value="<?php echo ( $zoom_alternative_join ) ? esc_html( $zoom_alternative_join ) : ''; ?>" placeholder="JOIN MEETING VIA ALTERNATIVE WAY">
                                <p class="description"><?php _e( 'You can change the text on alternative meeting join button displayed on meeting page with this field.', 'video-conferencing-with-zoom-api' ); ?></p>
                            </td>
                        </tr>
                        <tr class="zoom-btn-class">
                            <th><label><?php _e( 'CSS classes to add on buttons', 'video-conferencing-with-zoom-api' ); ?></label></th>
                            <td>
                                <input type="text" name="zoom_btn_css_class" class="regular-text" value="<?php echo ( $zoom_btn_css_class ) ? esc_html( $zoom_btn_css_class ) : ''; ?>" placeholder="my-theme-btn-class my-theme-btn-class2 my-theme-btn-class3">
                                <p class="description"><?php _e( 'You can add CSS classes separated by a SINGLE SPACE used in your theme for button styling here.', 'video-conferencing-with-zoom-api' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Hide help text above Zoom Window', 'video-conferencing-with-zoom-api' ); ?></label></th>
                            <td>
                                <select name="zoom_help_text_disable">
                                    <option <?php echo ( $zoom_help_text_disable == 0 ) ? 'selected="selected"' : ''; ?> name="no" value="0"><?php _e( 'No', 'video-conferencing-with-zoom-api' ) ?></option>
                                    <option <?php echo ( $zoom_help_text_disable == 1 ) ? 'selected="selected"' : ''; ?> name="yes" value="1"><?php _e( 'Yes', 'video-conferencing-with-zoom-api' ) ?></option>
                                </select>
                                <p class="description">Show/Hide help text and Zoom App links above the Zoom Window on the page where you place Zoom shortcode.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Hide alternative meeting join button', 'video-conferencing-with-zoom-api' ); ?></label></th>
                            <td>
                                <select name="zoom_compatiblity_text_disable">
                                    <option <?php echo ( $zoom_compatiblity_text_disable == 0 ) ? 'selected="selected"' : ''; ?> name="no" value="0"><?php _e( 'No', 'video-conferencing-with-zoom-api' ) ?></option>
                                    <option <?php echo ( $zoom_compatiblity_text_disable == 1 ) ? 'selected="selected"' : ''; ?> name="yes" value="1"><?php _e( 'Yes', 'video-conferencing-with-zoom-api' ) ?></option>
                                </select>
                                <p class="description">Show/Hide alternative meeting join button above the Zoom Window on the page where you place the shortcode.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit"><input type="submit" name="save_zoom_settings" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'inactive-logout' ); ?>"></p>
            </form>

            <hr>
            <section class="zoom-api-example-section">
                <h3>Using Shortcode Example</h3>
                <p>Below are few examples of how you can add shortcodes manually into your posts.</p>

                <div class="zoom-api-basic-usage">
                    <h3>Basic Usage:</h3>
                    <code>[zoom_api_link meeting_id="123456789" class="zoom-meeting-window" id="zoom-meeting-window" title=""]</code>
                    <div class="zoom-api-basic-usage-description">
                        <label>Parameters:</label>
                        <ul>
                            <li><strong>meeting_id</strong> : Your meeting ID on meeting list page.</li>
                            <li><strong>class</strong> : CSS class</li>
                            <li><strong>id</strong> : CSS ID</li>
                            <li><strong>title</strong> : Title of the zoom window.</li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>

        <div class="zvc-position-floater-right">
            <ul class="zvc-information-sec">
                <li><a target="_blank" href="https://elearningevolve.com.np/learndash-zoom-integration/"><?php _e( 'Plugin guide', 'video-conferencing-with-zoom-api' ); ?></a></li>
                <li><a target="_blank" href="https://elearningevolve.com/contact/"><?php _e( 'Contact for additional Support', 'video-conferencing-with-zoom-api' ); ?></a></li>
            </ul>
            <div class="zvc-information-sec">
                <h3>Did you know?</h3>
                <p>You can improve your LearnDash course by encouraging your students to become active contributors on your courses via my <a target="_blank" href="https://elearningevolve.com/products/learndash-student-voice/">LearnDash Student Voice Addon </a></p>
            </div>
        </div>
    </div>
    <div class="zvc-position-clear"></div>
</div>
