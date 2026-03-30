<?php
add_shortcode('danh_sach_sinh_vien', 'sm_display_student_list');

function sm_display_student_list() {
    $args = [
        'post_type'      => 'sinh_vien',
        'posts_per_page' => -1,
        'status'         => 'publish'
    ];
    $query = new WP_Query($args);

    if (!$query->have_posts()) return "<p>Chưa có sinh viên nào trong danh sách.</p>";

    // Thêm wrapper div để hỗ trợ responsive và đổ bóng
    $output = '<div class="sm-table-wrapper">
                <table class="sm-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>MSSV</th>
                        <th>Họ tên</th>
                        <th>Lớp / Ngành</th>
                        <th>Ngày sinh</th>
                    </tr>
                </thead>
                <tbody>';
    
    $stt = 1;
    while ($query->have_posts()) {
        $query->the_post();
        $id = get_the_ID();
        
        $mssv = get_post_meta($id, '_sm_mssv', true);
        $lop = get_post_meta($id, '_sm_lop', true);
        $ngay_sinh = get_post_meta($id, '_sm_ngay_sinh', true);
        
        // Định dạng ngày tháng cho đẹp hơn (VD: 25/12/2000)
        $formatted_date = $ngay_sinh ? date('d/m/Y', strtotime($ngay_sinh)) : '---';

        $output .= '<tr>
            <td class="sm-stt">' . sprintf('%02d', $stt++) . '</td>
            <td><strong>' . esc_html($mssv) . '</strong></td>
            <td>' . get_the_title() . '</td>
            <td><span class="sm-badge">' . esc_html($lop) . '</span></td>
            <td>' . esc_html($formatted_date) . '</td>
        </tr>';
    }
    
    $output .= '</tbody></table></div>';
    wp_reset_postdata();
    
    return $output;
}