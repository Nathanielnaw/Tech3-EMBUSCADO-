-- TFA3 submission export with fictional sample records and no credentials.
-- Import into a fresh MySQL/MariaDB instance to recreate the activity database.
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

INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES
    (1, 'Maria Santos', 'maria.santos@example.com', '+63 917 555 0101', '2026-10-01 09:00:00'),
    (2, 'James Carter', 'james.carter@example.com', '+63 918 555 0102', '2026-10-01 09:15:00'),
    (3, 'Aisha Rahman', 'aisha.rahman@example.com', '+63 919 555 0103', '2026-10-01 09:30:00'),
    (4, 'Daniel Lee', 'daniel.lee@example.com', '+63 920 555 0104', '2026-10-01 09:45:00'),
    (5, 'Sofia Garcia', 'sofia.garcia@example.com', '+63 921 555 0105', '2026-10-01 10:00:00')
ON DUPLICATE KEY UPDATE `id` = `id`;

INSERT INTO `users` (`id`, `username`, `full_name`, `created_at`) VALUES
    (1, 'mrivera', 'Miguel Rivera', '2026-10-01 08:00:00'),
    (2, 'lchen', 'Lena Chen', '2026-10-01 08:15:00'),
    (3, 'apatel', 'Arjun Patel', '2026-10-01 08:30:00'),
    (4, 'jwilson', 'Jordan Wilson', '2026-10-01 08:45:00'),
    (5, 'nreyes', 'Nina Reyes', '2026-10-01 09:00:00')
ON DUPLICATE KEY UPDATE `id` = `id`;
