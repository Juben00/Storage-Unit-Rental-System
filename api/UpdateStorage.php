<?php
require_once '../classes/admin.class.php';
require_once '../sanitize.php';
require_once './imageUpload.api.php';

$adminObj = new Admin();

$name = $category = $price = $status = $description = $image = $stock = $id = "";
$nameErr = $categoryErr = $priceErr = $statusErr = $descriptionErr = $imageErr = $stockErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = clean_input($_POST["u_id"]);
    $name = clean_input($_POST["u_storageName"]);
    $category = clean_input($_POST["u_category"]);
    $price = clean_input($_POST["u_price"]);
    $description = clean_input($_POST["u_description"]);
    $stock = clean_input($_POST["u_stock"]);

    // Check if a new image was uploaded
    if ($_FILES['u_image']['error'] === 0 && getimagesize($_FILES['u_image']['tmp_name']) !== false) {
        $image = uploadImage($_FILES['u_image']); // Upload new image if provided
    } else {
        // If no new image is uploaded, use the existing image
        $image = $_POST['existing_image'];
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
    if (empty($description)) {
        $descriptionErr = "Description is required";
    }
    if (empty($stock)) {
        $stockErr = "Stock is required";
    }

    if (empty($nameErr) && empty($categoryErr) && empty($priceErr) && empty($descriptionErr) && empty($stockErr)) {
        $adminObj->id = $id;
        $adminObj->name = $name;
        $adminObj->category = $category;
        $adminObj->price = $price;
        $adminObj->description = $description;
        $adminObj->image = $image;
        $adminObj->stock = $stock;

        $updateStorageResult = $adminObj->updateStorage();

        $response = $updateStorageResult;
        echo json_encode($response);
        exit;
    } else {
        $feedbackMessage = implode("<br>", array_filter([$nameErr, $categoryErr, $priceErr, $descriptionErr, $stockErr]));
        $response = ["status" => "error", "message" => $feedbackMessage];
        echo json_encode($response);
        exit;
    }
}
