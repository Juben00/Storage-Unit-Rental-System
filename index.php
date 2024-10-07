<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StorageUnit Rental System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./output.css">
</head>

<body class="min-h-screen flex flex-col bg-slate-100">
    <?php
    include_once './components/header.php';
    ?>

    <main class="flex-grow flex flex-col container mx-auto">
        <?php
        include_once './components/cover.php';
        ?>
        <section class="relative bg-cover bg-center h-[40vh]"
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
        </section>
        <!-- Services Section -->
        <section class="pt-16 pb-4 bg-white">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <i class="fas fa-box text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Secure Storage</h3>
                        <p class="text-gray-600 mb-4">
                            Keep your belongings safe with our 24/7 monitored storage units.
                        </p>
                        <button class="px-4 py-2 bg-blue-600 text-white font-semibold rounded">
                            LEARN MORE
                        </button>
                    </div>
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <i class="fas fa-calendar-check text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Flexible Leasing</h3>
                        <p class="text-gray-600 mb-4">
                            Short-term and long-term rental options to suit your schedule.
                        </p>
                        <button class="px-4 py-2 bg-blue-600 text-white font-semibold rounded">
                            CHECK AVAILABILITY
                        </button>
                    </div>
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
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
                        <div class="flex items-start mb-4">
                            <i class="fas fa-quote-left text-4xl text-blue-600 mr-4">
                            </i>
                            <p class="text-gray-600">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vehicula metus eu libero
                                bibendum, pulvinar dapibus leo.
                            </p>
                        </div>
                        <div class="flex items-center">
                            <img alt="Person's face" class="rounded-full mr-4" height="50" src="./images/OIP.jpg"
                                width="50" />
                            <div>
                                <p class="font-semibold">
                                    John Doe
                                </p>
                                <p class="text-gray-600">
                                    Customer
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start mt-8">
                            <i class="fas fa-quote-left text-4xl text-blue-600 mr-4">
                            </i>
                            <p class="text-gray-600">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vehicula metus eu libero
                                bibendum, pulvinar dapibus leo.
                            </p>
                        </div>
                    </div>
                </div>
        </section>
        <!-- Contact Section -->
        <section class="py-16 bg-gray-900 text-white text-center mb-4">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl font-bold mb-4">Ready to rent a storage unit?</h2>
                <button class="px-6 py-3 bg-blue-600 text-white font-semibold rounded">
                    CONTACT US TODAY
                </button>
            </div>
        </section>
    </main>
    <?php
    require_once './components/footer.php'
        ?>
</body>

</html>