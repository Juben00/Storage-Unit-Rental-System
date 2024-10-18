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
} else {
    echo 'No ID provided.';
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
</head>

<body class="min-h-screen flex flex-col bg-slate-100 relative">
    <?php
    include_once './components/header.php';
    ?>

    <main class="flex-grow flex flex-col container mx-auto pt-24">
        <div class="min-h-screen flex flex-col lg:flex-row ">
            <!-- Left side - Image Gallery -->
            <div class="w-full lg:w-1/2 bg-slate-50 p-4 lg:p-8 flex flex-col">
                <div class="flex-grow mb-4">
                    <img src="/placeholder.svg?height=600&width=600" alt="Eco-Friendly Water Bottle"
                        class="w-full h-64 sm:h-96 lg:h-full object-cover rounded-lg">
                </div>
                <div class="flex justify-between space-x-4">
                    <img src="/placeholder.svg?height=100&width=100" alt="Thumbnail 1"
                        class="w-1/3 h-20 sm:h-32 object-cover rounded-lg">
                    <img src="/placeholder.svg?height=100&width=100" alt="Thumbnail 2"
                        class="w-1/3 h-20 sm:h-32 object-cover rounded-lg">
                    <img src="/placeholder.svg?height=100&width=100" alt="Thumbnail 3"
                        class="w-1/3 h-20 sm:h-32 object-cover rounded-lg">
                </div>
            </div>

            <!-- Right side - Product Information -->
            <div class="w-full lg:w-1/2 bg-gray-50 p-4 sm:p-8 lg:p-12 overflow-y-auto">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Eco-Friendly Water Bottle</h1>

                <div class="flex items-center mb-6">
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

                <p class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">$24.99</p>

                <p class="text-sm sm:text-base text-gray-600 mb-8">
                    Stay hydrated in style with our eco-friendly water bottle. Made from sustainable materials, this
                    20oz
                    bottle keeps your drinks cold for up to 24 hours or hot for up to 12 hours. Perfect for outdoor
                    adventures or everyday use.
                </p>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Color</h2>
                    <div class="flex space-x-2">
                        <button
                            class="w-8 h-8 bg-blue-500 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"></button>
                        <button
                            class="w-8 h-8 bg-green-500 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"></button>
                        <button
                            class="w-8 h-8 bg-red-500 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"></button>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Quantity</h2>
                    <div class="flex items-center">
                        <button class="bg-gray-200 text-gray-700 py-2 px-4 rounded-l hover:bg-gray-300">-</button>
                        <span class="bg-gray-200 text-gray-700 py-2 px-4">1</span>
                        <button class="bg-gray-200 text-gray-700 py-2 px-4 rounded-r hover:bg-gray-300">+</button>
                    </div>
                </div>

                <button
                    class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Add to Cart
                </button>
            </div>
        </div>
    </main>

</body>

</html>