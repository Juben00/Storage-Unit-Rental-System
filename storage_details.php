<?php
require_once './classes/customer.class.php';
require_once './sanitize.php';

$customerObj = new Customer();

session_start();

if (!isset($_SESSION['customer']['role_name'])) {
    header('Location: ./index.php');
    exit();
}

$booking_id = $_GET['booking_id'];
$bookingDetails = $customerObj->getBookingDetails($booking_id);
$storageDetails = $customerObj->getStorageDetails($bookingDetails['storage_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage Details</title>
    <link rel="stylesheet" href="./output.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Booking Details</h1>
        <div class="bg-white p-8 rounded-lg shadow-lg relative">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">
                <?php echo htmlspecialchars($storageDetails['name']); ?>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <?php
                $images = json_decode($storageDetails['image'], true);
                foreach ($images as $image) {
                    echo '<div class="overflow-hidden rounded-lg shadow-lg"><img src="./' . htmlspecialchars($image) . '" alt="Storage Image" class="w-full h-64 object-cover transition-transform duration-300 hover:scale-105"></div>';
                }
                ?>
            </div>

            <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-700">Storage Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <p><strong>Area:</strong> <?php echo htmlspecialchars($storageDetails['area']); ?> sqm</p>
                <p><strong>Price:</strong> ₱<?php echo htmlspecialchars(number_format($storageDetails['price'], 0)); ?>
                </p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($storageDetails['category_name']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($storageDetails['description']); ?></p>
            </div>

            <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-700">Booking Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <p><strong>Booking Status:</strong> <?php echo htmlspecialchars($bookingDetails['booking_status']); ?>
                </p>
                <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($bookingDetails['payment_method']); ?>
                </p>
                <p><strong>Payment Status:</strong> <?php echo htmlspecialchars($bookingDetails['payment_status']); ?>
                </p>
                <p><strong>Booking Date:</strong>
                    <?php echo htmlspecialchars(date('M d, Y', strtotime($bookingDetails['booking_date']))); ?></p>
                <p><strong>Duration:</strong> <?php echo htmlspecialchars($bookingDetails['months']); ?> months
                    (<?php echo htmlspecialchars($bookingDetails['start_date']); ?> -
                    <?php echo htmlspecialchars($bookingDetails['end_date']); ?>)
                </p>
                <p><strong>Total Cost:</strong>
                    ₱<?php echo htmlspecialchars(number_format($storageDetails['price'] * $bookingDetails['months'], 0)); ?>
                </p>
            </div>
            <?php
            $today = date('Y-m-d');
            if ($bookingDetails['end_date'] < $today) {
                ?>
                <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-700">Leave a Review</h2>
                <form action="./api/submit_review.php" method="POST" class="bg-white p-8 rounded-lg shadow-lg">
                    <input type="hidden" name="storage_id" value="<?php echo htmlspecialchars($storageDetails['sid']); ?>">
                    <input type="hidden" name="user_id"
                        value="<?php echo htmlspecialchars($_SESSION['customer']['id']); ?>">
                    <div class="mb-4">
                        <label for="rating" class="block text-gray-700 font-semibold mb-2">Rating:</label>
                        <select name="rating" id="rating" class="w-full p-2 border rounded-lg">
                            <option value="1">1 - Very Poor</option>
                            <option value="2">2 - Poor</option>
                            <option value="3">3 - Average</option>
                            <option value="4">4 - Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="review" class="block text-gray-700 font-semibold mb-2">Review:</label>
                        <textarea name="review" id="review" rows="4" class="w-full p-2 border rounded-lg"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Submit Review</button>
                </form>
                <?php
            }
            ?>
            <div class="mt-8 absolute top-2 right-12">
                <a href="javascript:history.back()" class="text-blue-500 hover:underline">← Back</a>
            </div>
        </div>
    </div>
</body>

</html>