CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    status ENUM('Available', 'Not available') NOT NULL DEFAULT 'Available', -- Changed to include default value
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    product_image VARCHAR(255)
);

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin INT NOT NULL DEFAULT 0 -- Added new column for admin status with default value 0
);
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    order_date DATE NOT NULL,
    order_status VARCHAR(50) NOT NULL,
    order_amount DECIMAL(10,2) NOT NULL
);
