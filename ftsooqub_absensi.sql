-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2021 at 09:54 AM
-- Server version: 10.3.31-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ftsooqub_absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `building_id` int(8) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `koordinat_kantor` varchar(100) NOT NULL,
  `building_scanner` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`building_id`, `code`, `name`, `address`, `koordinat_kantor`, `building_scanner`) VALUES
(1, 'SWUKZ/2021', 'Kantor Pusat', 'Gresik', '-7.157422124734545, 112.61664229924854', '');

-- --------------------------------------------------------

--
-- Table structure for table `cuty`
--

CREATE TABLE `cuty` (
  `cuty_id` int(11) NOT NULL,
  `employees_id` int(11) NOT NULL,
  `cuty_start` date NOT NULL,
  `cuty_end` date NOT NULL,
  `date_work` date NOT NULL,
  `cuty_total` int(5) NOT NULL,
  `cuty_description` varchar(100) NOT NULL,
  `cuty_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cuty`
--

INSERT INTO `cuty` (`cuty_id`, `employees_id`, `cuty_start`, `cuty_end`, `date_work`, `cuty_total`, `cuty_description`, `cuty_status`) VALUES
(3, 19, '2021-08-29', '2021-08-29', '2021-08-30', 1, 'Sakit', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employees_code` varchar(20) NOT NULL,
  `employees_email` varchar(30) NOT NULL,
  `employees_password` varchar(100) NOT NULL,
  `employees_name` varchar(50) NOT NULL,
  `position_id` int(5) NOT NULL DEFAULT 1,
  `shift_id` int(11) NOT NULL DEFAULT 1,
  `building_id` int(11) NOT NULL DEFAULT 1,
  `home_coordinate` varchar(100) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `created_login` datetime DEFAULT NULL,
  `created_cookies` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employees_code`, `employees_email`, `employees_password`, `employees_name`, `position_id`, `shift_id`, `building_id`, `home_coordinate`, `photo`, `created_login`, `created_cookies`) VALUES
(1, 'K-89121', '-', '8551798d9479836fa9fe972e8d4317855b00de4c015ebc6006698aca99db24cb', 'SUMARSO', 1, 1, 1, NULL, NULL, NULL, NULL),
(2, 'K-10001', '-', 'c94ef25acaf9407afb138033001e1d3b90780ff274da7a424b7e7a29f4ff7312', 'IMAM ISKANDAR', 1, 1, 1, NULL, NULL, NULL, NULL),
(3, 'K-20006', '-', '46bf67cdce2b7349f80b3be981a6481450e8becf58fb34fd018af96d2db4ac0a', 'DEDE ADITYA ARWAN', 1, 1, 1, NULL, NULL, NULL, NULL),
(4, 'K-13007', '-', '6daffa2ee8665c1b601bcd7ae6f256749829219169b05d7da4093b9d83b3a218', 'IRWANTO HADI PRANOTO', 1, 1, 1, NULL, NULL, NULL, NULL),
(5, 'K-18004', '-', 'f3080a0f34aa8bf4dd5fb644174b779c4164e26b9e30975a50fb9eafcd7f5e74', 'SUPARDI AKHMAD SALEH', 1, 1, 1, NULL, NULL, NULL, NULL),
(6, 'K-03114', '-', '8dce512e4de6faff8d6b3c9c145ab082dfcac44fd2ee4ca8597193d3333b1236', 'SISWADI', 1, 1, 1, NULL, NULL, NULL, NULL),
(7, 'K-20010', '-', '33bc975cbb78419649e34f9e03315a2910d1fa5f88ff0f6cf2b0c4a21955dfd4', 'ACHMAD SYARIFUDDIN AMRULLAH', 1, 1, 1, NULL, NULL, NULL, NULL),
(8, 'K-19011', '-', 'a3895e979cb2f0c0bcbef551b431db16ee6a1bd9fc62179d6d732246e9e2a747', 'FAJAR ABDUL HAKIM', 1, 1, 1, NULL, NULL, NULL, NULL),
(9, 'K-19031', '-', '805cafd2ab6c14cc6690b5a41e0064ff6fcd3803b839e180421ca4ee682b9d3b', 'LULU UN NIMAH', 1, 1, 1, NULL, NULL, NULL, NULL),
(10, 'K-91157', '-', 'b1a0bda6458f281974bb4c1336b6dd7e92855d91b4702d0fa33c4e8d87b5a4c2', 'SUSILO FITRIANTO', 1, 1, 1, '-7.186822,112.61615', NULL, NULL, NULL),
(11, 'K-19002', '-', '6e38876386921c4dfdc7e44463ce906e5c4b7d5c3eb24415d3433f16d9dbe89c', 'DANI DARUSMAN , S.T', 1, 1, 1, NULL, NULL, NULL, NULL),
(12, 'K-20002', '-', '2004ac3ad87a6b71dfa6ec552465c6728364068113757dd483aa2d32c5e8e482', 'RIZKI BAYU SANTOSO', 1, 1, 1, '-7.145912,112.619369', NULL, NULL, NULL),
(13, 'K-19025', '-', '4b6b398c56bf4678d20abf4440bf1a67dadd6802b22aa28d39519798f2d95cdf', 'ADI SUSANTO', 1, 1, 1, NULL, NULL, NULL, NULL),
(14, 'K-90147', '-', '93a936bb28919d691a193cd832d1d7de2c2308b85e69a99347892f56cbc47e50', 'SUHARTINI', 1, 1, 1, '-7.151028.112.617888', NULL, NULL, NULL),
(15, 'K-87081', '-', '6ae45712a4606e654a715c3ce5f46e61100587ceb7f87df58b73be0ebf9005db', 'NUR FADILAH', 1, 1, 1, '-7.158088,112.613547', NULL, NULL, NULL),
(16, 'K-19001', '-', '666e90b19243acc14fc48b08bc2ef048cbd120a0ad667f48830bd8456fc1e372', 'AGATHA CHRISTY KARINA PUTRI', 1, 1, 1, NULL, NULL, NULL, NULL),
(17, 'K-89111', '-', '4a4e7e5c3f21736893be020542cd54985cd6670a7769bff8d1742f3a68ba83f7', 'MUHAMMAD YASIN', 1, 1, 1, '-7.158425,112.623561', NULL, NULL, NULL),
(18, 'K-88089', '-', '90d7988ab6e5d4d4e898c1c021c020d12cc8ec28ce68671e8448c0a32ff96b90', 'HARDJONO', 1, 1, 1, '-7.186725,112.616682', NULL, NULL, NULL),
(19, 'K-18007', '-', 'afd60e7c60066b0915d6ca06f7e9c9902297d8582c04c51d25995b52cca73b20', 'NOOR JANAH', 1, 1, 1, '-7.150766,112.601409', NULL, NULL, NULL),
(20, 'K-88091', '-', '0ae679adcd0d952f2d4a86bac9e22a7588b33f3f3651d84eb33906d09677364c', 'ARIFIN', 1, 1, 1, NULL, NULL, NULL, NULL),
(21, 'K-90149', '-', 'c877b56ecfd269d7c6463ce707aa4daff1e842bc4228371b4734920685be6652', 'HENIF TRI HASTUTIK', 1, 1, 1, NULL, NULL, NULL, NULL),
(22, 'K-89124', '-', '54cb7c993e62575f9b8645ab810b01f626fe66f501f3e236a28e1f0023b4de82', 'ZULIATI', 1, 1, 1, '-7.174157,112.637298', NULL, NULL, NULL),
(23, 'K-88102', '-', 'f8bc551daebcab83d1b96cb66b4ca2a852d56317f5814723585f4700dee99cbe', 'MUJI RAHAYU', 1, 1, 1, NULL, NULL, NULL, NULL),
(24, 'K-88085', '-', 'd5b00f441407de710432b565e7715a676f22e96132a3f741de081026d7cfe59e', 'AKUSNAWATI', 1, 1, 1, '-7.138015,112.61625', NULL, NULL, NULL),
(25, 'K-19004', '-', '359137ba419de708381ab6a7d82009c62ff790ce98e43e16f17effc4edf91b79', 'ELI WAYUNI', 1, 1, 1, NULL, NULL, NULL, NULL),
(26, 'K-20015', '-', '3fc439eb203acf4688de692b7baf45b61be069a3e962d70ccdfbe01e46ef7309', 'EKO ANDY SUSILO', 1, 1, 1, NULL, NULL, NULL, NULL),
(27, 'K-20011', '-', 'c4c51acdfea6b012aa6de9e2d4e7d742c87da9802e569081b339db6130fff93e', 'KOKO DIMAS PERMANA', 1, 1, 1, '-7.1347032185737085,112.61891619207555', NULL, NULL, NULL),
(28, 'K-19018', '-', 'a280c740feddf4e85b6f71dfe5ec5fb042385044b6de3b3faab4b68529bfdc69', 'MOHAMMAD ARIFIN', 1, 1, 1, NULL, NULL, NULL, NULL),
(29, 'K-19020', '-', 'a8f55ae68d6df333e9c82feeed3f29408e399ccae445b9d7a00f7373ee0ab174', 'WIDIYATUL MUFIDAH', 1, 1, 1, NULL, NULL, NULL, NULL),
(30, 'K-89106', '-', 'c3645a378b308395956146893a88aaf0947c2a42c63203224873ed147d40f198', 'FARID MUJDI', 1, 1, 1, NULL, NULL, NULL, NULL),
(31, 'K-91159', '-', '63a7f058e043de78aa6621a31bc5d13b586ee927e7153d2d4b9851a8dd6ec40c', 'AGUS NURIJANTO', 1, 1, 1, NULL, NULL, NULL, NULL),
(32, 'K-19017', '-', '009100984dcb85e05b98020dee776dde0e5c30d9ae8f8550319d166b2c0799a2', 'JALU RARASBRE PANDHEBUMI', 1, 1, 1, '-7,8261720,112,7209711', NULL, NULL, NULL),
(33, 'K-13005', '-', 'e455f1c88d0579a8e32e5054a5b21d619c42703b1567f93aa7b270fced027c4c', 'WISNU ADI KURNIAWAN', 1, 1, 1, NULL, NULL, NULL, NULL),
(34, 'K-19027', '-', '9e0460031d922116edd7d8d341891dda2fbfe924fda4ef826c97ebfc72fd3234', 'DHANI SETYAWAN', 1, 1, 1, NULL, NULL, NULL, NULL),
(35, 'K-19022', '-', 'ab360c8ad3d768ab0433505e8271f745db0e0c073f92f4d755f2ef25aca4ff17', 'PRIMA NOFAN ANGGAESA', 1, 1, 1, NULL, NULL, NULL, NULL),
(36, 'K-19016', '-', '0e2d9c990802b8837beafe0f483bfe68a3ebf307bb68263c7db62b2cd698f024', 'EKA RANGGA PERMANA', 1, 1, 1, NULL, NULL, NULL, NULL),
(37, 'K-90151', '-', '98f485e840f538069d7d20f18f7dd93fa35ae54055f142fe8e6d59c2f68ff775', 'TEGUH PRAYITNO', 1, 1, 1, NULL, NULL, NULL, NULL),
(38, 'K-11002', '-', 'd875fdfa5394d7d49dc2744634d041091273f229588a4af0381490025354e84d', 'DWI ANGGRAINI FUTURHESA', 1, 1, 1, NULL, NULL, NULL, NULL),
(39, 'K-96188', '-', '86418b3d72b36bb21356a24991e076af6eda27d88d8f3ed2dbfe0c1a69060759', 'NANIK KURNIAWATI', 1, 1, 1, '-7.150945,112.614159', NULL, NULL, NULL),
(40, 'K-89122', '-', '8fec7caf805f47637b66b3e98fb0d9f52abf7c95967b65b88fab0c07e6260f50', 'RINDARTI', 1, 1, 1, '-7.160095,112.614183', NULL, NULL, NULL),
(41, 'K-19007', '-', '261808ec3ac7a4c4d58f06ef92a03b46f5b8d00c4bde85d707e406922d9820b7', 'MITA AMIRIANTI', 1, 1, 1, NULL, NULL, NULL, NULL),
(42, 'K-20008', '-', '43d80d0a549faf53973feeab2fe29fc6331aaa641020cdf24dc589ec8f28d7df', 'SETIAWAN AGUNG PRAYOGO', 1, 1, 1, NULL, NULL, NULL, NULL),
(43, 'K-19021', '-', '1027d4b8b2c8fe6e555c7eeef043e42f6bbbd86c30ec7cc0fc2320a52fd7cea2', 'ADHIE PERDANA', 1, 1, 1, NULL, NULL, NULL, NULL),
(44, 'K-20003', '-', '4df6699a5a4dc4387abcba35d58a8055d62f99ccbd9d3cc268d9171873f0879c', 'YASINTA FITRIANI PUSPITA SARI', 1, 1, 1, '-7.158288,112.623687', NULL, NULL, NULL),
(45, 'K-17005', '-', 'ad2d2ffde36aaf40ba3b34444b58383d413382849300d11134532ec387e8e36d', 'HAJIIR PRISNA SUGENG PUTRI', 1, 1, 1, '-7.164637,112.650312', NULL, NULL, NULL),
(46, 'K-19029', '-', 'e00b6fc0f5339f5d18dfccd2f138b570a40b66e7dda7f02cad291c6cb6e8c553', 'ANGGRAENI RAHMA DEWI', 1, 1, 1, '-7.144782,112.617337', NULL, NULL, NULL),
(47, 'K-10003', '-', '886fb569fbb56bd8878638e4326713339718e88e4ea8a9bea9503e808841c0a1', 'TEDDY EIVERT PAMIKIRAN', 1, 1, 1, '-7.179730,112.616388', NULL, NULL, NULL),
(48, 'K-91160', '-', 'ecbb5c87ef1eca4b29ab6bfeb8f3117b972ebe168f17cd4da0e1a0dbad8cb0e0', 'HERI EFENDI', 1, 1, 1, '-7.145926,112.619268', NULL, NULL, NULL),
(49, 'K-15001', '-', '987bdd7a9ed376ebf452be614f91b0ebfc76ec74ade8ca339493c394d91545b5', 'IWAN DWIYANTO NUGROHO', 1, 1, 1, '-7.2687882695387875,112.76711941177979', NULL, NULL, NULL),
(50, 'K-18001', '-', '1e5af3e6b8c9c3de090d0c2f36817aa66cff80d08e035ee78d4867daef98b967', 'IKA RIZQI FEBRIYANTI', 1, 1, 1, '-7.163973,112.600546', NULL, NULL, NULL),
(51, 'K-84030', '-', '21182362376ba0f76fc63d4af8d75ddae077812d4f1d6effecde5f4cded1189e', 'SUMARI', 1, 1, 1, '-7.149419,112.594394', NULL, NULL, NULL),
(52, 'K-19012', '-', '977b8fcd1b066f8c55f2ae875ad11b71c5dfb5d52001c9a8906d1bb0c45c1b2c', 'DWI CAHYA LESTARI', 1, 1, 1, NULL, NULL, NULL, NULL),
(53, 'K-17001', '-', '77f7e3bdd117f3de38c6c3fa7f0b69d93a12934455677b9aba69bd3e97311e7e', 'IMUT FATIHAH SARI', 1, 1, 1, '-7.151108,112.590634', NULL, NULL, NULL),
(54, 'K-13002', '-', '45964eb68010362a00f1a74b6c794fd721fd81aed1327fd71d3480d4fbc5fa14', 'MUNIROH MAHMUDAH', 1, 1, 1, NULL, NULL, NULL, NULL),
(55, 'K-19009', '-', '1f3d839d68cb8ae86c98ef7b43b3a6c67147f6e31a707cab8cee8363b291ef90', 'RIZA RATNA PRIHASTUTI', 1, 1, 1, NULL, NULL, NULL, NULL),
(56, 'K-19023', '-', '3c6fad12b8241db0d952f2061908ec2cc5ba287c5c592bb5e7e66b127ddccce4', 'AGUS PURWANTO', 1, 1, 1, NULL, NULL, NULL, NULL),
(57, 'K-17003', '-', '9ff64409571e0bbb87038ef89cea52d2646b7c1dc9ab992adb18bee0b8a3c5c8', 'DEDIK KRISDIANTO', 1, 1, 1, '-7.162241,112.626465', NULL, NULL, NULL),
(58, 'K-19019', '-', '02752e865d4cb80f018275802b955f14cbb75854c1c1a9857935cb413f39cb41', 'RISKI FAJARIYAH', 1, 1, 1, NULL, NULL, NULL, NULL),
(59, 'K-85048', '-', 'd771172d9d7c05f86ab1bb3db356ec96492c5dbf91175a4605aca86271371d71', 'SUKOTIPA', 1, 1, 1, '-7.138015,112.61625', NULL, NULL, NULL),
(60, 'K-91155', '-', '750110f212ef5ae39204a98196eaf7ec1380ba45254cd739e82592b3a1de2fea', 'WAWAN ZAINURI BUDI SUJARWO', 1, 1, 1, NULL, NULL, NULL, NULL),
(61, 'K-19026', '-', '62699c828260f77a5e09b36d31189d6f8195efc99a578c3e1716d739bea45a5d', 'MOHAMAD IDROR ARDANI', 1, 1, 1, '-7.1381394,112.6126809', NULL, NULL, NULL),
(62, 'K-13004', '-', 'f9befc369c4fdacd9a02ddd19deeeb80fe5fe45e88295176b818b9b2f716e0fe', 'IRWAN ARIFIN', 1, 1, 1, NULL, NULL, NULL, NULL),
(63, 'K-18002', '-', 'd16c0644ac06dcb1a910520a384e03dd49276c70d7513567e75969d3dd7707d0', 'JULIA DIAH KARTIKA', 1, 1, 1, '-7.154813,112.646906', NULL, NULL, NULL),
(64, 'K-88087', '-', '11d215849f3a2d433cbb0fdc43d3efb25586e134398695043e5c3eb6e596b071', 'TITIK SULISTIYANI', 1, 1, 1, '-7,1549723,112,6142041', NULL, NULL, NULL),
(65, 'K-19003', '-', 'fed33e5fb2a87d3842046ed784eeee8ca2cc4a4c20ac79e1306e873fbf90248a', 'EDDY SUSANTO', 1, 1, 1, '-7,1624459,112,6420609', NULL, NULL, NULL),
(66, 'K-87069', '-', '6285a99d6af4213f775334d5fb6ba3fde76585c0f82c88d1c410977d29cb9e9e', 'KHUSNAINI', 1, 1, 1, NULL, NULL, NULL, NULL),
(67, 'K-19014', '-', '975fa77dd15a54e65e28d24c57cd413434e39c5fcaf90d73b4164f6bbea3e602', 'BINSAR COURNUS WIJAYA PUTRA', 1, 1, 1, '-7.178963,112.584573', NULL, NULL, NULL),
(68, 'K-20014', '-', 'd61a78107df7a7721acf5bc8b53e3e3256f0b03fb549b3589cd0cd9f7ab686b3', 'NOVALIYA EKANTA LARASATI', 1, 1, 1, '-7.1621530,112.6553811', NULL, NULL, NULL),
(69, 'K-11001', '-', '3b588a46f6fd426845a66b8105230024784c0fa085813ae0c73a0b8cce55507b', 'ALVIANO DE PARTHO', 1, 1, 1, '-7,1327939,112,6046072', NULL, NULL, NULL),
(70, 'K-15002', '-', '58040792689e88d56c21308b7558339c05bc3caabe1e82c208d053bca5899633', 'FANDI YULIANTO', 1, 1, 1, NULL, NULL, NULL, NULL),
(71, 'K-19028', '-', '26157d45d94adcf141628d5c10b7854fef06c6251e258bbcceeeb92cb0d4e9ea', 'GAYATRI PERWITA SARI', 1, 1, 1, NULL, NULL, NULL, NULL),
(72, 'K-19030', '-', 'fb68fdeeb10515cb0af7d6ca6addbee62629b75c4e10429227330972de98653f', 'WULAN SETYA PUTRI', 1, 1, 1, NULL, NULL, NULL, NULL),
(73, 'K-17007', '-', '4e9b006df9b575b33049799e159b9023476a6b6b20d9c42c8f42a525faa3ae76', 'RASTADJI', 1, 1, 1, NULL, NULL, NULL, NULL),
(74, 'K-20005', '-', '1fcf807785b423e00234b636f05776405501c1cb6426f5ade61e7bdcb777e039', 'NUREGINA MAULINA AGUSTIN', 1, 1, 1, NULL, NULL, NULL, NULL),
(75, 'K-10002', '-', 'c6a5814f089bb98e6a1545a52301b912c39337ebdc5558fe6e67e2d4c0ba89bc', 'ANDRY ERMAWAN', 1, 1, 1, '-7.156352,112.585938', NULL, NULL, NULL),
(76, 'K-20004', '-', '5498e5230f06f7ab373361b32d0baed7a15ffd833d2477fbc5b30b9a65edcdc0', 'AYU LISTYA ANGGRAINI', 1, 1, 1, '-7.1650459,112.6426811', NULL, NULL, NULL),
(77, 'K-17002', '-', '1cbe347f841fbdb234320b7fca681893abb05a0c278011234103be9dc4287fe7', 'NANDINI KASSETYANING LAKSMI', 1, 1, 1, NULL, NULL, NULL, NULL),
(78, 'K-19010', '-', '159eb580a32ddd396015206fd3505b7b192d6a5463bb799e206a70fde9e6468a', 'ADITYA ARIS KURNIAWAN', 1, 1, 1, '-7.160162,112.606776', NULL, NULL, NULL),
(79, 'K-20009', '-', '19f1435e511852eb55366731fc4aea4466e5398dd6a47e4d171e0dad6db8af8a', 'LOVYANA NUGRAHENI', 1, 1, 1, '-7.175433,112.611115', NULL, NULL, NULL),
(80, 'K-88088', '-', '0792617a7c3007f525ac8b4d64c744d82b47cd4ea9a2850def52cff940b30ed5', 'MANGASI PANJAITAN', 1, 1, 1, '-7.167943,112.639631', NULL, NULL, NULL),
(81, 'K-18005', '-', 'f32528e02384b59c322993e5d38a21bd8ebce2c21e76b3139f2966eb8347afb9', 'DURROTUN NASICHAH', 1, 1, 1, NULL, NULL, NULL, NULL),
(82, 'K-90141', '-', '15ec4517582d8ee293be8da0bdeb5eb8a99ec4625a51981f0350b9e5d21ee87a', 'HANDAYANI', 1, 1, 1, '-7,1615969,112,6302595', NULL, NULL, NULL),
(83, 'K-17006', '-', '2fe696a664987a3d56c0be7754d36aeee271ec795a0da64c7b89170f517ee3da', 'ANAS MUCHTAR ZAINI', 1, 1, 1, '-7.2623895,112.5634379', NULL, NULL, NULL),
(84, 'K-13006', '-', 'aa007e1193ea72b36153a51a690aaa0c9b31af21d7e3477d5b0b70f45fbd1f2c', 'AHMAD RIVQI JAMIL', 1, 1, 1, NULL, NULL, NULL, NULL),
(85, 'K-18006', '-', '1c44a008fad14b78dd8c825d6bb06f5b144c635de6c55d08b740775a1b2ce5f1', 'ONNY EKASARI', 1, 1, 1, NULL, NULL, NULL, NULL),
(86, 'K-19013', '-', '2eb3650e00b197e0b70bdf95c5fc7a900e7aa8e1e3fed7f421d88272f0e3ec87', 'HAJAR ARINI', 1, 1, 1, NULL, NULL, NULL, NULL),
(87, 'K-88096', '-', 'd8e9cdfb1a70f9e175bba688e283cba41aa7d1e045c8c5fd843f8aa2274180da', 'DIDIK SETIAWAN BASUKI', 1, 1, 1, NULL, NULL, NULL, NULL),
(88, 'K-13003', '-', 'c2123d228884f150afe6ebe445171266dc742db43f1dfe4197f6cf6c320f24f5', 'RIZKA FITRIYANI', 1, 1, 1, NULL, NULL, NULL, NULL),
(89, 'K-10004', '-', 'f6591dcafdbd4e056a5b1460297d66bd34f90715ce9babce7dae3544b0bd4b8f', 'TRI YULIANA WAHYUNINGRUM', 1, 1, 1, NULL, NULL, NULL, NULL),
(90, 'K-11003', '-', 'bc24a97dbb219f454551f0069fc209b18955b7d48dfac455a1e0990bbaa713d1', 'ARIE SASONGKO', 1, 1, 1, NULL, NULL, NULL, NULL),
(91, 'K-89107', '-', '77d82641e111f5a726b73c1e93b97577beb96d63a648bde5e17cd96327880790', 'KAHUDI RAHARDJANTO', 1, 1, 1, NULL, NULL, NULL, NULL),
(92, 'K-18003', '-', 'f2e0908aac738243b11ce41fbf2de2b2a9734dbaa33d342ba9eb417b8e158bb6', 'VIEGO KISNEJAYA SUIZTA', 1, 1, 1, NULL, NULL, NULL, NULL),
(93, 'K-94184', '-', '5736251834167ffd3251b708ead60691139e942394ba130dc3318fb2fb6914bb', 'NGATARI', 1, 1, 1, NULL, NULL, NULL, NULL),
(94, 'K-17004', '-', 'ccf54922c4d43a7cf28b8c42165a8595f6f78482d5c8da6c6dc38f344c2a39ff', 'SIDIQ YUDHI ANGGARA', 1, 1, 1, NULL, NULL, NULL, NULL),
(95, 'K-20001', '-', '9b08435d158484340099c6c41c0cd925d9de2601ef853ad86285097694840185', 'FATONI ABDURROHMAN', 1, 1, 1, NULL, NULL, NULL, NULL),
(96, 'K-20013', '-', '057ef7d6ee72d816d8f0228bc1db21e5537c124c6e93ea047843a31623ecf806', 'SARIYANI', 1, 1, 1, NULL, NULL, NULL, NULL),
(97, 'K-19008', '-', '5d434348edc264c960f165e10bce08a0b25ecda6966d5efb0a96f1ac4dfdc417', 'RIRIK AGUS RIANTO', 1, 1, 1, NULL, NULL, NULL, NULL),
(98, 'K-89117', '-', '633869594e156f6faf86bfba82cd47021b66e794d876c383545eac2367329ceb', 'MUJIANTO', 1, 1, 1, NULL, NULL, NULL, NULL),
(99, 'K-19015', '-', 'd7a417a071a3d0bc02f423fdcc06ad384b6557a1969322e2ec6ab4ff53b9b684', 'ANTON HARIYONO', 1, 1, 1, NULL, NULL, NULL, NULL),
(100, 'K-88093', '-', 'df6c888700fb6a7ed941ee628f6d90b4d7f296b9a42da9e63f76eb4ca61fa7a3', 'GUNAWAN SUGENG BAHARI PUTRO', 1, 1, 1, NULL, NULL, NULL, NULL),
(101, 'K-90146', '-', 'cf1d1df4624168429cbc1a5c3c7a54ebace6c1e0ef33ec2523be921f9c058f7d', 'R.CHUNCORO AGUNG PRAKOSO', 1, 1, 1, NULL, NULL, NULL, NULL),
(102, 'K-89116', '-', '4f0acb0870e2e86da91099b961713b19d63763254224908b117fb578066826bf', 'YUSMA ANDRIYANI', 1, 1, 1, NULL, NULL, NULL, NULL),
(103, 'K-19005', '-', '520b98838846079c748a4abe644e2b9b0235259f4fe9885b06dc3be375348287', 'JOKO WALUYO', 1, 1, 1, NULL, NULL, NULL, NULL),
(104, 'K-19006', '-', '2ef071d6c7cc7c0aebc8c1834525ddec491cf877708912687832f3ed47a681ce', 'SYAIFUL EFENDI', 1, 1, 1, '-7.210614,112.490178', NULL, NULL, NULL),
(105, 'K-20012', '-', 'fff311740140b75a9e27c868fe5ce73bcefc43979e08e8d1c4b72879e95edb17', 'ANITA TRISTI', 1, 1, 1, NULL, NULL, NULL, NULL),
(106, 'K-91156', '-', '53a0dc3ea3644fce3236e6914395ee0029f5001824965eb045d75eae68c76c59', 'NANANG SUBAGIO', 1, 1, 1, NULL, NULL, NULL, NULL),
(107, 'K-93181', '-', '96a27acc1246cfb30243d2363ebfe65780b806baf6f567c9967b3cf727bbe40b', 'SINTA RACHMAWATI', 1, 1, 1, NULL, NULL, NULL, NULL),
(108, 'K-13001', '-', '753d3e36b2d998275b1d0e3596362bf4356cbf4c62dc304554c53714dc58c629', 'YENI MARADIANA ULFA', 1, 1, 1, '-7.177915,112.631387', NULL, NULL, NULL),
(109, 'K-89119', '-', '5830ca9885c9c6239cf0628c9994a06eb14888eb1c2ba0b2aa69c5f6b1c663d9', 'MULYANTO', 1, 1, 1, '-7.142866,112.613284', NULL, NULL, NULL),
(110, 'K-87065', '-', 'ea3d784c68fb4e648fd1f07c573f5700b31c149f755d6f5248eae9eb0af5b541', 'MAHFUD', 1, 1, 1, '-7,1616438,112,5356526', NULL, NULL, NULL),
(111, 'KK-113019', '-', 'c31a2108c6c2a69b0fa9dfe458a7c25804699decf6123d552720ff95220c73f2', 'WARJONO', 1, 1, 1, NULL, NULL, NULL, NULL),
(112, 'KK-112017', '-', 'da06ba89adda61612bb7ceb181dc211ecff827d928971e1f299781573ef026f6', 'HARTO AGIANTO', 1, 1, 1, '-7.1424076,112.6137763', NULL, NULL, NULL),
(113, 'KK-712018', '-', '4d258c15a7ecd4f6e3b60ca6c69ab2c3e2a98cc653f9d2d033e94345bd066da8', 'DIO DHITA PRADHANA', 1, 1, 1, NULL, NULL, NULL, NULL),
(114, 'KK-200220', '-', '4c4fecb46fd8f0aeaf250c7f934fd1ef4ad3fc3e0474f3bd0abd37005363550e', 'ANINDITA PARAMESWARI CAHYANING WULAN SUCI', 1, 1, 1, '-7.1566357,112.6449133', NULL, NULL, NULL),
(115, 'KK-722018', '-', 'cc32ff3bab4cedbcaa8c73394cd504af1e5e316f0411ff0918f21ab29de6fb3d', 'LILIAN ENGGAL EKASARI', 1, 1, 1, '-7.1392399,112.5896537', NULL, NULL, NULL),
(116, 'KK-822018', '-', '8eadcc4dd3f5d232db258830ee98dd2429257eedcd6c4e128470be6bf28ceb52', 'SUPARNO', 1, 1, 1, NULL, NULL, NULL, NULL),
(117, 'KK-201019', '-', '0c9b4ea3b71b1f7af70ca3e4b37c45f4ed028672c427e7adbc1b131b51cb7c20', 'RIZALDI RACHMANSYAH', 1, 1, 1, NULL, NULL, NULL, NULL),
(118, 'KK-704019', '-', '031e1beccc3de0393002e430e2c1b03b3e3a3f54d1867af4afa046c3611cf504', 'MUHAMMAD RUFII SETIAWAN', 1, 1, 1, NULL, NULL, NULL, NULL),
(119, 'KK-101020', '-', 'd05a69874efdc14214f88498de7c7b4b6a8d41696c1093ca2335f5a6f9fc0c21', 'GATOT PRABOWO', 1, 1, 1, NULL, NULL, NULL, NULL),
(120, 'KK-832018', '-', 'a91bd5321fddb9084822d64f6fdf001d232e06674422c83c603f776de4f55e0a', 'R. BACHTIAR WIBOWO', 1, 1, 1, NULL, NULL, NULL, NULL),
(121, 'KK-702019', '-', '4c0c4699cff825477d72b846595a2289715a0ff4644f5764f93aecaf3dd36561', 'CAHYONO', 1, 1, 1, NULL, NULL, NULL, NULL),
(122, 'KK-121015', '-', '3c7eaba56cca8999dad876de70186b9fd816c37a33a85efe6095fb8989c2f4bb', 'ADI SUTANTO', 1, 1, 1, NULL, NULL, NULL, NULL),
(123, 'KK-202019', '-', '5fbbcb630c878b42003eebea9f5f1757e6d8dd9b2681b3ebffe6afe5ec523848', 'BRIAN GALANG ANGKASA', 1, 1, 1, NULL, NULL, NULL, NULL),
(124, 'KK-701019', '-', 'b1dbdc5e04e946d5cd1718f1211e21c1659bd15fa8fe04158a6331a382507e3c', 'AZHARI IRHAS', 1, 1, 1, NULL, NULL, NULL, NULL),
(125, 'KK-200120', '-', '7a30711805b1c3b0d109de047f2ab731e16a0e1cf77f43dbcbd0108dfa83d1fc', 'DIO FABIAN ADITYA PUTRA', 1, 1, 1, NULL, NULL, NULL, NULL),
(126, 'KK-211016', '-', '3f590d467fb71001f11ff482b3d61611508a14b894758289a68aadf4a8eee516', 'LIPDIYANA', 1, 1, 1, NULL, NULL, NULL, NULL),
(127, 'KK-112019', '-', 'a1e0449cb338115397409534a69d7e59e255b52dc0a87045effa8094a1c0bd4b', 'NATRISKA SHEPA JULIANTO', 1, 1, 1, NULL, NULL, NULL, NULL),
(128, 'KK-212018', '-', 'eed2687b8c2bb74c6387e35618ef248ae86e208cb0284e232bfb6c24845decb8', 'HARYO', 1, 1, 1, NULL, NULL, NULL, NULL),
(129, 'KK-411018', '-', '95d211b60153d4cecb0de3b34906881f9d29ee8a0c4df7ad0837454a1b3315be', 'DWI HERI PURNOMO', 1, 1, 1, NULL, NULL, NULL, NULL),
(130, 'KK-111015', '-', '85e88046263b723fc1b0d6bbd9924259635c1c8429ee97ffdb351531f17e83b3', 'ALI AFANDI', 1, 1, 1, NULL, NULL, NULL, NULL),
(131, 'KK-312016', '-', '6e57b4cea2f9213525bd535581571690477db2d1e6de6b90a8f2b9145a1ca883', 'DWIATMAJI HENDRIYOUTOMO', 1, 1, 1, '-7.163934,112.600552', NULL, NULL, NULL),
(132, 'KK-212016', '-', '6fd916a79ec45f5a1f9435a3e35e7239a864e32021992e8969f913dcaec977d2', 'MOHAMMAD FAIZ FAKHRI', 1, 1, 1, NULL, NULL, NULL, NULL),
(133, 'KK-912018', '-', 'cf90ae9d33a3a004ce3652c82b0c6817942bd137779861ad462e6723c561543b', 'NASIYATI', 1, 1, 1, NULL, NULL, NULL, NULL),
(134, 'KK-922018', '-', '417dde553bc4647e556b3881acbe778fb29f492c2a5decc0ae554a60a43da728', 'DARSONO', 1, 1, 1, NULL, NULL, NULL, NULL),
(135, 'KK-932018', '-', 'b4fd4c6b640fe1a8831a8daf4a4b5e2163281c9b1dccb95b6a0ce908c2ddd207', 'DIMAS RAMADHIAN', 1, 1, 1, '-7.138748,112.592234', NULL, NULL, NULL),
(136, 'KK-812018', '-', '87e3ab9233908903954ebe6fc2937062a9be07906b4f6050e2e8be51fd6f85d9', 'NUR HALIMAH', 1, 1, 1, NULL, NULL, NULL, NULL),
(137, 'KK-111028', '-', 'a6b01652168f2f95f4773d11c105f38562796360c7ab2b03238e6fe77b2554a9', 'MAT SRIPAN', 1, 1, 1, '-7.1520129,112.5937445', NULL, NULL, NULL),
(138, 'KK-604019', '-', 'dda221065e58d029da7f6c0f1771804f054326c404b9101f506ec7c57b90d95f', 'ENDAH PRASETIANINGSIH', 1, 1, 1, NULL, NULL, NULL, NULL),
(139, 'KK-606019', '-', 'b79fdaefb5f75d4717abe7fd13503f527d8170992c0e493efa13c116c2cc1bb2', 'ZAINI ROHMAN', 1, 1, 1, NULL, NULL, NULL, NULL),
(140, 'KK-601019', '-', 'a79410308e0e2fb88bda5180d383443c6a6f382c77708c84f23159c1b4e40d76', 'ACHMAD ARIF SANTOSO', 1, 1, 1, '-7.152248,112.657333', NULL, NULL, NULL),
(141, 'KK-852018', '-', '00872c5c11a5c09a356167adc1e56ce579722d4ba74b00458cecea983c107659', 'FAJAR MARTHA KUSMAWIJAYA', 1, 1, 1, NULL, NULL, NULL, NULL),
(142, 'KK-952018', '-', '226fa35517334e9d4174e27cc65e6e6f5d69827fbb5d54f36d19173d6f26cf8a', 'RODLI', 1, 1, 1, NULL, NULL, NULL, NULL),
(143, 'KK-400121', '-', '500a6fd5f77e2aa1b69e7d2ada44e7ad6124ebaf8412377451aa65ae9bc0e622', 'MOCH DEDI MAHENDRA', 1, 1, 1, NULL, NULL, NULL, NULL),
(144, 'KK-182015', '-', 'ee326ee22bacca6324d54bb42290487592834bee99a1f9d8b68be64812306741', 'TAUFIQ', 1, 1, 1, '-7.1737195781904886, 112.58230455204446', NULL, NULL, NULL),
(145, 'KK-415018', '-', '815f20291a48f0d14f83cf33a4c5f587dda4cba14934d5505f70f5b57b75db37', 'SUMASIHAM', 1, 1, 1, NULL, NULL, NULL, NULL),
(146, 'KK-111019', '-', '0f961ef6aea4aa1e1445a389dc5515db9e292beb32b7fd4571d691a66c3e1be4', 'ISNANI ALDILA PUTRI', 1, 1, 1, '-7.1866289,112.6149353', NULL, NULL, NULL),
(147, 'KK-605019', '-', '3594b327968ac49be9dfd5099c5e2791743a9b3613c6fa07b38b760ce8538895', 'SUTIYAH NINGSIH', 1, 1, 1, '-7.182878,112.612447', NULL, NULL, NULL),
(148, 'KK-602019', '-', '4502fca238899362165cd3ee2eee464bf77db7ce4f239e4cecaecfbcdd3f1b25', 'AGUNG SETIAWAN', 1, 1, 1, NULL, NULL, NULL, NULL),
(149, 'KK-500121', '-', 'bdb85f656f70b62f6cd8d1b169621a5d57326b7ee78f0ab0f175bafad2a273db', 'NIMAS GALUH PHITALOKA', 1, 1, 1, NULL, NULL, NULL, NULL),
(150, 'KK-700121', '-', '91fbd27335e80a8153ec536402458c23978ac794a96cfbaf0c9c6978fb47f261', 'DINA FEBIANTI HASANAH', 1, 1, 1, NULL, NULL, '2021-09-22 21:46:04', '423ae45e525cba90ff14febcdf523dc8');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `position_id` int(5) NOT NULL,
  `position_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_id`, `position_name`) VALUES
