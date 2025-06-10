CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Member', 'Administrator', 'Tim Keuangan', 'panitia pelaksana kegiatan') NOT NULL,
    status ENUM('ACTIVE', 'INACTIVE'),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE events (
    event_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    speaker VARCHAR(255),
    poster_url TEXT,
    registration_fee INT NOT NULL,
    max_participants INT NOT NULL,
    created_by INT,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);


CREATE TABLE event_registrations (
    registration_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    event_id INT,
    payment_status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    payment_proof TEXT,
    certificate VARCHAR(255),
    qr_code VARCHAR(255), -- Bisa berupa kode unik
    registered_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (event_id) REFERENCES events(event_id)
);


CREATE TABLE attendances (
    attendance_id INT PRIMARY KEY AUTO_INCREMENT,
    registration_id INT,
    scanned_by INT, -- panitia
    scanned_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (registration_id) REFERENCES event_registrations(registration_id),
    FOREIGN KEY (scanned_by) REFERENCES users(user_id)
);