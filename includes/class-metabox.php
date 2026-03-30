<?php
add_action('add_meta_boxes', 'sm_add_student_metabox');
function sm_add_student_metabox() {
    add_meta_box('sm_details', 'Thông tin chi tiết sinh viên', 'sm_render_metabox', 'sinh_vien', 'normal', 'high');
}

function sm_render_metabox($post) {
    // Sử dụng Nonce để bảo mật
    wp_nonce_field('sm_save_meta', 'sm_nonce');

    $mssv = get_post_meta($post->ID, '_sm_mssv', true);
    $lop = get_post_meta($post->ID, '_sm_lop', true);
    $ngay_sinh = get_post_meta($post->ID, '_sm_ngay_sinh', true);

    echo '<p><label>MSSV: </label><input type="text" name="sm_mssv" value="'.esc_attr($mssv).'" class="widefat"></p>';
    
    echo '<p><label>Lớp/Chuyên ngành: </label>';
    echo '<select name="sm_lop" class="widefat">';
    $options = ['CNTT', 'Kinh tế', 'Marketing'];
    foreach($options as $opt) {
        echo '<option value="'.$opt.'" '.selected($lop, $opt, false).'>'.$opt.'</option>';
    }
    echo '</select></p>';

    echo '<p><label>Ngày sinh: </label><input type="date" name="sm_ngay_sinh" value="'.esc_attr($ngay_sinh).'" class="widefat"></p>';
}

// Lưu dữ liệu
add_action('save_post', 'sm_save_student_meta');
function sm_save_student_meta($post_id) {
    if (!isset($_POST['sm_nonce']) || !wp_verify_nonce($_POST['sm_nonce'], 'sm_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['sm_mssv'])) update_post_meta($post_id, '_sm_mssv', sanitize_text_field($_POST['sm_mssv']));
    if (isset($_POST['sm_lop'])) update_post_meta($post_id, '_sm_lop', sanitize_text_field($_POST['sm_lop']));
    if (isset($_POST['sm_ngay_sinh'])) update_post_meta($post_id, '_sm_ngay_sinh', sanitize_text_field($_POST['sm_ngay_sinh']));
}