-- 1. Create the Database
CREATE DATABASE real_estate_db;
USE real_estate_db;

-- 2. Property Categories Table
CREATE TABLE property_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Users Table (End-User, Agent, Admin)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('end-user', 'agent', 'admin') NOT NULL,
    profile_pic VARCHAR(255) NULL,
    contact VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- 4. Amenities Table
CREATE TABLE amenities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Properties Table (Including Category and Agent Association)
CREATE TABLE properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,                       
    title VARCHAR(255) NOT NULL,           
    description TEXT,                      
    location VARCHAR(255) NOT NULL,         
    rent_price DECIMAL(10,2) NOT NULL,       
    old_price DECIMAL(10,2),                 
    bedrooms INT,                         
    bathrooms INT,                         
    area INT,                              
    image_url VARCHAR(255),                
    agent_id INT,                          
    status ENUM('available', 'sold', 'rented') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES property_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (agent_id) REFERENCES users(id) ON DELETE SET NULL
);


-- 6. Property_Amenities Mapping Table (Many-to-Many Relationship)
CREATE TABLE property_amenities (
    property_id INT,
    amenity_id INT,
    PRIMARY KEY (property_id, amenity_id),
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (amenity_id) REFERENCES amenities(id) ON DELETE CASCADE
);

-- 7. Transactions Table (Tracking Property Transactions)
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    property_id INT NOT NULL,
    transaction_type ENUM('hire', 'buy', 'sell') NOT NULL,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE
);

-- 8. Payments Table (Linked to Transactions)
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('credit_card', 'bank_transfer', 'paypal') NOT NULL,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE
);

-- 9. Approvals Table (Agent Approval Process)
CREATE TABLE approvals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agent_id INT NOT NULL,
    admin_id INT NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE
);

-- -----------------------------------------------
-- Inserting Dummy Data for Testing and Validation
-- -----------------------------------------------

-- Insert Dummy Data for Property Categories
INSERT INTO property_categories (name, description) VALUES
('Residential', 'Properties for living such as houses, apartments, and condos.'),
('Commercial', 'Office spaces, retail shops, and other commercial properties.'),
('Industrial', 'Warehouses, factories, and industrial units.'),
('Plot', 'Warehouses, factories, and industrial units.');

-- Insert Dummy Data for Users
INSERT INTO users (name, email, password_hash, role, contact, profile_pic, created_at)
VALUES
('James Stallon', 'agent1@example.com', 'hashedpassword1', 'agent', '1234567890', 'images/team-1.jpg', NOW()),
('John Doe', 'john@example.com', 'hashedpassword2', 'end-user', '1234567890', 'images/team-2.jpg', NOW()),
('Jane Smith', 'jane@example.com', 'hashedpassword3', 'agent', '1234567890', 'images/team-3.jpg', NOW()),
('Admin User', 'admin@example.com', 'hashedpassword4', 'admin', NULL, 'images/team-4.jpg', NOW()),
('James Stallon', 'agent5@example.com', 'hashedpassword5', 'agent', '1234567890', 'images/team-5.jpg', NOW()),
('James Stallon', 'agent6@example.com', 'hashedpassword6', 'agent', '1234567890', 'images/team-6.jpg', NOW()),
('James Stallon', 'agent7@example.com', 'hashedpassword7', 'agent', '1234567890', 'images/team-7.jpg', NOW()),
('James Stallon', 'agent8@example.com', 'hashedpassword8', 'agent', '1234567890', 'images/team-8.jpg', NOW());


-- Insert Dummy Data for Amenities
INSERT INTO amenities (name, description) VALUES
('Pool', 'Swimming pool available for residents.'),
('Gym', 'On-site gym facility with modern equipment.'),
('Parking', 'Secure parking space available.'),
('Security', '24/7 security and surveillance.'),
('Balcony', 'Private balcony with a scenic view.');


INSERT INTO properties (
    category_id, 
    title, 
    description, 
    location, 
    rent_price, 
    old_price, 
    bedrooms, 
    bathrooms, 
    area, 
    image_url, 
    agent_id
) VALUES
(1, 'The Blue Sky Home', 'Spacious 3BHK property with modern amenities and a beautiful view.', 'Oakland', 3050, 800000, 3, 2, 1878, 'images/work-2.jpg', 2),
(1, 'Luxury Apartment', 'Spacious 3BHK apartment with sea view.', 'Downtown', 3050, 800000, 3, 2, 1878, 'images/work-3.jpg', 2),
(1, 'Cozy Studio', 'Affordable studio apartment ideal for singles.', 'Suburb', 3050, 800000, 3, 2, 1878, 'images/work-4.jpg', 2),
(1, 'The Blue Sky Home', 'Spacious 3BHK property with modern amenities and a beautiful view.', 'Oakland', 3050, 800000, 3, 2, 1878, 'images/work-5.jpg', 2),
(1, 'The Blue Sky Home', 'Spacious 3BHK property with modern amenities and a beautiful view.', 'Oakland', 3050, 800000, 3, 2, 1878, 'images/work-6.jpg', 2),
(1, 'The Blue Sky Home', 'Spacious 3BHK property with modern amenities and a beautiful view.', 'Oakland', 3050, 800000, 3, 2, 1878, 'images/work-4.jpg', 2),
(1, 'The Blue Sky Home', 'Spacious 3BHK property with modern amenities and a beautiful view.', 'Oakland', 3050, 800000, 3, 2, 1878, 'images/work-5.jpg', 2),
(1, 'The Blue Sky Home', 'Spacious 3BHK property with modern amenities and a beautiful view.', 'Oakland', 3050, 800000, 3, 2, 1878, 'images/work-6.jpg', 2);


-- Map Amenities to Properties
-- For property 1: Assign Pool, Gym, and Parking
INSERT INTO property_amenities (property_id, amenity_id) VALUES
(1, 1),
(1, 2),
(1, 3);

-- For property 2: Assign Security and Balcony
INSERT INTO property_amenities (property_id, amenity_id) VALUES
(2, 4),
(2, 5);

-- Insert Dummy Data for Transactions
INSERT INTO transactions (user_id, property_id, transaction_type, status) VALUES
(1, 1, 'buy', 'completed'),
(1, 2, 'hire', 'pending');

-- Insert Dummy Data for Payments
INSERT INTO payments (transaction_id, amount, payment_method, status) VALUES
(1, 150000, 'bank_transfer', 'completed'),
(2, 5000, 'paypal', 'pending');

-- Insert Dummy Data for Approvals (Agent Approval by Admin)
INSERT INTO approvals (agent_id, admin_id, status) VALUES
(2, 3, 'approved');
