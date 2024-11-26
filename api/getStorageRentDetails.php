<?php
require_once '../classes/admin.class.php';

header('Content-Type: application/json');

if (isset($_GET['storage_id'])) {
    $storageId = intval($_GET['storage_id']);
    $adminObj = new Admin();

    try {
        $rentDetails = $adminObj->getStorageRentDetails($storageId);
        echo json_encode($rentDetails);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Storage ID not provided']);
}
?>