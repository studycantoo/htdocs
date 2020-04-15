<?php
extract( shortcode_atts( array(
	'css'   => ''
), $atts ) );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

stm_module_styles('searchbox'); ?>

<div class="stm_searchbox <?php echo esc_attr($css_class); ?>">
    <form action="<?php echo esc_url(STM_LMS_Course::courses_page_url()); ?>">
        <input name="search" class="form-control" placeholder="<?php esc_attr_e('Search Courses...', 'masterstudy'); ?>" />
        <button type="submit">
            <i class="lnricons-magnifier"></i>
        </button>
    </form>
</div>
