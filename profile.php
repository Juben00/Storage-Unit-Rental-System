<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./output.css">
    <link rel="icon" href="./images/logo white transparent.png">
    -
    <style>
        .hidden-content {
            display: none;
        }

        .active-content {
            display: block;
        }

        .sidebar-text {
            display: inline;
        }

        #sidebar.w-16 .sidebar-text {
            display: none;
        }

        #sidebar.w-16 i {
            margin-right: 0;
        }

        .minimized {
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-1/5 bg-white p-4 items-center border-2 flex flex-col relative" id="sidebar">
            <button class="text-white z-50 bg-blue-500 p-2 rounded absolute top-2 right-2" id="toggle-button"
                onclick="toggleSidebar()">
                <span class="toggle-text">
                    <svg width="20px" height="20px" viewBox="0 0 16.00 16.00" fill="none"
                        xmlns="http://www.w3.org/2000/svg" stroke="#FFFFFF" stroke-width="0.00016">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC"
                            stroke-width="0.41600000000000004"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M9 13L9 10H16V6L9 6L9 3L8 3L3 8L8 13H9Z" fill="#FFFFFF"></path>
                            <path d="M2 14L2 2L0 2L5.24537e-07 14H2Z" fill="#FFFFFF"></path>
                        </g>
                    </svg>
                </span>
                <i class="fas fa-bars hidden"></i>
            </button>
            <img src="./images/logo black transparent with name.png" class="h-[200px] w-auto relative mb-2" id="logo" />

            <div class="mb-8" id="proflinks">
                <ul>
                    <li class="mb-4 flex items-center">
                        <a class="flex items-center" href="index.php">
                            <svg width="20px" height="20px" class="mr-2" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.5192 7.82274C2 8.77128 2 9.91549 2 12.2039V13.725C2 17.6258 2 19.5763 3.17157 20.7881C4.34315 22 6.22876 22 10 22H14C17.7712 22 19.6569 22 20.8284 20.7881C22 19.5763 22 17.6258 22 13.725V12.2039C22 9.91549 22 8.77128 21.4808 7.82274C20.9616 6.87421 20.0131 6.28551 18.116 5.10812L16.116 3.86687C14.1106 2.62229 13.1079 2 12 2C10.8921 2 9.88939 2.62229 7.88403 3.86687L5.88403 5.10813C3.98695 6.28551 3.0384 6.87421 2.5192 7.82274ZM9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z"
                                        fill="#000000"></path>
                                </g>
                            </svg>
                            <span class="sidebar-text">
                                Home
                            </span>
                        </a>
                    </li>
                    <li class="mb-4 flex items-center" onclick="showContent('profile-content')">
                        <svg width="20px" height="20px" class="mr-2" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.75 6.5C6.75 3.6005 9.1005 1.25 12 1.25C14.8995 1.25 17.25 3.6005 17.25 6.5C17.25 9.3995 14.8995 11.75 12 11.75C9.1005 11.75 6.75 9.3995 6.75 6.5Z"
                                fill="#000000"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.25 18.5714C4.25 15.6325 6.63249 13.25 9.57143 13.25H14.4286C17.3675 13.25 19.75 15.6325 19.75 18.5714C19.75 20.8792 17.8792 22.75 15.5714 22.75H8.42857C6.12081 22.75 4.25 20.8792 4.25 18.5714Z"
                                fill="#000000"></path>
                        </svg>
                        <span class="sidebar-text">Profile</span>
                    </li>
                    <li class="mb-4 flex items-center" onclick="showContent('rents-content')">
                        <svg width="20px" height="20px" class="mr-2" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22ZM14.4743 8.419C14.7952 8.68094 14.8429 9.15341 14.581 9.47428L8.86671 16.4743C8.72427 16.6488 8.51096 16.75 8.28571 16.75C8.06047 16.75 7.84716 16.6488 7.70472 16.4743L5.419 13.6743C5.15707 13.3534 5.20484 12.8809 5.52572 12.619C5.84659 12.3571 6.31906 12.4048 6.581 12.7257L8.28571 14.814L13.419 8.52572C13.6809 8.20484 14.1534 8.15707 14.4743 8.419Z"
                                fill="#000000"></path>
                        </svg>
                        <span class="sidebar-text">Rents</span>
                    </li>
                    <li class="mb-4 flex items-center" onclick="showContent('saved-content')">
                        <svg width="20px" height="20px" class="mr-2" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M21 11.0975V16.0909C21 19.1875 21 20.7358 20.2659 21.4123C19.9158 21.735 19.4739 21.9377 19.0031 21.9915C18.016 22.1045 16.8633 21.0849 14.5578 19.0458C13.5388 18.1445 13.0292 17.6938 12.4397 17.5751C12.1494 17.5166 11.8506 17.5166 11.5603 17.5751C10.9708 17.6938 10.4612 18.1445 9.44216 19.0458C7.13673 21.0849 5.98402 22.1045 4.99692 21.9915C4.52615 21.9377 4.08421 21.735 3.73411 21.4123C3 20.7358 3 19.1875 3 16.0909V11.0975C3 6.80891 3 4.6646 4.31802 3.3323C5.63604 2 7.75736 2 12 2C16.2426 2 18.364 2 19.682 3.3323C21 4.6646 21 6.80891 21 11.0975ZM8.25 6C8.25 5.58579 8.58579 5.25 9 5.25H15C15.4142 5.25 15.75 5.58579 15.75 6C15.75 6.41421 15.4142 6.75 15 6.75H9C8.58579 6.75 8.25 6.41421 8.25 6Z"
                                fill="#000000"></path>
                        </svg>
                        <span class="sidebar-text">Saved</span>
                    </li>
                    <li class="mb-4 flex items-center">
                        <svg viewBox="0 0 24 24" height="20" class="mr-2" width="20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M21 12L13 12" stroke="#323232" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                                <path
                                    d="M18 15L20.913 12.087V12.087C20.961 12.039 20.961 11.961 20.913 11.913V11.913L18 9"
                                    stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path
                                    d="M16 5V4.5V4.5C16 3.67157 15.3284 3 14.5 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H14.5C15.3284 21 16 20.3284 16 19.5V19.5V19"
                                    stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </g>
                        </svg>
                        <span class="sidebar-text">
                            Logout
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8 h-screen overflow-y-scroll">

            <div id="profile-content" class="active-content">
                <div class="bg-white p-6 rounded-lg shadow ">
                    <h2 class="text-xl font-semibold mb-4"> Profile Picture </h2>
                    <div class="flex items-center mb-6"> <img alt="Profile picture of a person"
                            class="w-16 h-16 rounded-full mr-4" height="100" src="./images/OIP.jpg" width="100" />
                        <div class="space-x-4"> <button class="bg-blue-500 text-white px-4 py-2 rounded"> Change picture
                            </button> <button class="bg-red-500 text-white px-4 py-2 rounded"> Delete picture </button>
                        </div>
                    </div>
                    <div class="mb-4"> <label class="block text-gray-700 mb-2"> Profile name </label> <input
                            class="w-full border rounded px-4 py-2" type="text" value="Kevin Heart" /> </div>
                    <div class="mb-4"> <label class="block text-gray-700 mb-2"> Username </label> <input
                            class="w-full border rounded px-4 py-2 bg-gray-100" readonly="" type="text"
                            value="@kevinheart" />
                        <p class="text-gray-500 mt-2"> Available for change in 10/10/2024 </p>
                    </div>
                    <div class="mb-4"> <label class="block text-gray-700 mb-2"> Status recently </label> <input
                            class="w-full border rounded px-4 py-2" type="text" value="On duty" /> </div>
                    <div class="mb-4"> <label class="block text-gray-700 mb-2"> About me </label> <textarea
                            class="w-full border rounded px-4 py-2"
                            rows="4">Discuss only on work hour, unless you wanna discuss about music</textarea> </div>
                    <button class="bg-gray-300 text-gray-500 px-4 py-2 rounded" disabled=""> Save changes </button>
                </div>
            </div>

            <div id="rents-content" class="hidden-content">
                <h1 class="text-2xl">Rents Content</h1>
                <p>This is the rents section.</p>
            </div>

            <div id="saved-content" class="hidden-content">
                <h1 class="text-2xl">Saved Content</h1>
                <p>This is the saved section.</p>
            </div>

        </div>
    </div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            const logo = document.getElementById('logo');

            sidebar.classList.toggle("w-1/5");
            sidebar.classList.toggle("w-16");
            logo.classList.toggle("hidden");
        }

        function showContent(contentId) {
            // Hide all content sections
            document.querySelectorAll('.active-content').forEach(section => {
                section.classList.remove('active-content');
                section.classList.add('hidden-content');
            });

            // Show selected content
            document.getElementById(contentId).classList.remove('hidden-content');
            document.getElementById(contentId).classList.add('active-content');
        }
    </script>

</body>

</html>