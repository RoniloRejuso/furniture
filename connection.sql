CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    category ENUM('living_room', 'dining_room', 'bedroom', 'home_office') NOT NULL,
    status ENUM('Available', 'Not available') NOT NULL DEFAULT 'Available',
    price DECIMAL(9) NOT NULL,
    quantity INT NOT NULL,
    product_image VARCHAR(255),
    color VARCHAR(50),
    size VARCHAR(20),   
    weight_capacity DECIMAL(8, 2) NOT NULL  
);


CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin INT NOT NULL DEFAULT 0,
);
CREATE TABLE orders (
    orders_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,  -- Corrected the syntax here
    quantity INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    amount_change INT NOT NULL,
    date DATE NOT NULL
);


CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(9) NOT NULL,
    product_image VARCHAR(255),
    category VARCHAR(255) NOT NULL,
    quantity INT(9) NOT NULL,

);
CREATE TABLE carousel_banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_url VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

