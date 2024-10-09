<?php
require_once '../classes/customer.class.php';
require_once '../sanitize.php';

$customerObj = new Customer();
$email = $password = "";
$emailErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = clean_input($_POST["email"]);
    $password = clean_input($_POST["password"]);

    if (empty($email)) {
        $emailErr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }
    if (empty($password)) {
        $passwordErr = "Password is required";
    }

    if (empty($emailErr) && empty($passwordErr)) {
        $customerObj->email = $email;
        $customerObj->password = $password;

        $loginResult = $customerObj->login();

        // Return success or error message
        $response = $loginResult;
        echo json_encode($response);
        exit; // Prevent any unintended output
    } else {
        // Compile errors and return them
        $feedbackMessage = implode("<br>", array_filter([$firstnameErr, $lastnameErr, $birthdateErr, $sexErr, $phoneErr, $addressErr, $emailErr, $passwordErr, $cpasswordErr]));
        $response = ["status" => "error", "message" => $feedbackMessage];
        echo json_encode($response);
        exit;
    }
}
