<?php
if (!defined('ABSPATH')) exit; //Exit if accessed directly ?>

<?php
get_header();

do_action('stm_lms_template_main');
?>

    <div class="stm-lms-wrapper stm-lms-wrapper--assignments">

        <div class="container">

            <div id="stm_lms_user_bundles_archive">
                <?php STM_LMS_Templates::show_lms_template('bundles/my_bundles'); ?>
            </div>


        </div>

    </div>

<?php get_footer(); ?>