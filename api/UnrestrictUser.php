<?php
require_once '../classes/admin.class.php';

if (isset($_GET['id'])) {
    $adminObj = new Admin();
    $response = $adminObj->unrestrictUser($_GET['id']);
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>