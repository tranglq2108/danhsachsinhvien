<?php
/**
 * Plugin Name: Sinh Viên
 * Description: Plugin tạo Custom Post Type để quản lý danh sách sinh viên chuyên nghiệp.
 * Version: 1.0
 * Author: Lê Quỳnh Trang
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Định nghĩa hằng số cho đường dẫn plugin
define ('SM_PATH', plugin_dir_path(__FILE__));

// Bao gồm file để xử lý logic
require_once SM_PATH . 'includes/class-cpt.php';
require_once SM_PATH . 'includes/class-metabox.php';
require_once SM_PATH . 'includes/class-shortcode.php';


add_action ('wp_enqueue_scripts', function(){
    wp_enqueue_style('sm-style', plugin_dir_url(__FILE__) . 'assets/style.css');
});