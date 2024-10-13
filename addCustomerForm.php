<form class="bg-white p-6 rounded-lg shadow-lg" id="addCustomerForm">
    <div class="lg:mb-1 lg:flex lg:items-center lg:gap-2 block">
        <div class="mb-1 lg:mb-0 flex flex-col w-full">
            <label for="firstname" class=" ">First Name</label>
            <div
                class=" w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600 flex items-center">
                <input type="text" id="firstname" name="firstname" placeholder="Enter your First Name"
                    class="w-full bg-transparent border-none focus:outline-none">
                <i class="fas fa-user text-neutral-900 mr-2"></i>
            </div>
        </div>

        <div class="mb-1 lg:mb-0 flex flex-col w-full">
            <label for="lastname" class=" ">Last Name</label>
            <div
                class=" w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600 flex items-center">
                <input type="text" id="lastname" name="lastname" placeholder="Enter your Last Name"
                    class="w-full bg-transparent border-none focus:outline-none">
                <i class="fas fa-user text-neutral-900 mr-2"></i>
            </div>
        </div>
    </div>

    <div class="lg:mb-1 lg:flex lg:items-center lg:gap-2 block">
        <div class="mb-1 lg:mb-0 flex flex-col w-full">
            <label for="birthdate" class=" ">Birthdate</label>
            <div
                class=" w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600 flex items-center">
                <input type="date" id="birthdate" name="birthdate"
                    class="w-full bg-transparent border-none focus:outline-none">
            </div>
        </div>

        <div class="mb-1 lg:mb-0  flex flex-col w-full">
            <label for="sex" class="  ">Sex</label>
            <div
                class=" w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600 flex items-center">
                <select id="sex" name="sex" class="w-full bg-transparent border-none focus:outline-none" required>
                    <option value="" disabled selected>Select your sex</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>
    </div>

    <div class="lg:mb-1 lg:flex lg:items-center lg:gap-2 block ">
        <div class="mb-1 lg:mb-0  flex flex-col w-full">
            <label for="phone" class=" ">Phone</label>
            <div
                class=" w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600 flex items-center">
                <input type="text" id="phone" name="phone" placeholder="Enter Phone Number"
                    class="w-full bg-transparent border-none focus:outline-none">
                <i class="fas fa-phone text-neutral-900 mr-2"></i>
            </div>
        </div>

        <div class="mb-1 lg:mb-0  flex flex-col w-full">
            <label for="address" class="">Address</label>
            <div
                class=" w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600 flex items-center">
                <input type="text" id="address" name="address" placeholder="Enter your Address"
                    class="w-full bg-transparent border-none focus:outline-none">
                <i class="fas fa-home text-neutral-900 mr-2"></i>
            </div>
        </div>
    </div>

    <div class="mb-1">
        <label for="email" class=" ">Email</label>
        <div
            class=" w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600 flex items-center">
            <input type="email" id="email" name="email" placeholder="Enter your Email"
                class="w-full bg-transparent border-none focus:outline-none">
            <i class="fas fa-envelope text-neutral-900 mr-2"></i>
        </div>
    </div>

    <div class="mb-1">
        <label for="Password" class=" ">Password</label>
        <div
            class=" w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600 flex items-center">
            <input type="password" id="password" name="password" placeholder="password"
                class="w-full bg-transparent border-none focus:outline-none">
            <i class="fas fa-lock text-neutral-900 mr-2"></i>
        </div>
    </div>

    <div class="mb-4">
        <label for="cPassword" class=" ">Confirm Password</label>
        <div
            class=" w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600 flex items-center">
            <input type="password" id="cpassword" name="cpassword" placeholder="Confrim Password"
                class="w-full bg-transparent border-none focus:outline-none">
            <i class="fas fa-lock text-neutral-900 mr-2"></i>
        </div>
    </div>

    <div class="mb-4">
        <input type="submit"
            class="w-full bg-blue-600 font-semibold text-white py-2 rounded hover:bg-blue-700 duration-100 "
            value="Enroll Customer" />
    </div>
</form>

<script>
    const form = document.getElementById('addCustomerForm');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(event.target);

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

            document.getElementById('feedbackMessage').innerText = feedbackMessage;
            document.getElementById('modal').style.display = 'flex';

        } catch (error) {
            console.error('Error:', error);
            document.getElementById('feedbackMessage').innerText = 'An error occurred while processing your request.';
            document.getElementById('modal').style.display = 'flex';
        }
        document.getElementById('addCustomerForm').reset();
    });
</script>