<?php require_once './classes/admin.class.php';
require_once './sanitize.php';
$adminObj = new Admin();
session_start();
$isLoginPop = false;
$feedbackMessage = "";
$Customer = [];
$Admin = [];
$Admin = $adminObj->getAdmin();
$Customer = $adminObj->getAllCustomers();
$totalCustomers = count($Customer);


if (isset($_SESSION['customer']['role'])) {
    if ($_SESSION['customer']['role'] === 'Customer') {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="./output.css">
    <link rel="icon" href="./images/logo white transparent.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />

</head>

<body class="max-h-screen flex flex-col bg-slate-100 overflow-hidden">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php require_once './components/AdminSidebar.php' ?>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div id="dashboard" class="content-section">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold">
                        Dashboard
                    </h1>
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <img alt="User Avatar" class="rounded-full mr-2" height="40" src="./images/OIP.jpg"
                                width="40" />
                            <div>
                                <p class="text-gray-700 font-medium">
                                    <?php
                                    if (isset($Admin['firstname']) && isset($Admin['lastname'])) {
                                        echo $Admin['firstname'] . ' ' . $Admin['lastname'];
                                    } else {
                                        echo 'Admin Name';
                                    }
                                    ?>
                                </p>
                                <p class="text-gray-500 text-sm">
                                    <?php
                                    if (isset($Admin['email'])) {
                                        echo $Admin['email'];
                                    } else {
                                        echo 'admin@example.com';
                                    }
                                    ?>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="grid grid-cols-3 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-white p-4 rounded-lg shadow-md border-t-4 border-blue-500">
                        <div class="flex justify-between items-center ">
                            <div class="flex items-center gap-2">
                                <svg width="50px" height="50px" viewBox="0 0 24.00 24.00" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                        stroke="#CCCCCC" stroke-width="0.048"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <circle cx="12" cy="9" r="3" stroke="#1C274C" stroke-width="1.5"></circle>
                                        <path
                                            d="M17.9691 20C17.81 17.1085 16.9247 15 11.9999 15C7.07521 15 6.18991 17.1085 6.03076 20"
                                            stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                                        <path
                                            d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7"
                                            stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                                    </g>
                                </svg>

                                <div>
                                    <p class="text-gray-500">
                                        Total Number of Customers
                                    </p>
                                    <p class="text-2xl font-semibold">
                                        <?php echo $totalCustomers ?>
                                    </p>
                                </div>
                            </div>
                            <i class="fas fa-ellipsis-v text-gray-500">
                            </i>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white p-4 rounded-lg shadow-md border-t-4 border-green-500">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-wallet text-gray-500 text-2xl mr-2">
                                </i>
                                <div>
                                    <p class="text-gray-500">
                                        Total Number of Storages
                                    </p>
                                    <p class="text-2xl font-semibold">
                                        $105 500.00
                                    </p>
                                </div>
                            </div>
                            <i class="fas fa-ellipsis-v text-gray-500">
                            </i>
                        </div>

                    </div>
                    <!-- Card 3 -->
                    <div class="bg-white p-4 rounded-lg shadow-md border-t-4 border-red-500">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <i class="fas fa-money-bill-wave text-gray-500 text-2xl mr-2">
                                </i>
                                <div>
                                    <p class="text-gray-500">
                                        Gastos Diarios
                                    </p>
                                    <p class="text-2xl font-semibold">
                                        $3 480.00
                                    </p>
                                </div>
                            </div>
                            <i class="fas fa-ellipsis-v text-gray-500">
                            </i>
                        </div>

                    </div>
                    <!-- Card 4 -->
                    <div class="col-span-2 bg-white p-4 rounded-lg shadow-md">
                        <div class="flex justify-between items-center ">
                            <div class="flex items-center">
                                <i class="fas fa-chart-line text-gray-500 text-2xl mr-2">
                                </i>
                                <div>
                                    <p class="text-gray-500">
                                        Evolución de Ventas
                                    </p>
                                </div>
                            </div>
                            <i class="fas fa-ellipsis-v text-gray-500">
                            </i>
                        </div>
                        <div>
                            <canvas id="salesChart">
                            </canvas>
                        </div>
                    </div>
                    <!-- Card 5 -->
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-boxes text-gray-500 text-2xl mr-2">
                                </i>
                                <div>
                                    <p class="text-gray-500">
                                        Inventario
                                    </p>
                                </div>
                            </div>
                            <i class="fas fa-ellipsis-v text-gray-500">
                            </i>
                        </div>
                        <div>
                            <canvas id="inventoryChart">
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div id="sales" class="content-section hidden">
                <h1 class="text-2xl font-semibold">
                    Sales
                </h1>
            </div>

            <div id="customers" class="content-section hidden">
                <h1 class="text-2xl font-semibold">
                    Customers
                </h1>
            </div>

            <div id="storages" class="content-section hidden h-screen overflow-y-scroll">

                <div class="flex-1">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold">
                            Storages
                        </h1>
                        <a class="bg-blue-600 text-white px-4 py-2 rounded " id="addStore">
                            + Add Storage
                        </a>
                    </div>
                    <div class="bg-white p-4 py-6  rounded shadow-md">
                        <div class="flex items-center">
                            <div class="flex items-center mb-4 gap-1">
                                <label for="status">Status: </label>
                                <select id="status" class="bg-gray-100 px-2 py-1 rounded mr-4">
                                    <option>
                                        Select
                                    </option>
                                    <option>
                                        In-Stock
                                    </option>
                                    <option>
                                        Out-of-Stock
                                    </option>
                                </select>
                            </div>
                            <div class="flex items-center mb-4 gap-1">
                                <label for="category">Category : </label>
                                <select id="category" class="bg-gray-100 px-2 py-1 rounded mr-4">
                                    <option>
                                        Select
                                    </option>
                                    <option>
                                        Small
                                    </option>
                                    <option>
                                        Medium
                                    </option>
                                    <option>
                                        Large
                                    </option>
                                </select>
                            </div>
                        </div>
                        <table class="w-full text-left border-collapse overflow-scroll">
                            <thead>
                                <tr class="text-gray-600">
                                    <th class="py-2">
                                        Storage ID
                                    </th>
                                    <th class="py-2">
                                        Name
                                    </th>
                                    <th class="py-2">
                                        Description
                                    </th>
                                    <th class="py-2">
                                        Category
                                    </th>
                                    <th class="py-2">
                                        Stock
                                    </th>
                                    <th class="py-2">
                                        Price
                                    </th>
                                    <th class="py-2">
                                        Status
                                    </th>
                                    <th class="py-2">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b">
                                    <td class="py-2">
                                        01
                                    </td>
                                    <td class="py-2 flex items-center">
                                        <img alt="Product Image" class="w-8 h-8 mr-2" height="30"
                                            src="https://storage.googleapis.com/a1aa/image/qLIcgYqeWKUSQKheqKPRd3pywgnQe0jX9OgpTLJhvBEki0LnA.jpg"
                                            width="30" />
                                        <span class="truncate">
                                            Lorem ipsum
                                        </span>
                                    </td>
                                    <td class="py-2 max-w-xs truncate overflow-hidden whitespace-nowrap">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta dicta ullam
                                        laborum aperiam cumque autem aliquid adipisci possimus, veniam
                                        necessitatibus.
                                    </td>
                                    <td class="py-2">
                                        Small
                                    </td>
                                    <td class="py-2">
                                        5
                                    </td>
                                    <td class="py-2">
                                        $254
                                    </td>
                                    <td class="py-2">
                                        In-Stock
                                    </td>
                                    <td class="py-2">
                                        <button class="p-2 border bg-red-500 w-[80px] rounded-sm">Disable</button>
                                        <button class="p-2 border bg-orange-400 w-[80px] rounded-sm">Edit</button>
                                        <button
                                            class="p-2 border bg-neutral-800 w-[80px] rounded-sm text-slate-50">Delete</button>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2">
                                        01
                                    </td>
                                    <td class="py-2 flex items-center">
                                        <img alt="Product Image" class="w-8 h-8 mr-2" height="30"
                                            src="https://storage.googleapis.com/a1aa/image/qLIcgYqeWKUSQKheqKPRd3pywgnQe0jX9OgpTLJhvBEki0LnA.jpg"
                                            width="30" />
                                        <span class="truncate">
                                            Lorem ipsum
                                        </span>
                                    </td>
                                    <td class="py-2 max-w-xs truncate overflow-hidden whitespace-nowrap">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta dicta ullam
                                        laborum aperiam cumque autem aliquid adipisci possimus, veniam
                                        necessitatibus.
                                    </td>
                                    <td class="py-2">
                                        Small
                                    </td>
                                    <td class="py-2">
                                        5
                                    </td>
                                    <td class="py-2">
                                        $254
                                    </td>
                                    <td class="py-2">
                                        In-Stock
                                    </td>
                                    <td class="py-2">
                                        <button class="p-2 border bg-red-500 w-[80px] rounded-sm">Disable</button>
                                        <button class="p-2 border bg-orange-400 w-[80px] rounded-sm">Edit</button>
                                        <button
                                            class="p-2 border bg-neutral-800 w-[80px] rounded-sm text-slate-50">Delete</button>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2">
                                        01
                                    </td>
                                    <td class="py-2 flex items-center">
                                        <img alt="Product Image" class="w-8 h-8 mr-2" height="30"
                                            src="https://storage.googleapis.com/a1aa/image/qLIcgYqeWKUSQKheqKPRd3pywgnQe0jX9OgpTLJhvBEki0LnA.jpg"
                                            width="30" />
                                        <span class="truncate">
                                            Lorem ipsum
                                        </span>
                                    </td>
                                    <td class="py-2 max-w-xs truncate overflow-hidden whitespace-nowrap">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta dicta ullam
                                        laborum aperiam cumque autem aliquid adipisci possimus, veniam
                                        necessitatibus.
                                    </td>
                                    <td class="py-2">
                                        Small
                                    </td>
                                    <td class="py-2">
                                        5
                                    </td>
                                    <td class="py-2">
                                        $254
                                    </td>
                                    <td class="py-2">
                                        In-Stock
                                    </td>
                                    <td class="py-2">
                                        <button class="p-2 border bg-red-500 w-[80px] rounded-sm">Disable</button>
                                        <button class="p-2 border bg-orange-400 w-[80px] rounded-sm">Edit</button>
                                        <button
                                            class="p-2 border bg-neutral-800 w-[80px] rounded-sm text-slate-50">Delete</button>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2">
                                        01
                                    </td>
                                    <td class="py-2 flex items-center">
                                        <img alt="Product Image" class="w-8 h-8 mr-2" height="30"
                                            src="https://storage.googleapis.com/a1aa/image/qLIcgYqeWKUSQKheqKPRd3pywgnQe0jX9OgpTLJhvBEki0LnA.jpg"
                                            width="30" />
                                        <span class="truncate">
                                            Lorem ipsum
                                        </span>
                                    </td>
                                    <td class="py-2 max-w-xs truncate overflow-hidden whitespace-nowrap">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta dicta ullam
                                        laborum aperiam cumque autem aliquid adipisci possimus, veniam
                                        necessitatibus.
                                    </td>
                                    <td class="py-2">
                                        Small
                                    </td>
                                    <td class="py-2">
                                        5
                                    </td>
                                    <td class="py-2">
                                        $254
                                    </td>
                                    <td class="py-2">
                                        In-Stock
                                    </td>
                                    <td class="py-2">
                                        <button class="p-2 border bg-red-500 w-[80px] rounded-sm">Disable</button>
                                        <button class="p-2 border bg-orange-400 w-[80px] rounded-sm">Edit</button>
                                        <button
                                            class="p-2 border bg-neutral-800 w-[80px] rounded-sm text-slate-50">Delete</button>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2">
                                        01
                                    </td>
                                    <td class="py-2 flex items-center">
                                        <img alt="Product Image" class="w-8 h-8 mr-2" height="30"
                                            src="https://storage.googleapis.com/a1aa/image/qLIcgYqeWKUSQKheqKPRd3pywgnQe0jX9OgpTLJhvBEki0LnA.jpg"
                                            width="30" />
                                        <span class="truncate">
                                            Lorem ipsum
                                        </span>
                                    </td>
                                    <td class="py-2 max-w-xs truncate overflow-hidden whitespace-nowrap">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta dicta ullam
                                        laborum aperiam cumque autem aliquid adipisci possimus, veniam
                                        necessitatibus.
                                    </td>
                                    <td class="py-2">
                                        Small
                                    </td>
                                    <td class="py-2">
                                        5
                                    </td>
                                    <td class="py-2">
                                        $254
                                    </td>
                                    <td class="py-2">
                                        In-Stock
                                    </td>
                                    <td class="py-2">
                                        <button class="p-2 border bg-red-500 w-[80px] rounded-sm">Disable</button>
                                        <button class="p-2 border bg-orange-400 w-[80px] rounded-sm">Edit</button>
                                        <button
                                            class="p-2 border bg-neutral-800 w-[80px] rounded-sm text-slate-50">Delete</button>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2">
                                        01
                                    </td>
                                    <td class="py-2 flex items-center">
                                        <img alt="Product Image" class="w-8 h-8 mr-2" height="30"
                                            src="https://storage.googleapis.com/a1aa/image/qLIcgYqeWKUSQKheqKPRd3pywgnQe0jX9OgpTLJhvBEki0LnA.jpg"
                                            width="30" />
                                        <span class="truncate">
                                            Lorem ipsum
                                        </span>
                                    </td>
                                    <td class="py-2 max-w-xs truncate overflow-hidden whitespace-nowrap">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta dicta ullam
                                        laborum aperiam cumque autem aliquid adipisci possimus, veniam
                                        necessitatibus.
                                    </td>
                                    <td class="py-2">
                                        Small
                                    </td>
                                    <td class="py-2">
                                        5
                                    </td>
                                    <td class="py-2">
                                        $254
                                    </td>
                                    <td class="py-2">
                                        In-Stock
                                    </td>
                                    <td class="py-2">
                                        <button class="p-2 border bg-red-500 w-[80px] rounded-sm">Disable</button>
                                        <button class="p-2 border bg-orange-400 w-[80px] rounded-sm">Edit</button>
                                        <button
                                            class="p-2 border bg-neutral-800 w-[80px] rounded-sm text-slate-50">Delete</button>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2">
                                        01
                                    </td>
                                    <td class="py-2 flex items-center">
                                        <img alt="Product Image" class="w-8 h-8 mr-2" height="30"
                                            src="https://storage.googleapis.com/a1aa/image/qLIcgYqeWKUSQKheqKPRd3pywgnQe0jX9OgpTLJhvBEki0LnA.jpg"
                                            width="30" />
                                        <span class="truncate">
                                            Lorem ipsum
                                        </span>
                                    </td>
                                    <td class="py-2 max-w-xs truncate overflow-hidden whitespace-nowrap">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta dicta ullam
                                        laborum aperiam cumque autem aliquid adipisci possimus, veniam
                                        necessitatibus.
                                    </td>
                                    <td class="py-2">
                                        Small
                                    </td>
                                    <td class="py-2">
                                        5
                                    </td>
                                    <td class="py-2">
                                        $254
                                    </td>
                                    <td class="py-2">
                                        In-Stock
                                    </td>
                                    <td class="py-2">
                                        <button class="p-2 border bg-red-500 w-[80px] rounded-sm">Disable</button>
                                        <button class="p-2 border bg-orange-400 w-[80px] rounded-sm">Edit</button>
                                        <button
                                            class="p-2 border bg-neutral-800 w-[80px] rounded-sm text-slate-50">Delete</button>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2">
                                        01
                                    </td>
                                    <td class="py-2 flex items-center">
                                        <img alt="Product Image" class="w-8 h-8 mr-2" height="30"
                                            src="https://storage.googleapis.com/a1aa/image/qLIcgYqeWKUSQKheqKPRd3pywgnQe0jX9OgpTLJhvBEki0LnA.jpg"
                                            width="30" />
                                        <span class="truncate">
                                            Lorem ipsum
                                        </span>
                                    </td>
                                    <td class="py-2 max-w-xs truncate overflow-hidden whitespace-nowrap">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta dicta ullam
                                        laborum aperiam cumque autem aliquid adipisci possimus, veniam
                                        necessitatibus.
                                    </td>
                                    <td class="py-2">
                                        Small
                                    </td>
                                    <td class="py-2">
                                        5
                                    </td>
                                    <td class="py-2">
                                        $254
                                    </td>
                                    <td class="py-2">
                                        In-Stock
                                    </td>
                                    <td class="py-2">
                                        <button class="p-2 border bg-red-500 w-[80px] rounded-sm">Disable</button>
                                        <button class="p-2 border bg-orange-400 w-[80px] rounded-sm">Edit</button>
                                        <button
                                            class="p-2 border bg-neutral-800 w-[80px] rounded-sm text-slate-50">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="">
                    <div class="flex justify-between items-center mt-6">
                        <h1 class="text-2xl font-semibold" id="addStorage">
                            Add Storage
                        </h1>
                    </div>
                    <div class="flex">
                        <!-- Right Section -->
                        <div class="w-1/2 ">
                            <form class="bg-white  my-2 p-6 rounded-lg shadow-lg">
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="image">
                                        Product Image
                                    </label>
                                    <input type="file" id="image"
                                        class="border-2 w-full border-dashed border-gray-300 rounded-lg p-6 text-center">

                                    </input>
                                    <label class="block text-gray-700 font-semibold mb-2" for="productName">
                                        Product Name
                                    </label>
                                    <input
                                        class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                                        id="productName" placeholder="Name" type="text" />
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="description">
                                        Description
                                    </label>
                                    <textarea
                                        class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                                        id="description" placeholder="Storage Description"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="category">
                                        Category
                                    </label>
                                    <select name="category" id="category"
                                        class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                        <option value="">Select an Option</option>
                                        <option value="Small">Small</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Large">Large</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <div class="flex items-center gap-2">
                                        <label class="block text-gray-700 font-semibold " for="stock">
                                            Stock
                                        </label>
                                        <input
                                            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                                            id="stock" placeholder="Storage Quantity" type="text" />

                                        <label class="block text-gray-700 font-semibold " for="price">
                                            Price
                                        </label>
                                        <input
                                            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                                            id="price" placeholder="Storage Price" type="text" />
                                    </div>
                                </div>

                                <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                                    Add Product
                                </button>
                                </f>
                        </div>
                    </div>
                </div>
            </div>

            <div id="settings" class="content-section hidden">
                <h1 class="text-2xl font-semibold">
                    Settings
                </h1>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js">
    </script>

    <script>
        // JavaScript to switch content based on sidebar click
        const links = document.querySelectorAll('nav a');
        const contentSections = document.querySelectorAll('.content-section');

        links.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault(); // Prevent default anchor behavior

                // Remove active class from all links
                links.forEach(l => l.classList.remove('border-l-4', 'border-blue-500', 'bg-slate-200'));

                const targetId = link.getAttribute('data-target');

                // Hide all sections
                contentSections.forEach(section => {
                    section.classList.add('hidden');
                });

                // Show the selected section
                const targetSection = document.getElementById(targetId);
                targetSection.classList.remove('hidden');

                // Add active class to the clicked link
                link.classList.add('border-l-4', 'border-blue-500', 'bg-slate-200');
            });
        });




        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Progreso actual',
                    data: [20, 40, 60, 50, 70, 80],
                    borderColor: 'blue',
                    fill: false
                }, {
                    label: 'Progreso Ideal',
                    data: [30, 50, 70, 60, 80, 90],
                    borderColor: 'lightblue',
                    borderDash: [5, 5],
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
        const inventoryChart = new Chart(inventoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Stock', 'Defectuosos', 'Agotados', 'Obsoletos'],
                datasets: [{
                    data: [65, 10, 20, 5],
                    backgroundColor: ['blue', 'red', 'orange', 'gray']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>


</html>