<header class="flex justify-between items-center p-6 bg-slate-200 fixed w-full top-0 z-50">
    <div class="flex items-center w-[300px] ">
        <img alt="TitanML Logo" class="h-10 w-10" height="50" src="./images/logo black transparent.png" width="50" />
        <span class="ml-2 text-2xl font-bold tracking-tighter">
            Storage Unit
            <span class="text-blue-500 text-sm">
                Reservation System
            </span>
        </span>
    </div>

    <!-- Burger Menu (Visible only on mobile) -->
    <div class="lg:hidden">
        <button id="burger-menu" class="focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                class="h-8 w-8 text-black">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Navigation Links (Hidden on mobile) -->
    <nav id="nav-links" class="hidden lg:flex justify-center space-x-6 w-[300px] ">
        <a class="hover:text-blue-400 duration-150" href="#">
            Storages
        </a>
        <a class="hover:text-blue-400 duration-150" href="#">
            Pricing
        </a>
        <a class="hover:text-blue-400 duration-150" href="#">
            About Us
        </a>
    </nav>

    <!-- Buttons (Hidden on mobile) -->

    <div id="nav-buttons" class="hidden lg:flex space-x-4 w-[300px]  justify-end relative">
        <?php
        if (isset($_SESSION['customer'])) {
            echo '<button id="profilenav">
            <svg width="40px" height="40px" viewBox="-2.4 -2.4 28.80 28.80" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.048"></g><g id="SVGRepo_iconCarrier"> <path d="M22 12C22 6.49 17.51 2 12 2C6.49 2 2 6.49 2 12C2 14.9 3.25 17.51 5.23 19.34C5.23 19.35 5.23 19.35 5.22 19.36C5.32 19.46 5.44 19.54 5.54 19.63C5.6 19.68 5.65 19.73 5.71 19.77C5.89 19.92 6.09 20.06 6.28 20.2C6.35 20.25 6.41 20.29 6.48 20.34C6.67 20.47 6.87 20.59 7.08 20.7C7.15 20.74 7.23 20.79 7.3 20.83C7.5 20.94 7.71 21.04 7.93 21.13C8.01 21.17 8.09 21.21 8.17 21.24C8.39 21.33 8.61 21.41 8.83 21.48C8.91 21.51 8.99 21.54 9.07 21.56C9.31 21.63 9.55 21.69 9.79 21.75C9.86 21.77 9.93 21.79 10.01 21.8C10.29 21.86 10.57 21.9 10.86 21.93C10.9 21.93 10.94 21.94 10.98 21.95C11.32 21.98 11.66 22 12 22C12.34 22 12.68 21.98 13.01 21.95C13.05 21.95 13.09 21.94 13.13 21.93C13.42 21.9 13.7 21.86 13.98 21.8C14.05 21.79 14.12 21.76 14.2 21.75C14.44 21.69 14.69 21.64 14.92 21.56C15 21.53 15.08 21.5 15.16 21.48C15.38 21.4 15.61 21.33 15.82 21.24C15.9 21.21 15.98 21.17 16.06 21.13C16.27 21.04 16.48 20.94 16.69 20.83C16.77 20.79 16.84 20.74 16.91 20.7C17.11 20.58 17.31 20.47 17.51 20.34C17.58 20.3 17.64 20.25 17.71 20.2C17.91 20.06 18.1 19.92 18.28 19.77C18.34 19.72 18.39 19.67 18.45 19.63C18.56 19.54 18.67 19.45 18.77 19.36C18.77 19.35 18.77 19.35 18.76 19.34C20.75 17.51 22 14.9 22 12ZM16.94 16.97C14.23 15.15 9.79 15.15 7.06 16.97C6.62 17.26 6.26 17.6 5.96 17.97C4.44 16.43 3.5 14.32 3.5 12C3.5 7.31 7.31 3.5 12 3.5C16.69 3.5 20.5 7.31 20.5 12C20.5 14.32 19.56 16.43 18.04 17.97C17.75 17.6 17.38 17.26 16.94 16.97Z" fill="#292D32"></path> <path d="M12 6.92969C9.93 6.92969 8.25 8.60969 8.25 10.6797C8.25 12.7097 9.84 14.3597 11.95 14.4197C11.98 14.4197 12.02 14.4197 12.04 14.4197C12.06 14.4197 12.09 14.4197 12.11 14.4197C12.12 14.4197 12.13 14.4197 12.13 14.4197C14.15 14.3497 15.74 12.7097 15.75 10.6797C15.75 8.60969 14.07 6.92969 12 6.92969Z" fill="#292D32"></path> </g></svg>
            </button>';
        } else {
            ?>
            <button
                class="bg-transparent duration-150 border border-neutral-600 py-2 px-4 rounded hover:bg-blue-400 hover:text-black"
                id="signup-button">
                SIGN UP
            </button>
            <button class="bg-blue-500 duration-150 text-white py-2 px-4 rounded hover:bg-blue-600" id="login-button">
                LOGIN
            </button>

            <?php
        }
        ?>
        <div id="profilepop"
            class="hidden border-2 border-blue-500 absolute right-0 p-4 mt-2 top-16 bg-white rounded-md shadow-lg w-32">
            <ul class="w-full">
                <li class="py-2 border-b border-gray-200 flex items-center justify-center">
                    <!-- Profile Icon (FontAwesome) -->
                    <span class="flex items-center w-full">
                        <i class="fas fa-user text-gray-700 mr-2"></i>
                        <a href="profile.php?userId=<?php echo htmlspecialchars($userId); ?>"
                            class="block w-full text-center text-gray-700 hover:text-blue-500 hover:bg-gray-100 rounded duration-150">Profile</a>
                    </span>
                </li>
                <li class="py-2 flex items-center  justify-center">
                    <!-- Logout Icon (FontAwesome) -->
                    <span class="flex items-center w-full">
                        <i class="fas fa-sign-out-alt text-gray-700 mr-2"></i>
                        <a class="block w-full text-center text-gray-700 hover:text-blue-500 hover:bg-gray-100 rounded duration-150"
                            href="logout.php">Logout</a>
                    </span>
                </li>
            </ul>
        </div>


    </div>

    <!-- Mobile Menu (Hidden by default) -->
