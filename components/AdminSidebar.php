<div class="w-64 bg-slate-50 shadow-md">
    <div class="flex items-center justify-center">
        <img alt="Company Logo" src="./images/logo black transparent with name.png" />
    </div>
    <nav>
        <a class="navlink flex items-center px-6 py-2 gap-2 text-gray-700 border-l-4 border-blue-500 bg-slate-200 font-semibold"
            data-target="dashboard" href="#">
            <i class="fas fa-home "></i>
            <p>Dashboard</p>
        </a>
        <a class="navlink flex items-center px-6 py-2 gap-2 text-gray-700" data-target="customers" href="#">
            <i class="fas fa-chart-line "></i>
            <p>Customers</p>
        </a>
        <a class="navlink flex items-center px-6 py-2 gap-2 text-gray-700" data-target="storages" href="#">
            <i class="fas fa-boxes "></i>
            <p>Storages</p>
        </a>
        <a class="navlink flex items-center px-6 py-2 gap-2 text-gray-700" data-target="sales" href="#">
            <i class="fas fa-dollar-sign ml-1 mr-1  "></i>
            <p>Sales</p>
        </a>

        <a class="navlink flex items-center px-6 py-2 gap-2 text-gray-700" data-target="settings" href="#">
            <i class="fas fa-cog "></i>
            <p>Settings</p>
        </a>

    </nav>
    <a class="flex items-center px-6 py-2  text-gray-700 hover:bg-gray-100" href="logout.php"
        onclick="return confirmLogout();">
        <svg viewBox="0 0 24 24" height="20" class="mr-2" width="20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path d="M21 12L13 12" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                </path>
                <path d="M18 15L20.913 12.087V12.087C20.961 12.039 20.961 11.961 20.913 11.913V11.913L18 9"
                    stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path
                    d="M16 5V4.5V4.5C16 3.67157 15.3284 3 14.5 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H14.5C15.3284 21 16 20.3284 16 19.5V19.5V19"
                    stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
        </svg>
        <p>Logout</p>
    </a>

    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }
    </script>

</div>