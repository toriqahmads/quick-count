-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 03, 2019 at 10:21 PM
-- Server version: 5.7.22-0ubuntu18.04.1
-- PHP Version: 7.2.7-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qcount`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_data_pil` (IN `ids` INT(2))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;

SET jml := (SELECT COUNT(*) FROM pil WHERE id = ids AND status = 'l');

IF jml>0 THEN
UPDATE pil SET status = 'd' WHERE id = ids;

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
ELSE
SET msg = 'data not found';
END IF;
SELECT msg;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_data_saksi` (IN `ids` INT(2), IN `nomor_nik` VARCHAR(16))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;

SET jml := (SELECT COUNT(*) FROM saksi WHERE id = ids AND nik = nomor_nik);

IF jml>0 THEN
  UPDATE saksi SET status = 'd', nik = (SELECT CONCAT(nik, '+deleted')) WHERE id = ids;

  UPDATE users SET status = 'd', username = (SELECT CONCAT(username, '+deleted')) WHERE id_saksi = ids;

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;

ELSE
  SET msg = 'data not found';
END IF;
SELECT msg;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_proof` (IN `ids` INT(2))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;

SET jml := (SELECT COUNT(*) FROM proof WHERE id = ids AND status = 'l');

IF jml>0 THEN
UPDATE proof SET updated = NOW(), status = 'd' WHERE id = ids;

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
ELSE
  SET msg = 'data not found';
END IF;

SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_r_suara` (IN `ids` INT(2))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;

SET jml := (SELECT COUNT(*) FROM r_suara WHERE id = ids AND status = 'l');

IF jml>0 THEN
UPDATE r_suara SET updated = NOW(), status = 'd' WHERE id = ids;

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
ELSE
  SET msg = 'data not found';
END IF;
SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_suara` (IN `ids` INT(2))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;

SET jml := (SELECT COUNT(*) FROM suara WHERE id = ids AND status = 'l');

IF jml>0 THEN
UPDATE suara SET updated = NOW(), status = 'd' WHERE id = ids;

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
ELSE
  SET msg = 'data not found';
END IF;

SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_data_pil` (IN `fname` VARCHAR(15), IN `lname` VARCHAR(15), IN `partai` INT(2), IN `dapil` INT(2), IN `tingkat` ENUM('a','b','c','d','e'), IN `gender` CHAR(1), IN `foto` VARCHAR(255))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;

INSERT INTO pil(nama_depan, nama_belakang, gender, tingkat, id_partai, id_dapil, foto) VALUES (fname, lname, gender, tingkat, partai, dapil, foto);

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_data_saksi` (IN `fname` VARCHAR(15), IN `lname` VARCHAR(15), IN `sex` CHAR(1), IN `alamat` VARCHAR(30), IN `kel` INT(4), IN `kec` INT(2), IN `kab` INT(2), IN `prov` INT(2), IN `dapil` INT(2), IN `nomor_nik` VARCHAR(16), IN `telpon` VARCHAR(13), IN `tps` INT(2), IN `passwd` VARCHAR(255), IN `foto` VARCHAR(255))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
    GET DIAGNOSTICS CONDITION 1
      code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
      SET rb = 1;
END;

START TRANSACTION;

INSERT INTO users (username, pass) VALUES (nomor_nik, passwd);

INSERT INTO saksi (nama_depan, nama_belakang, gender, alamat, id_kel, id_kec, id_kab, id_prov, id_dapil, nik, telp, id_tps, foto)
VALUES (fname, lname, sex, alamat, kel, kec, kab, prov, dapil, nomor_nik, telpon, tps, foto);

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
  SET msg = 'success';
END IF;

SELECT msg;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_proof` (IN `photo` TEXT, IN `lokasi` VARCHAR(100), IN `dapil` INT(2), IN `tps` INT(2), IN `saksi` INT(3))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;
SET jml := (SELECT COUNT(*) FROM saksi WHERE id = ids AND status = 'l');

IF jml>0 THEN
INSERT INTO proof (foto, location, id_dapil, id_tps, id_saksi, tanggal, updated) VALUES (photo, lokasi, dapil, tps, saksi, NOW(), NOW());

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
ELSE
  SET msg = 'data for saksi not found';
END IF;
SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_r_suara` (IN `tipe` ENUM('a','b','c','d','cadangan'), IN `n` INT(5), IN `tingkatan` INT(2), IN `tps` INT(3))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;

INSERT INTO r_suara (jenis, jumlah, tingkat, id_tps, tanggal, updated) VALUES (tipe, n, tingkatan, tps, NOW(), NOW());

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_suara` (IN `j_suara` INT(7), IN `caleg` INT(2), IN `saksi` INT(3), IN `tps` INT(3), IN `tipe` ENUM('p','c'), IN `partai` INT(3))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;
SET jml := (SELECT COUNT(*) FROM saksi WHERE id = saksi AND status = 'l');

INSERT INTO suara (suara, id_caleg, id_saksi, tanggal, updated, id_tps, id_partai, jenis_suara) VALUES (j_suara, caleg, saksi, NOW(), NOW(), tps, partai, tipe);

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_tps` (IN `n_tps` VARCHAR(5), IN `dapil` INT(2), IN `kel` INT(2), IN `kec` INT(2), IN `kab` INT(2), IN `prov` INT(2))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;

