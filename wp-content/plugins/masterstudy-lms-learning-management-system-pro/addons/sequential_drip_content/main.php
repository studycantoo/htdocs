<?php

new STM_LMS_Sequential_Drip_Content;

class STM_LMS_Sequential_Drip_Content
{

    function __construct()
    {

        add_filter('stm_lms_curriculum_item_status', array($this, 'curriculum_item_status'), 10, 4);
        add_filter('stm_lms_lesson_content', array($this, 'lesson_content'), 10, 3);
        add_filter('stm_lms_prev_status', array($this, "prev_status"), 10, 4);

        add_filter('stm_wpcfto_boxes', array($this, 'sequential_boxes'));
        add_filter('stm_wpcfto_fields', array($this, 'sequential_fields'));

        add_filter('wpcfto_options_page_setup', array($this, 'stm_lms_settings_page'));

    }

    /*Settings*/
    function stm_lms_settings_page($setups)
    {

        $setups[] = array(
            'page' => array(
                'parent_slug' => 'stm-lms-settings',
                'page_title' => 'Sequential Drip Content',
                'menu_title' => 'Sequential Drip Content',
                'menu_slug' => 'sequential_drip_content',
            ),
            'fields' => $this->stm_lms_settings(),
            'option_name' => 'stm_lms_sequential_drip_content_settings'
        );

        return $setups;
    }

    function stm_lms_settings()
    {
        return apply_filters('stm_lms_sequential_drip_content_settings', array(
            'credentials' => array(
                'name' => esc_html__('Credentials', 'masterstudy-lms-learning-management-system-pro'),
                'fields' => array(
                    'locked' => array(
                        'type' => 'checkbox',
                        'label' => esc_html__('Lock lessons sequentially', 'masterstudy-lms-learning-management-system-pro'),
                        'value' => false
                    ),
                )
            ),
        ));
    }

    function stm_lms_get_settings()
    {
        return get_option('stm_lms_sequential_drip_content_settings', array());
    }

    function stm_lms_settings_page_view()
    {
        $metabox = $this->stm_lms_settings();
        $settings = $this->stm_lms_get_settings();

        foreach ($metabox['args']['stm_lms_sequential_drip_content_settings'] as $section_name => $section) {
            foreach ($section['fields'] as $field_name => $field) {
                $default_value = (!empty($field['value'])) ? $field['value'] : '';
                $metabox['args']['stm_lms_sequential_drip_content_settings'][$section_name]['fields'][$field_name]['value'] = (!empty($settings[$field_name])) ? $settings[$field_name] : $default_value;
            }
        }
        $title = esc_html__('Sequential Drip Content Settings', 'masterstudy-lms-learning-management-system-pro'); ?>
        <script>
            const STM_LMS_EventBus = new Vue();
        </script>
        <?php require_once(STM_LMS_PATH . '/settings/view/main.php');
    }

    function stm_save_settings()
    {
        if (!current_user_can('manage_options')) die;

        if (empty($_REQUEST['name'])) die;
        $id = sanitize_text_field($_REQUEST['name']);
        $settings = array();
        $request_body = file_get_contents('php://input');
        if (!empty($request_body)) {
            $request_body = json_decode($request_body, true);
            foreach ($request_body as $section_name => $section) {
                foreach ($section['fields'] as $field_name => $field) {
                    $settings[$field_name] = $field['value'];
                }
            }
        }

        wp_send_json(update_option($id, $settings));
    }

    /*Filters*/
    function curriculum_item_status($html, $previous_completed, $course_id, $item_id)
    {

        $settings = self::stm_lms_get_settings();

        if (!empty($settings['locked']) and empty($previous_completed)) {
            $html = '<div class="stm-curriculum-item__completed locked">
                <i class="fa fa-lock"></i>
            </div>';
        }

        $parent_passed = self::is_parent_passed($course_id, $item_id);
        if (!$parent_passed) {
            $html = '<div class="stm-curriculum-item__completed locked">
                <i class="fa fa-lock"></i>
            </div>';
        }

        return $html;
    }

