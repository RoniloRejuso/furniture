CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    category ENUM('living_room', 'dining_room', 'bedroom', 'home_office') NOT NULL,
    status ENUM('Available', 'Not available') NOT NULL DEFAULT 'Available', -- Changed to include default value
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    product_image VARCHAR(255)
);