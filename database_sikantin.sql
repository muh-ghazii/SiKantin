CREATE DATABASE IF NOT EXISTS db_kantin;

USE db_kantin;

-- DDL
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    PASSWORD VARCHAR(255) NOT NULL,
    ROLE ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE menus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    nama_menu VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga DECIMAL(10, 2) NOT NULL,
    stok INT DEFAULT 0,
    gambar_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_harga DECIMAL(10, 2) NOT NULL,
    STATUS ENUM('pending', 'diproses', 'selesai', 'batal') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_id INT NOT NULL,
    jumlah INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE
);

-- DML
INSERT INTO categories (nama_kategori) VALUES
('Makanan Utama'),
('Minuman'),
('Camilan');

INSERT INTO users (nama, email, PASSWORD, ROLE) VALUES
('Admin Kantin', 'admin@kantin.com', '123456', 'admin'),
('Andi Pembeli', 'andi@kampus.com', '123456', 'user');

INSERT INTO menus (category_id, nama_menu, deskripsi, harga, stok) VALUES
(1, 'Nasi Goreng Ayam', 'Nasi goreng porsi besar', 15000, 20),
(2, 'Es Teh Manis', 'Es teh gula asli', 4000, 50),
(3, 'Pisang Goreng', 'Pisang goreng cokelat keju', 6000, 30);

INSERT INTO orders (user_id, total_harga, STATUS) VALUES
(2, 19000, 'pending');
