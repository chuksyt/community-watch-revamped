-- Community Watch — Database Schema
-- Run this in phpMyAdmin or via MySQL CLI before using the app

CREATE DATABASE IF NOT EXISTS `missing_person_database`
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `missing_person_database`;

CREATE TABLE IF NOT EXISTS `registered_users` (
    `id`        INT AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(150) NOT NULL,
    `username`  VARCHAR(80)  NOT NULL UNIQUE,
    `email`     VARCHAR(150) NOT NULL UNIQUE,
    `password`  VARCHAR(255) NOT NULL,
    `Aadhar`    VARCHAR(20)  NOT NULL,
    `Phone`     VARCHAR(20)  NOT NULL,
    `address`   VARCHAR(255) NOT NULL,
    `pin_code`  VARCHAR(20)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `user_complaint` (
    `id`           INT AUTO_INCREMENT PRIMARY KEY,
    `full_name`    VARCHAR(150) NOT NULL,
    `address`      VARCHAR(255) NOT NULL,
    `pin_code`     VARCHAR(20)  NOT NULL,
    `city`         VARCHAR(100) NOT NULL,
    `missing_date` DATE         NOT NULL,
    `Aadhar`       VARCHAR(20)  NOT NULL,
    `image`        VARCHAR(500) NOT NULL,
    `gen_desc`     TEXT,
    `submitted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `volunteer_details` (
    `id`           INT AUTO_INCREMENT PRIMARY KEY,
    `full_name`    VARCHAR(150) NOT NULL,
    `address`      VARCHAR(255) NOT NULL,
    `pin_code`     VARCHAR(20)  NOT NULL,
    `city`         VARCHAR(100) NOT NULL,
    `image`        VARCHAR(500) NOT NULL,
    `gen_desc`     TEXT,
    `username`     VARCHAR(80)  NOT NULL,
    `submitted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