(1, 'STAFF'),
(2, 'ACCOUNTING'),
(7, 'MARKETING');

-- --------------------------------------------------------

--
-- Table structure for table `presence`
--

CREATE TABLE `presence` (
  `presence_id` int(11) NOT NULL,
  `employees_id` int(11) NOT NULL,
  `presence_date` date NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `picture_in` text NOT NULL,
  `picture_out` varchar(150) NOT NULL,
  `present_id` int(11) NOT NULL COMMENT 'Masuk,Pulang,Tidak Hadir',
  `latitude_longtitude_in` varchar(100) NOT NULL,
  `latitude_longtitude_out` varchar(100) NOT NULL,
  `information` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `presence`
--

INSERT INTO `presence` (`presence_id`, `employees_id`, `presence_date`, `time_in`, `time_out`, `picture_in`, `picture_out`, `present_id`, `latitude_longtitude_in`, `latitude_longtitude_out`, `information`) VALUES
(1, 6, '2021-08-10', '21:48:19', '22:45:54', '2021-08-10-in-1628606899-6.jpeg', '2021-08-10-out-1628610354-6.jpeg', 1, '-4.5585849,105.40680789999999', '-4.5585849,105.40680789999999', ''),
(2, 6, '2021-08-11', '00:19:18', '00:22:11', '2021-08-11-in-1628615958-6.jpeg', '2021-08-11-out-1628616131-6.jpeg', 1, '-4.5585849,105.40680789999999', '-4.5585849,105.40680789999999', ''),
(3, 16, '2021-08-28', '12:48:33', '12:51:37', '2021-08-28-in-1630129713-16.jpeg', '2021-08-28-out-1630129898-16.jpeg', 1, '-7.1607,112.647', '-7.1607,112.647', ''),
(4, 17, '2021-08-28', '13:11:38', '14:48:49', '2021-08-28-in-1630131098-17.jpeg', '2021-08-28-out-1630136929-17.jpeg', 1, '-7.1607,112.647', '-7.1607,112.647', ''),
(6, 19, '2021-08-28', '21:43:37', '00:00:00', '2021-08-28-in-1630161817-19.jpeg', '', 1, '-7.0822504,112.3807571', '', ''),
(8, 18, '2021-08-28', '22:04:01', '22:05:15', '2021-08-28-in-1630163042-18.jpeg', '2021-08-28-out-1630163116-18.jpeg', 1, '-7.1633786,112.6045809', '-7.1633786,112.6045809', ''),
(9, 19, '2021-08-30', '08:25:25', '09:21:35', '2021-08-30-in-1630286725-19.jpeg', '2021-08-30-out-1630290095-19.jpeg', 1, '-7.169170399999999,112.64492519999999', '-7.1692023,112.6449191', ''),
(10, 19, '2021-08-31', '11:45:12', '00:00:00', '2021-08-31-in-1630385112-19.jpeg', '', 1, '-7.0822576,112.3807719', '', ''),
(11, 18, '2021-09-01', '14:03:52', '00:00:00', '2021-09-01-in-1630479832-18.jpeg', '', 1, '-7.1633783,112.6045807', '', ''),
(12, 47, '2021-09-01', '14:26:00', '00:00:00', '2021-09-01-in-1630481160-47.jpeg', '', 1, '-7.1585246,112.641654', '', ''),
(13, 2, '2021-09-06', '12:45:43', '00:00:00', '2021-09-06-in-1630907143-2.jpeg', '', 1, '-7.1691617,112.6445174', '', ''),
(14, 47, '2021-09-21', '10:23:45', '00:00:00', '2021-09-21-in-1632194625-47.jpeg', '', 1, '-7.1671829,112.6549021', '', ''),
(16, 51, '2021-09-22', '10:41:39', '00:00:00', '2021-09-22-in-1632282100-51.jpeg', '', 1, '-7.1633777,112.6045802', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `present_status`
--

CREATE TABLE `present_status` (
  `present_id` int(6) NOT NULL,
  `present_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `present_status`
--

INSERT INTO `present_status` (`present_id`, `present_name`) VALUES
(1, 'Hadir'),
(2, 'Sakit'),
(3, 'Izin');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `shift_id` int(11) NOT NULL,
  `shift_name` varchar(20) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`shift_id`, `shift_name`, `time_in`, `time_out`) VALUES
(1, 'FULL TIME', '07:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `status_kerja`
--

CREATE TABLE `status_kerja` (
  `id` int(10) NOT NULL,
  `ket_kerja` varchar(5) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_kerja`
--

INSERT INTO `status_kerja` (`id`, `ket_kerja`, `status`) VALUES
(1, 'WFO', 'aktif'),
(2, 'WFH', 'nonaktif');

-- --------------------------------------------------------

--
-- Table structure for table `sw_site`
--

CREATE TABLE `sw_site` (
  `site_id` int(4) NOT NULL,
  `site_url` varchar(100) NOT NULL,
  `site_name` varchar(50) NOT NULL,
  `site_company` varchar(30) NOT NULL,
  `site_manager` varchar(30) NOT NULL,
  `site_director` varchar(30) NOT NULL,
  `site_phone` char(12) NOT NULL,
  `site_address` text NOT NULL,
  `site_description` text NOT NULL,
  `site_logo` varchar(50) NOT NULL,
  `site_email` varchar(30) NOT NULL,
  `site_email_domain` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sw_site`
--

INSERT INTO `sw_site` (`site_id`, `site_url`, `site_name`, `site_company`, `site_manager`, `site_director`, `site_phone`, `site_address`, `site_description`, `site_logo`, `site_email`, `site_email_domain`) VALUES
(1, 'https://warbinfal.xyz', 'Absensi Online', 'K3PG', ' ', ' ', '-', '-', 'Absensi online', 'whiteswlogowebpng.png', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `registered` datetime NOT NULL,
  `created_login` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `session` varchar(100) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `browser` varchar(30) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`, `fullname`, `registered`, `created_login`, `last_login`, `session`, `ip`, `browser`, `level`) VALUES
(1, 'admin', 'admin@gmail.com', '88222999e01f1910a5ac39fa37d3b8b704973d503d0ff7c84d46305b92cfa0f6', 'Administrator', '2021-02-03 10:22:00', '2021-09-22 21:44:53', '2021-09-01 13:53:25', '-', '1', 'Google Crome', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `level_id` int(4) NOT NULL,
  `level_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`level_id`, `level_name`) VALUES
(1, 'Administrator'),
(2, 'Operator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`building_id`);

--
-- Indexes for table `cuty`
--
ALTER TABLE `cuty`
  ADD PRIMARY KEY (`cuty_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `presence`
--
ALTER TABLE `presence`
  ADD PRIMARY KEY (`presence_id`);

--
-- Indexes for table `present_status`
--
ALTER TABLE `present_status`
  ADD PRIMARY KEY (`present_id`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`shift_id`);

--
-- Indexes for table `status_kerja`
--
ALTER TABLE `status_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sw_site`
--
ALTER TABLE `sw_site`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `building_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cuty`
--
ALTER TABLE `cuty`
  MODIFY `cuty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `position_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `presence`
--
ALTER TABLE `presence`
  MODIFY `presence_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `present_status`
--
ALTER TABLE `present_status`
  MODIFY `present_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `shift_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `status_kerja`
--
ALTER TABLE `status_kerja`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sw_site`
--
ALTER TABLE `sw_site`
  MODIFY `site_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_level`
--
ALTER TABLE `user_level`
  MODIFY `level_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
