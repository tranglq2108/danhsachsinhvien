<?php
/**
 * Plugin Name: LP Custom Enhancements
 * Description: Custom features for LearnPress courses
 * Version: 1.0
 */

if (!defined('ABSPATH')) exit;

/* =========================
   1. NOTIFICATION BAR
========================= */
add_action('wp_body_open', 'lp_custom_notification_bar');

function lp_custom_notification_bar() {
     if (!function_exists('learn_press_get_current_user')) return;

     echo '<div class="lp-notification-bar">';

     if (is_user_logged_in()) {
          $current_user = wp_get_current_user();
          echo "Chào " . esc_html($current_user->display_name) . ", bạn đã sẵn sàng bắt đầu bài học hôm nay chưa?";
     } else {
          echo "Đăng nhập để lưu tiến độ học tập!";
     }

     echo '</div>';
}

/* =========================
   2. SHORTCODE
========================= */
add_shortcode('lp_course_info', 'lp_course_info_shortcode');

function lp_course_info_shortcode($atts) {

     $atts = shortcode_atts(['id' => ''], $atts);
     $course_id = intval($atts['id']);

     if (!$course_id) return "Thiếu ID khóa học";

     if (!function_exists('learn_press_get_course')) {
          return "LearnPress chưa được cài!";
     }

     $course = learn_press_get_course($course_id);
     if (!$course) return "Không tìm thấy khóa học";

     $lessons = $course->get_curriculum_items();
     $lesson_count = count($lessons);

     $duration = get_post_meta($course_id, '_lp_duration', true);

     $status = "Chưa đăng nhập";

     if (is_user_logged_in()) {
          $user = learn_press_get_current_user();
          $course_data = $user->get_course_data($course_id);

          if ($course_data) {
               if ($course_data->get_status() == 'finished') {
                    $status = "Đã hoàn thành";
               } else {
                    $status = "Đã đăng ký";
               }
          } else {
               $status = "Chưa đăng ký";
          }
     }

     ob_start();
     ?>
     <div class="lp-course-info">
          <p><strong>Số bài học:</strong> <?php echo $lesson_count; ?></p>
          <p><strong>Thời lượng:</strong> <?php echo esc_html($duration); ?></p>
          <p><strong>Trạng thái:</strong> <?php echo esc_html($status); ?></p>
     </div>
     <?php

     return ob_get_clean();
}

/* =========================
   3. CUSTOM CSS
========================= */
add_action('wp_head', 'lp_custom_styles');

function lp_custom_styles() {
     echo '<style>
          /* Notification Bar */
          .lp-notification-bar {
               background: #ff6600;
               color: #fff;
               padding: 10px;
               text-align: center;
               font-weight: bold;
          }

          /* Nút Enroll */
          .lp-button.button-enroll-course {
               background-color: #ff6600 !important;
               border-color: #ff6600 !important;
               color: #fff !important;
          }

          /* Nút Finish Course */
          .lp-button.button-finish-course {
               background-color: #28a745 !important;
               border-color: #28a745 !important;
               color: #fff !important;
          }

          /* Hover */
          .lp-button.button-enroll-course:hover,
          .lp-button.button-finish-course:hover {
               opacity: 0.8;
          }
     </style>';
}