<?php
add_action('init', 'sm_register_student_cpt');

function sm_register_student_cpt() {
    $labels = [
        'name'           => 'Sinh viên',
        'singular_name'  => 'Sinh viên',
        'add_new'        => 'Thêm mới sinh viên',
        'all_items'      => 'Tất cả sinh viên',
    ];

    $args = [
        'labels'         => $labels,
        'public'         => true,
        'has_archive'    => true,
        'menu_icon'      => 'dashicons-id',
        'supports'       => ['title', 'editor'],
        'show_in_rest'   => true, 
    ];
    
    register_post_type('sinh_vien', $args);
}