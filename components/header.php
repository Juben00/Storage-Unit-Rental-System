<header class="flex justify-between items-center p-6 bg-slate-200 fixed w-full top-0 z-40">
    <div class="flex items-center">
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
    <nav id="nav-links" class="hidden lg:flex space-x-6">
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
    <div id="nav-buttons" class="hidden lg:flex space-x-4">
        <button
            class="bg-transparent duration-150 border border-neutral-600  py-2 px-4 rounded hover:bg-blue-400 hover:text-black">
            <!-- CONTACT US -->
            SIGN UP
        </button>
        <button class="bg-blue-500 duration-150 text-white py-2 px-4 rounded hover:bg-blue-600"
            id="login-button-mobile">
            <!-- GET STARTED -->
            LOGIN
        </button>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
</header>
<div id="mobile-menu" class="lg:hidden flex flex-col items-center gap-4 bg-slate-200 p-6">
    <a class=" w-full text-center hover:text-gray-400 duration-150" href="#">Storages</a>
    <a class=" w-full text-center hover:text-gray-400 duration-150" href="#">Pricing</a>
    <a class=" w-full text-center hover:text-gray-400 duration-150" href="#">About Us</a>

    <button
        class="w-[100px] bg-transparent text-center  duration-150 border border-neutral-600 py-2 px-4 rounded hover:bg-white hover:text-black">
        <!-- CONTACT US -->
        SIGN UP
    </button>

    <button id="login-button"
        class="w-[100px] bg-blue-500 text-center duration-150 text-white py-2 px-4 rounded hover:bg-blue-600">
        <!-- GET STARTED -->
        LOGIN
    </button>
</div>


<script>
    const burgerMenu = document.getElementById('burger-menu');
    const navLinks = document.getElementById('nav-links');
    const navButtons = document.getElementById('nav-buttons');
    const mobileMenu = document.getElementById('mobile-menu');

    burgerMenu.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });


</script>