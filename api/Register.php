<?php
require_once '../classes/customer.class.php';
require_once '../sanitize.php';

$customerObj = new Customer();

$firstname = $lastname = $birthdate = $sex = $phone = $address = $email = $password = $cpassword = "";
$firstnameErr = $lastnameErr = $birthdateErr = $sexErr = $phoneErr = $addressErr = $emailErr = $passwordErr = $cpasswordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = clean_input($_POST["firstname"]);
    $lastname = clean_input($_POST["lastname"]);
    $birthdate = clean_input($_POST["birthdate"]);
    $sex = clean_input($_POST['sex']);
    $phone = clean_input($_POST["phone"]);
    $address = clean_input($_POST["address"]);
    $email = clean_input($_POST["email"]);
    $password = clean_input($_POST["password"]);
    $cpassword = clean_input($_POST["cpassword"]);

    // Validate input fields
    if (empty($firstname)) {
        $firstnameErr = "First Name is required";
    }
    if (empty($lastname)) {
        $lastnameErr = "Last Name is required";
    }
    if (empty($birthdate)) {
        $birthdateErr = "Birthdate is required";
    }
    if (empty($sex)) {
        $sexErr = "Please select your sex";
    }
    if (empty($phone)) {
        $phoneErr = "Phone is required";
    }
    if (empty($address)) {
        $addressErr = "Address is required";
    }
    if (empty($email)) {
        $emailErr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }
    if (empty($password)) {
        $passwordErr = "Password is required";
    } elseif (strlen($password) < 8) {
        $passwordErr = "Password must be at least 8 characters long";
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
        $passwordErr = "Password must include letters, numbers, and special characters";
    }
    if (empty($cpassword)) {
        $cpasswordErr = "Confirm Password is required";
    }

    if (empty($firstnameErr) && empty($lastnameErr) && empty($birthdateErr) && empty($sexErr) && empty($phoneErr) && empty($addressErr) && empty($emailErr) && empty($passwordErr) && empty($cpasswordErr)) {
        $customerObj->firstname = $firstname;
        $customerObj->lastname = $lastname;
        $customerObj->birthdate = $birthdate;
        $customerObj->sex = $sex;
        $customerObj->phone = $phone;
        $customerObj->address = $address;
        $customerObj->email = $email;
        $customerObj->password = $password;
        $customerObj->cpassword = $cpassword;

        $signupResult = $customerObj->signup();

        // Return success or error message
        $response = $signupResult;
        echo json_encode($response);
        exit; // Prevent any unintended output
    } else {
        // Compile errors and return them
        $feedbackMessage = implode("<br>", array_filter([$firstnameErr, $lastnameErr, $birthdateErr, $sexErr, $phoneErr, $addressErr, $emailErr, $passwordErr, $cpasswordErr]));
        $response = ["status" => "error", "message" => $feedbackMessage, "source" => "signup"];
        echo json_encode($response);
        exit;
    }
}
