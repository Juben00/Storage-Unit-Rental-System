<?php
require_once '../classes/admin.class.php';

header('Content-Type: application/json');

$adminObj = new Admin();

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['status'])) {
    $id = $data['id'];
    $status = $data['status'];

    $result = $adminObj->toggleTestimonialVisibility($id, $status);
    echo json_encode($result);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>