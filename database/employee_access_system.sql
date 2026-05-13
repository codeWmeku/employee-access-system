CREATE DATABASE employee_access_system;
USE employee_access_system;

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'employee'
);

CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL
);

CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    department_id INT,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);

CREATE TABLE access_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    department_id INT,
    status VARCHAR(50),
    access_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);