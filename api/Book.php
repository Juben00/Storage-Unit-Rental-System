<?php

require_once '../classes/customer.class.php';
require_once '../sanitize.php';

$customerObj = new Customer();

$customerId = $storageId = $startDate = $endDate = $totalAmount = $accountNumber = $paymentMethod = "";
$customerIdErr = $storageIdErr = $startDateErr = $endDateErr = $totalAmountErr = $paymentMethodErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $customerId = clean_input($_POST['customer_id']);
    $storageId = clean_input($_POST['storage_id']);
    $startDate = clean_input($_POST['start_date']);
    $endDate = clean_input($_POST['end_date']);
    $totalAmount = clean_input($_POST['total_amount']);
    $accountNumber = clean_input($_POST['account_number']);
    $paymentMethod = clean_input($_POST['payment_method']);

    // Validate Account Number
    if (empty($accountNumber)) {
        $accountNumberErr = "Account Number is required";
    } elseif (!preg_match('/^\d{11}$/', $accountNumber)) {
        $accountNumberErr = "Invalid Account Number. It must be 11 digits.";
    }

    // Validate Customer ID
    if (empty($customerId)) {
        $customerIdErr = "Customer ID is required";
    } elseif (!is_numeric($customerId)) {
        $customerIdErr = "Invalid Customer ID";
    }

    // Validate Storage ID
    if (empty($storageId)) {
        $storageIdErr = "Storage ID is required";
    } elseif (!is_numeric($storageId)) {
        $storageIdErr = "Invalid Storage ID";
    }

    // Validate Start Date
    if (empty($startDate)) {
        $startDateErr = "Start Date is required";
    } elseif (!validateDate($startDate)) {
        $startDateErr = "Invalid Start Date format";
    }

    // Validate End Date
    if (empty($endDate)) {
        $endDateErr = "End Date is required";
    } elseif (!validateDate($endDate)) {
        $endDateErr = "Invalid End Date format";
    } elseif (strtotime($endDate) < strtotime($startDate)) {
        $endDateErr = "End Date must be after Start Date";
    }

    // Validate Total Amount
    if (empty($totalAmount)) {
        $totalAmountErr = "Total Amount is required";
    } elseif (!is_numeric($totalAmount) || $totalAmount <= 0) {
        $totalAmountErr = "Invalid Total Amount";
    }

    // Validate Payment Method
    if (empty($paymentMethod)) {
        $paymentMethodErr = "Payment Method is required";
    }

    // If no errors, proceed to process the form
    if (empty($customerIdErr) && empty($storageIdErr) && empty($startDateErr) && empty($endDateErr) && empty($totalAmountErr) && empty($paymentMethodErr)) {

        $bookingResult = $customerObj->bookStorage($customerId, $storageId, $startDate, $endDate, $totalAmount, $accountNumber, $paymentMethod);

        $response = $bookingResult;

        echo json_encode($response);
        exit;
    } else {
        // Compile errors and return them
        $feedbackMessage = implode("<br>", array_filter([$customerIdErr, $storageIdErr, $startDateErr, $endDateErr, $totalAmountErr, $paymentMethodErr]));

        $response = ["status" => "error", "message" => $feedbackMessage];
        echo json_encode($response);
        exit;
    }
}

// Function to validate date format
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
