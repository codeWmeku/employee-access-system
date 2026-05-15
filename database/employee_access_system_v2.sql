-- Drop existing database if it exists
DROP DATABASE IF EXISTS employee_access_system;

-- Create fresh database
CREATE DATABASE employee_access_system;
USE employee_access_system;

-- Create employees table with status and created_at
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'employee',
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin account (password: admin12345)
INSERT INTO employees (fullname, email, password, role, status) 
VALUES ('Administrator', 'admin@system.local', '$2y$12$B.8MwEBvKmkoBi6olOXLXuFYp3568kKqUNZzPd8hreAnbe54gSxmu', 'admin', 'approved');

-- Create departments table
CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL
);

-- Create permissions table
CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    department_id INT,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);

-- Create access_logs table
CREATE TABLE access_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    department_id INT,
    status VARCHAR(50),
    access_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