INSERT INTO tps (tps, id_dapil, id_kel, id_kec, id_kab, id_prov) VALUES (n_tps, dapil, kel, kec, kab, prov);

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_data_pil` (IN `ids` INT(2), IN `fname` VARCHAR(15), IN `lname` VARCHAR(15), IN `partai` INT(2), IN `dapil` INT(2), IN `tingkat` ENUM('a','b','c','d','e'), IN `gender` CHAR(1), IN `foto` VARCHAR(255))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;

SET jml := (SELECT COUNT(*) FROM pil WHERE id = ids);

IF jml>0 THEN
UPDATE pil SET nama_depan = fname, nama_belakang = lname, id_partai = partai, id_dapil = dapil, tingkat = tingkat, gender = gender, foto = foto WHERE id = ids;

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
ELSE
  SET msg = 'data not found';
END IF;
SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_data_saksi` (IN `ids` INT(2), IN `fname` VARCHAR(15), IN `lname` VARCHAR(15), IN `sex` CHAR(1), IN `alamat` VARCHAR(30), IN `kel` INT(4), IN `kec` INT(2), IN `kab` INT(2), IN `prov` INT(2), IN `dapil` INT(2), IN `nomor_nik` VARCHAR(16), IN `telpon` VARCHAR(13), IN `tps` INT(2), IN `foto` VARCHAR(255))  BEGIN
DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;
SET jml := (SELECT COUNT(*) FROM saksi WHERE id = ids AND nik = nomor_nik);

IF jml>0 THEN
UPDATE saksi SET nama_depan = fname, nama_belakang = lname, gender = sex, alamat = alamat, id_kel = kel, id_kec = kec, id_kab = kab, id_prov = prov, id_dapil = dapil, nik = nomor_nik, telp = telpon, id_tps = tps, foto = foto WHERE id = ids;

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
ELSE
  SET msg = 'data not found';
END IF;
SELECT msg;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_proof` (IN `ids` INT(2), IN `photo` TEXT, IN `lokasi` VARCHAR(100), IN `dapil` INT(2), IN `tps` INT(2), IN `saksi` INT(3))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;

SET jml := (SELECT COUNT(*) FROM proof WHERE id = ids AND status = 'l');

IF jml>0 THEN
UPDATE proof SET foto = photo, location = lokasi, id_dapil = dapil, id_tps = tps, id_saksi = saksi, updated = NOW() WHERE id = ids;

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
ELSE 
  SET msg = 'data not found';
END IF;

SELECT msg;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_r_suara` (IN `ids` INT(2), IN `tipe` ENUM('a','b','c','d','cadangan'), IN `n` INT(5), IN `tingkatan` INT(2), IN `tps` INT(3))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;

SET jml := (SELECT COUNT(*) FROM r_suara WHERE id = ids AND status = 'l');

IF jml>0 THEN
UPDATE r_suara SET jenis = tipe, jumlah = n, tingkat = tingkatan, id_tps = tps WHERE id = ids;

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
ELSE
  SET msg = 'data not found';
END IF;

SELECT msg;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_suara` (IN `ids` INT(2), IN `j_suara` INT(7), IN `caleg` INT(2), IN `saksi` INT(3), IN `tps` INT(2), IN `tipe` ENUM('p','c'), IN `partai` INT(3))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;

SET jml := (SELECT COUNT(*) FROM suara WHERE id = ids AND status = 'l');

IF jml>0 THEN
UPDATE suara SET suara = j_suara, id_caleg = caleg, id_saksi = saksi, id_tps = tps, updated = NOW(), jenis_suara = tipe, id_partai = partai WHERE id = ids;

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
ELSE
  SET msg = 'data not found';
END IF;

SELECT msg;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_tps` (IN `ids` INT(2), IN `n_tps` VARCHAR(5), IN `dapil` INT(2), IN `kel` INT(2), IN `kec` INT(2), IN `kab` INT(2), IN `prov` INT(2))  BEGIN

DECLARE code CHAR(5) DEFAULT '00000';
DECLARE msg TEXT;
DECLARE rb BOOL DEFAULT 0;
DECLARE jml INT(1);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION, SQLWARNING, NOT FOUND
BEGIN
  GET DIAGNOSTICS CONDITION 1
    code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
    SET rb = 1;
END;

START TRANSACTION;
SET jml := (SELECT COUNT(*) FROM tps WHERE id = ids);

IF jml>0 THEN
UPDATE tps SET tps = n_tps, id_dapil = dapil, id_kel = kel, id_kec = kec, id_kab = kab, id_prov = prov WHERE id = ids;

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
ELSE
  SET msg = 'data not found';
END IF;
SELECT msg;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `pass`) VALUES
(1, 'admin', '$2y$10$NWIsiNRuhhh3s0WQw.z.7uPm9Lfm.HApQCTgyhziN//In8k.Pcr/W');

-- --------------------------------------------------------

--
-- Table structure for table `dapil`
--