    function lesson_content($html, $post_id, $item_id)
    {

        $settings = self::stm_lms_get_settings();
        if (empty($settings['locked'])) {

            /*Check Deps*/
            $parent_passed = self::is_parent_passed($post_id, $item_id, true);
            if (isset($parent_passed['passed']) and !$parent_passed['passed']) {
                $prev_lesson_url = STM_LMS_Course::item_url($post_id, $parent_passed['parent']);
                wp_safe_redirect($prev_lesson_url);
            }

            return $html;
        }

        $curriculum = get_post_meta($post_id, 'curriculum', true);
        if (!empty($curriculum)) {
            $curriculum = explode(',', $curriculum);
            $curriculum = array_values(array_filter($curriculum, function ($value) {
                return is_numeric($value);
            }));
        }

        $item_order = array_search($item_id, $curriculum);

        /*First item is always allowed to do*/
        if ($item_order === 0) {
            return $html;
        }

        /*Check if prev lesson is passed*/
        $prev_lesson = (!empty($curriculum[$item_order - 1])) ? $curriculum[$item_order - 1] : 0;
        $is_prev_lesson_completed = STM_LMS_Lesson::is_lesson_completed('', $post_id, $prev_lesson);

        if (!$is_prev_lesson_completed) {
            $prev_lesson_url = STM_LMS_Course::item_url($post_id, $prev_lesson);
            wp_safe_redirect($prev_lesson_url);
        } else {
            return $html;
        }

        return $html;

    }

    function prev_status($status, $course_id, $item_id, $user_id)
    {

        $settings = self::stm_lms_get_settings();
        if (empty($settings['locked'])) $status = '';

        /*Check Item Deps*/
        $parent_passed = self::is_parent_passed($course_id, $item_id, false, $user_id);
        $status = (!$parent_passed) ? '' : 'opened';

        return "prev-status-{$status}";
    }

    /*Boxes*/
    function sequential_boxes($boxes)
    {
        $boxes['stm_courses_sequential'] = array(
            'post_type' => array('stm-courses'),
            'label' => esc_html__('Sequential Drip Content', 'masterstudy-lms-learning-management-system-pro'),
        );
        return $boxes;
    }

    function sequential_fields($fields)
    {
        $fields['stm_courses_sequential'] = array(
            'section_prereqs' => array(
                'name' => esc_html__('Sequential Drip Content', 'masterstudy-lms-learning-management-system-pro'),
                'fields' => array(
                    'drip_content' => array(
                        'type' => 'drip_content',
                        'post_type' => array('stm-lessons', 'stm-quizzes'),
                        'label' => esc_html__('Sequential Drip Content', 'masterstudy-lms-learning-management-system-pro'),
                    ),
                )
            )
        );

        return $fields;
    }

    function is_parent_passed($course_id, $item_id, $get_parent = false, $user_id = '')
    {
        $check_parent_passed = true;

        $item_id = intval($item_id);

        $drip_content = get_post_meta($course_id, 'drip_content', true);

        if (!empty($drip_content)) {
            $drip_content = json_decode($drip_content, true);
            if (!empty($drip_content)) {
                foreach ($drip_content as $drip_content_single) {
                    //wp_send_json($drip_content_single);
                    if (!empty($drip_content_single['childs'])) {
                        foreach ($drip_content_single['childs'] as $drip_content_child) {
                            if ($item_id === $drip_content_child['id']) {
                                $parent = $drip_content_single['parent']['id'];
                                $check_parent_passed = STM_LMS_Lesson::is_lesson_completed($user_id, $course_id, $parent);
                                if ($get_parent) {
                                    $check_parent_passed = array(
                                        'passed' => $check_parent_passed,
                                        'parent' => $parent
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }

        return $check_parent_passed;
    }
}