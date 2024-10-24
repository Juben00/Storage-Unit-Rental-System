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
    // Sanitize the ID
    $userId = $_SESSION['customer']['id'];
    $idparam = clean_input($_GET['id']);
    $storage = $customerObj->getSingleStorage($idparam);

    // Decode the JSON-encoded images field
    if (!empty($storage['image'])) {
        $storage['images'] = json_decode($storage['image'], true);
    }

    // Get the start and end dates from the URL
    $startDate = isset($_GET['startDate']) ? clean_input($_GET['startDate']) : '';
    $endDate = isset($_GET['endDate']) ? clean_input($_GET['endDate']) : '';

    $monthsDifference = (new DateTime($endDate))->diff(new DateTime($startDate))->m; // Include start month
    $totalPrice = $storage['price'] * $monthsDifference;

} else {
    header('Location: ./index.php');
    exit();
}

$customerId = $_SESSION['customer']['id'];
$startDate = isset($_GET['startDate']) ? clean_input($_GET['startDate']) : '';
$endDate = isset($_GET['endDate']) ? clean_input($_GET['endDate']) : '';
$monthsDifference = (new DateTime($endDate))->diff(new DateTime($startDate))->m;
$totalPrice = $storage['price'] * $monthsDifference;

$isLoginPop = false;
$feedbackMessage = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./output.css">
    <link rel="icon" href="./images/logo white transparent.png">
</head>

<body class="min-h-screen flex flex-col bg-slate-100 relative">
    <?php include_once './components/header.php'; ?>

    <div class="w-full max-w-5xl border-2 mx-auto border-blue-500 mt-24 mb-8 bg-white rounded-lg shadow-md
    overflow-hidden">
        <div class="flex flex-col lg:flex-row">
            <!-- Storage Details Section -->
            <div class="lg:w-1/2 p-6 sm:p-8 bg-gray-50">
                <h2 class="text-2xl font-bold mb-2">Selected Storage</h2>
                <div class="bg-white p-4 rounded-lg shadow-md mb-2">
                    <?php if (!empty($storage['images'])): ?>
                        <img src="<?php echo $storage['images'][0]; ?>" alt="Storage Image"
                            class="w-full h-48 object-cover rounded-md mb-4">
                    <?php else: ?>
                        <img src="/placeholder.svg?height=150&width=150" alt="Placeholder Image" class="w-full h-48
                object-cover rounded-md mb-4">
                    <?php endif; ?>
                    <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($storage['name']); ?>
                    </h3>
                    <p class="text-gray-600 mb-2">
                        <?php echo htmlspecialchars($storage['description']); ?>
                    </p>
                    <div
                        class="text-xl border-2 border-blue-500 w-fit p-2 rounded-lg flex flex-col items-center bg-slate-100">
                        <span><?php echo htmlspecialchars($storage['area']); ?></span><span class="text-xs">sqm</span>
                    </div>
                    <span class="text-2xl font-bold text-blue-600">₱
                        <?php echo number_format($storage['price'], 2); ?>/month
                    </span>
                </div>


            </div>

            <!-- Payment Form Section -->
            <div class="lg:w-1/2 p-6 sm:p-8 relative">
                <button class="absolute top-4 right-5 hover:text-gray-400 text-red-500 duration-100"
                    onclick="window.history.back()">
                    <i class="fa fa-times fa-lg"></i>
                </button>
                <h2 class="text-2xl font-bold mb-2">Payment Details</h2>
                <p class=" text-gray-600 mb-6">Complete your payment information below.</p>

                <div class="bg-white p-4 rounded-lg shadow-md my-4">
                    <h4 class=" text-lg font-semibold mb-2">Booking Details</h4>
                    <p class="text-gray-600">Booking
                        Period: <span
                            class="font-medium"><?php echo htmlspecialchars($startDate) . " to " . htmlspecialchars($endDate); ?></span>
                    </p>
                </div>

                <form id="bookingForm" method="POST" class="">
                    <input type="hidden" name="customer_id" value="<?php echo $customerId; ?>">
                    <input type="hidden" name="storage_id" value="<?php echo htmlspecialchars($storage['id']); ?>">
                    <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>">
                    <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>">
                    <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($totalPrice); ?>">

                    <!-- Payment Method -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="gcash" name="payment_method" value="gcash"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                <label for="gcash" class="ml-2 block text-sm text-gray-900">GCash</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="paymaya" name="payment_method" value="paymaya"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="paymaya" class="ml-2 block text-sm text-gray-900">PayMaya</label>
                            </div>
                        </div>
                    </div>

                    <!-- Account Number -->
                    <div class="mb-4">
                        <label for="account-number" class="block text-sm font-medium text-gray-700 mb-1">Account
                            Number</label>
                        <input type="text" id="account-number" name="account_number" placeholder="09XX XXX XXXX"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>

                    <!-- Total Price -->
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Pay ₱
                        <?php echo number_format($totalPrice, 2); ?>
                    </button>
                </form>
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

    <script>
        const popbutton = document.getElementById('popupbutt');

        popbutton.addEventListener("click", () => {
            document.getElementById('modal').style.display = 'none';
            if (document.getElementById('feedbackMessage').innerHTML === 'Signup successful!') {
                loginModal.classList.remove('hidden');
                loginModal.classList.add('flex');
                signupModal.classList.add('hidden');
                signupModal.classList.remove('flex');
            } else if (document.getElementById('feedbackMessage').innerHTML === 'Logged In successfully!') {
                window.location.reload();
            } else if (document.getElementById('feedbackMessage').innerHTML === 'Storage unbookmarked successfully!') {
                window.location.reload();
            } else if (document.getElementById('feedbackMessage').innerHTML === 'Storage bookmarked successfully!') {
                window.location.reload();
            }
        });


        const bookForm = document.getElementById('bookingForm');

        bookForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);

            try {
                const response = await fetch('./api/Book.php', {
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

                document.getElementById('feedbackMessage').innerHTML = feedbackMessage;
                document.getElementById('modal').style.display = 'flex';
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('feedbackMessage').innerHTML = 'An error occurred while processing your request.';
                document.getElementById('modal').style.display = 'flex';
            }


        })
    </script>
</body>


</html>