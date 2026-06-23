-- Seed SQL for wijaya_transport sample cars
CREATE DATABASE IF NOT EXISTS wijaya_transport CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE wijaya_transport;

CREATE TABLE IF NOT EXISTS cars (
  id INT AUTO_INCREMENT PRIMARY KEY,
  brand VARCHAR(100),
  model VARCHAR(100),
  year INT,
  plate_number VARCHAR(50),
  price_per_day DECIMAL(10,2),
  image VARCHAR(255),
  status VARCHAR(50) DEFAULT 'available',
  created_at DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255),
  phone VARCHAR(50),
  address TEXT,
  role VARCHAR(50) DEFAULT 'user',
  created_at DATETIME
);

CREATE TABLE IF NOT EXISTS bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  car_id INT,
  start_date DATE,
  end_date DATE,
  total_price DECIMAL(12,2),
  status VARCHAR(50) DEFAULT 'pending',
  created_at DATETIME
);

CREATE TABLE IF NOT EXISTS payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  booking_id INT,
  transaction_id VARCHAR(255),
  payment_method VARCHAR(100),
  amount DECIMAL(12,2),
  status VARCHAR(50),
  payment_date DATETIME
);

INSERT INTO cars (brand,model,year,plate_number,price_per_day,image,status,created_at) VALUES
('Lamborghini','Huracan','2020','B-1234-XYZ',3500000.00,'assets/media/car1.jpg','available',NOW()),
('Toyota','Avanza','2019','B-5678-XYZ',500000.00,'assets/media/car2.jpg','available',NOW()),
('Honda','Civic','2021','B-9999-XYZ',800000.00,'assets/media/car3.jpg','unavailable',NOW());
