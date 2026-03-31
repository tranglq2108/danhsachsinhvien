<?php
/*
Plugin Name: LearnPress Stats Dashboard
Description: Hien thi thong ke LearnPress
Version: 1.0
Author: Lê Quỳnh Trang
*/

function lp_get_stats() {
     global $wpdb;

     // Tong so khoa hoc
     $total_courses = wp_count_posts('lp_course')->publish;

     // Tong hoc vien (user co role student)
     $total_students = count(get_users([
          'role' => 'subscriber'
     ]));

     // So khoa hoc da hoan thanh
     $completed_courses = $wpdb->get_var("
          SELECT COUNT(*) 
          FROM {$wpdb->prefix}learnpress_user_items 
          WHERE status = 'completed'
          AND item_type = 'lp_course'
     ");

     return [
          'courses' => $total_courses,
          'students' => $total_students,
          'completed' => $completed_courses
     ];
     }

function lp_stats_dashboard_widget() {
      wp_add_dashboard_widget(
          'lp_stats_widget',
          'LearnPress Stats',
          'lp_stats_widget_display'
     );
}
add_action('wp_dashboard_setup', 'lp_stats_dashboard_widget');

function lp_stats_widget_display() {
     $stats = lp_get_stats();

     echo "<ul>";
     echo "<li>Tong khoa hoc: " . $stats['courses'] . "</li>";
     echo "<li>Tong hoc vien: " . $stats['students'] . "</li>";
     echo "<li>Khoa hoc da hoan thanh: " . $stats['completed'] . "</li>";
     echo "</ul>";
}

function lp_stats_shortcode() {
     $stats = lp_get_stats();

     ob_start();
     ?>
     <style>
          .lp-stats {
               display: flex;
               justify-content: center;
               gap: 20px;
               margin: 30px 0;
               flex-wrap: wrap;
               font-family: Arial, sans-serif;
          }

          .lp-item {
               border: 1px solid #e5e7eb;
               border-radius: 10px;
               padding: 20px 30px;
               text-align: center;
               min-width: 180px;
               background: #fff;
          }

          .lp-item h2 {
               margin: 0;
               font-size: 28px;
               color: #111827;
          }

          .lp-item span {
               display: block;
               margin-top: 5px;
               font-size: 14px;
               color: #6b7280;
          }
     </style>

     <div class="lp-stats">
          <div class="lp-item">
               <h2><?php echo $stats['courses']; ?></h2>
               <span>Khóa học</span>
          </div>

          <div class="lp-item">
               <h2><?php echo $stats['students']; ?></h2>
               <span>Học viên</span>
          </div>

          <div class="lp-item">
               <h2><?php echo $stats['completed']; ?></h2>
               <span>Hoàn thành</span>
          </div>
     </div>
     <?php

     return ob_get_clean();
}
add_shortcode('lp_total_stats', 'lp_stats_shortcode');