CREATE TABLE `dapil` (
  `id` int(2) NOT NULL,
  `kursi` int(2) DEFAULT NULL,
  `DPT` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dapil`
--

INSERT INTO `dapil` (`id`, `kursi`, `DPT`) VALUES
(1, 12, 278333),
(2, 8, 183939),
(3, 8, 176297),
(4, 11, 236374),
(5, 11, 241400);

-- --------------------------------------------------------

--
-- Table structure for table `kab`
--

CREATE TABLE `kab` (
  `id` int(2) NOT NULL,
  `kab` varchar(25) DEFAULT NULL,
  `id_prov` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kab`
--

INSERT INTO `kab` (`id`, `kab`, `id_prov`) VALUES
(1, 'Demak', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kec`
--

CREATE TABLE `kec` (
  `id` int(2) NOT NULL,
  `kec` varchar(15) DEFAULT NULL,
  `id_kab` int(2) DEFAULT NULL,
  `id_prov` int(2) DEFAULT NULL,
  `id_dapil` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kec`
--

INSERT INTO `kec` (`id`, `kec`, `id_kab`, `id_prov`, `id_dapil`) VALUES
(1, 'Demak', 1, 1, 1),
(2, 'Dempet', 1, 1, 1),
(3, 'Kebonagung', 1, 1, 1),
(4, 'Wonosalam', 1, 1, 1),
(5, 'Bonang', 1, 1, 2),
(6, 'Wedung', 1, 1, 2),
(7, 'Gajah', 1, 1, 3),
(8, 'Karanganyar', 1, 1, 3),
(9, 'Mijen', 1, 1, 3),
(10, 'Karangawen', 1, 1, 4),
(11, 'Mranggen', 1, 1, 4),
(12, 'Guntur', 1, 1, 5),
(13, 'Karangtengah', 1, 1, 5),
(14, 'Sayung', 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `kel`
--

CREATE TABLE `kel` (
  `id` int(3) NOT NULL,
  `kel` varchar(20) DEFAULT NULL,
  `pos` int(6) DEFAULT NULL,
  `id_kec` int(2) DEFAULT NULL,
  `id_kab` int(2) DEFAULT NULL,
  `id_prov` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kel`
--

INSERT INTO `kel` (`id`, `kel`, `pos`, `id_kec`, `id_kab`, `id_prov`) VALUES
(1, 'Bintoro', 59511, 1, 1, 1),
(2, 'Betokan', 59512, 1, 1, 1),
(3, 'Singorejo', 59513, 1, 1, 1),
(4, 'Kalicilik', 59514, 1, 1, 1),
(5, 'Mangunjiwan', 59515, 1, 1, 1),
(6, 'Katonsari', 59516, 1, 1, 1),
(7, 'Bango', 59517, 1, 1, 1),
(8, 'Bolo', 59517, 1, 1, 1),
(9, 'Cabean', 59517, 1, 1, 1),
(10, 'Donorejo', 59517, 1, 1, 1),
(11, 'Kadilangu', 59517, 1, 1, 1),
(12, 'Kalikondang', 59517, 1, 1, 1),
(13, 'Karangmlati', 59517, 1, 1, 1),
(14, 'Kedondong', 59517, 1, 1, 1),
(15, 'Mulyorejo', 59517, 1, 1, 1),
(16, 'Raji', 59517, 1, 1, 1),
(17, 'Sedo', 59517, 1, 1, 1),
(18, 'Tempuran', 59517, 1, 1, 1),
(19, 'Turirejo', 59517, 1, 1, 1),
(20, 'Balerejo', 59573, 2, 1, 1),
(21, 'Baleromo', 59573, 2, 1, 1),
(22, 'Botosengon', 59573, 2, 1, 1),
(23, 'Brakas', 59573, 2, 1, 1),
(24, 'Dempet', 59573, 2, 1, 1),
(25, 'Gempoldenok', 59573, 2, 1, 1),
(26, 'Harjowinangun', 59573, 2, 1, 1),
(27, 'Jerukgulung', 59573, 2, 1, 1),
(28, 'Karangrejo', 59573, 2, 1, 1),
(29, 'Kebonsari', 59573, 2, 1, 1),
(30, 'Kedungori', 59573, 2, 1, 1),
(31, 'Kramat', 59573, 2, 1, 1),
(32, 'Kunir', 59573, 2, 1, 1),
(33, 'Kuwu', 59573, 2, 1, 1),
(34, 'Merak', 59573, 2, 1, 1),
(35, 'Sidomulyo', 59573, 2, 1, 1),
(36, 'Kebonagung', 59583, 3, 1, 1),
(37, 'Klampok Lor', 59583, 3, 1, 1),
(38, 'Mangunan Lor', 59583, 3, 1, 1),
(39, 'Mangunrejo', 59583, 3, 1, 1),
(40, 'Megonten', 59583, 3, 1, 1),
(41, 'Mijen', 59583, 3, 1, 1),
(42, 'Pilangwetan', 59583, 3, 1, 1),
(43, 'Prigi', 59583, 3, 1, 1),
(44, 'Sarimulyo', 59583, 3, 1, 1),
(45, 'Soko Kidul', 59583, 3, 1, 1),
(46, 'Solowire', 59583, 3, 1, 1),
(47, 'Tlogosih', 59583, 3, 1, 1),
(48, 'Werdoyo', 59583, 3, 1, 1),
(49, 'Botorejo', 59571, 4, 1, 1),
(50, 'Bunderan', 59571, 4, 1, 1),
(51, 'Doreng', 59571, 4, 1, 1),
(52, 'Getas', 59571, 4, 1, 1),
(53, 'Jogoloyo', 59571, 4, 1, 1),
(54, 'Kalianyar', 59571, 4, 1, 1),
(55, 'Karangrejo', 59571, 4, 1, 1),
(56, 'Karangrowo', 59571, 4, 1, 1),
(57, 'Kendaldoyong', 59571, 4, 1, 1),
(58, 'Kerangkulon', 59571, 4, 1, 1),
(59, 'Kuncir', 59571, 4, 1, 1),
(60, 'Lempuyang', 59571, 4, 1, 1),
(61, 'Mojodemak', 59571, 4, 1, 1),
(62, 'Mranak', 59571, 4, 1, 1),
(63, 'Mrisen', 59571, 4, 1, 1),
(64, 'Pilangrejo', 59571, 4, 1, 1),
(65, 'Sido Mulyo', 59571, 4, 1, 1),
(66, 'Tlogodowo', 59571, 4, 1, 1),
(67, 'Tlogorejo', 59571, 4, 1, 1),
(68, 'Trengguli', 59571, 4, 1, 1),
(69, 'Wonosalam', 59571, 4, 1, 1),
(70, 'Kembangan', 59511, 5, 1, 1),
(71, 'Betahwalang', 59552, 5, 1, 1),
(72, 'Bonangrejo', 59552, 5, 1, 1),
(73, 'Gebang', 59552, 5, 1, 1),
(74, 'Gebangarum', 59552, 5, 1, 1),
(75, 'Jali', 59552, 5, 1, 1),
(76, 'Jatimulyo', 59552, 5, 1, 1),
(77, 'Jatirogo', 59552, 5, 1, 1),
(78, 'Karangrejo', 59552, 5, 1, 1),
(79, 'Krajanbogo', 59552, 5, 1, 1),
(80, 'Margolinduk', 59552, 5, 1, 1),
(81, 'Morodemak', 59552, 5, 1, 1),
(82, 'Poncoharjo', 59552, 5, 1, 1),
(83, 'Purworejo', 59552, 5, 1, 1),
(84, 'Serangan', 59552, 5, 1, 1),
(85, 'Sukodono', 59552, 5, 1, 1),
(86, 'Sumberejo', 59552, 5, 1, 1),
(87, 'Tlogoboyo', 59552, 5, 1, 1),
(88, 'Tridonorejo', 59552, 5, 1, 1),
(89, 'Weding', 59552, 5, 1, 1),
(90, 'Wonosari', 59552, 5, 1, 1),
(91, 'Babalan', 59554, 6, 1, 1),
(92, 'Berahan Kulon', 59554, 6, 1, 1),
(93, 'Berahan Wetan', 59554, 6, 1, 1),
(94, 'Buko', 59554, 6, 1, 1),
(95, 'Bungo', 59554, 6, 1, 1),
(96, 'Jetak', 59554, 6, 1, 1),
(97, 'Jungpasir', 59554, 6, 1, 1),
(98, 'Jungsemi', 59554, 6, 1, 1),
(99, 'Kedungkarang', 59554, 6, 1, 1),
(100, 'Kedungmutih', 59554, 6, 1, 1),
(101, 'Kendalasem', 59554, 6, 1, 1),
(102, 'Kenduren', 59554, 6, 1, 1),
(103, 'Mandung', 59554, 6, 1, 1),
(104, 'Mutih Kulon', 59554, 6, 1, 1),
(105, 'Mutih Wetan', 59554, 6, 1, 1),
(106, 'Ngawen', 59554, 6, 1, 1),
(107, 'Ruwit', 59554, 6, 1, 1),
(108, 'Tedunan', 59554, 6, 1, 1),
(109, 'Tempel', 59554, 6, 1, 1),
(110, 'Wedung', 59554, 6, 1, 1),
(111, 'Banjarsari', 59581, 7, 1, 1),
(112, 'Boyolali', 59581, 7, 1, 1),
(113, 'Gajah', 59581, 7, 1, 1),
(114, 'Gedangalas', 59581, 7, 1, 1),
(115, 'Jatisono', 59581, 7, 1, 1),
(116, 'Kedondong', 59581, 7, 1, 1),
(117, 'Medini', 59581, 7, 1, 1),
(118, 'Mlatiharjo', 59581, 7, 1, 1),
(119, 'Mlekang', 59581, 7, 1, 1),
(120, 'Mojosimo', 59581, 7, 1, 1),
(121, 'Sambiroto', 59581, 7, 1, 1),
(122, 'Sambung', 59581, 7, 1, 1),
(123, 'Sarirejo', 59581, 7, 1, 1),
(124, 'Surodadi', 59581, 7, 1, 1),
(125, 'Tambirejo', 59581, 7, 1, 1),
(126, 'Tanjunganyar', 59581, 7, 1, 1),
(127, 'Tlogopandogan', 59581, 7, 1, 1),
(128, 'Wilalung', 59581, 7, 1, 1),
(129, 'Bandungrejo', 59582, 8, 1, 1),
(130, 'Cangkring', 59582, 8, 1, 1),
(131, 'Cangkring Rembang', 59582, 8, 1, 1),
(132, 'Jatirejo', 59582, 8, 1, 1),
(133, 'Karanganyar', 59582, 8, 1, 1),
(134, 'Kedungwaru Kidul', 59582, 8, 1, 1),
(135, 'Kedungwaru Lor', 59582, 8, 1, 1),
(136, 'Ketanjung', 59582, 8, 1, 1),
(137, 'Kotakan', 59582, 8, 1, 1),
(138, 'Ngaluran', 59582, 8, 1, 1),
(139, 'Ngemplik Wetan', 59582, 8, 1, 1),
(140, 'Tugu Lor', 59582, 8, 1, 1),
(141, 'Tuwang', 59582, 8, 1, 1),
(142, 'Undaan Kidul', 59582, 8, 1, 1),
(143, 'Undaan Lor', 59582, 8, 1, 1),
(144, 'Wonoketingal', 59582, 8, 1, 1),
(145, 'Wonorejo', 59582, 8, 1, 1),
(146, 'Bakung', 59583, 9, 1, 1),
(147, 'Banteng Mati', 59583, 9, 1, 1),
(148, 'Bermi', 59583, 9, 1, 1),
(149, 'Gempolsongo', 59583, 9, 1, 1),
(150, 'Geneng', 59583, 9, 1, 1),
(151, 'Jleper', 59583, 9, 1, 1),
(152, 'Mijen', 59583, 9, 1, 1),
(153, 'Mlaten', 59583, 9, 1, 1),
(154, 'Ngegot', 59583, 9, 1, 1),
(155, 'Ngelo Kulon', 59583, 9, 1, 1),
(156, 'Ngelo Wetan', 59583, 9, 1, 1),
(157, 'Pasir', 59583, 9, 1, 1),
(158, 'Pecuk', 59583, 9, 1, 1),
(159, 'Rejosari', 59583, 9, 1, 1),
(160, 'Tanggul', 59583, 9, 1, 1),
(161, 'Brambang', 59566, 10, 1, 1),
(162, 'Bumirejo', 59566, 10, 1, 1),
(163, 'Jragung', 59566, 10, 1, 1),
(164, 'Karangawen', 59566, 10, 1, 1),
(165, 'Kuripan', 59566, 10, 1, 1),
(166, 'Margohayu', 59566, 10, 1, 1),
(167, 'Pundenarum', 59566, 10, 1, 1),
(168, 'Rejosari', 59566, 10, 1, 1),
(169, 'Sido Rejo', 59566, 10, 1, 1),
(170, 'Teluk', 59566, 10, 1, 1),
(171, 'Tlogorejo', 59566, 10, 1, 1),
(172, 'Wonosekar', 59566, 10, 1, 1),
(173, 'Bandungrejo', 59567, 11, 1, 1),
(174, 'Banyumeneng', 59567, 11, 1, 1),
(175, 'Batursari', 59567, 11, 1, 1),
(176, 'Brumbung', 59567, 11, 1, 1),
(177, 'Candisari', 59567, 11, 1, 1),
(178, 'Jamus', 59567, 11, 1, 1),
(179, 'Kalitengah', 59567, 11, 1, 1),
(180, 'Kangkung', 59567, 11, 1, 1),
(181, 'Karangsono', 59567, 11, 1, 1),
(182, 'Kebonbatur', 59567, 11, 1, 1),
(183, 'Kembangarum', 59567, 11, 1, 1),
(184, 'Menur', 59567, 11, 1, 1),
(185, 'Mranggen', 59567, 11, 1, 1),
(186, 'Ngemplak', 59567, 11, 1, 1),
(187, 'Sumberejo', 59567, 11, 1, 1),
(188, 'Tamansari', 59567, 11, 1, 1),
(189, 'Tegalarum', 59567, 11, 1, 1),
(190, 'Waru', 59567, 11, 1, 1),
(191, 'Wringin Jajar', 59567, 11, 1, 1),
(192, 'Bakalrejo', 59565, 12, 1, 1),
(193, 'Banjarejo', 59565, 12, 1, 1),
(194, 'Blerong', 59565, 12, 1, 1),
(195, 'Bogosari', 59565, 12, 1, 1),
(196, 'Bumiharjo', 59565, 12, 1, 1),
(197, 'Gaji', 59565, 12, 1, 1),
(198, 'Guntur', 59565, 12, 1, 1),
(199, 'Krandon', 59565, 12, 1, 1),
(200, 'Pamongan', 59565, 12, 1, 1),
(201, 'Sarirejo', 59565, 12, 1, 1),
(202, 'Sidoharjo', 59565, 12, 1, 1),
(203, 'Sidokumpul', 59565, 12, 1, 1),
(204, 'Sukorejo', 59565, 12, 1, 1),
(205, 'Tangkis', 59565, 12, 1, 1),
(206, 'Temuroso', 59565, 12, 1, 1),
(207, 'Tlogorejo', 59565, 12, 1, 1),
(208, 'Tlogoweru', 59565, 12, 1, 1),
(209, 'Trimulyo', 59565, 12, 1, 1),
(210, 'Turitempel', 59565, 12, 1, 1),
(211, 'Wonorejo', 59565, 12, 1, 1),
(212, 'Batu', 59561, 13, 1, 1),
(213, 'Donorejo', 59561, 13, 1, 1),
(214, 'Dukun', 59561, 13, 1, 1),
(215, 'Grogol', 59561, 13, 1, 1),
(216, 'Karangsari', 59561, 13, 1, 1),
(217, 'Karangtowo', 59561, 13, 1, 1),
(218, 'Kedunguter', 59561, 13, 1, 1),
(219, 'Klitih', 59561, 13, 1, 1),
(220, 'Pidodo', 59561, 13, 1, 1),
(221, 'Ploso', 59561, 13, 1, 1),
(222, 'Pulosari', 59561, 13, 1, 1),
(223, 'Rejosari', 59561, 13, 1, 1),
(224, 'Sampang', 59561, 13, 1, 1),
(225, 'Tambakbulusan', 59561, 13, 1, 1),
(226, 'Wonoagung', 59561, 13, 1, 1),
(227, 'Wonokerto', 59561, 13, 1, 1),
(228, 'Wonowoso', 59561, 13, 1, 1),
(229, 'Banjarsari', 59563, 14, 1, 1),
(230, 'Bedono', 59563, 14, 1, 1),
(231, 'Bulusari', 59563, 14, 1, 1),
(232, 'Dombo', 59563, 14, 1, 1),
(233, 'Gemulak', 59563, 14, 1, 1),
(234, 'Jetaksari', 59563, 14, 1, 1),
(235, 'Kalisari', 59563, 14, 1, 1),
(236, 'Karangasem', 59563, 14, 1, 1),
(237, 'Loireng', 59563, 14, 1, 1),
(238, 'Perampelan', 59563, 14, 1, 1),
(239, 'Pilangsari', 59563, 14, 1, 1),
(240, 'Purwosari', 59563, 14, 1, 1),
(241, 'Sayung', 59563, 14, 1, 1),
(242, 'Sidogemah', 59563, 14, 1, 1),
(243, 'Sidorejo', 59563, 14, 1, 1),
(244, 'Sriwulan', 59563, 14, 1, 1),
(245, 'Surodadi', 59563, 14, 1, 1),
(246, 'Tambakroto', 59563, 14, 1, 1),
(247, 'Timbulsloko', 59563, 14, 1, 1),
(248, 'Tugu', 59563, 14, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `partai`
--

CREATE TABLE `partai` (
  `id` int(2) NOT NULL,
  `partai` varchar(15) DEFAULT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'demak.png'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partai`
--

INSERT INTO `partai` (`id`, `partai`, `foto`) VALUES
(1, 'Demokrat', 'demak.png'),
(2, 'Golongan Karya', '1534913498.jpg'),
(3, 'Nasdem', '1549206827.png');

-- --------------------------------------------------------

--
-- Table structure for table `pil`
--

CREATE TABLE `pil` (
  `id` int(2) NOT NULL,
  `nama_depan` varchar(15) DEFAULT NULL,
  `nama_belakang` varchar(15) DEFAULT NULL,
  `gender` char(1) NOT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'default_avatar.jpg',
  `tingkat` enum('a','b','c','d','e') NOT NULL COMMENT 'a = presiden. b = dpd. c = dppri. d = dpr prov. e = dpr kab',
  `id_partai` int(2) DEFAULT NULL,
  `id_dapil` int(2) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'l' COMMENT '''l'' untuk data masih digunakan, ''d'' untuk data sudah dihapus'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pil`
--

INSERT INTO `pil` (`id`, `nama_depan`, `nama_belakang`, `gender`, `foto`, `tingkat`, `id_partai`, `id_dapil`, `status`) VALUES
(1, 'Misbahul', 'Munir S.E, M.Pd', 'l', '1540635564.png', 'e', 1, 1, 'l'),
(2, 'Irham', 'Najib', 'l', '1549203514.png', 'e', 2, 1, 'l');

-- --------------------------------------------------------

--
-- Table structure for table `proof`
--

CREATE TABLE `proof` (
  `id` int(2) NOT NULL,
  `foto` text,
  `location` varchar(100) DEFAULT NULL,
  `id_dapil` int(2) DEFAULT NULL,
  `id_tps` int(2) DEFAULT NULL,
  `id_saksi` int(3) DEFAULT NULL,
  `tanggal` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'l' COMMENT '''l'' untuk data masih digunakan, ''d'' untuk data sudah dihapus'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prov`
--

CREATE TABLE `prov` (
  `id` int(2) NOT NULL,
  `prov` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prov`
--

INSERT INTO `prov` (`id`, `prov`) VALUES
(1, 'Jawa Tengah');

-- --------------------------------------------------------

--
-- Table structure for table `r_suara`
--

CREATE TABLE `r_suara` (
  `id` int(3) NOT NULL,
  `jenis` enum('a','b','c','d') DEFAULT NULL COMMENT 'a = surat rusak. b = surat tidak terpakai. c = surat sah. d = surat tidak sah. e = (c+d)->suara sah dan tidak sah. ',
  `jumlah` int(5) DEFAULT NULL,
  `tingkat` enum('a','b','c','d','e') DEFAULT NULL COMMENT 'a = presiden. b = dpd. c = dppri. d = dpr prov. e = dpr kab',
  `id_tps` int(3) DEFAULT NULL,
  `tanggal` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'l' COMMENT '''l'' untuk data masih digunakan, ''d'' untuk data sudah dihapus'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `saksi`
--

CREATE TABLE `saksi` (
  `id` int(3) NOT NULL,
  `nama_depan` varchar(15) DEFAULT NULL,
  `nama_belakang` varchar(15) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `alamat` varchar(30) DEFAULT NULL,
  `id_kel` int(4) DEFAULT NULL,
  `id_kec` int(2) DEFAULT NULL,
  `id_kab` int(2) DEFAULT NULL,
  `id_prov` int(2) DEFAULT NULL,
  `id_dapil` int(2) DEFAULT NULL,
  `nik` varchar(25) DEFAULT NULL,
  `foto` varchar(30) DEFAULT 'default_avatar.jpg',
  `telp` varchar(13) DEFAULT NULL,
  `id_tps` int(3) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'l' COMMENT '''l'' untuk data masih digunakan, ''d'' untuk data sudah dihapus'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saksi`
--

INSERT INTO `saksi` (`id`, `nama_depan`, `nama_belakang`, `gender`, `alamat`, `id_kel`, `id_kec`, `id_kab`, `id_prov`, `id_dapil`, `nik`, `foto`, `telp`, `id_tps`, `status`) VALUES
(1, 'Muhammad', 'Haimin', 'l', 'Jl. Kyai Singki no.45', 1, 1, 1, 1, 1, '337230934799234+deleted', 'Images2.jpg', '089667823877', 2, 'd'),
(2, 'Rozikin', 'Ahmad', 'l', 'Jl. Pahlawan no.11', 1, 1, 1, 1, 1, '3340034987239080+deleted', 'default_avatar.jpg', '089668623899', 2, 'd'),
(3, 'Fadli', 'Ihsan', 'l', 'Jl. Tentara Pelajar no.11', 1, 1, 1, 1, 1, '3302210111900006', 'default_avatar.jpg', '089668623333', 2, 'l'),
(4, 'Ziat', 'Ahmad', 'l', 'Jl. Wadak Sempal no.11', 1, 1, 1, 1, 1, '3302210111900007', 'default_avatar.jpg', '089667865658', 2, 'l'),
(5, 'Ahmad', 'Husain', 'l', 'Jl. Kyai Singkil no.4', 1, 1, 1, 1, 1, '3302210111900004', 'default_avatar.jpg', '08966862385', 2, 'l'),
(6, 'Ahmad', 'Roziqin', 'l', 'Jl. Kyai Singkil no.45', 1, 1, 1, 1, 1, '3302210111900001', 'default_avatar.jpg', '089667682352', 2, 'l'),
(7, 'Ahmad', 'Zaenudin', 'l', 'Jl. Tentara plejar no.4', 1, 1, 1, 1, 1, '3302210111900009', 'default_avatar.jpg', '089668687263', 2, 'l'),
(8, 'Toriq', 'Ahmad', 'l', 'Jl. Wiku 2 no.4', 1, 1, 1, 1, 1, '3302210111900000', 'default_avatar.jpg', '0896678268376', 2, 'l'),
(9, 'Zuli', 'Husadah', 'l', 'Jl. Kyai Singkil no.45', 1, 1, 1, 1, 1, '3302210111900012', 'default_avatar.jpg', '089556753242', 2, 'l'),
(10, 'Ahmad', 'Zubair', 'l', 'Jl. Kyai jebat no.11', 1, 1, 1, 1, 1, '3302210111900014', 'default_avatar.jpg', '08966768564', 2, 'l'),
(11, 'Toriq', 'Ahmad', 'l', 'Jl. Kyai Singkil no.45', 1, 1, 1, 1, 1, '3325436456567567', 'default_avatar.jpg', '089668623333', 2, 'l'),
(12, 'Misbahuls', 'Munir S.E, M.Pd', 'l', 'Jl. Kyai Singkil no.45', 70, 5, 1, 1, 2, '3324455667783943', '1534922517.jpg', '0896686233323', 2, 'l'),
(13, 'Gufron', 'Ibrahim', 'l', 'Jl. Kyai Singkil no.45', 1, 1, 1, 1, 1, '3324455667783940', 'default_avatar.jpg', '089668623373', 2, 'l'),
(14, 'Gufron', 'Ahmad', 'l', 'Jl. Kyai Singkil no.45', 1, 1, 1, 1, 1, '3324455667788551', '1533979114.png', '0896686233326', 2, 'l');

--
-- Triggers `saksi`
--
DELIMITER $$
CREATE TRIGGER `insert_user` AFTER INSERT ON `saksi` FOR EACH ROW UPDATE users SET id_saksi = NEW.id WHERE username = NEW.nik
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `suara`
--

CREATE TABLE `suara` (
  `id` int(2) NOT NULL,
  `suara` int(7) DEFAULT NULL,
  `id_caleg` int(2) DEFAULT NULL,
  `id_saksi` int(3) DEFAULT NULL,
  `tanggal` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `id_tps` int(3) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'l' COMMENT '''l'' untuk data masih digunakan, ''d'' untuk data sudah dihapus',
  `id_partai` int(2) DEFAULT NULL,
  `jenis_suara` enum('p','c') NOT NULL COMMENT 'p = suara partai, c = suara caleg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suara`
--

INSERT INTO `suara` (`id`, `suara`, `id_caleg`, `id_saksi`, `tanggal`, `updated`, `id_tps`, `status`, `id_partai`, `jenis_suara`) VALUES
(2, 235, NULL, 1, '2019-02-03 21:19:57', '2019-02-03 22:12:15', 3, 'd', 1, 'p'),
(3, 764, 1, 1, '2019-02-03 21:19:57', '2019-02-03 22:12:15', 3, 'd', 1, 'c'),
(4, 123, NULL, 1, '2019-02-03 21:20:09', '2019-02-03 22:12:19', 3, 'd', 2, 'p'),
(5, 1234, 2, 1, '2019-02-03 21:20:09', '2019-02-03 22:12:19', 3, 'd', 2, 'c');

-- --------------------------------------------------------

--
-- Table structure for table `tps`
--

CREATE TABLE `tps` (
  `id` int(3) NOT NULL,
  `tps` varchar(5) DEFAULT NULL,
  `id_dapil` int(2) DEFAULT NULL,
  `id_kel` int(3) DEFAULT NULL,
  `id_kec` int(2) DEFAULT NULL,
  `id_kab` int(2) DEFAULT NULL,
  `id_prov` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tps`
--

INSERT INTO `tps` (`id`, `tps`, `id_dapil`, `id_kel`, `id_kec`, `id_kab`, `id_prov`) VALUES
(2, 'TPS 3', 2, 70, 5, 1, 1),
(3, 'TPS 1', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(2) NOT NULL,
  `username` varchar(25) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `id_saksi` int(2) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'l' COMMENT '''l'' untuk data masih digunakan, ''d'' untuk data sudah dihapus'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `pass`, `id_saksi`, `status`) VALUES
(1, '337230934799234+deleted', 'Kbps1234', 1, 'd'),
(2, '3340034987239080+deleted', '$2a$04$7DNeUGBxI0JUVoW61.JQOe1RbcEqMaqxE.WuBmf/SDmTJvXyt8KCK', 2, 'd'),
(3, '3302210111900006', '$2y$10$IzgNMJr.Q7N7cgKSnYQb8.8.X5cUA1NraXsXZ9FjUqbeEJgZXrCjS', 3, 'l'),
(4, '3302210111900007', '$2y$10$7xeIwQhWx22WVMHpxkv80ud505hjxkCN2UgufNYzBTi76PAY0URJC', 4, 'l'),
(5, '3302210111900004', '$2y$10$37viONb42WPIZgwDrOPYme6V3B15Veg9Wsqt5iHluLbdmNm.YNME6', 5, 'l'),
(6, '3302210111900001', '$2y$10$58R.0ePmX.z.YWQBTaeUBuU5u8vECfjp7scJo8tMtrkYQ.GzJhdYi', 6, 'l'),
(7, '3302210111900009', '$2y$10$bcY2dbV3dAlj.PskRfi2peVDDFD97Kqam9CmReFzgsmTAqHZfYfA6', 7, 'l'),
(8, '3302210111900000', '$2y$10$njZP2GrrP1QhkUJM4hTbDONTNE3AaUdGMgpEfhW4gYARp4SCdt28G', 8, 'l'),
(9, '3302210111900012', '$2y$10$eWOvA8gYqxL7Diph7uzbJuh6U.q2pxCCHEKgmJirsdh.JanBA1OQm', 9, 'l'),
(10, '3302210111900014', '$2y$10$sKlQANl6GDZunU2IiJDQheObbO4TxcbbqJvpv6EVFMeWEyqk8hqQu', 10, 'l'),
(11, '3325436456567567', '$2y$10$wMgvCkUmIWbV52k8/SQ4xulo.ACOHQAbm46D7VxcuscmbSs69ZuDy', 11, 'l'),
(12, '3324455667783943', '$2y$10$lc.aT5itzlEBvgcaThC50OoYGCZsL3bNBdAhJzJcigTPoFL0V.ira', 12, 'l'),
(13, '3324455667783940', '$2y$10$4CrlegMERUibfY3jWKsm2e7DIYNN2ZMpPv3bju9/O81B.FOv9Vl4a', 13, 'l'),
(14, '3324455667788551', '$2y$10$A/a/lfBuvijhonBO69C5/.UPpWfhJziucg/oygsjNwpKtlmB6yY6C', 14, 'l');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `dapil`
--
ALTER TABLE `dapil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kab`
--
ALTER TABLE `kab`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kab_ibfk_1` (`id_prov`);

--
-- Indexes for table `kec`
--
ALTER TABLE `kec`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kec_ibfk_1` (`id_kab`),
  ADD KEY `kec_ibfk_2` (`id_prov`),
  ADD KEY `kec_ibfk_3` (`id_dapil`);

--
-- Indexes for table `kel`
--
ALTER TABLE `kel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kel_ibfk_1` (`id_kec`),
  ADD KEY `kel_ibfk_2` (`id_kab`),
  ADD KEY `kel_ibfk_3` (`id_prov`);

--
-- Indexes for table `partai`
--
ALTER TABLE `partai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pil`
--
ALTER TABLE `pil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caleg_ibfk_1` (`id_partai`),
  ADD KEY `caleg_ibfk_2` (`id_dapil`);

--
-- Indexes for table `proof`
--
ALTER TABLE `proof`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proof_ibfk_1` (`id_dapil`),
  ADD KEY `proof_ibfk_3` (`id_saksi`),
  ADD KEY `proof_ibfk_2` (`id_tps`);

--
-- Indexes for table `prov`
--
ALTER TABLE `prov`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `r_suara`
--
ALTER TABLE `r_suara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `r_suara_ibfk_1` (`id_tps`);

--
-- Indexes for table `saksi`
--
ALTER TABLE `saksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `saksi_rel_dapil` (`id_dapil`),
  ADD KEY `saksi_rel_prov` (`id_prov`),
  ADD KEY `saksi_rel_kab` (`id_kab`),
  ADD KEY `saksi_rel_kec` (`id_kec`),
  ADD KEY `saksi_rel_kel` (`id_kel`),
  ADD KEY `saksi_tps` (`id_tps`);

--
-- Indexes for table `suara`
--
ALTER TABLE `suara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suara_tps` (`id_tps`),
  ADD KEY `suara_ibfk_1` (`id_caleg`),
  ADD KEY `suara_ibfk_3` (`id_saksi`),
  ADD KEY `suara_parta` (`id_partai`);

--
-- Indexes for table `tps`
--
ALTER TABLE `tps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tps_ibfk_1` (`id_dapil`),
  ADD KEY `tps_ibfk_2` (`id_kel`),
  ADD KEY `tps_ibfk_3` (`id_kec`),
  ADD KEY `tps_ibfk_4` (`id_kab`),
  ADD KEY `tps_ibfk_5` (`id_prov`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_saksi` (`id_saksi`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dapil`
--
ALTER TABLE `dapil`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `kab`
--
ALTER TABLE `kab`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `kec`
--
ALTER TABLE `kec`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `kel`
--
ALTER TABLE `kel`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;
--
-- AUTO_INCREMENT for table `partai`
--
ALTER TABLE `partai`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pil`
--
ALTER TABLE `pil`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `proof`
--
ALTER TABLE `proof`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `prov`
--
ALTER TABLE `prov`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `r_suara`
--
ALTER TABLE `r_suara`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `saksi`
--
ALTER TABLE `saksi`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `suara`
--
ALTER TABLE `suara`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tps`
--
ALTER TABLE `tps`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `kab`
--
ALTER TABLE `kab`
  ADD CONSTRAINT `kab_ibfk_1` FOREIGN KEY (`id_prov`) REFERENCES `prov` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `kec`
--
ALTER TABLE `kec`
  ADD CONSTRAINT `kec_ibfk_1` FOREIGN KEY (`id_kab`) REFERENCES `kab` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kec_ibfk_2` FOREIGN KEY (`id_prov`) REFERENCES `prov` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kec_ibfk_3` FOREIGN KEY (`id_dapil`) REFERENCES `dapil` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `kel`
--
ALTER TABLE `kel`
  ADD CONSTRAINT `kel_ibfk_1` FOREIGN KEY (`id_kec`) REFERENCES `kec` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kel_ibfk_2` FOREIGN KEY (`id_kab`) REFERENCES `kab` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kel_ibfk_3` FOREIGN KEY (`id_prov`) REFERENCES `prov` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pil`
--
ALTER TABLE `pil`
  ADD CONSTRAINT `pil_ibfk_1` FOREIGN KEY (`id_partai`) REFERENCES `partai` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pil_ibfk_2` FOREIGN KEY (`id_dapil`) REFERENCES `dapil` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `proof`
--
ALTER TABLE `proof`
  ADD CONSTRAINT `proof_ibfk_1` FOREIGN KEY (`id_dapil`) REFERENCES `dapil` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `proof_ibfk_2` FOREIGN KEY (`id_tps`) REFERENCES `tps` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `proof_ibfk_3` FOREIGN KEY (`id_saksi`) REFERENCES `saksi` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `r_suara`
--
ALTER TABLE `r_suara`
  ADD CONSTRAINT `r_suara_ibfk_1` FOREIGN KEY (`id_tps`) REFERENCES `tps` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `saksi`
--
ALTER TABLE `saksi`
  ADD CONSTRAINT `saksi_rel_dapil` FOREIGN KEY (`id_dapil`) REFERENCES `dapil` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `saksi_rel_kab` FOREIGN KEY (`id_kab`) REFERENCES `kab` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `saksi_rel_kec` FOREIGN KEY (`id_kec`) REFERENCES `kec` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `saksi_rel_kel` FOREIGN KEY (`id_kel`) REFERENCES `kel` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `saksi_rel_prov` FOREIGN KEY (`id_prov`) REFERENCES `prov` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `saksi_tps` FOREIGN KEY (`id_tps`) REFERENCES `tps` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tps`
--
ALTER TABLE `tps`
  ADD CONSTRAINT `tps_ibfk_1` FOREIGN KEY (`id_dapil`) REFERENCES `dapil` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tps_ibfk_2` FOREIGN KEY (`id_kel`) REFERENCES `kel` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tps_ibfk_3` FOREIGN KEY (`id_kec`) REFERENCES `kec` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tps_ibfk_4` FOREIGN KEY (`id_kab`) REFERENCES `kab` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tps_ibfk_5` FOREIGN KEY (`id_prov`) REFERENCES `prov` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
