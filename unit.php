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

$getBookedDate = $customerObj->getBookedDates($idparam);
$bookedDates = json_encode($getBookedDate);

$isLoginPop = false;
$feedbackMessage = "";

// Fetch reviews for the storage unit
$reviews = $customerObj->getReviews($idparam);

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
                    <a class="mb-4 w-full h-auto" href="./<?php echo htmlspecialchars($storage['images'][0]); ?>"
                        target="_blank">
                        <img src="./<?php echo htmlspecialchars($storage['images'][0]); ?>" alt="Main Image"
                            class="w-full h-64 sm:h-96 lg:h-[520px] object-cover rounded-lg">
                    </a>

                    <!-- Thumbnail Images (All Other Images) -->
                    <div class="flex justify-start space-x-4 overflow-x-auto">
                        <?php foreach ($storage['images'] as $index => $image): ?>
                            <?php if ($index > 0): // Skip the first image, already displayed ?>
                                <a href="./<?php echo htmlspecialchars($image); ?>" target="_blank" class="flex-shrink-0 w-[200px]">
                                    <img src="./<?php echo htmlspecialchars($image); ?>" alt="Thumbnail <?php echo $index; ?>"
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
                                <input type="hidden" id="id" value="<?php echo htmlspecialchars($idparam) ?>"
                                    name="storageId">
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
                    <p class="text-2xl sm:text-3xl font-semibold text-gray-900 mb-4 flex items-center gap-1"><span
                            class="text-blue-950">₱</span>
                        <span class="text-xl"><?php echo htmlspecialchars($storage['price']) ?> / month</span>
                    </p>


                    <div class="mb-4 flex items-center">



                        <!-- Area Size Block -->
                        <div
                            class="items-center gap-1 border-2 border-blue-500 bg-slate-200 px-2 py-4 flex flex-col rounded-xl">
                            <span class="text-sm font-semibold">
                                <span class=" text-lg"><?php echo htmlspecialchars($storage['area']) ?></span>
                                sqm
                            </span>
                            <span class="text-xs">AREA SIZE</span>
                        </div>

                        <!-- Category Block (Copied Format) -->
                        <div
                            class="items-center gap-1 border-2 border-blue-500 bg-slate-200 px-2 py-4 flex flex-col rounded-xl ml-4">
                            <span class="text-sm">
                                <span
                                    class="font-semibold text-lg"><?php echo htmlspecialchars($storage['category_name']) ?></span>
                            </span>
                            <span class="text-xs">CATEGORY</span>
                        </div>
                    </div>


                    <p class="text-sm sm:text-base text-gray-600 mb-4">
                        <?php echo htmlspecialchars($storage['description']) ?>
                    </p>
                </div>

                <div class="mx-auto mt-2 w-full flex gap-2 flex-col">
                    <span class="flex items-center gap-2">
                        <span class="w-full flex flex-col">
                            <label for="month-count" class="block font-semibold mb-2">Number of consecutive
                                months</label>
                            <input type="number" id="month-count" class="border-2 flex-1 p-2 rounded bg-white" min="1"
                                value="1" />
                        </span>
                        <span class="w-full flex flex-col">
                            <label for="year-selection" class="block font-semibold mb-2">Select Year</label>
                            <select id="year-selection" class="border-2 p-2 rounded bg-white">
                                <!-- Dynamically populated with JavaScript -->
                            </select>
                        </span>
                    </span>

                    <!-- Month Selection -->
                    <div id="month-selection"
                        class="grid grid-cols-3 gap-2 opacity-0 pointer-events-none transition-all duration-300">
                        <!-- Month buttons go here -->
                    </div>

                    <!-- Day Selection -->
                    <div id="day-selection"
                        class="grid grid-cols-7 gap-1 opacity-0 pointer-events-none transition-all duration-300">
                        <!-- Day buttons go here -->
                    </div>

                    <div class="my-4 opacity-0 pointer-events-none transition-all duration-300"
                        id="booking-confirmation">
                        <p id="confirmation-message" class="text-lg font-semibold"></p>
                    </div>

                </div>
                <a id="booking-link"
                    class="w-full text-white mt-auto py-3 px-6 rounded-lg cursor-not-allowed bg-blue-400 transition duration-300">
                    Book This Storage
                </a>

                <!-- Reviews Section -->
                <div class="mt-8">
                    <h2 class="text-2xl font-bold mb-4">Reviews</h2>
                    <?php if (!empty($reviews)): ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="mb-4 p-4 bg-white rounded-lg shadow">
                                <p class="font-semibold"><?php echo htmlspecialchars($review['user_name']); ?></p>
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($review['review']); ?></p>
                                <p class="text-sm text-yellow-500">Rating: <?php echo htmlspecialchars($review['rating']); ?>/5
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No reviews available for this storage unit.</p>
                    <?php endif; ?>
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
        document.addEventListener("DOMContentLoaded", () => {
            // Get the start and end dates from the PHP variables
            const bookedDates = <?php echo ($bookedDates); ?>; // Make sure bookedDates is an array
            const currentYear = new Date().getFullYear();
            const currentMonth = new Date().getMonth(); // Month is 0-indexed
            const currentDay = new Date().getDate();
            const yearSelection = document.getElementById('year-selection');
            const monthSelection = document.getElementById('month-selection');
            const daySelection = document.getElementById('day-selection');
            const monthCountInput = document.getElementById('month-count');
            const confirmationMessage = document.getElementById('confirmation-message');
            const bookingLink = document.getElementById('booking-link');
            const bookingConfirmation = document.getElementById('booking-confirmation');

            // Populate year dropdown (for the next 10 years)
            for (let i = currentYear; i <= currentYear + 10; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                yearSelection.appendChild(option);
            }

            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            function createMonthButtons() {
                monthSelection.innerHTML = ''; // Clear previous months
                const selectedYear = parseInt(yearSelection.value); // Get the selected year

                months.forEach((month, index) => {
                    const button = document.createElement('button');
                    button.textContent = month;
                    button.classList.add('p-1', 'text-sm', 'rounded', 'bg-blue-100', 'hover:bg-blue-300');
                    button.dataset.month = index; // Store month index
                    button.addEventListener('click', () => showDays(index));
                    monthSelection.appendChild(button);

                    // Disable past months if the selected year is the current year
                    if (selectedYear === currentYear && index < currentMonth) {
                        button.disabled = true;
                        button.classList.add('cursor-not-allowed', 'bg-gray-200');
                    }

                    // Allow past months but show them as disabled
                    if (selectedYear < currentYear || (selectedYear === currentYear && index < currentMonth)) {
                        button.classList.add('cursor-not-allowed', 'bg-gray-200');
                    }
                });
            }

            yearSelection.addEventListener('change', createMonthButtons);

            function showDays(monthIndex) {
                daySelection.innerHTML = ''; // Clear previous days
                const selectedYear = parseInt(yearSelection.value);
                const daysInMonth = new Date(selectedYear, monthIndex + 1, 0).getDate();

                for (let i = 1; i <= daysInMonth; i++) {
                    const button = document.createElement('button');
                    button.textContent = i;
                    button.classList.add('p-2', 'text-xs', 'rounded', 'bg-gray-100', 'hover:bg-gray-300');
                    button.dataset.day = i;

                    const currentDate = new Date(selectedYear, monthIndex, i);

                    // Disable dates in the past
                    if (currentDate < new Date()) {
                        button.disabled = true;
                        button.classList.add('cursor-not-allowed', 'bg-gray-200');
                    }

                    // Disable previous days only if the selected year is the current year
                    if (selectedYear === currentYear && monthIndex === currentMonth && i < currentDay) {
                        button.disabled = true;
                        button.classList.add('cursor-not-allowed', 'bg-gray-200');
                    }

                    // Disable days that fall within booked dates
                    bookedDates.forEach(booking => {
                        const bookedStartDate = new Date(booking.start_date);
                        const bookedEndDate = new Date(booking.end_date);

                        // Check if the current day falls between the booked start and end date
                        if (currentDate >= bookedStartDate && currentDate <= bookedEndDate) {
                            button.disabled = true;
                            button.classList.add('cursor-not-allowed', 'bg-red-300', 'text-white', 'font-bold'); // Add styles for booked dates
                        }
                    });

                    // Disable dates in gaps smaller than 30 days
                    for (let j = 0; j < bookedDates.length - 1; j++) {
                        const currentEndDate = new Date(bookedDates[j].end_date);
                        const nextStartDate = new Date(bookedDates[j + 1].start_date);

                        // Calculate the gap in days
                        const gapInDays = (nextStartDate - currentEndDate) / (1000 * 60 * 60 * 24);

                        // If the gap is less than 30 days, disable the dates in the gap
                        if (gapInDays < 30 && currentDate > currentEndDate && currentDate < nextStartDate) {
                            button.disabled = true;
                            button.classList.add('cursor-not-allowed', 'bg-yellow-300', 'text-white', 'font-bold'); // Add styles for small gaps
                        }
                    }

                    button.addEventListener('click', () => confirmBooking(selectedYear, monthIndex, i));
                    daySelection.appendChild(button);
                }

                daySelection.classList.remove('opacity-0', 'pointer-events-none');
            }

            function confirmBooking(year, month, day) {
                const monthCount = parseInt(monthCountInput.value); // Get the number of months
                let selectedMonths = [];

                // Calculate the end date based on the number of months
                let endMonth = month + monthCount;
                let endYear = year;

                // Adjust the year and month if the end month exceeds 12
                if (endMonth >= 12) {
                    endYear += Math.floor(endMonth / 12);
                    endMonth = endMonth % 12;
                }

                const selectedStartDate = new Date(year, month, day);
                const selectedEndDate = new Date(endYear, endMonth, day);

                // Format dates for display and URL
                const formattedStartDate = selectedStartDate.toISOString().split('T')[0];
                const formattedEndDate = selectedEndDate.toISOString().split('T')[0];

                confirmationMessage.textContent = `You have selected: ${day} ${months[month]} ${year} for ${monthCount} month(s). Your booking will end on: ${day} ${months[endMonth]} ${endYear}. Please proceed to booking.`;
                bookingConfirmation.classList.remove('opacity-0', 'pointer-events-none');

                // Enable booking link with the storage ID, start and end dates
                bookingLink.href = `payment-section.php?id=<?php echo $idparam ?>&startDate=${encodeURIComponent(formattedStartDate)}&endDate=${encodeURIComponent(formattedEndDate)}&monthCount=${monthCount}`;
                bookingLink.classList.remove('cursor-not-allowed', 'bg-blue-400');
                bookingLink.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }

            // Initialize the month buttons
            createMonthButtons();
            monthSelection.classList.remove('opacity-0', 'pointer-events-none');
            daySelection.classList.add('opacity-0', 'pointer-events-none'); // Reset day selection
            bookingConfirmation.classList.add('opacity-0', 'pointer-events-none'); // Hide confirmation message
        });
    </script>




</body>

</html>