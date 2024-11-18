<?php
//header('Access-Control-Allow-Origin: *');
global $db;
error_reporting(E_ERROR); // 모든 오류 보고
ini_set('display_errors', 1); // 오류를 화면에 표시
// API 요청 처리
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include_once('../common.php');
    include_once(G5_LIB_PATH.'/ExtShop/ExtShopItem.php');
    include_once(G5_LIB_PATH.'/ExtShop/ExtShopItemLog.php');
    include_once(G5_LIB_PATH.'/ExtShop/ExtShopItemOrder.php');
    $extItem = new ExtShopItem($db,true);
    $extItemLog = new ExtShopItemLog($db,true);
    $method = isset($_GET['method']) ? $_GET['method'] : '';

    switch ($method) {
        case 'getItemInfo':
            $itemId = $_GET['item_id']??null;
            if(!empty($itemId)) {
                $rsItemInfo = $extItem->getItemInfo(['item_id' => $itemId]);
                resonseJson($rsItemInfo);
            }else{
                http_response_code(400);
                resonseJson(["error" => "Missing user_id parameter"]);
            }
            break;
        case 'getItems':
            error_reporting(E_ERROR); // 모든 오류 보고
            ini_set('display_errors', 1); // 오류를 화면에 표시
            if (isset($_GET['member_id'])) {
                $member_id = $_GET['member_id'];
                $token = $_GET['token'];
                $rsKeyLogs = $extItemLog->getKeyLogs([
                    'member_id' => $member_id,
                    'page' => !empty($_GET['page']) && is_numeric($_GET['page'])?$_GET['page']:1,
                    'per_page' => !empty($_GET['per_page']) && is_numeric($_GET['per_page'])?$_GET['per_page']:10,
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
                    'page' => !empty($_GET['page']) && is_numeric($_GET['page'])?$_GET['page']:1,
                    'per_page' => !empty($_GET['per_page']) && is_numeric($_GET['per_page'])?$_GET['per_page']:10,
                ]);
                resonseJson($rsItemOrders);
            } else {
                http_response_code(400);
                resonseJson(["error" => "Missing uuid parameter"]);
            }
            break;
        case 'download':
            if (isset($_GET['uuid']) && isset($_GET['link_key'])) {
                $extItemLog->isApi = false;
                $rsItemStatus = $extItemLog->getLogItemStatus(['uuid' => $_GET['uuid']]);

                $downloadStatus =  $rsItemStatus['downloadStatus']??[];
                if(isset($downloadStatus['days']) && $downloadStatus['days'] > 0){
                    $link_key = $_GET['link_key'];
                    $rsDownloadLink = $db->select(['item_ext_link'])
                        ->from('ext_shop_item')
                        ->where([
                            'item_id' => $rsItemStatus['itemId'],
                            'item_ext_link_key' => $link_key,
                            'item_ext_status' => 'U'
                        ])
                        ->getOne();
                    // 해당링크로 이동
                    if(!empty($rsDownloadLink)){
                        if(filter_var($rsDownloadLink['item_ext_link'], FILTER_VALIDATE_URL) !== false){
                            header('Location: '.$rsDownloadLink['item_ext_link']);
                        }else{
                            resonseJson(["code"=> 400,"message" => "유효하지 않은 링크입니다.(Not Url Format)"]);
                        }
                    }else{
                        // 해당링크가 없을경우 alert
                        resonseJson(["code"=> 400,"message" => "유효하지 않은 링크입니다.(Not Url Format)"]);
                    }
                }else{
                    resonseJson(["code"=> 400,"message" => "다운로드 기한이 만료된 링크입니다."]);
                    exit;
                }

            } else {
                resonseJson(["code"=> 400,"message" => "유효하지 않은 링크입니다."]);
                exit;
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
https://localhost8080.cafe24.com/api/v1.php?method=getItems&member_id=admin&page=2&per_page=20
https://localhost8080.cafe24.com/api/v1.php?method=getItemStatus&uuid=256718fa-387d-4684-9a74-0e60b15ea28d
https://localhost8080.cafe24.com/api/v1.php?method=getItemOrders&uuid=256718fa-387d-4684-9a74-0e60b15ea28d&page=1&per_page=20
https://localhost8080.cafe24.com/api/v1.php?method=download&uuid=70d14244-5d46-4d58-b33b-dbc184831246&link_key=1727453788342VT5NLU
*/