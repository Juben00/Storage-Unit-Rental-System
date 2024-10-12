<form class="bg-white p-6 rounded-lg shadow-lg" id="addStorageForm">
    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2" for="image">
            Storage Image </label>
        <input type="file" id="image" name="image"
            class="border-2 w-full border-dashed border-gray-300 rounded-lg p-6 text-center" />

    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2" for="productName">
            Product Name </label>
        <input
            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
            id="storageName" placeholder="Storage Name" name="storageName" type="text" />
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2" for="description"> Description
        </label>
        <textarea
            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
            id="description" name="description" placeholder="Storage Description">
                                    </textarea>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2" for="category">
            Category </label>
        <select name="category" id="category"
            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <option value="">Select an Option</option>
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
                id="stock" name="stock" placeholder="Storage Quantity" type="text" />

            <label class="block text-gray-700 font-semibold " for="price"> Price </label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="price" name="price" placeholder="Storage Price" type="text" />
        </div>
    </div>
    <input type="submit" value="Add Product"
        class="w-full bg-blue-600 text-white py-2 rounded-lg text-center font-semibold hover:bg-blue-700" />
</form>