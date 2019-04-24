CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(128),
    symbol CHAR(64)
);

CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    user_id INT,
    user_id_win INT,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title CHAR(255),
    description CHAR(255),
    path CHAR(255),
    start_price INT,
    dt_close DATE,
    step INT
);

CREATE TABLE bet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    lot_id INT,
    bet_price INT,
    dt_bet TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lot_id INT,
    bet_id INT,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email CHAR(128),
    name CHAR(255),
    password CHAR(64),
    avatar_path CHAR(255),
    contact TEXT
);

CREATE UNIQUE INDEX email ON users(email);

CREATE UNIQUE INDEX pass ON users(password);

CREATE INDEX lot_title ON lot(title);

CREATE INDEX lot_desc ON lot(description)