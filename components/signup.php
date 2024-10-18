<div class="z-50 flex-col shadow-2xl min-w-96 fixed bg-cyan-700 p-4 rounded-xl left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 hidden"
    id="signupModal">
    <button class="absolute top-3 right-4 hover:text-gray-400 duration-100" id="closeSignup">
        <i class="fa fa-times fa-lg"></i>
    </button>

    <h2 class="text-center text-2xl text-white mb-4 font-semibold">SIGNUP</h2>
    <form id="signup-form">
        <div class="lg:mb-1 lg:flex lg:items-center lg:gap-2 block">
            <div class="mb-1 lg:mb-0 flex flex-col w-full">
                <label for="firstname" class="text-neutral-100">First Name</label>
                <div class="flex items-center bg-neutral-100 p-2 rounded">
                    <input type="text" id="firstname" name="firstname" placeholder="Enter your First Name"
                        class="w-full bg-transparent border-none focus:outline-none">
                    <i class="fas fa-user text-neutral-900 mr-2"></i>
                </div>
            </div>

            <div class="mb-1 lg:mb-0 flex flex-col w-full">
                <label for="lastname" class="text-neutral-100">Last Name</label>
                <div class="flex items-center bg-neutral-100 p-2 rounded">
                    <input type="text" id="lastname" name="lastname" placeholder="Enter your Last Name"
                        class="w-full bg-transparent border-none focus:outline-none">
                    <i class="fas fa-user text-neutral-900 mr-2"></i>
                </div>
            </div>
        </div>

        <div class="lg:mb-1 lg:flex lg:items-center lg:gap-2 block">
            <div class="mb-1 lg:mb-0 flex flex-col w-full">
                <label for="birthdate" class="text-neutral-100">Birthdate</label>
                <div class="flex items-center bg-neutral-100 p-2 rounded">
                    <input type="date" id="birthdate" name="birthdate"
                        class="w-full bg-transparent border-none focus:outline-none">
                </div>
            </div>

            <div class="mb-1 lg:mb-0  flex flex-col w-full">
                <label for="sex" class="text-neutral-100 ">Sex</label>
                <div class="flex items-center bg-neutral-100 p-2 rounded">
                    <select id="sex" name="sex" class="w-full bg-transparent border-none focus:outline-none" required>
                        <option value="" disabled selected>Select your sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="lg:mb-1 lg:flex lg:items-center lg:gap-2 block">
            <div class="mb-1">
                <label for="phone" class="text-neutral-100">Phone</label>
                <div class="flex items-center bg-neutral-100 p-2 rounded">
                    <input type="text" id="phone" name="phone" placeholder="Enter Phone Number"
                        class="w-full bg-transparent border-none focus:outline-none">
                    <i class="fas fa-phone text-neutral-900 mr-2"></i>
                </div>
            </div>

            <div class="mb-1">
                <label for="address" class="text-neutral-100">Address</label>
                <div class="flex items-center bg-neutral-100 p-2 rounded">
                    <input type="text" id="address" name="address" placeholder="Enter your Address"
                        class="w-full bg-transparent border-none focus:outline-none">
                    <i class="fas fa-home text-neutral-900 mr-2"></i>
                </div>
            </div>
        </div>

        <div class="mb-1">
            <label for="email" class="text-neutral-100">Email</label>
            <div class="flex items-center bg-neutral-100 p-2 rounded">
                <input type="email" id="email" name="email" placeholder="Enter your Email"
                    class="w-full bg-transparent border-none focus:outline-none">
                <i class="fas fa-envelope text-neutral-900 mr-2"></i>
            </div>
        </div>

        <div class="mb-1">
            <label for="Password" class="text-neutral-100">Password</label>
            <div class="flex items-center bg-neutral-100 p-2 rounded">
                <input type="password" id="password" name="password" placeholder="password"
                    class="w-full bg-transparent border-none focus:outline-none">
                <i class="fas fa-lock text-neutral-900 mr-2"></i>
            </div>
        </div>

        <div class="mb-4">
            <label for="cPassword" class="text-neutral-100">Confirm Password</label>
            <div class="flex items-center bg-neutral-100 p-2 rounded">
                <input type="password" id="cpassword" name="cpassword" placeholder="Confrim Password"
                    class="w-full bg-transparent border-none focus:outline-none">
                <i class="fas fa-lock text-neutral-900 mr-2"></i>
            </div>
        </div>

        <div class="mb-4">
            <input type="submit"
                class="w-full bg-blue-500 text-gray-800 py-2 rounded hover:bg-blue-400 duration-100 hover:text-neutral-100"
                value="SIGN UP" />
        </div>
        <div class="text-center">
            <p class="text-sm text-neutral-100">Already Have An Account? <button
                    class="underline hover:text-blue-500 duration-100" id="Signup-Login-Redirect">Click
                    Here</button>
            </p>
        </div>
    </form>
</div>

</div>