<?php
$db = new mysqli('localhost', 'root', '', 'eras_app');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sqls = [
    // 1. Add employee_id to users table (links user account to employee record)
    "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `employee_id` INT NULL AFTER `role_id`",

    // 2. Insert Employee role if not exists
    "INSERT IGNORE INTO `roles` (`id`, `name`) 
     SELECT 10, 'Employee' WHERE NOT EXISTS (SELECT 1 FROM `roles` WHERE `name` = 'Employee')",

    // 3. Create sandbox database
    "CREATE DATABASE IF NOT EXISTS `sandbox` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",

    // 4. Add address, phone, email to companies if missing (for branding on portal payslips)
    "ALTER TABLE `companies` ADD COLUMN IF NOT EXISTS `address` TEXT NULL AFTER `reporting_currency`",
    "ALTER TABLE `companies` ADD COLUMN IF NOT EXISTS `phone` VARCHAR(50) NULL AFTER `address`",
];

foreach ($sqls as $sql) {
    if ($db->query($sql) === TRUE) {
        echo "✅ Success: " . substr($sql, 0, 80) . "...\n";
    } else {
        echo "❌ Error: (" . $db->errno . ") " . $db->error . " | " . substr($sql, 0, 80) . "\n";
    }
}

$db->close();
echo "\n✅ Portal & Sandbox migration complete.\n";
