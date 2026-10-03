-- TFA3 fresh schema. Safe to run again: existing tables and records are preserved.
-- For a TFA2 database without users.avatar, run php spark migrate after import.
CREATE DATABASE IF NOT EXISTS `pos_db`
    CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `pos_db`;

CREATE TABLE IF NOT EXISTS `customers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20),
    `created_at` DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `full_name` VARCHAR(100) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `avatar` VARCHAR(255) NULL
);
