<?php
$db = new mysqli('localhost', 'root', '', 'eras_app');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sqls = [
    // 1. Branding & Currency
    "ALTER TABLE companies ADD COLUMN IF NOT EXISTS logo LONGTEXT NULL AFTER email",
    "ALTER TABLE companies ADD COLUMN IF NOT EXISTS reporting_currency VARCHAR(10) DEFAULT 'USD' AFTER logo",

    // 2. Departments Table
    "CREATE TABLE IF NOT EXISTS `departments` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `company_id` INT NOT NULL,
        `name` VARCHAR(255) NOT NULL,
        `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `modified` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 3. Ensure company_id exists in relevant tables (Fixing existing schema gaps)
    "ALTER TABLE `bills` ADD COLUMN IF NOT EXISTS `company_id` INT NULL AFTER `id` ",
    "ALTER TABLE `invoices` ADD COLUMN IF NOT EXISTS `company_id` INT NULL AFTER `id` ",

    // 4. Department IDs
    "ALTER TABLE `transactions` ADD COLUMN IF NOT EXISTS `department_id` INT NULL ",
    "ALTER TABLE `invoices` ADD COLUMN IF NOT EXISTS `department_id` INT NULL ",
    "ALTER TABLE `bills` ADD COLUMN IF NOT EXISTS `department_id` INT NULL ",
    "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `department_id` INT NULL ",

    // 5. Exchange Rates Table
    "CREATE TABLE IF NOT EXISTS `exchange_rates` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `company_id` INT NOT NULL,
        `currency` VARCHAR(10) NOT NULL,
        `rate_to_base` DECIMAL(18,8) NOT NULL,
        `date` DATE NOT NULL,
        `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `modified` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];

foreach ($sqls as $sql) {
    if ($db->query($sql) === TRUE) {
        echo "Success: $sql\n";
    } else {
        echo "Error: (" . $db->errno . ") " . $db->error . " | $sql\n";
    }
}
$db->close();
echo "Migration complete.\n";
