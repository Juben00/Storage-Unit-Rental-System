<form class="bg-white p-6 rounded-lg shadow-lg" id="addStorageForm" enctype="multipart/form-data">
    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1" for="storageImages">
            Storage Images </label>
        <input type="file" id="storageImages" name="storageImages[]" multiple required
            class="border-2 w-full border-dashed border-gray-300 rounded-lg p-6 text-center" />
    </div>

    <div class="mb-4 flex items-center gap-2">
        <span class="w-full">
            <label class="block text-gray-700 font-semibold mb-1" for="storageName">
                Storage Name </label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="storageName" name="storageName" placeholder="Storage Name" type="text" required />
        </span>
        <span class="w-2/5">
            <label class="block text-gray-700 font-semibold mb-1" for="storageArea">
                Storage Area <span class="text-xs font-normal text-red-500">*sqm</span></label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="storageArea" name="storageArea" placeholder="Storage Area" type="number" required />
        </span>

    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1" for="description"> Description </label>
        <textarea
            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600 resize-none"
            id="description" name="storageDescription" placeholder="Storage Description" rows="4" required></textarea>
    </div>


    <input
        class="w-full border border-gray-300 rounded-lg py-2 px-4 hidden focus:outline-none focus:ring-2 focus:ring-blue-600"
        id="storageCategory" name="storageCategory" placeholder="Storage Category" type="text" readonly />

    <div class="flex items-center gap-2 mb-4">

        <span class="flex flex-col w-full">
            <label class="block text-gray-700 font-semibold " for="price"> Price </label>
            <input
                class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                id="price" name="storagePrice" placeholder="Storage Price" type="number" required />
        </span>
    </div>

    <input type="submit" value="Add Storage"
        class="w-full bg-blue-600 text-white py-2 rounded-lg text-center font-semibold hover:bg-blue-700" />
</form>
<script>
    const storageAreaInput = document.getElementById('storageArea');
    const storageCategoryInput = document.getElementById('storageCategory');

    storageAreaInput.addEventListener('input', function () {
        const area = parseFloat(storageAreaInput.value);

        if (area < 50) {
            storageCategoryInput.value = '1'; // Category 1 for area < 50
        } else if (area < 100) {
            storageCategoryInput.value = '2'; // Category 2 for area < 100
        } else {
            storageCategoryInput.value = '3'; // Category 3 for area >= 100
        }

        console.log(storageCategoryInput.value);

    });
</script>