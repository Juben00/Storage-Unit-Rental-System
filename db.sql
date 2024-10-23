-- Create the database
CREATE DATABASE storage_db;

-- Switch to the new database
USE storage_db;

-- Roles table
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL
);

-- Insert default roles
INSERT INTO roles (role_name) VALUES ('Admin'), ('Customer');

-- Customer table
CREATE TABLE customer (
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

-- Category table
CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    min_area DECIMAL(10, 2),
    max_area DECIMAL(10, 2)
);

-- Insert default categories
INSERT INTO category (name, min_area, max_area) VALUES
('Small', 0.00, 50.00),
('Medium', 50.01, 100.00),
('Large', 100.01, NULL);  -- NULL for max_area means no upper limit

-- Status table
CREATE TABLE status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status_name VARCHAR(50) NOT NULL
);

-- Insert default statuses
INSERT INTO status (status_name) VALUES ('In-stock'), ('Out-of-stock');

-- Storage table
CREATE TABLE storage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id INT NOT NULL, -- Foreign key to category table
    description TEXT NOT NULL,
    area DECIMAL(10, 2) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    status_id INT NOT NULL, -- Foreign key to status table
    image VARCHAR(255) NOT NULL, -- URL for image
    FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE,
    FOREIGN KEY (status_id) REFERENCES status(id)
);

-- Bookmark table
CREATE TABLE bookmark (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL, -- Foreign key to customer table
    storage_id INT NOT NULL, -- Foreign key to storage table
    FOREIGN KEY (customer_id) REFERENCES customer(id) ON DELETE CASCADE,
    FOREIGN KEY (storage_id) REFERENCES storage(id) ON DELETE CASCADE
);

-- Booking Status table
CREATE TABLE booking_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status_name VARCHAR(50) NOT NULL UNIQUE -- E.g., 'Pending', 'Confirmed', 'Cancelled'
);

-- Insert default booking statuses
INSERT INTO booking_status (status_name) VALUES ('Pending'), ('Confirmed'), ('Cancelled');

-- Booking table
CREATE TABLE booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL, -- Foreign key to customer table
    storage_id INT NOT NULL, -- Foreign key to storage table
    booking_date DATE NOT NULL DEFAULT CURDATE(), -- Date when the booking is made, default to current date
    start_date DATE NOT NULL, -- Start date of the booking
    end_date DATE NOT NULL, -- End date of the booking
    total_amount DECIMAL(10, 2) NOT NULL, -- Precision for monetary values
    booking_status_id INT NOT NULL, -- Foreign key to booking_status table
    FOREIGN KEY (customer_id) REFERENCES customer(id) ON DELETE CASCADE,
    FOREIGN KEY (storage_id) REFERENCES storage(id) ON DELETE CASCADE,
    FOREIGN KEY (booking_status_id) REFERENCES booking_status(id),
    CONSTRAINT chk_dates CHECK (end_date > start_date) -- Ensure end date is after start date
);

-- Payment Status table
CREATE TABLE payment_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status_name VARCHAR(50) NOT NULL UNIQUE -- E.g., 'Pending', 'Completed', 'Failed'
);

-- Insert default payment statuses
INSERT INTO payment_status (status_name) VALUES ('Pending'), ('Completed'), ('Failed');

-- Payment table
CREATE TABLE payment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL, -- Foreign key to booking table
    amount DECIMAL(10, 2) NOT NULL, -- Amount paid
    payment_method VARCHAR(50) NOT NULL, -- Method of payment (e.g., 'Credit Card', 'PayPal', etc.)
    payment_status_id INT NOT NULL, -- Foreign key to payment_status table
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for payment date
    FOREIGN KEY (booking_id) REFERENCES booking(id) ON DELETE CASCADE, -- Payment associated with booking
    FOREIGN KEY (payment_status_id) REFERENCES payment_status(id) -- Payment status
);

-- Indexing for optimization
CREATE INDEX idx_category_id ON storage(category_id);
CREATE INDEX idx_status_id ON storage(status_id);
CREATE INDEX idx_email ON customer(email);
