<?php
include_once('../bbs/_common.php');

// 입력값 검증
$client_id = isset($_POST['client_id']) ? trim($_POST['client_id']) : '';
$mb_id = isset($_POST['mb_id']) ? trim($_POST['mb_id']) : ''; // mb_id 받기
$timestamp = date('Y-m-d H:i:s'); // 현재 시간을 사용

// client_id와 mb_id가 제공되었는지 확인
if ($client_id == '' || $mb_id == '') {
    echo json_encode(array('status' => 'error', 'message' => 'Missing client_id or mb_id'));
    exit;
}

// SQL 쿼리 준비
$sql = "INSERT INTO active_users (client_id, mb_id, last_heartbeat) 
        VALUES ('$client_id', '$mb_id', '$timestamp') 
        ON DUPLICATE KEY UPDATE 
            last_heartbeat = VALUES(last_heartbeat), 
            client_id = VALUES(client_id)";

// 쿼리 실행
$result = sql_query($sql);

if ($result) {
    echo json_encode(array('status' => 'success', 'message' => 'Heartbeat updated successfully'));
} else {
    // SQL 오류 메시지 반환
    $error_msg = sql_error();
    echo json_encode(array('status' => 'error', 'message' => "Failed to update heartbeat: $error_msg"));
}
?>
