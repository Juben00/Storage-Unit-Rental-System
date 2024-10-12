<?php
require_once '../classes/admin.class.php';
require_once '../sanitize.php';
require_once './imageUpload.api.php';

$adminObj = new Admin();

$name = $category = $price = $status = $description = $image = $stock = "";
$nameErr = $categoryErr = $priceErr = $statusErr = $descriptionErr = $imageErr = $stockErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = clean_input($_POST["storageName"]);
    $category = clean_input($_POST["category"]);
    $price = clean_input($_POST["price"]);
    // $status = clean_input($_POST['sex']);
    $description = clean_input($_POST["description"]);
    $stock = clean_input($_POST["stock"]);

    if ($_FILES['image']['error'] === 0 && getimagesize($_FILES['image']['tmp_name']) !== false) {
        $image = uploadImage($_FILES['image']);
    } else {
        $imageErr = "Please upload a valid image file.";
    }


    // Validate input fields
    if (empty($name)) {
        $nameErr = "Storage Name is required";
    }
    if (empty($category)) {
        $categoryErr = "Category is required";
    }
    if (empty($price)) {
        $priceErr = "Price is required";
    }
    // if (empty($status)) {
    //     $statusErr = "Please select
    // }
    if (empty($description)) {
        $descriptionErr = "Description is required";
    }
    if (empty($image)) {
        $imageErr = "Image is required";
    }
    if (empty($stock)) {
        $stockErr = "Stock is required";
    }

    if (empty($nameErr) && empty($categoryErr) && empty($priceErr) && empty($descriptionErr) && empty($imageErr) && empty($stockErr)) {
        $adminObj->name = $name;
        $adminObj->category = $category;
        $adminObj->price = $price;
        // $adminObj->status = $status;
        $adminObj->description = $description;
        $adminObj->image = $image;
        $adminObj->stock = $stock;

        $addStorageResult = $adminObj->addStorage();

        // Return success or error message
        $response = $addStorageResult;
        echo json_encode($response);
        exit; // Prevent any unintended output
    } else {
        // Compile errors and return them
        $feedbackMessage = implode("<br>", array_filter([$nameErr, $categoryErr, $priceErr, $descriptionErr, $imageErr, $stockErr]));
        $response = ["status" => "error", "message" => $feedbackMessage];
        echo json_encode($response);
        exit;
    }
}