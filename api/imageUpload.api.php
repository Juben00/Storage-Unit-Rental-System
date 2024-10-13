<?php

require_once '../vendor/autoload.php';
use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

function uploadImage($file)
{
    Configuration::instance([
        'cloud' => [
            'cloud_name' => 'ddujkyfzj',
            'api_key' => '897774582825532',
            'api_secret' => 'DC5Y_PbDb6Dvv2hAgHvXGB1STnE',
        ],
        'url' => [
            'secure' => true
        ]
    ]);

    try {
        // Uploading the image to Cloudinary
        $uploadResult = (new UploadApi())->upload($file['tmp_name'], [
            'folder' => 'blu',
            'public_id' => 'user_' . uniqid(),
        ]);

        // Return the secure URL of the uploaded image
        return $uploadResult['secure_url'];

    } catch (Exception $e) {
        // Return the error message instead of success URL
        return "Upload failed: " . $e->getMessage();
    }
}
