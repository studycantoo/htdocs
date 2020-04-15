<?php if (!defined('ABSPATH')) exit; //Exit if accessed directly ?>

<?php
get_header();
stm_lms_register_style('enterprise_groups');
stm_lms_register_script('enterprise-groups', array('vue.js', 'vue-resource.js'));
wp_localize_script('stm-lms-enterprise-groups', 'stm_lms_groups', array(
    'limit' => STM_LMS_Enterprise_Courses::get_group_common_limit(),
    'translations' => array(
        'group_limit' => esc_html__('Group Limit:', 'masterstudy-lms-learning-management-system-pro'),
    )
));
do_action('stm_lms_template_main');
?>

    <div class="stm-lms-wrapper stm-lms-wrapper--gradebook">
        <div class="container">
            <div class="stm-lms-wrapper--gradebook_header">

                <a href="<?php echo esc_url(STM_LMS_User::user_page_url()); ?>">
                    <i class="lnricons-arrow-left"></i>
                    <?php esc_html_e('Back to account', 'masterstudy-lms-learning-management-system-pro'); ?>
                </a>

            </div>

            <div id="stm_lms_enterprise_groups" v-bind:class="{'loading': loading}">

                <div class="row">

                    <div class="col-sm-6">
                        <?php STM_LMS_Templates::show_lms_template('enterprise_groups/groups'); ?>
                    </div>

                    <div class="col-sm-6">
                        <?php STM_LMS_Templates::show_lms_template('enterprise_groups/edit_group'); ?>
                    </div>

                </div>

            </div>

            <?php do_action('stm_lms_after_groups_end'); ?>

        </div>
    </div>

<?php get_footer(); ?>