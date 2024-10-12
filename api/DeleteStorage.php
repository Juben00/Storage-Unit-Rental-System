<?php
require_once '../classes/admin.class.php';

$adminObj = new Admin();

session_start();

if (!isset($_SESSION['customer'])) {
    header('location: index.php');
    exit;
}

$id = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $deleteResult = $adminObj->deleteStorage($id);

    // Return the result as JSON
    echo json_encode($deleteResult);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
}

exit;
