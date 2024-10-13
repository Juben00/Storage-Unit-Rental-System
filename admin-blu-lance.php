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

$Admin = $adminObj->getAdmin();
$Customer = $adminObj->getAllCustomers();
$Storage = $adminObj->getAllStorage();
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

<body class="max-h-screen flex flex-col bg-slate-100 text-neutral-800">
    <div class="bg-neutral-900/20 w-screen h-screen z-50 absolute hidden" id="updateStorageFormParent">
        <form class="bg-white p-6 rounded-lg shadow-lg left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 absolute"
            id="updateStorageForm">
            <div class="mb-4">
                <input type="hidden" name="u_id" id="u_id">
                <input type="hidden" name="existing_image" id="existing_image">
                <label class="block text-gray-700 font-semibold mb-2" for="image">
                    Storage Image </label>
                <input type="file" id="u_image" name="u_image"
                    class="border-2 w-full border-dashed border-gray-300 rounded-lg p-6 text-center" />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="productName">
                    Product Name </label>
                <input
                    class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    id="u_storageName" name="u_storageName" placeholder="Storage Name" type="text" required />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="description"> Description
                </label>
                <input
                    class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    id="u_description" name="u_description" placeholder="Storage Description" type="text" required />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="category">
                    Category </label>
                <select name="u_category" id="u_category"
                    class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <option value="" disabled selected>Select an Option</option>
                    <option value='Small'>Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>
                </select>
            </div>

            <div class="mb-4">
                <div class="flex items-center gap-2">
                    <label class="block text-gray-700 font-semibold " for="stock"> Stock </label>
                    <input
                        class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        id="u_stock" name="u_stock" placeholder="Storage Quantity" type="text" required />

                    <label class="block text-gray-700 font-semibold " for="price"> Price </label>
                    <input
                        class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        id="u_price" name="u_price" placeholder="Storage Price" type="text" required />
                </div>
            </div>

            <input type="submit" value="Update Product"
                class="w-full bg-blue-600 text-white py-2 rounded-lg text-center font-semibold hover:bg-blue-700" />
        </form>
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
                                    <th class="py-2">Category</th>
                                    <th class="py-2">Stock</th>
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
                                                <img alt="Product Image" class="w-8 h-8 mr-2" height="30"
                                                    src="<?php echo htmlspecialchars($item['image']); ?>" width="30" />
                                                <span class="truncate"><?php echo htmlspecialchars($item['name']); ?></span>
                                            </td>
                                            <td class="py-2 max-w-xs truncate overflow-hidden whitespace-nowrap">
                                                <?php echo htmlspecialchars($item['description']); ?>
                                            </td>
                                            <td class="py-2"><?php echo htmlspecialchars($item['category']); ?></td>
                                            <td class="py-2"><?php echo htmlspecialchars($item['stock']); ?></td>
                                            <td class="py-2">$<?php echo htmlspecialchars(number_format($item['price'], 2)); ?>
                                            </td>
                                            <td class="py-2"><?php echo htmlspecialchars($item['status']); ?></td>
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
                                                        category: '<?php echo htmlspecialchars($item['category']); ?>',
                                                        stock: '<?php echo htmlspecialchars($item['stock']); ?>',
                                                        price: '<?php echo htmlspecialchars($item['price']); ?>',
                                                        image: '<?php echo htmlspecialchars($item['image']); ?>'
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
                                        <td colspan="8" class="py-2 text-center">No storage items found.</td>
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
                            <?php require_once './addStorageForm.php' ?>
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

        document.getElementById('updateStorageForm').addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(event.target);

            try {
                const response = await fetch('./api/UpdateStorage.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                console.log(data);

                let feedbackMessage = '';

                if (data.status === 'success') {
                    feedbackMessage = data.message;
                    // Close the modal
                    document.getElementById('updateStorageForm').classList.add('hidden');
                    // Update the table row with the new data
                    // const updatedRow = document.querySelector(`#storage-row-${data.id}`);
                    // updatedRow.querySelector('td:nth-child(2) img').src = data.image;
                    // updatedRow.querySelector('td:nth-child(2) span').innerText = data.name;
                    // updatedRow.querySelector('td:nth-child(3)').innerText = data.description;
                    // updatedRow.querySelector('td:nth-child(4)').innerText = data.category;
                    // updatedRow.querySelector('td:nth-child(5)').innerText = data.stock;
                    // updatedRow.querySelector('td:nth-child(6)').innerText = data.price;
                    // updatedRow.querySelector('td:nth-child(7)').innerText = data.status;

                } else {
                    feedbackMessage = data.message;
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
            // Ensure the form is visible
            document.getElementById('updateStorageFormParent').classList.remove('hidden');

            // Populate the form fields with the item's data
            document.getElementById('u_id').value = item.id;
            document.getElementById('u_storageName').value = item.name;
            document.getElementById('u_description').value = item.description;
            document.getElementById('u_category').value = item.category;
            document.getElementById('u_stock').value = item.stock;
            document.getElementById('u_price').value = item.price;

            // Set the existing image
            document.getElementById('existing_image').value = item.image; // Set existing image URL to hidden field
        }



        // Function to open the modal and populate the form with the selected storage item's data
        // function populateForm(item) {
        //     // Open the modal
        //     document.getElementById('updateStorageFormParent').classList.remove('hidden');

        //     // Populate the form fields with the item data
        //     document.getElementById('u_id').value = item.id;
        //     document.getElementById('u_storageName').value = item.name;
        //     document.getElementById('u_description').value = item.description;
        //     document.getElementById('u_category').value = item.category;
        //     document.getElementById('u_stock').value = item.stock;
        //     document.getElementById('u_price').value = item.price;

        //     // Set the form action if needed (e.g., update URL or handling)
        //     // document.getElementById('updateStorageForm').action = 'update_storage.php?id=' + item.id;
        //     console.log("hello");

        // }


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
            }
        });
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