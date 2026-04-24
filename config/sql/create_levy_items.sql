-- Migration: Create levy_items table
-- Run this in your MySQL/MariaDB database

CREATE TABLE IF NOT EXISTS `levy_items` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `levy_id`     INT UNSIGNED NOT NULL,
    `account_id`  INT UNSIGNED NOT NULL,
    `product_id`  INT UNSIGNED DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `quantity`    INT NOT NULL DEFAULT 1,
    `unit_price`  DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `line_total`  DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `vat_rate`    DECIMAL(5,2) DEFAULT NULL,
    `vat_amount`  DECIMAL(15,2) DEFAULT NULL,
    `vat_type`    VARCHAR(50) DEFAULT NULL,
    `hs_code`     VARCHAR(100) DEFAULT NULL,
    `company_id`  INT UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `levy_id`    (`levy_id`),
    KEY `account_id` (`account_id`),
    KEY `product_id` (`product_id`),
    KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
