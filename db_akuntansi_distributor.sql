-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: db_akuntansi_distributor
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Current Database: `db_akuntansi_distributor`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `db_akuntansi_distributor` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `db_akuntansi_distributor`;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','sakit','izin','alpa') NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (1,1,'2026-01-06','hadir','08:00:00','17:00:00'),(2,2,'2026-01-05','alpa','08:00:00','17:00:00'),(3,3,'2026-01-05','sakit','08:00:00','17:00:00'),(4,3,'2026-01-06','izin','08:00:00','17:00:00'),(5,5,'2026-01-01','hadir','08:00:00','17:00:00'),(6,6,'2026-01-01','hadir','08:00:00','17:00:00'),(7,6,'2026-01-07','alpa','08:00:00','17:00:00');
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(150) NOT NULL,
  `posisi` varchar(100) DEFAULT NULL,
  `gaji_pokok` decimal(12,2) NOT NULL,
  `tunjangan` decimal(12,2) DEFAULT 0.00,
  `no_hp` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'Guntur','Kasir',2500000.00,500000.00,'086969696969','2026-01-06 20:17:37'),(2,'raihan','Staff Gudang',3000000.00,450000.00,'080707070707','2026-01-06 20:23:27'),(3,'pasha','Sales',1500000.00,250000.00,'081234567890','2026-01-06 20:31:17'),(5,'Danish keren','Staff Gudang',1000000.00,250000.00,'08123','2026-01-06 23:03:09'),(6,'Wira Ganteng','Kasir',50000000.00,7000000.00,'0812345','2026-01-07 16:44:56'),(7,'testing3','Sales',2500000.00,0.00,'083333','2026-01-07 20:06:32'),(8,'testing4','Staff Gudang',2700000.00,2000.00,'0844444','2026-01-07 20:09:03'),(9,'testing5','Sales',1500000.00,2500.00,'0877777','2026-01-08 15:27:22');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `sender_name` varchar(100) NOT NULL,
  `target_role` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,8,'Wira','staff_gudang','mouse 4',0,'2026-01-08 23:37:14');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payroll`
--

DROP TABLE IF EXISTS `payroll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `bulan_tahun` varchar(7) DEFAULT NULL,
  `total_hadir` int(11) DEFAULT NULL,
  `potongan` decimal(12,2) DEFAULT 0.00,
  `total_gaji_bersih` decimal(12,2) DEFAULT NULL,
  `tanggal_generate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `payroll_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payroll`
--

LOCK TABLES `payroll` WRITE;
/*!40000 ALTER TABLE `payroll` DISABLE KEYS */;
INSERT INTO `payroll` VALUES (1,2,'2026-01',0,100000.00,3350000.00,'2026-01-07 03:28:28'),(2,1,'2026-01',1,0.00,3000000.00,'2026-01-07 03:28:57'),(3,3,'2026-01',0,0.00,1750000.00,'2026-01-07 03:32:17'),(4,5,'2025-12',0,0.00,0.00,'2026-01-08 00:48:49'),(5,5,'2026-01',1,0.00,0.00,'2026-01-08 00:48:57'),(6,5,'2026-01',1,0.00,1250000.00,'2026-01-08 01:24:00'),(7,6,'2026-01',1,0.00,57000000.00,'2026-01-08 01:25:25'),(8,6,'2026-01',1,100000.00,56900000.00,'2026-01-08 01:25:54');
/*!40000 ALTER TABLE `payroll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(150) NOT NULL,
  `kode_barang` varchar(50) DEFAULT NULL,
  `harga_beli` decimal(10,2) DEFAULT NULL,
  `harga_jual` decimal(10,2) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_barang` (`kode_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Laptop Gaming','LP001',8500000.00,10000000.00,20,'2026-01-07 02:12:12'),(2,'Mouse','MS001',50000.00,500000.00,4,'2026-01-06 19:57:02'),(3,'Keyboard','KB001',300000.00,700000.00,6,'2026-01-06 20:03:22'),(5,'Headset Gaming','HS001',300000.00,450000.00,9,'2026-01-06 21:32:22');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_items`
--

DROP TABLE IF EXISTS `sale_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `harga_saat_ini` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_items`
--

