<?php
/**
 * @var $course_id
 * @var $item_id
 */
wp_enqueue_script('vue-resource.js');
stm_lms_register_script('buy-button');

$item_id = (!empty($item_id)) ? $item_id : '';

$has_course = STM_LMS_User::has_course_access($course_id, $item_id);
$course_price = STM_LMS_Course::get_course_price($course_id);

$is_affiliate = STM_LMS_Course_Pro::is_external_course($course_id);

if (!$is_affiliate):

    $is_prerequisite_passed = true;

    if(class_exists('STM_LMS_Prerequisites')) {
        $is_prerequisite_passed = STM_LMS_Prerequisites::is_prerequisite(true, $course_id);
    }

    ?>

    <div class="stm-lms-buy-buttons dddd">

		<?php if (($has_course or empty($course_price)) and $is_prerequisite_passed): ?>
			<?php STM_LMS_Templates::show_lms_template('global/buy-button-start', array('course_id' => $course_id)); ?>

		<?php else:
			$not_in_membership = get_post_meta($course_id, 'not_membership', true);
            ?>

			<?php if ($show_buttons = apply_filters('stm_lms_pro_show_button', true, $course_id)): ?>
				<?php STM_LMS_Templates::show_lms_template('global/buy-button-buy', array('course_id' => $course_id)); ?>

				<?php if (empty($not_in_membership) and STM_LMS_Subscriptions::subscription_enabled()): ?>

					<?php STM_LMS_Templates::show_lms_template('global/subscription'); ?>

				<?php endif; ?>

			<?php else: ?>

				<?php do_action('stm_lms_pro_instead_buttons', $course_id); ?>

			<?php endif; ?>

		<?php endif; ?>

    </div>

    <?php do_action('stm_lms_buy_button_end', $course_id); ?>

<?php endif;