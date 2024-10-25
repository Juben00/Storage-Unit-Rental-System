<?php
require_once '../classes/admin.class.php';
require_once '../sanitize.php';

$adminObj = new Admin();

// Ensure the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data
    $input = json_decode(file_get_contents("php://input"), true);

    $id = $input['id'] ?? null;

    if (empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'ID is required']);
        exit;
    } else {
        // Approve the booking
        $result = $adminObj->approvePendingBook($id);
        echo json_encode($result);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}
