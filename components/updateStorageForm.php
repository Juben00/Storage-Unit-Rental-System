<form
    class="bg-white max-h-[600px] overflow-y-scroll p-6 rounded-lg shadow-lg left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 absolute"
    id="updateStorageForm" enctype="multipart/form-data">

    <input type="hidden" name="u_id" id="u_id">
    <input type="hidden" name="existing_image" id="existing_image">

    <div id="imagePreview" class="mb-4 flex gap-2">
        <!-- This will be populated dynamically with images -->
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1" for="u_image">
            Storage Images </label>
        <input type="file" id="u_image" name="u_image[]" multiple
            class="border-2 w-full border-dashed border-gray-300 rounded-lg p-6 text-center" />
    </div>

    <div class="mb-4 flex items-center gap-2">
        <span class="w-full">
            <label class="block text-gray-700 font-semibold mb-1" for="u_storageName">
                Storage Name </label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="u_storageName" name="u_storageName" placeholder="Storage Name" type="text" required />
        </span>

        <span class="w-2/5">
            <label class="block text-gray-700 font-semibold mb-1" for="u_area">
                Storage Area </label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="u_area" name="u_area" placeholder="Storage Area" type="number" required />
        </span>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1" for="u_description"> Description </label>
        <textarea
            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600 resize-none"
            id="u_description" name="u_description" placeholder="Storage Description" rows="4" required></textarea>
    </div>

    <input
        class="w-full border border-gray-300 rounded-lg py-2 px-4 hidden focus:outline-none focus:ring-2 focus:ring-blue-600"
        id="u_category" name="u_category" placeholder="Storage Category" type="text" readonly />

    <div class="flex items-center gap-2 mb-4">

        <span class="flex flex-col w-full">
            <label class="block text-gray-700 font-semibold " for="u_price"> Price </label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="u_price" name="u_price" placeholder="Storage Price" type="number" required />
        </span>
    </div>

    <input type="submit" value="Update Storage"
        class="w-full bg-blue-600 text-white py-2 rounded-lg text-center font-semibold hover:bg-blue-700" />
</form>

<script>
    // Function to calculate and update the storage category based on the area
    document.getElementById('u_area').addEventListener('input', function () {
        let area = parseFloat(this.value); // Get the area value from input
        let category = '';

        // Set category based on area
        if (area < 50) {
            category = '1';
        } else if (area < 100) {
            category = '2';
        } else
            category = '3';


        // Update the hidden category input field
        document.getElementById('u_category').value = category;
    });
</script>