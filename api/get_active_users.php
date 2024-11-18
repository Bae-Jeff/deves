<?php
include_once('../bbs/_common.php');

header('Content-Type: application/json');

// 정의된 비밀 키, 실제 환경에서는 더 복잡하고 예측 불가능한 키를 사용해야 합니다.
$definedSecretKey = "yourSecretKey";

// GET 파라미터로부터 secretkey를 받아옵니다.
$secretKeyReceived = isset($_GET['secretkey']) ? $_GET['secretkey'] : '';

// 받아온 secretkey가 정의된 비밀 키와 일치하는지 검증합니다.
if ($secretKeyReceived !== $definedSecretKey) {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid secret key'));
    exit;
}

$list = array();
$query = "SELECT client_id, mb_id, last_heartbeat FROM active_users";
$result = sql_query($query);
while ($row = sql_fetch_array($result)) {
    $list[] = array(
        'client_id' => $row['client_id'],
        'mb_id' => $row['mb_id'],
        'last_heartbeat' => $row['last_heartbeat']
    );
}

echo json_encode(array('status' => 'success', 'active_users' => $list));
?>
