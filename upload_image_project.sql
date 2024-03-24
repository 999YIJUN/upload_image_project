CREATE DATABASE  IF NOT EXISTS `upload_image_project` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `upload_image_project`;
-- MySQL dump 10.13  Distrib 8.0.34, for macos13 (arm64)
--
-- Host: localhost    Database: upload_image_project
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `care_center`
--

DROP TABLE IF EXISTS `care_center`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `care_center` (
  `center_id` int(11) NOT NULL AUTO_INCREMENT,
  `center_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`center_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `care_center`
--

LOCK TABLES `care_center` WRITE;
/*!40000 ALTER TABLE `care_center` DISABLE KEYS */;
INSERT INTO `care_center` VALUES (1,'測試照護中心'),(2,'測試照護中心1'),(3,'測試照護中心2');
/*!40000 ALTER TABLE `care_center` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `homecare`
--

DROP TABLE IF EXISTS `homecare`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `homecare` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personal_id` varchar(10) DEFAULT NULL,
  `record_number` varchar(20) DEFAULT NULL,
  `patient_name` varchar(20) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(5) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `care_center` varchar(20) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_end` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homecare`
--

LOCK TABLES `homecare` WRITE;
/*!40000 ALTER TABLE `homecare` DISABLE KEYS */;
INSERT INTO `homecare` VALUES (1,'H123456788','54321','TEST','2020-02-02','male',20,'測試照護中心','2024-03-03',NULL,1),(8,'H123456789','12345','TEST1','2020-02-02','male',20,'測試照護中心','2024-03-09','2024-03-09',1),(9,'H123456789','12345','TEST1','2020-02-02','male',20,'測試照護中心','2024-03-09',NULL,1),(10,'H123456789','12345','TEST1','2020-02-02','male',20,'測試照護中心','2024-03-09','2024-03-09',1),(11,'H123456789','12345','TEST1','2020-02-02','male',20,'測試照護中心1','2024-03-09','2024-03-13',1),(12,'H123456789','12345','TEST1','2020-02-02','male',20,'測試照護中心1','2024-03-09','2024-03-10',1),(13,'H123456788','54321','TEST2','2000-01-01','femal',20,'測試照護中心','2024-03-10','2024-03-11',1),(14,'H123456789','12345','TEST1','2020-02-02','male',20,'測試照護中心1','2024-03-11',NULL,1),(15,'H123456788','54321','TEST2','2000-01-01','femal',20,'測試照護中心2','2024-03-11','2024-03-12',1),(16,'H123456789','12345','TEST1','2020-02-02','male',20,'測試照護中心1','2024-03-12','2024-03-12',1),(17,'H123456789','12345','TEST1','2020-02-02','male',20,'測試照護中心1','2024-03-12','2024-03-24',1),(18,'H123456788','54321','TEST2','2000-01-01','femal',20,'測試照護中心1','2024-03-24','2024-03-24',1),(19,'H123456789','12345','TEST1','2020-02-02','male',20,'測試照護中心','2024-03-24','2024-03-24',1),(20,'H123456789','12345','TEST1','2020-02-02','male',20,'測試照護中心1','2024-03-24','2024-03-24',1),(21,'H123456788','54321','TEST2','2000-01-01','femal',20,'測試照護中心1','2024-03-24',NULL,0),(22,'H123456789','12345','TEST1','2020-02-02','male',20,'測試照護中心','2024-03-24','2024-03-24',1),(23,'H123456789','12345','TEST1','2020-02-02','male',20,'測試照護中心1','2024-03-24',NULL,0);
/*!40000 ALTER TABLE `homecare` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_name` varchar(100) DEFAULT NULL,
  `personal_id` varchar(10) DEFAULT NULL,
  `patient_name` varchar(20) DEFAULT NULL,
  `record_number` varchar(20) DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `source` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'img_20240310_435',NULL,NULL,NULL,NULL,NULL),(2,'img_20240310_8244',NULL,NULL,NULL,'2024-03-10',NULL),(3,'img_20240310_7720',NULL,NULL,NULL,'2024-03-10',NULL),(4,'img_20240310_6942',NULL,NULL,NULL,'2024-03-10',NULL),(5,'img_20240310_6821','H123456787','TEST3','123','2024-03-10',NULL),(6,'img_20240310_6022','H123456787','TEST3','123','2024-03-10',NULL),(7,'img_20240310_6506','H123456787','TEST3','123','2024-03-10',NULL),(8,'img_20240310_8651','H123456666','TEST4','234','2024-03-10',NULL),(9,'img_20240310_219','H123456787','TEST3','123','2024-03-10',NULL),(10,'img_20240310_5166','H123456666','TEST4','234','2024-03-10','門診'),(12,'img_20240311_9677','H123456789','TEST1','12345','2024-03-11',NULL),(13,'img_20240311_8007','H123456788','TEST2','54321','2024-03-11',NULL),(26,'img_20240315_2892','H123456666','TEST4','234','2024-03-15','住院病房'),(27,'img_20240315_8958','H123456666','TEST4','234','2024-03-15','門診'),(29,'img_20240324_559','H123456788','TEST2','54321','2024-03-24','居家照護'),(30,'img_20240324_2909','H123456788','TEST2','54321','2024-03-24','居家照護'),(31,'img_20240324_1054','H123456788','TEST2','54321','2024-03-24','居家照護'),(32,'img_20240324_2116','H123456789','TEST1','12345','2024-03-24','居家照護'),(33,'img_20240324_8259','H123456788','TEST2','54321','2024-03-24','居家照護');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inpatient`
--

DROP TABLE IF EXISTS `inpatient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inpatient` (
  `inpatient_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_name` varchar(20) DEFAULT NULL,
  `record_number` varchar(20) DEFAULT NULL,
  `doctor_name` varchar(20) DEFAULT NULL,
  `bed_number` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`inpatient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inpatient`
--

LOCK TABLES `inpatient` WRITE;
/*!40000 ALTER TABLE `inpatient` DISABLE KEYS */;
INSERT INTO `inpatient` VALUES (1,'TEST4','234','TEST_ADMIN','01');
/*!40000 ALTER TABLE `inpatient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opd`
--

DROP TABLE IF EXISTS `opd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opd` (
  `opd_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_name` varchar(20) DEFAULT NULL,
  `record_number` varchar(20) DEFAULT NULL,
  `doctor_name` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`opd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opd`
--

LOCK TABLES `opd` WRITE;
/*!40000 ALTER TABLE `opd` DISABLE KEYS */;
INSERT INTO `opd` VALUES (1,'TEST','456','TEST_doctor','2024-03-09'),(2,'12345TEST','123','TEST','2024-03-10'),(3,'234TEST','234','TEST','2024-03-10'),(4,'12345TEST','123','TEST','2024-03-11'),(5,'234TEST','234','TEST','2024-03-11'),(6,'TEST1','12345','TEST','2024-03-11'),(7,'TEST2','54321','TEST','2024-03-11'),(8,'TEST2','54321','TEST','2024-03-12'),(9,'TEST2','54321','TEST_ADMIN','2024-03-24');
/*!40000 ALTER TABLE `opd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_name` varchar(20) DEFAULT NULL,
  `personal_id` varchar(10) DEFAULT NULL,
  `record_number` varchar(20) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES (1,'TEST1','H123456789','12345','2020-02-02','male',20),(2,'TEST2','H123456788','54321','2000-01-01','female',20),(3,'TEST3','H123456787','123','2020-01-01','female',20),(4,'TEST4','H123456666','234','2020-03-03','male',20);
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surgery`
--

DROP TABLE IF EXISTS `surgery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surgery` (
  `surgery_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_name` varchar(20) DEFAULT NULL,
  `record_number` varchar(20) DEFAULT NULL,
  `doctor_name` varchar(20) DEFAULT NULL,
  `surgery_room` varchar(10) DEFAULT NULL,
  `surgery_date` date DEFAULT NULL,
  PRIMARY KEY (`surgery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surgery`
--

LOCK TABLES `surgery` WRITE;
/*!40000 ALTER TABLE `surgery` DISABLE KEYS */;
INSERT INTO `surgery` VALUES (1,'TEST1','12345','TEST_ADMIN','TEST_ROOM','2024-03-24');
/*!40000 ALTER TABLE `surgery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `account` varchar(20) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `permission` enum('admin','advance','general') DEFAULT 'general',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifydate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'TEST','12345','$2y$10$0grTKHqi00xZaLdylI3ciOd4F451Em49ku240VYWbsoWF8MOLqBOS','醫師','advance','2024-03-08 15:41:49','2024-03-11 08:11:12'),(2,'TEST1','54321','$2y$10$euVAgTFW2TMW3vJzZ83Wq.EUBl681hEh0Abb5lmScxmMgUn3XAg2y','護理師','advance','2024-03-12 09:03:16','2024-03-12 09:03:16'),(4,'TEST_ADMIN','123456','$2y$10$5EEPp3viuanxgsHLZkuB9.bZkcAlf2iwdH6pusrAZdytfUcdUV1kC','醫師','admin','2024-03-24 07:12:07','2024-03-24 07:12:30'),(5,'TEST_user','123456123','$2y$10$RKNWEeg4BhBsMbOLEEVuZOhzsclidlN.R9NW/yaBfdWA4Zh2xWgaa','護理師','advance','2024-03-24 07:17:03','2024-03-24 07:17:14'),(6,'TEST123','123','$2y$10$t6UyqukDX6aMx.KfNXCpwObIPKvssG8OvP6rBKgXvK0qs187JGdmC','醫師','general','2024-03-24 07:27:05','2024-03-24 07:27:05'),(7,'TEST12345','123','$2y$10$25XcYUDLqGQifdW1Itx4oObJpsdOML4sBqUramQGZsqL6n.2sh02C','護理師','advance','2024-03-24 07:31:04','2024-03-24 07:49:30'),(11,'TEST_DOCTOR','12345678','$2y$10$MWC0xImDyw46e9HOrFIHeePr/fmoCawWeYVYoZOS0x/VH4aD1U3PO','醫師','general','2024-03-24 07:49:48','2024-03-24 07:49:48');
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

-- Dump completed on 2024-03-24 19:31:23
