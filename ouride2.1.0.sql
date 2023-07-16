-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2020 at 02:44 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ouride`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `user_name`, `password`, `email`, `image`) VALUES
(1, 'Admin', '4e7afebcfbae000b22c7c85e5560f89a2a0280b4', 'admin@admin.com', 'c9b5879ee01f4e2a3e3d2ef0eb00392a.png');

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int(11) NOT NULL,
  `app_email` varchar(500) NOT NULL,
  `app_contact` varchar(500) NOT NULL,
  `app_website` varchar(500) NOT NULL,
  `app_description` text NOT NULL,
  `app_privacy_policy` text NOT NULL,
  `app_aboutus` text NOT NULL,
  `email_subject` varchar(500) NOT NULL,
  `email_subject_confirm` varchar(500) NOT NULL,
  `email_text1` text NOT NULL,
  `email_text2` text NOT NULL,
  `email_text3` text NOT NULL,
  `email_text4` text NOT NULL,
  `app_logo` varchar(500) NOT NULL,
  `smtp_host` varchar(500) NOT NULL,
  `smtp_port` varchar(500) NOT NULL,
  `smtp_username` varchar(500) NOT NULL,
  `smtp_password` varchar(500) NOT NULL,
  `smtp_from` varchar(500) NOT NULL,
  `smtp_secure` varchar(250) NOT NULL,
  `app_name` varchar(500) NOT NULL,
  `app_address` text NOT NULL,
  `app_linkgoogle` varchar(500) NOT NULL,
  `app_currency` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `app_currency_text` varchar(10) NOT NULL,
  `stripe_secret_key` varchar(500) NOT NULL,
  `stripe_published_key` varchar(500) NOT NULL,
  `stripe_status` varchar(5) NOT NULL,
  `stripe_active` varchar(20) NOT NULL,
  `paypal_key` varchar(500) NOT NULL,
  `paypal_mode` varchar(20) NOT NULL,
  `paypal_active` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `app_email`, `app_contact`, `app_website`, `app_description`, `app_privacy_policy`, `app_aboutus`, `email_subject`, `email_subject_confirm`, `email_text1`, `email_text2`, `email_text3`, `email_text4`, `app_logo`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `smtp_from`, `smtp_secure`, `app_name`, `app_address`, `app_linkgoogle`, `app_currency`, `app_currency_text`, `stripe_secret_key`, `stripe_published_key`, `stripe_status`, `stripe_active`, `paypal_key`, `paypal_mode`, `paypal_active`) VALUES
(1, 'demo@ourdevelops.com', '081234567890', 'https://ourdevelops.com/ouride', '', '<div xss=removed><strong xss=\"removed\" xss=removed>Lorem Ipsum</strong><span xss=\"removed\" xss=removed> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</span></div>', '<div xss=removed><strong xss=\"removed\" xss=removed>Lorem Ipsum</strong><span xss=\"removed\" xss=removed> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</span></div>', 'Reset Password', 'Registration accepted', '<div style=\"text-align: justify;\"><span style=\"font-size: 0.875rem; font-weight: initial;\">We have received your request to reset the password. Please confirm via the button below:</span></div>', '<div style=\"text-align: justify;\"><span style=\"font-size: 0.875rem; font-weight: initial;\">Ignore this email if you never asked to reset your password. For questions, please contact </span></div>', '<div style=\"text-align: justify;\"><span style=\"font-size: 0.875rem; font-weight: initial;\">Thank you for registering a driver, we have accepted, please click the button below to reset your password:</span></div>', '<span style=\"text-align: justify;\">Ignore this email if you never asked to reset your password. For questions, please contact </span>', 'lol.jpg', 'your smtp host', '465', 'smtp username', 'password', 'smtp from', 'ssl', 'ouride', '<p><span style=\"font-size: 14px; text-align: justify;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s</span><br></p>', 'https://play.google.com', '$', 'USD', 'sk_test_WRuTFWBsvTvRaCnJt2V87QjQ00vTewyiWS', 'pk_test_kUsRHrV9bdD9LzHq5CYvOqn7001mufIjaiaa', '1', '1', 'Ab95j_J-CIrQ-Fbg6dAv2ee9d1dD3OQLmAqTp_ZJZybEp1OCmqRBaoLBEaAA0cTL_dIjxvGVFWMPGljb', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(11) NOT NULL,
  `id_kategori` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `foto_berita` varchar(250) NOT NULL,
  `created_berita` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_berita` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `berkas_driver`
