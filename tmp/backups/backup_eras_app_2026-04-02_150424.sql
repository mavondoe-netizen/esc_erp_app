-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: eras_app
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `category` varchar(151) NOT NULL,
  `type` varchar(151) NOT NULL,
  `company_id` int(11) NOT NULL,
  `subcategory` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'Receivables','1','1',1,NULL),(2,'Rental Income','4','2',1,NULL),(3,'Salaries','6','2',1,NULL),(4,'Premiums','4','2',1,NULL),(5,'basic_salary','6','2',1,NULL),(6,'Transport Allowance','6','1',1,NULL),(7,'Covid Allowance','6','2',1,NULL),(8,'Consulting Income','4','2',1,NULL),(9,'Other Income','4','2',1,NULL),(10,'Licenses','4','2',1,NULL),(11,'Housing Allowance','6','2',1,NULL),(12,'Union Dues','2','1',1,NULL),(13,'Medical Aid','2','1',1,NULL),(14,'Salary Adavance Recovery','1','1',1,NULL),(15,'FBC Bank Nostro','1','1',1,NULL),(16,'ZB ZWG account','1','1',1,NULL),(17,'ZB Nostro Account','1','1',1,NULL),(18,'NSSA_ee','2','1',1,NULL),(19,'PAYE','2','1',1,NULL),(20,'Aids Levy','2','1',1,NULL),(21,'Pension','2','1',1,NULL);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounts_invoices`
--

DROP TABLE IF EXISTS `accounts_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts_invoices`
--

LOCK TABLES `accounts_invoices` WRITE;
/*!40000 ALTER TABLE `accounts_invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounts_invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `approval_flows`
--

DROP TABLE IF EXISTS `approval_flows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `approval_flows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approval_flows`
--

LOCK TABLES `approval_flows` WRITE;
/*!40000 ALTER TABLE `approval_flows` DISABLE KEYS */;
INSERT INTO `approval_flows` VALUES (1,'Deals',2,1,'Manager Approves','2025-10-28 17:17:25');
/*!40000 ALTER TABLE `approval_flows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `approval_histories`
--

DROP TABLE IF EXISTS `approval_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `approval_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `approval_id` int(11) NOT NULL,
  `action` enum('initiated','approved','rejected','escalated','cancelled') NOT NULL,
  `level` int(11) DEFAULT NULL,
  `performed_by` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approval_histories`
--

LOCK TABLES `approval_histories` WRITE;
/*!40000 ALTER TABLE `approval_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `approval_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `approvals`
--

DROP TABLE IF EXISTS `approvals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `approvals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(100) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `level` int(11) NOT NULL DEFAULT 1,
  `initiated_by` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approvals`
--

