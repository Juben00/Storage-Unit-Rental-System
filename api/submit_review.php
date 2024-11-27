<?php
require_once '../classes/customer.class.php';
require_once '../sanitize.php';

$customerObj = new Customer();

session_start();

if (!isset($_SESSION['customer']['role_name'])) {
    header('Location: ./index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $storageId = $_POST['storage_id'];
    $userId = $_POST['user_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Sanitize inputs
    $storageId = clean_input($storageId);
    $userId = clean_input($userId);
    $rating = clean_input($rating);
    $review = clean_input($review);

    // Save the review
    $result = $customerObj->saveReview($storageId, $userId, $rating, $review);

    if ($result) {
        header('Location: ../profile.php?userId=' . $_SESSION['customer']['id']);
    } else {
        header('Location: ../storage_details.php?booking_id=' . $_GET['booking_id'] . '&review=error');
    }
    exit();
}
?>