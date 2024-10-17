<?php

header('Content-Type: application/json');

// 사용자 정의 함수에 대한 예시 구현
function getItems($user_id) {
    // 데이터베이스에서 아이템을 가져오는 로직
    // 예시: 아이템 목록 반환
    return [
        ["id" => 1, "name" => "Item 1", "user_id" => $user_id],
        ["id" => 2, "name" => "Item 2", "user_id" => $user_id],
    ];
}

function getItemStatus($uuid) {
    // 데이터베이스에서 아이템 상태를 가져오는 로직
    // 예시: UUID에 대한 상태 반환
    return ["uuid" => $uuid, "status" => "available"];
}

function getItemOrders($uuid) {
    // UUID에 대한 주문 목록을 가져오는 로직
    // 예시: 주문 목록 반환
    return [
        ["order_id" => 1, "uuid" => $uuid, "status" => "shipped"],
        ["order_id" => 2, "uuid" => $uuid, "status" => "pending"],
    ];
}

function getItemOrderDetail($uuid) {
    // UUID에 대한 주문 세부 정보를 가져오는 로직
    // 예시: 주문 세부 정보 반환
    return [
        "order_id" => 1,
        "uuid" => $uuid,
        "items" => [
            ["item_id" => 1, "name" => "Item 1", "quantity" => 2],
            ["item_id" => 2, "name" => "Item 2", "quantity" => 1],
        ],
        "total" => 100.00,
    ];
}

// API 요청 처리
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : '';

    switch ($endpoint) {
        case 'getItems':
            if (isset($_GET['user_id'])) {
                $user_id = $_GET['user_id'];
                $token = $_GET['token'];

                echo json_encode(getItems($user_id));
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