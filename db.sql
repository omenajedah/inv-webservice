/*
SQLyog Professional v12.5.1 (64 bit)
MySQL - 10.1.35-MariaDB : Database - inventaris
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`inventaris` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `inventaris`;

/*Table structure for table `tbl_barang` */

DROP TABLE IF EXISTS `tbl_barang`;

CREATE TABLE `tbl_barang` (
  `kode_barang` char(10) NOT NULL,
  `nama_barang` varchar(20) DEFAULT NULL,
  `jumlah` int(10) NOT NULL,
  `satuan_barang` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`kode_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_barang` */

insert  into `tbl_barang`(`kode_barang`,`nama_barang`,`jumlah`,`satuan_barang`) values 
('B000001','Paku 5 cm',30,'kg'),
('B000002','Paku 7 cm',120,'kg'),
('B000003','Lampu 13 watt',0,'pcs'),
('B000004','Semen',20,'zak');

/*Table structure for table `tbl_barang_keluar` */

DROP TABLE IF EXISTS `tbl_barang_keluar`;

CREATE TABLE `tbl_barang_keluar` (
  `id_trans` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` char(10) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `waktu` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `kode_mandor` char(10) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_trans`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_barang_keluar` */

insert  into `tbl_barang_keluar`(`id_trans`,`kode_barang`,`jumlah`,`waktu`,`kode_mandor`,`keterangan`) values 
(1,'B000001',10,'2018-12-10 07:22:15','M000001',NULL),
(2,'B000001',20,'2018-12-18 01:13:14','M000001',NULL);

/*Table structure for table `tbl_barang_masuk` */

DROP TABLE IF EXISTS `tbl_barang_masuk`;

CREATE TABLE `tbl_barang_masuk` (
  `id_trans` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` char(10) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `waktu` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `kode_supplier` char(10) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_trans`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_barang_masuk` */

insert  into `tbl_barang_masuk`(`id_trans`,`kode_barang`,`jumlah`,`waktu`,`kode_supplier`,`keterangan`) values 
(1,'B000001',20,'2018-12-10 07:16:10','S000001',NULL),
(2,'B000001',20,'2018-12-10 07:17:47','S000001',NULL),
(3,'B000001',20,'2018-12-10 07:18:12','S000001',NULL),
(4,'B000002',20,'2018-12-10 07:18:37','S000001',NULL),
(5,'B000002',100,'2018-12-18 01:15:52','S000001',NULL),
(6,'B000004',20,'2018-12-21 07:16:36','S000001',NULL);

/*Table structure for table `tbl_mandor` */

DROP TABLE IF EXISTS `tbl_mandor`;

CREATE TABLE `tbl_mandor` (
  `kode_mandor` char(10) NOT NULL,
  `nama_mandor` varchar(120) DEFAULT NULL,
  `status_mandor` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`kode_mandor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_mandor` */

insert  into `tbl_mandor`(`kode_mandor`,`nama_mandor`,`status_mandor`) values 
('M000001','Wahid',1),
('M000002','Sirun',1),
('M000003','Agus',1);

/*Table structure for table `tbl_supplier` */

DROP TABLE IF EXISTS `tbl_supplier`;

CREATE TABLE `tbl_supplier` (
  `kode_supplier` char(10) NOT NULL,
  `nama_supplier` varchar(120) DEFAULT NULL,
  `status_supplier` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`kode_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_supplier` */

insert  into `tbl_supplier`(`kode_supplier`,`nama_supplier`,`status_supplier`) values 
('S000001','PT. Sinar Laut Mandiri',1),
('S000002','Karya Electric',1),
('S000003','Toko Makmur',1);

/*Table structure for table `tbl_user` */

DROP TABLE IF EXISTS `tbl_user`;

CREATE TABLE `tbl_user` (
  `user_name` char(15) NOT NULL,
  `user_pass` varchar(32) DEFAULT NULL,
  `user_fullname` varchar(120) DEFAULT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_user` */

insert  into `tbl_user`(`user_name`,`user_pass`,`user_fullname`,`user_status`) values 
('admin','admin','Administrator',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
