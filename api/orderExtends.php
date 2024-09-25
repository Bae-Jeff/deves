<?php
header("Content-Type: application/json; charset=UTF-8");
include_once ('../common.php');

// Sample function to get item status
function getItemStatus($itemId) {
    // Example: Fetch item status from the database (pseudo code)
    // $status = Database::getItemStatusById($itemId);
    
    // For demo purposes, returning a mock status
    return array("itemId" => $itemId, "status" => "Available");
}

// Sample function to get item order history
function getItemOrderHistory($itemId) {
    // Example: Fetch order history from the database (pseudo code)
    // $orderHistory = Database::getItemOrderHistoryById($itemId);
    
    // For demo purposes, returning a mock order history
    return array(
        "itemId" => $itemId,
        "history" => array(
            array("orderId" => 1, "date" => "2023-01-01", "status" => "Shipped"),
            array("orderId" => 2, "date" => "2023-02-15", "status" => "Delivered"),
        )
    );
}

// Fetching the action and item ID from the URL parameters
$action = isset($_GET['action']) ? $_GET['action'] : null;
$itemId = isset($_GET['itemId']) ? $_GET['itemId'] : null;
$userId = $_SESSION['ss_mb_id']??null;

if ($action && $itemId && $userId) {
    switch ($action) {
        case 'getItemStatus':
            $response = getItemStatus($itemId);
            break;
        case 'getItemOrderHistory':
            $response = getItemOrderHistory($itemId);
            break;
        default:
            $response = array("error" => "Invalid action specified");
    }
} else {
    $response = array("error" => "Action and itemId parameters are required");
}

// Returning the JSON response
echo json_encode($response);