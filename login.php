<div class="z-50 flex-col shadow-2xl min-w-96 fixed bg-cyan-700 p-4 rounded-xl left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 hidden "
    id="loginModal">
    <button class="absolute top-3 right-4 hover:text-gray-400 duration-100" id="closeLogin">
        <i class="fa fa-times fa-lg"></i>
    </button>


    <h2 class="text-center text-2xl text-white mb-4 font-semibold">USER LOGIN</h2>
    <form>
        <div class="mb-1">
            <label for="Email" class="text-neutral-100">Email</label>
            <div class="flex items-center bg-neutral-100 p-2 rounded">
                <input type="text" id="Email" name="Email" placeholder="Enter your Email"
                    class="w-full bg-transparent border-none focus:outline-none">
                <i class="fas fa-user text-neutral-900 mr-2"></i>
            </div>
        </div>
        <div class="mb-4">
            <label for="Password" class="text-neutral-100">Password</label>
            <div class="flex items-center bg-neutral-100 p-2 rounded">
                <input type="password" id="Password" name="Password" placeholder="Password"
                    class="w-full bg-transparent border-none focus:outline-none">
                <i class="fas fa-lock text-neutral-900 mr-2"></i>
            </div>
        </div>
        <div class="mb-4">
            <button type="submit"
                class="w-full bg-blue-500 text-gray-800 py-2 rounded hover:bg-blue-400 duration-100 hover:text-neutral-100">LOGIN</button>
        </div>
        <div class="mb-4">
            <button type="button" id="Login-Signup-Redirect"
                class="w-full bg-neutral-100 text-gray-900 py-2 rounded hover:bg-neutral-400 duration-100 hover:text-neutral-100">REGISTER</button>
        </div>
    </form>
    <div class="text-center">
        <a href="#" class="text-sm text-neutral-100">Forgot Password? <span
                class="underline hover:text-blue-500 duration-100">Click Here</span></a>
    </div>
</div>