<?php

require_once './classes/admin.class.php';
require_once './sanitize.php';

$adminObj = new Admin();

session_start();

$isLoginPop = false;
$feedbackMessage = "";
$Customer = [];
$Admin = [];

$Admin = $adminObj->getAdmin();
$Customer = $adminObj->getAllCustomers();


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

<body class="min-h-screen flex flex-col bg-slate-100 ">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-slate-50 shadow-md">
            <div class="flex items-center justify-center">
                <img alt="Company Logo" src="./images/logo black transparent with name.png" />
            </div>
            <nav class="">
                <a class="flex items-center px-6 py-2 text-gray-700 bg-gray-100 border-l-4 border-blue-500" href="#">
                    <i class="fas fa-home mr-3">
                    </i>
                    Dashboard
                </a>

                <a class="flex items-center px-6 py-2 text-gray-700 hover:bg-gray-100" href="#">
                    <i class="fas fa-chart-line mr-3">
                    </i>
                    Sales
                </a>
                <a class="flex items-center px-6 py-2 text-gray-700 hover:bg-gray-100" href="#">
                    <i class="fas fa-boxes mr-3">
                    </i>
                    Accounts
                </a>

                <a class="flex items-center px-6 py-2 text-gray-700 hover:bg-gray-100" href="#">
                    <i class="fas fa-cog mr-3">
                    </i>
                    Settings
                </a>
                <a class="flex items-center px-6 py-2 text-gray-700 hover:bg-gray-100" href="#">
                    <svg viewBox="0 0 24 24" height="20" class="mr-2" width="20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M21 12L13 12" stroke="#323232" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M18 15L20.913 12.087V12.087C20.961 12.039 20.961 11.961 20.913 11.913V11.913L18 9"
                                stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path
                                d="M16 5V4.5V4.5C16 3.67157 15.3284 3 14.5 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H14.5C15.3284 21 16 20.3284 16 19.5V19.5V19"
                                stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                    Logout </a>
            </nav>
        </div>


        <!-- Main Content -->
        <div class="flex-1 p-6">
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
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-dollar-sign text-gray-500 text-2xl mr-2">
                            </i>
                            <div>
                                <p class="text-gray-500">
                                    Ventas Diarias
                                </p>
                                <p class="text-2xl font-semibold">
                                    $40 572.00
                                </p>
                            </div>
                        </div>
                        <i class="fas fa-ellipsis-v text-gray-500">
                        </i>
                    </div>
                    <div class="flex items-center text-green-500">
                        <i class="fas fa-arrow-up mr-1">
                        </i>
                        <p>
                            8% con el día anterior
                        </p>
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
                                    Saldo Disponible
                                </p>
                                <p class="text-2xl font-semibold">
                                    $105 500.00
                                </p>
                            </div>
                        </div>
                        <i class="fas fa-ellipsis-v text-gray-500">
                        </i>
                    </div>
                    <div class="flex items-center text-green-500">
                        <i class="fas fa-arrow-up mr-1">
                        </i>
                        <p>
                            3% con el día anterior
                        </p>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="bg-white p-4 rounded-lg shadow-md border-t-4 border-red-500">
                    <div class="flex justify-between items-center mb-4">
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
                    <div class="flex items-center text-red-500">
                        <i class="fas fa-arrow-down mr-1">
                        </i>
                        <p>
                            3% con el día anterior
                        </p>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="col-span-2 bg-white p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js">
    </script>
    <script>
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