LOCK TABLES `approvals` WRITE;
/*!40000 ALTER TABLE `approvals` DISABLE KEYS */;
INSERT INTO `approvals` VALUES (1,'Deals',8,'pending',2,1,NULL,NULL,'2025-11-02 11:25:40',NULL),(2,'Deals',6,'pending',2,1,NULL,NULL,'2025-11-02 11:38:13',NULL),(3,'Deals',7,'pending',2,1,NULL,NULL,'2025-11-02 11:39:56',NULL),(4,'Deals',13,'pending',2,1,NULL,NULL,'2025-11-02 11:48:10',NULL),(5,'Deals',13,'pending',2,1,NULL,NULL,'2025-11-04 19:09:40',NULL),(6,'Deals',6,'pending',2,1,NULL,NULL,'2025-11-04 19:10:10',NULL),(7,'Deals',13,'pending',2,1,NULL,NULL,'2025-11-22 08:57:15',NULL),(8,'Deals',6,'pending',2,1,NULL,NULL,'2025-11-25 09:25:42',NULL),(9,'Deals',7,'pending',2,1,NULL,NULL,'2025-11-25 09:28:52',NULL),(10,'Deals',8,'pending',2,1,NULL,NULL,'2025-11-25 09:29:44',NULL),(11,'Deals',13,'pending',2,1,NULL,NULL,'2025-11-25 09:30:07',NULL),(12,'Deals',6,'pending',2,1,NULL,NULL,'2025-11-25 10:41:05',NULL),(13,'Deals',7,'pending',2,1,NULL,NULL,'2025-11-25 10:41:40',NULL),(14,'Deals',6,'pending',2,1,NULL,NULL,'2025-11-25 14:25:38',NULL),(15,'Deals',7,'pending',2,1,NULL,NULL,'2025-11-25 14:26:01',NULL),(16,'Deals',14,'pending',2,1,NULL,NULL,'2025-11-25 14:26:48',NULL),(17,'Deals',14,'pending',2,1,NULL,NULL,'2025-11-25 14:27:10',NULL),(18,'Deals',14,'pending',2,1,NULL,NULL,'2026-03-05 10:08:47',NULL),(19,'Deals',14,'pending',2,1,NULL,NULL,'2026-03-05 11:27:05',NULL),(20,'Deals',14,'pending',2,1,NULL,NULL,'2026-03-11 18:26:42',NULL),(21,'Deals',14,'pending',2,1,NULL,NULL,'2026-03-28 20:08:43',NULL);
/*!40000 ALTER TABLE `approvals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `model` varchar(100) NOT NULL,
  `record_id` varchar(255) NOT NULL,
  `action` varchar(50) NOT NULL,
  `changed_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changed_data`)),
  `created` datetime DEFAULT current_timestamp(),
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=911 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,4,'EmployeeProfiles','1','CREATE','[]','2026-03-07 09:24:07',NULL),(2,4,'Roles','2','UPDATE','{\"users\":[{\"id\":2,\"email\":\"mavondoe@gmail.com\",\"role_id\":2},{\"id\":7,\"email\":\"user@hotmail.com\",\"role_id\":2}]}','2026-03-07 09:25:43',NULL),(3,4,'SalaryStructures','1','CREATE','[]','2026-03-07 10:23:18',NULL),(4,4,'SalaryStructures','2','CREATE','[]','2026-03-07 10:24:07',NULL),(5,4,'PayrollComponents','1','CREATE','[]','2026-03-07 10:34:56',NULL),(6,4,'PayrollComponents','1','UPDATE','{\"type\":\"\",\"calculation_type\":\"\",\"value\":\"1.01\",\"is_statutory\":false}','2026-03-07 10:43:56',NULL),(7,4,'PayrollComponents','2','CREATE','[]','2026-03-08 03:16:32',NULL),(8,4,'PayrollComponents','3','CREATE','[]','2026-03-08 03:16:57',NULL),(9,4,'PayrollComponents','4','CREATE','[]','2026-03-08 03:17:23',NULL),(10,4,'PayrollComponents','5','CREATE','[]','2026-03-08 03:17:51',NULL),(11,4,'PayrollComponents','6','CREATE','[]','2026-03-08 03:19:30',NULL),(12,4,'PayrollComponents','7','CREATE','[]','2026-03-08 03:19:52',NULL),(13,4,'Employees','1','CREATE','[]','2026-03-08 11:55:02',NULL),(14,4,'Employees','1','UPDATE','{\"nssa_number\":0,\"tax_number\":0,\"date_of_birth\":null}','2026-03-08 11:58:01',NULL),(15,4,'PayPeriods','1','CREATE','[]','2026-03-08 12:21:44',NULL),(16,4,'Employees','1','UPDATE','{\"disabled\":false,\"national_identity\":null}','2026-03-08 12:24:02',NULL),(17,4,'Accounts','5','CREATE','[]','2026-03-10 04:10:41',NULL),(18,4,'Accounts','5','UPDATE','{\"category\":\"Operating Expenses\",\"type\":\"Income Statement\"}','2026-03-10 04:11:33',NULL),(19,4,'Earnings','1','CREATE','[]','2026-03-10 04:12:29',NULL),(20,4,'PayslipItems','1','CREATE','[]','2026-03-10 19:55:57',NULL),(21,4,'PayslipItems','2','CREATE','[]','2026-03-10 19:55:57',NULL),(22,4,'Payslips','1','CREATE','[]','2026-03-10 19:55:57',NULL),(23,4,'PayslipItems','3','CREATE','[]','2026-03-10 20:24:01',NULL),(24,4,'PayslipItems','4','CREATE','[]','2026-03-10 20:24:01',NULL),(25,4,'PayslipItems','5','CREATE','[]','2026-03-10 20:24:01',NULL),(26,4,'PayslipItems','6','CREATE','[]','2026-03-10 20:24:01',NULL),(27,4,'Payslips','1','UPDATE','{\"deductions\":\"0.00\",\"net_pay\":\"784.00\",\"payslip_items\":[{\"id\":1,\"payslip_id\":1,\"item_type\":\"Earning\",\"name\":\"basic_salary\",\"amount\":\"700.000000\"},{\"id\":2,\"payslip_id\":1,\"item_type\":\"Earning\",\"name\":\"transport allowance\",\"amount\":\"84.000000\"}]}','2026-03-10 20:24:01',NULL),(28,4,'TaxTables','1','CREATE','[]','2026-03-11 03:06:25',NULL),(29,4,'TaxTables','2','CREATE','[]','2026-03-11 03:09:24',NULL),(30,4,'TaxTables','3','CREATE','[]','2026-03-11 03:11:23',NULL),(31,4,'TaxTables','4','CREATE','[]','2026-03-11 03:12:40',NULL),(32,4,'TaxTables','5','CREATE','[]','2026-03-11 03:13:45',NULL),(33,4,'TaxTables','6','CREATE','[]','2026-03-11 03:15:29',NULL),(34,4,'PayPeriods','2','CREATE','[]','2026-03-11 03:18:12',NULL),(35,4,'TaxTables','2','UPDATE','{\"rate\":20}','2026-03-11 03:35:10',NULL),(36,4,'TaxTables','2','UPDATE','{\"rate\":0}','2026-03-11 03:36:23',NULL),(37,4,'TaxTables','6','DELETE','{\"id\":6,\"currency\":\"USD\",\"lower_limit\":3001,\"upper_limit\":10000000,\"rate\":40,\"deduction\":335,\"tax_year\":\"2026-12-31\"}','2026-03-11 03:36:45',NULL),(38,4,'TaxTables','5','DELETE','{\"id\":5,\"currency\":\"USD\",\"lower_limit\":2001,\"upper_limit\":3000,\"rate\":35,\"deduction\":184,\"tax_year\":\"2026-12-31\"}','2026-03-11 03:36:52',NULL),(39,4,'TaxTables','4','DELETE','{\"id\":4,\"currency\":\"USD\",\"lower_limit\":1001,\"upper_limit\":2000,\"rate\":30,\"deduction\":85,\"tax_year\":\"2026-12-31\"}','2026-03-11 03:36:58',NULL),(40,4,'TaxTables','3','DELETE','{\"id\":3,\"currency\":\"USD\",\"lower_limit\":301,\"upper_limit\":1000,\"rate\":25,\"deduction\":35,\"tax_year\":\"2026-12-31\"}','2026-03-11 03:37:05',NULL),(41,4,'TaxTables','2','DELETE','{\"id\":2,\"currency\":\"USD\",\"lower_limit\":101,\"upper_limit\":300,\"rate\":0,\"deduction\":20,\"tax_year\":\"2026-12-31\"}','2026-03-11 03:37:12',NULL),(42,4,'TaxTables','1','DELETE','{\"id\":1,\"currency\":\"USD\",\"lower_limit\":0,\"upper_limit\":100,\"rate\":0,\"deduction\":0,\"tax_year\":\"2026-12-31\"}','2026-03-11 03:37:21',NULL),(43,4,'TaxTables','7','CREATE','[]','2026-03-11 03:37:58',NULL),(44,4,'TaxTables','8','CREATE','[]','2026-03-11 03:39:02',NULL),(45,4,'TaxTables','8','UPDATE','{\"rate\":0}','2026-03-11 03:41:33',NULL),(46,4,'TaxTables','9','CREATE','[]','2026-03-11 03:42:31',NULL),(47,4,'TaxTables','10','CREATE','[]','2026-03-11 03:43:26',NULL),(48,4,'TaxTables','11','CREATE','[]','2026-03-11 03:44:17',NULL),(49,4,'TaxTables','12','CREATE','[]','2026-03-11 03:45:11',NULL),(50,4,'PayslipItems','3','UPDATE','{\"amount\":\"31.500000\"}','2026-03-11 03:55:02',NULL),(51,4,'PayslipItems','4','UPDATE','{\"amount\":\"39.200000\"}','2026-03-11 03:55:02',NULL),(52,4,'PayslipItems','5','UPDATE','{\"amount\":\"0.000000\"}','2026-03-11 03:55:02',NULL),(53,4,'PayslipItems','6','UPDATE','{\"amount\":\"0.000000\"}','2026-03-11 03:55:02',NULL),(54,4,'PayslipItems','7','CREATE','[]','2026-03-11 03:55:02',NULL),(55,4,'PayslipItems','8','CREATE','[]','2026-03-11 03:55:02',NULL),(56,4,'PayslipItems','9','CREATE','[]','2026-03-11 03:55:02',NULL),(57,4,'PayslipItems','10','CREATE','[]','2026-03-11 03:55:02',NULL),(58,4,'Payslips','1','UPDATE','{\"deductions\":\"70.70\",\"net_pay\":\"713.30\",\"payslip_items\":[{\"id\":1,\"payslip_id\":1,\"item_type\":\"Earning\",\"name\":\"basic_salary\",\"amount\":\"700.000000\"},{\"id\":2,\"payslip_id\":1,\"item_type\":\"Earning\",\"name\":\"transport allowance\",\"amount\":\"84.000000\"},{\"id\":3,\"payslip_id\":1,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"0\"},{\"id\":4,\"payslip_id\":1,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"0\"},{\"id\":5,\"payslip_id\":1,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"0\"},{\"id\":6,\"payslip_id\":1,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"0\"}]}','2026-03-11 03:55:02',NULL),(59,4,'PayslipItems','11','CREATE','[]','2026-03-11 04:03:51',NULL),(60,4,'PayslipItems','12','CREATE','[]','2026-03-11 04:03:52',NULL),(61,4,'PayslipItems','13','CREATE','[]','2026-03-11 04:03:52',NULL),(62,4,'PayslipItems','14','CREATE','[]','2026-03-11 04:03:52',NULL),(63,4,'PayslipItems','15','CREATE','[]','2026-03-11 04:03:52',NULL),(64,4,'PayslipItems','16','CREATE','[]','2026-03-11 04:03:52',NULL),(65,4,'Payslips','2','CREATE','[]','2026-03-11 04:03:52',NULL),(66,4,'PayPeriods','3','CREATE','[]','2026-03-11 18:08:02',NULL),(67,4,'Accounts','6','CREATE','[]','2026-03-11 18:21:31',NULL),(68,4,'Accounts','1','UPDATE','{\"category\":\"4\"}','2026-03-11 18:21:53',NULL),(69,4,'Accounts','2','UPDATE','{\"category\":\"1\"}','2026-03-11 18:22:06',NULL),(70,4,'Accounts','3','UPDATE','{\"category\":\"2\"}','2026-03-11 18:22:28',NULL),(71,4,'Accounts','4','UPDATE','{\"category\":\"1\"}','2026-03-11 18:22:46',NULL),(72,4,'Accounts','5','UPDATE','{\"category\":\"2\"}','2026-03-11 18:23:03',NULL),(73,4,'Approvals','20','CREATE','[]','2026-03-11 18:26:42',NULL),(74,4,'Employees','2','CREATE','[]','2026-03-14 02:36:48',NULL),(75,NULL,'Payslips','3','CREATE','[]','2026-03-14 02:45:31',NULL),(76,NULL,'Payslips','3','DELETE','{\"employee_id\":1,\"pay_period_id\":1,\"generated_date\":\"2026-03-14\",\"gross_pay\":\"1000\",\"deductions\":\"100\",\"net_pay\":\"900\",\"basic_salary\":\"0\",\"allowances\":\"0\",\"bonuses\":\"0\",\"overtime\":\"0\",\"benefits\":\"0\",\"pension\":\"0\",\"nssa\":\"0\",\"medical_aid\":\"0\",\"medical_expenses\":\"0\",\"taxable_income\":\"0\",\"paye\":\"0\",\"tax_credits\":\"0\",\"aids_levy\":\"0\",\"total_tax\":\"0\",\"id\":3}','2026-03-14 02:45:31',NULL),(77,4,'PayslipItems','17','CREATE','[]','2026-03-14 02:49:11',NULL),(78,4,'PayslipItems','18','CREATE','[]','2026-03-14 02:49:11',NULL),(79,4,'PayslipItems','19','CREATE','[]','2026-03-14 02:49:11',NULL),(80,4,'PayslipItems','20','CREATE','[]','2026-03-14 02:49:11',NULL),(81,4,'PayslipItems','21','CREATE','[]','2026-03-14 02:49:11',NULL),(82,4,'PayslipItems','22','CREATE','[]','2026-03-14 02:49:11',NULL),(83,4,'Payslips','4','CREATE','[]','2026-03-14 02:49:11',NULL),(84,NULL,'PayslipItems','23','CREATE','[]','2026-03-15 10:51:18',NULL),(85,NULL,'PayslipItems','24','CREATE','[]','2026-03-15 10:51:18',NULL),(86,NULL,'Payslips','5','CREATE','{\"payslip_items\":[{\"item_type\":\"Earning\",\"name\":\"Salary\",\"amount\":\"1500\"},{\"item_type\":\"Deduction\",\"name\":\"Loan Repayment\",\"amount\":\"200\"}]}','2026-03-15 10:51:18',NULL),(87,NULL,'PayslipItems','25','CREATE','[]','2026-03-15 10:51:48',NULL),(88,NULL,'PayslipItems','26','CREATE','[]','2026-03-15 10:51:48',NULL),(89,NULL,'Payslips','6','CREATE','{\"payslip_items\":[{\"item_type\":\"Earning\",\"name\":\"Salary\",\"amount\":\"1500\",\"is_permanent\":true},{\"item_type\":\"Deduction\",\"name\":\"Loan Repayment\",\"amount\":\"200\",\"is_permanent\":false}]}','2026-03-15 10:51:48',NULL),(90,4,'LeaveTypes','1','CREATE','[]','2026-03-15 12:23:25',NULL),(91,4,'LeaveTypes','2','CREATE','[]','2026-03-15 12:23:51',NULL),(92,4,'LeaveTypes','3','CREATE','[]','2026-03-15 12:24:21',NULL),(93,4,'LeaveTypes','4','CREATE','[]','2026-03-15 12:24:49',NULL),(94,4,'PayslipItems','27','CREATE','[]','2026-03-15 12:27:32',NULL),(95,4,'PayslipItems','28','CREATE','[]','2026-03-15 12:27:32',NULL),(96,4,'PayslipItems','29','CREATE','[]','2026-03-15 12:27:32',NULL),(97,4,'PayslipItems','30','CREATE','[]','2026-03-15 12:27:32',NULL),(98,4,'PayslipItems','31','CREATE','[]','2026-03-15 12:27:32',NULL),(99,4,'PayslipItems','32','CREATE','[]','2026-03-15 12:27:32',NULL),(100,4,'PayslipItems','33','CREATE','[]','2026-03-15 12:27:32',NULL),(101,4,'PayslipItems','34','CREATE','[]','2026-03-15 12:27:32',NULL),(102,4,'PayslipItems','35','CREATE','[]','2026-03-15 12:27:32',NULL),(103,4,'PayslipItems','36','CREATE','[]','2026-03-15 12:27:32',NULL),(104,4,'PayslipItems','37','CREATE','[]','2026-03-15 12:27:32',NULL),(105,4,'Payslips','7','CREATE','[]','2026-03-15 12:27:32',NULL),(106,4,'PayPeriods','1','UPDATE','{\"name\":\"\"}','2026-03-15 12:35:43',NULL),(107,4,'PayPeriods','2','UPDATE','{\"name\":\"\"}','2026-03-15 12:36:29',NULL),(108,4,'PayPeriods','3','UPDATE','{\"name\":\"\"}','2026-03-15 12:37:08',NULL),(109,4,'PayslipItems','38','CREATE','[]','2026-03-15 12:50:15',NULL),(110,4,'PayslipItems','39','CREATE','[]','2026-03-15 12:50:15',NULL),(111,4,'PayslipItems','40','CREATE','[]','2026-03-15 12:50:15',NULL),(112,4,'PayslipItems','41','CREATE','[]','2026-03-15 12:50:15',NULL),(113,4,'PayslipItems','42','CREATE','[]','2026-03-15 12:50:15',NULL),(114,4,'PayslipItems','43','CREATE','[]','2026-03-15 12:50:15',NULL),(115,4,'Payslips','8','CREATE','[]','2026-03-15 12:50:15',NULL),(116,4,'PayslipItems','44','CREATE','[]','2026-03-15 18:53:31',NULL),(117,4,'PayslipItems','45','CREATE','[]','2026-03-15 18:53:31',NULL),(118,4,'PayslipItems','46','CREATE','[]','2026-03-15 18:53:31',NULL),(119,4,'PayslipItems','47','CREATE','[]','2026-03-15 18:53:31',NULL),(120,4,'PayslipItems','48','CREATE','[]','2026-03-15 18:53:31',NULL),(121,4,'PayslipItems','49','CREATE','[]','2026-03-15 18:53:31',NULL),(122,4,'PayslipItems','50','CREATE','[]','2026-03-15 18:53:31',NULL),(123,4,'PayslipItems','51','CREATE','[]','2026-03-15 18:53:31',NULL),(124,4,'PayslipItems','52','CREATE','[]','2026-03-15 18:53:31',NULL),(125,4,'PayslipItems','53','CREATE','[]','2026-03-15 18:53:31',NULL),(126,4,'Payslips','9','CREATE','[]','2026-03-15 18:53:31',NULL),(127,4,'PayslipItems','54','CREATE','[]','2026-03-19 02:48:59',NULL),(128,4,'PayslipItems','55','CREATE','[]','2026-03-19 02:48:59',NULL),(129,4,'PayslipItems','56','CREATE','[]','2026-03-19 02:48:59',NULL),(130,4,'PayslipItems','57','CREATE','[]','2026-03-19 02:48:59',NULL),(131,4,'PayslipItems','58','CREATE','[]','2026-03-19 02:48:59',NULL),(132,4,'PayslipItems','59','CREATE','[]','2026-03-19 02:48:59',NULL),(133,4,'PayslipItems','60','CREATE','[]','2026-03-19 02:48:59',NULL),(134,4,'PayslipItems','61','CREATE','[]','2026-03-19 02:48:59',NULL),(135,4,'PayslipItems','62','CREATE','[]','2026-03-19 02:48:59',NULL),(136,4,'PayslipItems','63','CREATE','[]','2026-03-19 02:48:59',NULL),(137,4,'Payslips','10','CREATE','[]','2026-03-19 02:48:59',NULL),(138,4,'PayslipItems','64','CREATE','[]','2026-03-19 02:56:02',NULL),(139,4,'PayslipItems','65','CREATE','[]','2026-03-19 02:56:02',NULL),(140,4,'PayslipItems','66','CREATE','[]','2026-03-19 02:56:02',NULL),(141,4,'PayslipItems','67','CREATE','[]','2026-03-19 02:56:02',NULL),(142,4,'PayslipItems','68','CREATE','[]','2026-03-19 02:56:02',NULL),(143,4,'PayslipItems','69','CREATE','[]','2026-03-19 02:56:02',NULL),(144,4,'PayslipItems','70','CREATE','[]','2026-03-19 02:56:02',NULL),(145,4,'PayslipItems','71','CREATE','[]','2026-03-19 02:56:02',NULL),(146,4,'PayslipItems','72','CREATE','[]','2026-03-19 02:56:02',NULL),(147,4,'PayslipItems','73','CREATE','[]','2026-03-19 02:56:02',NULL),(148,4,'PayslipItems','74','CREATE','[]','2026-03-19 02:56:02',NULL),(149,4,'Payslips','11','CREATE','[]','2026-03-19 02:56:02',NULL),(150,4,'PayPeriods','4','CREATE','[]','2026-03-19 03:13:37',NULL),(151,4,'Modules','4','UPDATE','{\"is_active\":true}','2026-03-21 17:04:01',NULL),(152,4,'Modules','3','UPDATE','{\"is_active\":false}','2026-03-21 18:27:46',NULL),(153,4,'Modules','5','CREATE','[]','2026-03-21 18:32:04',NULL),(154,4,'Modules','6','CREATE','[]','2026-03-21 18:32:32',NULL),(155,4,'Modules','7','CREATE','[]','2026-03-21 18:33:08',NULL),(156,4,'Modules','7','UPDATE','{\"is_active\":true}','2026-03-21 18:33:44',NULL),(157,4,'Modules','8','CREATE','[]','2026-03-21 18:34:04',NULL),(158,4,'PayslipItems','75','CREATE','[]','2026-03-22 03:50:36',NULL),(159,4,'PayslipItems','76','CREATE','[]','2026-03-22 03:50:36',NULL),(160,4,'PayslipItems','77','CREATE','[]','2026-03-22 03:50:36',NULL),(161,4,'PayslipItems','78','CREATE','[]','2026-03-22 03:50:36',NULL),(162,4,'PayslipItems','79','CREATE','[]','2026-03-22 03:50:36',NULL),(163,4,'PayslipItems','80','CREATE','[]','2026-03-22 03:50:36',NULL),(164,4,'PayslipItems','81','CREATE','[]','2026-03-22 03:50:36',NULL),(165,4,'PayslipItems','82','CREATE','[]','2026-03-22 03:50:36',NULL),(166,4,'PayslipItems','83','CREATE','[]','2026-03-22 03:50:36',NULL),(167,4,'PayslipItems','84','CREATE','[]','2026-03-22 03:50:36',NULL),(168,4,'PayslipItems','85','CREATE','[]','2026-03-22 03:50:36',NULL),(169,4,'Payslips','12','CREATE','[]','2026-03-22 03:50:36',NULL),(170,4,'Modules','9','CREATE','[]','2026-03-22 03:56:02',NULL),(171,4,'Modules','10','CREATE','[]','2026-03-22 03:57:26',NULL),(172,4,'PayslipItems','86','CREATE','[]','2026-03-24 03:50:08',NULL),(173,4,'PayslipItems','87','CREATE','[]','2026-03-24 03:50:08',NULL),(174,4,'PayslipItems','88','CREATE','[]','2026-03-24 03:50:08',NULL),(175,4,'PayslipItems','89','CREATE','[]','2026-03-24 03:50:08',NULL),(176,4,'PayslipItems','90','CREATE','[]','2026-03-24 03:50:08',NULL),(177,4,'PayslipItems','91','CREATE','[]','2026-03-24 03:50:08',NULL),(178,4,'PayslipItems','92','CREATE','[]','2026-03-24 03:50:08',NULL),(179,4,'PayslipItems','93','CREATE','[]','2026-03-24 03:50:08',NULL),(180,4,'PayslipItems','94','CREATE','[]','2026-03-24 03:50:08',NULL),(181,4,'PayslipItems','95','CREATE','[]','2026-03-24 03:50:08',NULL),(182,4,'PayslipItems','96','CREATE','[]','2026-03-24 03:50:08',NULL),(183,4,'PayslipItems','97','CREATE','[]','2026-03-24 03:50:08',NULL),(184,4,'Payslips','13','CREATE','[]','2026-03-24 03:50:08',NULL),(185,4,'PayslipItems','98','CREATE','[]','2026-03-24 04:58:18',NULL),(186,4,'PayslipItems','99','CREATE','[]','2026-03-24 04:58:18',NULL),(187,4,'PayslipItems','100','CREATE','[]','2026-03-24 04:58:18',NULL),(188,4,'PayslipItems','101','CREATE','[]','2026-03-24 04:58:18',NULL),(189,4,'PayslipItems','102','CREATE','[]','2026-03-24 04:58:18',NULL),(190,4,'PayslipItems','103','CREATE','[]','2026-03-24 04:58:18',NULL),(191,4,'PayslipItems','104','CREATE','[]','2026-03-24 04:58:18',NULL),(192,4,'PayslipItems','105','CREATE','[]','2026-03-24 04:58:18',NULL),(193,4,'PayslipItems','106','CREATE','[]','2026-03-24 04:58:18',NULL),(194,4,'PayslipItems','107','CREATE','[]','2026-03-24 04:58:18',NULL),(195,4,'PayslipItems','108','CREATE','[]','2026-03-24 04:58:18',NULL),(196,4,'PayslipItems','109','CREATE','[]','2026-03-24 04:58:18',NULL),(197,4,'PayslipItems','110','CREATE','[]','2026-03-24 04:58:18',NULL),(198,4,'PayslipItems','111','CREATE','[]','2026-03-24 04:58:18',NULL),(199,4,'PayslipItems','112','CREATE','[]','2026-03-24 04:58:18',NULL),(200,4,'PayslipItems','113','CREATE','[]','2026-03-24 04:58:18',NULL),(201,4,'Payslips','14','CREATE','[]','2026-03-24 04:58:18',NULL),(202,4,'PayPeriods','5','CREATE','[]','2026-03-24 17:31:16',NULL),(203,4,'PayPeriods','6','CREATE','[]','2026-03-24 17:31:17',NULL),(204,4,'PayslipItems','114','CREATE','[]','2026-03-24 17:32:23',NULL),(205,4,'PayslipItems','115','CREATE','[]','2026-03-24 17:32:23',NULL),(206,4,'PayslipItems','116','CREATE','[]','2026-03-24 17:32:23',NULL),(207,4,'PayslipItems','117','CREATE','[]','2026-03-24 17:32:23',NULL),(208,4,'PayslipItems','118','CREATE','[]','2026-03-24 17:32:23',NULL),(209,4,'PayslipItems','119','CREATE','[]','2026-03-24 17:32:23',NULL),(210,4,'PayslipItems','120','CREATE','[]','2026-03-24 17:32:23',NULL),(211,4,'PayslipItems','121','CREATE','[]','2026-03-24 17:32:23',NULL),(212,4,'PayslipItems','122','CREATE','[]','2026-03-24 17:32:23',NULL),(213,4,'PayslipItems','123','CREATE','[]','2026-03-24 17:32:23',NULL),(214,4,'PayslipItems','124','CREATE','[]','2026-03-24 17:32:23',NULL),(215,4,'PayslipItems','125','CREATE','[]','2026-03-24 17:32:23',NULL),(216,4,'PayslipItems','126','CREATE','[]','2026-03-24 17:32:23',NULL),(217,4,'PayslipItems','127','CREATE','[]','2026-03-24 17:32:23',NULL),(218,4,'PayslipItems','128','CREATE','[]','2026-03-24 17:32:23',NULL),(219,4,'PayslipItems','129','CREATE','[]','2026-03-24 17:32:23',NULL),(220,4,'Payslips','15','CREATE','[]','2026-03-24 17:32:23',NULL),(221,4,'Earnings','2','UPDATE','{\"account_id\":1}','2026-03-24 17:43:32',NULL),(222,4,'Earnings','3','UPDATE','{\"account_id\":1}','2026-03-24 17:43:53',NULL),(223,NULL,'Products','1','CREATE','[]','2026-03-24 18:40:36',NULL),(224,NULL,'Products','2','CREATE','[]','2026-03-24 18:40:36',NULL),(225,4,'InvoiceItems','15','CREATE','[]','2026-03-24 19:08:44',NULL),(226,4,'InvoiceItems','16','CREATE','[]','2026-03-24 19:08:44',NULL),(227,4,'Invoices','20','CREATE','[]','2026-03-24 19:08:44',NULL),(228,4,'InvoiceItems','17','CREATE','[]','2026-03-24 19:19:32',NULL),(229,4,'InvoiceItems','18','CREATE','[]','2026-03-24 19:19:32',NULL),(230,4,'Invoices','21','CREATE','[]','2026-03-24 19:19:32',NULL),(231,NULL,'Users','2','UPDATE','{\"company_id\":null}','2026-03-25 03:51:56',NULL),(232,4,'Earnings','5','UPDATE','{\"pensionable\":true,\"nssa_applicable\":true}','2026-03-25 17:52:15',NULL),(233,4,'PayslipItems','130','CREATE','[]','2026-03-25 18:21:55',NULL),(234,4,'PayslipItems','131','CREATE','[]','2026-03-25 18:21:55',NULL),(235,4,'PayslipItems','132','CREATE','[]','2026-03-25 18:21:55',NULL),(236,4,'PayslipItems','133','CREATE','[]','2026-03-25 18:21:55',NULL),(237,4,'PayslipItems','134','CREATE','[]','2026-03-25 18:21:55',NULL),(238,4,'PayslipItems','135','CREATE','[]','2026-03-25 18:21:55',NULL),(239,4,'PayslipItems','136','CREATE','[]','2026-03-25 18:21:55',NULL),(240,4,'PayslipItems','137','CREATE','[]','2026-03-25 18:21:55',NULL),(241,4,'PayslipItems','138','CREATE','[]','2026-03-25 18:21:55',NULL),(242,4,'PayslipItems','139','CREATE','[]','2026-03-25 18:21:55',NULL),(243,4,'PayslipItems','140','CREATE','[]','2026-03-25 18:21:55',NULL),(244,4,'PayslipItems','141','CREATE','[]','2026-03-25 18:21:55',NULL),(245,4,'PayslipItems','142','CREATE','[]','2026-03-25 18:21:55',NULL),(246,4,'PayslipItems','143','CREATE','[]','2026-03-25 18:21:55',NULL),(247,4,'PayslipItems','144','CREATE','[]','2026-03-25 18:21:55',NULL),(248,4,'PayslipItems','145','CREATE','[]','2026-03-25 18:21:55',NULL),(249,4,'Payslips','16','CREATE','[]','2026-03-25 18:21:55',NULL),(250,4,'PayslipItems','146','CREATE','[]','2026-03-25 18:32:35',NULL),(251,4,'PayslipItems','147','CREATE','[]','2026-03-25 18:32:35',NULL),(252,4,'PayslipItems','148','CREATE','[]','2026-03-25 18:32:35',NULL),(253,4,'PayslipItems','149','CREATE','[]','2026-03-25 18:32:35',NULL),(254,4,'PayslipItems','150','CREATE','[]','2026-03-25 18:32:35',NULL),(255,4,'PayslipItems','151','CREATE','[]','2026-03-25 18:32:35',NULL),(256,4,'PayslipItems','152','CREATE','[]','2026-03-25 18:32:35',NULL),(257,4,'PayslipItems','153','CREATE','[]','2026-03-25 18:32:35',NULL),(258,4,'PayslipItems','154','CREATE','[]','2026-03-25 18:32:35',NULL),(259,4,'PayslipItems','155','CREATE','[]','2026-03-25 18:32:35',NULL),(260,4,'PayslipItems','156','CREATE','[]','2026-03-25 18:32:35',NULL),(261,4,'PayslipItems','157','CREATE','[]','2026-03-25 18:32:35',NULL),(262,4,'PayslipItems','158','CREATE','[]','2026-03-25 18:32:35',NULL),(263,4,'PayslipItems','159','CREATE','[]','2026-03-25 18:32:35',NULL),(264,4,'PayslipItems','160','CREATE','[]','2026-03-25 18:32:35',NULL),(265,4,'PayslipItems','161','CREATE','[]','2026-03-25 18:32:35',NULL),(266,4,'Payslips','17','CREATE','[]','2026-03-25 18:32:35',NULL),(267,4,'Earnings','2','UPDATE','{\"zimra_mapping\":null}','2026-03-28 13:04:52',NULL),(268,4,'Earnings','3','UPDATE','{\"zimra_mapping\":null}','2026-03-28 13:05:12',NULL),(269,4,'Earnings','4','UPDATE','{\"nssa_applicable\":false,\"zimra_mapping\":null}','2026-03-28 13:05:39',NULL),(270,4,'Earnings','5','UPDATE','{\"zimra_mapping\":null}','2026-03-28 13:06:16',NULL),(271,4,'Modules','11','CREATE','[]','2026-03-28 13:23:02',NULL),(272,4,'Modules','12','CREATE','[]','2026-03-28 13:23:27',NULL),(273,4,'Modules','13','CREATE','[]','2026-03-28 13:23:55',NULL),(274,4,'Modules','14','CREATE','[]','2026-03-28 13:24:20',NULL),(275,4,'Modules','15','CREATE','[]','2026-03-28 13:24:57',NULL),(276,4,'Modules','16','CREATE','[]','2026-03-28 13:25:34',NULL),(277,4,'Modules','17','CREATE','[]','2026-03-28 13:25:50',NULL),(278,4,'Modules','18','CREATE','[]','2026-03-28 13:26:27',NULL),(279,4,'Modules','19','CREATE','[]','2026-03-28 13:26:52',NULL),(280,4,'Modules','20','CREATE','[]','2026-03-28 13:27:42',NULL),(281,4,'Modules','1','UPDATE','{\"is_active\":true}','2026-03-28 13:32:06',NULL),(282,4,'Modules','11','UPDATE','{\"is_active\":true}','2026-03-28 13:33:59',NULL),(283,4,'Employees','3','CREATE','[]','2026-03-28 13:39:38',NULL),(284,4,'PayPeriods','7','CREATE','[]','2026-03-28 13:41:51',NULL),(285,4,'PayPeriods','8','CREATE','[]','2026-03-28 13:42:45',NULL),(286,4,'Modules','8','DELETE','{\"id\":8,\"name\":\"Settings\",\"model\":\"Users\",\"is_active\":true,\"created\":\"2026-03-21T18:34:04+00:00\",\"modified\":\"2026-03-21T18:34:04+00:00\"}','2026-03-28 13:44:57',NULL),(287,4,'Accounts','7','CREATE','[]','2026-03-28 15:53:24',NULL),(288,4,'Earnings','6','CREATE','[]','2026-03-28 15:54:27',NULL),(289,4,'PayslipItems','114','DELETE','{\"id\":114,\"payslip_id\":15,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"1537.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:02:27',NULL),(290,4,'PayslipItems','115','DELETE','{\"id\":115,\"payslip_id\":15,\"item_type\":\"Earning\",\"name\":\"Transport Allowance\",\"amount\":\"84.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:02:27',NULL),(291,4,'PayslipItems','116','DELETE','{\"id\":116,\"payslip_id\":15,\"item_type\":\"Earning\",\"name\":\"Salary\",\"amount\":\"9999.999999\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:02:27',NULL),(292,4,'PayslipItems','117','DELETE','{\"id\":117,\"payslip_id\":15,\"item_type\":\"Deduction\",\"name\":\"Medical Aid\",\"amount\":\"70.000000\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:02:27',NULL),(293,4,'PayslipItems','118','DELETE','{\"id\":118,\"payslip_id\":15,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"31.480000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:27',NULL),(294,4,'PayslipItems','119','DELETE','{\"id\":119,\"payslip_id\":15,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"153.610000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:27',NULL),(295,4,'PayslipItems','120','DELETE','{\"id\":120,\"payslip_id\":15,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"345.830000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:27',NULL),(296,4,'PayslipItems','121','DELETE','{\"id\":121,\"payslip_id\":15,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"10.370000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:27',NULL),(297,4,'PayslipItems','122','DELETE','{\"id\":122,\"payslip_id\":15,\"item_type\":\"Company Contribution\",\"name\":\"ZIMDEF\",\"amount\":\"16.210000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:27',NULL),(298,4,'PayslipItems','123','DELETE','{\"id\":123,\"payslip_id\":15,\"item_type\":\"Company Contribution\",\"name\":\"SDF\",\"amount\":\"8.110000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:27',NULL),(299,4,'PayslipItems','124','DELETE','{\"id\":124,\"payslip_id\":15,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"533.870000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:27',NULL),(300,4,'PayslipItems','125','DELETE','{\"id\":125,\"payslip_id\":15,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"2604.940000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:27',NULL),(301,4,'PayslipItems','126','DELETE','{\"id\":126,\"payslip_id\":15,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"5864.740000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:27',NULL),(302,4,'PayslipItems','127','DELETE','{\"id\":127,\"payslip_id\":15,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"175.920000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:27',NULL),(303,4,'PayslipItems','128','DELETE','{\"id\":128,\"payslip_id\":15,\"item_type\":\"Company Contribution\",\"name\":\"ZIMDEF\",\"amount\":\"274.900000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:27',NULL),(304,4,'PayslipItems','129','DELETE','{\"id\":129,\"payslip_id\":15,\"item_type\":\"Company Contribution\",\"name\":\"SDF\",\"amount\":\"137.450000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:27',NULL),(305,4,'Payslips','15','DELETE','{\"id\":15,\"employee_id\":1,\"pay_period_id\":5,\"gross_pay\":\"1622.00\",\"deductions\":\"541.63\",\"net_pay\":\"1080.37\",\"exchange_rate\":\"27490.0000\",\"generated_date\":\"2026-03-24\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"1621.00\",\"usd_deductions\":\"541.29\",\"usd_net\":\"1079.71\",\"zwg_gross\":\"27490.00\",\"zwg_deductions\":\"9249.47\",\"zwg_net\":\"18240.53\",\"company_id\":1}','2026-03-28 16:02:27',NULL),(306,4,'PayslipItems','130','DELETE','{\"id\":130,\"payslip_id\":16,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"1537.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":null}','2026-03-28 16:02:36',NULL),(307,4,'PayslipItems','131','DELETE','{\"id\":131,\"payslip_id\":16,\"item_type\":\"Earning\",\"name\":\"Transport Allowance\",\"amount\":\"84.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":null}','2026-03-28 16:02:36',NULL),(308,4,'PayslipItems','132','DELETE','{\"id\":132,\"payslip_id\":16,\"item_type\":\"Earning\",\"name\":\"Salary\",\"amount\":\"9999.999999\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":null}','2026-03-28 16:02:36',NULL),(309,4,'PayslipItems','133','DELETE','{\"id\":133,\"payslip_id\":16,\"item_type\":\"Earning\",\"name\":\"COLA\",\"amount\":\"134.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":null}','2026-03-28 16:02:36',NULL),(310,4,'PayslipItems','134','DELETE','{\"id\":134,\"payslip_id\":16,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"19.890000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:36',NULL),(311,4,'PayslipItems','135','DELETE','{\"id\":135,\"payslip_id\":16,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"97.030000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:36',NULL),(312,4,'PayslipItems','136','DELETE','{\"id\":136,\"payslip_id\":16,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"424.410000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:36',NULL),(313,4,'PayslipItems','137','DELETE','{\"id\":137,\"payslip_id\":16,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"12.730000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:36',NULL),(314,4,'PayslipItems','138','DELETE','{\"id\":138,\"payslip_id\":16,\"item_type\":\"Company Contribution\",\"name\":\"ZIMDEF\",\"amount\":\"17.550000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:36',NULL),(315,4,'PayslipItems','139','DELETE','{\"id\":139,\"payslip_id\":16,\"item_type\":\"Company Contribution\",\"name\":\"SDF\",\"amount\":\"8.780000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:36',NULL),(316,4,'PayslipItems','140','DELETE','{\"id\":140,\"payslip_id\":16,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"311.480000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:36',NULL),(317,4,'PayslipItems','141','DELETE','{\"id\":141,\"payslip_id\":16,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"1519.830000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:36',NULL),(318,4,'PayslipItems','142','DELETE','{\"id\":142,\"payslip_id\":16,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"6647.930000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:36',NULL),(319,4,'PayslipItems','143','DELETE','{\"id\":143,\"payslip_id\":16,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"199.450000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:36',NULL),(320,4,'PayslipItems','144','DELETE','{\"id\":144,\"payslip_id\":16,\"item_type\":\"Company Contribution\",\"name\":\"ZIMDEF\",\"amount\":\"274.900000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:36',NULL),(321,4,'PayslipItems','145','DELETE','{\"id\":145,\"payslip_id\":16,\"item_type\":\"Company Contribution\",\"name\":\"SDF\",\"amount\":\"137.450000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:36',NULL),(322,4,'Payslips','16','DELETE','{\"id\":16,\"employee_id\":1,\"pay_period_id\":6,\"gross_pay\":\"2780.06\",\"deductions\":\"877.68\",\"net_pay\":\"1902.39\",\"exchange_rate\":\"26.8179\",\"generated_date\":\"2026-03-25\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"1755.00\",\"usd_deductions\":\"554.06\",\"usd_net\":\"1200.94\",\"zwg_gross\":\"27490.01\",\"zwg_deductions\":\"8678.69\",\"zwg_net\":\"18811.32\",\"company_id\":null}','2026-03-28 16:02:37',NULL),(323,4,'PayslipItems','146','DELETE','{\"id\":146,\"payslip_id\":17,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"1537.000000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(324,4,'PayslipItems','147','DELETE','{\"id\":147,\"payslip_id\":17,\"item_type\":\"Earning\",\"name\":\"Transport Allowance\",\"amount\":\"84.000000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(325,4,'PayslipItems','148','DELETE','{\"id\":148,\"payslip_id\":17,\"item_type\":\"Earning\",\"name\":\"COLA\",\"amount\":\"134.000000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(326,4,'PayslipItems','149','DELETE','{\"id\":149,\"payslip_id\":17,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"9999.999999\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(327,4,'PayslipItems','150','DELETE','{\"id\":150,\"payslip_id\":17,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"19.890000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(328,4,'PayslipItems','151','DELETE','{\"id\":151,\"payslip_id\":17,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"161.740000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(329,4,'PayslipItems','152','DELETE','{\"id\":152,\"payslip_id\":17,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"403.060000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(330,4,'PayslipItems','153','DELETE','{\"id\":153,\"payslip_id\":17,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"12.090000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(331,4,'PayslipItems','154','DELETE','{\"id\":154,\"payslip_id\":17,\"item_type\":\"Company Contribution\",\"name\":\"ZIMDEF\",\"amount\":\"17.550000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(332,4,'PayslipItems','155','DELETE','{\"id\":155,\"payslip_id\":17,\"item_type\":\"Company Contribution\",\"name\":\"SDF\",\"amount\":\"8.780000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(333,4,'PayslipItems','156','DELETE','{\"id\":156,\"payslip_id\":17,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"311.480000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(334,4,'PayslipItems','157','DELETE','{\"id\":157,\"payslip_id\":17,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"2533.440000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(335,4,'PayslipItems','158','DELETE','{\"id\":158,\"payslip_id\":17,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"6313.440000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(336,4,'PayslipItems','159','DELETE','{\"id\":159,\"payslip_id\":17,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"189.360000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(337,4,'PayslipItems','160','DELETE','{\"id\":160,\"payslip_id\":17,\"item_type\":\"Company Contribution\",\"name\":\"ZIMDEF\",\"amount\":\"274.900000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(338,4,'PayslipItems','161','DELETE','{\"id\":161,\"payslip_id\":17,\"item_type\":\"Company Contribution\",\"name\":\"SDF\",\"amount\":\"137.450000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}','2026-03-28 16:02:43',NULL),(339,4,'Payslips','17','DELETE','{\"id\":17,\"employee_id\":2,\"pay_period_id\":6,\"gross_pay\":\"2780.06\",\"deductions\":\"945.34\",\"net_pay\":\"1834.72\",\"exchange_rate\":\"26.8179\",\"generated_date\":\"2026-03-25\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"1755.00\",\"usd_deductions\":\"596.78\",\"usd_net\":\"1158.22\",\"zwg_gross\":\"27490.00\",\"zwg_deductions\":\"9347.72\",\"zwg_net\":\"18142.28\",\"company_id\":null}','2026-03-28 16:02:43',NULL),(340,4,'PayslipItems','98','DELETE','{\"id\":98,\"payslip_id\":14,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"1537.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:02:59',NULL),(341,4,'PayslipItems','99','DELETE','{\"id\":99,\"payslip_id\":14,\"item_type\":\"Earning\",\"name\":\"Transport Allowance\",\"amount\":\"84.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:02:59',NULL),(342,4,'PayslipItems','100','DELETE','{\"id\":100,\"payslip_id\":14,\"item_type\":\"Earning\",\"name\":\"Salary\",\"amount\":\"1500.000000\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:02:59',NULL),(343,4,'PayslipItems','101','DELETE','{\"id\":101,\"payslip_id\":14,\"item_type\":\"Deduction\",\"name\":\"Medical Aid\",\"amount\":\"70.000000\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:02:59',NULL),(344,4,'PayslipItems','102','DELETE','{\"id\":102,\"payslip_id\":14,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"16.360000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:59',NULL),(345,4,'PayslipItems','103','DELETE','{\"id\":103,\"payslip_id\":14,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"79.830000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:59',NULL),(346,4,'PayslipItems','104','DELETE','{\"id\":104,\"payslip_id\":14,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"389.440000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:59',NULL),(347,4,'PayslipItems','105','DELETE','{\"id\":105,\"payslip_id\":14,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"11.680000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:59',NULL),(348,4,'PayslipItems','106','DELETE','{\"id\":106,\"payslip_id\":14,\"item_type\":\"Company Contribution\",\"name\":\"ZIMDEF\",\"amount\":\"16.210000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:59',NULL),(349,4,'PayslipItems','107','DELETE','{\"id\":107,\"payslip_id\":14,\"item_type\":\"Company Contribution\",\"name\":\"SDF\",\"amount\":\"8.110000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:59',NULL),(350,4,'PayslipItems','108','DELETE','{\"id\":108,\"payslip_id\":14,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"15.140000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:59',NULL),(351,4,'PayslipItems','109','DELETE','{\"id\":109,\"payslip_id\":14,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"73.870000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:59',NULL),(352,4,'PayslipItems','110','DELETE','{\"id\":110,\"payslip_id\":14,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"360.370000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:59',NULL),(353,4,'PayslipItems','111','DELETE','{\"id\":111,\"payslip_id\":14,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"10.810000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:59',NULL),(354,4,'PayslipItems','112','DELETE','{\"id\":112,\"payslip_id\":14,\"item_type\":\"Company Contribution\",\"name\":\"ZIMDEF\",\"amount\":\"15.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:59',NULL),(355,4,'PayslipItems','113','DELETE','{\"id\":113,\"payslip_id\":14,\"item_type\":\"Company Contribution\",\"name\":\"SDF\",\"amount\":\"7.500000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:02:59',NULL),(356,4,'Payslips','14','DELETE','{\"id\":14,\"employee_id\":1,\"pay_period_id\":4,\"gross_pay\":\"3121.00\",\"deductions\":\"1027.50\",\"net_pay\":\"2093.50\",\"exchange_rate\":\"1.0000\",\"generated_date\":\"2026-03-24\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"1621.00\",\"usd_deductions\":\"497.31\",\"usd_net\":\"1123.69\",\"zwg_gross\":\"1500.00\",\"zwg_deductions\":\"530.19\",\"zwg_net\":\"969.81\",\"company_id\":1}','2026-03-28 16:02:59',NULL),(357,4,'PayslipItems','86','DELETE','{\"id\":86,\"payslip_id\":13,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"1537.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:03:10',NULL),(358,4,'PayslipItems','87','DELETE','{\"id\":87,\"payslip_id\":13,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"9999.999999\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:10',NULL),(359,4,'PayslipItems','88','DELETE','{\"id\":88,\"payslip_id\":13,\"item_type\":\"Earning\",\"name\":\"Transport Allowance\",\"amount\":\"144.000000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:10',NULL),(360,4,'PayslipItems','89','DELETE','{\"id\":89,\"payslip_id\":13,\"item_type\":\"Earning\",\"name\":\"COLA\",\"amount\":\"84.000000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:10',NULL),(361,4,'PayslipItems','90','DELETE','{\"id\":90,\"payslip_id\":13,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"1.900000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:10',NULL),(362,4,'PayslipItems','91','DELETE','{\"id\":91,\"payslip_id\":13,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"175.630000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:10',NULL),(363,4,'PayslipItems','92','DELETE','{\"id\":92,\"payslip_id\":13,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"598.960000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:10',NULL),(364,4,'PayslipItems','93','DELETE','{\"id\":93,\"payslip_id\":13,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"17.970000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:10',NULL),(365,4,'PayslipItems','94','DELETE','{\"id\":94,\"payslip_id\":13,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"29.600000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:10',NULL),(366,4,'PayslipItems','95','DELETE','{\"id\":95,\"payslip_id\":13,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"2735.470000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:10',NULL),(367,4,'PayslipItems','96','DELETE','{\"id\":96,\"payslip_id\":13,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"9328.870000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:10',NULL),(368,4,'PayslipItems','97','DELETE','{\"id\":97,\"payslip_id\":13,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"279.870000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:10',NULL),(369,4,'Payslips','13','DELETE','{\"id\":13,\"employee_id\":2,\"pay_period_id\":4,\"gross_pay\":\"29255.00\",\"deductions\":\"13168.27\",\"net_pay\":\"16086.73\",\"exchange_rate\":\"1.0000\",\"generated_date\":\"2026-03-24\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"1765.00\",\"usd_deductions\":\"794.46\",\"usd_net\":\"970.54\",\"zwg_gross\":\"27490.00\",\"zwg_deductions\":\"12373.81\",\"zwg_net\":\"15116.19\",\"company_id\":1}','2026-03-28 16:03:10',NULL),(370,4,'PayslipItems','64','DELETE','{\"id\":64,\"payslip_id\":11,\"item_type\":\"Earning\",\"name\":\"Transport Allowance\",\"amount\":\"84.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:03:22',NULL),(371,4,'PayslipItems','65','DELETE','{\"id\":65,\"payslip_id\":11,\"item_type\":\"Earning\",\"name\":\"Salary\",\"amount\":\"1500.000000\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:03:22',NULL),(372,4,'PayslipItems','66','DELETE','{\"id\":66,\"payslip_id\":11,\"item_type\":\"Deduction\",\"name\":\"Medical Aid\",\"amount\":\"70.000000\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:03:22',NULL),(373,4,'PayslipItems','67','DELETE','{\"id\":67,\"payslip_id\":11,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"1.670000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:22',NULL),(374,4,'PayslipItems','68','DELETE','{\"id\":68,\"payslip_id\":11,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"7.950000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:22',NULL),(375,4,'PayslipItems','69','DELETE','{\"id\":69,\"payslip_id\":11,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"15.950000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:22',NULL),(376,4,'PayslipItems','70','DELETE','{\"id\":70,\"payslip_id\":11,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"0.480000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:22',NULL),(377,4,'PayslipItems','71','DELETE','{\"id\":71,\"payslip_id\":11,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"29.830000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:22',NULL),(378,4,'PayslipItems','72','DELETE','{\"id\":72,\"payslip_id\":11,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"142.050000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:22',NULL),(379,4,'PayslipItems','73','DELETE','{\"id\":73,\"payslip_id\":11,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"284.800000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:22',NULL),(380,4,'PayslipItems','74','DELETE','{\"id\":74,\"payslip_id\":11,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"8.540000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:22',NULL),(381,4,'Payslips','11','DELETE','{\"id\":11,\"employee_id\":1,\"pay_period_id\":3,\"gross_pay\":\"1584.00\",\"deductions\":\"561.27\",\"net_pay\":\"1022.73\",\"exchange_rate\":\"1.0000\",\"generated_date\":\"2026-03-19\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"84.00\",\"usd_deductions\":\"26.05\",\"usd_net\":\"57.95\",\"zwg_gross\":\"1500.00\",\"zwg_deductions\":\"535.22\",\"zwg_net\":\"964.78\",\"company_id\":1}','2026-03-28 16:03:22',NULL),(382,4,'PayslipItems','54','DELETE','{\"id\":54,\"payslip_id\":10,\"item_type\":\"Earning\",\"name\":\"Transport Allowance\",\"amount\":\"84.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:03:29',NULL),(383,4,'PayslipItems','55','DELETE','{\"id\":55,\"payslip_id\":10,\"item_type\":\"Earning\",\"name\":\"Salary\",\"amount\":\"1500.000000\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:03:29',NULL),(384,4,'PayslipItems','56','DELETE','{\"id\":56,\"payslip_id\":10,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"1.670000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:29',NULL),(385,4,'PayslipItems','57','DELETE','{\"id\":57,\"payslip_id\":10,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"7.950000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:29',NULL),(386,4,'PayslipItems','58','DELETE','{\"id\":58,\"payslip_id\":10,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"17.800000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:29',NULL),(387,4,'PayslipItems','59','DELETE','{\"id\":59,\"payslip_id\":10,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"0.530000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:29',NULL),(388,4,'PayslipItems','60','DELETE','{\"id\":60,\"payslip_id\":10,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"29.830000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:29',NULL),(389,4,'PayslipItems','61','DELETE','{\"id\":61,\"payslip_id\":10,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"142.050000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:29',NULL),(390,4,'PayslipItems','62','DELETE','{\"id\":62,\"payslip_id\":10,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"317.950000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:29',NULL),(391,4,'PayslipItems','63','DELETE','{\"id\":63,\"payslip_id\":10,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"9.540000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:29',NULL),(392,4,'Payslips','10','DELETE','{\"id\":10,\"employee_id\":1,\"pay_period_id\":3,\"gross_pay\":\"1584.00\",\"deductions\":\"527.32\",\"net_pay\":\"1056.68\",\"exchange_rate\":\"1.0000\",\"generated_date\":\"2026-03-19\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"84.00\",\"usd_deductions\":\"27.95\",\"usd_net\":\"56.05\",\"zwg_gross\":\"1500.00\",\"zwg_deductions\":\"499.37\",\"zwg_net\":\"1000.63\",\"company_id\":1}','2026-03-28 16:03:29',NULL),(393,4,'PayslipItems','11','DELETE','{\"id\":11,\"payslip_id\":2,\"item_type\":\"Earning\",\"name\":\"basic_salary\",\"amount\":\"600.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:38',NULL),(394,4,'PayslipItems','12','DELETE','{\"id\":12,\"payslip_id\":2,\"item_type\":\"Earning\",\"name\":\"allowances\",\"amount\":\"40.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:38',NULL),(395,4,'PayslipItems','13','DELETE','{\"id\":13,\"payslip_id\":2,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"28.800000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:38',NULL),(396,4,'PayslipItems','14','DELETE','{\"id\":14,\"payslip_id\":2,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"64.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:38',NULL),(397,4,'PayslipItems','15','DELETE','{\"id\":15,\"payslip_id\":2,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"101.800000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:38',NULL),(398,4,'PayslipItems','16','DELETE','{\"id\":16,\"payslip_id\":2,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"3.050000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:03:38',NULL),(399,4,'Payslips','2','DELETE','{\"id\":2,\"employee_id\":1,\"pay_period_id\":2,\"gross_pay\":\"640.00\",\"deductions\":\"197.65\",\"net_pay\":\"442.35\",\"exchange_rate\":\"1.0000\",\"generated_date\":\"2026-03-11\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"0.00\",\"usd_deductions\":\"0.00\",\"usd_net\":\"0.00\",\"zwg_gross\":\"0.00\",\"zwg_deductions\":\"0.00\",\"zwg_net\":\"0.00\",\"company_id\":1}','2026-03-28 16:03:38',NULL),(400,4,'PayslipItems','75','DELETE','{\"id\":75,\"payslip_id\":12,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"1537.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:04:00',NULL),(401,4,'PayslipItems','76','DELETE','{\"id\":76,\"payslip_id\":12,\"item_type\":\"Earning\",\"name\":\"basic\",\"amount\":\"9999.999999\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:04:00',NULL),(402,4,'PayslipItems','77','DELETE','{\"id\":77,\"payslip_id\":12,\"item_type\":\"Earning\",\"name\":\"Medical Aid\",\"amount\":\"80.000000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:00',NULL),(403,4,'PayslipItems','78','DELETE','{\"id\":78,\"payslip_id\":12,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"19.280000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:00',NULL),(404,4,'PayslipItems','79','DELETE','{\"id\":79,\"payslip_id\":12,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"161.700000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:00',NULL),(405,4,'PayslipItems','80','DELETE','{\"id\":80,\"payslip_id\":12,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"361.270000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:00',NULL),(406,4,'PayslipItems','81','DELETE','{\"id\":81,\"payslip_id\":12,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"10.840000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:00',NULL),(407,4,'PayslipItems','82','DELETE','{\"id\":82,\"payslip_id\":12,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"327.750000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:00',NULL),(408,4,'PayslipItems','83','DELETE','{\"id\":83,\"payslip_id\":12,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"2749.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:00',NULL),(409,4,'PayslipItems','84','DELETE','{\"id\":84,\"payslip_id\":12,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"6141.900000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:00',NULL),(410,4,'PayslipItems','85','DELETE','{\"id\":85,\"payslip_id\":12,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"184.270000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:00',NULL),(411,4,'Payslips','12','DELETE','{\"id\":12,\"employee_id\":2,\"pay_period_id\":1,\"gross_pay\":\"2642.06\",\"deductions\":\"903.71\",\"net_pay\":\"1738.35\",\"exchange_rate\":\"26.8179\",\"generated_date\":\"2026-03-22\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"1617.00\",\"usd_deductions\":\"553.09\",\"usd_net\":\"1063.91\",\"zwg_gross\":\"27490.00\",\"zwg_deductions\":\"9402.92\",\"zwg_net\":\"18087.08\",\"company_id\":1}','2026-03-28 16:04:00',NULL),(412,4,'PayslipItems','44','DELETE','{\"id\":44,\"payslip_id\":9,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"200.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:04:08',NULL),(413,4,'PayslipItems','45','DELETE','{\"id\":45,\"payslip_id\":9,\"item_type\":\"Earning\",\"name\":\"Transport Allowance\",\"amount\":\"9999.999999\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:08',NULL),(414,4,'PayslipItems','46','DELETE','{\"id\":46,\"payslip_id\":9,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"0.060000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:08',NULL),(415,4,'PayslipItems','47','DELETE','{\"id\":47,\"payslip_id\":9,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"0.130000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:08',NULL),(416,4,'PayslipItems','48','DELETE','{\"id\":48,\"payslip_id\":9,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"75.710000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:08',NULL),(417,4,'PayslipItems','49','DELETE','{\"id\":49,\"payslip_id\":9,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"2.270000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:08',NULL),(418,4,'PayslipItems','50','DELETE','{\"id\":50,\"payslip_id\":9,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"8.940000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:08',NULL),(419,4,'PayslipItems','51','DELETE','{\"id\":51,\"payslip_id\":9,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"19.870000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:08',NULL),(420,4,'PayslipItems','52','DELETE','{\"id\":52,\"payslip_id\":9,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"9999.999999\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:08',NULL),(421,4,'PayslipItems','53','DELETE','{\"id\":53,\"payslip_id\":9,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"340.710000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:08',NULL),(422,4,'Payslips','9','DELETE','{\"id\":9,\"employee_id\":2,\"pay_period_id\":1,\"gross_pay\":\"30200.00\",\"deductions\":\"11804.67\",\"net_pay\":\"18395.33\",\"exchange_rate\":\"1.0000\",\"generated_date\":\"2026-03-15\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"200.00\",\"usd_deductions\":\"78.17\",\"usd_net\":\"121.83\",\"zwg_gross\":\"30000.00\",\"zwg_deductions\":\"11726.50\",\"zwg_net\":\"18273.50\",\"company_id\":1}','2026-03-28 16:04:08',NULL),(423,4,'PayslipItems','38','DELETE','{\"id\":38,\"payslip_id\":8,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"9999.999999\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:04:15',NULL),(424,4,'PayslipItems','39','DELETE','{\"id\":39,\"payslip_id\":8,\"item_type\":\"Deduction\",\"name\":\"pension\",\"amount\":\"2700.000000\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:04:15',NULL),(425,4,'PayslipItems','40','DELETE','{\"id\":40,\"payslip_id\":8,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"844.760000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:15',NULL),(426,4,'PayslipItems','41','DELETE','{\"id\":41,\"payslip_id\":8,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"2700.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:15',NULL),(427,4,'PayslipItems','42','DELETE','{\"id\":42,\"payslip_id\":8,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"4925.180000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:15',NULL),(428,4,'PayslipItems','43','DELETE','{\"id\":43,\"payslip_id\":8,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"147.770000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:15',NULL),(429,4,'Payslips','8','DELETE','{\"id\":8,\"employee_id\":2,\"pay_period_id\":1,\"gross_pay\":\"1006.79\",\"deductions\":\"422.02\",\"net_pay\":\"584.77\",\"exchange_rate\":\"26.8179\",\"generated_date\":\"2026-03-15\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"0.00\",\"usd_deductions\":\"0.00\",\"usd_net\":\"0.00\",\"zwg_gross\":\"27000.00\",\"zwg_deductions\":\"11317.71\",\"zwg_net\":\"15682.29\",\"company_id\":1}','2026-03-28 16:04:15',NULL),(430,4,'PayslipItems','27','DELETE','{\"id\":27,\"payslip_id\":7,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"1530.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:04:22',NULL),(431,4,'PayslipItems','28','DELETE','{\"id\":28,\"payslip_id\":7,\"item_type\":\"Earning\",\"name\":\"Transport Allowance\",\"amount\":\"84.000000\",\"currency\":\"USD\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:04:22',NULL),(432,4,'PayslipItems','29','DELETE','{\"id\":29,\"payslip_id\":7,\"item_type\":\"Earning\",\"name\":\"basic Salary\",\"amount\":\"9999.999999\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:04:22',NULL),(433,4,'PayslipItems','30','DELETE','{\"id\":30,\"payslip_id\":7,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"1.780000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:22',NULL),(434,4,'PayslipItems','31','DELETE','{\"id\":31,\"payslip_id\":7,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"160.930000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:22',NULL),(435,4,'PayslipItems','32','DELETE','{\"id\":32,\"payslip_id\":7,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"547.170000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:22',NULL),(436,4,'PayslipItems','33','DELETE','{\"id\":33,\"payslip_id\":7,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"16.420000\",\"currency\":\"USD\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:22',NULL),(437,4,'PayslipItems','34','DELETE','{\"id\":34,\"payslip_id\":7,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"29.720000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:22',NULL),(438,4,'PayslipItems','35','DELETE','{\"id\":35,\"payslip_id\":7,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"2692.070000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:22',NULL),(439,4,'PayslipItems','36','DELETE','{\"id\":36,\"payslip_id\":7,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"9153.340000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:22',NULL),(440,4,'PayslipItems','37','DELETE','{\"id\":37,\"payslip_id\":7,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"274.600000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:22',NULL),(441,4,'Payslips','7','DELETE','{\"id\":7,\"employee_id\":2,\"pay_period_id\":1,\"gross_pay\":\"28614.00\",\"deductions\":\"12876.03\",\"net_pay\":\"15737.97\",\"exchange_rate\":\"1.0000\",\"generated_date\":\"2026-03-15\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"1614.00\",\"usd_deductions\":\"726.30\",\"usd_net\":\"887.70\",\"zwg_gross\":\"27000.00\",\"zwg_deductions\":\"12149.73\",\"zwg_net\":\"14850.27\",\"company_id\":1}','2026-03-28 16:04:22',NULL),(442,4,'PayslipItems','25','DELETE','{\"id\":25,\"payslip_id\":6,\"item_type\":\"Earning\",\"name\":\"Salary\",\"amount\":\"1500.000000\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":1}','2026-03-28 16:04:30',NULL),(443,4,'PayslipItems','26','DELETE','{\"id\":26,\"payslip_id\":6,\"item_type\":\"Deduction\",\"name\":\"Loan Repayment\",\"amount\":\"200.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:30',NULL),(444,4,'Payslips','6','DELETE','{\"id\":6,\"employee_id\":1,\"pay_period_id\":1,\"gross_pay\":\"1500.00\",\"deductions\":\"200.00\",\"net_pay\":\"1300.00\",\"exchange_rate\":\"1.0000\",\"generated_date\":\"2026-03-15\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"0.00\",\"usd_deductions\":\"0.00\",\"usd_net\":\"0.00\",\"zwg_gross\":\"0.00\",\"zwg_deductions\":\"0.00\",\"zwg_net\":\"0.00\",\"company_id\":1}','2026-03-28 16:04:30',NULL),(445,4,'PayslipItems','23','DELETE','{\"id\":23,\"payslip_id\":5,\"item_type\":\"Earning\",\"name\":\"Salary\",\"amount\":\"1500.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:37',NULL),(446,4,'PayslipItems','24','DELETE','{\"id\":24,\"payslip_id\":5,\"item_type\":\"Deduction\",\"name\":\"Loan Repayment\",\"amount\":\"200.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:37',NULL),(447,4,'Payslips','5','DELETE','{\"id\":5,\"employee_id\":1,\"pay_period_id\":1,\"gross_pay\":\"1500.00\",\"deductions\":\"200.00\",\"net_pay\":\"1300.00\",\"exchange_rate\":\"1.0000\",\"generated_date\":\"2026-03-15\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"0.00\",\"usd_deductions\":\"0.00\",\"usd_net\":\"0.00\",\"zwg_gross\":\"0.00\",\"zwg_deductions\":\"0.00\",\"zwg_net\":\"0.00\",\"company_id\":1}','2026-03-28 16:04:37',NULL),(448,4,'PayslipItems','17','DELETE','{\"id\":17,\"payslip_id\":4,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"900.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:44',NULL),(449,4,'PayslipItems','18','DELETE','{\"id\":18,\"payslip_id\":4,\"item_type\":\"Deduction\",\"name\":\"Advance Repayment\",\"amount\":\"70.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:44',NULL),(450,4,'PayslipItems','19','DELETE','{\"id\":19,\"payslip_id\":4,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"31.500000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:44',NULL),(451,4,'PayslipItems','20','DELETE','{\"id\":20,\"payslip_id\":4,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"90.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:44',NULL),(452,4,'PayslipItems','21','DELETE','{\"id\":21,\"payslip_id\":4,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"159.630000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:44',NULL),(453,4,'PayslipItems','22','DELETE','{\"id\":22,\"payslip_id\":4,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"4.790000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:04:44',NULL),(454,4,'Payslips','4','DELETE','{\"id\":4,\"employee_id\":2,\"pay_period_id\":1,\"gross_pay\":\"900.00\",\"deductions\":\"355.92\",\"net_pay\":\"544.08\",\"exchange_rate\":\"1.0000\",\"generated_date\":\"2026-03-14\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"0.00\",\"usd_deductions\":\"0.00\",\"usd_net\":\"0.00\",\"zwg_gross\":\"0.00\",\"zwg_deductions\":\"0.00\",\"zwg_net\":\"0.00\",\"company_id\":1}','2026-03-28 16:04:44',NULL),(455,4,'PayslipItems','1','DELETE','{\"id\":1,\"payslip_id\":1,\"item_type\":\"Earning\",\"name\":\"basic_salary\",\"amount\":\"700.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:05:00',NULL),(456,4,'PayslipItems','2','DELETE','{\"id\":2,\"payslip_id\":1,\"item_type\":\"Earning\",\"name\":\"transport allowance\",\"amount\":\"84.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:05:00',NULL),(457,4,'PayslipItems','3','DELETE','{\"id\":3,\"payslip_id\":1,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"0.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:05:00',NULL),(458,4,'PayslipItems','4','DELETE','{\"id\":4,\"payslip_id\":1,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"0.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:05:00',NULL),(459,4,'PayslipItems','5','DELETE','{\"id\":5,\"payslip_id\":1,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"0.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:05:00',NULL),(460,4,'PayslipItems','6','DELETE','{\"id\":6,\"payslip_id\":1,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"0.000000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:05:00',NULL),(461,4,'PayslipItems','7','DELETE','{\"id\":7,\"payslip_id\":1,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"31.500000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:05:00',NULL),(462,4,'PayslipItems','8','DELETE','{\"id\":8,\"payslip_id\":1,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"78.400000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:05:00',NULL),(463,4,'PayslipItems','9','DELETE','{\"id\":9,\"payslip_id\":1,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"133.530000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:05:00',NULL),(464,4,'PayslipItems','10','DELETE','{\"id\":10,\"payslip_id\":1,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"4.010000\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":1}','2026-03-28 16:05:00',NULL),(465,4,'Payslips','1','DELETE','{\"id\":1,\"employee_id\":1,\"pay_period_id\":1,\"gross_pay\":\"784.00\",\"deductions\":\"247.44\",\"net_pay\":\"536.56\",\"exchange_rate\":\"1.0000\",\"generated_date\":\"2026-03-10\",\"basic_salary\":\"0.000000\",\"allowances\":\"0.000000\",\"bonuses\":\"0.000000\",\"overtime\":\"0.000000\",\"benefits\":\"0.000000\",\"pension\":\"0.000000\",\"nssa\":\"0.000000\",\"medical_aid\":\"0.000000\",\"medical_expenses\":\"0.000000\",\"taxable_income\":\"0.000000\",\"paye\":\"0.000000\",\"tax_credits\":\"0.000000\",\"aids_levy\":\"0.000000\",\"total_tax\":\"0.000000\",\"usd_gross\":\"0.00\",\"usd_deductions\":\"0.00\",\"usd_net\":\"0.00\",\"zwg_gross\":\"0.00\",\"zwg_deductions\":\"0.00\",\"zwg_net\":\"0.00\",\"company_id\":1}','2026-03-28 16:05:00',NULL),(466,4,'PayslipItems','162','CREATE','[]','2026-03-28 16:06:26',NULL),(467,4,'PayslipItems','163','CREATE','[]','2026-03-28 16:06:26',NULL),(468,4,'PayslipItems','164','CREATE','[]','2026-03-28 16:06:26',NULL),(469,4,'PayslipItems','165','CREATE','[]','2026-03-28 16:06:26',NULL),(470,4,'PayslipItems','166','CREATE','[]','2026-03-28 16:06:26',NULL),(471,4,'PayslipItems','167','CREATE','[]','2026-03-28 16:06:26',NULL),(472,4,'PayslipItems','168','CREATE','[]','2026-03-28 16:06:26',NULL),(473,4,'Payslips','18','CREATE','[]','2026-03-28 16:06:26',NULL),(474,4,'PayslipItems','169','CREATE','[]','2026-03-28 16:07:13',NULL),(475,4,'PayslipItems','170','CREATE','[]','2026-03-28 16:07:13',NULL),(476,4,'PayslipItems','171','CREATE','[]','2026-03-28 16:07:13',NULL),(477,4,'PayslipItems','172','CREATE','[]','2026-03-28 16:07:13',NULL),(478,4,'PayslipItems','173','CREATE','[]','2026-03-28 16:07:13',NULL),(479,4,'Payslips','19','CREATE','[]','2026-03-28 16:07:13',NULL),(480,4,'PayslipItems','174','CREATE','[]','2026-03-28 16:08:13',NULL),(481,4,'PayslipItems','175','CREATE','[]','2026-03-28 16:08:13',NULL),(482,4,'PayslipItems','176','CREATE','[]','2026-03-28 16:08:13',NULL),(483,4,'PayslipItems','177','CREATE','[]','2026-03-28 16:08:13',NULL),(484,4,'PayslipItems','178','CREATE','[]','2026-03-28 16:08:13',NULL),(485,4,'Payslips','20','CREATE','[]','2026-03-28 16:08:13',NULL),(486,4,'PayslipItems','163','UPDATE','{\"amount\":\"31.500000\"}','2026-03-28 16:10:00',NULL),(487,4,'PayslipItems','164','UPDATE','{\"amount\":\"200.000000\"}','2026-03-28 16:10:00',NULL),(488,4,'PayslipItems','165','UPDATE','{\"amount\":\"445.550000\"}','2026-03-28 16:10:00',NULL),(489,4,'PayslipItems','166','UPDATE','{\"amount\":\"13.370000\"}','2026-03-28 16:10:00',NULL),(490,4,'PayslipItems','167','UPDATE','{\"amount\":\"20.000000\"}','2026-03-28 16:10:00',NULL),(491,4,'PayslipItems','168','UPDATE','{\"amount\":\"10.000000\"}','2026-03-28 16:10:00',NULL),(492,4,'PayslipItems','179','CREATE','[]','2026-03-28 16:10:00',NULL),(493,4,'PayslipItems','180','CREATE','[]','2026-03-28 16:10:00',NULL),(494,4,'PayslipItems','181','CREATE','[]','2026-03-28 16:10:00',NULL),(495,4,'PayslipItems','182','CREATE','[]','2026-03-28 16:10:00',NULL),(496,4,'Payslips','18','UPDATE','{\"gross_pay\":\"2000.00\",\"deductions\":\"690.42\",\"net_pay\":\"1309.58\",\"exchange_rate\":\"1.0000\",\"zwg_deductions\":\"690.42\",\"zwg_net\":\"1309.58\",\"payslip_items\":[{\"id\":162,\"payslip_id\":18,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"2000.000000\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":null},{\"id\":163,\"payslip_id\":18,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":164,\"payslip_id\":18,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":165,\"payslip_id\":18,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":166,\"payslip_id\":18,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":167,\"payslip_id\":18,\"item_type\":\"Company Contribution\",\"name\":\"ZIMDEF\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":168,\"payslip_id\":18,\"item_type\":\"Company Contribution\",\"name\":\"SDF\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}]}','2026-03-28 16:10:00',NULL),(497,4,'PayslipItems','183','CREATE','[]','2026-03-28 16:13:43',NULL),(498,4,'PayslipItems','184','CREATE','[]','2026-03-28 16:13:43',NULL),(499,4,'PayslipItems','185','CREATE','[]','2026-03-28 16:13:43',NULL),(500,4,'PayslipItems','186','CREATE','[]','2026-03-28 16:13:43',NULL),(501,4,'PayslipItems','187','CREATE','[]','2026-03-28 16:13:43',NULL),(502,4,'Payslips','21','CREATE','[]','2026-03-28 16:13:43',NULL),(503,4,'PayslipItems','188','CREATE','[]','2026-03-28 16:14:28',NULL),(504,4,'PayslipItems','189','CREATE','[]','2026-03-28 16:14:28',NULL),(505,4,'PayslipItems','190','CREATE','[]','2026-03-28 16:14:28',NULL),(506,4,'PayslipItems','191','CREATE','[]','2026-03-28 16:14:28',NULL),(507,4,'PayslipItems','192','CREATE','[]','2026-03-28 16:14:28',NULL),(508,4,'Payslips','22','CREATE','[]','2026-03-28 16:14:28',NULL),(509,4,'PayslipItems','193','CREATE','[]','2026-03-28 16:14:55',NULL),(510,4,'PayslipItems','194','CREATE','[]','2026-03-28 16:14:55',NULL),(511,4,'PayslipItems','195','CREATE','[]','2026-03-28 16:14:55',NULL),(512,4,'PayslipItems','196','CREATE','[]','2026-03-28 16:14:55',NULL),(513,4,'PayslipItems','197','CREATE','[]','2026-03-28 16:14:55',NULL),(514,4,'Payslips','23','CREATE','[]','2026-03-28 16:14:55',NULL),(515,4,'PayslipItems','198','CREATE','[]','2026-03-28 16:16:18',NULL),(516,4,'PayslipItems','199','CREATE','[]','2026-03-28 16:16:18',NULL),(517,4,'PayslipItems','200','CREATE','[]','2026-03-28 16:16:18',NULL),(518,4,'PayslipItems','201','CREATE','[]','2026-03-28 16:16:18',NULL),(519,4,'PayslipItems','202','CREATE','[]','2026-03-28 16:16:18',NULL),(520,4,'Payslips','24','CREATE','[]','2026-03-28 16:16:18',NULL),(521,4,'PayslipItems','203','CREATE','[]','2026-03-28 16:17:12',NULL),(522,4,'PayslipItems','204','CREATE','[]','2026-03-28 16:17:12',NULL),(523,4,'PayslipItems','205','CREATE','[]','2026-03-28 16:17:12',NULL),(524,4,'PayslipItems','206','CREATE','[]','2026-03-28 16:17:12',NULL),(525,4,'PayslipItems','207','CREATE','[]','2026-03-28 16:17:12',NULL),(526,4,'Payslips','25','CREATE','[]','2026-03-28 16:17:12',NULL),(527,4,'InvoiceItems','14','UPDATE','{\"account_id\":2,\"unit_price\":9,\"line_total\":720,\"product_id\":null}','2026-03-28 16:21:16',NULL),(528,4,'InvoiceItems','19','CREATE','[]','2026-03-28 16:21:16',NULL),(529,4,'Invoices','19','UPDATE','{\"total\":720,\"invoice_items\":[{\"id\":14,\"invoice_id\":19,\"account_id\":1,\"quantity\":80,\"unit_price\":1500,\"line_total\":138000,\"product_id\":1}]}','2026-03-28 16:21:16',NULL),(530,4,'Transactions','1','CREATE','[]','2026-03-28 16:21:16',NULL),(531,4,'Transactions','2','CREATE','[]','2026-03-28 16:21:16',NULL),(532,4,'Transactions','3','CREATE','[]','2026-03-28 16:21:16',NULL),(533,4,'Transactions','4','CREATE','[]','2026-03-28 16:21:16',NULL),(534,4,'InvoiceItems','20','CREATE','[]','2026-03-28 16:21:56',NULL),(535,4,'Invoices','20','UPDATE','{\"currency\":\"1\",\"total\":6725,\"invoice_items\":[{\"id\":15,\"invoice_id\":20,\"account_id\":1,\"quantity\":1,\"unit_price\":1500,\"line_total\":1725,\"product_id\":1},{\"id\":16,\"invoice_id\":20,\"account_id\":1,\"quantity\":1,\"unit_price\":5000,\"line_total\":5000,\"product_id\":2}]}','2026-03-28 16:21:56',NULL),(536,4,'Transactions','5','CREATE','[]','2026-03-28 16:21:56',NULL),(537,4,'Transactions','6','CREATE','[]','2026-03-28 16:21:56',NULL),(538,4,'InvoiceItems','21','CREATE','[]','2026-03-28 16:22:27',NULL),(539,4,'Invoices','21','UPDATE','{\"currency\":\"1\",\"total\":13450,\"invoice_items\":[{\"id\":17,\"invoice_id\":21,\"account_id\":1,\"quantity\":2,\"unit_price\":1500,\"line_total\":3450,\"product_id\":1},{\"id\":18,\"invoice_id\":21,\"account_id\":1,\"quantity\":2,\"unit_price\":5000,\"line_total\":10000,\"product_id\":2}]}','2026-03-28 16:22:27',NULL),(540,4,'Transactions','7','CREATE','[]','2026-03-28 16:22:27',NULL),(541,4,'Transactions','8','CREATE','[]','2026-03-28 16:22:27',NULL),(542,4,'InvoiceItems','22','CREATE','[]','2026-03-28 16:32:35',NULL),(543,4,'Invoices','22','CREATE','[]','2026-03-28 16:32:35',NULL),(544,4,'Transactions','9','CREATE','[]','2026-03-28 16:32:35',NULL),(545,4,'Transactions','10','CREATE','[]','2026-03-28 16:32:35',NULL),(546,4,'Accounts','8','CREATE','[]','2026-03-28 16:34:53',NULL),(547,4,'Accounts','9','CREATE','[]','2026-03-28 16:35:31',NULL),(548,4,'Products','1','UPDATE','{\"account_id\":1,\"vat_rate\":\"15.000000\"}','2026-03-28 16:35:56',NULL),(549,4,'Accounts','10','CREATE','[]','2026-03-28 16:36:31',NULL),(550,4,'Invoices','19','UPDATE','{\"invoice_items\":[{\"id\":14,\"invoice_id\":19,\"account_id\":1,\"quantity\":80,\"unit_price\":1500,\"line_total\":138000,\"product_id\":1},{\"id\":19,\"invoice_id\":19,\"account_id\":1,\"quantity\":1,\"unit_price\":5000,\"line_total\":5000,\"product_id\":2}]}','2026-03-28 16:37:02',NULL),(551,4,'Transactions','11','CREATE','[]','2026-03-28 16:37:02',NULL),(552,4,'Transactions','12','CREATE','[]','2026-03-28 16:37:02',NULL),(553,4,'Transactions','13','CREATE','[]','2026-03-28 16:37:02',NULL),(554,4,'Transactions','14','CREATE','[]','2026-03-28 16:37:02',NULL),(555,4,'Invoices','20','UPDATE','{\"total\":6900,\"invoice_items\":[{\"id\":15,\"invoice_id\":20,\"account_id\":1,\"quantity\":1,\"unit_price\":1500,\"line_total\":1725,\"product_id\":1},{\"id\":16,\"invoice_id\":20,\"account_id\":1,\"quantity\":1,\"unit_price\":5000,\"line_total\":5000,\"product_id\":2},{\"id\":20,\"invoice_id\":20,\"account_id\":1,\"quantity\":4,\"unit_price\":1500,\"line_total\":6900,\"product_id\":1}]}','2026-03-28 16:37:12',NULL),(556,4,'Transactions','15','CREATE','[]','2026-03-28 16:37:12',NULL),(557,4,'Transactions','16','CREATE','[]','2026-03-28 16:37:12',NULL),(558,4,'Transactions','17','CREATE','[]','2026-03-28 16:37:12',NULL),(559,4,'Transactions','18','CREATE','[]','2026-03-28 16:37:12',NULL),(560,4,'Transactions','19','CREATE','[]','2026-03-28 16:37:12',NULL),(561,4,'Transactions','20','CREATE','[]','2026-03-28 16:37:12',NULL),(562,4,'Invoices','21','UPDATE','{\"total\":103500,\"invoice_items\":[{\"id\":17,\"invoice_id\":21,\"account_id\":1,\"quantity\":2,\"unit_price\":1500,\"line_total\":3450,\"product_id\":1},{\"id\":18,\"invoice_id\":21,\"account_id\":1,\"quantity\":2,\"unit_price\":5000,\"line_total\":10000,\"product_id\":2},{\"id\":21,\"invoice_id\":21,\"account_id\":1,\"quantity\":60,\"unit_price\":1500,\"line_total\":103500,\"product_id\":1}]}','2026-03-28 16:37:20',NULL),(563,4,'Transactions','21','CREATE','[]','2026-03-28 16:37:20',NULL),(564,4,'Transactions','22','CREATE','[]','2026-03-28 16:37:20',NULL),(565,4,'Transactions','23','CREATE','[]','2026-03-28 16:37:20',NULL),(566,4,'Transactions','24','CREATE','[]','2026-03-28 16:37:20',NULL),(567,4,'Transactions','25','CREATE','[]','2026-03-28 16:37:20',NULL),(568,4,'Transactions','26','CREATE','[]','2026-03-28 16:37:20',NULL),(569,4,'Invoices','22','UPDATE','{\"invoice_items\":[{\"id\":22,\"invoice_id\":22,\"account_id\":1,\"quantity\":1,\"unit_price\":1500,\"line_total\":1725,\"product_id\":1}]}','2026-03-28 16:37:28',NULL),(570,4,'Transactions','27','CREATE','[]','2026-03-28 16:37:28',NULL),(571,4,'Transactions','28','CREATE','[]','2026-03-28 16:37:28',NULL),(572,4,'Transactions','20','DELETE','{\"id\":20,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":6900,\"zwg\":6900,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:37:47',NULL),(573,4,'Transactions','21','DELETE','{\"id\":21,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":3450,\"zwg\":3450,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:37:57',NULL),(574,4,'Transactions','22','DELETE','{\"id\":22,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":3450,\"zwg\":3450,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:38:05',NULL),(575,4,'Transactions','1','DELETE','{\"id\":1,\"date\":\"2025-10-23\",\"description\":\"testing\",\"currency\":\"USD\",\"amount\":138000,\"zwg\":138000,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:38:11',NULL),(576,4,'Transactions','2','DELETE','{\"id\":2,\"date\":\"2025-10-23\",\"description\":\"testing\",\"currency\":\"USD\",\"amount\":138000,\"zwg\":138000,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:38:20',NULL),(577,4,'Transactions','3','DELETE','{\"id\":3,\"date\":\"2025-10-23\",\"description\":\"testing\",\"currency\":\"USD\",\"amount\":5000,\"zwg\":5000,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:38:25',NULL),(578,4,'Transactions','4','DELETE','{\"id\":4,\"date\":\"2025-10-23\",\"description\":\"testing\",\"currency\":\"USD\",\"amount\":5000,\"zwg\":5000,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:38:30',NULL),(579,4,'Transactions','5','DELETE','{\"id\":5,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":6900,\"zwg\":6900,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":1,\"company_id\":null}','2026-03-28 16:38:35',NULL),(580,4,'Transactions','6','DELETE','{\"id\":6,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":6900,\"zwg\":6900,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:38:41',NULL),(581,4,'Transactions','7','DELETE','{\"id\":7,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":103500,\"zwg\":103500,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:38:45',NULL),(582,4,'Transactions','8','DELETE','{\"id\":8,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":103500,\"zwg\":103500,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:38:52',NULL),(583,4,'Transactions','27','DELETE','{\"id\":27,\"date\":\"2026-03-28\",\"description\":\"testing\",\"currency\":\"USD\",\"amount\":1725,\"zwg\":1725,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:39:22',NULL),(584,4,'Transactions','9','DELETE','{\"id\":9,\"date\":\"2026-03-28\",\"description\":\"testing\",\"currency\":\"USD\",\"amount\":1725,\"zwg\":1725,\"type\":\"2\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:39:27',NULL),(585,4,'Transactions','10','DELETE','{\"id\":10,\"date\":\"2026-03-28\",\"description\":\"testing\",\"currency\":\"USD\",\"amount\":1725,\"zwg\":1725,\"type\":\"1\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:39:32',NULL),(586,4,'Transactions','11','DELETE','{\"id\":11,\"date\":\"2025-10-23\",\"description\":\"testing\",\"currency\":\"USD\",\"amount\":138000,\"zwg\":138000,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:39:36',NULL),(587,4,'Transactions','12','DELETE','{\"id\":12,\"date\":\"2025-10-23\",\"description\":\"testing\",\"currency\":\"USD\",\"amount\":138000,\"zwg\":138000,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:39:42',NULL),(588,4,'Transactions','13','DELETE','{\"id\":13,\"date\":\"2025-10-23\",\"description\":\"testing\",\"currency\":\"USD\",\"amount\":5000,\"zwg\":5000,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:39:58',NULL),(589,4,'Transactions','14','DELETE','{\"id\":14,\"date\":\"2025-10-23\",\"description\":\"testing\",\"currency\":\"USD\",\"amount\":5000,\"zwg\":5000,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:40:03',NULL),(590,4,'Transactions','15','DELETE','{\"id\":15,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":1725,\"zwg\":1725,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":1,\"company_id\":null}','2026-03-28 16:40:15',NULL),(591,4,'Transactions','16','DELETE','{\"id\":16,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":1725,\"zwg\":1725,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:40:20',NULL),(592,4,'Transactions','17','DELETE','{\"id\":17,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":5000,\"zwg\":5000,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":1,\"company_id\":null}','2026-03-28 16:40:26',NULL),(593,4,'Transactions','18','DELETE','{\"id\":18,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":5000,\"zwg\":5000,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:40:31',NULL),(594,4,'Transactions','19','DELETE','{\"id\":19,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":6900,\"zwg\":6900,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":1,\"company_id\":null}','2026-03-28 16:40:36',NULL),(595,4,'Transactions','23','DELETE','{\"id\":23,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":10000,\"zwg\":10000,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:40:41',NULL),(596,4,'Transactions','24','DELETE','{\"id\":24,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":10000,\"zwg\":10000,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:40:46',NULL),(597,4,'Transactions','25','DELETE','{\"id\":25,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":103500,\"zwg\":103500,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:40:51',NULL),(598,4,'Transactions','26','DELETE','{\"id\":26,\"date\":\"2026-03-24\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":103500,\"zwg\":103500,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:40:55',NULL),(599,4,'Transactions','28','DELETE','{\"id\":28,\"date\":\"2026-03-28\",\"description\":\"testing\",\"currency\":\"USD\",\"amount\":1725,\"zwg\":1725,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:41:00',NULL),(600,4,'Invoices','22','DELETE','{\"id\":22,\"date\":\"2026-03-28\",\"customer_id\":2,\"currency\":\"USD\",\"description\":\"testing\",\"status\":\"1\",\"total\":1725,\"company_id\":null}','2026-03-28 16:41:25',NULL),(601,4,'Invoices','21','DELETE','{\"id\":21,\"date\":\"2026-03-24\",\"customer_id\":2,\"currency\":\"USD\",\"description\":\"February Rentals\",\"status\":\"1\",\"total\":116950,\"company_id\":1}','2026-03-28 16:41:31',NULL),(602,4,'Invoices','20','DELETE','{\"id\":20,\"date\":\"2026-03-24\",\"customer_id\":1,\"currency\":\"USD\",\"description\":\"February Rentals\",\"status\":\"1\",\"total\":13625,\"company_id\":1}','2026-03-28 16:41:36',NULL),(603,4,'Invoices','19','DELETE','{\"id\":19,\"date\":\"2025-10-23\",\"customer_id\":2,\"currency\":\"USD\",\"description\":\"testing\",\"status\":\"1\",\"total\":143000,\"company_id\":1}','2026-03-28 16:41:40',NULL),(604,4,'InvoiceItems','23','CREATE','[]','2026-03-28 16:42:04',NULL),(605,4,'Invoices','23','CREATE','[]','2026-03-28 16:42:04',NULL),(606,4,'Transactions','29','CREATE','[]','2026-03-28 16:42:04',NULL),(607,4,'Transactions','30','CREATE','[]','2026-03-28 16:42:04',NULL),(608,4,'Transactions','29','DELETE','{\"id\":29,\"date\":\"2026-03-28\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":1732.5,\"zwg\":1732.5,\"type\":\"2\",\"account_id\":8,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:43:51',NULL),(609,4,'Transactions','30','DELETE','{\"id\":30,\"date\":\"2026-03-28\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":1732.5,\"zwg\":1732.5,\"type\":\"1\",\"account_id\":8,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:43:55',NULL),(610,4,'InvoiceItems','24','CREATE','[]','2026-03-28 16:44:43',NULL),(611,4,'Invoices','23','UPDATE','{\"total\":1732.5,\"invoice_items\":[{\"id\":23,\"invoice_id\":23,\"account_id\":8,\"quantity\":1,\"unit_price\":1500,\"line_total\":1732.5,\"product_id\":1}]}','2026-03-28 16:44:43',NULL),(612,4,'Transactions','31','CREATE','[]','2026-03-28 16:44:43',NULL),(613,4,'Transactions','32','CREATE','[]','2026-03-28 16:44:43',NULL),(614,4,'Transactions','33','CREATE','[]','2026-03-28 16:44:43',NULL),(615,4,'Transactions','34','CREATE','[]','2026-03-28 16:44:43',NULL),(616,4,'Products','2','UPDATE','{\"account_id\":1}','2026-03-28 16:45:30',NULL),(617,4,'Modules','21','CREATE','[]','2026-03-28 16:46:11',NULL),(618,4,'Invoices','23','DELETE','{\"id\":23,\"date\":\"2026-03-28\",\"customer_id\":2,\"currency\":\"USD\",\"description\":\"February Rentals\",\"status\":\"1\",\"total\":11732.5,\"company_id\":null}','2026-03-28 16:46:30',NULL),(619,4,'Transactions','34','DELETE','{\"id\":34,\"date\":\"2026-03-28\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":10000,\"zwg\":10000,\"type\":\"credit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:46:39',NULL),(620,4,'Transactions','31','DELETE','{\"id\":31,\"date\":\"2026-03-28\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":1732.5,\"zwg\":1732.5,\"type\":\"debit\",\"account_id\":8,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:46:45',NULL),(621,4,'Transactions','32','DELETE','{\"id\":32,\"date\":\"2026-03-28\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":1732.5,\"zwg\":1732.5,\"type\":\"credit\",\"account_id\":8,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":null,\"company_id\":null}','2026-03-28 16:46:51',NULL),(622,4,'Transactions','33','DELETE','{\"id\":33,\"date\":\"2026-03-28\",\"description\":\"February Rentals\",\"currency\":\"USD\",\"amount\":10000,\"zwg\":10000,\"type\":\"debit\",\"account_id\":1,\"building_id\":null,\"tenant_id\":null,\"supplier_id\":null,\"customer_id\":2,\"company_id\":null}','2026-03-28 16:46:56',NULL),(623,4,'InvoiceItems','25','CREATE','[]','2026-03-28 16:47:45',NULL),(624,4,'Invoices','24','CREATE','[]','2026-03-28 16:47:45',NULL),(625,4,'Transactions','35','CREATE','[]','2026-03-28 16:47:45',NULL),(626,4,'Transactions','36','CREATE','[]','2026-03-28 16:47:45',NULL),(627,4,'Approvals','21','CREATE','[]','2026-03-28 20:08:43',NULL),(628,4,'PayslipItems','163','UPDATE','{\"amount\":\"0.000000\"}','2026-03-28 20:12:35',NULL),(629,4,'PayslipItems','164','UPDATE','{\"amount\":\"0.000000\"}','2026-03-28 20:12:35',NULL),(630,4,'PayslipItems','165','UPDATE','{\"amount\":\"0.000000\"}','2026-03-28 20:12:35',NULL),(631,4,'PayslipItems','166','UPDATE','{\"amount\":\"0.000000\"}','2026-03-28 20:12:35',NULL),(632,4,'PayslipItems','167','UPDATE','{\"amount\":\"0.000000\"}','2026-03-28 20:12:35',NULL),(633,4,'PayslipItems','168','UPDATE','{\"amount\":\"0.000000\"}','2026-03-28 20:12:35',NULL),(634,4,'PayslipItems','179','UPDATE','{\"amount\":\"90.000000\"}','2026-03-28 20:12:35',NULL),(635,4,'PayslipItems','180','UPDATE','{\"amount\":\"200.000000\"}','2026-03-28 20:12:35',NULL),(636,4,'PayslipItems','181','UPDATE','{\"amount\":\"20.000000\"}','2026-03-28 20:12:35',NULL),(637,4,'PayslipItems','182','UPDATE','{\"amount\":\"10.000000\"}','2026-03-28 20:12:35',NULL),(638,4,'PayslipItems','208','CREATE','[]','2026-03-28 20:12:35',NULL),(639,4,'PayslipItems','209','CREATE','[]','2026-03-28 20:12:35',NULL),(640,4,'PayslipItems','210','CREATE','[]','2026-03-28 20:12:35',NULL),(641,4,'PayslipItems','211','CREATE','[]','2026-03-28 20:12:35',NULL),(642,4,'Payslips','18','UPDATE','{\"payslip_items\":[{\"id\":162,\"payslip_id\":18,\"item_type\":\"Earning\",\"name\":\"Basic Salary\",\"amount\":\"2000.000000\",\"currency\":\"ZWG\",\"is_permanent\":true,\"company_id\":null},{\"id\":163,\"payslip_id\":18,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":164,\"payslip_id\":18,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":165,\"payslip_id\":18,\"item_type\":\"Tax\",\"name\":\"PAYE\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":166,\"payslip_id\":18,\"item_type\":\"Tax\",\"name\":\"Aids Levy\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":167,\"payslip_id\":18,\"item_type\":\"Company Contribution\",\"name\":\"ZIMDEF\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":168,\"payslip_id\":18,\"item_type\":\"Company Contribution\",\"name\":\"SDF\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":179,\"payslip_id\":18,\"item_type\":\"Tax\",\"name\":\"NSSA\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":180,\"payslip_id\":18,\"item_type\":\"Tax\",\"name\":\"Pension\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":181,\"payslip_id\":18,\"item_type\":\"Company Contribution\",\"name\":\"ZIMDEF\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null},{\"id\":182,\"payslip_id\":18,\"item_type\":\"Company Contribution\",\"name\":\"SDF\",\"amount\":\"0\",\"currency\":\"ZWG\",\"is_permanent\":false,\"company_id\":null}]}','2026-03-28 20:12:35',NULL),(643,4,'Modules','2','UPDATE','{\"name\":\"Accounting\",\"model\":\"JournalEntries\"}','2026-03-28 20:17:45',NULL),(644,4,'Accounts','11','CREATE','[]','2026-03-28 20:18:34',NULL),(645,4,'Earnings','4','UPDATE','{\"account_id\":1,\"nssa_applicable\":true,\"calculation_type\":\"Fixed\"}','2026-03-28 20:20:17',NULL),(646,4,'Earnings','5','UPDATE','{\"account_id\":1,\"calculation_type\":\"Fixed\"}','2026-03-28 20:21:06',NULL),(647,4,'Modules','22','CREATE','[]','2026-03-28 20:22:17',NULL),(648,4,'Companies','1','CREATE','[]','2026-03-28 20:25:18',NULL),(649,4,'Products','3','CREATE','[]','2026-03-28 20:31:38',NULL),(650,4,'Accounts','12','CREATE','[]','2026-03-28 20:34:09',NULL),(651,4,'Accounts','13','CREATE','[]','2026-03-28 20:34:36',NULL),(652,4,'Accounts','14','CREATE','[]','2026-03-28 20:35:53',NULL),(653,4,'PayslipItems','212','CREATE','[]','2026-03-29 06:41:31',NULL),(654,4,'PayslipItems','213','CREATE','[]','2026-03-29 06:41:31',NULL),(655,4,'PayslipItems','214','CREATE','[]','2026-03-29 06:41:31',NULL),(656,4,'PayslipItems','215','CREATE','[]','2026-03-29 06:41:31',NULL),(657,4,'PayslipItems','216','CREATE','[]','2026-03-29 06:41:31',NULL),(658,4,'Payslips','26','CREATE','[]','2026-03-29 06:41:31',NULL),(659,4,'Employees','4','CREATE','[]','2026-03-29 13:36:37',NULL),(660,4,'PayslipItems','217','CREATE','[]','2026-03-29 13:38:54',NULL),(661,4,'PayslipItems','218','CREATE','[]','2026-03-29 13:38:54',NULL),(662,4,'PayslipItems','219','CREATE','[]','2026-03-29 13:38:54',NULL),(663,4,'PayslipItems','220','CREATE','[]','2026-03-29 13:38:54',NULL),(664,4,'PayslipItems','221','CREATE','[]','2026-03-29 13:38:54',NULL),(665,4,'PayslipItems','222','CREATE','[]','2026-03-29 13:38:54',NULL),(666,4,'PayslipItems','223','CREATE','[]','2026-03-29 13:38:54',NULL),(667,4,'PayslipItems','224','CREATE','[]','2026-03-29 13:38:54',NULL),(668,4,'PayslipItems','225','CREATE','[]','2026-03-29 13:38:54',NULL),(669,4,'PayslipItems','226','CREATE','[]','2026-03-29 13:38:54',NULL),(670,4,'PayslipItems','227','CREATE','[]','2026-03-29 13:38:54',NULL),(671,4,'PayslipItems','228','CREATE','[]','2026-03-29 13:38:54',NULL),(672,4,'PayslipItems','229','CREATE','[]','2026-03-29 13:38:55',NULL),(673,4,'PayslipItems','230','CREATE','[]','2026-03-29 13:38:55',NULL),(674,4,'PayslipItems','231','CREATE','[]','2026-03-29 13:38:55',NULL),(675,4,'PayslipItems','232','CREATE','[]','2026-03-29 13:38:55',NULL),(676,4,'Payslips','27','CREATE','[]','2026-03-29 13:38:55',NULL),(677,4,'PayslipItems','233','CREATE','[]','2026-03-30 16:59:19',NULL),(678,4,'PayslipItems','234','CREATE','[]','2026-03-30 16:59:19',NULL),(679,4,'PayslipItems','235','CREATE','[]','2026-03-30 16:59:19',NULL),(680,4,'PayslipItems','236','CREATE','[]','2026-03-30 16:59:19',NULL),(681,4,'PayslipItems','237','CREATE','[]','2026-03-30 16:59:19',NULL),(682,4,'PayslipItems','238','CREATE','[]','2026-03-30 16:59:19',NULL),(683,4,'PayslipItems','239','CREATE','[]','2026-03-30 16:59:19',NULL),(684,4,'PayslipItems','240','CREATE','[]','2026-03-30 16:59:19',NULL),(685,4,'PayslipItems','241','CREATE','[]','2026-03-30 16:59:19',NULL),(686,4,'PayslipItems','242','CREATE','[]','2026-03-30 16:59:19',NULL),(687,4,'PayslipItems','243','CREATE','[]','2026-03-30 16:59:19',NULL),(688,4,'PayslipItems','244','CREATE','[]','2026-03-30 16:59:20',NULL),(689,4,'PayslipItems','245','CREATE','[]','2026-03-30 16:59:20',NULL),(690,4,'PayslipItems','246','CREATE','[]','2026-03-30 16:59:21',NULL),(691,4,'PayslipItems','247','CREATE','[]','2026-03-30 16:59:21',NULL),(692,4,'PayslipItems','248','CREATE','[]','2026-03-30 16:59:21',NULL),(693,4,'Payslips','28','CREATE','[]','2026-03-30 16:59:21',NULL),(694,4,'PayslipItems','249','CREATE','[]','2026-03-30 17:01:56',NULL),(695,4,'PayslipItems','250','CREATE','[]','2026-03-30 17:01:56',NULL),(696,4,'PayslipItems','251','CREATE','[]','2026-03-30 17:01:56',NULL),(697,4,'PayslipItems','252','CREATE','[]','2026-03-30 17:01:56',NULL),(698,4,'Payslips','29','CREATE','[]','2026-03-30 17:01:56',NULL),(699,4,'PayslipItems','253','CREATE','[]','2026-03-30 17:02:05',NULL),(700,4,'PayslipItems','254','CREATE','[]','2026-03-30 17:02:05',NULL),(701,4,'PayslipItems','255','CREATE','[]','2026-03-30 17:02:05',NULL),(702,4,'PayslipItems','256','CREATE','[]','2026-03-30 17:02:05',NULL),(703,4,'PayslipItems','257','CREATE','[]','2026-03-30 17:02:05',NULL),(704,4,'PayslipItems','258','CREATE','[]','2026-03-30 17:02:05',NULL),(705,4,'PayslipItems','259','CREATE','[]','2026-03-30 17:02:05',NULL),(706,4,'PayslipItems','260','CREATE','[]','2026-03-30 17:02:06',NULL),(707,4,'PayslipItems','261','CREATE','[]','2026-03-30 17:02:06',NULL),(708,4,'PayslipItems','262','CREATE','[]','2026-03-30 17:02:06',NULL),(709,4,'PayslipItems','263','CREATE','[]','2026-03-30 17:02:06',NULL),(710,4,'PayslipItems','264','CREATE','[]','2026-03-30 17:02:06',NULL),(711,4,'PayslipItems','265','CREATE','[]','2026-03-30 17:02:06',NULL),(712,4,'PayslipItems','266','CREATE','[]','2026-03-30 17:02:06',NULL),(713,4,'PayslipItems','267','CREATE','[]','2026-03-30 17:02:06',NULL),(714,4,'PayslipItems','268','CREATE','[]','2026-03-30 17:02:06',NULL),(715,4,'Payslips','30','CREATE','[]','2026-03-30 17:02:07',NULL),(716,4,'Employees','5','CREATE','[]','2026-03-30 17:08:03',NULL),(717,4,'Accounts','15','CREATE','[]','2026-03-30 17:43:22',NULL),(718,4,'Modules','23','CREATE','[]','2026-03-30 19:02:51',NULL),(719,4,'Accounts','16','CREATE','[]','2026-03-30 19:16:18',NULL),(720,4,'Accounts','17','CREATE','[]','2026-03-30 19:17:58',NULL),(721,4,'Modules','3','UPDATE','{\"name\":\"HR Payroll\"}','2026-03-31 03:43:20',NULL),(722,4,'PayslipItems','269','CREATE','[]','2026-03-31 03:51:01',NULL),(723,4,'PayslipItems','270','CREATE','[]','2026-03-31 03:51:01',NULL),(724,4,'PayslipItems','271','CREATE','[]','2026-03-31 03:51:01',NULL),(725,4,'PayslipItems','272','CREATE','[]','2026-03-31 03:51:01',NULL),(726,4,'PayslipItems','273','CREATE','[]','2026-03-31 03:51:01',NULL),(727,4,'Payslips','31','CREATE','[]','2026-03-31 03:51:01',NULL),(728,4,'Accounts','18','CREATE','[]','2026-03-31 03:53:03',NULL),(729,4,'Accounts','19','CREATE','[]','2026-03-31 03:53:32',NULL),(730,4,'Accounts','20','CREATE','[]','2026-03-31 03:53:54',NULL),(731,4,'Accounts','21','CREATE','[]','2026-03-31 03:54:08',NULL),(732,4,'BankTransactions','1','CREATE','[]','2026-03-31 16:03:04',NULL),(733,4,'BankTransactions','2','CREATE','[]','2026-03-31 16:03:04',NULL),(734,4,'BankTransactions','3','CREATE','[]','2026-03-31 17:19:12',NULL),(735,4,'BankTransactions','4','CREATE','[]','2026-03-31 17:19:12',NULL),(736,4,'BankTransactions','4','DELETE','{\"id\":4,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-03-31\",\"description\":\"Sample Debit (Supplier Payment)\",\"amount\":\"-250.00\",\"reference\":\"REF002\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-03-31T17:19:12+00:00\",\"modified\":\"2026-03-31T17:19:12+00:00\"}','2026-03-31 17:35:15',NULL),(737,4,'BankTransactions','3','DELETE','{\"id\":3,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-03-31\",\"description\":\"Sample Credit (Customer Payment)\",\"amount\":\"500.00\",\"reference\":\"REF001\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-03-31T17:19:12+00:00\",\"modified\":\"2026-03-31T17:19:12+00:00\"}','2026-03-31 17:35:18',NULL),(738,4,'Modules','24','CREATE','[]','2026-03-31 18:52:09',NULL),(739,4,'PayslipItems','274','CREATE','[]','2026-03-31 19:00:32',NULL),(740,4,'PayslipItems','275','CREATE','[]','2026-03-31 19:00:32',NULL),(741,4,'PayslipItems','276','CREATE','[]','2026-03-31 19:00:32',NULL),(742,4,'PayslipItems','277','CREATE','[]','2026-03-31 19:00:32',NULL),(743,4,'PayslipItems','278','CREATE','[]','2026-03-31 19:00:32',NULL),(744,4,'PayslipItems','279','CREATE','[]','2026-03-31 19:00:32',NULL),(745,4,'PayslipItems','280','CREATE','[]','2026-03-31 19:00:32',NULL),(746,4,'PayslipItems','281','CREATE','[]','2026-03-31 19:00:32',NULL),(747,4,'PayslipItems','282','CREATE','[]','2026-03-31 19:00:32',NULL),(748,4,'PayslipItems','283','CREATE','[]','2026-03-31 19:00:32',NULL),(749,4,'PayslipItems','284','CREATE','[]','2026-03-31 19:00:32',NULL),(750,4,'PayslipItems','285','CREATE','[]','2026-03-31 19:00:32',NULL),(751,4,'PayslipItems','286','CREATE','[]','2026-03-31 19:00:32',NULL),(752,4,'PayslipItems','287','CREATE','[]','2026-03-31 19:00:32',NULL),(753,4,'PayslipItems','288','CREATE','[]','2026-03-31 19:00:32',NULL),(754,4,'PayslipItems','289','CREATE','[]','2026-03-31 19:00:32',NULL),(755,4,'PayslipItems','290','CREATE','[]','2026-03-31 19:00:32',NULL),(756,4,'Payslips','32','CREATE','[]','2026-03-31 19:00:32',NULL),(757,4,'Employees','6','CREATE','[]','2026-03-31 19:04:47',NULL),(758,4,'PayslipItems','291','CREATE','[]','2026-03-31 19:07:23',NULL),(759,4,'PayslipItems','292','CREATE','[]','2026-03-31 19:07:23',NULL),(760,4,'PayslipItems','293','CREATE','[]','2026-03-31 19:07:23',NULL),(761,4,'PayslipItems','294','CREATE','[]','2026-03-31 19:07:23',NULL),(762,4,'PayslipItems','295','CREATE','[]','2026-03-31 19:07:23',NULL),(763,4,'PayslipItems','296','CREATE','[]','2026-03-31 19:07:23',NULL),(764,4,'PayslipItems','297','CREATE','[]','2026-03-31 19:07:24',NULL),(765,4,'PayslipItems','298','CREATE','[]','2026-03-31 19:07:24',NULL),(766,4,'PayslipItems','299','CREATE','[]','2026-03-31 19:07:24',NULL),(767,4,'PayslipItems','300','CREATE','[]','2026-03-31 19:07:24',NULL),(768,4,'PayslipItems','301','CREATE','[]','2026-03-31 19:07:24',NULL),(769,4,'PayslipItems','302','CREATE','[]','2026-03-31 19:07:24',NULL),(770,4,'PayslipItems','303','CREATE','[]','2026-03-31 19:07:24',NULL),(771,4,'PayslipItems','304','CREATE','[]','2026-03-31 19:07:24',NULL),(772,4,'PayslipItems','305','CREATE','[]','2026-03-31 19:07:24',NULL),(773,4,'PayslipItems','306','CREATE','[]','2026-03-31 19:07:24',NULL),(774,4,'Payslips','33','CREATE','[]','2026-03-31 19:07:24',NULL),(775,4,'PayslipItems','307','CREATE','[]','2026-03-31 19:13:16',NULL),(776,4,'PayslipItems','308','CREATE','[]','2026-03-31 19:13:16',NULL),(777,4,'PayslipItems','309','CREATE','[]','2026-03-31 19:13:16',NULL),(778,4,'PayslipItems','310','CREATE','[]','2026-03-31 19:13:16',NULL),(779,4,'PayslipItems','311','CREATE','[]','2026-03-31 19:13:16',NULL),(780,4,'PayslipItems','312','CREATE','[]','2026-03-31 19:13:16',NULL),(781,4,'PayslipItems','313','CREATE','[]','2026-03-31 19:13:16',NULL),(782,4,'PayslipItems','314','CREATE','[]','2026-03-31 19:13:16',NULL),(783,4,'PayslipItems','315','CREATE','[]','2026-03-31 19:13:16',NULL),(784,4,'PayslipItems','316','CREATE','[]','2026-03-31 19:13:16',NULL),(785,4,'PayslipItems','317','CREATE','[]','2026-03-31 19:13:16',NULL),(786,4,'PayslipItems','318','CREATE','[]','2026-03-31 19:13:16',NULL),(787,4,'PayslipItems','319','CREATE','[]','2026-03-31 19:13:16',NULL),(788,4,'PayslipItems','320','CREATE','[]','2026-03-31 19:13:16',NULL),(789,4,'PayslipItems','321','CREATE','[]','2026-03-31 19:13:16',NULL),(790,4,'PayslipItems','322','CREATE','[]','2026-03-31 19:13:16',NULL),(791,4,'Payslips','34','CREATE','[]','2026-03-31 19:13:16',NULL),(792,4,'PayslipItems','323','CREATE','[]','2026-03-31 19:16:09',NULL),(793,4,'PayslipItems','324','CREATE','[]','2026-03-31 19:16:09',NULL),(794,4,'PayslipItems','325','CREATE','[]','2026-03-31 19:16:09',NULL),(795,4,'PayslipItems','326','CREATE','[]','2026-03-31 19:16:09',NULL),(796,4,'PayslipItems','327','CREATE','[]','2026-03-31 19:16:09',NULL),(797,4,'PayslipItems','328','CREATE','[]','2026-03-31 19:16:09',NULL),(798,4,'PayslipItems','329','CREATE','[]','2026-03-31 19:16:09',NULL),(799,4,'PayslipItems','330','CREATE','[]','2026-03-31 19:16:09',NULL),(800,4,'PayslipItems','331','CREATE','[]','2026-03-31 19:16:09',NULL),(801,4,'PayslipItems','332','CREATE','[]','2026-03-31 19:16:09',NULL),(802,4,'PayslipItems','333','CREATE','[]','2026-03-31 19:16:09',NULL),(803,4,'PayslipItems','334','CREATE','[]','2026-03-31 19:16:09',NULL),(804,4,'PayslipItems','335','CREATE','[]','2026-03-31 19:16:09',NULL),(805,4,'PayslipItems','336','CREATE','[]','2026-03-31 19:16:09',NULL),(806,4,'PayslipItems','337','CREATE','[]','2026-03-31 19:16:09',NULL),(807,4,'PayslipItems','338','CREATE','[]','2026-03-31 19:16:09',NULL),(808,4,'Payslips','35','CREATE','[]','2026-03-31 19:16:09',NULL),(809,4,'Deals','15','CREATE','[]','2026-04-01 03:09:44',NULL),(810,4,'Deals','15','UPDATE','{\"status\":\"Draft\"}','2026-04-01 03:09:44',NULL),(811,4,'Modules','25','CREATE','[]','2026-04-01 03:23:36',NULL),(812,4,'Invitations','1','CREATE','[]','2026-04-01 03:24:14',NULL),(813,4,'Users','8','CREATE','[]','2026-04-01 03:31:56',NULL),(814,4,'Invitations','1','UPDATE','{\"status\":\"pending\"}','2026-04-01 03:31:56',NULL),(815,8,'Deals','14','DELETE','{\"id\":14,\"name\":\"tasara\",\"description\":\"we diabetes\",\"date\":\"2025-11-01\",\"type\":\"2\",\"value\":\"5000\",\"stage\":\"2\",\"contact_id\":4,\"status\":\"1\",\"submitted_by\":4,\"submitted_at\":\"2025-11-25T14:26:48+00:00\",\"approved_by\":null,\"approved_at\":null,\"rejected_by\":null,\"rejected_at\":null,\"rejection_reason\":\"\",\"company_id\":null}','2026-04-01 03:34:00',NULL),(816,8,'Deals','13','DELETE','{\"id\":13,\"name\":\"Testing approvals\",\"description\":\"Testing approvals\",\"date\":\"2025-11-02\",\"type\":\"1\",\"value\":\"10000\",\"stage\":\"1\",\"contact_id\":4,\"status\":\"1\",\"submitted_by\":4,\"submitted_at\":\"2025-11-25T09:30:07+00:00\",\"approved_by\":null,\"approved_at\":null,\"rejected_by\":null,\"rejected_at\":null,\"rejection_reason\":\"\",\"company_id\":null}','2026-04-01 03:34:05',NULL),(817,8,'Deals','8','DELETE','{\"id\":8,\"name\":\"erasmusm software consultancy\",\"description\":\"February Pension\",\"date\":\"2025-10-28\",\"type\":\"1\",\"value\":\"700\",\"stage\":\"1\",\"contact_id\":2,\"status\":\"1\",\"submitted_by\":4,\"submitted_at\":\"2025-11-25T09:29:44+00:00\",\"approved_by\":null,\"approved_at\":null,\"rejected_by\":null,\"rejected_at\":null,\"rejection_reason\":\"\",\"company_id\":null}','2026-04-01 03:34:11',NULL),(818,8,'Deals','7','DELETE','{\"id\":7,\"name\":\"erasmusm software consultancy\",\"description\":\"February Pension\",\"date\":\"2025-10-28\",\"type\":\"1\",\"value\":\"80\",\"stage\":\"1\",\"contact_id\":2,\"status\":\"1\",\"submitted_by\":4,\"submitted_at\":\"2025-11-25T14:26:01+00:00\",\"approved_by\":null,\"approved_at\":null,\"rejected_by\":null,\"rejected_at\":null,\"rejection_reason\":\"\",\"company_id\":null}','2026-04-01 03:34:15',NULL),(819,8,'Deals','6','DELETE','{\"id\":6,\"name\":\"erasmusm software consultancy\",\"description\":\"February Pension\",\"date\":\"2025-10-28\",\"type\":\"1\",\"value\":\"79997\",\"stage\":\"1\",\"contact_id\":2,\"status\":\"1\",\"submitted_by\":4,\"submitted_at\":\"2025-11-25T14:25:38+00:00\",\"approved_by\":null,\"approved_at\":null,\"rejected_by\":null,\"rejected_at\":null,\"rejection_reason\":\"\",\"company_id\":null}','2026-04-01 03:34:21',NULL),(820,8,'Modules','26','CREATE','[]','2026-04-01 03:42:51',NULL),(821,8,'Modules','27','CREATE','[]','2026-04-01 04:00:07',NULL),(822,4,'BankTransactions','5','CREATE','[]','2026-04-02 13:13:26',NULL),(823,4,'BankTransactions','6','CREATE','[]','2026-04-02 13:13:26',NULL),(824,4,'BankTransactions','7','CREATE','[]','2026-04-02 13:13:26',NULL),(825,4,'BankTransactions','8','CREATE','[]','2026-04-02 13:13:26',NULL),(826,4,'BankTransactions','9','CREATE','[]','2026-04-02 13:13:26',NULL),(827,4,'BankTransactions','10','CREATE','[]','2026-04-02 13:13:26',NULL),(828,4,'BankTransactions','11','CREATE','[]','2026-04-02 13:13:26',NULL),(829,4,'BankTransactions','12','CREATE','[]','2026-04-02 13:13:26',NULL),(830,4,'BankTransactions','13','CREATE','[]','2026-04-02 13:13:26',NULL),(831,4,'BankTransactions','14','CREATE','[]','2026-04-02 13:13:26',NULL),(832,4,'BankTransactions','15','CREATE','[]','2026-04-02 13:13:26',NULL),(833,4,'BankTransactions','16','CREATE','[]','2026-04-02 13:13:26',NULL),(834,4,'BankTransactions','17','CREATE','[]','2026-04-02 13:13:26',NULL),(835,4,'BankTransactions','18','CREATE','[]','2026-04-02 13:13:26',NULL),(836,4,'BankTransactions','19','CREATE','[]','2026-04-02 13:13:26',NULL),(837,4,'BankTransactions','20','CREATE','[]','2026-04-02 13:13:26',NULL),(838,4,'BankTransactions','21','CREATE','[]','2026-04-02 13:13:26',NULL),(839,4,'BankTransactions','22','CREATE','[]','2026-04-02 13:13:26',NULL),(840,4,'BankTransactions','23','CREATE','[]','2026-04-02 13:13:26',NULL),(841,4,'BankTransactions','24','CREATE','[]','2026-04-02 13:13:26',NULL),(842,4,'BankTransactions','25','CREATE','[]','2026-04-02 13:13:26',NULL),(843,4,'BankTransactions','26','CREATE','[]','2026-04-02 13:13:26',NULL),(844,4,'BankTransactions','27','CREATE','[]','2026-04-02 13:13:26',NULL),(845,4,'BankTransactions','28','CREATE','[]','2026-04-02 13:13:26',NULL),(846,4,'BankTransactions','29','CREATE','[]','2026-04-02 13:13:26',NULL),(847,4,'BankTransactions','30','CREATE','[]','2026-04-02 13:13:26',NULL),(848,4,'BankTransactions','31','CREATE','[]','2026-04-02 13:13:26',NULL),(849,4,'BankTransactions','32','CREATE','[]','2026-04-02 13:13:26',NULL),(850,4,'BankTransactions','33','CREATE','[]','2026-04-02 13:13:26',NULL),(851,4,'BankTransactions','34','CREATE','[]','2026-04-02 13:21:55',NULL),(852,4,'BankTransactions','35','CREATE','[]','2026-04-02 13:21:55',NULL),(860,4,'BankTransactions','5','DELETE','{\"id\":5,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"\\u0015??+y\\u0006?FO?(~l\\u001a\\u0018\\u001f?`s??\\u04d0lC?\\u0017?j?c%?w?rwX?\\u001e\\f???AZ?V|H?;\\u045c\\u001d7\\u000b]??XAo{?j????RU?@ZA\\u001a\\u0019gL?\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:44:42',NULL),(867,4,'BankTransactions','6','DELETE','{\"id\":6,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"?\\u00148??(%\\u0019???\\\"D??\\u04864j?0u2js?\\u001d?MY?\\u02f4????S\\ucb42??? ?)f???C??\\u0006??y\\u001f??\\u0019\\tI<\\ry\\u0000???!+??E?\\b???fMy?k???\\f?\\u001c?K\\u001e?5=|?t ??G\\u001f)?s\\u5899?U??tB??)???\",\"amount\":0,\"reference\":\"??q}??o??????????????f_?vy??=????????o??\\u04fb???????us{????~?P????>{??\\u06577*??????w?m?\\u03df?\\t??\\u01cf?\\u0007\\u0003??-??<?\\/????????_~??????~???oc?\\u04fe????????w{}?t???O????o?|\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:45:11',NULL),(868,4,'BankTransactions','7','DELETE','{\"id\":7,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"uJ?:%K???N?R?d?S??)Y??\",\"amount\":0,\"reference\":\"tJ\\u0016:%\\u000b???N?B?d?S??)Y??\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:45:11',NULL),(869,4,'BankTransactions','8','DELETE','{\"id\":8,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"tJ\\u0016:%\\u000b???N?B?d?S??)Y??\",\"amount\":0,\"reference\":\"uJ?:%K???N?R?d?S??)Y??\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:45:24',NULL),(870,4,'BankTransactions','9','DELETE','{\"id\":9,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"uJ?:%K???N?R?d?S??)Y??\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:45:24',NULL),(871,4,'BankTransactions','10','DELETE','{\"id\":10,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"uJ?:%K???N?R?d?S??)Y??\",\"amount\":0,\"reference\":\"uJ?:%K???N?R?d?S??)Y??\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:45:24',NULL),(875,4,'BankTransactions','11','DELETE','{\"id\":11,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"tJ\\u0016:%\\u000b???N?B?d?S??)Y??\",\"amount\":0,\"reference\":\"tJ\\u0016:?\\u01a1[??\\r\\u0015?e?4?n?^?o???:7>??s3_k\\u0013??u\\u0013??s3?\\u0013\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:46:06',NULL),(876,4,'BankTransactions','13','DELETE','{\"id\":13,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"?x??Wg?E??\\\"6\\u001e?o???????\\u000b\\u0015??41?\\u001f\\u011c\\u0013??0??9\'?9a?\\tsN?s\\u009c\\u0013??0??9\'?9a?\\tsN?s?\\\\?d?l?g0\\u0017K??9?w????t??\\ud9bb\\ude58?l.??o??s?9q?sz?\\u0013?<?9\'?9a?\\tsN?s\\u009c\\u0013??0??9\'?9a?\\tsN?s\\u009c\\u0013??0?$?+??\\u0019??Jzbn?[\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:46:20',NULL),(877,4,'BankTransactions','14','DELETE','{\"id\":14,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"?9??\\tvN?s??\\u0013??`?\\u0004;\'?9??\\tvN?s??\\u0013??`?\\u0004?&?]Y\\u001d??Y?26?f7\\u07a8?\\u000b?:????!??Uzx??????\\u001csN???8?9a?\\tsN?s\\u009c\\u0013??0??9\'?9a?\\tsN?s\\u009c\\u0013??0??9\'?9a?I2WV?3??b\\u0003=1?^\\u001e?qCb??i???\\u0273:?\\u0006{\\u001c???\\u001a\\u0007????\\u001ctN?s\\u0002?\\u0013??@?\\u0004:\'?9??\\ttN?s\\u0002?\\u0013??@?\\u0004:\'?9??\\ttN?s\\u0002?\\u0013??$tes<\\u00c9.\\u0016\\u040fF\\u0017?\\u0013tig????nw?u???????G?y?\\u00bf???\\fO??<??F\\u001d\",\"amount\":0,\"reference\":\"c??.??b????s\\u001er?8?9??\\ttN?s\\u0002?\\u0013??@?\\u0004:\'?9??\\ttN?s\\u0002?\\u0013??@?\\u0004:\'?9??\\ttM\\u0012??K?\\u0001]???nu?\\u000f???.?.c??.f??\\u04b5?z\\u0014?m??S\\u0519?\\u0003?7??sB?\\u0013??P??:\'?9??\\tuN?sB?\\u0013??P??:\'?9??\\tuN?sB?\\u0013??$ue\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:46:20',NULL),(878,4,'BankTransactions','15','DELETE','{\"id\":15,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"???l\\u0015;\\u9cfa??vY?????EJ???v?z?e=fe?\\u032fi? }t^???\\ttN?s\\u0002?\\u0013??@?\\u0004:\'?9??\\ttN?s\\u0002?\\u0013??@?\\u0004:\'?9??\\ttN?s\\u0002]?????\\\\?8\\u001e??N?GW\\u01fb??:s~V?Nuu???\\u03b4?)Rz?L?MNosz????>??1???ns???SN?s???\\u05dc???=?\\u001f9???~???\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:46:20',NULL),(879,4,'BankTransactions','16','DELETE','{\"id\":16,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"??^s.?#=y??v(??\\u97eb}?\\u001dW??\\u054b?^??j??3????L?fz?\\u04c7?>??i??3}???L?f?>\\u04cf?~\\u001e\\t(k???\\/?\\u001c?\\u001e??\\u0014??????A1=?)(^\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014?-\\u0001eMq7@q?\\u000b?)(W:?x\\u0015\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014?-\\u0001eMq7@q?\\u000b?)(W:?x\\u0015\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:46:33',NULL),(880,4,'BankTransactions','17','DELETE','{\"id\":17,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"??^s.?#=y?;?P????W?2;??\\u03eb\\u00173????L?gz3?\\u06d9???~?\\u000f3}???L?g?2?\\u05d9???}?\\u001f3?<\\u0012P?)???(?\\u001c?\\u001e?\\u001a)(?????A1=?)(^\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014?-\\u0001???n???\\u0017\\u0014SPV:?x\\u0015\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014?-\\u0001???n???\\u0017\\u0014SPV:?x\\u0015\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA1\\u0005?\\u0014\\u0014SPLA\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:46:33',NULL),(881,4,'BankTransactions','18','DELETE','{\"id\":18,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"]?7)??\\u001du???xe6;?~~\\u0503<=?\\u04e3<=?\\u04d3<=?\\u04f3<=?\\u04cb<??\\u04eb<??\\u04db<??\\u04fb<??\\u04c7<}L?????o??\\f^??X?\\u0004???\\u0004??A?8??\\u0013P|\\u0014P???\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P??\\u0012%A\\tKq;@?\\\"\\u001fP????\\u0004??\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?DIP?R?\\u000eP??\\u0007\\u0014\'?l)?\\u28c0?\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:46:48',NULL),(882,4,'BankTransactions','19','DELETE','{\"id\":19,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"?}?\\u0019e?\\\"?\\u015a%?lG%P?\\u000f\\u0002??^??\\u28c0?\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004?(\\tJX??\\u0001?\\u0017???\\u0004?-%P|\\u0014P???\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001%J?\\u0012??v??E>?8\\u0001eK\\t\\u0014\\u001f\\u0005\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001?\\t(N@??????\\u001d?x?\\u000f(N@?R\\u0002?G\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'\",\"amount\":0,\"reference\":\"\\u0001e;*??\\u0010(N??\\u0004\\u0014\\u001f\\u0005\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?DIP?R?\\u000eP??\\u0007\\u0014\'?l)?\\u28c0?\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001?\\t(N@q\\u0002?\\u0013P???\\u0004\\u0014\'?8\\u0001?\\t(Q\\u0012??\\u0014?\\u0003\\u0014\\/?\\u0001?\\t([J??(?8\\u0001?\\t(N@q\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:46:48',NULL),(883,4,'BankTransactions','20','DELETE','{\"id\":20,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"O???\\\"O\\/??*O???&Oo??.O???!O\\u001f?$(a)???(?\\u0017?.?\",\"amount\":0,\"reference\":\"??\\u0000\\u014b|@q\\u0002\\u0296\\u0012(>\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:47:02',NULL),(884,4,'BankTransactions','21','DELETE','{\"id\":21,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"9C?8\\u001d??~\",\"amount\":0,\"reference\":\"?t??9fW?????6????????-?wW?\\u0797??C|?\\r\\/??????\\u0007~?x?w_??\\u000f??6????\\u001f\\u000e?4\\u001f?#O?????~???\\u1974\\u001d?0M????\\u053b\\/????Z\\u001b^J??\\u001f\\u0007>Y?%?z??????\\u001b???\\u000e?x\\\\\\u000f?)\\u001c???7S????!?\\u0586????\\u001f?i???0\\u001f??\\u0014???\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:47:02',NULL),(885,4,'BankTransactions','22','DELETE','{\"id\":22,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"?\\u0018?M\\u0018\\ubbf5???\\u0018_k?Ki;??r??\\u0011??s???~???\\u1974\\u001d=???\\u0390?P???L??????Z\\u001b^J?\\u0473\\u0002~\\u0018?%??m??~(????Z\\u001b^J???c?\\u0004?????U?8??:{C?\\u0014_k?Ki9z.?\\u00137?\\f#?????4???kmx)mG??U-l?+?z????\\u0014_k?Ki;?c??j\\u0019???;\\u00e14???{?\\u001a_k?????p<.??k???~?????4}\\ufefe_??u?T???P??O??6???????bt?\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:47:02',NULL),(887,4,'BankTransactions','23','DELETE','{\"id\":23,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"$W????}?????[_kGn????0\\u036c\\u001e}i~\\u001f~??4???Zf\\b]?\\u001f?E???3\\u0016o??????4?????\\u0005?k???}i~\\u001f~??t?}?k??\\u0019????\\uda6e\\udff5?U??om?\\u001d???[_k???\\u0019????R?{_?\\u07c7\\u001fw;?????\\u0213\\u000f??rKf?{_?\\u07c7_\\u001c;?????5?pK?????????>?\\f?i????3\'?~?\\u0001????S?\\u07c7?f:????v?:?W?|??w_?\\u07c7\\u001f\\f:????vf?\\u0018??R?`?X?\\u07c7_?9??????{n?aM?~~?????7lN?o}??\\u001e?#?n??\",\"amount\":0,\"reference\":\"Du???K???\\/?i\\udbf6\\udff5kw\\b7F\\u001d?l^?)??\\u00ee\\u0127?7?\\u05ae?\\f8?\\u000b?\\u0097???K??????\\u0447???Z?\'Bnq???\\u05ef??\\u0004???\\u00f6???7?\\u05ae\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:48:47',NULL),(888,4,'BankTransactions','25','DELETE','{\"id\":25,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"m4\\u001e?w???>?:N??\\u07cb????\\u72abb????\\u0017_??|X?)??????3????<???a??~??8?O????Q????????_s?\\/???\\u076e?w?x??\\u001a\'?o?;\\b???.???d??.????O\\u001e=?\\u0013???&???Wq???x?}???\\u03d6]????V???\\/???=?x*????o??!??\\u059f?o??2?Ov??\\u00abi?\'?8\\u0014?\\/q\\u0012???^\\u0016??\\u027eW?\\u001c?z?\\\\L?O??i???eq???|?>x????\\u001d\\u07f8??9M??????????\\u0016Z??_~\\u00189\\u0003??z?????U\\u0017^M\",\"amount\":0,\"reference\":\"M2???_???\\u0262?\\u0007S???4??j??????????\'+??\\\\??4??n?d????||?\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:49:08',NULL),(889,4,'BankTransactions','26','DELETE','{\"id\":26,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"?\\u0006???K??p??\\uc767\\u000b\\u001dw\\u0013?#[?!J?\\u0004?\\u0017s?Wbs\\u0019F\\u0620y??D?\\u0019N?p?3v??etw\\b1??O?)?l*?;??\\\"b\\r\\u0250??B*???\\u0018???\\u0011?T\\u001b?\\u067f?t\\u0019?????L$?\\u0016?Z?\\u000f15?x\\u0019-\\u0004?m.?(?z????l$\\u000f??X????L?0eN?9??\\\\Oa?Z\\u04af???\\u04feO???L\\u00059???C???\\u001e;\\f#\\u0014\\u03ed?I\\u0012??O?!?(rn0a??3?\\r???\\u0007?lM?m??t?-\\u0004?@\\\\uJE??\'?\\u0512?\\u02d8????N\\u0011V*\\u0003?oHzL?3?????????5?\\u001c4???]\\u053c?\\u0012?;\",\"amount\":0,\"reference\":\"E??I????? BsX?W?6t?s?3??\\u0019?u?jV\\u001bb|\\u02b7?=\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:49:08',NULL),(890,4,'BankTransactions','28','DELETE','{\"id\":28,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"?Q?j?\",\"amount\":0,\"reference\":\"\\u0019?Ww?\\u0011??|^%G??WKk??\\u0016?ye??{o?W?UT\\u0015;\\u0017G?\\\\z??\\u037d????\\u0011;??V?V?\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:49:19',NULL),(891,4,'BankTransactions','29','DELETE','{\"id\":29,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"D3M?\\b9\\\"??z??iV??9\\u001c?dj\\u0015\\u0011\\t?\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:49:19',NULL),(892,4,'BankTransactions','30','DELETE','{\"id\":30,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"{I`\\r?dw\",\"amount\":0,\"reference\":\"\\u001d\\u0005?\\u0001Iv?!7\\u0015?c??0????g?\\u0014\\u001c????\\u000eU\\u0007?T?\\u0386?\\u0019V???&\\u0011Qf??#rFh??\\u0010???h:b+n\\u07dc\\u0011??!\\u0017\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:49:19',NULL),(893,4,'BankTransactions','31','DELETE','{\"id\":31,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"7?\\r???2BX?{[?~?\\f?\\u000b$\\u0011 ?\\u0000K??R9?l??J\\u0010\\u001b?\\u00110?\\u0004u\\u05dca?(qPQ\\/0?]\\u6757??7??]P???q?!\\rK?@?$?OKn??-4L\\u0013Ax\\u0001k??8\\u0587?\\u0018b?<I\\\"\\u0615\\u00021\\u001b2\\u000f??%???a??P??\\r????b???G\\u03ee?\\u0004\\r??`n\\u0013?.\\\\?P????%??pW(????\\t?aF?4?\\u000fbBa????s?V@?N\\u000f??\\u0019??\\u0770?O??\\t?y?:?X?0??W????f???\\/?\\u060a?}?T?0?:?$h8({?\\u001a?\\u0018(???\\\\??\\r?s\\u001bD???\\u0014}\\u070d??\\u0017?si?\\u001e?#p\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:49:28',NULL),(894,4,'BankTransactions','32','DELETE','{\"id\":32,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"k\\b?yy;O4?#9\\u0012?0??~\\/\\u0019\\fiw??B?\\u00119S????\\u001a?$T??\\u001193f\\u000e?~??????qO\\u41a2???Mnr??a$;4\",\"amount\":0,\"reference\":\"?L\\u01d4??\\f3?w?\\u0006?\\u0015\\u0013?J?iI?`ghX?8?\\u0015hq?\\u0001H?H2\\u000f\\u0016:\\u0010l??t?1?\\u001d???t?\\u0011 ?Jv\\u00e0T8X\\u0002rx????$???;?P?\\u00f9V+z\\u0013?\\u0010JB???(\\u0004??=\\u0005?Ba?3*;?M??8?\\u0007??i?|\\u0017?\\u0005??5\\u001c\\u0004??&???I?z\\u0006?l8?\\b\\u0001\\u0003?BA?.\\u000f???h(?\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:49:28',NULL),(895,4,'BankTransactions','33','DELETE','{\"id\":33,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"T?\\\"\\u054e?k?\\u0015?r>\\u0012\\u0012???Rj+dd??\\u001a??oW\\u0013F\\u0006?*??\\u0443?\\u0000\\u0000\\u0000??\\u0003\\u0000PK\\u0003\\u0004\\u0014\\u0000\\u0006\\u0000\\b\\u0000\\u0000\\u0000!\\u0000?Y\\/DM\\u0001\\u0000\\u0000o\\u0002\\u0000\\u0000\\u0011\\u0000\\b\\u0001docProps\\/core.xml ?\\u0004\\u0001(?\\u0000\\u0001\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\",\"amount\":0,\"reference\":\"??*???\\u0019???.???.??B?r?K??qZ%)????nD<\\u0003?\\u001c_|??\\u001b\\u0000\\u0000??\\u0003\\u0000PK\\u0003\\u0004\\u0014\\u0000\\u0006\\u0000\\b\\u0000\\u0000\\u0000!\\u0000aI\\t\\u0010?\\u0001\\u0000\\u0000\\u0011\\u0003\\u0000\\u0000\\u0010\\u0000\\b\\u0001docProps\\/app.xml ?\\u0004\\u0001(?\\u0000\\u0001\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:49:28',NULL),(896,4,'BankTransactions','34','DELETE','{\"id\":34,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"\\u20ac~\\u201c\\u00d3\\u00ba\\u0019\\u00d0\\u00ca\\u00f4\\u0018\\u00b8\\u0012\\u00f3\\u00c7\\u00b6\\u00d6RV\\u00d6\\u0000qO\\u000b*\\u017e;PU)S\\u00ff\\u00fc\\u00a1b\\u001c\\u00df\\u0017\\u00e0\\u00f6\\u001a9\\u00ca\\u0161\\u00c3\\u00cf\\u2026?2\\u00a01\\u2021\\u201c`\\u00e9\\u00e0\\u00a8\\u2019\\u00a6\\u01535l)N\\u0000Z\\u00efI\\u001f\\u00f8\\u008f\\f\\u001d\\u00a1\\u00bd\\u0010\\u00ac\\u000fcp\\u001c\\u2019\\u00ads\\u00f2De\\u000e\\u00b7\\u00ac\\u00b8\\u00fbFV\\u00ee\\u0016\\u00cb\\u00dd\\u0081!\\u00e3\\u00ddh\\b\\u00a4\\u00d5i\\u00c5\\u2021\\u00e0\\u00bd\\u0011\\u00cd\\u00d9r3\\u00d5\\u00b3\\u00d3%-\\u00c8u\\/]\\u0005\\u00d7\\u00f5\\u0017\\\\\\u00caL\\u0015\\u00aaR\\u00e0F\\u00c4\\u0019\\u0015$\\u000b\\u00d4\\u0011\\f\\u00d9\\u0160\\u00ec&\\u00c0+\\u00de\\u00d6aK\\u000bX5\\u00bd\\u00b1i\\u00aa\\u00fa\\u00d9V\\u00ce\\u2014\\u001c\\u0006\\u0090\\u00fbI!\\b\\u00af\\u00b0 SV\\t\\u0090\\u00da\\u2020\\u00fa{e\\u00d5aOs\\u0006\\\"V\\u00e6\\u00e4GK9\\u0081\\u00bb\\u0003\\u0012\\u0002w\\u00a0\\u00c5\\u00a9\\u008f\\u00ef\\u203aK\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:21:55+00:00\",\"modified\":\"2026-04-02T13:21:55+00:00\"}','2026-04-02 13:49:36',NULL),(897,4,'BankTransactions','35','DELETE','{\"id\":35,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"\\u00bc\\u00f7\\u00fa\\u0017\\u00a4O\\u0007\\u0014\\u0000\\u00d9\\u00e7\\u00efT\\u00aa\\u00fe\\u0017\\u00fc+F\\u00dd;\\u00dbO\\u00f9^\\u00ca\\u00c0\\u00c0?4\\u00e7_*U\\u00ff\\u000b\\u00fe\\u0015Xro\\u00fb9y\\u001do\\u20398\\u00cc\\u00fa\\u00a7R\\u00f5\\\"F\\u00ed\\u00f5\\u00b37\\u00ff\\u0160\\u00b3o?u\\u00ffR\\u00bfa\\u00d6\\u0178\\u00d5O\\u00fd\\u00df\\u009d}\\u00aec\\u00b3\\u0153\\u00af\\u0016\\u203a\\u00e1\\u00d9z2\\u008d\\u00d7\\u201cf:_m\\u000e\\u2013\\u00f1\\u00b5=\\u00ef\\u00f4\\u000e\\u00d38\\u0152\\u00f9t\\u00b6{\\u00dd\\u00d6\\u00eb\\u00ed\\u00bb\\u00ec\\u00ab\\u00a7\\u00bam\\u00eb\\u00b7\\u00dd\\u00d5\",\"amount\":0,\"reference\":\":\\u00dc\\u00a7\\u00fb\\u00fbF\\u00dd\\u008f\\u00baYlf1\\u00b6\\u00c3\\/\\u0000\\u0000\\u0000\\u00ff\\u00ff\\u0003\\u0000PK\\u0003\\u0004\\u0014\\u0000\\u0006\\u0000\\b\\u0000\\u0000\\u0000!\\u0000u>\\u2122i\\u201c\\u0006\\u0000\\u0000\\u0152\\u001a\\u0000\\u0000\\u0013\\u0000\\u0000\\u0000xl\\/theme\\/theme1.xml\\u00ecY[\\u2039\\u00dbF\\u0014~\\/\\u00f4?\\b\\u00bd;\\u00beI\\u00b2\\u00bd\\u00c4\\u001bl\\u00d9N\\u00da\\u00ec&!\\u00eb\\u00a4\\u00e4ql\\u008f\\u00ad\\u00c9\\u017d4F3\\u00de\\u008d\\t\\u0081\\u2019<\\u00f5\\u00a5PHK_\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:21:55+00:00\",\"modified\":\"2026-04-02T13:21:55+00:00\"}','2026-04-02 13:49:36',NULL),(898,4,'BankTransactions','27','DELETE','{\"id\":27,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"????\\u0014Q?2*N?\\u0015?????\\u0019??\\u0217M???.D\\u0318??f[?\\u039b\\u0019M?\\u0006D?:?\\u05cd????u???f?\\u04db?vC??D?J=?4\\u00174?h!??d\\u0766\\u053b??????D\\u0113Uy^?\\\"Y????aB?%\\u0013??\\u0006g?D??K?\\u0019?GV?4??!???0? ??]?\\\"tR??i]o\\u0010?=pIhO\\u00020???\\u001c??Y\\u00168??\\u001bz?{?_\\u0017?F?5????\\u069f!?)??\\u05bf???\\u0001???}W??\\\\?\\u0015?0c\\u0018z???5?9\\f?HV\\u0005?4\\u001d??fL?\\u0001??\'\\u0357?\'U?j?\\u0005KK??FQ?O7?\\u0002\\u001c??rOB7??a??x??\\u000f?\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:50:14',NULL),(899,4,'BankTransactions','12','DELETE','{\"id\":12,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"?g8???Y?֫Ŧ?I?%?1?????x????????)ǜ\\u0013??0??9\'?9a?\\tsN?s\\u0013??0??9\'?9a?\\tsN?s\\u0013??0焹&?\\\\?\\u001c?`.\\u0016?Ss??rQ?\\u001a?\\u000b?\\/?u????????\\\"???G??k6???D??ɳ:O??\\tuN?sB?\\u0013??P??:\'?9??\\tuN?sB?\\u0013??P??:\'?9??\\tuM???9?A]\",\"amount\":0,\"reference\":\"Q\\u000f2Y?x??9\'?9a?\\tsN?s\\u0013??0??9\'?9a?\\tsN?s\\u0013??0??9\'?9a?I2Wv?3??\\u0015??-W\\u0003߳????I?????\\tݐ>?????:??9?9??\\tuN?sB?\\u0013??P??:\'?9??\\tuN?sB?\\u0013??P??:\'?9??\\tuN?k?ԕ??\\f?b\\u0007-u?\\u001b\\u0014}q??u1\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:53:41',NULL),(900,4,'BankTransactions','24','DELETE','{\"id\":24,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"n??l%ՅW???oX\\u0011??\\b???????t??7?????\\/#_??\\/???_?V\'l??e??\\u0017܍?ϳ?Gf\\u0010|?R??)n?\\u0013?a????#????a?\\u000e?????[?Z\'l?\\u0014?????O]\\u0001\\u0010?\\rV߂qs??es??\\u0015S4??\\u001f{?:\'ׯp?l??\\u001f^q???7??1\\u0019?????s\\u001c??2U\\/????؎)z?[_?i?.knج?\\u0019 l?Tx???o?ͥ???U\\u001f?????j?????T?????|?<ށ???\\u000fw?\\u0016??t??\\u001bL1?id?\\u0002?????;\\u0017???\\u000eS]?-?\\u0018??g?\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:13:26+00:00\",\"modified\":\"2026-04-02T13:13:26+00:00\"}','2026-04-02 13:53:45',NULL),(901,4,'BankTransactions','36','CREATE','[]','2026-04-02 13:54:17',NULL),(902,4,'BankTransactions','37','CREATE','[]','2026-04-02 13:54:17',NULL),(903,4,'BankTransactions','36','DELETE','{\"id\":36,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"€~“Óº\\u0019ÐÊô\\u0018¸\\u0012óÇ¶ÖRVÖqO\\u000b*ž;PU)Sÿü¡b\\u001cß\\u0017àö\\u001a9ÊšÃÏ…?2 1‡“`éà¨’¦œ5l)NZïI\\u001fø\\f\\u001d¡½\\u0010¬\\u000fcp\\u001c’­sòDe\\u000e·¬¸ûFVî\\u0016ËÝ!ãÝh\\b¤ÕiÅ‡à½\\u0011ÍÙr3Õ³Ó%-Èu\\/]\\u0005×õ\\u0017\\\\ÊL\\u0015ªRàFÄ\\u0019\\u0015$\\u000bÔ\\u0011\\fÙŠì&À+ÞÖaK\\u000bX5½±iªúÙVÎ—\\u001c\\u0006ûI!\\b¯° SV\\tÚ†ú{eÕaOs\\u0006\\\"VæäGK9»\\u0003\\u0012\\u0002w Å©ï›K\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:54:17+00:00\",\"modified\":\"2026-04-02T13:54:17+00:00\"}','2026-04-02 13:54:31',NULL),(904,4,'BankTransactions','37','DELETE','{\"id\":37,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"¼÷ú\\u0017¤O\\u0007\\u0014ÙçïTªþ\\u0017ü+FÝ;ÛOù^ÊÀÀ?4ç_*Uÿ\\u000bþ\\u0015Xroû9y\\u001do‹8Ìú§Rõ\\\"Fíõ³7ÿŠ³o?uÿR¿aÖŸÕOýß}®c³œ¯\\u0016›áÙz2×“f:_m\\u000e–ñµ=ïô\\u000eÓ8Œùt¶{ÝÖëí»ì«§ºmë·ÝÕ\",\"amount\":0,\"reference\":\":Ü§ûûFÝºYlf1¶Ã\\/ÿÿ\\u0003PK\\u0003\\u0004\\u0014\\u0006\\b!u>™i“\\u0006Œ\\u001a\\u0013xl\\/theme\\/theme1.xmlìY[‹ÛF\\u0014~\\/ô?\\b½;¾I²½Ä\\u001blÙNÚì&!ë¤äql­ÉŽ4F3Þ\\t’<õ¥PHK_\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T13:54:17+00:00\",\"modified\":\"2026-04-02T13:54:17+00:00\"}','2026-04-02 13:54:31',NULL),(905,4,'BankTransactions','38','CREATE','[]','2026-04-02 14:00:56',NULL),(906,4,'BankTransactions','39','CREATE','[]','2026-04-02 14:00:56',NULL),(907,4,'BankTransactions','38','DELETE','{\"id\":38,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"€~“Óº\\u0019ÐÊô\\u0018¸\\u0012óÇ¶ÖRVÖqO\\u000b*ž;PU)Sÿü¡b\\u001cß\\u0017àö\\u001a9ÊšÃÏ…?2 1‡“`éà¨’¦œ5l)NZïI\\u001fø\\f\\u001d¡½\\u0010¬\\u000fcp\\u001c’­sòDe\\u000e·¬¸ûFVî\\u0016ËÝ!ãÝh\\b¤ÕiÅ‡à½\\u0011ÍÙr3Õ³Ó%-Èu\\/]\\u0005×õ\\u0017\\\\ÊL\\u0015ªRàFÄ\\u0019\\u0015$\\u000bÔ\\u0011\\fÙŠì&À+ÞÖaK\\u000bX5½±iªúÙVÎ—\\u001c\\u0006ûI!\\b¯° SV\\tÚ†ú{eÕaOs\\u0006\\\"VæäGK9»\\u0003\\u0012\\u0002w Å©ï›K\",\"amount\":0,\"reference\":null,\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T14:00:56+00:00\",\"modified\":\"2026-04-02T14:00:56+00:00\"}','2026-04-02 14:01:08',NULL),(908,4,'BankTransactions','39','DELETE','{\"id\":39,\"company_id\":1,\"bank_account_id\":17,\"date\":\"2026-04-02\",\"description\":\"¼÷ú\\u0017¤O\\u0007\\u0014ÙçïTªþ\\u0017ü+FÝ;ÛOù^ÊÀÀ?4ç_*Uÿ\\u000bþ\\u0015Xroû9y\\u001do‹8Ìú§Rõ\\\"Fíõ³7ÿŠ³o?uÿR¿aÖŸÕOýß}®c³œ¯\\u0016›áÙz2×“f:_m\\u000e–ñµ=ïô\\u000eÓ8Œùt¶{ÝÖëí»ì«§ºmë·ÝÕ\",\"amount\":0,\"reference\":\":Ü§ûûFÝºYlf1¶Ã\\/ÿÿ\\u0003PK\\u0003\\u0004\\u0014\\u0006\\b!u>™i“\\u0006Œ\\u001a\\u0013xl\\/theme\\/theme1.xmlìY[‹ÛF\\u0014~\\/ô?\\b½;¾I²½Ä\\u001blÙNÚì&!ë¤äql­ÉŽ4F3Þ\\t’<õ¥PHK_\",\"reconciled\":false,\"transaction_id\":null,\"created\":\"2026-04-02T14:00:56+00:00\",\"modified\":\"2026-04-02T14:00:56+00:00\"}','2026-04-02 14:01:08',NULL),(909,4,'Users','6','DELETE','{\"id\":6,\"email\":\"vondoldo@gmail.com\",\"role_id\":1,\"employee_id\":null,\"company_id\":1,\"department_id\":null}','2026-04-02 14:06:22',NULL),(910,4,'Users','7','DELETE','{\"id\":7,\"email\":\"user@hotmail.com\",\"role_id\":2,\"employee_id\":null,\"company_id\":1,\"department_id\":null}','2026-04-02 14:06:27',NULL);
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_trails`
--

DROP TABLE IF EXISTS `audit_trails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_trails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_type` varchar(151) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_trails`
--

LOCK TABLES `audit_trails` WRITE;
/*!40000 ALTER TABLE `audit_trails` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_trails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_rules`
--

DROP TABLE IF EXISTS `bank_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `match_text` varchar(151) NOT NULL,
  `account_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_rules`
--

LOCK TABLES `bank_rules` WRITE;
/*!40000 ALTER TABLE `bank_rules` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_transactions`
--

DROP TABLE IF EXISTS `bank_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `bank_account_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` float(15,2) NOT NULL,
  `reference` varchar(151) DEFAULT NULL,
  `reconciled` tinyint(1) NOT NULL DEFAULT 0,
  `transaction_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `reconciled` (`reconciled`),
  KEY `bank_account_id` (`bank_account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_transactions`
--

LOCK TABLES `bank_transactions` WRITE;
/*!40000 ALTER TABLE `bank_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill_items`
--

DROP TABLE IF EXISTS `bill_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` float NOT NULL,
  `line_total` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_items`
--

LOCK TABLES `bill_items` WRITE;
/*!40000 ALTER TABLE `bill_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `bill_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(151) NOT NULL,
  `currency` varchar(151) NOT NULL,
  `total` float NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
INSERT INTO `bills` VALUES (1,NULL,1,'2025-09-27','February Rentals','1',42,NULL);
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills_transactions`
--

DROP TABLE IF EXISTS `bills_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bills_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills_transactions`
--

LOCK TABLES `bills_transactions` WRITE;
/*!40000 ALTER TABLE `bills_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `budgets`
--

DROP TABLE IF EXISTS `budgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budgets`
--

LOCK TABLES `budgets` WRITE;
/*!40000 ALTER TABLE `budgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `budgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buildings`
--

DROP TABLE IF EXISTS `buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buildings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `address` varchar(151) NOT NULL,
  `investor_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `isvacant` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buildings`
--

LOCK TABLES `buildings` WRITE;
/*!40000 ALTER TABLE `buildings` DISABLE KEYS */;
INSERT INTO `buildings` VALUES (1,'Kuimbashiri','2328 mk 7',1,'2024-10-01 18:23:52',1),(2,'Senga Nehosho','1777',1,'2024-11-01 05:24:25',1);
/*!40000 ALTER TABLE `buildings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `claims`
--

DROP TABLE IF EXISTS `claims`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `claims` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `scheme` varchar(151) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date_of_accident` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `benefit_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `claims`
--

LOCK TABLES `claims` WRITE;
/*!40000 ALTER TABLE `claims` DISABLE KEYS */;
/*!40000 ALTER TABLE `claims` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `logo` longtext DEFAULT NULL,
  `reporting_currency` varchar(10) DEFAULT 'USD',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'NMC Engineers','Malborough','0773808900','noelmuzuva63@gmail.com',NULL,'USD','2026-03-28 20:25:18','2026-03-28 20:25:18');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `mobile` varchar(151) NOT NULL,
  `email` varchar(151) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (1,'Mavondo Erasmus','0772776179','mavondoe@nssa.org.zw',0),(2,'shonga','011234567','shonga@gmail.com',0),(3,'tasara','876654321','tasara@gmail.com',0),(4,'Muti','0773767123','muti@gmail.com',0);
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `address` varchar(151) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'vondoldo','3704 Tynwaldnorth, 3704',3,1),(2,'erasmusm software consultancy','1777 randolf senga',4,1);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deal_requests`
--

DROP TABLE IF EXISTS `deal_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deal_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `source` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `deal_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deal_requests`
--

LOCK TABLES `deal_requests` WRITE;
/*!40000 ALTER TABLE `deal_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `deal_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deals`
--

DROP TABLE IF EXISTS `deals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `description` varchar(151) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(151) NOT NULL,
  `value` decimal(10,0) NOT NULL,
  `stage` varchar(151) NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `status` varchar(151) NOT NULL,
  `submitted_by` int(11) DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deals`
--

LOCK TABLES `deals` WRITE;
/*!40000 ALTER TABLE `deals` DISABLE KEYS */;
INSERT INTO `deals` VALUES (15,'voxy','testing','2026-04-01','B2B',10000,'Qualification',NULL,'Pending Approval (Stage 1)',3,'2026-04-01 03:09:44',NULL,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `deals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deductions`
--

DROP TABLE IF EXISTS `deductions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deductions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `statutory` tinyint(1) NOT NULL,
  `tax_deductible` tinyint(1) NOT NULL,
  `calculation_type` varchar(151) NOT NULL,
  `account_id` int(11) NOT NULL,
  `zimra_mapping` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deductions`
--

LOCK TABLES `deductions` WRITE;
/*!40000 ALTER TABLE `deductions` DISABLE KEYS */;
INSERT INTO `deductions` VALUES (1,'Medical Aid',0,1,'Fixed',0,NULL),(2,'Pension Fund',0,1,'Percentage',0,NULL),(3,'Advance Repayment',0,0,'Fixed',0,NULL);
/*!40000 ALTER TABLE `deductions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `earnings`
--

DROP TABLE IF EXISTS `earnings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `earnings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `account_id` int(11) NOT NULL,
  `taxable` tinyint(1) NOT NULL,
  `pensionable` tinyint(1) NOT NULL,
  `nssa_applicable` tinyint(1) NOT NULL,
  `calculation_type` varchar(151) NOT NULL,
  `zimra_mapping` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `earnings`
--

LOCK TABLES `earnings` WRITE;
/*!40000 ALTER TABLE `earnings` DISABLE KEYS */;
INSERT INTO `earnings` VALUES (2,'Basic Salary',5,1,1,1,'Fixed','regular_earnings'),(3,'Transport Allowance',6,1,0,0,'Fixed','regular_earnings'),(4,'Housing Allowance',11,1,0,0,'Fixed Amount','regular_earnings'),(5,'COLA',5,1,0,0,'Fixed Amount',''),(6,'Covid',7,1,0,0,'Fixed Amount','regular_earnings');
/*!40000 ALTER TABLE `earnings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emails`
--

DROP TABLE IF EXISTS `emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `emailto` varchar(255) NOT NULL,
  `emailfrom` varchar(255) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emails`
--

LOCK TABLES `emails` WRITE;
/*!40000 ALTER TABLE `emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_profiles`
--

DROP TABLE IF EXISTS `employee_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `employee_id_number` varchar(100) DEFAULT NULL,
  `tax_number` varchar(100) DEFAULT NULL,
  `social_security_number` varchar(100) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `employee_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_profiles`
--

LOCK TABLES `employee_profiles` WRITE;
/*!40000 ALTER TABLE `employee_profiles` DISABLE KEYS */;
INSERT INTO `employee_profiles` VALUES (1,2,'27-128064A27','2009765431','2100975T','2000-01-01','2026-03-07 09:24:07','2026-03-07 09:24:07');
/*!40000 ALTER TABLE `employee_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_code` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `nssa_number` int(11) NOT NULL,
  `tax_number` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `basic_salary` decimal(15,2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `national_identity` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `is_blind` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_code` (`employee_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'9000','Tasara','Shonga',20001234,20001234,'2000-01-01',1,'Manager',2000.00,'2026-03-08 11:55:02','2026-03-08 12:24:02','12-278065A29',1,0),(2,'50098','era','hama',123456,70987653,'2020-01-01',1,'Manager',600.00,'2026-03-14 02:36:48','2026-03-14 02:36:48','12-278065B27',1,0),(3,'esc_10001','Celine','Mavondo',2023121,200001234,'2005-07-17',0,'Manager',1999.97,'2026-03-28 13:39:38','2026-03-28 13:39:38','29-1254277Q29',2,0),(4,'emp-10002','Tasara','Shonga',12345678,200097654,'2026-03-01',1,'Accountant',1536.99,'2026-03-29 13:36:37','2026-03-29 13:36:37','123',1,0),(5,'emp-11001','test','testing',123789,234567,'2026-03-01',0,'Accountant',2000.00,'2026-03-30 17:08:03','2026-03-30 17:08:03','2345678',1,1),(6,'emp-11003','Lyeonn','Manyara',101,2678,'2006-06-16',0,'Software Intern',10000.00,'2026-03-31 19:04:47','2026-03-31 19:04:47','29-2005870J27',1,0);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrolments`
--

DROP TABLE IF EXISTS `enrolments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrolments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `rate` decimal(10,0) NOT NULL,
  `status` varchar(151) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrolments`
--

LOCK TABLES `enrolments` WRITE;
/*!40000 ALTER TABLE `enrolments` DISABLE KEYS */;
INSERT INTO `enrolments` VALUES (1,1,2,'2024-11-01 21:47:04','2024-12-07 21:47:12',500,'1'),(2,1,3,'2024-11-01 05:22:12','2024-12-31 05:22:17',800,'1'),(3,1,1,'2025-02-01 05:22:58','2026-12-31 05:23:09',500,'1');
/*!40000 ALTER TABLE `enrolments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exchange_rates`
--

DROP TABLE IF EXISTS `exchange_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exchange_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `rate_to_base` decimal(18,8) NOT NULL,
  `date` date NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exchange_rates`
--

LOCK TABLES `exchange_rates` WRITE;
/*!40000 ALTER TABLE `exchange_rates` DISABLE KEYS */;
/*!40000 ALTER TABLE `exchange_rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inspections`
--

DROP TABLE IF EXISTS `inspections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inspections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pobs_insurable` float NOT NULL,
  `apwcs_insurable` float NOT NULL,
  `apwcs_penalty` float NOT NULL,
  `inspector_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inspections`
--

LOCK TABLES `inspections` WRITE;
/*!40000 ALTER TABLE `inspections` DISABLE KEYS */;
/*!40000 ALTER TABLE `inspections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inspectors`
--

DROP TABLE IF EXISTS `inspectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inspectors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `grade` varchar(151) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inspectors`
--

LOCK TABLES `inspectors` WRITE;
/*!40000 ALTER TABLE `inspectors` DISABLE KEYS */;
/*!40000 ALTER TABLE `inspectors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `investors`
--

DROP TABLE IF EXISTS `investors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `investors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `investors`
--

LOCK TABLES `investors` WRITE;
/*!40000 ALTER TABLE `investors` DISABLE KEYS */;
INSERT INTO `investors` VALUES (1,'vondoldo',1),(2,'Shonga',2),(3,'Tasara',3);
/*!40000 ALTER TABLE `investors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invitations`
--

DROP TABLE IF EXISTS `invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invitations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invitations`
--

LOCK TABLES `invitations` WRITE;
/*!40000 ALTER TABLE `invitations` DISABLE KEYS */;
INSERT INTO `invitations` VALUES (1,'mavondoe@nssa.org.zw',1,3,'6c3c2873-9759-40dd-83ed-877f0364a397','accepted','2026-04-01 03:24:14','2026-04-01 03:31:56');
/*!40000 ALTER TABLE `invitations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` float NOT NULL,
  `line_total` float NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_items`
--

LOCK TABLES `invoice_items` WRITE;
/*!40000 ALTER TABLE `invoice_items` DISABLE KEYS */;
INSERT INTO `invoice_items` VALUES (1,1,2,7,6,42,NULL),(2,2,2,6,8,48,NULL),(3,3,2,7,8,56,NULL),(4,4,2,7,9,63,NULL),(5,5,2,7,8,56,NULL),(6,6,4,5,6,30,NULL),(7,8,4,8,5,40,NULL),(8,9,4,8,5,40,NULL),(9,10,4,8,5,40,NULL),(10,11,4,8,5,40,NULL),(11,13,2,6,6,36,NULL),(12,15,2,9,9,81,NULL),(13,17,2,10,70,700,NULL),(14,19,1,80,1500,138000,1),(15,20,1,1,1500,1725,1),(16,20,1,1,5000,5000,2),(17,21,1,2,1500,3450,1),(18,21,1,2,5000,10000,2),(19,19,1,1,5000,5000,2),(20,20,1,4,1500,6900,1),(21,21,1,60,1500,103500,1),(22,22,1,1,1500,1725,1),(23,23,8,1,1500,1732.5,1),(24,23,1,2,5000,10000,2),(25,24,8,2,1500,3465,1);
/*!40000 ALTER TABLE `invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `currency` varchar(151) NOT NULL,
  `description` varchar(151) NOT NULL,
  `status` varchar(151) NOT NULL,
  `total` float NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (7,'2025-10-09',0,'USD','Revenue for Invoice Item ID: 6','',0,1,NULL),(12,'2025-10-05',0,'USD','Revenue for Invoice Item ID: 10','',0,1,NULL),(24,'2026-03-28',2,'USD','testing','1',3465,NULL,NULL);
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices_transactions`
--

DROP TABLE IF EXISTS `invoices_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices_transactions`
--

LOCK TABLES `invoices_transactions` WRITE;
/*!40000 ALTER TABLE `invoices_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_applications`
--

DROP TABLE IF EXISTS `leave_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `days_requested` decimal(5,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `leave_type_id` (`leave_type_id`),
  CONSTRAINT `leave_applications_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `leave_applications_ibfk_2` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_applications`
--

LOCK TABLES `leave_applications` WRITE;
/*!40000 ALTER TABLE `leave_applications` DISABLE KEYS */;
/*!40000 ALTER TABLE `leave_applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_balances`
--

DROP TABLE IF EXISTS `leave_balances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_balances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `days_entitled` decimal(5,2) NOT NULL DEFAULT 0.00,
  `days_taken` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_id` (`employee_id`,`leave_type_id`,`year`),
  KEY `leave_type_id` (`leave_type_id`),
  CONSTRAINT `leave_balances_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `leave_balances_ibfk_2` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_balances`
--

LOCK TABLES `leave_balances` WRITE;
/*!40000 ALTER TABLE `leave_balances` DISABLE KEYS */;
/*!40000 ALTER TABLE `leave_balances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_types`
--

DROP TABLE IF EXISTS `leave_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `default_days_per_year` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_types`
--

LOCK TABLES `leave_types` WRITE;
/*!40000 ALTER TABLE `leave_types` DISABLE KEYS */;
INSERT INTO `leave_types` VALUES (1,'Vacation','Vacation Leave',22,1,'2026-03-15 12:23:25','2026-03-15 12:23:25'),(2,'Sick Leave','Sick Leave',90,1,'2026-03-15 12:23:51','2026-03-15 12:23:51'),(3,'Compassionate Leave','Compassionate Leave',5,1,'2026-03-15 12:24:21','2026-03-15 12:24:21'),(4,'Study Leave','Study Leave',8,1,'2026-03-15 12:24:49','2026-03-15 12:24:49');
/*!40000 ALTER TABLE `leave_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meetings`
--

DROP TABLE IF EXISTS `meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meetings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `agenda` varchar(151) NOT NULL,
  `outcomes` varchar(151) NOT NULL,
  `attachments` varchar(151) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meetings`
--

LOCK TABLES `meetings` WRITE;
/*!40000 ALTER TABLE `meetings` DISABLE KEYS */;
/*!40000 ALTER TABLE `meetings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'Loans Management','Loans',0,NULL,'2026-03-28 13:32:06',NULL),(2,'Chart of Accounts','Accounts',1,NULL,'2026-03-28 20:17:45',NULL),(3,'Employees','Employees',1,NULL,'2026-03-31 03:43:20',NULL),(4,'CRM','Customers',0,NULL,'2026-03-21 17:04:01',NULL),(5,'Payslips','Payslips',1,'2026-03-21 18:32:04','2026-03-21 18:32:04',NULL),(6,'Contacts','Contacts',1,'2026-03-21 18:32:32','2026-03-21 18:32:32',NULL),(7,'Admin','Users',0,'2026-03-21 18:33:08','2026-03-21 18:33:44',NULL),(9,'Deals','Deals',1,'2026-03-22 03:56:02','2026-03-22 03:56:02',NULL),(10,'Meetings','Meetings',1,'2026-03-22 03:57:26','2026-03-22 03:57:26',NULL),(11,'Audit Trails','AuditTrails',0,'2026-03-28 13:23:02','2026-03-28 13:33:59',NULL),(12,'Customers','Customers',1,'2026-03-28 13:23:27','2026-03-28 13:23:27',NULL),(13,'Emp Profiles','EmployeeProfiles',1,'2026-03-28 13:23:55','2026-03-28 13:23:55',NULL),(14,'Companies-Tenants','Companies',1,'2026-03-28 13:24:20','2026-03-28 13:24:20',NULL),(15,'Tax Tables','TaxTables',1,'2026-03-28 13:24:57','2026-03-28 13:24:57',NULL),(16,'Earnings','Earnings',1,'2026-03-28 13:25:34','2026-03-28 13:25:34',NULL),(17,'Deductions','Deductions',1,'2026-03-28 13:25:50','2026-03-28 13:25:50',NULL),(18,'Products','Products',1,'2026-03-28 13:26:27','2026-03-28 13:26:27',NULL),(19,'Invoices','Invoices',1,'2026-03-28 13:26:52','2026-03-28 13:26:52',NULL),(20,'Settings','Settings',1,'2026-03-28 13:27:42','2026-03-28 13:27:42',NULL),(21,'Transactions','Transactions',1,'2026-03-28 16:46:11','2026-03-28 16:46:11',NULL),(22,'Payperiods','PayPeriods',1,'2026-03-28 20:22:17','2026-03-28 20:22:17',NULL),(23,'Bank Transactions','BankTransactions',1,'2026-03-30 19:02:51','2026-03-30 19:02:51',1),(24,'events','Events',1,'2026-03-31 18:52:09','2026-03-31 18:52:09',1),(25,'Invitations','Invitations',1,'2026-04-01 03:23:36','2026-04-01 03:23:36',1),(26,'Approval Flows','ApprovalFlows',1,'2026-04-01 03:42:51','2026-04-01 03:42:51',1),(27,'Deal Requests','DealRequests',1,'2026-04-01 04:00:07','2026-04-01 04:00:07',1);
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pay_periods`
--

DROP TABLE IF EXISTS `pay_periods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pay_periods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(8) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pay_periods`
--

LOCK TABLES `pay_periods` WRITE;
/*!40000 ALTER TABLE `pay_periods` DISABLE KEYS */;
INSERT INTO `pay_periods` VALUES (1,'jan/2026','2026-01-01','2026-01-31','draft'),(2,'feb/2026','2026-02-01','2026-02-28','draft'),(3,'mar/2026','2026-03-01','2026-03-31','draft'),(4,'Apr/2026','2026-04-01','2026-04-30','draft'),(5,'May/2026','2026-05-01','2026-05-31','draft'),(6,'May/2026','2026-05-01','2026-05-31','draft'),(7,'May/2025','2025-05-01','2025-05-31','draft'),(8,'Jun/2025','2025-06-01','2025-06-30','draft');
/*!40000 ALTER TABLE `pay_periods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payroll_components`
--

DROP TABLE IF EXISTS `payroll_components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payroll_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('EARNING','DEDUCTION') NOT NULL,
  `calculation_type` enum('FIXED_AMOUNT','PERCENTAGE_OF_BASIC') NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `is_statutory` tinyint(1) DEFAULT 0,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payroll_components`
--

LOCK TABLES `payroll_components` WRITE;
/*!40000 ALTER TABLE `payroll_components` DISABLE KEYS */;
INSERT INTO `payroll_components` VALUES (1,'Transport Allowance','EARNING','FIXED_AMOUNT',1.00,1,'2026-03-07 10:34:56','2026-03-07 10:43:56'),(2,'basic_salary','EARNING','FIXED_AMOUNT',1.00,0,'2026-03-08 03:16:32','2026-03-08 03:16:32'),(3,'bonus','EARNING','PERCENTAGE_OF_BASIC',1.00,0,'2026-03-08 03:16:57','2026-03-08 03:16:57'),(4,'overtime 1.5','EARNING','PERCENTAGE_OF_BASIC',1.50,0,'2026-03-08 03:17:23','2026-03-08 03:17:23'),(5,'overtime 2.0','EARNING','PERCENTAGE_OF_BASIC',2.00,0,'2026-03-08 03:17:51','2026-03-08 03:17:51'),(6,'NSSA_ee','DEDUCTION','PERCENTAGE_OF_BASIC',1.00,0,'2026-03-08 03:19:30','2026-03-08 03:19:30'),(7,'pension','DEDUCTION','PERCENTAGE_OF_BASIC',0.10,0,'2026-03-08 03:19:52','2026-03-08 03:19:52');
/*!40000 ALTER TABLE `payroll_components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payroll_record_items`
--

DROP TABLE IF EXISTS `payroll_record_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payroll_record_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payroll_record_id` int(11) NOT NULL,
  `payroll_component_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `payroll_record_id` (`payroll_record_id`),
  KEY `payroll_component_id` (`payroll_component_id`),
  CONSTRAINT `payroll_record_items_ibfk_1` FOREIGN KEY (`payroll_record_id`) REFERENCES `payroll_records` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payroll_record_items_ibfk_2` FOREIGN KEY (`payroll_component_id`) REFERENCES `payroll_components` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payroll_record_items`
--

LOCK TABLES `payroll_record_items` WRITE;
/*!40000 ALTER TABLE `payroll_record_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `payroll_record_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payroll_records`
--

DROP TABLE IF EXISTS `payroll_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payroll_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `salary_structure_id` int(11) NOT NULL,
  `payroll_month` varchar(10) NOT NULL,
  `base_salary_amount` decimal(15,2) NOT NULL,
  `total_earnings` decimal(15,2) DEFAULT 0.00,
  `total_deductions` decimal(15,2) DEFAULT 0.00,
  `net_pay` decimal(15,2) NOT NULL,
  `status` enum('DRAFT','APPROVED','PAID') DEFAULT 'DRAFT',
  `currency` varchar(3) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `salary_structure_id` (`salary_structure_id`),
  CONSTRAINT `payroll_records_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payroll_records_ibfk_2` FOREIGN KEY (`salary_structure_id`) REFERENCES `salary_structures` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payroll_records`
--

LOCK TABLES `payroll_records` WRITE;
/*!40000 ALTER TABLE `payroll_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `payroll_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payroll_runs`
--

DROP TABLE IF EXISTS `payroll_runs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payroll_runs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `currency` varchar(151) NOT NULL,
  `status` varchar(151) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payroll_runs`
--

LOCK TABLES `payroll_runs` WRITE;
/*!40000 ALTER TABLE `payroll_runs` DISABLE KEYS */;
/*!40000 ALTER TABLE `payroll_runs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payslip_items`
--

DROP TABLE IF EXISTS `payslip_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payslip_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payslip_id` int(11) NOT NULL,
  `item_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(10,6) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'ZWG',
  `is_permanent` tinyint(1) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=339 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payslip_items`
--

LOCK TABLES `payslip_items` WRITE;
/*!40000 ALTER TABLE `payslip_items` DISABLE KEYS */;
INSERT INTO `payslip_items` VALUES (162,18,'Earning','Basic Salary',2000.000000,'ZWG',1,NULL),(163,18,'Tax','NSSA',0.000000,'ZWG',0,NULL),(164,18,'Tax','Pension',0.000000,'ZWG',0,NULL),(165,18,'Tax','PAYE',0.000000,'ZWG',0,NULL),(166,18,'Tax','Aids Levy',0.000000,'ZWG',0,NULL),(167,18,'Company Contribution','ZIMDEF',0.000000,'ZWG',0,NULL),(168,18,'Company Contribution','SDF',0.000000,'ZWG',0,NULL),(169,19,'Earning','Basic Salary',2000.000000,'ZWG',1,NULL),(170,19,'Tax','NSSA',90.000000,'ZWG',0,NULL),(171,19,'Tax','Pension',200.000000,'ZWG',0,NULL),(172,19,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,NULL),(173,19,'Company Contribution','SDF',10.000000,'ZWG',0,NULL),(174,20,'Earning','Basic Salary',2000.000000,'ZWG',1,NULL),(175,20,'Tax','NSSA',90.000000,'ZWG',0,NULL),(176,20,'Tax','Pension',200.000000,'ZWG',0,NULL),(177,20,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,NULL),(178,20,'Company Contribution','SDF',10.000000,'ZWG',0,NULL),(179,18,'Tax','NSSA',0.000000,'ZWG',0,NULL),(180,18,'Tax','Pension',0.000000,'ZWG',0,NULL),(181,18,'Company Contribution','ZIMDEF',0.000000,'ZWG',0,NULL),(182,18,'Company Contribution','SDF',0.000000,'ZWG',0,NULL),(183,21,'Earning','Basic Salary',2000.000000,'ZWG',1,NULL),(184,21,'Tax','NSSA',90.000000,'ZWG',0,NULL),(185,21,'Tax','Pension',200.000000,'ZWG',0,NULL),(186,21,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,NULL),(187,21,'Company Contribution','SDF',10.000000,'ZWG',0,NULL),(188,22,'Earning','Basic Salary',2000.000000,'ZWG',1,NULL),(189,22,'Tax','NSSA',90.000000,'ZWG',0,NULL),(190,22,'Tax','Pension',200.000000,'ZWG',0,NULL),(191,22,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,NULL),(192,22,'Company Contribution','SDF',10.000000,'ZWG',0,NULL),(193,23,'Earning','Basic Salary',2000.000000,'ZWG',1,NULL),(194,23,'Tax','NSSA',90.000000,'ZWG',0,NULL),(195,23,'Tax','Pension',200.000000,'ZWG',0,NULL),(196,23,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,NULL),(197,23,'Company Contribution','SDF',10.000000,'ZWG',0,NULL),(198,24,'Earning','Basic Salary',2000.000000,'ZWG',1,NULL),(199,24,'Tax','NSSA',90.000000,'ZWG',0,NULL),(200,24,'Tax','Pension',200.000000,'ZWG',0,NULL),(201,24,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,NULL),(202,24,'Company Contribution','SDF',10.000000,'ZWG',0,NULL),(203,25,'Earning','Basic Salary',2000.000000,'ZWG',1,NULL),(204,25,'Tax','NSSA',90.000000,'ZWG',0,NULL),(205,25,'Tax','Pension',200.000000,'ZWG',0,NULL),(206,25,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,NULL),(207,25,'Company Contribution','SDF',10.000000,'ZWG',0,NULL),(208,18,'Tax','NSSA',90.000000,'ZWG',0,NULL),(209,18,'Tax','Pension',200.000000,'ZWG',0,NULL),(210,18,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,NULL),(211,18,'Company Contribution','SDF',10.000000,'ZWG',0,NULL),(212,26,'Earning','Basic Salary',2000.000000,'ZWG',1,1),(213,26,'Tax','NSSA',90.000000,'ZWG',0,1),(214,26,'Tax','Pension',200.000000,'ZWG',0,1),(215,26,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,1),(216,26,'Company Contribution','SDF',10.000000,'ZWG',0,1),(217,27,'Earning','Basic Salary',1537.000000,'USD',1,1),(218,27,'Earning','Transport Allowance',184.000000,'USD',1,1),(219,27,'Earning','Basic Salary',9999.999999,'ZWG',1,1),(220,27,'Earning','Covid',84.000000,'USD',0,1),(221,27,'Tax','NSSA',20.090000,'USD',0,1),(222,27,'Tax','Pension',163.410000,'USD',0,1),(223,27,'Tax','PAYE',369.910000,'USD',0,1),(224,27,'Tax','Aids Levy',11.100000,'USD',0,1),(225,27,'Company Contribution','ZIMDEF',18.050000,'USD',0,1),(226,27,'Company Contribution','SDF',9.030000,'USD',0,1),(227,27,'Tax','NSSA',305.980000,'ZWG',0,1),(228,27,'Tax','Pension',2488.680000,'ZWG',0,1),(229,27,'Tax','PAYE',5633.650000,'ZWG',0,1),(230,27,'Tax','Aids Levy',169.020000,'ZWG',0,1),(231,27,'Company Contribution','ZIMDEF',274.900000,'ZWG',0,1),(232,27,'Company Contribution','SDF',137.450000,'ZWG',0,1),(233,28,'Earning','Covid',84.000000,'USD',0,1),(234,28,'Earning','Basic Salary',1537.000000,'USD',1,1),(235,28,'Earning','Transport Allowance',184.000000,'USD',1,1),(236,28,'Earning','Basic Salary',9999.999999,'ZWG',1,1),(237,28,'Tax','NSSA',19.570000,'USD',0,1),(238,28,'Tax','Pension',163.850000,'USD',0,1),(239,28,'Tax','PAYE',374.170000,'USD',0,1),(240,28,'Tax','Aids Levy',11.220000,'USD',0,1),(241,28,'Company Contribution','ZIMDEF',18.050000,'USD',0,1),(242,28,'Company Contribution','SDF',9.030000,'USD',0,1),(243,28,'Tax','NSSA',298.130000,'ZWG',0,1),(244,28,'Tax','Pension',2495.360000,'ZWG',0,1),(245,28,'Tax','PAYE',5698.600000,'ZWG',0,1),(246,28,'Tax','Aids Levy',170.930000,'ZWG',0,1),(247,28,'Company Contribution','ZIMDEF',274.900000,'ZWG',0,1),(248,28,'Company Contribution','SDF',137.450000,'ZWG',0,1),(249,29,'Earning','Basic Salary',1537.000000,'USD',1,1),(250,29,'Earning','Transport Allowance',84.000000,'USD',1,1),(251,29,'Earning','Covid',144.000000,'USD',1,1),(252,29,'Earning','Basic Salary',9999.999999,'ZWG',1,1),(253,30,'Earning','Basic Salary',1537.000000,'USD',1,1),(254,30,'Earning','Transport Allowance',84.000000,'USD',1,1),(255,30,'Earning','Covid',144.000000,'USD',1,1),(256,30,'Earning','Basic Salary',9999.999999,'ZWG',1,1),(257,30,'Tax','NSSA',19.410000,'USD',0,1),(258,30,'Tax','Pension',162.450000,'USD',0,1),(259,30,'Tax','PAYE',362.860000,'USD',0,1),(260,30,'Tax','Aids Levy',10.890000,'USD',0,1),(261,30,'Company Contribution','ZIMDEF',17.650000,'USD',0,1),(262,30,'Company Contribution','SDF',8.830000,'USD',0,1),(263,30,'Tax','NSSA',302.290000,'ZWG',0,1),(264,30,'Tax','Pension',2530.200000,'ZWG',0,1),(265,30,'Tax','PAYE',5651.500000,'ZWG',0,1),(266,30,'Tax','Aids Levy',169.570000,'ZWG',0,1),(267,30,'Company Contribution','ZIMDEF',274.900000,'ZWG',0,1),(268,30,'Company Contribution','SDF',137.450000,'ZWG',0,1),(269,31,'Earning','Basic Salary',2000.000000,'ZWG',1,1),(270,31,'Tax','NSSA',90.000000,'ZWG',0,1),(271,31,'Tax','Pension',200.000000,'ZWG',0,1),(272,31,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,1),(273,31,'Company Contribution','SDF',10.000000,'ZWG',0,1),(274,32,'Earning','Basic Salary',2000.000000,'ZWG',1,1),(275,32,'Earning','Basic Salary',1537.000000,'USD',1,1),(276,32,'Earning','Transport Allowance',84.000000,'USD',1,1),(277,32,'Earning','Covid',144.000000,'USD',1,1),(278,32,'Earning','Basic Salary',9999.999999,'ZWG',1,1),(279,32,'Tax','NSSA',4.040000,'USD',0,1),(280,32,'Tax','Pension',173.580000,'USD',0,1),(281,32,'Tax','PAYE',566.640000,'USD',0,1),(282,32,'Tax','Aids Levy',17.000000,'USD',0,1),(283,32,'Company Contribution','ZIMDEF',17.650000,'USD',0,1),(284,32,'Company Contribution','SDF',8.830000,'USD',0,1),(285,32,'Tax','NSSA',27.460000,'ZWG',0,1),(286,32,'Tax','Pension',1180.120000,'ZWG',0,1),(287,32,'Tax','PAYE',3852.490000,'ZWG',0,1),(288,32,'Tax','Aids Levy',115.570000,'ZWG',0,1),(289,32,'Company Contribution','ZIMDEF',120.000000,'ZWG',0,1),(290,32,'Company Contribution','SDF',60.000000,'ZWG',0,1),(291,33,'Earning','Basic Salary',2000.000000,'ZWG',1,1),(292,33,'Earning','Basic Salary',9999.999999,'USD',1,1),(293,33,'Deduction','Medical Aid',50.000000,'ZWG',1,1),(294,33,'Deduction','Medical Aid',100.000000,'USD',1,1),(295,33,'Tax','NSSA',31.500000,'USD',0,1),(296,33,'Tax','Pension',9999.999999,'USD',0,1),(297,33,'Tax','PAYE',9999.999999,'USD',0,1),(298,33,'Tax','Aids Levy',4200.090000,'USD',0,1),(299,33,'Company Contribution','ZIMDEF',4000.000000,'USD',0,1),(300,33,'Company Contribution','SDF',2000.000000,'USD',0,1),(301,33,'Tax','NSSA',0.160000,'ZWG',0,1),(302,33,'Tax','Pension',200.000000,'ZWG',0,1),(303,33,'Tax','PAYE',700.010000,'ZWG',0,1),(304,33,'Tax','Aids Levy',21.000000,'ZWG',0,1),(305,33,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,1),(306,33,'Company Contribution','SDF',10.000000,'ZWG',0,1),(307,34,'Earning','Basic Salary',2000.000000,'ZWG',1,1),(308,34,'Earning','Basic Salary',9999.999999,'USD',1,1),(309,34,'Deduction','Medical Aid',50.000000,'ZWG',1,1),(310,34,'Deduction','Medical Aid',100.000000,'USD',1,1),(311,34,'Tax','NSSA',31.300000,'USD',0,1),(312,34,'Tax','Pension',1000.000000,'USD',0,1),(313,34,'Tax','PAYE',3115.400000,'USD',0,1),(314,34,'Tax','Aids Levy',93.470000,'USD',0,1),(315,34,'Company Contribution','ZIMDEF',100.000000,'USD',0,1),(316,34,'Company Contribution','SDF',50.000000,'USD',0,1),(317,34,'Tax','NSSA',6.260000,'ZWG',0,1),(318,34,'Tax','Pension',200.000000,'ZWG',0,1),(319,34,'Tax','PAYE',623.080000,'ZWG',0,1),(320,34,'Tax','Aids Levy',18.690000,'ZWG',0,1),(321,34,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,1),(322,34,'Company Contribution','SDF',10.000000,'ZWG',0,1),(323,35,'Earning','Basic Salary',2000.000000,'ZWG',1,1),(324,35,'Earning','Basic Salary',9999.999999,'USD',1,1),(325,35,'Deduction','Medical Aid',50.000000,'ZWG',1,1),(326,35,'Deduction','Medical Aid',100.000000,'USD',1,1),(327,35,'Tax','NSSA',31.300000,'USD',0,1),(328,35,'Tax','Pension',1000.000000,'USD',0,1),(329,35,'Tax','PAYE',3115.400000,'USD',0,1),(330,35,'Tax','Aids Levy',93.470000,'USD',0,1),(331,35,'Company Contribution','ZIMDEF',100.000000,'USD',0,1),(332,35,'Company Contribution','SDF',50.000000,'USD',0,1),(333,35,'Tax','NSSA',6.260000,'ZWG',0,1),(334,35,'Tax','Pension',200.000000,'ZWG',0,1),(335,35,'Tax','PAYE',623.080000,'ZWG',0,1),(336,35,'Tax','Aids Levy',18.690000,'ZWG',0,1),(337,35,'Company Contribution','ZIMDEF',20.000000,'ZWG',0,1),(338,35,'Company Contribution','SDF',10.000000,'ZWG',0,1);
/*!40000 ALTER TABLE `payslip_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payslips`
--

DROP TABLE IF EXISTS `payslips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payslips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `pay_period_id` int(11) NOT NULL,
  `gross_pay` decimal(15,2) NOT NULL,
  `deductions` decimal(15,2) DEFAULT 0.00,
  `net_pay` decimal(15,2) NOT NULL,
  `exchange_rate` decimal(15,4) NOT NULL DEFAULT 1.0000,
  `generated_date` date NOT NULL,
  `basic_salary` decimal(10,6) NOT NULL,
  `allowances` decimal(10,6) NOT NULL,
  `bonuses` decimal(10,6) NOT NULL,
  `overtime` decimal(10,6) NOT NULL,
  `benefits` decimal(10,6) NOT NULL,
  `pension` decimal(10,6) NOT NULL,
  `nssa` decimal(10,6) NOT NULL,
  `medical_aid` decimal(10,6) NOT NULL,
  `medical_expenses` decimal(10,6) NOT NULL,
  `taxable_income` decimal(10,6) NOT NULL,
  `paye` decimal(10,6) NOT NULL,
  `tax_credits` decimal(10,6) NOT NULL,
  `aids_levy` decimal(10,6) NOT NULL,
  `total_tax` decimal(10,6) NOT NULL,
  `usd_gross` decimal(15,2) NOT NULL DEFAULT 0.00,
  `usd_deductions` decimal(15,2) NOT NULL DEFAULT 0.00,
  `usd_net` decimal(15,2) NOT NULL DEFAULT 0.00,
  `zwg_gross` decimal(15,2) NOT NULL DEFAULT 0.00,
  `zwg_deductions` decimal(15,2) NOT NULL DEFAULT 0.00,
  `zwg_net` decimal(15,2) NOT NULL DEFAULT 0.00,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `pay_period_id` (`pay_period_id`),
  CONSTRAINT `payslips_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `payslips_ibfk_2` FOREIGN KEY (`pay_period_id`) REFERENCES `pay_periods` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payslips`
--

LOCK TABLES `payslips` WRITE;
/*!40000 ALTER TABLE `payslips` DISABLE KEYS */;
INSERT INTO `payslips` VALUES (18,3,1,74.58,10.81,63.76,26.8179,'2026-03-28',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.00,0.00,0.00,2000.00,290.00,1710.00,NULL),(19,3,2,74.58,10.81,63.76,26.8179,'2026-03-28',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.00,0.00,0.00,2000.00,290.00,1710.00,NULL),(20,3,3,74.58,10.81,63.76,26.8179,'2026-03-28',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.00,0.00,0.00,2000.00,290.00,1710.00,NULL),(21,3,4,80.00,11.60,68.40,25.0000,'2026-03-28',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.00,0.00,0.00,2000.00,290.00,1710.00,NULL),(22,3,5,76.92,11.15,65.77,26.0000,'2026-03-28',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.00,0.00,0.00,2000.00,290.00,1710.00,NULL),(23,3,6,80.00,11.60,68.40,24.9999,'2026-03-28',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.00,0.00,0.00,2000.00,290.00,1710.00,NULL),(24,3,7,80.00,11.60,68.40,25.0000,'2026-03-28',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.00,0.00,0.00,2000.00,290.00,1710.00,NULL),(25,3,8,76.92,11.15,65.77,25.9999,'2026-03-28',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.00,0.00,0.00,2000.00,290.00,1710.00,NULL),(26,1,7,74.58,10.81,63.76,26.8179,'2026-03-29',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.00,0.00,0.00,2000.00,290.00,1710.00,1),(27,4,1,2830.06,885.09,1944.97,26.8179,'2026-03-29',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,1805.00,564.51,1240.49,27490.00,8597.33,18892.67,1),(28,4,8,2904.60,915.33,1989.27,25.0000,'2026-03-30',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,1805.00,568.81,1236.19,27490.01,8663.02,18826.99,1),(29,4,7,2864.60,0.00,2864.60,25.0000,'2026-03-30',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,1765.00,0.00,1765.00,27490.00,0.00,27490.00,1),(30,4,6,2864.60,901.75,1962.85,25.0000,'2026-03-30',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,1765.00,555.61,1209.39,27490.00,8653.56,18836.44,1),(31,5,2,76.92,11.15,65.77,26.0000,'2026-03-31',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.00,0.00,0.00,2000.00,290.00,1710.00,1),(32,4,2,13765.00,5936.90,7828.10,1.0000,'2026-03-31',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,1765.00,761.26,1003.74,12000.00,5175.64,6824.36,1),(33,6,1,400062.50,184364.94,215697.56,32.0000,'2026-01-31',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,400000.00,184334.59,215665.41,2000.00,971.17,1028.83,1),(34,6,2,10062.50,4368.23,5694.27,32.0000,'2026-02-28',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,10000.00,4340.17,5659.83,2000.00,898.03,1101.97,1),(35,6,3,10062.50,4368.23,5694.27,31.9999,'2026-03-31',0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,10000.00,4340.17,5659.83,2000.00,898.03,1101.97,1);
/*!40000 ALTER TABLE `payslips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `model` varchar(100) NOT NULL,
  `can_create` tinyint(1) DEFAULT 0,
  `can_read` tinyint(1) DEFAULT 0,
  `can_update` tinyint(1) DEFAULT 0,
  `can_delete` tinyint(1) DEFAULT 0,
  `can_approve` tinyint(1) DEFAULT 0,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phinxlog`
--

DROP TABLE IF EXISTS `phinxlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phinxlog`
--

LOCK TABLES `phinxlog` WRITE;
/*!40000 ALTER TABLE `phinxlog` DISABLE KEYS */;
INSERT INTO `phinxlog` VALUES (20251008191232,'Customerid','2025-10-08 19:22:00','2025-10-08 19:22:00',0),(20251021131945,'Userrole','2025-10-21 13:37:25','2025-10-21 13:37:25',0),(20251021132639,'Migrate','2025-10-21 13:37:25','2025-10-21 13:37:25',0),(20260308080148,'AddDetailsToPayslips','2026-03-08 08:02:05','2026-03-08 08:02:05',0),(20260309194222,'CreatePayslipItems','2026-03-09 19:42:36','2026-03-09 19:42:37',0),(20260312200000,'CreateSettings','2026-03-12 19:59:18','2026-03-12 19:59:18',0),(20260312200100,'InsertZimSampleData','2026-03-12 19:59:18','2026-03-12 19:59:18',0),(20260315104536,'AddIsPermanentToPayslipItems','2026-03-15 10:47:26','2026-03-15 10:47:26',0),(20260315110944,'AddMulticurrencyToPayslips','2026-03-15 11:15:55','2026-03-15 11:15:55',0),(20260315111122,'CreateLeaveManagement','2026-03-15 11:15:55','2026-03-15 11:15:56',0),(20260315114722,'AddAccountIdToDeductions','2026-03-15 11:47:34','2026-03-15 11:47:34',0),(20260324180237,'CreateProducts','2026-03-24 18:25:47','2026-03-24 18:25:47',0),(20260324180238,'AlterInvoiceItems','2026-03-24 18:25:47','2026-03-24 18:25:47',0),(20260325034017,'CreateCompanies','2026-03-25 03:49:37','2026-03-25 03:49:37',0),(20260325034018,'AddCompanyIdToCoreTables','2026-03-25 03:49:37','2026-03-25 03:49:37',0),(20260328115325,'AddZimraFields','2026-03-28 11:56:52','2026-03-28 11:56:52',0),(20260330173000,'CreateBankTransactions','2026-03-30 17:25:47','2026-03-30 17:25:48',0),(20260330174100,'AddBankAccountIdToBankTransactions','2026-03-30 17:40:22','2026-03-30 17:40:22',0),(20260330182000,'AddBankTxLinkToTransactions','2026-03-30 18:47:21','2026-03-30 18:47:21',0),(20260401031636,'CreateInvitations','2026-04-01 03:17:18','2026-04-01 03:17:18',0),(20260401035406,'CreateDealRequests','2026-04-01 03:54:57','2026-04-01 03:54:57',0),(20260401040615,'AddSubcategoryToAccounts','2026-04-01 04:06:56','2026-04-01 04:06:56',0),(20260401143832,'CreateBudgets','2026-04-01 14:38:44','2026-04-01 14:38:44',0);
/*!40000 ALTER TABLE `phinxlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `account_id` int(11) NOT NULL,
  `unit_price` decimal(10,6) NOT NULL,
  `vat_rate` decimal(10,6) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Consulting Service',8,1500.000000,15.500000,'2026-03-24 18:40:36','2026-03-28 16:35:56',1),(2,'Software License',10,5000.000000,0.000000,'2026-03-24 18:40:36','2026-03-28 16:45:30',1),(3,'Accounting Services',8,100.000000,0.000000,'2026-03-28 20:31:38','2026-03-28 20:31:38',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receipts`
--

DROP TABLE IF EXISTS `receipts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receipts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `currency` varchar(151) NOT NULL,
  `amount` float NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receipts`
--

LOCK TABLES `receipts` WRITE;
/*!40000 ALTER TABLE `receipts` DISABLE KEYS */;
/*!40000 ALTER TABLE `receipts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receipts_transactions`
--

DROP TABLE IF EXISTS `receipts_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receipts_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receipts_transactions`
--

LOCK TABLES `receipts_transactions` WRITE;
/*!40000 ALTER TABLE `receipts_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `receipts_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `created` datetime NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'User','2025-10-21 13:28:45',NULL),(2,'Approver','2025-10-21 13:28:59',NULL),(3,'Super Admin','2025-10-21 13:29:23',NULL),(4,'General Manager','2025-10-21 13:29:44',NULL),(10,'Employee','0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary_structures`
--

DROP TABLE IF EXISTS `salary_structures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salary_structures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `currency` varchar(3) NOT NULL,
  `basic_salary` decimal(15,2) NOT NULL,
  `payment_frequency` varchar(50) DEFAULT 'Monthly',
  `is_active` tinyint(1) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `salary_structures_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `salary_structures_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_structures`
--

LOCK TABLES `salary_structures` WRITE;
/*!40000 ALTER TABLE `salary_structures` DISABLE KEYS */;
INSERT INTO `salary_structures` VALUES (1,2,3,'USD',999.99,'monthly',1,'2026-03-07 10:23:18','2026-03-07 10:23:18'),(2,3,1,'USD',499.98,'monthly',1,'2026-03-07 10:24:07','2026-03-07 10:24:07');
/*!40000 ALTER TABLE `salary_structures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nssa_ceiling` decimal(10,2) NOT NULL DEFAULT 700.00,
  `nssa_rate` decimal(5,2) NOT NULL DEFAULT 4.50,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,700.00,4.50,'2026-03-12 19:59:18','2026-03-12 19:59:18');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `industry` varchar(151) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'City of Harare',4,'1');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `description` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_tables`
--

DROP TABLE IF EXISTS `tax_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tax_tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency` varchar(151) NOT NULL,
  `lower_limit` int(11) NOT NULL,
  `upper_limit` int(11) NOT NULL,
  `rate` float(10,0) NOT NULL,
  `deduction` float(10,0) NOT NULL,
  `tax_year` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_tables`
--

LOCK TABLES `tax_tables` WRITE;
/*!40000 ALTER TABLE `tax_tables` DISABLE KEYS */;
INSERT INTO `tax_tables` VALUES (7,'USD',0,100,0,0,'2026-12-31'),(8,'USD',101,300,20,20,'2026-12-31'),(9,'USD',301,1000,25,35,'2026-12-31'),(10,'USD',1001,2000,30,85,'2026-12-31'),(11,'USD',2001,3000,33,184,'2026-12-31'),(12,'USD',3001,10000000,39,334,'2026-12-31'),(13,'USD',0,100,0,0,'2024-01-01'),(14,'USD',101,300,20,20,'2024-01-01'),(15,'USD',301,1000,25,35,'2024-01-01'),(16,'USD',1001,2000,30,85,'2024-01-01'),(17,'USD',2001,3000,35,185,'2024-01-01'),(18,'USD',3001,9999999,40,335,'2024-01-01');
/*!40000 ALTER TABLE `tax_tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tenants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES (1,'Makandiwa',4);
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_transaction_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `description` varchar(151) NOT NULL,
  `currency` varchar(151) NOT NULL,
  `amount` float NOT NULL,
  `zwg` float NOT NULL,
  `type` varchar(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `building_id` int(11) DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `bank_transaction_id` (`bank_transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (35,NULL,'2026-03-28','testing','USD',3465,3465,'2',1,NULL,NULL,NULL,NULL,2,NULL),(36,NULL,'2026-03-28','testing','USD',3465,3465,'1',8,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(151) NOT NULL,
  `building_id` int(11) NOT NULL,
  `area` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'section A',1,101),(2,'section b',1,300),(3,'section c',1,250);
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(151) NOT NULL,
  `password` varchar(151) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'mavondoe@gmail.com','$2y$10$KOaEbb5FRNwqRpsMQUyItu1Ec5qAvaQq4sJhhykSM/2vPQRD.l6tW',2,NULL,1,NULL),(3,'mavondolyeonn@gmail.com','$2y$10$sJyra6ITDT37aT8I/RBQhOmTNcCZsqCFmABpAF/jRLeyzWP/HL02q',3,NULL,1,NULL),(4,'tasara@gmail.com','$2y$10$o.iOs4H9Y7ykiBvOp9vVS.jUAKnXxjEFnXw9uuOBnOvN7/pZgFJAe',3,NULL,1,NULL),(5,'voxy@gmail.com','$2y$10$ftypwcJthyNaWJPNlfqgaOMqC3XPL8kbLJkr8uevAWFnSGDjjdk3.',4,NULL,1,NULL),(8,'mavondoe@nssa.org.zw','$2y$10$ACGU.EuQNevZYQI2Flg4buAP3TlSKcDYniiayHDQ0rFdfGadAXXO6',3,NULL,1,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-02 17:04:25
