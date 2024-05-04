CREATE TABLE files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    size INT NOT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);