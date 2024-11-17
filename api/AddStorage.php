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

    if (empty($_FILES['storageImages']['name'][0])) {
        $imageErr[] = 'At least one image is required.';
    } else {
        $uploadedImages = [];
        $allowedType = ['jpg', 'jpeg', 'png'];
        $uploadDir = '/storageImages/';

        foreach ($_FILES['storageImages']['name'] as $key => $image) {
            $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

            // Validate each image
            if (!in_array($imageFileType, $allowedType)) {
                $imageErr[] = "File " . $_FILES['storageImages']['name'][$key] . " has an invalid format. Only jpg, jpeg, and png are allowed.";
            } else {
                // Generate a unique target path for each image
                $targetImage = $uploadDir . uniqid() . '.' . $imageFileType;

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES['storageImages']['tmp_name'][$key], '..' . $targetImage)) {
                    $uploadedImages[] = $targetImage; // Save the file path for future use
                } else {
                    $imageErr[] = "Failed to upload image: " . $_FILES['storageImages']['name'][$key];
                }
            }
        }

        // Check if any images were successfully uploaded
        if (!empty($uploadedImages)) {
            // Convert the array of uploaded file paths into a JSON-encoded string
            $image = json_encode($uploadedImages);
        } else {
            $imageErr[] = "No images were successfully uploaded.";
        }
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
