<?php
require_once '../classes/admin.class.php';

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    $adminObj = new Admin();

    $result = $adminObj->restrictUser($userId);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'User restricted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to restrict user']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>