LOCK TABLES `sale_items` WRITE;
/*!40000 ALTER TABLE `sale_items` DISABLE KEYS */;
INSERT INTO `sale_items` VALUES (1,1,2,2,500000.00,1000000.00),(2,1,3,3,700000.00,2100000.00),(3,2,2,4,500000.00,2000000.00),(4,2,3,1,700000.00,700000.00),(5,3,5,1,450000.00,450000.00),(6,4,1,53,10000000.00,530000000.00),(7,5,1,30,10000000.00,300000000.00);
/*!40000 ALTER TABLE `sale_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(50) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `total_harga` decimal(12,2) DEFAULT NULL,
  `pajak` decimal(12,2) DEFAULT NULL,
  `grand_total` decimal(12,2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_faktur` (`no_faktur`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,'INV-20260106201145','2026-01-06 20:11:45',NULL,NULL,3100000.00,1),(2,'INV-20260106205619','2026-01-06 20:56:19',NULL,NULL,2700000.00,1),(3,'INV-20260106213446','2026-01-06 21:34:46',NULL,NULL,450000.00,1),(4,'INV-20260107182837','2026-01-07 18:28:37',NULL,NULL,530000000.00,1),(5,'INV-20260107182954','2026-01-07 18:29:54',NULL,NULL,300000000.00,1);
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_histories`
--

DROP TABLE IF EXISTS `stock_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `type` enum('masuk','keluar') NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `stock_histories_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_histories`
--

LOCK TABLES `stock_histories` WRITE;
/*!40000 ALTER TABLE `stock_histories` DISABLE KEYS */;
INSERT INTO `stock_histories` VALUES (1,2,'keluar',2,'Sinkronisasi Penjualan Lama: INV-20260106201145','2026-01-06 20:11:45'),(2,3,'keluar',3,'Sinkronisasi Penjualan Lama: INV-20260106201145','2026-01-06 20:11:45'),(3,2,'keluar',4,'Sinkronisasi Penjualan Lama: INV-20260106205619','2026-01-06 20:56:19'),(4,3,'keluar',1,'Sinkronisasi Penjualan Lama: INV-20260106205619','2026-01-06 20:56:19'),(8,1,'masuk',3,'Supplier asos','2026-01-07 04:25:24'),(9,5,'masuk',10,'Stok Awal Barang Baru','2026-01-07 04:32:22'),(10,5,'keluar',1,'Penjualan No: INV-20260106213446','2026-01-07 04:34:46'),(11,1,'masuk',50,'Supplier Lonvo','2026-01-08 01:28:13'),(12,1,'keluar',53,'Penjualan No: INV-20260107182837','2026-01-08 01:28:37'),(13,1,'masuk',50,'Supplier Alenwer','2026-01-08 01:29:45'),(14,1,'keluar',30,'Penjualan No: INV-20260107182954','2026-01-08 01:29:54');
/*!40000 ALTER TABLE `stock_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT 'default.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'','admin','$2y$10$VrBNfEEB9dSeItDqilNV1e5AZLXCq8UAi8zlsTjVTYc8W2PaGFCtu','pemilik','2026-01-07 02:04:03','1767814949_d1192d4dfa24b7d1f4f0.jpg'),(2,NULL,'Guntur','$2y$10$VrBNfEEB9dSeItDqilNV1e5AZLXCq8UAi8zlsTjVTYc8W2PaGFCtu','kasir','2026-01-07 04:52:59','default.png'),(3,'raihan kebab','raihan','$2y$10$VrBNfEEB9dSeItDqilNV1e5AZLXCq8UAi8zlsTjVTYc8W2PaGFCtu','staff_gudang','2026-01-07 04:52:59','1767814837_a41f9b2671eab72b1ae0.jpg'),(4,'pasha goreng','pasha','$2y$10$VrBNfEEB9dSeItDqilNV1e5AZLXCq8UAi8zlsTjVTYc8W2PaGFCtu','sales','2026-01-07 04:52:59','1767814912_dba76e112a84ccb9eeb5.jpg'),(7,NULL,'Danish','$2y$10$Pb2b6tnKt2N8UOypAtjz/e4x1Dr/RJafQwyk6J8W/bzkYIRShKK.u','staff_gudang','2026-01-06 23:03:09','default.png'),(8,'saya wira','Wira','$2y$10$gVqavHBEmL3VmvbmyY3sz.wEpdVXd7oL1yg/7nTqBlRNTBY65DtVG','kasir','2026-01-07 16:44:56','1767813049_3c6f524dc6f7d1f0ace0.jpg'),(11,'testing3','testing3','$2y$10$YeOoyFhp192ttLxOefa7S.6eQW8CW7kER/GOHx4vM7/Wo2IMoyigi','sales','2026-01-07 20:06:32','default.png'),(12,'testing4','testing4','$2y$10$junkhO29I.DdEnWcf5BCM.cBg//l3V2nmjGB5vNcFP9aXUQElMrb2','staff_gudang','2026-01-07 20:09:03','default.png'),(13,'testing5','testing5','$2y$10$XED11Pf77ZgPaERNZz7B2ee8rwictbCWObG.TQRagXwGohsYXNA46','sales','2026-01-08 15:27:22','default.png');
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

-- Dump completed on 2026-01-09  0:44:32
