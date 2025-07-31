-- Create database
CREATE DATABASE IF NOT EXISTS riwaas_guesthouse;
USE riwaas_guesthouse;

-- Create rooms table
CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    amenities JSON,
    rating DECIMAL(2,1) DEFAULT 0.0,
    available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    guests INT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    booking_items JSON NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample room data
INSERT INTO rooms (name, description, price, image, amenities, rating) VALUES
('Deluxe Room', 'Spacious room with modern amenities, free WiFi, and beautiful city view.', 2500.00, 'img/WhatsApp Image 2025-07-18 at 11.57.33 AM.jpeg', '["Free WiFi", "Free Parking", "Breakfast", "AC", "TV"]', 4.5),
('Standard Room', 'Comfortable room with essential amenities for a pleasant stay.', 1800.00, 'img/WhatsApp Image 2025-02-07 at 1.40.15 PM.jpeg', '["Free WiFi", "Free Parking", "TV", "AC"]', 4.0),
('Premium Room', 'Luxury room with premium amenities and exceptional service.', 3200.00, 'img/WhatsApp Image 2025-02-16 at 9.55.06 AM.jpeg', '["Free WiFi", "Free Parking", "Room Service", "AC", "TV", "Mini Bar"]', 5.0),
('Airport Transfer', 'Comfortable airport pickup and drop service.', 800.00, 'img/WhatsApp Image 2025-06-11 at 10.15.09 AM.jpeg', '["AC Vehicle", "24/7 Available", "Professional Driver"]', 4.2);

-- Create indexes for better performance
CREATE INDEX idx_bookings_dates ON bookings(check_in, check_out);
CREATE INDEX idx_bookings_status ON bookings(status);
CREATE INDEX idx_bookings_email ON bookings(email);
CREATE INDEX idx_rooms_available ON rooms(available);
CREATE INDEX idx_rooms_price ON rooms(price);