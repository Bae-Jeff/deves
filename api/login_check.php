<?php
include_once('../bbs/_common.php');

$g5['title'] = "로그인 검사";

// HTTP 상태 코드와 메시지를 설정하는 함수
function http_response($code = 200, $message = 'OK') {
    http_response_code($code);
    echo $message;
    exit;
}

// 입력 검증
if (!isset($_POST['mb_id']) || !isset($_POST['mb_password'])) {
    http_response(400, '회원아이디나 비밀번호가 입력되지 않았습니다.');
}

$mb_id = trim($_POST['mb_id']);
$mb_password = trim($_POST['mb_password']);

// 회원 정보 조회
$mb = get_member($mb_id);

// 회원 정보 검증
if (!$mb || !$mb['mb_id']) {
    http_response(401, '가입된 회원아이디가 아니거나 비밀번호가 틀립니다.');
}

// 비밀번호 검증
if (!check_password($mb_password, $mb['mb_password'])) {
    http_response(401, '가입된 회원아이디가 아니거나 비밀번호가 틀립니다.');
}

// 차단된 아이디 검증
if ($mb['mb_intercept_date'] && $mb['mb_intercept_date'] <= date("Ymd", G5_SERVER_TIME)) {
    http_response(403, '회원님의 아이디는 접근이 금지되어 있습니다.');
}

// 탈퇴한 아이디 검증
if ($mb['mb_leave_date'] && $mb['mb_leave_date'] <= date("Ymd", G5_SERVER_TIME)) {
    http_response(403, '탈퇴한 아이디이므로 접근하실 수 없습니다.');
}

// 메일인증 검증 (선택적)
// if (is_use_email_certify() && !preg_match("/[1-9]/", $mb['mb_email_certify'])) {
//     http_response(403, '메일인증이 필요합니다.');
// }

// 회원아이디 세션 생성 및 추가 로직 처리
set_session('ss_mb_id', $mb['mb_id']);
// 필요한 추가 로직이 있다면 여기에 구현

// 로그인 성공 응답
http_response(200, 'Login successful');
?>
