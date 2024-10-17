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
