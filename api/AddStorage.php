<?php
require_once '../classes/admin.class.php';
require_once '../sanitize.php';
require_once './imageUpload.api.php';

$adminObj = new Admin();

$name = $area = $category = $price = $status = $description = $image = "";
$nameErr = $areaErr = $categoryErr = $priceErr = $statusErr = $descriptionErr = $imageErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = clean_input($_POST["storageName"]);
    $area = clean_input($_POST["storageArea"]);
    $description = clean_input($_POST["storageDescription"]);
    $category = clean_input($_POST["storageCategory"]);
    $price = clean_input($_POST["storagePrice"]);

    // Check if images were uploaded
    if (!empty($_FILES['storageImages']['name'][0])) {
        $uploadedImages = [];

        // Loop through each uploaded file and upload to Cloudinary
        for ($i = 0; $i < count($_FILES['storageImages']['name']); $i++) {
            $imageTmpName = $_FILES['storageImages']['tmp_name'][$i];

            try {
                // Upload to Cloudinary and store the URL
                $result = uploadImage($imageTmpName);
                $uploadedImages[] = $result;
            } catch (Exception $e) {
                echo "Error uploading image: " . $e->getMessage();
                continue; // Skip the current image and continue with the next one
            }
        }

        // Join URLs into a comma-separated string or store as JSON array
        $image = json_encode($uploadedImages);
    } else {
        $imageErr = "Please upload at least one image.";
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
    if (empty($image)) {
        $imageErr = "Image is required";
    }
    if (empty($area)) {
        $areaErr = "Area is required";
    }

    // If no errors, proceed with saving to the database
    if (empty($nameErr) && empty($areaErr) && empty($categoryErr) && empty($priceErr) && empty($descriptionErr) && empty($imageErr)) {
        $adminObj->image = $image; // Store the image URLs as JSON
        $adminObj->name = $name;
        $adminObj->area = $area;
        $adminObj->description = $description;
        $adminObj->category = $category;
        $adminObj->price = $price;

        $addStorageResult = $adminObj->addStorage();

        // Return success or error message
        $response = $addStorageResult;
        echo json_encode($response);
        exit; // Prevent any unintended output
    } else {
        // Compile errors and return them
        $feedbackMessage = implode("<br>", array_filter([$nameErr, $categoryErr, $priceErr, $descriptionErr, $imageErr]));
        $response = ["status" => "error", "message" => $feedbackMessage];
        echo json_encode($response);
        exit;
    }
}
