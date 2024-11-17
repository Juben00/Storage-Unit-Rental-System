<?php
require_once './classes/admin.class.php';
require_once './sanitize.php';
$adminObj = new Admin();
session_start();

$isLoginPop = false;
$feedbackMessage = "";
$Customer = [];
$Admin = [];
$Storage = [];

$Admin = $adminObj->getAdmin($_SESSION['customer']['email']);
$Customer = $adminObj->getAllCustomers();
$Storage = $adminObj->getAllStorage();
$Pending = $adminObj->getPendingBooking();
$Approved = $adminObj->getApprovedBooking();
$totalStorage = count($Storage);
$totalCustomers = count($Customer);
$totalApproved = count($Approved);


if (isset($_SESSION['customer']['role_name'])) {
    if ($_SESSION['customer']['role_name'] === 'Customer') {
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

<body class="max-h-screen flex flex-col bg-slate-100 text-neutral-800">

    <div class="bg-neutral-900/20 w-screen h-screen z-50 absolute hidden" id="updateStorageFormParent">
        <?php require_once './components/updateStorageForm.php' ?>
    </div>


    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php require_once './components/AdminSidebar.php' ?>

        <!-- Main Content -->
        <div class="flex-1 p-6 overflow-y-scroll h-screen">
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
                            <div class="flex items-center gap-2">
                                <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M22 22L2 22" stroke="#1C274C" stroke-width="0.744"
                                            stroke-linecap="round"></path>
                                        <path
                                            d="M3 22.0001V11.3472C3 10.4903 3.36644 9.67432 4.00691 9.10502L10.0069 3.77169C11.1436 2.76133 12.8564 2.76133 13.9931 3.77169L19.9931 9.10502C20.6336 9.67432 21 10.4903 21 11.3472V22.0001"
                                            stroke="#1C274C" stroke-width="0.744" stroke-linecap="round"></path>
                                        <path d="M10 9H14" stroke="#1C274C" stroke-width="0.744" stroke-linecap="round">
                                        </path>
                                        <path d="M9 15.5H15" stroke="#1C274C" stroke-width="0.744"
                                            stroke-linecap="round"></path>
                                        <path d="M9 18.5H15" stroke="#1C274C" stroke-width="0.744"
                                            stroke-linecap="round"></path>
                                        <path
                                            d="M18 22V16C18 14.1144 18 13.1716 17.4142 12.5858C16.8284 12 15.8856 12 14 12H10C8.11438 12 7.17157 12 6.58579 12.5858C6 13.1716 6 14.1144 6 16V22"
                                            stroke="#1C274C" stroke-width="0.744"></path>
                                    </g>
                                </svg>
                                <div>
                                    <p class="text-gray-500">
                                        Total Number of Storages
                                    </p>
                                    <p class="text-2xl font-semibold">
                                        <?php echo $totalStorage ?>
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
                            <div class="flex items-center gap-2">
                                <i class="fas fa-money-bill-wave text-gray-500 text-2xl mr-2">
                                </i>
                                <div>
                                    <p class="text-gray-500">
                                        Sales
                                    </p>
                                    <p class="text-2xl font-semibold">
                                        3 480.00
                                    </p>
                                </div>
                            </div>
                            <i class="fas fa-ellipsis-v text-gray-500">
                            </i>
                        </div>

                    </div>
                    <!-- Card 4 -->
                    <div class="bg-white p-4 rounded-lg shadow-md border-t-4 border-yellow-500">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-money-bill-wave text-gray-500 text-2xl mr-2">
                                </i>
                                <div>
                                    <p class="text-gray-500">
                                        Active Booking
                                    </p>
                                    <p class="text-2xl font-semibold">
                                        <?php echo $totalApproved ?>
                                    </p>
                                </div>
                            </div>
                            <i class="fas fa-ellipsis-v text-gray-500">
                            </i>
                        </div>

                    </div>
                    <!-- Graph 1 -->
                    <!-- <div class="col-span-2 bg-white p-4 rounded-lg shadow-md">
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
                    </div> -->
                    <!-- Graph 2 -->
                    <!-- <div class="bg-white p-4 rounded-lg shadow-md">
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
                    </div> -->
                </div>
            </div>

            <div id="customers" class="content-section hidden">
                <div class="flex-1 flex flex-col gap-6">
                    <div class="flex justify-between items-center ">
                        <h1 class="text-2xl font-semibold">
                            Customers
                        </h1>
                        <a href="#addCustomerForm" class="bg-blue-600 text-white px-4 py-2 rounded " id="addStore">
                            + Enroll New Customer
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
                                        Restricted
                                    </option>
                                    <option>
                                        Not Restricted
                                    </option>
                                </select>
                            </div>
                        </div>
                        <table class="w-full text-left border-collapse overflow-scroll">
                            <thead>
                                <tr class="text-gray-600">
                                    <th class="py-2">ID</th>
                                    <th class="py-2">First Name</th>
                                    <th class="py-2">Last Name</th>
                                    <th class="py-2">Birthdate</th>
                                    <th class="py-2">Sex</th>
                                    <th class="py-2">Phone</th>
                                    <th class="py-2">Address</th>
                                    <th class="py-2">Email</th>
                                    <th class="py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($Customer)): ?>
                                    <?php foreach ($Customer as $cust): ?>
                                        <tr class="border-b ">
                                            <td class="py-2 truncate">
                                                <?php echo htmlspecialchars($cust['id']); ?>
                                            </td>
                                            <td class="py-2 truncate">
                                                <?php echo htmlspecialchars($cust['firstname']); ?>
                                            </td>
                                            <td class="py-2 truncate">
                                                <?php echo htmlspecialchars($cust['lastname']); ?>
                                            </td>
                                            <td class="py-2 truncate">
                                                <?php echo htmlspecialchars($cust['birthdate']); ?>
                                            </td>
                                            <td class="py-2 truncate">
                                                <?php echo htmlspecialchars($cust['sex']); ?>
                                            </td>
                                            <td class="py-2 truncate">
                                                <?php echo htmlspecialchars($cust['phone']); ?>
                                            </td>
                                            <td class="py-2 truncate">
                                                <?php echo htmlspecialchars($cust['address']); ?>
                                            </td>
                                            <td class="py-2 truncate">
                                                <?php echo htmlspecialchars($cust['email']); ?>
                                            </td>
                                            <td class="py-2">
                                                <button class="p-2 border-2 border-blue-500 rounded-md font-semibold">
                                                    Restrict
                                                </button>
                                                <button class="p-2 border-2 border-red-500 rounded-md font-semibold"
                                                    onclick="deleteCustomer(<?php echo htmlspecialchars($cust['id']); ?>)">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="py-2 text-center">No customers found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>


                    </div>

                    <div class="flex justify-between items-center ">
                        <h1 class="text-2xl font-semibold" id="addStorage">
                            Add Customer
                        </h1>
                    </div>

                    <div class="flex">
                        <!-- left Section -->
                        <div class="w-1/2 ">
                            <?php require_once './components/addCustomerForm.php' ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="storages" class="content-section hidden relative">
                <div class="flex-1 flex flex-col gap-6">
                    <div class="flex justify-between items-center ">
                        <h1 class="text-2xl font-semibold">
                            Storages
                        </h1>
                        <a href="#addStorageForm" class="bg-blue-600 text-white px-4 py-2 rounded " id="addStore">
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
                                    <th class="py-2">Storage ID</th>
                                    <th class="py-2">Name</th>
                                    <th class="py-2">Description</th>
                                    <th class="py-2">Area</th>
                                    <th class="py-2">Category</th>
                                    <th class="py-2">Price</th>
                                    <th class="py-2">Status</th>
                                    <th class="py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($Storage)): ?>
                                    <?php foreach ($Storage as $item): ?>
                                        <tr id="storage-row-<?php echo htmlspecialchars($item['id']); ?>" class="border-b">
                                            <td class="py-2"><?php echo htmlspecialchars($item['id']); ?></td>
                                            <td class="py-2 flex items-center">
                                                <?php
                                                // Decode the JSON image field
                                                $images = json_decode($item['image'], true); // 'true' returns as associative array
                                                $firstImage = !empty($images) ? $images[0] : ''; // Get the first image
                                                ?>
                                                <?php if ($firstImage): ?>
                                                    <img alt="Product Image" class="w-8 h-8 mr-2" height="30"
                                                        src="./<?php echo htmlspecialchars($firstImage); ?>" width="30" />
                                                <?php else: ?>
                                                    <img alt="No Image" class="w-8 h-8 mr-2" height="30"
                                                        src="./images/bg-storage-removebg-preview.png" width="30" />
                                                <?php endif; ?>
                                                <span class="truncate"><?php echo htmlspecialchars($item['name']); ?></span>
                                            </td>
                                            <td class="py-2 max-w-xs truncate overflow-hidden whitespace-nowrap">
                                                <?php echo htmlspecialchars($item['description']); ?>
                                            </td>
                                            <td class="py-2 truncate"><?php echo htmlspecialchars($item['area']); ?>
                                            </td>
                                            <td class="py-2 truncate"><?php echo htmlspecialchars($item['category_name']); ?>
                                            </td>
                                            <!-- Updated category name -->
                                            <td class="py-2 truncate">
                                                <?php echo htmlspecialchars(number_format($item['price'], 2)); ?>
                                            </td>
                                            <td class="py-2 truncate"><?php echo htmlspecialchars($item['status_name']); ?></td>
                                            <!-- Updated status name -->
                                            <td class="py-2">
                                                <button
                                                    class="p-2 border-2 border-red-500 w-[70px] rounded-md font-semibold shadow-md"
                                                    onclick="disableStorage(<?php echo htmlspecialchars($item['id']); ?>)">Disable
                                                </button>
                                                <button
                                                    class="p-2 border-2 border-orange-500 w-[70px] rounded-md font-semibold shadow-md"
                                                    onclick="populateForm({
                                id: '<?php echo htmlspecialchars($item['id']); ?>',
                                name: '<?php echo htmlspecialchars(addslashes($item['name'])); ?>',
                                description: '<?php echo htmlspecialchars(addslashes($item['description'])); ?>',
                                area: '<?php echo htmlspecialchars($item['area']); ?>',
                                category: '<?php echo htmlspecialchars($item['category_id']); ?>', 
                                price: '<?php echo htmlspecialchars($item['price']); ?>',
                                image: '<?php echo htmlspecialchars(addslashes($item['image'])); ?>'
                            })">
                                                    Edit
                                                </button>
                                                <button
                                                    class="p-2 border-2 border-neutral-800 w-[70px] rounded-md font-semibold shadow-md"
                                                    onclick="deleteStorage(<?php echo htmlspecialchars($item['id']); ?>)">Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="py-2 text-center ">No storage items found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                    <div class="flex justify-between items-center ">
                        <h1 class="text-2xl font-semibold" id="addStorage">
                            Add Storage
                        </h1>
                    </div>

                    <div class="flex">
                        <!-- left Section -->
                        <div class="w-1/2 ">
                            <?php require_once './components/addStorageForm.php' ?>
                        </div>
                    </div>

                </div>
            </div>

            <div id="pending-req" class="content-section hidden">
                <div class="flex-1 flex flex-col gap-6">
                    <div class="flex justify-between items-center ">
                        <h1 class="text-2xl font-semibold">
                            Pending Requests
                        </h1>
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

                        <!-- table -->
                        <div class="overflow-x-auto">
                            <table class="w-full table-fixed text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-600">
                                        <th class="py-2 w-32">First Name</th>
                                        <th class="py-2 w-32">Last Name</th>
                                        <th class="py-2 w-40">Email</th>
                                        <th class="py-2 w-32">Phone</th>
                                        <th class="py-2 w-32">Booking Date</th>
                                        <th class="py-2 w-16">Months</th>
                                        <th class="py-2 w-32">Start Date</th>
                                        <th class="py-2 w-32">End Date</th>
                                        <th class="py-2 w-32">Total Amount</th>
                                        <th class="py-2 w-32">Storage Name</th>
                                        <th class="py-2 w-32">Area</th>
                                        <th class="py-2 w-32">Price</th>
                                        <th class="py-2 w-32">Booking Status</th>
                                        <th class="py-2 w-32">Payment Method</th>
                                        <th class="py-2 w-32">Payment Date</th>
                                        <!-- <th class="py-2 w-32">Payment Status</th> -->
                                        <th class="py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($Pending)): ?>
                                        <?php foreach ($Pending as $row): ?>
                                            <tr class="border-b">
                                                <td class="py-2 w-32 max-w-xs overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['firstname']); ?>
                                                </td>
                                                <td class="py-2 w-32 max-w-xs overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['lastname']); ?>
                                                </td>
                                                <td class="py-2 w-40 max-w-xs overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['email']); ?>
                                                </td>
                                                <td class="py-2 w-32 max-w-xs overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['phone']); ?>
                                                </td>
                                                <td class="py-2 w-32 max-w-xs overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['booking_date']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['months']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['start_date']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['end_date']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['total_amount']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['storage_name']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['area']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['price']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['booking_status']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['payment_method']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['payment_date']); ?>
                                                </td>
                                                <td class="py-2">
                                                    <button
                                                        class="p-2 border-2 border-red-500  rounded-md font-semibold shadow-md"
                                                        onclick="approveBook(<?php echo htmlspecialchars($row['booking_id']); ?>)">Approve
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="16" class="py-2">No pending bookings found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>

            <div id="approved-req" class="content-section hidden">
                <div class="flex-1 flex flex-col gap-6">
                    <div class="flex justify-between items-center ">
                        <h1 class="text-2xl font-semibold">
                            Confirmed Booking
                        </h1>
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

                        <!-- table -->
                        <div class="overflow-x-auto">
                            <table class="w-full table-fixed text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-600">
                                        <th class="py-2 w-32">First Name</th>
                                        <th class="py-2 w-32">Last Name</th>
                                        <th class="py-2 w-40">Email</th>
                                        <th class="py-2 w-32">Phone</th>
                                        <th class="py-2 w-32">Booking Date</th>
                                        <th class="py-2 w-16">Months</th>
                                        <th class="py-2 w-32">Start Date</th>
                                        <th class="py-2 w-32">End Date</th>
                                        <th class="py-2 w-32">Total Amount</th>
                                        <th class="py-2 w-32">Storage Name</th>
                                        <th class="py-2 w-32">Area</th>
                                        <th class="py-2 w-32">Price</th>
                                        <th class="py-2 w-32">Booking Status</th>
                                        <th class="py-2 w-32">Payment Method</th>
                                        <th class="py-2 w-32">Payment Date</th>
                                        <!-- <th class="py-2 w-32">Payment Status</th> -->
                                        <!-- <th class="py-2">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($Approved)): ?>
                                        <?php foreach ($Approved as $row): ?>
                                            <tr class="border-b">
                                                <td class="py-2 w-32 max-w-xs overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['firstname']); ?>
                                                </td>
                                                <td class="py-2 w-32 max-w-xs overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['lastname']); ?>
                                                </td>
                                                <td class="py-2 w-40 max-w-xs overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['email']); ?>
                                                </td>
                                                <td class="py-2 w-32 max-w-xs overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['phone']); ?>
                                                </td>
                                                <td class="py-2 w-32 max-w-xs overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['booking_date']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['months']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['start_date']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['end_date']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['total_amount']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['storage_name']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['area']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['price']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['booking_status']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['payment_method']); ?>
                                                </td>
                                                <td class="py-2 w-20 overflow-hidden truncate">
                                                    <?php echo htmlspecialchars($row['payment_date']); ?>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="16" class="py-2">No pending bookings found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

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

    <div class="fixed inset-0 flex items-center justify-center z-50 left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2"
        id="modal" style="display:none;"> <!-- Modal is hidden initially -->
        <div class="bg-white rounded-lg overflow-hidden shadow-2xl border-blue-500 border-2 z-10 max-w-sm mx-auto">
            <div class="p-5">
                <h2 class="text-lg font-semibold">Feedback</h2>
                <p id="feedbackMessage" class="mt-2"></p> <!-- Display feedback message here -->
                <div class="mt-4">
                    <button id="popupbutt" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js">
    </script>

    <script>

        document.getElementById('updateStorageFormParent').addEventListener('dblclick', (event) => {
            if (event.target === document.getElementById('updateStorageFormParent')) {
                document.getElementById('updateStorageFormParent').classList.add('hidden');
            }
        });

        document.getElementById('updateStorageForm').addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(event.target);

            // Debugging: Log the form data
            for (const [key, value] of formData.entries()) {
                console.log(key, value);
            }

            try {
                const response = await fetch('./api/UpdateStorage.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                console.log(data);

                let feedbackMessage = data.status === 'success' ? data.message : data.message;

                if (data.status === 'success') {
                    // Close the modal
                    document.getElementById('updateStorageFormParent').classList.add('hidden');
                }

                document.getElementById('feedbackMessage').innerText = feedbackMessage;
                document.getElementById('modal').style.display = 'flex';

            } catch (error) {
                console.error('Error:', error);
                document.getElementById('feedbackMessage').innerText = 'An error occurred while updating the storage item.';
                document.getElementById('modal').style.display = 'flex';
            }
        });

        function populateForm(item) {
            // Show the form
            document.getElementById('updateStorageFormParent').classList.remove('hidden');

            // Populate form fields
            document.getElementById('u_id').value = item.id;
            document.getElementById('u_storageName').value = item.name;
            document.getElementById('u_description').value = item.description;
            document.getElementById('u_area').value = item.area;
            document.getElementById('u_category').value = item.category; // Ensure this matches the category ID
            document.getElementById('u_price').value = item.price;

            // Handle existing images
            let existingImages = JSON.parse(item.image || '[]'); // Default to empty array if no images
            let imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = ''; // Clear previous images

            existingImages.forEach((imgUrl, index) => {
                const imgTag = `
            <div class="relative w-20">
                <img src="./${imgUrl}" alt="Storage Image" class="w-20 h-20 inline-block mr-2">
                <button type="button" class="absolute top-1 right-1 text-red-500" onclick="removeImage(${index})">
                    <svg width="10px" height="10px" viewBox="0 0 512 512" fill="#FF0000">
                        <g>
                            <polygon points="328.96 30.2933333 298.666667 0 164.48 134.4 30.2933333 0 0 30.2933333 134.4 164.48 0 298.666667 30.2933333 328.96 164.48 194.56 298.666667 328.96 328.96 298.666667 194.56 164.48"></polygon>
                        </g>
                    </svg>
                </button>
            </div>`;
                imagePreview.innerHTML += imgTag;
            });

            // Set the existing images in a hidden input
            document.getElementById('existing_image').value = JSON.stringify(existingImages);
        }

        // Remove image function adjusted
        function removeImage(index) {
            let existingImages = JSON.parse(document.getElementById('existing_image').value);
            existingImages.splice(index, 1); // Remove the selected image
            document.getElementById('existing_image').value = JSON.stringify(existingImages); // Update hidden input

            // Update the displayed images by clearing and repopulating
            document.getElementById('imagePreview').innerHTML = '';
            existingImages.forEach((imgUrl, idx) => {
                const imgTag = `
            <div class="relative w-20">
                <img src="./${imgUrl}" alt="Storage Image" class="w-20 h-20 inline-block mr-2">
                <button type="button" class="absolute top-1 right-1 text-red-500" onclick="removeImage(${idx})">
                    <svg width="10px" height="10px" viewBox="0 0 512 512" fill="#FF0000">
                        <g>
                            <polygon points="328.96 30.2933333 298.666667 0 164.48 134.4 30.2933333 0 0 30.2933333 134.4 164.48 0 298.666667 30.2933333 328.96 164.48 194.56 298.666667 328.96 328.96 298.666667 194.56 164.48"></polygon>
                        </g>
                    </svg>
                </button>
            </div>`;
                document.getElementById('imagePreview').innerHTML += imgTag;
            });
        }


        document.getElementById('u_image').addEventListener('change', function (event) {
            const files = event.target.files;
            const previewDiv = document.getElementById('imagePreview');
            previewDiv.innerHTML = ''; // Clear previous previews

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = "w-20 h-20 object-cover mr-2"; // Tailwind styling for preview
                    previewDiv.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });

        async function deleteStorage(id) {
            if (confirm('Are you sure you want to delete this storage item?')) {
                try {
                    let response = await fetch(`./api/DeleteStorage.php?id=${id}`, {
                        method: 'GET',
                    });
                    let data = await response.json();
                    let feedbackMessage = '';

                    if (data.status === 'success') {
                        feedbackMessage = data.message;
                        // Remove the deleted row from the table
                        document.querySelector(`#storage-row-${id}`).remove();
                    } else {
                        feedbackMessage = data.message;
                    }

                    document.getElementById('feedbackMessage').innerText = feedbackMessage;
                    document.getElementById('modal').style.display = 'flex';

                } catch (error) {
                    document.getElementById('feedbackMessage').innerText = 'An error occurred while deleting the storage item.';
                    document.getElementById('modal').style.display = 'flex';
                }
            }
        }

        async function deleteCustomer(id) {
            if (confirm('Are you sure you want to delete this storage item?')) {
                try {
                    let response = await fetch(`./api/deleteCustomer.php?id=${id}`, {
                        method: 'GET',
                    });
                    let data = await response.json();
                    let feedbackMessage = '';

                    if (data.status === 'success') {
                        feedbackMessage = data.message;
                    } else {
                        feedbackMessage = data.message;
                    }

                    document.getElementById('feedbackMessage').innerText = feedbackMessage;
                    document.getElementById('modal').style.display = 'flex';

                } catch (error) {
                    document.getElementById('feedbackMessage').innerText = 'An error occurred while deleting the Customer item.';
                    document.getElementById('modal').style.display = 'flex';
                }
            }
        }

        async function approveBook(id) {
            try {
                const response = await fetch(`./api/approveBook.php`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ id: id }), // Send the ID in the body of the POST request
                });

                let data = await response.json();
                let feedbackMessage = '';

                if (data.status === 'success') {
                    feedbackMessage = data.message;
                } else {
                    feedbackMessage = data.message;
                }

                document.getElementById('feedbackMessage').innerText = feedbackMessage;
                document.getElementById('modal').style.display = 'flex';
                // Reload the page to update the table
                window.location.reload();
            } catch (error) {
                document.getElementById('feedbackMessage').innerText = 'An error occurred while Approving the request.';
                document.getElementById('modal').style.display = 'flex';
            }
        }

        const popbutton = document.getElementById('popupbutt');

        popbutton.addEventListener("click", () => {
            document.getElementById('modal').style.display = 'none';
            if (document.getElementById('feedbackMessage').innerText === 'Signup successful!') {
                loginModal.classList.remove('hidden');
                loginModal.classList.add('flex');
                signupModal.classList.add('hidden');
                signupModal.classList.remove('flex');
            } else if (document.getElementById('feedbackMessage').innerText === 'Logged In successfully!') {
                window.location.reload();
            } else if (document.getElementById('feedbackMessage').innerText === 'Storage added successfully') {
                window.location.reload();
            } else if (document.getElementById('feedbackMessage').innerText === 'Storage updated successfully') {
                window.location.reload();
            } else if (document.getElementById('feedbackMessage').innerText === 'Customer deleted successfully') {
                window.location.reload();
            }
        });
        // JavaScript to switch content based on sidebar click
        document.addEventListener("DOMContentLoaded", function () {
            const links = document.querySelectorAll('.navlink');
            const contentSections = document.querySelectorAll('.content-section');

            links.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault(); // Prevent default anchor behavior

                    // Remove active class from all links
                    links.forEach(l => l.classList.remove('border-l-4', 'border-blue-500', 'bg-slate-200', 'font-semibold'));

                    const targetId = link.getAttribute('data-target');
                    console.log(targetId);

                    // Hide all sections
                    contentSections.forEach(section => {
                        section.classList.add('hidden');
                    });

                    // Show the selected section
                    const targetSection = document.getElementById(targetId);
                    targetSection.classList.remove('hidden');

                    // Add active class to the clicked link
                    link.classList.add('border-l-4', 'border-blue-500', 'bg-slate-200', 'font-semibold');

                });
            });
        });


        // const salesCtx = document.getElementById('salesChart').getContext('2d');
        // const salesChart = new Chart(salesCtx, {
        //     type: 'line',
        //     data: {
        //         labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
        //         datasets: [{
        //             label: 'Progreso actual',
        //             data: [20, 40, 60, 50, 70, 80],
        //             borderColor: 'blue',
        //             fill: false
        //         }, {
        //             label: 'Progreso Ideal',
        //             data: [30, 50, 70, 60, 80, 90],
        //             borderColor: 'lightblue',
        //             borderDash: [5, 5],
        //             fill: false
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         scales: {
        //             y: {
        //                 beginAtZero: true,
        //                 max: 100
        //             }
        //         }
        //     }
        // });

        // const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
        // const inventoryChart = new Chart(inventoryCtx, {
        //     type: 'doughnut',
        //     data: {
        //         labels: ['Stock', 'Defectuosos', 'Agotados', 'Obsoletos'],
        //         datasets: [{
        //             data: [65, 10, 20, 5],
        //             backgroundColor: ['blue', 'red', 'orange', 'gray']
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false
        //     }
        // });

        const addStorage = document.getElementById('addStorageForm');

        addStorage.addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(event.target);

            try {
                const response = await fetch('./api/addStorage.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                let feedbackMessage = '';

                if (data.status === 'success') {
                    feedbackMessage = data.message;
                } else {
                    feedbackMessage = data.message;
                }

                document.getElementById('feedbackMessage').innerText = feedbackMessage;
                document.getElementById('modal').style.display = 'flex';


            } catch (error) {
                console.error('Error:', error);
                document.getElementById('feedbackMessage').innerText = 'An error occurred while processing your request.';
                document.getElementById('modal').style.display = 'flex';
            }
            document.getElementById('addStorageForm').reset();
        });
    </script>
</body>


</html>