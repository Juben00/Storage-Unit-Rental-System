<?php

require_once './classes/customer.class.php';
require_once './sanitize.php';

$customerObj = new Customer();
session_start();

if (!isset($_SESSION['customer']['role_name'])) {
    header('Location: ./index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $idparam = $_GET['id'];
    $storage = $customerObj->getSingleStorage($idparam);

    // Decode the JSON-encoded images field
    if (!empty($storage['image'])) {
        $storage['images'] = json_decode($storage['image'], true);
    }
} else {
    header('Location: ./index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eco-Friendly Water Bottle - Responsive Product View</title>
    <link rel="stylesheet" href="./output.css">
    <link rel="icon" href="./images/logo white transparent.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="min-h-screen flex flex-col bg-slate-100 relative">
    <?php
    include_once './components/header.php';
    ?>

    <main class="flex-grow flex flex-col container mx-auto pt-24">
        <div class="min-h-screen flex flex-col lg:flex-row bg-slate-50 shadow-md ">
            <!-- Left side - Image Gallery -->
            <div class="w-full lg:w-1/2 p-4 lg:p-8 flex flex-col shadow-lg bg-neutral-100 relative">
                <!-- Main Image (First Image from Array) -->
                <?php if (!empty($storage['images'])): ?>
                    <a class="mb-4 w-full h-auto" href="<?php echo htmlspecialchars($storage['images'][0]); ?>"
                        target="_blank">
                        <img src="<?php echo htmlspecialchars($storage['images'][0]); ?>" alt="Main Image"
                            class="w-full h-64 sm:h-96 lg:h-[520px] object-cover rounded-lg">
                    </a>

                    <!-- Thumbnail Images (All Other Images) -->
                    <div class="flex justify-start space-x-4 overflow-x-auto">
                        <?php foreach ($storage['images'] as $index => $image): ?>
                            <?php if ($index > 0): // Skip the first image, already displayed ?>
                                <a href="<?php echo htmlspecialchars($image); ?>" target="_blank" class="flex-shrink-0 w-[200px]">
                                    <img src="<?php echo htmlspecialchars($image); ?>" alt="Thumbnail <?php echo $index; ?>"
                                        class="h-20 sm:h-32 w-full object-cover rounded-lg">
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No images available for this storage unit.</p>
                <?php endif; ?>
            </div>

            <!-- Right side - Product Information -->
            <div class="w-full lg:w-1/2 p-4 sm:p-8 lg:p-12 overflow-y-auto flex flex-col relative">

                <button class="absolute top-4 right-5 hover:text-gray-400 text-red-500 duration-100"
                    onclick="window.history.back()">
                    <i class="fa fa-times fa-lg"></i>
                </button>


                <div>
                    <div class="mb-2">
                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 ">
                            <?php echo htmlspecialchars($storage['name']) ?>
                        </h1>
                    </div>

                    <!-- rating -->
                    <div class="flex items-center mb-4 ">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                        </div>
                        <p class="ml-2 text-sm sm:text-base text-gray-600">(4.5) 150 reviews</p>
                    </div>


                    <p class="text-2xl sm:text-3xl font-semibold text-gray-900 mb-4 flex items-center gap-1"><span
                            class="text-blue-950">₱</span>
                        <span class="text-xl"><?php echo htmlspecialchars($storage['price']) ?> / month</span>
                    </p>

                    <div class="mb-4 flex flex-col">
                        <p class="flex items-center gap-1">
                            <span class="font-semibold text-lg">Area size: </span>
                            <span class="text-lg"><?php echo htmlspecialchars($storage['area']) ?> sqm</span>
                        </p>
                        <p class="flex items-center gap-1">
                            <span class="font-semibold text-lg">Category: </span>
                            <span class="text-lg"><?php echo htmlspecialchars($storage['category_name']) ?></span>
                        </p>
                    </div>

                    <p class="text-sm sm:text-base text-gray-600 mb-4">
                        <?php echo htmlspecialchars($storage['description']) ?>
                    </p>
                </div>


                <button
                    class="w-full bg-blue-600 text-white mt-auto gap-2 py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                    <svg width="20px" class="text-white" height="20px" viewBox="0 0 22.00 22.00" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M11 3.99995C12.8839 2.91716 14.9355 2.15669 17.07 1.74995C17.551 1.63467 18.0523 1.63283 18.5341 1.74458C19.016 1.85632 19.4652 2.07852 19.8464 2.39375C20.2276 2.70897 20.5303 3.10856 20.7305 3.56086C20.9307 4.01316 21.0229 4.50585 21 4.99995V13.9999C20.9699 15.117 20.5666 16.1917 19.8542 17.0527C19.1419 17.9136 18.1617 18.5112 17.07 18.7499C14.9355 19.1567 12.8839 19.9172 11 20.9999"
                                stroke="#FFFFFF" stroke-width="1.166" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path
                                d="M10.9995 3.99995C9.1156 2.91716 7.06409 2.15669 4.92957 1.74995C4.44856 1.63467 3.94731 1.63283 3.46546 1.74458C2.98362 1.85632 2.53439 2.07852 2.15321 2.39375C1.77203 2.70897 1.46933 3.10856 1.26911 3.56086C1.0689 4.01316 0.976598 4.50585 0.999521 4.99995V13.9999C1.0296 15.117 1.433 16.1917 2.14533 17.0527C2.85767 17.9136 3.83793 18.5112 4.92957 18.7499C7.06409 19.1567 9.1156 19.9172 10.9995 20.9999"
                                stroke="#FFFFFF" stroke-width="1.166" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path d="M11 21V4" stroke="#FFFFFF" stroke-width="1.166" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </g>
                    </svg>
                    Book This Storage
                </button>
            </div>
        </div>
    </main>

</body>

</html>