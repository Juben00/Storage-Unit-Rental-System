<?php
require_once './classes/customer.class.php';
require_once './sanitize.php';

$customerObj = new Customer();
session_start();

if (!isset($_SESSION['customer']['role_name'])) {
    header('Location: ./index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && isset($_GET['months'])) {
    // Sanitize the ID
    $userId = $_SESSION['customer']['id'];
    $idparam = clean_input($_GET['id']);
    $storage = $customerObj->getSingleStorage($idparam);

    // Decode the JSON-encoded images field
    if (!empty($storage['image'])) {
        $storage['images'] = json_decode($storage['image'], true);
    }

    // Get and decode the months from the URL
    $selectedMonths = explode(',', urldecode($_GET['months']));
} else {
    header('Location: ./index.php');
    exit();
}

$isLoginPop = false;
$feedbackMessage = "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="./output.css">
</head>

<body class="min-h-screen flex flex-col bg-slate-100 relative">
    <?php
    include_once './components/header.php';
    ?>
    <div
        class="w-full max-w-5xl border-2 mx-auto border-blue-500 mt-24 mb-8 bg-white rounded-lg shadow-md overflow-hidden">
        <div class="flex flex-col lg:flex-row ">
            <!-- Item Details Section -->
            <div class="lg:w-1/2 p-6 sm:p-8 bg-gray-50">
                <h2 class="text-2xl font-bold mb-2">Selected Storage</h2>
                <div class="bg-white p-4 rounded-lg shadow-md mb-2">
                    <!-- Display the image(s) -->
                    <?php if (!empty($storage['images'])): ?>
                        <img src="<?php echo $storage['images'][0]; ?>" alt="Storage Image"
                            class="w-full h-48 object-cover rounded-md mb-4">
                    <?php else: ?>
                        <img src="/placeholder.svg?height=150&width=150" alt="Placeholder Image"
                            class="w-full h-48 object-cover rounded-md mb-4">
                    <?php endif; ?>

                    <h3 class="text-xl font-semibold mb-2"><?php echo $storage['name'] ?></h3>
                    <p class="text-gray-600 mb-2"><?php echo $storage['description'] ?></p>
                    <h3 class="text-xl font-semibold mb-2"><?php echo $storage['area'] ?> sqm</h3>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-blue-600">₱<?php echo $storage['price'] ?>/month</span>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h4 class="text-lg font-semibold mb-2">Booking Details</h4>
                    <p class="text-gray-600">Selected Months:
                        <span class="font-medium ">
                            <?php
                            echo implode(', ', $selectedMonths);
                            ?>
                        </span>
                    </p>
                </div>
            </div>

            <!-- Payment Form Section -->
            <div class="lg:w-1/2 p-6 sm:p-8">
                <h2 class="text-2xl font-bold mb-2">Payment Details</h2>
                <p class="text-gray-600 mb-6">Choose your payment method and enter your details.</p>
                <form>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="gcash" name="payment-method" value="gcash"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                <label for="gcash" class="ml-2 block text-sm text-gray-900">GCash</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="paymaya" name="payment-method" value="paymaya"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="paymaya" class="ml-2 block text-sm text-gray-900">PayMaya</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="account-number" class="block text-sm font-medium text-gray-700 mb-1">Account
                            Number</label>
                        <input type="text" id="account-number" name="account-number" placeholder="09XX XXX XXXX"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="Juan Dela Cruz"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="juan@example.com"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Pay ₱4,999.00
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>