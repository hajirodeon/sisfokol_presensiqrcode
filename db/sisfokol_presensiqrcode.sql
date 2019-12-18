-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 18, 2019 at 02:14 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sisfokol_presensiqrcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminx`
--

CREATE TABLE `adminx` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `usernamex` varchar(15) NOT NULL DEFAULT '',
  `passwordx` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adminx`
--

INSERT INTO `adminx` (`kd`, `usernamex`, `passwordx`) VALUES
('e4ea2f7dfb2e5c51e38998599e90afc2', 'admin', 'e9b690b66c32ca3237bb283e718f342a');

-- --------------------------------------------------------

--
-- Table structure for table `item_pinjam`
--

CREATE TABLE `item_pinjam` (
  `kd` varchar(50) NOT NULL,
  `orang_kd` varchar(50) NOT NULL,
  `orang_qrcode` varchar(100) NOT NULL,
  `orang_kode` varchar(50) NOT NULL,
  `orang_nama` varchar(100) NOT NULL,
  `postdate` datetime NOT NULL,
  `item_kd` varchar(50) NOT NULL,
  `item_kode` varchar(100) NOT NULL,
  `item_qrcode` varchar(100) NOT NULL,
  `item_nama` varchar(100) NOT NULL,
  `postdate_pinjam` datetime NOT NULL,
  `postdate_kembali` datetime NOT NULL,
  `ket` longtext NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `item_rekap`
--

CREATE TABLE `item_rekap` (
  `kd` varchar(50) NOT NULL,
  `item_kd` varchar(50) NOT NULL,
  `item_qrcode` varchar(100) NOT NULL,
  `item_kode` varchar(50) NOT NULL,
  `item_nama` varchar(100) NOT NULL,
  `tglnya` date NOT NULL,
  `postdate_pinjam` varchar(100) NOT NULL,
  `postdate_kembali` varchar(100) NOT NULL,
  `postdate` datetime NOT NULL,
  `jml_jam` varchar(10) NOT NULL,
  `jml_menit` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `item_rekap`
--

INSERT INTO `item_rekap` (`kd`, `item_kd`, `item_qrcode`, `item_kode`, `item_nama`, `tglnya`, `postdate_pinjam`, `postdate_kembali`, `postdate`, `jml_jam`, `jml_menit`) VALUES
('ee30a0ebc06b0987494006f5e6c7d8ca', '4ca247a447c4ab2bc6e66451da9a679c', '', '1', '1', '0000-00-00', '', '', '2019-12-07 04:12:45', '0', '0'),
('8bb64051bba2a6b975644d1686799622', 'e58e38b2481391c021e3c81782016f18', '', '2', '2', '0000-00-00', '', '', '2019-12-07 04:12:45', '0', '0'),
('820b9a2e3fc26e9c5c9a8e9ac967634e', '84d5212f80428d20360953fd740c417a', '', '3', '3', '0000-00-00', '', '', '2019-12-07 04:12:45', '0', '0'),
('7d7ac947bdf716b9baf6ebb2687b536b', 'b98328c0bd2b5f0ff6886d2066e3dc64', '', '4', '4', '0000-00-00', '', '', '2019-12-07 04:12:45', '0', '0'),
('0dc8d181f01c050d2657102a59bae793', '469ba8b90acad892156cb5a25dcdad27', '', '5', '5', '0000-00-00', '', '', '2019-12-07 04:12:45', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `m_item`
--

CREATE TABLE `m_item` (
  `kd` varchar(50) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `filex1` longtext NOT NULL,
  `postdate` datetime NOT NULL,
  `qrcode` varchar(100) NOT NULL,
  `pinjam_nama` varchar(100) NOT NULL,
  `pinjam_masuk` varchar(100) NOT NULL,
  `pinjam_pulang` varchar(100) NOT NULL,
  `pinjam_lama` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `m_item`
--

INSERT INTO `m_item` (`kd`, `kode`, `nama`, `filex1`, `postdate`, `qrcode`, `pinjam_nama`, `pinjam_masuk`, `pinjam_pulang`, `pinjam_lama`) VALUES
('4ca247a447c4ab2bc6e66451da9a679c', '1', '1', '4ca247a447c4ab2bc6e66451da9a679c-1.jpg', '2019-12-18 02:12:43', '33531', '. ', '', '', '0 Jam, 0 Menit'),
('e58e38b2481391c021e3c81782016f18', '2', '2', 'e58e38b2481391c021e3c81782016f18-1.jpg', '2019-12-18 02:12:53', '45452', '. ', '', '', '0 Jam, 0 Menit'),
('84d5212f80428d20360953fd740c417a', '3', '3', '84d5212f80428d20360953fd740c417a-1.jpg', '2019-12-18 02:13:02', '47243', '. ', '', '', '0 Jam, 0 Menit'),
('b98328c0bd2b5f0ff6886d2066e3dc64', '4', '4', 'b98328c0bd2b5f0ff6886d2066e3dc64-1.jpg', '2019-12-18 02:13:12', '98844', '. ', '', '', '0 Jam, 0 Menit'),
('469ba8b90acad892156cb5a25dcdad27', '5', '5', '469ba8b90acad892156cb5a25dcdad27-1.jpg', '2019-12-18 02:13:30', '82685', '. ', '', '', '0 Jam, 0 Menit');

-- --------------------------------------------------------

--
-- Table structure for table `m_orang`
--

CREATE TABLE `m_orang` (
  `kd` varchar(50) NOT NULL,
  `qrcode` varchar(100) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `filex1` longtext NOT NULL,
  `postdate` datetime NOT NULL,
  `jabatan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `m_orang`
--

INSERT INTO `m_orang` (`kd`, `qrcode`, `kode`, `nama`, `filex1`, `postdate`, `jabatan`) VALUES
('97a7031d52a59f7dba2f3120e6d44158', '4985344', '4985344', 'DARTO', '', '2019-11-05 21:24:43', ''),
('d5477075758574b6595ceef834f14a27', '9225344', '9225344', 'SUWARNI', '', '2019-11-05 21:24:43', ''),
('fc2d49ab117bbb89505c0981ede1535b', '5665344', '5665344', 'SUPRIJANTO', '', '2019-11-05 21:24:43', ''),
('6f8e004923d6828458d07f12b194cf6e', '4525344', '4525344', 'SUTOMO', '', '2019-11-05 21:24:43', ''),
('1cae6dbd48cb6522e3334aea8e6afb08', '7125344', '7125344', 'KURNIA ISNU MARDIATI', '', '2019-11-05 21:24:43', ''),
('36beace592ea3a3df08092d990198590', '3825344', '3825344', 'RIBUT RIYANTO', '', '2019-11-05 21:24:43', ''),
('0a5f34ef62b471cec4d9ff526ec3fb8c', '4285344', '4285344', 'FADJAR PRIBADI', '', '2019-11-05 21:24:43', ''),
('2aad20767de0661c20903b5079755f67', '3555344', '3555344', 'MUDJIYANTO', '', '2019-11-05 21:24:43', ''),
('a210a26516f123d7844abe06caa8b086', '9385344', '9385344', 'SIYAM', '', '2019-11-05 21:24:43', ''),
('dcbee5d5226e92dd4de8e01a60692d9a', '8565344', '8565344', 'SALIMUN', '', '2019-11-05 21:24:43', ''),
('b34370ba622d6fafabd30cd26a1f6a8b', '8705344', '8705344', 'SHOLIHIN', '', '2019-11-05 21:24:43', ''),
('18f9d94a7417cfc5dcf76b975d8e7fbc', '4465344', '4465344', 'NARTI', '', '2019-11-05 21:24:43', ''),
('a7d260636d62cf311ea1b2f7d1c6e0a2', '9845344', '9845344', 'ELIS DWI LYDIAWATI', '', '2019-11-05 21:24:43', ''),
('0074c3b3416c5353be528b9ce9781e47', '9115344', '9115344', 'BAGUS RIYANTO', '', '2019-11-05 21:24:43', ''),
('8e5b2899ba8243f23501bf6b4abc7a99', '2535344', '2535344', 'EKOWATI SRI APRIANI', '', '2019-11-05 21:24:43', ''),
('95e2a7a76e01035cf31009add8fbff0b', '4485344', '4485344', 'RIN MADYANING SUKARELAWATI', '', '2019-11-05 21:24:43', ''),
('e37532cef8eed0396931d6d6d73aa09f', '2095344', '2095344', 'NANIK SETYAWATI AMADHY', '', '2019-11-05 21:24:43', ''),
('1d4a60095d9b8a2efb5e0b8bcd04d870', '5135344', '5135344', 'CHURNIAWAN BUDI SULISTIJO', '', '2019-11-05 21:24:43', ''),
('9f1272381a5bd7ba9d8e05deb4c8ae27', '4805344', '4805344', 'WASKITANINGTYAS', '', '2019-11-05 21:24:43', ''),
('3149f9284e1fda536f9ec7721bc47994', '8305344', '8305344', 'SRI ASIH', '', '2019-11-05 21:24:43', ''),
('82ed9b34e372e1f36d219ecf10411d69', '8325344', '8325344', 'SARIADI', '', '2019-11-05 21:24:43', ''),
('2b16e14d0104de56c2bd14714de14781', '3355344', '3355344', 'SIBIANA', '', '2019-11-05 21:24:43', ''),
('61a095415f4ddcf6195911e33482b579', '5175344', '5175344', 'KADARISMANTO', '', '2019-11-05 21:24:43', ''),
('45d87172a468acb8fd5ca1f23977bfe1', '6125344', '6125344', 'WIBOWO', '', '2019-11-05 21:24:43', ''),
('a4e0cd6dcb23e6c03fb520ca7768f593', '7625344', '7625344', 'SUTOYO', '', '2019-11-05 21:24:43', ''),
('59813b3d58ad7d93b3161a88b6e6d66b', '5635344', '5635344', 'ASMURI', '', '2019-11-05 21:24:43', ''),
('fe134d69e36dae3eaef3338e5e1a22a8', '1075344', '1075344', 'GATUT DJAKA SUSILA', '', '2019-11-05 21:24:43', ''),
('79424aeab95200a88ac4f6782f503947', '9775344', '9775344', 'ENDAH WAHYU HARIYANI', '', '2019-11-05 21:24:43', ''),
('d97e319913e6c618f475423bd7fcae1f', '6235344', '6235344', 'SARWITO', '', '2019-11-05 21:24:43', ''),
('020e5fab0395a696c75e92812c2534ed', '1065344', '1065344', 'AGUS WIBOWO', '', '2019-11-05 21:24:43', ''),
('eb4d30971fc551e505e9565135d1f183', '1085344', '1085344', 'AINU MUHAMADI', '', '2019-11-05 21:24:43', ''),
('108f30e7341986c5a5650880043d129a', '4395344', '4395344', 'ROEDHIHARTATI', '', '2019-11-05 21:24:43', ''),
('923da7c7a89aa775591c6b56c9638430', '2655344', '2655344', 'RADI', '', '2019-11-05 21:24:43', ''),
('06d5dc0714689d27d0cec8aa9710fe9d', '5645344', '5645344', 'NUR HIDAYAT', '', '2019-11-05 21:24:43', ''),
('e03e1a3f20efb108a957fdc0ee644f91', '8285344', '8285344', 'BUDI SANTOSO', '', '2019-11-05 21:24:43', ''),
('aec76e00f4c488077b8b4585b9308841', '3635344', '3635344', 'HARNO', '', '2019-11-05 21:24:43', ''),
('323ba56d852ac1cb97edef09dfe7dffd', '4185344', '4185344', 'WIWIK WIYATI', '', '2019-11-05 21:24:43', ''),
('09ad674cee5be86d6921b64d3142b31f', '5835344', '5835344', 'ESTI ANTARI', '', '2019-11-05 21:24:43', ''),
('d4baf5e0c6583819837c59a400842e05', '1905344', '1905344', 'SURURIN MUNAYATI', '', '2019-11-05 21:24:43', ''),
('d4b7430f5d015bf8b820545d331975b0', '3905344', '3905344', 'ARIE NURWIYANTI', '', '2019-11-05 21:24:43', ''),
('10adaa5a1ad5793b3b9053908bb7f4b3', '6195344', '6195344', 'MURNIYATI', '', '2019-11-05 21:24:43', ''),
('5cee102dd8f47ff3bb292517b673042d', '7035344', '7035344', 'KRISTIONO', '', '2019-11-05 21:24:43', ''),
('e15fd44248dc26b1be61825f8060d942', '4805344', '4805344', 'YUNI PURWANINGSIH', '', '2019-11-05 21:24:43', ''),
('bf239e107acb8f1f8fd1dce61401ca02', '9035344', '9035344', 'SITI MAIMUNAH', '', '2019-11-05 21:24:43', ''),
('5f27a3d19df130f8031f38d2201be996', '5505344', '5505344', 'SUWITO', '', '2019-11-05 21:24:43', ''),
('c99b8ce61445926fb011c2afababaf4f', '3475344', '3475344', 'MARGIATI', '', '2019-11-05 21:24:43', ''),
('f28383ca4389d72bced515ce0c2e39a2', '5415344', '5415344', 'SUJUD', '', '2019-11-05 21:24:43', ''),
('52b68ca79742c37766d395868aaa64c8', '8615344', '8615344', 'ANING HIDAYATI', '', '2019-11-05 21:24:43', ''),
('d3dcb4fe87603ea29208e0e8ba4622c1', '9065344', '9065344', 'SURATI', '', '2019-11-05 21:24:43', ''),
('b3ffc8b3d3df51ceba2d5b2200b38684', '2265344', '2265344', 'KARTIKO HADI', '', '2019-11-05 21:24:43', ''),
('e99db93ae49417cccdd395447091fa07', '9075344', '9075344', 'RENI INDARTI', '', '2019-11-05 21:24:43', ''),
('7495e989dc2f1c8d89c38cc89081f024', '5325344', '5325344', 'ISTINA HENDRIYANI', '', '2019-11-05 21:24:43', ''),
('9267748c79dce9655edf4376c1bb3e59', '9115344', '9115344', 'MARYONO', '', '2019-11-05 21:24:43', ''),
('e247948d4db43dea1e8059ba162328da', '8035344', '8035344', 'ELVI DWI ARIYANITA', '', '2019-11-05 21:24:43', ''),
('b2ee5cb05e22fef62e2692749dadad38', '3195344', '3195344', 'SITI NURUL CHOMARIYAH', '', '2019-11-05 21:24:43', ''),
('f57462cddd7afc7fcec5b6e4720ebb02', '3205344', '3205344', 'SUPRAYITNO', '', '2019-11-05 21:24:43', ''),
('dc42603dc3da8ae2e97cd8d8e5743f63', '5755344', '5755344', 'ANIK WINARSIH', '', '2019-11-05 21:24:43', ''),
('c86259344101ff61e15b648ffaf8b175', '3925344', '3925344', 'WAHJUDI SULISTIJONO', '', '2019-11-05 21:24:43', ''),
('796c022f1b4d4c70d9cde7ff96fc9a5b', '2825344', '2825344', 'ISNAINI', '', '2019-11-05 21:24:43', ''),
('2a9d800fab5c6dccd10310ab2c04c70b', '3865344', '3865344', 'TARYONO', '', '2019-11-05 21:24:43', ''),
('9fa4d5cd9511441876391c667a626cf6', '7665344', '7665344', 'KOCO YULI HARSIANTO', '', '2019-11-05 21:24:43', ''),
('0134683ea7ecd471cdf05f4afc2fdda2', '3995344', '3995344', 'SITI MUFAIDAH', '', '2019-11-05 21:24:43', ''),
('5fa56baa9dcfbc14f27b4b22abc3d500', '5075344', '5075344', 'DANU SETIYOKO', '', '2019-11-05 21:24:43', ''),
('adbb52ad0c6a0374a7c76cd979ecda10', '3535344', '3535344', 'HARI WAHYUNI', '', '2019-11-05 21:24:43', ''),
('543683bcf1fbeed20e363a5adaa9950e', '7735344', '7735344', 'KUNTJORO SETYO NUGROHO', '', '2019-11-05 21:24:43', ''),
('c87bfd22d98d041e9d9debf9c63b18d7', '1945344', '1945344', 'SUCI BUDI HANDIYANI', '', '2019-11-05 21:24:43', ''),
('6ec477a705cdf902e008c925b5b1e769', '7015344', '7015344', 'DWI WIYANTO', '', '2019-11-05 21:24:43', ''),
('20d7434181521a22709d8509ea342526', '7495344', '7495344', 'MUHTAROM', '', '2019-11-05 21:24:43', ''),
('abe9b41268a51f7267edeaa231236aa1', '7235344', '7235344', 'SIGID EKO MARYONO', '', '2019-11-05 21:24:43', ''),
('b07c3ddb948cf0515bb3f8c4c862f26a', '8185344', '8185344', 'ANANG SETYO NUGROHO', '', '2019-11-05 21:24:43', ''),
('fd6629330ef348c094815aefd0bfd03c', '7215344', '7215344', 'ISMIATIN', '', '2019-11-05 21:24:43', ''),
('0fbb62ccf908e9a5619cdd7539fa12ac', '4715344', '4715344', 'HENY NUR AISAH', '', '2019-11-05 21:24:43', ''),
('269a4200764c2d6d54783f4c20ecb01a', '4805344', '4805344', 'NARWOKO', '', '2019-11-05 21:24:43', ''),
('5f6443b4ccb88c40fe716ec9b3d8b1a6', '3405344', '3405344', 'WIDHIARI KUSUMANINGRUM', '', '2019-11-05 21:24:43', ''),
('fad667061f5f6cae488a834c0a4ef171', '2175344', '2175344', 'ASIH WINARNI', '', '2019-11-05 21:24:43', ''),
('e621bf293b2f0b0a1f6813fbbbfc34f3', '1555344', '1555344', 'SUKARNIASIH', '', '2019-11-05 21:24:43', ''),
('634836f5c66976992bd71c62ce2174bf', '7845344', '7845344', 'INDAH CATUR HANDAYANI', '', '2019-11-05 21:24:43', ''),
('4ee2ff30dca91e9d58df5d8a85979185', '8155344', '8155344', 'SITI RAHAYUNINGSIH', '', '2019-11-05 21:24:43', ''),
('14d87682a808665b3d3239efafe92214', '4885344', '4885344', 'FAJAR WIDODO', '', '2019-11-05 21:24:43', ''),
('a4e40e708ea43242efd68af44a5e5f56', '4205344', '4205344', 'TRI NURYANI JULAIKA', '', '2019-11-05 21:24:43', ''),
('38098bf9fcc6f0ece06aaa059d0e539c', '2995344', '2995344', 'HEVI SARI DEWI', '', '2019-11-05 21:24:43', ''),
('535e1b4e7bb2808fd3819c234245e9e3', '4595344', '4595344', 'ERNI DWI HASTUTIK', '', '2019-11-05 21:24:43', ''),
('4c774e6106693a7f3bd2a8bbcba23513', '6595344', '6595344', 'SUKIMUN', '', '2019-11-05 21:24:43', ''),
('9d8b2e084c150556b5c456064fd4df0e', '6225344', '6225344', 'TRI WULANDARI', '', '2019-11-05 21:24:43', ''),
('ca4e8a1d118aa364f31081ffb67350db', '1895344', '1895344', 'DWI WAHYUNING MIN HERGIANTINI', '', '2019-11-05 21:24:43', ''),
('df7043e30fb400b4638cb094257d4681', '4585344', '4585344', 'TOTOK EDY SUSILO', '', '2019-11-05 21:24:43', ''),
('836f53037528220b05cc5bd6deba5e15', '9045344', '9045344', 'ALIF MUJIATI', '', '2019-11-05 21:24:43', ''),
('243a5dcbb378b5ac3b89486bde7e5e66', '2875344', '2875344', 'KUSMIATI AGUSTIN', '', '2019-11-05 21:24:43', ''),
('59da0dfe00ab307c28e7203fbbd2daf9', '8275344', '8275344', 'HERI WIDODO', '', '2019-11-05 21:24:43', ''),
('bfb146f58a932020b55f3f5fcef0b1d7', '6675344', '6675344', 'M. ARIEF KURNIAWAN', '', '2019-11-05 21:24:43', ''),
('1d722e75e4e2e6471431eeeca0a9ea1b', '5775344', '5775344', 'ENDRAWATI', '', '2019-11-05 21:24:43', ''),
('d4af459f22d02a0817ef269e4e43a4a4', '4815344', '4815344', 'AGUS MUSTOFA', '', '2019-11-05 21:24:43', ''),
('9e9933aad393330a0cd0a59096179642', '3455344', '3455344', 'ZAENUL MAHMUDAH', '', '2019-11-05 21:24:43', ''),
('322e20f4b7d1ae90cbf3e30b47d4b6a6', '3555344', '3555344', 'ARIF RAHMAN', '', '2019-11-05 21:24:43', ''),
('efaebb9640ad264561b5bc67d20cca7c', '6965344', '6965344', 'AGUS SETYAWANTO', '', '2019-11-05 21:24:43', ''),
('eb4ccccc31931f79fcaabbd9bafea38e', '9555344', '9555344', 'FAJAR WAHYU HIDAYAT', '', '2019-11-05 21:24:43', ''),
('e63134d175c1c965e7a8cc22fdd73994', '2025344', '2025344', 'SULISTYOWATI', '', '2019-11-05 21:24:43', ''),
('fc7341e3ee75ed3d830aa5e3473443d6', '3145344', '3145344', 'IKA PUSPITANINGSIH', '', '2019-11-05 21:24:43', ''),
('d213f37cacb6cd19cb33c112bc78bd6d', '1955344', '1955344', 'SUJIANI RATNA JUWITA', '', '2019-11-05 21:24:43', ''),
('9b60890a174fdbb42094afe58c816a0b', '5945344', '5945344', 'ANTON BUDI PRASETYO', '', '2019-11-05 21:24:43', ''),
('5f719bec576ce37823e921b83b0516ca', '9715344', '9715344', 'SITI ALFIYAH NASIROH', '', '2019-11-05 21:24:43', ''),
('09de882927ecec3df50cee4f783beadb', '2495344', '2495344', 'YOANA LUKITA SARI', '', '2019-11-05 21:24:43', ''),
('a8bd816ca475eae99e8deb6be45da223', '9685344', '9685344', 'AHMAT DARMADI', '', '2019-11-05 21:24:43', ''),
('2e7da9331342d426dcbe37408c213761', '3885344', '3885344', 'ANIES JUSMA', '', '2019-11-05 21:24:43', ''),
('41a7a9f9806c342e6b7d81c5d4d8d678', '6215344', '6215344', 'ARYONO', '', '2019-11-05 21:24:43', ''),
('3df3fb320cb8f5fed768da8d9be590fd', '4875344', '4875344', 'CATUR SUMARWIDIATI', '', '2019-11-05 21:24:43', ''),
('6182dd40934f9a5642e0055d29e484bd', '9465344', '9465344', 'ERNY SAPTA WAHYUNINGSIH', '', '2019-11-05 21:24:43', ''),
('58fbfa71000a166575ff0014c991a9f2', '3435344', '3435344', 'FITRIANA KULSUM', '', '2019-11-05 21:24:43', ''),
('a27d8ff4c5041a0429f6df42a818ba12', '9635344', '9635344', 'FUAD FATAHILAH', '', '2019-11-05 21:24:43', ''),
('84f057e215d366685576851a4d335d90', '3715344', '3715344', 'HERU HARTANTO', '', '2019-11-05 21:24:43', ''),
('e1df215d0b777b233f1353a6fdeadd00', '4435344', '4435344', 'INDRA LIANAWATI', '', '2019-11-05 21:24:43', ''),
('7b218acac9392566ca0ae2ecd9056651', '4225344', '4225344', 'IWAN ARIANTO', '', '2019-11-05 21:24:43', ''),
('bf8f669753e55c0485054afaa678f4be', '4355344', '4355344', 'JOKO BAGIYO', '', '2019-11-05 21:24:43', ''),
('3d84c4cded55a45ee4c9ee693d5c7193', '4135344', '4135344', 'KHAMID', '', '2019-11-05 21:24:43', ''),
('441a5b7eeb5145f3078b3d4ed09d868f', '2015344', '2015344', 'LIA KUSUMA ANGGRAINI', '', '2019-11-05 21:24:43', ''),
('1ce14663b2c5a95824e23bfc980a640d', '6755344', '6755344', 'M.YAYAN ARIF HAMDANI', '', '2019-11-05 21:24:43', ''),
('6893e38bdb018aa787d2c197ccdbfea1', '8925344', '8925344', 'MUHTAROM', '', '2019-11-05 21:24:43', ''),
('5101f1fe5dabf1a1daaaba9c372dc464', '3645344', '3645344', 'NARDIANTO', '', '2019-11-05 21:24:43', ''),
('d20244c0afeda002e0cbde61da9f5221', '6605344', '6605344', 'NURSADIG', '', '2019-11-05 21:24:43', ''),
('226cfa03983b0fbe92e7d2da794606ce', '7055344', '7055344', 'ROHMA YULI MADYAWATI', '', '2019-11-05 21:24:43', ''),
('c5729c747f101d33be217056dbfb0c5e', '7845344', '7845344', 'RUSLAN', '', '2019-11-05 21:24:43', ''),
('5f4fd2343358caddccd33658a453a56a', '5365344', '5365344', 'SATRIYANI PUTRI RAKHMAD', '', '2019-11-05 21:24:43', ''),
('56b0f991ff0a06a21ab1e3cabc4e8044', '5755344', '5755344', 'SOLIKIN', '', '2019-11-05 21:24:43', ''),
('3cf93a2eebdcfa4eebb3f484eaf169ef', '5645344', '5645344', 'SONO', '', '2019-11-05 21:24:43', ''),
('d7f530dbaffe97981720b99b35e39ded', '6745344', '6745344', 'SUDARSONO', '', '2019-11-05 21:24:43', ''),
('9206185122e868e3bce43d98652e2c96', '5255344', '5255344', 'WAHYU INDAH SHINTAWATI KUNTAWIYONO', '', '2019-11-05 21:24:43', ''),
('c4968c0e907e12d16e10bd571d0e170b', '1875344', '1875344', 'WIWIN TRIAWANDARI', '', '2019-11-05 21:24:43', ''),
('404c78d418aef152fdba7227c0e182be', '8055344', '8055344', 'YAYUK SRININGSIH', '', '2019-11-05 21:24:43', ''),
('d9325a9cde51ab3fb5cd8d77fa61bb75', '2825344', '2825344', 'YOYOK TEGUH PRASETYO', '', '2019-11-05 21:24:43', ''),
('b8bfad58a65370cd572b84831a1b3398', '1815344', '1815344', 'V. ERNA KUSWORINI', '', '2019-11-21 00:00:00', ''),
('df8a1878598963a8805803201bdc757b', '8385344', '8385344', 'HANANTO EKO NUGROHO', '', '2019-11-21 00:00:00', ''),
('441373d815e68f1367c7f874bda71d2c', '7735344', '7735344', 'ADDONA KANUGRAHAN ERLANDO', '', '2019-11-21 00:00:00', ''),
('32a31c1f648ec51958657076abf7251c', '2465344', '2465344', 'FERYAN DANI ISWARA\r\n', '', '2019-11-21 00:00:00', 'GURU'),
('5948fb9928386ad98b2b6b92cc474871', '2435344', '2435344', 'DANANG KURNIA SETIAWAN', '', '2019-11-21 00:00:00', ''),
('27ea856297c9657cbabcff54967652f7', '4845344', '4845344', 'SUPRIONO', '', '2019-11-21 00:00:00', 'GURU'),
('86c87c7bbb648c283b5c34c09f37092f', '4605344', '4605344', 'HENOCH', '', '2019-11-21 00:00:00', ''),
('19930316', '6685344', '6685344', 'SUPRIONO IL\r\n', '', '2019-11-21 00:00:00', 'GURU'),
('67e972055e5f5d8e86205a7179bcff06', '3645344', '3645344', '235', '67e972055e5f5d8e86205a7179bcff06-1.jpg', '2019-12-18 02:12:01', '235');

-- --------------------------------------------------------

--
-- Table structure for table `m_waktu`
--

CREATE TABLE `m_waktu` (
  `kd` varchar(50) NOT NULL,
  `masuk_jam` varchar(2) NOT NULL,
  `masuk_menit` varchar(2) NOT NULL,
  `pulang_jam` varchar(2) NOT NULL,
  `pulang_menit` varchar(2) NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_waktu`
--

INSERT INTO `m_waktu` (`kd`, `masuk_jam`, `masuk_menit`, `pulang_jam`, `pulang_menit`, `postdate`) VALUES
('c4ca4238a0b923820dcc509a6f75849b', '07', '00', '15', '30', '2019-11-25 15:49:17');

-- --------------------------------------------------------

--
-- Table structure for table `orang_login`
--

CREATE TABLE `orang_login` (
  `kd` varchar(50) NOT NULL,
  `orang_kd` varchar(50) NOT NULL,
  `orang_kode` varchar(50) NOT NULL,
  `orang_nama` varchar(100) NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `orang_presensi`
--

CREATE TABLE `orang_presensi` (
  `kd` varchar(50) NOT NULL,
  `orang_kd` varchar(50) NOT NULL,
  `orang_kode` varchar(50) NOT NULL,
  `orang_nama` varchar(100) NOT NULL,
  `postdate` datetime NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `orang_rekap`
--

CREATE TABLE `orang_rekap` (
  `kd` varchar(50) NOT NULL,
  `orang_kd` varchar(50) NOT NULL,
  `orang_nip` varchar(50) NOT NULL,
  `orang_nama` varchar(100) NOT NULL,
  `tglnya` date NOT NULL,
  `postdate_masuk` varchar(100) NOT NULL,
  `postdate_pulang` varchar(100) NOT NULL,
  `postdate` datetime NOT NULL,
  `jml_jam` varchar(10) NOT NULL,
  `jml_menit` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminx`
--
ALTER TABLE `adminx`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `item_pinjam`
--
ALTER TABLE `item_pinjam`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `item_rekap`
--
ALTER TABLE `item_rekap`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `m_item`
--
ALTER TABLE `m_item`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `m_orang`
--
ALTER TABLE `m_orang`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `m_waktu`
--
ALTER TABLE `m_waktu`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `orang_login`
--
ALTER TABLE `orang_login`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `orang_presensi`
--
ALTER TABLE `orang_presensi`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `orang_rekap`
--
ALTER TABLE `orang_rekap`
  ADD PRIMARY KEY (`kd`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
