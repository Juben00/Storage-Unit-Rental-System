<form class="bg-white p-6 rounded-lg shadow-lg" id="addStorageForm" enctype="multipart/form-data">
    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1" for="storageImages">
            Storage Images </label>
        <input type="file" id="storageImages" name="storageImages[]" multiple required
            class="border-2 w-full border-dashed border-gray-300 rounded-lg p-6 text-center" />
    </div>

    <div class="mb-4 flex items-center gap-2">
        <span class="w-full">
            <label class="block text-gray-700 font-semibold mb-1" for="productName">
                Storage Name </label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="storageName" name="storageName" placeholder="Storage Name" type="text" required />
        </span>
        <span class="w-2/5">
            <label class="block text-gray-700 font-semibold mb-1" for="productName">
                Storage Area <span class="text-xs font-normal text-red-500">*sqm</span></label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="storageName" name="storageArea" placeholder="Storage Area" type="text" required />
        </span>

    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1" for="description"> Description </label>
        <textarea
            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600 resize-none"
            id="description" name="description" placeholder="Storage Description" rows="4" required></textarea>
    </div>


    <div class="mb-4">
        <input type="hidden" name="category" id="category"
            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600" />
    </div>

    <div class="flex items-center gap-2 mb-4">
        <span class="flex flex-col w-full">
            <label class="block text-gray-700 font-semibold " for="stock"> Stock </label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="stock" name="stock" placeholder="Storage Quantity" type="number" required />
        </span>

        <span class="flex flex-col w-full">
            <label class="block text-gray-700 font-semibold " for="price"> Price </label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="price" name="price" placeholder="Storage Price" type="number" required />
        </span>
    </div>

    <input type="submit" value="Add Storage"
        class="w-full bg-blue-600 text-white py-2 rounded-lg text-center font-semibold hover:bg-blue-700" />
</form>