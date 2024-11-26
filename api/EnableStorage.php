<?php
require_once '../classes/admin.class.php';

if (isset($_GET['id'])) {
    $storageId = intval($_GET['id']);
    $adminObj = new Admin();

    $result = $adminObj->enableStorage($storageId);

    echo json_encode($result); // Directly echo the result
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid storage ID.']);
}
?>