--

CREATE TABLE `berkas_driver` (
  `id_berkas` int(11) NOT NULL,
  `id_driver` varchar(250) NOT NULL,
  `foto_ktp` varchar(250) NOT NULL,
  `foto_sim` varchar(250) NOT NULL,
  `id_sim` varchar(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category_item`
--

CREATE TABLE `category_item` (
  `id_kategori_item` int(11) NOT NULL,
  `nama_kategori_item` varchar(250) NOT NULL,
  `foto_kategori_item` varchar(250) NOT NULL,
  `id_merchant` varchar(250) NOT NULL,
  `created_cat_item` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `all_category` varchar(50) NOT NULL,
  `status_kategori` varchar(5) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_item`
--

INSERT INTO `category_item` (`id_kategori_item`, `nama_kategori_item`, `foto_kategori_item`, `id_merchant`, `created_cat_item`, `all_category`, `status_kategori`) VALUES
(1, 'All', '', '0', '2020-04-21 08:49:42', '1', '1'),
(5, 'dsdsd', '', '1', '2020-06-08 06:55:27', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `category_merchant`
--

CREATE TABLE `category_merchant` (
  `id_kategori_merchant` int(11) NOT NULL,
  `nama_kategori` varchar(250) NOT NULL,
  `foto_kategori` varchar(250) NOT NULL,
  `id_fitur` varchar(200) NOT NULL,
  `status_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_merchant`
--

INSERT INTO `category_merchant` (`id_kategori_merchant`, `nama_kategori`, `foto_kategori`, `id_fitur`, `status_kategori`) VALUES
(1, 'All', '', '0', '1'),
(54, 'Pizza and Pasta', '', '21', '1'),
(55, 'Fast Food', '', '21', '1'),
(56, 'Drinks', '', '21', '1'),
(57, 'Snack', '', '21', '1'),
(58, 'Man Fashion', '', '22', '1'),
(59, 'Fashion', '', '22', '1'),
(60, 'Toys', '', '22', '1'),
(61, 'Kids', '', '22', '1'),
(62, 'Sport and Outdoor', '', '22', '1'),
(63, 'Hobby', '', '22', '1'),
(64, 'Home Appliance', '', '22', '1'),
(65, 'Electronic', '', '22', '1'),
(66, 'PC and Laptop', '', '22', '1'),
(67, 'Phone and Tablet', '', '22', '1'),
(68, 'Vegetables', '', '23', '1'),
(69, 'Herbs', '', '24', '1'),
(70, 'Grains and Bread', '', '23', '1'),
(71, 'Meat and Fish', '', '23', '1'),
(72, 'Drugstore', '', '24', '1'),
(73, 'medical devices', '', '24', '1');

-- --------------------------------------------------------

--
-- Table structure for table `config_driver`
--

CREATE TABLE `config_driver` (
  `id_driver` varchar(200) NOT NULL,
  `latitude` varchar(30) NOT NULL DEFAULT '0',
  `longitude` varchar(30) NOT NULL DEFAULT '0',
  `bearing` varchar(250) NOT NULL,
  `uang_belanja` int(11) NOT NULL DEFAULT '1',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` char(1) NOT NULL DEFAULT '2'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `id` varchar(200) NOT NULL,
  `nama_driver` varchar(20) NOT NULL,
  `no_ktp` varchar(16) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tempat_lahir` varchar(20) DEFAULT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `countrycode` varchar(20) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `rating` double NOT NULL DEFAULT '0',
  `job` int(11) NOT NULL,
  `gender` varchar(250) DEFAULT '2',
  `alamat_driver` text NOT NULL,
  `kendaraan` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reg_id` varchar(250) DEFAULT NULL,
  `status` char(1) DEFAULT '2'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `driver_job`
--

CREATE TABLE `driver_job` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_job` varchar(250) NOT NULL,
  `icon` varchar(20) NOT NULL DEFAULT '1',
  `status_job` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driver_job`
--

INSERT INTO `driver_job` (`id`, `driver_job`, `icon`, `status_job`) VALUES
(8, 'Car', '2', '1'),
(7, 'Bike', '1', '1'),
(9, 'Truck', '3', '1'),
(10, 'Hatchback', '3', '1'),
(11, 'SUV Car', '6', '1'),
(12, 'Van Car', '7', '1'),
(13, 'Delivery Box', '4', '1'),
(14, 'Bicycle', '8', '1'),
(15, 'Tuktuk', '9', '1');

-- --------------------------------------------------------

--
-- Table structure for table `fitur`
--

CREATE TABLE `fitur` (
  `id_fitur` int(11) NOT NULL,
  `fitur` varchar(20) NOT NULL,
  `biaya` int(11) NOT NULL,
  `biaya_minimum` int(11) NOT NULL,
  `jarak_minimum` varchar(100) NOT NULL,
  `maks_distance` varchar(250) NOT NULL,
  `wallet_minimum` varchar(100) NOT NULL,
  `komisi` varchar(200) DEFAULT '0',
  `keterangan_biaya` varchar(50) NOT NULL,
  `driver_job` int(11) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `icon` varchar(500) NOT NULL,
  `home` varchar(1) NOT NULL,
  `active` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fitur`
--

INSERT INTO `fitur` (`id_fitur`, `fitur`, `biaya`, `biaya_minimum`, `jarak_minimum`, `maks_distance`, `wallet_minimum`, `komisi`, `keterangan_biaya`, `driver_job`, `keterangan`, `icon`, `home`, `active`) VALUES
(21, 'Food', 120, 0, '5', '70', '000', '0', 'KM', 13, 'In Town Merchant', '4a75feea7e9e6ecb69669cd1c1c61e16.png', '4', '1'),
(27, 'Hatchback Car', 70, 200, '5', '70', '1000', '10', 'KM', 10, 'Max 4 Person', 'fa23127777a76b5ff7d505ef613a0762.png', '1', '1'),
(20, 'Car Rent', 200, 4500, '10', '0', '3000', '10', 'Hr', 8, 'City use', 'b94d61b4f10aa50376960f09ad0d8167.png', '3', '1'),
(18, 'Truck', 600, 1500, '50', '500', '5000', '10', 'KM', 9, 'Max 25,999 lbs or 1,500 ft³', '273429c0660e0e44a218bd0747248ac6.png', '2', '1'),
(17, 'Send Goods', 70, 120, '5', '70', '1000', '10', 'KM', 13, 'Max 20 KG or 0.5 M2', '9b3b0a492348ceb0d002f33d19661fa1.png', '2', '1'),
(16, 'Saloon Car', 120, 170, '5', '50', '3000', '10', 'KM', 8, 'Max 3 person', '3455045b87aea1ec76bbcce1947b3066.png', '1', '1'),
(15, 'Ride', 70, 200, '5', '70', '1000', '10', 'KM', 7, 'Max 1 Person', 'cafad9edd5aa96ea0732b174fd23f80e.png', '1', '1'),
(22, 'Shop', 120, 200, '5', '70', '1000', '10', 'KM', 13, 'In Town Shop Merchant', '06d943f123882b2d7682e30a25f54e39.png', '4', '1'),
(23, 'Grocery', 30, 100, '4', '12', '1000', '10', 'KM', 14, 'In Town Grocery Merchant', '0babfde5514897112049b393eb89f46f.png', '4', '1'),
(24, 'Medicine', 70, 200, '5', '500', '1000', '10', 'KM', 13, 'In Town Drugstore', 'b2501da020a00ebd0cc8e074bd16fc5c.png', '4', '1'),
(25, 'SUV Car', 150, 300, '5', '150', '3000', '10', 'KM', 11, 'Max 5 Person', 'ed2c25007536177045d7ae31b83afab2.png', '1', '1'),
(26, 'Van Shipment', 30, 300, '4', '70', '1000', '10', 'KM', 12, 'Send Big Item', '2da31839bc3ecc6dc9719f0f2225a339.png', '2', '1'),
(28, 'SUV Rent Car', 400, 4500, '5', '0', '3000', '10', 'Hr', 11, 'In Town Use', '9a763977427b18d16cc493dbc1d6be8a.png', '3', '1'),
(29, 'Tuktuk', 500, 1000, '100', '50', '5000', '15', 'KM', 15, 'take the tuktuk wherever you want', '45ddcde228beef10ff52747beec43768.png', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password`
--

CREATE TABLE `forgot_password` (
  `id` int(11) NOT NULL,
  `idkey` int(11) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `token` varchar(500) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_transaksi`
--

CREATE TABLE `history_transaksi` (
  `nomor` bigint(20) UNSIGNED NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_driver` varchar(200) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `catatan` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id_item` int(11) NOT NULL,
  `id_merchant` varchar(100) NOT NULL,
  `nama_item` varchar(250) NOT NULL,
  `harga_item` int(250) NOT NULL,
  `harga_promo` int(100) NOT NULL,
  `kategori_item` varchar(200) NOT NULL,
  `deskripsi_item` text NOT NULL,
  `foto_item` varchar(250) NOT NULL,
  `created_item` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_item` varchar(10) NOT NULL,
  `status_promo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_news`
--

CREATE TABLE `kategori_news` (
  `id_kategori_news` int(11) NOT NULL,
  `kategori` varchar(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_k` bigint(20) UNSIGNED NOT NULL,
  `merek` varchar(20) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `jenis` char(1) NOT NULL,
  `nomor_kendaraan` varchar(200) NOT NULL,
  `warna` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kodepromo`
--

CREATE TABLE `kodepromo` (
  `id_promo` int(11) NOT NULL,
  `nama_promo` varchar(250) NOT NULL,
  `kode_promo` varchar(250) NOT NULL,
  `nominal_promo` varchar(500) NOT NULL,
  `type_promo` varchar(250) NOT NULL,
  `expired` varchar(250) NOT NULL,
  `fitur` varchar(250) NOT NULL,
  `image_promo` varchar(500) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `list_bank`
--

CREATE TABLE `list_bank` (
  `id_bank` int(11) NOT NULL,
  `nama_bank` varchar(250) NOT NULL,
  `image_bank` varchar(250) NOT NULL,
  `rekening_bank` varchar(250) NOT NULL,
  `status_bank` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list_bank`
--

INSERT INTO `list_bank` (`id_bank`, `nama_bank`, `image_bank`, `rekening_bank`, `status_bank`) VALUES
(2, 'BNI', '5ea32dff13efb6689328f0f3520ac856.png', '12345678', '1');

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `id_merchant` int(11) NOT NULL,
  `id_fitur` varchar(100) NOT NULL,
  `nama_merchant` varchar(250) NOT NULL,
  `alamat_merchant` varchar(250) NOT NULL,
  `latitude_merchant` varchar(250) NOT NULL,
  `longitude_merchant` varchar(250) NOT NULL,
  `jam_buka` varchar(250) NOT NULL,
  `jam_tutup` varchar(250) NOT NULL,
  `category_merchant` varchar(100) NOT NULL,
  `foto_merchant` varchar(250) NOT NULL,
  `telepon_merchant` varchar(250) NOT NULL,
  `deskripsi_merchant` text NOT NULL,
  `phone_merchant` varchar(250) NOT NULL,
  `country_code_merchant` varchar(20) NOT NULL,
  `status_merchant` varchar(250) NOT NULL,
  `open_merchant` varchar(20) NOT NULL,
  `token_merchant` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mitra`
--

CREATE TABLE `mitra` (
  `id_mitra` varchar(200) NOT NULL,
  `nama_mitra` varchar(250) NOT NULL,
  `jenis_identitas_mitra` varchar(250) NOT NULL,
  `nomor_identitas_mitra` varchar(250) NOT NULL,
  `alamat_mitra` varchar(250) NOT NULL,
  `email_mitra` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `telepon_mitra` varchar(250) NOT NULL,
  `phone_mitra` varchar(250) NOT NULL,
  `country_code_mitra` varchar(250) NOT NULL,
  `id_merchant` varchar(250) NOT NULL,
  `partner` varchar(250) NOT NULL,
  `status_mitra` varchar(10) NOT NULL,
  `created_mitra` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payusettings`
--

CREATE TABLE `payusettings` (
  `id` int(11) NOT NULL,
  `payu_key` varchar(250) NOT NULL,
  `payu_id` varchar(250) NOT NULL,
  `payu_salt` varchar(250) NOT NULL,
  `payu_debug` varchar(250) NOT NULL,
  `active` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payusettings`
--

INSERT INTO `payusettings` (`id`, `payu_key`, `payu_id`, `payu_salt`, `payu_debug`, `active`) VALUES
(1, '4JreBobn', '7094565', 'gIY79pFnX9', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` varchar(200) NOT NULL,
  `fullnama` varchar(500) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `countrycode` varchar(20) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_lahir` varchar(50) NOT NULL,
  `rating_pelanggan` double NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `token` varchar(250) NOT NULL,
  `fotopelanggan` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `promosi`
--

CREATE TABLE `promosi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_berakhir` date NOT NULL,
  `fitur_promosi` int(11) NOT NULL,
  `link_promosi` varchar(500) DEFAULT NULL,
  `type_promosi` varchar(250) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `is_show` varchar(3) NOT NULL,
  `action` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rating_driver`
--

CREATE TABLE `rating_driver` (
  `nomor` bigint(20) UNSIGNED NOT NULL,
  `id_pelanggan` varchar(200) NOT NULL,
  `id_driver` varchar(200) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `catatan` varchar(200) DEFAULT 'Good job',
  `rating` int(11) NOT NULL,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `saldo`
--

CREATE TABLE `saldo` (
  `nomor` bigint(20) UNSIGNED NOT NULL,
  `id_user` varchar(200) NOT NULL,
  `saldo` int(11) DEFAULT '0',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status_transaksi`
--

CREATE TABLE `status_transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_transaksi` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_transaksi`
--

INSERT INTO `status_transaksi` (`id`, `status_transaksi`) VALUES
(3, 'start'),
(4, 'finish'),
(5, 'cancel'),
(2, 'accept'),
(1, 'near');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint(20) NOT NULL,
  `id_pelanggan` varchar(200) NOT NULL,
  `id_driver` varchar(200) DEFAULT NULL,
  `order_fitur` tinyint(4) NOT NULL,
  `start_latitude` varchar(20) NOT NULL,
  `start_longitude` varchar(20) NOT NULL,
  `end_latitude` varchar(20) NOT NULL,
  `end_longitude` varchar(20) NOT NULL,
  `jarak` double NOT NULL,
  `harga` int(11) NOT NULL,
  `waktu_order` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `estimasi_time` varchar(500) NOT NULL,
  `alamat_asal` varchar(500) NOT NULL,
  `alamat_tujuan` varchar(500) NOT NULL,
  `kredit_promo` int(11) NOT NULL DEFAULT '0',
  `biaya_akhir` int(11) DEFAULT '0',
  `pakai_wallet` tinyint(1) NOT NULL DEFAULT '0',
  `rate` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail_merchant`
--

CREATE TABLE `transaksi_detail_merchant` (
  `id_trans_merchant` int(11) NOT NULL,
  `id_transaksi` varchar(250) NOT NULL,
  `id_merchant` varchar(250) NOT NULL,
  `total_biaya` varchar(250) NOT NULL,
  `harga_akhir` varchar(250) NOT NULL,
  `struk` varchar(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail_send`
--

CREATE TABLE `transaksi_detail_send` (
  `id_send` int(11) NOT NULL,
  `id_transaksi` varchar(250) NOT NULL,
  `nama_barang` varchar(250) NOT NULL,
  `nama_pengirim` varchar(250) NOT NULL,
  `nama_penerima` varchar(250) NOT NULL,
  `telepon_pengirim` varchar(250) NOT NULL,
  `telepon_penerima` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_item`
--

CREATE TABLE `transaksi_item` (
  `id_trans_item` int(11) NOT NULL,
  `id_item` varchar(200) NOT NULL,
  `id_merchant` varchar(100) NOT NULL,
  `id_transaksi` varchar(200) NOT NULL,
  `jumlah_item` varchar(200) NOT NULL,
  `catatan_item` text NOT NULL,
  `total_harga` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher` varchar(20) NOT NULL,
  `tipe_voucher` char(1) NOT NULL,
  `untuk_fitur` int(11) NOT NULL,
  `tanggal_expired` date NOT NULL,
  `nilai` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `count_to_use` int(11) NOT NULL,
  `is_valid` varchar(3) NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`id`, `voucher`, `tipe_voucher`, `untuk_fitur`, `tanggal_expired`, `nilai`, `keterangan`, `count_to_use`, `is_valid`) VALUES
(1, 'DISKON', '1', 15, '2020-01-31', 0, 'Discount', 0, 'yes'),
(2, 'DISKON', '1', 16, '2020-01-31', 5, 'Discount', 0, 'yes'),
(3, 'DISKON', '1', 17, '2020-01-31', 0, 'Discount', 0, 'yes'),
(4, 'DISKON', '1', 18, '2020-01-31', 5, 'Discount', 0, 'yes'),
(13, 'DISKON', '1', 27, '2020-01-31', 0, 'Discount', 0, 'yes'),
(6, 'DISKON', '1', 20, '2020-01-31', 5, 'Discount', 0, 'yes'),
(7, 'DISKON', '1', 21, '2020-01-31', 2, 'Discount', 0, 'yes'),
(8, 'DISKON', '1', 22, '2020-01-31', 0, 'Discount', 0, 'yes'),
(9, 'DISKON', '1', 23, '2020-01-31', 0, 'Discount', 0, 'yes'),
(10, 'DISKON', '1', 24, '2020-01-31', 0, 'Discount', 0, 'yes'),
(11, 'DISKON', '1', 25, '2020-01-31', 5, 'Discount', 0, 'yes'),
(12, 'DISKON', '1', 26, '2020-01-31', 0, 'Discount', 0, 'yes'),
(14, 'DISKON', '1', 28, '2020-01-31', 0, 'Discount', 0, 'yes'),
(15, 'DISKON', '1', 29, '2020-01-31', 0, 'Discount', 0, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` varchar(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `bank` varchar(250) NOT NULL,
  `nama_pemilik` varchar(500) NOT NULL,
  `rekening` varchar(250) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `berkas_driver`
--
ALTER TABLE `berkas_driver`
  ADD PRIMARY KEY (`id_berkas`);

--
-- Indexes for table `category_item`
--
ALTER TABLE `category_item`
  ADD PRIMARY KEY (`id_kategori_item`);

--
-- Indexes for table `category_merchant`
--
ALTER TABLE `category_merchant`
  ADD PRIMARY KEY (`id_kategori_merchant`);

--
-- Indexes for table `config_driver`
--
ALTER TABLE `config_driver`
  ADD PRIMARY KEY (`id_driver`),
  ADD KEY `latitude` (`latitude`),
  ADD KEY `longitude` (`longitude`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `no_telepon` (`no_telepon`),
  ADD UNIQUE KEY `no_ktp` (`no_ktp`);

--
-- Indexes for table `driver_job`
--
ALTER TABLE `driver_job`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `fitur`
--
ALTER TABLE `fitur`
  ADD PRIMARY KEY (`id_fitur`),
  ADD UNIQUE KEY `id` (`id_fitur`);

--
-- Indexes for table `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_transaksi`
--
ALTER TABLE `history_transaksi`
  ADD PRIMARY KEY (`nomor`),
  ADD UNIQUE KEY `nomor` (`nomor`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `kategori_news`
--
ALTER TABLE `kategori_news`
  ADD PRIMARY KEY (`id_kategori_news`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_k`),
  ADD UNIQUE KEY `id` (`id_k`);

--
-- Indexes for table `kodepromo`
--
ALTER TABLE `kodepromo`
  ADD PRIMARY KEY (`id_promo`);

--
-- Indexes for table `list_bank`
--
ALTER TABLE `list_bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`id_merchant`);

--
-- Indexes for table `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id_mitra`),
  ADD UNIQUE KEY `email_mitra` (`email_mitra`),
  ADD UNIQUE KEY `telepon_mitra` (`telepon_mitra`);

--
-- Indexes for table `payusettings`
--
ALTER TABLE `payusettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `no_telepon` (`no_telepon`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `promosi`
--
ALTER TABLE `promosi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `rating_driver`
--
ALTER TABLE `rating_driver`
  ADD PRIMARY KEY (`nomor`),
  ADD UNIQUE KEY `nomor` (`nomor`);

--
-- Indexes for table `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`nomor`),
  ADD UNIQUE KEY `nomor` (`nomor`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Indexes for table `status_transaksi`
--
ALTER TABLE `status_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_pelanggan`,`waktu_order`),
  ADD UNIQUE KEY `nomor` (`id`);

--
-- Indexes for table `transaksi_detail_merchant`
--
ALTER TABLE `transaksi_detail_merchant`
  ADD PRIMARY KEY (`id_trans_merchant`);

--
-- Indexes for table `transaksi_detail_send`
--
ALTER TABLE `transaksi_detail_send`
  ADD PRIMARY KEY (`id_send`);

--
-- Indexes for table `transaksi_item`
--
ALTER TABLE `transaksi_item`
  ADD PRIMARY KEY (`id_trans_item`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `berkas_driver`
--
ALTER TABLE `berkas_driver`
  MODIFY `id_berkas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_item`
--
ALTER TABLE `category_item`
  MODIFY `id_kategori_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category_merchant`
--
ALTER TABLE `category_merchant`
  MODIFY `id_kategori_merchant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `driver_job`
--
ALTER TABLE `driver_job`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `fitur`
--
ALTER TABLE `fitur`
  MODIFY `id_fitur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `forgot_password`
--
ALTER TABLE `forgot_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_transaksi`
--
ALTER TABLE `history_transaksi`
  MODIFY `nomor` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_news`
--
ALTER TABLE `kategori_news`
  MODIFY `id_kategori_news` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id_k` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kodepromo`
--
ALTER TABLE `kodepromo`
  MODIFY `id_promo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list_bank`
--
ALTER TABLE `list_bank`
  MODIFY `id_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `id_merchant` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payusettings`
--
ALTER TABLE `payusettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promosi`
--
ALTER TABLE `promosi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating_driver`
--
ALTER TABLE `rating_driver`
  MODIFY `nomor` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saldo`
--
ALTER TABLE `saldo`
  MODIFY `nomor` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_transaksi`
--
ALTER TABLE `status_transaksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_detail_merchant`
--
ALTER TABLE `transaksi_detail_merchant`
  MODIFY `id_trans_merchant` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_detail_send`
--
ALTER TABLE `transaksi_detail_send`
  MODIFY `id_send` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_item`
--
ALTER TABLE `transaksi_item`
  MODIFY `id_trans_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
