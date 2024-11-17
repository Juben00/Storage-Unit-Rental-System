<?php
require_once '../classes/admin.class.php';
require_once '../sanitize.php';
require_once './imageUpload.api.php';

$adminObj = new Admin();

$name = $category = $price = $status = $description = $image = $id = $area = "";
$nameErr = $categoryErr = $priceErr = $statusErr = $descriptionErr = $imageErr = $areaErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = clean_input($_POST["u_id"]);
    $name = clean_input($_POST["u_storageName"]);
    $category = clean_input($_POST["u_category"]);
    $price = clean_input($_POST["u_price"]);
    $description = clean_input($_POST["u_description"]);
    $area = clean_input($_POST['u_area']);

    if (empty($_FILES['u_image']['name'][0])) {
        $imageErr[] = 'At least one image is required.';
    } else {
        $uploadedImages = [];
        $allowedType = ['jpg', 'jpeg', 'png'];
        $uploadDir = '/storageImages/';

        foreach ($_FILES['u_image']['name'] as $key => $image) {
            $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

            // Validate each image
            if (!in_array($imageFileType, $allowedType)) {
                $imageErr[] = "File " . $_FILES['u_image']['name'][$key] . " has an invalid format. Only jpg, jpeg, and png are allowed.";
            } else {
                // Generate a unique target path for each image
                $targetImage = $uploadDir . uniqid() . '.' . $imageFileType;

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES['u_image']['tmp_name'][$key], '..' . $targetImage)) {
                    $uploadedImages[] = $targetImage; // Save the file path for future use
                } else {
                    $imageErr[] = "Failed to upload image: " . $_FILES['u_image']['name'][$key];
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

    if (empty($nameErr) && empty($categoryErr) && empty($priceErr) && empty($descriptionErr)) {
        $adminObj->id = $id;
        $adminObj->name = $name;
        $adminObj->category = $category;
        $adminObj->price = $price;
        $adminObj->description = $description;
        $adminObj->image = $image;
        $adminObj->area = $area;


        $updateStorageResult = $adminObj->updateStorage();

        $response = $updateStorageResult;
        echo json_encode($response);
        exit;
    } else {
        $feedbackMessage = implode("<br>", array_filter([$nameErr, $categoryErr, $priceErr, $descriptionErr]));
        $response = ["status" => "error", "message" => $feedbackMessage];
        echo json_encode($response);
        exit;
    }
}
