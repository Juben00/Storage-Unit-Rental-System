<?php

require_once '../classes/customer.class.php';
require_once '../sanitize.php';

$customerObj = new Customer();

$storageId = $userId = "";
$storageIdErr = $userIdErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize POST data
    $storageId = clean_input($_POST['storageId']);
    $userId = clean_input($_POST['userId']);

    if (empty($storageId)) {
        $storageIdErr = "Storage ID is required";
    }
    if (empty($userId)) {
        $userIdErr = "User ID is required";
    }

    // If no errors, proceed to bookmark the storage
    if (empty($storageIdErr) && empty($userIdErr)) {
        // Use the sanitized $storageId for the function call
        $bookmarkResult = $customerObj->unbookmarkStorage($userId, $storageId);
        // Return success or error message
        $response = $bookmarkResult;
        echo json_encode($response);
        exit; // Prevent any unintended output

    } else {
        // Compile errors and return them
        $feedbackMessage = implode("<br>", array_filter([$userIdErr, $storageIdErr]));
        $response = ["status" => "error", "message" => $feedbackMessage];
        echo json_encode($response);
        exit;
    }
}