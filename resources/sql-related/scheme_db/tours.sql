CREATE TABLE TOURS (
    tour_id INT AUTO_INCREMENT PRIMARY KEY,
    tour_name VARCHAR(100) NOT NULL,
    tour_price DECIMAL(10, 2) NOT NULL,
    active TINYINT(1) DEFAULT 1,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    description TEXT,
    image_path VARCHAR(255)
);

