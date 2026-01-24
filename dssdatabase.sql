
CREATE TABLE departments (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    num_students INT NOT NULL,
    last_allocation_date DATE DEFAULT NULL
);
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','department') NOT NULL,
    department_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(department_id)
);
CREATE TABLE resources (
    resource_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    cost DECIMAL(10,2) DEFAULT 0.00
);
CREATE TABLE resource_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT NOT NULL,
    resource_id INT NOT NULL,
    quantity INT NOT NULL,
    urgency ENUM('low','medium','high') NOT NULL,
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending','approved','denied') DEFAULT 'pending',
    FOREIGN KEY (department_id) REFERENCES departments(department_id),
    FOREIGN KEY (resource_id) REFERENCES resources(resource_id)
);
CREATE TABLE allocations (
    allocation_id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT NOT NULL,
    resource_id INT NOT NULL,
    quantity INT NOT NULL,
    allocation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(department_id),
    FOREIGN KEY (resource_id) REFERENCES resources(resource_id)
);
CREATE TABLE logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
