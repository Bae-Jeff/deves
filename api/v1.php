<?php
header('Access-Control-Allow-Origin: *');
error_reporting(E_ERROR); // 모든 오류 보고
ini_set('display_errors', 1); // 오류를 화면에 표시
// API 요청 처리
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include_once('../common.php');
    include_once(G5_LIB_PATH.'/ExtShop/ExtShopItem.php');
    include_once(G5_LIB_PATH.'/ExtShop/ExtShopItemLog.php');
    include_once(G5_LIB_PATH.'/ExtShop/ExtShopItemOrder.php');
    $extItemLog = new ExtShopItemLog($db,true);
    $method = isset($_GET['method']) ? $_GET['method'] : '';

    switch ($method) {
        case 'getItems':
            error_reporting(E_ERROR); // 모든 오류 보고
            ini_set('display_errors', 1); // 오류를 화면에 표시
            if (isset($_GET['member_id'])) {
                $member_id = $_GET['member_id'];
                $token = $_GET['token'];
                $rsKeyLogs = $extItemLog->getKeyLogs([
                    'member_id' => $member_id,
                    'page' => !(empty($_GET['page']))??1,
                    'per_page' => !(empty($_GET['per_page']))??10,
                ]);
                resonseJson($rsKeyLogs);
            } else {
                http_response_code(400);
                resonseJson(["error" => "Missing user_id parameter"]);
            }
            break;

        case 'getItemStatus':
            if (isset($_GET['uuid'])) {
                $uuid = $_GET['uuid'];
                $rsKeyLogInfo = $extItemLog->getLogItemStatus(['uuid' => $uuid]);
                resonseJson($rsKeyLogInfo);
            } else {
                http_response_code(400);
                resonseJson(["error" => "Missing uuid parameter"]);
            }
            break;

        case 'getItemOrders':
            if (isset($_GET['uuid'])) {
                $uuid = $_GET['uuid'];
                $rsItemOrders = $extItemLog->getLogDetail([
                    'uuid' => $uuid,
                    'page' => !(empty($_GET['page']))??1,
                    'per_page' => !(empty($_GET['per_page']))??10,
                ]);
                resonseJson($rsItemOrders);
            } else {
                http_response_code(400);
                resonseJson(["error" => "Missing uuid parameter"]);
            }
            break;

        case 'getItemOrderDetail':
            if (isset($_GET['uuid'])) {
                $uuid = $_GET['uuid'];
                resonseJson(getItemOrderDetail($uuid));
            } else {
                http_response_code(400);
                resonseJson(["error" => "Missing uuid parameter"]);
            }
            break;

        default:
            http_response_code(404);
            resonseJson(["error" => "Endpoint not found"]);
            break;
    }
} else {
    http_response_code(405);
    resonseJson(["error" => "Method not allowed"]);
}
function resonseJson($params){
    header('Content-Type: application/json');
    echo json_encode([
        'code' => $params['code']??200,
        'message' => $params['message']??'success',
        'result' => $params['result']??[]
    ],JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}


/*

https://deves.mycafe24.com/api/v1.php?method=getItems&member_id=admin
https://deves.mycafe24.com/api/v1.php?method=getItemStatus&uuid=256718fa-387d-4684-9a74-0e60b15ea28d
https://deves.mycafe24.com/api/v1.php?method=getItemOrders&uuid=256718fa-387d-4684-9a74-0e60b15ea28d

 * */