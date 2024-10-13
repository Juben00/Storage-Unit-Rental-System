<?php

require_once '../vendor/autoload.php';
use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

function uploadImage($fileTmpName)
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
        $uploadResult = (new UploadApi())->upload($fileTmpName, [
            'folder' => 'blu',
            'public_id' => 'user_' . uniqid(),
        ]);

        return $uploadResult['secure_url'];

    } catch (Exception $e) {
        // Return the error message instead of success URL
        return "Upload failed: " . $e->getMessage();
    }
}
