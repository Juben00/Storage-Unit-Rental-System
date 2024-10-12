CREATE DATABASE storage_db;

USE Storage_db;

CREATE TABLE customer(
    id INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('Admin', 'Customer') NOT NULL,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    birthdate DATE NOT NULL,
    sex ENUM('Male', 'Female') NOT NULL,
    phone VARCHAR(100) NOT NULL,
    address VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);

CREATE TABLE storage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category ENUM('Small,', 'Medium', 'Large'),
    description VARCHAR(100) NOT NULL,
    stock INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    status ENUM('In-stock', 'Out-of-Stock') NOT NULL,
    image VARCHAR(100) NOT NULL
)