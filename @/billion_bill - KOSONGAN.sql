-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2022 at 10:40 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billion_bill`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_akses`
--

CREATE TABLE `tb_akses` (
  `staff_akses` varchar(255) NOT NULL,
  `status_akses` varchar(255) NOT NULL,
  `admin_akses` varchar(255) NOT NULL,
  `waktu_akses` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_akses`
--

INSERT INTO `tb_akses` (`staff_akses`, `status_akses`, `admin_akses`, `waktu_akses`) VALUES
('BILL-PST-00001', 'ADMIN', 'BILL-PST-00001', '2022-03-15 07:29:36'),
('BILL-PST-00001', 'PUSAT', 'BILL-PST-00001', '2022-03-15 12:15:13'),
('BILL-PST-00003', 'PUSAT', 'BILL-PST-00001', '2022-05-25 08:21:50'),
('BILL-PST-00002', 'PUSAT', 'BILL-PST-00001', '2022-05-25 08:21:56'),
('BILL-PST-00002', 'ADMIN', 'BILL-PST-00001', '2022-05-25 08:22:41'),
('BILL-PST-00003', 'ADMIN', 'BILL-PST-00001', '2022-05-25 08:22:41'),
('BILL-PST-00004', 'ADMIN', 'BILL-PST-00001', '2022-05-25 08:23:50'),
('BILL-PST-00005', 'ADMIN', 'BILL-PST-00005', '2022-05-25 08:26:19'),
('BILL-PST-00006', 'PUSAT', 'BILL-PST-00001', '2022-05-25 08:26:58'),
('BILL-SBY-00001', 'HEAD', 'BILL-PST-00001', '2022-05-25 08:27:55'),
('BILL-SBY-00002', 'HEAD', 'BILL-PST-00001', '2022-05-25 08:28:13'),
('BILL-SBY-00003', 'HEAD', 'BILL-PST-00001', '2022-05-25 08:28:52'),
('BILL-SMG-00001', 'HEAD', 'BILL-PST-00001', '2022-05-25 08:29:25'),
('BILL-SBY-00004', 'COUNTER', 'BILL-PST-00001', '2022-05-25 08:30:16'),
('BILL-SBY-00005', 'COUNTER', 'BILL-PST-00001', '2022-05-25 08:30:33'),
('BILL-SBY-00006', 'COUNTER', 'BILL-PST-00001', '2022-05-25 08:30:51'),
('BILL-SBY-00007', 'COUNTER', 'BILL-PST-00001', '2022-05-25 08:31:35'),
('BILL-SBY-00008', 'GUDANG', 'BILL-PST-00001', '2022-05-25 08:31:55'),
('BILL-SBY-00009', 'GUDANG', 'BILL-PST-00001', '2022-05-25 08:32:11'),
('BILL-SMG-00002', 'GUDANG', 'BILL-PST-00001', '2022-05-25 08:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `tb_beli`
--

CREATE TABLE `tb_beli` (
  `id_beli` varchar(255) NOT NULL,
  `tgl_beli` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_beli` int(255) NOT NULL,
  `status_beli` varchar(255) NOT NULL,
  `cara_bayar_beli` varchar(255) NOT NULL,
  `jenis_beli` varchar(255) NOT NULL,
  `event_beli` varchar(255) NOT NULL,
  `staff_beli` varchar(255) NOT NULL,
  `supplier_beli` varchar(255) NOT NULL,
  `tgl_approv_beli` timestamp NOT NULL DEFAULT current_timestamp(),
  `counter_beli` varchar(255) NOT NULL,
  `kantor_beli` varchar(255) NOT NULL,
  `keterangan_beli` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_beli_event`
--

CREATE TABLE `tb_beli_event` (
  `id_beli_event` varchar(255) NOT NULL,
  `tgl_beli_event` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_beli_event` int(255) NOT NULL,
  `cara_bayar_beli_event` varchar(255) NOT NULL,
  `jenis_beli_event` varchar(255) NOT NULL,
  `event_beli_event` varchar(255) NOT NULL,
  `staff_beli_event` varchar(255) NOT NULL,
  `kantor_beli_event` varchar(255) NOT NULL,
  `keterangan_beli_event` varchar(255) NOT NULL,
  `stat_beli_event` varchar(255) NOT NULL,
  `supplier_beli_event` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_beli`
--

CREATE TABLE `tb_detail_beli` (
  `nota_detbeli` varchar(255) NOT NULL,
  `produk_detbeli` varchar(255) NOT NULL,
  `harga_detbeli` varchar(255) NOT NULL,
  `qty_detbeli` int(255) NOT NULL,
  `diskon_detbeli` int(255) NOT NULL,
  `total_jumlah_detbeli` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_beli_event`
--

CREATE TABLE `tb_detail_beli_event` (
  `nota_detbelev` varchar(255) NOT NULL,
  `produk_detbelev` varchar(255) NOT NULL,
  `harga_detbelev` varchar(255) NOT NULL,
  `qty_detbelev` int(255) NOT NULL,
  `diskon_detbelev` int(255) NOT NULL,
  `total_jumlah_detbelev` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_events`
--

CREATE TABLE `tb_detail_events` (
  `id_det_event` int(11) NOT NULL,
  `nama_det_event` varchar(255) NOT NULL,
  `event_det_event` varchar(255) NOT NULL,
  `status_det_event` varchar(255) NOT NULL,
  `keterangan_det_event` varchar(255) NOT NULL,
  `time_det_event` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `office_det_event` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_fp`
--

CREATE TABLE `tb_detail_fp` (
  `id_detfp` varchar(255) NOT NULL,
  `produk_detfp` varchar(255) NOT NULL,
  `jum_detfp` int(255) NOT NULL,
  `harga_detfp` int(255) NOT NULL,
  `totjum_detfp` int(255) NOT NULL,
  `diskon_detfp` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_jual`
--

CREATE TABLE `tb_detail_jual` (
  `nota_detjual` varchar(255) NOT NULL,
  `produk_detjual` varchar(255) NOT NULL,
  `harga_detjual` varchar(255) NOT NULL,
  `qty_detjual` int(255) NOT NULL,
  `diskon_detjual` int(255) NOT NULL,
  `total_jumlah_detjual` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_jual_konsi`
--

CREATE TABLE `tb_detail_jual_konsi` (
  `nota_detjk` varchar(255) NOT NULL,
  `produk_detjk` varchar(255) NOT NULL,
  `harga_detjk` int(255) NOT NULL,
  `qty_detjk` int(255) NOT NULL,
  `diskon_detjk` int(255) NOT NULL,
  `totjum_detjk` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_mankonsi`
--

CREATE TABLE `tb_detail_mankonsi` (
  `nota_detmk` varchar(255) NOT NULL,
  `produk_detmk` varchar(255) NOT NULL,
  `harga_detmk` varchar(255) NOT NULL,
  `qty_detmk` int(255) NOT NULL,
  `diskon_detmk` int(255) NOT NULL,
  `totjum_detmk` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_mantrans`
--

CREATE TABLE `tb_detail_mantrans` (
  `nota_detmt` varchar(255) NOT NULL,
  `produk_detmt` varchar(255) NOT NULL,
  `harga_detmt` varchar(255) NOT NULL,
  `qty_detmt` int(255) NOT NULL,
  `diskon_detmt` int(255) NOT NULL,
  `total_jumlah_detmt` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_po`
--

CREATE TABLE `tb_detail_po` (
  `nota_detpo` varchar(255) NOT NULL,
  `produk_detpo` varchar(255) NOT NULL,
  `harga_detpo` varchar(255) NOT NULL,
  `qty_detpo` int(255) NOT NULL,
  `diskon_detpo` int(255) NOT NULL,
  `total_jumlah_detpo` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_restok`
--

CREATE TABLE `tb_detail_restok` (
  `nota_detrestok` varchar(255) NOT NULL,
  `produk_detrestok` varchar(255) NOT NULL,
  `harga_detrestok` varchar(255) NOT NULL,
  `qty_detrestok` int(255) NOT NULL,
  `diskon_detrestok` int(255) NOT NULL,
  `total_jumlah_detrestok` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_retur_event`
--

CREATE TABLE `tb_detail_retur_event` (
  `id_detretevt` varchar(255) NOT NULL,
  `produk_detretevt` varchar(255) NOT NULL,
  `jumret_detretevt` int(255) NOT NULL,
  `harga_detretevt` int(255) NOT NULL,
  `totjum_detretevt` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_retur_transaksi`
--

CREATE TABLE `tb_detail_retur_transaksi` (
  `id_detrettrans` varchar(255) NOT NULL,
  `produk_detrettrans` varchar(255) NOT NULL,
  `jumret_detrettrans` int(255) NOT NULL,
  `harga_detrettrans` int(255) NOT NULL,
  `totjum_detrettrans` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_events`
--

CREATE TABLE `tb_events` (
  `id_events` varchar(255) NOT NULL,
  `nama_events` varchar(255) DEFAULT NULL,
  `level_events` varchar(255) NOT NULL,
  `time_events` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `keterangan_events` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_events`
--

INSERT INTO `tb_events` (`id_events`, `nama_events`, `level_events`, `time_events`, `keterangan_events`) VALUES
('BCP', 'Bootcamp', 'BESAR', '2022-04-06 02:37:11', ''),
('BEM', 'Billionaires Enterprise Meeting', 'SEDANG', '2022-04-06 02:37:54', ''),
('BIG', 'Billionaires Instructor Gathering', 'BESAR', '2022-04-06 02:37:15', 'Billionaires Instructor Gathering'),
('BMW', 'Billionaires Meeting Weekend', 'BESAR', '2022-04-06 02:37:18', ''),
('BOM', 'Billionaires Oppo Meetinng', 'SEDANG', '2022-04-06 02:37:52', 'Billionaires Oppo Meetinng'),
('BSM', 'Billionaires Special Meeting', 'SEDANG', '2022-04-06 02:37:50', ''),
('BST', 'Billionaires Executive System Training', 'BESAR', '2022-04-06 02:37:28', ''),
('EIE', 'Entrepreneurship Is Easy', 'SEDANG', '2022-04-06 02:37:48', ''),
('ELT', 'Enterprise Leadership Immersive Training Experience', 'BESAR', '2022-04-06 02:37:32', ''),
('PLI', 'Pelican Import', 'SEDANG', '2022-04-06 02:37:46', ''),
('RTS', 'Road To Success', 'BESAR', '2022-04-06 02:37:36', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_free_produk`
--

CREATE TABLE `tb_free_produk` (
  `id_fp` varchar(255) NOT NULL,
  `event_fp` varchar(255) NOT NULL,
  `staff_fp` varchar(255) NOT NULL,
  `waktu_fp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kantor_fp` varchar(255) NOT NULL,
  `total_fp` int(255) NOT NULL,
  `keterangan_fp` varchar(255) NOT NULL,
  `status_fp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_gudang`
--

CREATE TABLE `tb_gudang` (
  `kode_produk_gudang` varchar(255) DEFAULT NULL,
  `kode_office_gudang` varchar(255) DEFAULT NULL,
  `jml_produk_gudang` int(255) DEFAULT NULL,
  `supplier_gudang` varchar(255) DEFAULT NULL,
  `staff_gudang` varchar(255) DEFAULT NULL,
  `tgl_update_gudang` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `event_gudang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_harga_produk`
--

CREATE TABLE `tb_harga_produk` (
  `id_harga` int(255) NOT NULL,
  `produk_harga` varchar(255) DEFAULT NULL,
  `region_harga` varchar(255) DEFAULT NULL,
  `harga_harian` int(255) DEFAULT NULL,
  `status_harga` varchar(255) DEFAULT NULL,
  `waktu_harga` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jual`
--

CREATE TABLE `tb_jual` (
  `id_jual` varchar(255) NOT NULL,
  `tgl_order_jual` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `acara_jual` varchar(255) NOT NULL,
  `total_jual` int(255) NOT NULL,
  `cara_bayar_jual` varchar(255) NOT NULL,
  `status_jual` varchar(255) NOT NULL,
  `tgl_approv_jual` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `counter_jual` varchar(255) NOT NULL,
  `gudang_jual` varchar(255) NOT NULL,
  `keterangan_jual` varchar(255) NOT NULL,
  `jenis_jual` varchar(255) NOT NULL,
  `nama_customer` varchar(255) NOT NULL,
  `tlp_customer` varchar(255) NOT NULL,
  `checking_by` varchar(255) NOT NULL,
  `kantor_jual` varchar(255) NOT NULL,
  `voucher_jual` int(255) NOT NULL,
  `dibayar_jual` int(255) NOT NULL,
  `kembalian_jual` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jual_konsi`
--

CREATE TABLE `tb_jual_konsi` (
  `id_jk` varchar(255) NOT NULL,
  `tgl_order_jk` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_jk` int(255) NOT NULL,
  `cara_bayar_jk` varchar(255) NOT NULL,
  `status_jk` varchar(255) NOT NULL,
  `tgl_approv_jk` timestamp NOT NULL DEFAULT current_timestamp(),
  `counter_jk` varchar(255) NOT NULL,
  `gudang_jk` varchar(255) NOT NULL,
  `keterangan_jk` varchar(255) NOT NULL,
  `jenis_jk` varchar(255) NOT NULL,
  `cs_jk` varchar(255) NOT NULL,
  `kantor_jk` varchar(255) NOT NULL,
  `retur_jk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` varchar(255) NOT NULL,
  `nama_kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `nama_kategori`) VALUES
('BK', 'Buku'),
('BRS', 'Brosur'),
('CD', 'Cd'),
('DGT', 'Digital'),
('DVD', 'Dvd'),
('LAIN', 'Lain-lain'),
('MCH', 'Merchan'),
('PKT', 'Paket'),
('SMS', 'Sort Message Services'),
('TEROI', 'Testing'),
('TKT', 'Tiket'),
('TLS', 'Tools'),
('TSH', 'T-shirt'),
('VCH', 'Voucher'),
('VD', 'Video');

-- --------------------------------------------------------

--
-- Table structure for table `tb_man_konsi`
--

CREATE TABLE `tb_man_konsi` (
  `id_mk` varchar(255) NOT NULL,
  `tgl_order_mk` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_mk` int(255) NOT NULL,
  `cara_bayar_mk` varchar(255) NOT NULL,
  `status_mk` varchar(255) NOT NULL,
  `tgl_approv_mk` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `counter_mk` varchar(255) NOT NULL,
  `gudang_mk` varchar(255) NOT NULL,
  `keterangan_mk` varchar(255) NOT NULL,
  `jenis_mk` varchar(255) NOT NULL,
  `cs_mk` varchar(255) NOT NULL,
  `checking_mk` varchar(255) NOT NULL,
  `kantor_mk` varchar(255) NOT NULL,
  `voucher_mk` int(255) NOT NULL,
  `dibayar_mk` int(255) NOT NULL,
  `kembalian_mk` int(255) NOT NULL,
  `manual_mk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_man_trans`
--

CREATE TABLE `tb_man_trans` (
  `id_mt` varchar(255) NOT NULL,
  `tgl_order_mt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `acara_mt` varchar(255) NOT NULL,
  `total_mt` int(255) NOT NULL,
  `cara_bayar_mt` varchar(255) NOT NULL,
  `status_mt` varchar(255) NOT NULL,
  `tgl_approv_mt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `counter_mt` varchar(255) NOT NULL,
  `gudang_mt` varchar(255) NOT NULL,
  `keterangan_mt` varchar(255) NOT NULL,
  `jenis_mt` varchar(255) NOT NULL,
  `cs_mt` varchar(255) NOT NULL,
  `tlp_mt` varchar(255) NOT NULL,
  `checking_mt` varchar(255) NOT NULL,
  `kantor_mt` varchar(255) NOT NULL,
  `voucher_mt` int(255) NOT NULL,
  `dibayar_mt` int(255) NOT NULL,
  `kembalian_mt` int(255) NOT NULL,
  `manual_mt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_notif_retur`
--

CREATE TABLE `tb_notif_retur` (
  `event_retur` varchar(255) NOT NULL,
  `status_retur` int(11) NOT NULL,
  `waktu_retur` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `staff_retur` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_office`
--

CREATE TABLE `tb_office` (
  `id_office` varchar(10) NOT NULL,
  `nama_office` varchar(255) NOT NULL,
  `kota_office` varchar(255) NOT NULL,
  `region_office` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_office`
--

INSERT INTO `tb_office` (`id_office`, `nama_office`, `kota_office`, `region_office`) VALUES
('BCL', 'Billionaires Citra Land', 'SURABAYA', 'R1'),
('BTU', 'Billionaires Batu', 'BATU', 'R1'),
('JKT', 'Billionaires Jakarta', 'JAKARTA', 'R1'),
('MKS', 'Billionaires Makasar', 'MAKASAR', 'R2'),
('PST', 'Billionaires Pusat', 'SURABAYA', 'R1'),
('SBY', 'Billionaires  Surabaya', 'SURABAYA', 'R1'),
('SMG', 'Billionaires Semarang', 'SEMARANG', 'R1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_paket_produk`
--

CREATE TABLE `tb_paket_produk` (
  `id_paket` int(255) NOT NULL,
  `produk_paket` varchar(255) DEFAULT NULL,
  `seq_paket` varchar(255) DEFAULT NULL,
  `det_produk` varchar(255) DEFAULT NULL,
  `jum_pro_paket` int(255) DEFAULT NULL,
  `status_paket` varchar(255) DEFAULT NULL,
  `waktu_paket` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_po`
--

CREATE TABLE `tb_po` (
  `id_po` varchar(255) NOT NULL,
  `tgl_po` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_po` int(255) NOT NULL,
  `status_po` varchar(255) NOT NULL,
  `cara_bayar_po` varchar(255) NOT NULL,
  `jenis_po` varchar(255) NOT NULL,
  `event_po` varchar(255) NOT NULL,
  `staff_po` varchar(255) NOT NULL,
  `supplier_po` varchar(255) NOT NULL,
  `tgl_approv_po` timestamp NOT NULL DEFAULT current_timestamp(),
  `counter_po` varchar(255) NOT NULL,
  `kantor_po` varchar(255) NOT NULL,
  `keterangan_po` varchar(255) NOT NULL,
  `beli_po` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` varchar(255) NOT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `kategori_produk` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_region`
--

CREATE TABLE `tb_region` (
  `id_region` varchar(255) NOT NULL,
  `nama_region` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_region`
--

INSERT INTO `tb_region` (`id_region`, `nama_region`) VALUES
('R1', 'Region 1'),
('R2', 'Region 2'),
('R3', 'Region 3'),
('R4', 'Region 4');

-- --------------------------------------------------------

--
-- Table structure for table `tb_restok`
--

CREATE TABLE `tb_restok` (
  `id_restok` varchar(255) NOT NULL,
  `tgl_restok` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_restok` int(255) NOT NULL,
  `status_restok` varchar(255) NOT NULL,
  `jenis_restok` varchar(255) NOT NULL,
  `event_restok` varchar(255) NOT NULL,
  `staff_restok` varchar(255) NOT NULL,
  `kantor_restok` varchar(255) NOT NULL,
  `keterangan_restok` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_retur_event`
--

CREATE TABLE `tb_retur_event` (
  `id_returevt` varchar(255) NOT NULL,
  `event_returevt` varchar(255) NOT NULL,
  `staff_returevt` varchar(255) NOT NULL,
  `waktu_returevt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kantor_returevt` varchar(255) NOT NULL,
  `total_returevt` int(255) NOT NULL,
  `keterangan_returevt` varchar(255) NOT NULL,
  `status_returevt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_retur_transaksi`
--

CREATE TABLE `tb_retur_transaksi` (
  `id_retur` varchar(255) NOT NULL,
  `event_retur` varchar(255) NOT NULL,
  `staff_retur` varchar(255) NOT NULL,
  `waktu_retur` timestamp NOT NULL DEFAULT current_timestamp(),
  `kantor_retur` varchar(255) NOT NULL,
  `total_retur` int(255) NOT NULL,
  `keterangan_retur` varchar(255) NOT NULL,
  `status_retur` varchar(255) NOT NULL,
  `jenis_retur` varchar(255) NOT NULL,
  `notajual_retur` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_staff`
--

CREATE TABLE `tb_staff` (
  `kode_staff` varchar(255) NOT NULL,
  `nama_staff` varchar(255) NOT NULL,
  `uname_staff` varchar(255) NOT NULL,
  `pass_staff` varchar(255) NOT NULL,
  `create_staff` varchar(255) NOT NULL,
  `office_staff` varchar(255) NOT NULL,
  `active_staff` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_staff`
--

INSERT INTO `tb_staff` (`kode_staff`, `nama_staff`, `uname_staff`, `pass_staff`, `create_staff`, `office_staff`, `active_staff`) VALUES
('BILL-PST-00001', 'juki', 'admin', 'admin', 'BILL-PST-00001', 'PST', 'ON'),
('BILL-PST-00002', 'widhi', 'widhi', 'widhi', 'BILL-PST-00001', 'PST', 'ON'),
('BILL-PST-00003', 'adi', 'adi', 'adi', 'BILL-PST-00001', 'PST', 'ON'),
('BILL-PST-00004', 'Tini', 'tini', 'tini', 'BILL-PST-00001', 'PST', 'ON'),
('BILL-PST-00005', 'Else', 'else', 'else', 'BILL-PST-00001', 'PST', 'ON'),
('BILL-PST-00006', 'Puji', 'puji', 'puji', 'BILL-PST-00001', 'PST', 'ON'),
('BILL-PST-00007', 'Albert', 'albert', 'albert', 'BILL-PST-00001', 'PST', 'ON'),
('BILL-SBY-00001', 'Winda', 'winda', 'winda', 'BILL-PST-00001', 'SBY', 'ON'),
('BILL-SBY-00002', 'Wiwik', 'wiwik', 'wiwik', 'BILL-PST-00001', 'SBY', 'ON'),
('BILL-SBY-00003', 'Hery', 'hery', 'hery', 'BILL-PST-00001', 'SBY', 'ON'),
('BILL-SBY-00004', 'Elisa', 'elisa', 'elisa', 'BILL-PST-00001', 'SBY', 'ON'),
('BILL-SBY-00005', 'Fitri', 'fitri', 'fitri', 'BILL-PST-00001', 'SBY', 'ON'),
('BILL-SBY-00006', 'Beny', 'beny', 'beny', 'BILL-PST-00001', 'SBY', 'ON'),
('BILL-SBY-00007', 'Fany', 'fany', 'fany', 'BILL-PST-00001', 'SBY', 'ON'),
('BILL-SBY-00008', 'Dedy', 'dedy', 'dedy', 'BILL-PST-00001', 'SBY', 'ON'),
('BILL-SBY-00009', 'Herdy', 'herdy', 'herdy', 'BILL-PST-00001', 'SBY', 'ON'),
('BILL-SMG-00001', 'Suasana', 'suasana', 'suasana', 'BILL-PST-00001', 'SMG', 'ON'),
('BILL-SMG-00002', 'Nindi', 'nindi', 'nindi', 'BILL-PST-00001', 'SMG', 'ON');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_beli`
--
ALTER TABLE `tb_beli`
  ADD PRIMARY KEY (`id_beli`);

--
-- Indexes for table `tb_beli_event`
--
ALTER TABLE `tb_beli_event`
  ADD PRIMARY KEY (`id_beli_event`);

--
-- Indexes for table `tb_detail_events`
--
ALTER TABLE `tb_detail_events`
  ADD PRIMARY KEY (`id_det_event`);

--
-- Indexes for table `tb_events`
--
ALTER TABLE `tb_events`
  ADD PRIMARY KEY (`id_events`);

--
-- Indexes for table `tb_free_produk`
--
ALTER TABLE `tb_free_produk`
  ADD PRIMARY KEY (`id_fp`);

--
-- Indexes for table `tb_harga_produk`
--
ALTER TABLE `tb_harga_produk`
  ADD PRIMARY KEY (`id_harga`);

--
-- Indexes for table `tb_jual`
--
ALTER TABLE `tb_jual`
  ADD PRIMARY KEY (`id_jual`);

--
-- Indexes for table `tb_jual_konsi`
--
ALTER TABLE `tb_jual_konsi`
  ADD PRIMARY KEY (`id_jk`);

--
-- Indexes for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tb_man_konsi`
--
ALTER TABLE `tb_man_konsi`
  ADD PRIMARY KEY (`id_mk`);

--
-- Indexes for table `tb_man_trans`
--
ALTER TABLE `tb_man_trans`
  ADD PRIMARY KEY (`id_mt`);

--
-- Indexes for table `tb_office`
--
ALTER TABLE `tb_office`
  ADD PRIMARY KEY (`id_office`);

--
-- Indexes for table `tb_paket_produk`
--
ALTER TABLE `tb_paket_produk`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `tb_po`
--
ALTER TABLE `tb_po`
  ADD PRIMARY KEY (`id_po`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `tb_region`
--
ALTER TABLE `tb_region`
  ADD PRIMARY KEY (`id_region`);

--
-- Indexes for table `tb_restok`
--
ALTER TABLE `tb_restok`
  ADD PRIMARY KEY (`id_restok`);

--
-- Indexes for table `tb_retur_event`
--
ALTER TABLE `tb_retur_event`
  ADD PRIMARY KEY (`id_returevt`);

--
-- Indexes for table `tb_retur_transaksi`
--
ALTER TABLE `tb_retur_transaksi`
  ADD PRIMARY KEY (`id_retur`);

--
-- Indexes for table `tb_staff`
--
ALTER TABLE `tb_staff`
  ADD PRIMARY KEY (`kode_staff`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_detail_events`
--
ALTER TABLE `tb_detail_events`
  MODIFY `id_det_event` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_paket_produk`
--
ALTER TABLE `tb_paket_produk`
  MODIFY `id_paket` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
