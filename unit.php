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
    $bookmarkedStorage = $customerObj->getBookmarkedStorage();

    // Decode the JSON-encoded images field
    if (!empty($storage['image'])) {
        $storage['images'] = json_decode($storage['image'], true);
    }
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
    <title>Eco-Friendly Water Bottle - Responsive Product View</title>
    <link rel="stylesheet" href="./output.css">
    <link rel="icon" href="./images/logo white transparent.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        .hidden {
            display: none;
        }

        .tab-content {
            padding: 16px;
        }

        .selected {
            background-color: #cbd5e1;
        }

        /* Highlight for selected months */
        .disabled {
            color: gray;
            pointer-events: none;
        }

        .hover:hover {
            background-color: #e2e8f0;
        }

        .active {
            background-color: #1d4ed8;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-slate-100 relative">
    <?php
    include_once './components/header.php';
    ?>

    <main class="flex-grow flex flex-col container mx-auto pt-24">
        <div class="min-h-screen flex flex-col lg:flex-row bg-slate-50 shadow-md ">
            <!-- Left side - Image Gallery -->
            <div class="w-full lg:w-1/2 p-4 lg:p-8 flex flex-col shadow-lg relative">
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
                    <div class="mb-2 flex justify-between items-center">
                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 ">
                            <?php echo htmlspecialchars($storage['name']) ?>
                        </h1>
                        <?php
                        if (in_array($idparam, array_column($bookmarkedStorage, 'id'))) {
                            ?>
                            <form id="unbookmark">
                                <input type="hidden" value="<?php echo htmlspecialchars($idparam) ?>" name="storageId">
                                <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userId) ?>">

                                <button type="submit">
                                    <svg width="25px" height="25px" viewBox="-4 0 30 30" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>bookmark</title>
                                            <desc>Created with Sketch Beta.</desc>
                                            <defs> </defs>
                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                                sketch:type="MSPage">
                                                <g id="Icon-Set-Filled" sketch:type="MSLayerGroup"
                                                    transform="translate(-419.000000, -153.000000)" fill="#000000">
                                                    <path
                                                        d="M437,153 L423,153 C420.791,153 419,154.791 419,157 L419,179 C419,181.209 420.791,183 423,183 L430,176 L437,183 C439.209,183 441,181.209 441,179 L441,157 C441,154.791 439.209,153 437,153"
                                                        id="bookmark" sketch:type="MSShapeGroup"> </path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </form>
                            <?php
                        } else {
                            ?>
                            <form id="bookmark">
                                <input type="hidden" value="<?php echo htmlspecialchars($idparam) ?>" name="storageId">
                                <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userId) ?>">

                                <button type="submit">
                                    <svg width="25px" height="25px" viewBox="-4 0 30 30" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>bookmark</title>
                                            <desc>Created with Sketch Beta.</desc>
                                            <defs> </defs>
                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                                sketch:type="MSPage">
                                                <g id="Icon-Set" sketch:type="MSLayerGroup"
                                                    transform="translate(-417.000000, -151.000000)" fill="#000000">
                                                    <path
                                                        d="M437,177 C437,178.104 436.104,179 435,179 L428,172 L421,179 C419.896,179 419,178.104 419,177 L419,155 C419,153.896 419.896,153 421,153 L435,153 C436.104,153 437,153.896 437,155 L437,177 L437,177 Z M435,151 L421,151 C418.791,151 417,152.791 417,155 L417,177 C417,179.209 418.791,181 421,181 L428,174 L435,181 C437.209,181 439,179.209 439,177 L439,155 C439,152.791 437.209,151 435,151 L435,151 Z"
                                                        id="bookmark" sketch:type="MSShapeGroup"> </path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </form>
                            <?php
                        }
                        ?>

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

                <div class="mx-auto mt-2 w-full flex gap-2">
                    <span class="w-full flex flex-col">
                        <label for="month-count" class="block font-semibold mb-2">Number of
                            consecutive months</label>
                        <input type="number" id="month-count" class="border-2 flex-1 p-2 rounded bg-white" min="1"
                            value="1" />
                    </span>
                    <span class="w-full flex flex-col">
                        <label for="start-date" class="block font-semibold mb-2">Select start date</label>
                        <input type="date" id="start-date" class="border-2 flex-1 p-2 rounded bg-white" />
                    </span>


                </div>
                <div class="my-4 hidden" id="booking-confirmation">
                    <p id="confirmation-message" class="text-lg font-semibold"></p>
                </div>

                <a id="booking-link"
                    class="w-full  text-white mt-auto gap-2 py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center cursor-not-allowed bg-blue-400"
                    href="javascript:void(0)">
                    <svg width="20px" class="text-white" height="20px" viewBox="0 0 22.00 22.00" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <!-- SVG content here -->
                    </svg>
                    Book This Storage
                </a>


            </div>
        </div>
    </main>

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


        document.getElementById("bookmark").addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);

            try {
                const response = await fetch('./api/AddBookmark.php', {
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


        document.getElementById("unbookmark").addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);

            try {
                const response = await fetch('./api/Unbookmark.php', {
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



    <script>
        // Function to handle date selection and month count
        function handleDateSelection() {
            const startDateInput = document.getElementById('start-date');
            const monthCountInput = document.getElementById('month-count');
            const confirmationMessage = document.getElementById('confirmation-message');
            const bookingConfirmation = document.getElementById('booking-confirmation');
            const bookingLink = document.getElementById('booking-link');

            startDateInput.addEventListener('change', updateBookingDetails);
            monthCountInput.addEventListener('input', updateBookingDetails);

            function updateBookingDetails() {
                const startDateValue = startDateInput.value;
                const monthCount = parseInt(monthCountInput.value);

                if (!startDateValue || isNaN(monthCount) || monthCount < 1) {
                    confirmationMessage.textContent = '';
                    bookingConfirmation.classList.add('hidden');
                    bookingLink.classList.add('cursor-not-allowed', 'bg-blue-400');
                    bookingLink.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                    return;
                }

                const startDate = new Date(startDateValue);
                const endDate = new Date(startDate);
                endDate.setMonth(startDate.getMonth() + monthCount);

                const months = getMonths();

                // Format the start date and end date
                const formattedStartDate = `${startDate.getDate()} ${months[startDate.getMonth()]} ${startDate.getFullYear()}`;
                const formattedEndDate = `${endDate.getDate()} ${months[endDate.getMonth()]} ${endDate.getFullYear()}`;

                // Display only the start and end dates
                confirmationMessage.textContent = `Booking starts on: ${formattedStartDate} and ends on: ${formattedEndDate}. Please proceed to booking.`;
                bookingConfirmation.classList.remove('hidden');

                // Update the booking link (use the selected date and months)
                bookingLink.href = `payment-section.php?id=<?php echo $storage['id']; ?>&startDate=${encodeURIComponent(startDateValue)}&endDate=${encodeURIComponent(endDate.toISOString().split('T')[0])}`;

                // Enable the booking link
                enableBookingLink();
            }

            // Enable booking link when valid data is selected
            function enableBookingLink() {
                bookingLink.classList.remove('cursor-not-allowed', 'bg-blue-400');
                bookingLink.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }

            // Get the names of the months
            function getMonths() {
                return [
                    'January', 'February', 'March', 'April',
                    'May', 'June', 'July', 'August',
                    'September', 'October', 'November', 'December'
                ];
            }
        }

        // Initialize date selection handler
        handleDateSelection();

    </script>
</body>

</html>