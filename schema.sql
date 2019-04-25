CREATE DATABASE yeticave1
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE yeticave1;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(128),
    symbol CHAR(64)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email CHAR(128),
    name CHAR(255),
    password CHAR(64),
    avatar_path CHAR(255),
    contact TEXT
);

CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    user_id INT,
    user_id_win INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title CHAR(255),
    description VARCHAR(1024),
    path TEXT,
    start_price INT,
    closed_at DATE,
    step INT,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (user_id_win) REFERENCES users(id)
);

CREATE TABLE bet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    lot_id INT,
    bet_price INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lot_id) REFERENCES lot(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE UNIQUE INDEX email ON users(email);

CREATE INDEX lot_title ON lot(title);

CREATE INDEX lot_desc ON lot(description);