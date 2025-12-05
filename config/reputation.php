<?php

return [
    // Chi phí các hành động (trừ điểm)
    'costs' => [
        'create_tag' => 10,        // Tạo tag mới
        'edit_question' => 5,      // Sửa câu hỏi người khác
    ],
    
    // Phần thưởng (cộng điểm)
    'rewards' => [
        'post_question' => 5,      // Đăng câu hỏi
        'post_answer' => 10,       // Trả lời
        'best_answer' => 25,       // Câu trả lời được chọn best
        'receive_upvote' => 10,    // Nhận upvote
    ],
    
    // Yêu cầu tối thiểu để thực hiện hành động
    'requirements' => [
        'create_tag' => 50,        // Cần 50 điểm để tạo tag
        'edit_others_post' => 100, // Cần 100 điểm để sửa bài người khác
    ],
];