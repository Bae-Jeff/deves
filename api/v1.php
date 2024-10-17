<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// API 요청 처리
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $db = new DB(G5_MYSQL_HOST, G5_MYSQL_USER, G5_MYSQL_PASSWORD, G5_MYSQL_DB);
    $extItem = new ExtShopItem($db,true);
    $extItemLog = new ExtShopItemLog($db,true);
    $extItemOrder = new ExtShopItemOrder($db,true);

    $method = isset($_GET['method']) ? $_GET['method'] : '';

    switch ($method) {
        case 'getItems':
            if (isset($_GET['member_id'])) {
                $member_id = $_GET['member_id'];
                $token = $_GET['token'];
                $rsKeyLogs = $extItemLog->getKeyLogs(['member_id',$member_id]);
                dump($rsKeyLogs);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Missing user_id parameter"]);
            }
            break;

        case 'getItemStatus':
            if (isset($_GET['uuid'])) {
                $uuid = $_GET['uuid'];
                echo json_encode(getItemStatus($uuid));
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Missing uuid parameter"]);
            }
            break;

        case 'getItemOrders':
            if (isset($_GET['uuid'])) {
                $uuid = $_GET['uuid'];
                echo json_encode(getItemOrders($uuid));
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Missing uuid parameter"]);
            }
            break;

        case 'getItemOrderDetail':
            if (isset($_GET['uuid'])) {
                $uuid = $_GET['uuid'];
                echo json_encode(getItemOrderDetail($uuid));
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Missing uuid parameter"]);
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(["error" => "Endpoint not found"]);
            break;
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}