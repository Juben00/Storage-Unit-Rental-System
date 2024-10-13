<form class="bg-white p-6 rounded-lg shadow-lg" id="addStorageForm" enctype="multipart/form-data" method="POST"
    action="upload.php">
    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2" for="storageImages">
            Storage Images </label>
        <input type="file" id="storageImages" name="storageImages[]" multiple required
            class="border-2 w-full border-dashed border-gray-300 rounded-lg p-6 text-center" />
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2" for="productName">
            Product Name </label>
        <input
            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
            id="storageName" name="storageName" placeholder="Storage Name" type="text" required />
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2" for="description"> Description </label>
        <input
            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
            id="description" name="description" placeholder="Storage Description" type="text" required />
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2" for="category">
            Category </label>
        <select name="category" id="category"
            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
            required>
            <option value="" disabled selected>Select an Option</option>
            <option value="Small">Small</option>
            <option value="Medium">Medium</option>
            <option value="Large">Large</option>
        </select>
    </div>

    <div class="mb-4">
        <div class="flex items-center gap-2">
            <label class="block text-gray-700 font-semibold " for="stock"> Stock </label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="stock" name="stock" placeholder="Storage Quantity" type="number" required />

            <label class="block text-gray-700 font-semibold " for="price"> Price </label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="price" name="price" placeholder="Storage Price" type="number" required />
        </div>
    </div>

    <input type="submit" value="Add Storage"
        class="w-full bg-blue-600 text-white py-2 rounded-lg text-center font-semibold hover:bg-blue-700" />
</form>