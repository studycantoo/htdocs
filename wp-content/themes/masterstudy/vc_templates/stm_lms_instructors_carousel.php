<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$uniq = stm_create_unique_id($atts);
$inline = '';
if (!empty($title_color)) {
    $inline = ".{$uniq} .stm_lms_instructors_carousel__top h3, .{$uniq} .stm_lms_instructors_carousel__top .h4 {color: {$title_color};}";
}

wp_enqueue_script('imagesloaded');
wp_enqueue_script('owl.carousel');
wp_enqueue_style('owl.carousel');
stm_module_styles('instructors_carousel', 'style_1', array(), $inline);
stm_module_scripts('instructors_carousel', 'style_1');

stm_lms_register_style('user');
stm_lms_register_style('instructors_grid');

$args = array(
    'per_row' => $per_row,
);

$user_args = array(
    'role' => STM_LMS_Instructor::role(),
    'number' => 10
);

if (!empty($sort) and $sort == 'rating') {
    $sort_args = array(
        'meta_key' => 'average_rating',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    );

    $user_args = array_merge($user_args, $sort_args);
}

$user_query = new WP_User_Query($user_args);
$results = $user_query->get_results();
?>
<div class="stm_lms_instructors_carousel_wrapper <?php echo esc_attr($uniq); ?> <?php if ($prev_next === 'disable') {
    echo esc_attr('no-nav');
} ?>">
    <div class="stm_lms_instructors_carousel"
         data-items="<?php echo esc_attr($per_row); ?>"
         data-items-md="<?php echo esc_attr($per_row_md); ?>"
         data-items-sm="<?php echo esc_attr($per_row_sm); ?>"
         data-items-xs="<?php echo esc_attr($per_row_xs); ?>"
         data-pagination="<?php echo esc_attr($pagination); ?>">
        <?php if (!empty($results)) : ?>
            <div class="stm_lms_instructors_carousel__top">

                <?php if (!empty($title)): ?>
                    <h3><?php echo wp_kses_post($title); ?></h3>
                <?php endif; ?>
                <a href="<?php echo esc_url(STM_LMS_Instructor::get_instructors_url()); ?>" class="h4">
                    <?php esc_html_e('View all', 'masterstudy'); ?> <i class="lnr lnr-arrow-right"></i>
                </a>
            </div>

            <div class="stm_lms_instructors__grid">
                <?php foreach ($user_query->get_results() as $user):
                    $user_profile_url = STM_LMS_User::user_public_page_url($user->ID);
                    $user = STM_LMS_User::get_current_user($user->ID, false, true);
                    $rating = STM_LMS_Instructor::my_rating_v2($user);

                    ?>
                    <a href="<?php echo esc_url($user_profile_url); ?>"
                       class="stm_lms_instructors__single stm_carousel_glitch">
                        <div class="stm_lms_user_side">

                            <?php if (!empty($user['avatar'])): ?>
                                <div class="stm-lms-user_avatar">
                                    <?php echo wp_kses_post($user['avatar']); ?>
                                </div>
                            <?php endif; ?>

                            <h3><?php echo esc_attr($user['login']); ?></h3>

                            <?php if (!empty($user['meta']['position'])): ?>
                                <h5><?php echo sanitize_text_field($user['meta']['position']); ?></h5>
                            <?php endif; ?>

                            <?php if (!empty($rating['total'])): ?>
                                <div class="stm-lms-user_rating">
                                    <div class="star-rating star-rating__big">
                                        <span style="width: <?php echo floatval($rating['percent']); ?>%;"></span>
                                    </div>
                                    <strong class="rating heading_font"><?php echo floatval($rating['average']); ?></strong>
                                    <div class="stm-lms-user_rating__total">
                                        <?php echo sanitize_text_field($rating['total_marks']); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if ($prev_next !== 'disable'): ?>
                <div class="stm_lms_courses_carousel__buttons">
                    <div class="stm_lms_courses_carousel__button stm_lms_courses_carousel__button_prev sbc_h sbrc_h">
                        <i class="fa fa-chevron-left"></i>
                    </div>
                    <div class="stm_lms_courses_carousel__button stm_lms_courses_carousel__button_next sbc_h sbrc_h">
                        <i class="fa fa-chevron-right"></i>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="stm_lms_instructors_carousel__top">
                <h3><?php esc_html_e('No instructors found', 'masterstudy'); ?></h3>
            </div>
        <?php endif; ?>
    </div>
</div>
