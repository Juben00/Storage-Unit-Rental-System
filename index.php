<?php

require_once './classes/customer.class.php';
require_once './sanitize.php';

$customerObj = new Customer();
session_start();

if (isset($_SESSION['customer']['role_name'])) {
    $userId = $_SESSION['customer']['id'];
    if ($_SESSION['customer']['role_name'] === 'Admin') {
        header('Location: admin-blu-lance.php');
    }
}


$isLoginPop = false;
$feedbackMessage = "";
$Storages = [];
$Storages = $customerObj->getAllStorage();
$Storages = array_filter($Storages, function ($storage) {
    return $storage['status'] !== 'disabled';
});

$testimonials = $customerObj->getTestimonials();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['testimonial'])) {
    $testimonial = htmlspecialchars($_POST['testimonial']);
    $customerObj->saveTestimonial($testimonial);
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StorageUnit Rental System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./output.css">
    <link rel="icon" href="./images/logo white transparent.png">
</head>

<body class="min-h-screen flex flex-col bg-slate-100 relative">
    <?php
    include_once './components/header.php';
    require_once './components/login.php';
    require_once './components/signup.php';

    ?>

    <main class="flex-grow flex flex-col container mx-auto pt-24 ">
        <?php
        include_once './components/cover.php';
        ?>

        <!-- Services Section -->
        <section>
            <div class="relative bg-cover bg-center h-[40vh] "
                style="background-image: url('./images/Storage-Unit-iStock-1280808958.jpg')">
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white">
                    <h1 class="text-4xl font-bold">
                        Your Trusted Partner for Secure Storage Solutions.
                    </h1>
                    <p class="mt-4 text-lg">
                        Safe, affordable, and convenient storage units for all your personal and business needs.
                    </p>
                    <button class="mt-8 px-6 py-3 bg-blue-600 text-white font-semibold rounded">
                        VIEW AVAILABLE UNITS
                    </button>
                </div>
            </div>
            <!-- Services Section -->
            <div class="pt-8 pb-4 bg-white shadow-lg">
                <div class="container mx-auto px-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="bg-white border-2 shadow-sm rounded-lg p-6 text-center">
                            <i class="fas fa-box text-4xl text-blue-600 mb-4"></i>
                            <h3 class="text-xl font-semibold mb-2">Secure Storage</h3>
                            <p class="text-gray-600 mb-4">
                                Keep your belongings safe with our 24/7 monitored storage units.
                            </p>
                            <button class="px-4 py-2 bg-blue-600 text-white font-semibold rounded">
                                LEARN MORE
                            </button>
                        </div>
                        <div class="bg-white border-2 shadow-sm rounded-lg p-6 text-center">
                            <i class="fas fa-calendar-check text-4xl text-blue-600 mb-4"></i>
                            <h3 class="text-xl font-semibold mb-2">Flexible Leasing</h3>
                            <p class="text-gray-600 mb-4">
                                Short-term and long-term rental options to suit your schedule.
                            </p>
                            <button class="px-4 py-2 bg-blue-600 text-white font-semibold rounded">
                                CHECK AVAILABILITY
                            </button>
                        </div>
                        <div class="bg-white border-2 shadow-sm rounded-lg p-6 text-center">
                            <i class="fas fa-truck-loading text-4xl text-blue-600 mb-4"></i>
                            <h3 class="text-xl font-semibold mb-2">Easy Access</h3>
                            <p class="text-gray-600 mb-4">
                                Convenient access to your units with free parking and loading docks.
                            </p>
                            <button class="px-4 py-2 bg-blue-600 text-white font-semibold rounded">
                                GET DIRECTIONS
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Storages section -->
        <section class="px-4 py-8">

            <div class="flex justify-center mb-4 gap-4">
                <button class="text-black font-semibold">
                    All
                </button>
                <button class="text-gray-500">
                    Small
                </button>
                <button class="text-gray-500">
                    Medium
                </button>
                <button class="text-gray-500">
                    Large
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 ">
                <?php if (!empty($Storages)): ?>
                    <?php foreach ($Storages as $storage): ?>
                        <a class="border p-2 bg-neutral-100 shadow-md storage-link"
                            href="unit.php?id=<?php echo htmlspecialchars($storage['id']); ?>">
                            <?php
                            // Decode the JSON image field
                            $images = json_decode($storage['image'], true); // 'true' returns as associative array
                            $firstImage = !empty($images) ? $images[0] : ''; // Get the first image
                            ?>
                            <?php if ($firstImage): ?>
                                <img alt="<?php echo htmlspecialchars($storage['name']); ?>" class="w-full h-64 object-cover"
                                    src="./<?php echo htmlspecialchars($firstImage); ?>" width="400" height="400" />
                            <?php else: ?>
                                <img alt="No Image" class="w-8 h-8 mr-2" height="30" src="./image/bg-storage-removebg-preview.png"
                                    width="30" />
                            <?php endif; ?>

                            <div class="text-sm mt-2 flex items-center">
                                <span class="flex-1">
                                    <?php echo htmlspecialchars($storage['name']); ?>
                                    <span class="text-xs">
                                        (<?php echo htmlspecialchars($storage['area']); ?> sqm)
                                    </span>
                                </span>
                                <span class="text-xs text-gray-500">
                                    <?php echo htmlspecialchars($storage['category_name']); ?>
                                </span>
                            </div>
                            <p class="text-red-500 font-semibold">
                                ₱<?php echo htmlspecialchars(number_format($storage['price'], 0)); ?>
                                <?php if (isset($storage['discount']) && $storage['discount'] > 0): ?>
                                    <span class="line-through text-gray-500">
                                        ₱<?php echo htmlspecialchars(number_format($storage['original_price'], 0)); ?>
                                    </span>
                                    <span class="text-orange-500">
                                        <?php echo htmlspecialchars($storage['discount']); ?>% Off
                                    </span>
                                <?php endif; ?>
                            </p>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No storage units found.</p>
                <?php endif; ?>
            </div>

        </section>

        <!-- Testimonial Section -->
        <section class="py-16 bg-gray-100">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="w-full md:w-1/2 mb-8 md:mb-0">
                        <img alt="Storage unit" class="rounded-lg shadow-lg w-full" height="500"
                            src="./images/south-charleston.jpg" width="500" />
                    </div>
                    <div class="w-full md:w-1/2 md:pl-12">
                        <h2 class="text-blue-600 font-semibold mb-2">
                            TESTIMONIAL
                        </h2>
                        <h3 class="text-2xl font-bold mb-4">
                            What they say about us
                        </h3>
                        <?php foreach ($testimonials as $testimonial): ?>
                            <div class="flex items-start mb-4">
                                <i class="fas fa-quote-left text-4xl text-blue-600 mr-4"></i>
                                <p class="text-gray-600"><?php echo htmlspecialchars($testimonial['content']); ?></p>
                            </div>
                        <?php endforeach; ?>
                        <form method="POST" action="">
                            <textarea name="testimonial" class="w-full p-2 border rounded" placeholder="Write your testimonial here..." required></textarea>
                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white font-semibold rounded">Submit</button>
                        </form>
                    </div>
                </div>
        </section>

        <!-- Contact Section -->
        <section class="py-16 text-white text-center mb-4 bg-cover bg-no-repeat bg-center"
            style="background-image: url('./images/Storage-Unit-iStock-1280808958.jpg');">
            <div class="container mx-auto p-4 backdrop-blur-md bg-transparent max-w-screen-sm rounded-lg">
                <h2 class="text-3xl font-semibold mb-4">Ready to rent a storage unit?</h2>
                <button class="px-6 py-3 bg-blue-600 text-white font-semibold rounded">
                    CONTACT US TODAY
                </button>
            </div>
        </section>

        <!-- pop up message -->
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


    </main>
    <?php
    require_once './components/footer.php'
        ?>

    <script>
        // Login Modal Elements
        const loginModal = document.getElementById('loginModal');
        const loginButton = document.getElementById('login-button');
        const loginButtonMobile = document.getElementById('login-button-mobile');
        const closeLoginButton = document.getElementById('closeLogin');

        // Signup Modal Elements
        const signupModal = document.getElementById('signupModal');
        const signupButton = document.getElementById('signup-button');
        const signupButtonMobile = document.getElementById('signup-button-mobile');
        const closeSignupButton = document.getElementById('closeSignup');

        //Redirect Button
        const loginSignupRedirect = document.getElementById('Login-Signup-Redirect');
        const signupLoginRedirect = document.getElementById('Signup-Login-Redirect');

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
            }
        });

        // Login Button Event Listeners
        loginButton.addEventListener('click', () => {
            loginModal.classList.remove('hidden');
            loginModal.classList.add('flex');
            signupModal.classList.add('hidden');
            signupModal.classList.remove('flex');
            console.log("click login");
        });

        loginButtonMobile.addEventListener('click', () => {
            loginModal.classList.remove('hidden');
            loginModal.classList.add('flex');
            signupModal.classList.add('hidden');
            signupModal.classList.remove('flex');
            console.log("click login");
        });

        closeLoginButton.addEventListener('click', () => {
            loginModal.classList.add('hidden');
            loginModal.classList.remove('flex');
        });

        // Signup Button Event Listeners
        signupButton.addEventListener('click', () => {
            signupModal.classList.add('flex');
            signupModal.classList.remove('hidden');
            loginModal.classList.remove('flex');
            loginModal.classList.add('hidden');
            console.log("click signup");
        });

        signupButtonMobile.addEventListener('click', () => {
            signupModal.classList.add('flex');
            signupModal.classList.remove('hidden');
            loginModal.classList.remove('flex');
            loginModal.classList.add('hidden');
            console.log("click signup");
        });

        closeSignupButton.addEventListener('click', () => {
            signupModal.classList.add('hidden');
            signupModal.classList.remove('flex');
        });

        loginSignupRedirect.addEventListener('click', () => {
            loginModal.classList.add('hidden');
            loginModal.classList.remove('flex');
            signupModal.classList.remove('hidden');
            signupModal.classList.add('flex');
        });

        signupLoginRedirect.addEventListener('click', () => {
            signupModal.classList.add('hidden');
            signupModal.classList.remove('flex');
            loginModal.classList.remove('hidden');
            loginModal.classList.add('flex');
        });

        document.getElementById('signup-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);

            try {
                const response = await fetch('./api/Register.php', {
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
            document.getElementById('signup-form').reset();
        });

        document.getElementById('login-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);

            try {
                const response = await fetch('./api/Login.php', {
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
            document.getElementById('login-form').reset();
        });


        document.addEventListener('DOMContentLoaded', function () {
            const storageLinks = document.querySelectorAll('.storage-link');

            storageLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    // Check if the user is logged in
                    const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

                    if (!isLoggedIn) {
                        e.preventDefault(); // Prevent default action (redirect)

                        // Show the login modal
                        document.getElementById('loginModal').classList.remove('hidden'); // Ensure this matches your modal's structure
                        document.getElementById('loginModal').classList.remove('flex'); // Ensure this matches your modal's structure
                    }
                });
            });
        });

    </script>


</body>

</html>