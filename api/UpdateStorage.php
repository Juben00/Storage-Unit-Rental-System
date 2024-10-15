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
    if (!empty($_FILES['u_image']['name'][0])) {
        $uploadedImages = []; // Array to store newly uploaded images
        foreach ($_FILES['u_image']['tmp_name'] as $key => $tmp_name) {
            // Check if the file is a valid image before attempting to upload
            if (getimagesize($tmp_name) !== false) {
                // Prepare file data
                $fileData = [
                    'tmp_name' => $tmp_name,
                    'name' => $_FILES['u_image']['name'][$key]
                ];

                // Call uploadImage with the single file data
                $uploadResult = uploadImage($fileData['tmp_name']);

                if (strpos($uploadResult, "Upload failed:") === false) {
                    // If upload was successful, add the secure URL to the uploaded images array
                    $uploadedImages[] = $uploadResult;
                } else {
                    // Log the error message or handle the failed upload
                    error_log("Failed to upload image: " . $uploadResult);
                }
            }
        }

        // Merge existing images with new uploads
        $existingImages = json_decode($_POST['existing_image'], true);
        $imageArray = array_merge($existingImages, $uploadedImages);
        $image = json_encode($imageArray); // Encode back to JSON for storing
    } else {
        // If no new images were uploaded, use the existing images
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
