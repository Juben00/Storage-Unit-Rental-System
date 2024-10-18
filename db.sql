CREATE DATABASE storage_db;

USE storage_db;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL
);

INSERT INTO roles (role_name) VALUES ('Admin'), ('Customer');

CREATE TABLE customer(
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL, -- Foreign key to roles table
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    birthdate DATE NOT NULL,
    sex ENUM('Male', 'Female') NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Accommodates password hashes
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    min_area DECIMAL(10, 2),
    max_area DECIMAL(10, 2)
);

INSERT INTO category (name, min_area, max_area) VALUES
('Small', 0.00, 50.00),
('Medium', 50.01, 100.00),
('Large', 100.01, NULL);  -- NULL for max_area means no upper limit

CREATE TABLE status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status_name VARCHAR(50) NOT NULL
);

INSERT INTO status (status_name) VALUES ('In-stock'), ('Out-of-stock');

CREATE TABLE storage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id INT NOT NULL, -- Foreign key to category table
    description TEXT NOT NULL,
    area DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    status_id INT NOT NULL, -- Foreign key to status table
    image VARCHAR(255) NOT NULL, -- URL for image
    FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE,
    FOREIGN KEY (status_id) REFERENCES status(id)
);

-- Create indexes for performance
CREATE INDEX idx_category_id ON storage(category_id);
CREATE INDEX idx_status_id ON storage(status_id);
CREATE INDEX idx_email ON customer(email);


<form
            class="bg-white max-h-[600px] overflow-y-scroll p-6 rounded-lg shadow-lg left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 absolute"
            id="updateStorageForm" enctype="multipart/form-data">
            <div class="mb-4">
                <input type="hidden" name="u_id" id="u_id">
                <input type="hidden" name="existing_image" id="existing_image">

                <div id="imagePreview" class="mb-4 flex gap-2">
                    <!-- This will be populated dynamically with images -->
                </div>

                <label class="block text-gray-700 font-semibold mb-2" for="u_image">
                    Storage Image </label>
                <input type="file" id="u_image" name="u_image[]" multiple
                    class="border-2 w-full border-dashed border-gray-300 rounded-lg p-6 text-center" />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="u_storageName">
                    Product Name </label>
                <input
                    class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    id="u_storageName" name="u_storageName" placeholder="Storage Name" type="text" required />
                <span class="w-2/5">
                    <label class="block text-gray-700 font-semibold mb-1" for="storageArea">
                        Storage Area <span class="text-xs font-normal text-red-500">*sqm</span></label>
                    <input
                        class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        id="storageArea" name="storageArea" placeholder="Storage Area" type="number" required />
                </span>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="u_description"> Description
                </label>
                <input
                    class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    id="u_description" name="u_description" placeholder="Storage Description" type="text" required />
            </div>

            <div class="mb-4">
                <input type="hidden" name="u_category" id="u_category"
                    class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600" />
            </div>

            <div class="mb-4">
                <div class="flex items-center gap-2">
                    <div class="flex flex-col w-full">
                        <label class="block text-gray-700 font-semibold " for="u_stock"> Stock </label>
                        <input
                            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            id="u_stock" name="u_stock" placeholder="Storage Quantity" type="number" min="0" required />
                    </div>
                    <div class="flex flex-col w-full">
                        <label class="block text-gray-700 font-semibold " for="u_price"> Price </label>
                        <input
                            class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            id="u_price" name="u_price" placeholder="Storage Price" type="number" min="0" step="0.01"
                            required />
                    </div>
                </div>
            </div>

            <input type="submit" value="Update Product"
                class="w-full bg-blue-600 text-white py-2 rounded-lg text-center font-semibold hover:bg-blue-700" />
        </form>