</header>

<div id="mobile-menu" class="lg:hidden fixed w-full z-40 flex flex-col items-center gap-4 bg-slate-200 p-6 pt-24">


    <?php
    if (isset($_SESSION['customer'])) {
        echo '
        <a class=" w-full text-center hover:text-gray-400 duration-150" href="profile.php?userId=<?php echo htmlspecialchars($userId); ?>">Profile</a>
        <a class=" w-full text-center hover:text-gray-400 duration-150" href="#">Storages</a>
        <a class=" w-full text-center hover:text-gray-400 duration-150" href="#">Pricing</a>
        <a class=" w-full text-center hover:text-gray-400 duration-150" href="#">About Us</a>
        <a class=" w-full text-center hover:text-gray-400 duration-150" href="logout.php">Logout</a>
      ';
    } else {
        ?>
        <a class=" w-full text-center hover:text-gray-400 duration-150" href="#">Storages</a>
        <a class=" w-full text-center hover:text-gray-400 duration-150" href="#">Pricing</a>
        <a class=" w-full text-center hover:text-gray-400 duration-150" href="#">About Us</a>
        <button
            class="w-[100px] bg-transparent text-center duration-150 border border-neutral-600 py-2 px-4 rounded hover:bg-white hover:text-black"
            id="signup-button-mobile">
            SIGN UP
        </button>

        <button id="login-button-mobile"
            class="w-[100px] bg-blue-500 text-center duration-150 text-white py-2 px-4 rounded hover:bg-blue-600">
            LOGIN
        </button>
        <?php
    }
    ?>

</div>


<script>
    const burgerMenu = document.getElementById('burger-menu');
    const navLinks = document.getElementById('nav-links');
    const navButtons = document.getElementById('nav-buttons');
    const mobileMenu = document.getElementById('mobile-menu');

    burgerMenu.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    let isVisibleNav = false;
    document.getElementById('profilenav').addEventListener('click', () => {
        isVisibleNav = !isVisibleNav;
        if (isVisibleNav) {
            document.getElementById('profilepop').classList.remove('hidden');
            document.getElementById('profilepop').classList.add('flex');

        } else {
            document.getElementById('profilepop').classList.add('hidden');
            document.getElementById('profilepop').classList.remove('flex');
        }
        console.log(isVisibleNav);

    });
</script>