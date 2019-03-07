-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 07, 2019 at 11:17 PM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_suara_desa` (IN `ids` INT(2))  BEGIN

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

SET jml := (SELECT COUNT(*) FROM suara_desa WHERE id = ids AND status = 'l');

IF jml>0 THEN
UPDATE suara_desa SET updated = NOW(), status = 'd' WHERE id = ids;

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_data_pil` (IN `fname` VARCHAR(15), IN `lname` VARCHAR(15), IN `partai` INT(2), IN `dapil` INT(2), IN `tingkat` ENUM('a','b','c','d','e'), IN `gender` CHAR(1), IN `foto` VARCHAR(255), IN `prov` INT(2), IN `kab` INT(3), IN `no_urut` INT(3), IN `kec` INT(3))  BEGIN

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

INSERT INTO pil(nama_depan, nama_belakang, gender, tingkat, id_prov, id_kab, id_partai, id_dapil, foto, no_urut, id_kec) VALUES (fname, lname, gender, tingkat, prov, kab, partai, dapil, foto, no_urut, kec);

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_data_saksi` (IN `fname` VARCHAR(15), IN `lname` VARCHAR(15), IN `sex` CHAR(1), IN `alamat` VARCHAR(30), IN `kel` INT(4), IN `kec` INT(2), IN `kab` INT(2), IN `prov` INT(2), IN `nomor_nik` VARCHAR(16), IN `telpon` VARCHAR(13), IN `tps` INT(2), IN `passwd` VARCHAR(255), IN `foto` VARCHAR(255))  BEGIN

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

INSERT INTO saksi (nama_depan, nama_belakang, gender, alamat, id_kel, id_kec, id_kab, id_prov, nik, telp, id_tps, foto)
VALUES (fname, lname, sex, alamat, kel, kec, kab, prov, nomor_nik, telpon, tps, foto);

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_suara` (IN `j_suara` INT(7), IN `caleg` INT(2), IN `saksi` INT(3), IN `tps` INT(3), IN `tipe` ENUM('p','c'), IN `partai` INT(3), IN `tingkat` ENUM('a','b','c','d','e'))  BEGIN

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

INSERT INTO suara (suara, id_caleg, id_saksi, tanggal, updated, id_tps, id_partai, jenis_suara, tingkat_suara) VALUES (j_suara, caleg, saksi, NOW(), NOW(), tps, partai, tipe, tingkat);

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_suara_desa` (IN `j_suara` INT(7), IN `caleg` INT(3), IN `saksi` INT(3), IN `kel` INT(3), IN `tipe` ENUM('p','c'), IN `partai` INT(3), IN `tingkat` ENUM('a','b','c','d','e'))  BEGIN

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

INSERT INTO suara_desa (suara, id_caleg, id_saksi, tanggal, updated, id_kel, id_partai, jenis_suara, tingkat_suara) VALUES (j_suara, caleg, saksi, NOW(), NOW(), kel, partai, tipe, tingkat);

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_tps` (IN `n_tps` VARCHAR(5), IN `kel` INT(2), IN `kec` INT(2), IN `kab` INT(2), IN `prov` INT(2))  BEGIN

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

INSERT INTO tps (tps, id_kel, id_kec, id_kab, id_prov) VALUES (n_tps, kel, kec, kab, prov);

IF code != '00000' OR rb = 1 THEN
  ROLLBACK;
ELSE
  COMMIT;
    SET msg = 'success';
END IF;
SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_data_pil` (IN `ids` INT(2), IN `fname` VARCHAR(15), IN `lname` VARCHAR(15), IN `partai` INT(2), IN `dapil` INT(2), IN `tingkat` ENUM('a','b','c','d','e'), IN `gender` CHAR(1), IN `foto` VARCHAR(255), IN `prov` INT(2), IN `kab` INT(3), IN `no_urut` INT(3), IN `kec` INT(3))  BEGIN

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
UPDATE pil SET nama_depan = fname, nama_belakang = lname, id_partai = partai, id_dapil = dapil, tingkat = tingkat, gender = gender, foto = foto, id_prov = prov, id_kab = kab, no_urut = no_urut, id_kec = kec WHERE id = ids;

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_data_saksi` (IN `ids` INT(2), IN `fname` VARCHAR(15), IN `lname` VARCHAR(15), IN `sex` CHAR(1), IN `alamat` VARCHAR(30), IN `kel` INT(4), IN `kec` INT(2), IN `kab` INT(2), IN `prov` INT(2), IN `nomor_nik` VARCHAR(16), IN `telpon` VARCHAR(13), IN `tps` INT(2), IN `foto` VARCHAR(255))  BEGIN
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
UPDATE saksi SET nama_depan = fname, nama_belakang = lname, gender = sex, alamat = alamat, id_kel = kel, id_kec = kec, id_kab = kab, id_prov = prov,  nik = nomor_nik, telp = telpon, id_tps = tps, foto = foto WHERE id = ids;

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_suara` (IN `ids` INT(2), IN `j_suara` INT(7), IN `caleg` INT(2), IN `saksi` INT(3), IN `tps` INT(2), IN `tipe` ENUM('p','c'), IN `partai` INT(3), IN `tingkat` ENUM('a','b','c','d','e'))  BEGIN

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
UPDATE suara SET suara = j_suara, id_caleg = caleg, id_saksi = saksi, id_tps = tps, updated = NOW(), jenis_suara = tipe, id_partai = partai, tingkat_suara = tingkat WHERE id = ids;

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_suara_desa` (IN `ids` INT(2), IN `j_suara` INT(7), IN `caleg` INT(3), IN `saksi` INT(3), IN `kel` INT(3), IN `tipe` ENUM('p','c'), IN `partai` INT(3), IN `tingkat` ENUM('a','b','c','d','e'))  BEGIN

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

SET jml := (SELECT COUNT(*) FROM suara_desa WHERE id = ids AND status = 'l');

IF jml>0 THEN
UPDATE suara_desa SET suara = j_suara, id_caleg = caleg, id_saksi = saksi, id_kel = kel, updated = NOW(), jenis_suara = tipe, id_partai = partai, tingkat_suara = tingkat WHERE id = ids;

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_tps` (IN `ids` INT(2), IN `n_tps` VARCHAR(5), IN `kel` INT(2), IN `kec` INT(2), IN `kab` INT(2), IN `prov` INT(2))  BEGIN

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
UPDATE tps SET tps = n_tps, id_kel = kel, id_kec = kec, id_kab = kab, id_prov = prov WHERE id = ids;

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
  `pass` varchar(255) NOT NULL,
  `role_id` int(1) NOT NULL,
  `id_details` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `pass`, `role_id`, `id_details`) VALUES
(1, 'admin', '$2y$10$NWIsiNRuhhh3s0WQw.z.7uPm9Lfm.HApQCTgyhziN//In8k.Pcr/W', 112, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_details`
--

CREATE TABLE `admin_details` (
  `id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `nama_depan` varchar(25) NOT NULL,
  `nama_belakang` varchar(25) NOT NULL,
  `hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_details`
--

INSERT INTO `admin_details` (`id`, `username`, `nama_depan`, `nama_belakang`, `hp`) VALUES
(1, 'admin', 'Toriq', 'Ahmad', '08966826389');

-- --------------------------------------------------------

--
-- Table structure for table `dapil`
--

CREATE TABLE `dapil` (
  `id` int(11) NOT NULL,
  `dapil` int(3) NOT NULL,
  `id_prov` int(2) DEFAULT NULL,
  `id_kab` int(3) DEFAULT NULL,
  `kursi` int(2) DEFAULT NULL,
  `DPT` int(6) DEFAULT NULL,
  `jenis` enum('a','b','c','d') NOT NULL COMMENT 'a = dpd. b = dpr ri. c = dpr prov. d = dpr kab'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dapil`
--

INSERT INTO `dapil` (`id`, `dapil`, `id_prov`, `id_kab`, `kursi`, `DPT`, `jenis`) VALUES
(1, 1, 1, 1, 12, 278333, 'd'),
(2, 2, 1, 1, 8, 183939, 'd'),
(3, 3, 1, 1, 8, 176297, 'd'),
(4, 4, 1, 1, 11, 236374, 'd'),
(5, 5, 1, 1, 11, 241400, 'd'),
(6, 1, 1, NULL, 112, NULL, 'a'),
(7, 2, 1, NULL, 7, NULL, 'b'),
(8, 3, 1, NULL, 10, NULL, 'c');

-- --------------------------------------------------------

--
-- Table structure for table `kab`
--

CREATE TABLE `kab` (
  `id` int(2) NOT NULL,
  `kab` varchar(25) DEFAULT NULL,
  `id_prov` int(2) DEFAULT NULL,
  `dapil_dprri` int(2) DEFAULT NULL,
  `dapil_dprprov` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kab`
--

INSERT INTO `kab` (`id`, `kab`, `id_prov`, `dapil_dprri`, `dapil_dprprov`) VALUES
(1, 'Demak', 1, 7, 8),
(2, 'Jepara', 1, 7, 8),
(3, 'Kudus', 1, 7, 8);

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
(248, 'Tugu', 59563, 14, 1, 1),
(249, 'Babat', 59583, 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `partai`
--

CREATE TABLE `partai` (
  `id` int(2) NOT NULL,
  `partai` varchar(15) DEFAULT NULL,
  `no_urut` int(3) NOT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'default_avatar.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partai`
--

INSERT INTO `partai` (`id`, `partai`, `no_urut`, `foto`) VALUES
(1, 'PKB', 1, 'default_avatar.jpg'),
(2, 'GERINDRA', 2, 'default_avatar.jpg'),
(3, 'PDIP', 3, 'default_avatar.jpg'),
(4, 'GOLKAR', 4, 'default_avatar.jpg'),
(5, 'NASDEM', 5, 'default_avatar.jpg'),
(6, 'BERKARYA', 7, 'default_avatar.jpg'),
(7, 'PKS', 8, 'default_avatar.jpg'),
(8, 'PERINDO', 9, 'default_avatar.jpg'),
(9, 'PPP', 10, 'default_avatar.jpg'),
(10, 'PSI', 11, 'default_avatar.jpg'),
(11, 'PAN', 12, 'default_avatar.jpg'),
(12, 'HANURA', 13, 'default_avatar.jpg'),
(13, 'DEMOKRAT', 14, 'default_avatar.jpg'),
(14, 'PBB', 19, 'default_avatar.jpg'),
(15, 'PKPI', 20, 'default_avatar.jpg'),
(16, 'GARUDA', 6, 'default_avatar.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pil`
--

CREATE TABLE `pil` (
  `id` int(2) NOT NULL,
  `nama_depan` varchar(30) DEFAULT NULL,
  `nama_belakang` varchar(30) DEFAULT NULL,
  `gender` char(1) NOT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'default_avatar.jpg',
  `tingkat` enum('a','b','c','d','e') NOT NULL COMMENT 'a = presiden. b = dpd. c = dppri. d = dpr prov. e = dpr kab',
  `id_prov` int(2) DEFAULT NULL,
  `id_kab` int(3) DEFAULT NULL,
  `id_kec` int(3) DEFAULT NULL,
  `id_partai` int(2) DEFAULT NULL,
  `id_dapil` int(2) DEFAULT NULL,
  `no_urut` int(3) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'l' COMMENT '''l'' untuk data masih digunakan, ''d'' untuk data sudah dihapus'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pil`
--

INSERT INTO `pil` (`id`, `nama_depan`, `nama_belakang`, `gender`, `foto`, `tingkat`, `id_prov`, `id_kab`, `id_kec`, `id_partai`, `id_dapil`, `no_urut`, `status`) VALUES
(1, 'Drs. FATHAN', 'NULL', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 1, 7, 1, 'l'),
(2, 'HINDUN', 'ANISAH, S.Ag', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 1, 7, 2, 'l'),
(3, 'MUHAMMAD', 'MUNJAZIM', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 1, 7, 3, 'l'),
(4, 'MOCH', 'BASUNI, ST', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 1, 7, 4, 'l'),
(5, 'H. HASAN', 'FATONI, SH', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 1, 7, 5, 'l'),
(6, 'SRI', 'NURYATI, S.AQ', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 1, 7, 6, 'l'),
(7, 'MUâ€™ASYAROH, SH.I', 'NULL', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 1, 7, 7, 'l'),
(8, 'ABDUL', 'WACHID', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 2, 7, 1, 'l'),
(9, 'AHMAD', 'YANUAR RIKZA', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 2, 7, 2, 'l'),
(10, 'IQLIMA', 'ROIHANI', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 2, 7, 3, 'l'),
(11, 'SYARONI, SEI', 'NULL', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 2, 7, 4, 'l'),
(12, 'MUAYANAH, S.Ag', 'NULL', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 2, 7, 5, 'l'),
(13, 'SARI', 'RIFYANJANI, S.Kom', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 2, 7, 6, 'l'),
(14, 'H. GHUFRONI', 'NULL', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 2, 7, 7, 'l'),
(15, 'DARYATMO', 'MARDIYAN', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 3, 7, 1, 'l'),
(16, 'GILANG', 'DHIELAFARAR', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 3, 7, 2, 'l'),
(17, 'Ir. HERU ', 'MULYATI', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 3, 7, 3, 'l'),
(18, 'DR. H. MUSTHOFA, SE', 'NULL', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 3, 7, 4, 'l'),
(19, 'TAMARA', 'TAMBUNAN', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 3, 7, 5, 'l'),
(20, 'R. YANNE ', 'YOLANDARI ', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 3, 7, 6, 'l'),
(21, 'INDRA ', 'AULIA NUGRAHA', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 3, 7, 7, 'l'),
(22, 'DANY', 'SOEDARSONO', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 4, 7, 1, 'l'),
(23, 'H. BOWO ', 'SIDIK PANG', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 4, 7, 2, 'l'),
(24, 'NUR ', 'YAHMAN, SH', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 4, 7, 3, 'l'),
(25, 'BUDIANTO ', 'TARIGAN', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 4, 7, 4, 'l'),
(26, 'RATIH ', 'DEWANTI', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 4, 7, 5, 'l'),
(27, 'HERLINAWATI', 'NULL', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 4, 7, 6, 'l'),
(28, 'NUSRON ', 'WAHID', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 4, 7, 7, 'l'),
(29, 'LESTARI', 'MOERDIJAT', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 5, 7, 1, 'l'),
(30, 'Ir. ALI ', 'MAHIR, MM', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 5, 7, 2, 'l'),
(31, 'ENDANG ', 'SUSILOWATI', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 5, 7, 3, 'l'),
(32, 'H.SOLIKHIN, ST, MT', 'NULL', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 5, 7, 4, 'l'),
(33, 'H. IDHAM ', 'KHOLID, SH, MH', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 5, 7, 5, 'l'),
(34, 'SRI ', 'HARTINI', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 5, 7, 6, 'l'),
(35, 'GANTYO ', 'KOESPRADONO', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 5, 7, 7, 'l'),
(36, 'NELY ', 'RAHMAWATI ', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 16, 7, 1, 'l'),
(37, 'TEGUH ', 'SETIAWAN', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 16, 7, 2, 'l'),
(38, 'ILHAM ', 'SETIAWAN', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 16, 7, 3, 'l'),
(39, 'PANDUWINATA ', 'FN', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 6, 7, 1, 'l'),
(40, 'ROCHMIYATI', 'NULL', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 6, 7, 2, 'l'),
(41, 'RENI ', 'HARDITA ', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 6, 7, 3, 'l'),
(42, 'KRT. ', 'CHRISNA ', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 6, 7, 4, 'l'),
(43, 'Ir. ERDI ', 'NURKITO, MT', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 6, 7, 5, 'l'),
(44, 'H. MUHSININ ', 'FAUZI', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 7, 7, 1, 'l'),
(45, 'H. AHMADI, A.Md', 'NULL', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 7, 7, 2, 'l'),
(46, 'AMANATUL ', 'HUSNA, S.Pi', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 7, 7, 3, 'l'),
(47, 'ADY ', 'SUPRATIKTO', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 7, 7, 4, 'l'),
(48, 'SURTINI', 'NULL', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 7, 7, 5, 'l'),
(49, 'SISWADI ', 'SELODIPOERO', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 8, 7, 1, 'l'),
(50, 'DWI ', 'PUTRA BUDIYANTO, SH', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 8, 7, 2, 'l'),
(51, 'RITA ', 'ZAENAF, SH, S.Pd, M.Pd', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 8, 7, 3, 'l'),
(52, 'SUTRISNO, ', 'S.IP, M.Si', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 8, 7, 4, 'l'),
(53, 'LINA ', 'ROHMA', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 8, 7, 5, 'l'),
(54, 'NINIK ', 'SETIYANI', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 8, 7, 6, 'l'),
(55, 'RICKY ', 'HARISMA HASANUD', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 8, 7, 7, 'l'),
(56, 'ROJIH', 'NULL', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 9, 7, 1, 'l'),
(57, 'Dr. FAHRUDDIN', 'NULL', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 9, 7, 2, 'l'),
(58, 'ALFI', 'BAROKAH', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 9, 7, 3, 'l'),
(59, 'ISTAJIB', 'AS', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 9, 7, 4, 'l'),
(60, 'FARIDAH, ', 'SHI', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 9, 7, 5, 'l'),
(61, 'SLAMET ', 'BADRUDDIN', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 9, 7, 6, 'l'),
(62, 'FARAH ', 'MAHARANI', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 9, 7, 7, 'l'),
(63, 'HARIJANTO ', 'ARBI', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 10, 7, 1, 'l'),
(64, 'FUAD ', 'SULAIMY, ST, MM', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 10, 7, 2, 'l'),
(65, 'INGE ', 'YASMINE', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 10, 7, 3, 'l'),
(66, 'RIA ', 'DWI ASTUTI', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 10, 7, 4, 'l'),
(67, 'NATAYA ', 'APRIALISA', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 10, 7, 5, 'l'),
(68, 'APRILIA', 'NULL', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 10, 7, 6, 'l'),
(69, 'JONATHAN', 'NULL', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 10, 7, 7, 'l'),
(70, 'WIDA ', 'FADLIKA, SE, M.Si', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 11, 7, 1, 'l'),
(71, 'DEDDY ', 'RIZALDI', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 11, 7, 2, 'l'),
(72, 'Hj. HARDINI ', 'PUSPASAARI', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 11, 7, 3, 'l'),
(73, 'M. KISRA ', 'HADIAN', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 11, 7, 4, 'l'),
(74, 'Drs. ASEP ', 'SUTISNA, MM', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 11, 7, 5, 'l'),
(75, 'Hj. YENI ', 'ANJANI JUWITA', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 11, 7, 6, 'l'),
(76, 'LUSIATI, ', 'SE, M.Si', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 11, 7, 7, 'l'),
(77, 'DINA ', 'LORENZA AUDRIA', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 13, 7, 1, 'l'),
(78, 'H. GUNARI ', 'A LATIEF, M.Si', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 13, 7, 2, 'l'),
(79, 'Drs. HENDRO ', 'MARTOJO', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 13, 7, 3, 'l'),
(80, 'NURUL ', 'HUDA, SH, MH', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 13, 7, 4, 'l'),
(81, 'REKHA ', 'MAHENDRASWARI', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 13, 7, 5, 'l'),
(82, 'KARREN ', 'ZUSRINA', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 13, 7, 6, 'l'),
(83, 'AHDI ', 'MUQSITH', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 13, 7, 7, 'l'),
(84, 'DR. H. MUHANTO', 'NULL', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 14, 7, 1, 'l'),
(85, 'AMIN', 'NULL', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 14, 7, 2, 'l'),
(86, 'HANA ', 'PUJI ASTUTI', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 14, 7, 3, 'l'),
(87, 'AHMAD ', 'FAIDONI HARIRI', 'l', 'default_avatar.jpg', 'c', 1, 1, NULL, 14, 7, 4, 'l'),
(88, 'IIS', 'ROSMERIA', 'p', 'default_avatar.jpg', 'c', 1, 1, NULL, 14, 7, 5, 'l'),
(128, 'Hj. Nur', 'Saadah, S.Pd.I, MH', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 1, 8, 1, 'l'),
(129, 'H. Ahmad ', 'Zaki, S.Hi', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 1, 8, 2, 'l'),
(130, 'HM. Nur ', 'Khabsyin, S.Pd', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 1, 8, 3, 'l'),
(131, 'Mohamad ', 'Ali Chabib', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 1, 8, 4, 'l'),
(132, 'Sri', 'Solichatul Umami', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 1, 8, 5, 'l'),
(133, 'Khamdun', 'Khiyarudin Misbah', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 1, 8, 6, 'l'),
(134, 'Nuril', 'Khasanatun Nisak, S.Pd.I', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 1, 8, 7, 'l'),
(135, 'Alex ', 'Yusron Al Mufti', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 1, 8, 8, 'l'),
(136, 'Mutiara', 'Choirunnisa, SE', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 1, 8, 9, 'l'),
(137, 'A. Bahrul', 'Amiq', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 1, 8, 10, 'l'),
(138, 'Hj. Sri ', 'Hartini, ST', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 2, 8, 1, 'l'),
(139, 'H. Chumaimudin', '', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 2, 8, 2, 'l'),
(140, 'M. Iqbal ', 'Faishol', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 2, 8, 3, 'l'),
(141, 'Savista ', 'Mada Humans', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 2, 8, 4, 'l'),
(142, 'Zainal ', 'Abidin', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 2, 8, 5, 'l'),
(143, 'Anwar ', 'Said', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 2, 8, 6, 'l'),
(144, 'Slamet ', 'Sukirno', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 2, 8, 7, 'l'),
(145, 'Wahyu ', 'Setiawan Bagus P', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 2, 8, 8, 'l'),
(146, 'Siti Nur ', 'Malikhah, S.H.I', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 2, 8, 9, 'l'),
(147, 'Asri ', 'Budi Utomo', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 2, 8, 10, 'l'),
(148, 'Denny ', 'Nurcahyanto, SE', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 3, 8, 1, 'l'),
(149, 'Andang ', 'Wahyu Triyanto, SE', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 3, 8, 2, 'l'),
(150, 'Julia ', 'Setyowati, S.Sos. MM', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 3, 8, 3, 'l'),
(151, 'Dwi ', 'Setiawan', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 3, 8, 4, 'l'),
(152, 'Adrian ', 'Ranakusuma', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 3, 8, 5, 'l'),
(153, 'Ita ', 'Nurmasari', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 3, 8, 6, 'l'),
(154, 'Ibra ', 'Hartawan', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 3, 8, 7, 'l'),
(155, 'Eko ', 'Masidin', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 3, 8, 8, 'l'),
(156, 'Emerentiana ', 'Yusi Utari', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 3, 8, 9, 'l'),
(157, 'Wahyu ', 'Prasetyo Hadi, SE', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 3, 8, 10, 'l'),
(158, 'Rifâ€™an', '', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 4, 8, 1, 'l'),
(159, 'Tardjo ', 'Ragil, SE, M.Si', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 4, 8, 2, 'l'),
(160, 'Hj. Farida ', 'Rahmah, S.A', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 4, 8, 3, 'l'),
(161, 'Suyadi, ', 'S.Pd.I', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 4, 8, 4, 'l'),
(162, 'Ray Sri ', 'Hendrarrini, BA', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 4, 8, 5, 'l'),
(163, 'Dr. Slamet, ', 'S.Pd, M.Pd', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 4, 8, 6, 'l'),
(164, 'Tri Esny ', 'Susilowati, S.Pd', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 4, 8, 7, 'l'),
(165, 'Muhammad ', 'Muthoharul', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 4, 8, 8, 'l'),
(166, 'Retno Iyut ', 'Ade Pamungkas', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 4, 8, 9, 'l'),
(167, 'H. Mawahib', '', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 4, 8, 10, 'l'),
(168, 'H. Akhwan, SH', '', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 5, 8, 1, 'l'),
(169, 'dr. Sugeng ', 'Ibrahim', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 5, 8, 2, 'l'),
(170, 'Dra. Hj. Tri ', 'Wahyu Hapsari, MM', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 5, 8, 3, 'l'),
(171, 'Drs. H. ', 'Sukarno', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 5, 8, 4, 'l'),
(172, 'Mochamad ', 'Senojati Haryo', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 5, 8, 5, 'l'),
(173, 'Intan ', 'Heryati Indah, SE', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 5, 8, 6, 'l'),
(174, 'Muchamad ', 'Sholechan', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 5, 8, 7, 'l'),
(175, 'Aida Farichatul ', 'Laila, S.Sos', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 5, 8, 8, 'l'),
(176, 'KH. A Soelaeman ', 'Efendi, SH,', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 5, 8, 9, 'l'),
(177, 'Fedelis Titis ', 'Eka Taurina', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 5, 8, 10, 'l'),
(178, 'Machasin ', 'Rochman, SH', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 6, 8, 1, 'l'),
(179, 'Mujiah, ', 'SE, MPd', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 6, 8, 2, 'l'),
(180, 'Sri ', 'Hartini', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 6, 8, 3, 'l'),
(181, 'Agus ', 'Sanyoto', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 6, 8, 4, 'l'),
(182, 'Jumanto, ', 'S.Pd', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 6, 8, 5, 'l'),
(183, 'Amir ', 'Darmanto, SH', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 7, 8, 1, 'l'),
(184, 'H. Setia ', 'Budi Wibowo, S.Ag', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 7, 8, 2, 'l'),
(185, 'Amalia Fadhila ', 'Habibah Fitri', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 7, 8, 3, 'l'),
(186, 'Hartoyo, SE', '', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 7, 8, 4, 'l'),
(187, 'Tutut ', 'Wulandari, SS', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 7, 8, 5, 'l'),
(188, 'Saifudin', '', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 7, 8, 6, 'l'),
(189, 'Ahmad ', 'Mudhofar, SE', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 7, 8, 7, 'l'),
(190, 'Hj. Dwi ', 'Ningrum Astuti', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 7, 8, 8, 'l'),
(191, 'Drs. Iskandar, ', 'SH, MH, Cand', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 8, 8, 1, 'l'),
(192, 'Dyah ', 'Karmindagri, SH', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 8, 8, 2, 'l'),
(193, 'H. Abdul ', 'Fatiq, M.Kom', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 8, 8, 3, 'l'),
(194, 'Ririk ', 'Novita Sari', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 8, 8, 4, 'l'),
(195, 'Agus ', 'Widodo, ST', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 8, 8, 5, 'l'),
(196, 'Nurul ', 'Furqon, SE', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 9, 8, 1, 'l'),
(197, 'Djoko ', 'Nurhadi, SH', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 9, 8, 2, 'l'),
(198, 'Irliza ', 'Rahma Diana, SH', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 9, 8, 3, 'l'),
(199, 'Yogi ', 'Aditya', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 9, 8, 4, 'l'),
(200, 'Rifai, ', 'S.Pd.I', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 9, 8, 5, 'l'),
(201, 'Istiqomah', '', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 9, 8, 6, 'l'),
(202, 'Alfaya ', 'Sayyidah', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 9, 8, 7, 'l'),
(203, 'Muhammad ', 'Chowasul Arifin', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 9, 8, 8, 'l'),
(204, 'Naili ', 'Hidayati', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 9, 8, 9, 'l'),
(205, 'Ali ', 'Maskur', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 9, 8, 10, 'l'),
(206, 'Bagus ', 'Ardeni', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 10, 8, 1, 'l'),
(207, 'Yunika ', 'Erma Puspita', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 10, 8, 2, 'l'),
(208, 'Drs. Jayus, MM', '', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 11, 8, 1, 'l'),
(209, 'Hasan ', 'Sanubari, SE', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 11, 8, 2, 'l'),
(210, 'Rosdiana Nur ', 'Pasha Lubis', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 11, 8, 3, 'l'),
(211, 'Noor ', 'Djamaâ€™ah', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 11, 8, 4, 'l'),
(212, 'Muhammad ', 'Shodiqin, SH', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 11, 8, 5, 'l'),
(213, 'Sulistyawati', '', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 11, 8, 6, 'l'),
(214, 'Ratna ', 'Setiasih', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 11, 8, 7, 'l'),
(215, 'Endang ', 'Tri Widyastuti', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 11, 8, 8, 'l'),
(216, 'Khotiah', '', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 11, 8, 9, 'l'),
(217, 'Musarif', '', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 11, 8, 10, 'l'),
(218, 'Merry Herlina ', 'Saragih, SE', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 12, 8, 1, 'l'),
(219, 'Aklis ', 'Junaidi', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 12, 8, 2, 'l'),
(220, 'Dedy Heru ', 'Pramono, SH', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 12, 8, 3, 'l'),
(221, 'Nur ', 'Faisah', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 12, 8, 4, 'l'),
(222, 'Ramadi, SH', '', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 12, 8, 5, 'l'),
(223, 'Wahono', 'Sudhariyo', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 12, 8, 6, 'l'),
(224, 'Nova ', 'Widjoyo', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 13, 8, 1, 'l'),
(225, 'H. Helmy ', 'Turmudhi, SE', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 13, 8, 2, 'l'),
(226, 'Istianah', '', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 13, 8, 3, 'l'),
(227, 'Nurul ', 'Fatah, SH, MH', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 13, 8, 4, 'l'),
(228, 'H. Aris ', 'Isnandar, ST', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 13, 8, 5, 'l'),
(229, 'Diana ', 'Irawati', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 13, 8, 6, 'l'),
(230, 'H. Heni ', 'Purwadi, SH', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 13, 8, 7, 'l'),
(231, 'Hanifa ', 'Noviabida Wijayanti', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 13, 8, 8, 'l'),
(232, 'Dwi ', 'Nuryono Winahyu', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 13, 8, 9, 'l'),
(233, 'Zaenal ', 'Mubaroq, SH', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 13, 8, 10, 'l'),
(234, 'Djoko ', 'Prayitno, S.Kom', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 14, 8, 1, 'l'),
(235, 'Lisniâ€™matu ', 'Zahroh, S.Pd.I', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 14, 8, 2, 'l'),
(236, 'Siti ', 'Firdausiyah', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 14, 8, 3, 'l'),
(237, 'Nathalia ', 'Tau Ceti', 'p', 'default_avatar.jpg', 'd', 1, 1, NULL, 14, 8, 4, 'l'),
(238, 'Sarojo', '', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 14, 8, 5, 'l'),
(239, 'H. Hanafi ', 'Saleh', 'l', 'default_avatar.jpg', 'd', 1, 1, NULL, 14, 8, 6, 'l');

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
  `prov` varchar(15) DEFAULT NULL,
  `id_dapil` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prov`
--

INSERT INTO `prov` (`id`, `prov`, `id_dapil`) VALUES
(1, 'Jawa Tengah', 6);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(1) NOT NULL,
  `role` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(112, 'admin'),
(123, 'saksi');

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
  `nik` varchar(25) DEFAULT NULL,
  `foto` varchar(30) DEFAULT 'default_avatar.jpg',
  `telp` varchar(13) DEFAULT NULL,
  `id_tps` int(3) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'l' COMMENT '''l'' untuk data masih digunakan, ''d'' untuk data sudah dihapus'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saksi`
--

INSERT INTO `saksi` (`id`, `nama_depan`, `nama_belakang`, `gender`, `alamat`, `id_kel`, `id_kec`, `id_kab`, `id_prov`, `nik`, `foto`, `telp`, `id_tps`, `status`) VALUES
(1, 'Yasril', 'Ahmad', 'l', 'Jl. jalan jalan jalan', 1, 1, 1, 1, '3322423974879066', 'default_avatar.jpg', '08767364787', 58, 'l');

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
  `jenis_suara` enum('p','c') NOT NULL COMMENT 'p = suara partai, c = suara caleg',
  `tingkat_suara` enum('a','b','c','d','e') NOT NULL COMMENT 'a=pres. b = dpd. c = dprri. d = dpr prov. e = dpr kab'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suara_desa`
--

CREATE TABLE `suara_desa` (
  `id` int(3) NOT NULL,
  `suara` int(7) DEFAULT NULL,
  `id_caleg` int(3) DEFAULT NULL,
  `id_saksi` int(3) NOT NULL DEFAULT '0',
  `tanggal` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `id_kel` int(3) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'l' COMMENT '''l'' untuk data masih digunakan, ''d'' untuk data sudah dihapus',
  `id_partai` int(2) DEFAULT NULL,
  `jenis_suara` enum('p','c') NOT NULL COMMENT 'p = suara partai, c = suara caleg',
  `tingkat_suara` enum('a','b','c','d','e') NOT NULL COMMENT 'a=pres. b = dpd. c = dprri. d = dpr prov. e = dpr kab'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tps`
--

CREATE TABLE `tps` (
  `id` int(3) NOT NULL,
  `tps` varchar(11) DEFAULT NULL,
  `id_kel` int(3) DEFAULT NULL,
  `id_kec` int(2) DEFAULT NULL,
  `id_kab` int(2) DEFAULT NULL,
  `id_prov` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tps`
--

INSERT INTO `tps` (`id`, `tps`, `id_kel`, `id_kec`, `id_kab`, `id_prov`) VALUES
(1, 'TPS 1', 5, 1, 1, 1),
(2, 'TPS 2', 5, 1, 1, 1),
(3, 'TPS 3', 5, 1, 1, 1),
(4, 'TPS 4', 5, 1, 1, 1),
(5, 'TPS 5', 5, 1, 1, 1),
(6, 'TPS 6', 5, 1, 1, 1),
(7, 'TPS 7', 5, 1, 1, 1),
(8, 'TPS 8', 5, 1, 1, 1),
(9, 'TPS 9', 5, 1, 1, 1),
(10, 'TPS 10', 5, 1, 1, 1),
(11, 'TPS 11', 5, 1, 1, 1),
(12, 'TPS 12', 5, 1, 1, 1),
(13, 'TPS 13', 5, 1, 1, 1),
(14, 'TPS 14', 5, 1, 1, 1),
(15, 'TPS 15', 5, 1, 1, 1),
(16, 'TPS 16', 5, 1, 1, 1),
(17, 'TPS 17', 5, 1, 1, 1),
(18, 'TPS 18', 5, 1, 1, 1),
(19, 'TPS 19', 5, 1, 1, 1),
(20, 'TPS 20', 5, 1, 1, 1),
(21, 'TPS 21', 5, 1, 1, 1),
(22, 'TPS 22', 5, 1, 1, 1),
(23, 'TPS 23', 5, 1, 1, 1),
(24, 'TPS 24', 5, 1, 1, 1),
(25, 'TPS 25', 5, 1, 1, 1),
(26, 'TPS 26', 5, 1, 1, 1),
(27, 'TPS 1', 4, 1, 1, 1),
(28, 'TPS 2', 4, 1, 1, 1),
(29, 'TPS 3', 4, 1, 1, 1),
(30, 'TPS 4', 4, 1, 1, 1),
(31, 'TPS 5', 4, 1, 1, 1),
(32, 'TPS 6', 4, 1, 1, 1),
(33, 'TPS 7', 4, 1, 1, 1),
(34, 'TPS 8', 4, 1, 1, 1),
(35, 'TPS 9', 4, 1, 1, 1),
(36, 'TPS 10', 4, 1, 1, 1),
(37, 'TPS 1', 3, 1, 1, 1),
(38, 'TPS 2', 3, 1, 1, 1),
(39, 'TPS 3', 3, 1, 1, 1),
(40, 'TPS 4', 3, 1, 1, 1),
(41, 'TPS 5', 3, 1, 1, 1),
(42, 'TPS 1', 2, 1, 1, 1),
(43, 'TPS 2', 2, 1, 1, 1),
(44, 'TPS 3', 2, 1, 1, 1),
(45, 'TPS 4', 2, 1, 1, 1),
(46, 'TPS 5', 2, 1, 1, 1),
(47, 'TPS 6', 2, 1, 1, 1),
(48, 'TPS 7', 2, 1, 1, 1),
(49, 'TPS 8', 2, 1, 1, 1),
(50, 'TPS 9', 2, 1, 1, 1),
(51, 'TPS 10', 2, 1, 1, 1),
(52, 'TPS 11', 2, 1, 1, 1),
(53, 'TPS 12', 2, 1, 1, 1),
(54, 'TPS 13', 2, 1, 1, 1),
(55, 'TPS 14', 2, 1, 1, 1),
(56, 'TPS 15', 2, 1, 1, 1),
(57, 'TPS 16', 2, 1, 1, 1),
(58, 'TPS 1', 1, 1, 1, 1),
(59, 'TPS 2', 1, 1, 1, 1),
(60, 'TPS 3', 1, 1, 1, 1),
(61, 'TPS 4', 1, 1, 1, 1),
(62, 'TPS 5', 1, 1, 1, 1),
(63, 'TPS 6', 1, 1, 1, 1),
(64, 'TPS 7', 1, 1, 1, 1),
(65, 'TPS 8', 1, 1, 1, 1),
(66, 'TPS 9', 1, 1, 1, 1),
(67, 'TPS 10', 1, 1, 1, 1),
(68, 'TPS 11', 1, 1, 1, 1),
(69, 'TPS 12', 1, 1, 1, 1),
(70, 'TPS 13', 1, 1, 1, 1),
(71, 'TPS 14', 1, 1, 1, 1),
(72, 'TPS 15', 1, 1, 1, 1),
(73, 'TPS 16', 1, 1, 1, 1),
(74, 'TPS 17', 1, 1, 1, 1),
(75, 'TPS 18', 1, 1, 1, 1),
(76, 'TPS 19', 1, 1, 1, 1),
(77, 'TPS 20', 1, 1, 1, 1),
(78, 'TPS 21', 1, 1, 1, 1),
(79, 'TPS 22', 1, 1, 1, 1),
(80, 'TPS 23', 1, 1, 1, 1),
(81, 'TPS 24', 1, 1, 1, 1),
(82, 'TPS 25', 1, 1, 1, 1),
(83, 'TPS 26', 1, 1, 1, 1),
(84, 'TPS 27', 1, 1, 1, 1),
(85, 'TPS 28', 1, 1, 1, 1),
(86, 'TPS 29', 1, 1, 1, 1),
(87, 'TPS 30', 1, 1, 1, 1),
(88, 'TPS 31', 1, 1, 1, 1),
(89, 'TPS 32', 1, 1, 1, 1),
(90, 'TPS 33', 1, 1, 1, 1),
(91, 'TPS 34', 1, 1, 1, 1),
(92, 'TPS 35', 1, 1, 1, 1),
(93, 'TPS 36', 1, 1, 1, 1),
(94, 'TPS 37', 1, 1, 1, 1),
(95, 'TPS 38', 1, 1, 1, 1),
(96, 'TPS 39', 1, 1, 1, 1),
(97, 'TPS 40', 1, 1, 1, 1),
(98, 'TPS 41', 1, 1, 1, 1),
(99, 'TPS 42', 1, 1, 1, 1),
(100, 'TPS 43', 1, 1, 1, 1),
(101, 'TPS 44', 1, 1, 1, 1),
(102, 'TPS 45', 1, 1, 1, 1),
(103, 'TPS 46', 1, 1, 1, 1),
(104, 'TPS 47', 1, 1, 1, 1),
(105, 'TPS 48', 1, 1, 1, 1),
(106, 'TPS 49', 1, 1, 1, 1),
(107, 'TPS 50', 1, 1, 1, 1),
(108, 'TPS 51', 1, 1, 1, 1),
(109, 'TPS 52', 1, 1, 1, 1),
(110, 'TPS 53', 1, 1, 1, 1),
(111, 'TPS 54', 1, 1, 1, 1),
(112, 'TPS 55', 1, 1, 1, 1),
(113, 'TPS 56', 1, 1, 1, 1),
(114, 'TPS 1', 11, 1, 1, 1),
(115, 'TPS 2', 11, 1, 1, 1),
(116, 'TPS 3', 11, 1, 1, 1),
(117, 'TPS 4', 11, 1, 1, 1),
(118, 'TPS 5', 11, 1, 1, 1),
(119, 'TPS 6', 11, 1, 1, 1),
(120, 'TPS 7', 11, 1, 1, 1),
(121, 'TPS 8', 11, 1, 1, 1),
(122, 'TPS 9', 11, 1, 1, 1),
(123, 'TPS 10', 11, 1, 1, 1),
(124, 'TPS 1', 8, 1, 1, 1),
(125, 'TPS 2', 8, 1, 1, 1),
(126, 'TPS 3', 8, 1, 1, 1),
(127, 'TPS 4', 8, 1, 1, 1),
(128, 'TPS 5', 8, 1, 1, 1),
(129, 'TPS 6', 8, 1, 1, 1),
(130, 'TPS 7', 8, 1, 1, 1),
(131, 'TPS 8', 8, 1, 1, 1),
(132, 'TPS 9', 8, 1, 1, 1),
(133, 'TPS 10', 8, 1, 1, 1),
(134, 'TPS 11', 8, 1, 1, 1),
(135, 'TPS 12', 8, 1, 1, 1),
(136, 'TPS 13', 8, 1, 1, 1),
(137, 'TPS 1', 7, 1, 1, 1),
(138, 'TPS 2', 7, 1, 1, 1),
(139, 'TPS 3', 7, 1, 1, 1),
(140, 'TPS 4', 7, 1, 1, 1),
(141, 'TPS 5', 7, 1, 1, 1),
(142, 'TPS 6', 7, 1, 1, 1),
(143, 'TPS 7', 7, 1, 1, 1),
(144, 'TPS 8', 7, 1, 1, 1),
(145, 'TPS 9', 7, 1, 1, 1),
(146, 'TPS 10', 7, 1, 1, 1),
(147, 'TPS 11', 7, 1, 1, 1),
(148, 'TPS 12', 7, 1, 1, 1),
(149, 'TPS 13', 7, 1, 1, 1),
(150, 'TPS 14', 7, 1, 1, 1),
(151, 'TPS 15', 7, 1, 1, 1),
(152, 'TPS 16', 7, 1, 1, 1),
(153, 'TPS 17', 7, 1, 1, 1),
(154, 'TPS 18', 7, 1, 1, 1),
(155, 'TPS 19', 7, 1, 1, 1),
(156, 'TPS 20', 7, 1, 1, 1),
(157, 'TPS 21', 7, 1, 1, 1),
(158, 'TPS 22', 7, 1, 1, 1),
(159, 'TPS 1', 14, 1, 1, 1),
(160, 'TPS 2', 14, 1, 1, 1),
(161, 'TPS 3', 14, 1, 1, 1),
(162, 'TPS 4', 14, 1, 1, 1),
(163, 'TPS 5', 14, 1, 1, 1),
(164, 'TPS 6', 14, 1, 1, 1),
(165, 'TPS 7', 14, 1, 1, 1),
(166, 'TPS 8', 14, 1, 1, 1),
(167, 'TPS 9', 14, 1, 1, 1),
(168, 'TPS 10', 14, 1, 1, 1),
(169, 'TPS 11', 14, 1, 1, 1),
(170, 'TPS 12', 14, 1, 1, 1),
(171, 'TPS 13', 14, 1, 1, 1),
(172, 'TPS 14', 14, 1, 1, 1),
(173, 'TPS 15', 14, 1, 1, 1),
(174, 'TPS 16', 14, 1, 1, 1),
(175, 'TPS 1', 17, 1, 1, 1),
(176, 'TPS 2', 17, 1, 1, 1),
(177, 'TPS 3', 17, 1, 1, 1),
(178, 'TPS 4', 17, 1, 1, 1),
(179, 'TPS 5', 17, 1, 1, 1),
(180, 'TPS 6', 17, 1, 1, 1),
(181, 'TPS 7', 17, 1, 1, 1),
(182, 'TPS 8', 17, 1, 1, 1),
(183, 'TPS 9', 17, 1, 1, 1),
(184, 'TPS 10', 17, 1, 1, 1),
(185, 'TPS 11', 17, 1, 1, 1),
(186, 'TPS 1', 15, 1, 1, 1),
(187, 'TPS 2', 15, 1, 1, 1),
(188, 'TPS 3', 15, 1, 1, 1),
(189, 'TPS 4', 15, 1, 1, 1),
(190, 'TPS 5', 15, 1, 1, 1),
(191, 'TPS 6', 15, 1, 1, 1),
(192, 'TPS 7', 15, 1, 1, 1),
(193, 'TPS 8', 15, 1, 1, 1),
(194, 'TPS 9', 15, 1, 1, 1),
(195, 'TPS 10', 15, 1, 1, 1),
(196, 'TPS 11', 15, 1, 1, 1),
(197, 'TPS 12', 15, 1, 1, 1),
(198, 'TPS 13', 15, 1, 1, 1),
(199, 'TPS 14', 15, 1, 1, 1),
(200, 'TPS 15', 15, 1, 1, 1),
(201, 'TPS 16', 15, 1, 1, 1),
(202, 'TPS 17', 15, 1, 1, 1),
(203, 'TPS 1', 19, 1, 1, 1),
(204, 'TPS 2', 19, 1, 1, 1),
(205, 'TPS 3', 19, 1, 1, 1),
(206, 'TPS 4', 19, 1, 1, 1),
(207, 'TPS 5', 19, 1, 1, 1),
(208, 'TPS 6', 19, 1, 1, 1),
(209, 'TPS 7', 19, 1, 1, 1),
(210, 'TPS 8', 19, 1, 1, 1),
(211, 'TPS 9', 19, 1, 1, 1),
(212, 'TPS 10', 19, 1, 1, 1),
(213, 'TPS 11', 19, 1, 1, 1),
(214, 'TPS 12', 19, 1, 1, 1),
(215, 'TPS 13', 19, 1, 1, 1),
(216, 'TPS 14', 19, 1, 1, 1),
(217, 'TPS 15', 19, 1, 1, 1),
(218, 'TPS 16', 19, 1, 1, 1),
(219, 'TPS 17', 19, 1, 1, 1),
(220, 'TPS 18', 19, 1, 1, 1),
(221, 'TPS 19', 19, 1, 1, 1),
(222, 'TPS 20', 19, 1, 1, 1),
(223, 'TPS 21', 19, 1, 1, 1),
(224, 'TPS 22', 19, 1, 1, 1),
(225, 'TPS 23', 19, 1, 1, 1),
(226, 'TPS 24', 19, 1, 1, 1),
(227, 'TPS 25', 19, 1, 1, 1),
(228, 'TPS 26', 19, 1, 1, 1),
(229, 'TPS 27', 19, 1, 1, 1),
(230, 'TPS 28', 19, 1, 1, 1),
(231, 'TPS 29', 19, 1, 1, 1),
(232, 'TPS 30', 19, 1, 1, 1),
(233, 'TPS 31', 19, 1, 1, 1),
(234, 'TPS 32', 19, 1, 1, 1),
(235, 'TPS 1', 16, 1, 1, 1),
(236, 'TPS 2', 16, 1, 1, 1),
(237, 'TPS 3', 16, 1, 1, 1),
(238, 'TPS 4', 16, 1, 1, 1),
(239, 'TPS 5', 16, 1, 1, 1),
(240, 'TPS 6', 16, 1, 1, 1),
(241, 'TPS 7', 16, 1, 1, 1),
(242, 'TPS 8', 16, 1, 1, 1),
(243, 'TPS 9', 16, 1, 1, 1),
(244, 'TPS 10', 16, 1, 1, 1),
(245, 'TPS 11', 16, 1, 1, 1),
(246, 'TPS 12', 16, 1, 1, 1),
(247, 'TPS 13', 16, 1, 1, 1),
(248, 'TPS 14', 16, 1, 1, 1),
(249, 'TPS 15', 16, 1, 1, 1),
(250, 'TPS 16', 16, 1, 1, 1),
(251, 'TPS 17', 16, 1, 1, 1),
(252, 'TPS 18', 16, 1, 1, 1),
(253, 'TPS 1', 9, 1, 1, 1),
(254, 'TPS 2', 9, 1, 1, 1),
(255, 'TPS 3', 9, 1, 1, 1),
(256, 'TPS 4', 9, 1, 1, 1),
(257, 'TPS 5', 9, 1, 1, 1),
(258, 'TPS 6', 9, 1, 1, 1),
(259, 'TPS 7', 9, 1, 1, 1),
(260, 'TPS 8', 9, 1, 1, 1),
(261, 'TPS 9', 9, 1, 1, 1),
(262, 'TPS 10', 9, 1, 1, 1),
(263, 'TPS 11', 9, 1, 1, 1),
(264, 'TPS 12', 9, 1, 1, 1),
(265, 'TPS 13', 9, 1, 1, 1),
(266, 'TPS 14', 9, 1, 1, 1),
(267, 'TPS 15', 9, 1, 1, 1),
(268, 'TPS 16', 9, 1, 1, 1),
(269, 'TPS 17', 9, 1, 1, 1),
(270, 'TPS 18', 9, 1, 1, 1),
(271, 'TPS 19', 9, 1, 1, 1),
(272, 'TPS 20', 9, 1, 1, 1),
(273, 'TPS 21', 9, 1, 1, 1),
(274, 'TPS 22', 9, 1, 1, 1),
(275, 'TPS 23', 9, 1, 1, 1),
(276, 'TPS 1', 18, 1, 1, 1),
(277, 'TPS 2', 18, 1, 1, 1),
(278, 'TPS 3', 18, 1, 1, 1),
(279, 'TPS 4', 18, 1, 1, 1),
(280, 'TPS 5', 18, 1, 1, 1),
(281, 'TPS 6', 18, 1, 1, 1),
(282, 'TPS 7', 18, 1, 1, 1),
(283, 'TPS 8', 18, 1, 1, 1),
(284, 'TPS 9', 18, 1, 1, 1),
(285, 'TPS 10', 18, 1, 1, 1),
(286, 'TPS 11', 18, 1, 1, 1),
(287, 'TPS 12', 18, 1, 1, 1),
(288, 'TPS 1', 13, 1, 1, 1),
(289, 'TPS 2', 13, 1, 1, 1),
(290, 'TPS 3', 13, 1, 1, 1),
(291, 'TPS 4', 13, 1, 1, 1),
(292, 'TPS 5', 13, 1, 1, 1),
(293, 'TPS 6', 13, 1, 1, 1),
(294, 'TPS 7', 13, 1, 1, 1),
(295, 'TPS 8', 13, 1, 1, 1),
(296, 'TPS 9', 13, 1, 1, 1),
(297, 'TPS 10', 13, 1, 1, 1),
(298, 'TPS 11', 13, 1, 1, 1),
(299, 'TPS 12', 13, 1, 1, 1),
(300, 'TPS 13', 13, 1, 1, 1),
(301, 'TPS 1', 6, 1, 1, 1),
(302, 'TPS 2', 6, 1, 1, 1),
(303, 'TPS 3', 6, 1, 1, 1),
(304, 'TPS 4', 6, 1, 1, 1),
(305, 'TPS 5', 6, 1, 1, 1),
(306, 'TPS 6', 6, 1, 1, 1),
(307, 'TPS 7', 6, 1, 1, 1),
(308, 'TPS 8', 6, 1, 1, 1),
(309, 'TPS 9', 6, 1, 1, 1),
(310, 'TPS 10', 6, 1, 1, 1),
(311, 'TPS 11', 6, 1, 1, 1),
(312, 'TPS 12', 6, 1, 1, 1),
(313, 'TPS 13', 6, 1, 1, 1),
(314, 'TPS 14', 6, 1, 1, 1),
(315, 'TPS 15', 6, 1, 1, 1),
(316, 'TPS 16', 6, 1, 1, 1),
(317, 'TPS 17', 6, 1, 1, 1),
(318, 'TPS 18', 6, 1, 1, 1),
(319, 'TPS 19', 6, 1, 1, 1),
(320, 'TPS 20', 6, 1, 1, 1),
(321, 'TPS 21', 6, 1, 1, 1),
(322, 'TPS 1', 12, 1, 1, 1),
(323, 'TPS 2', 12, 1, 1, 1),
(324, 'TPS 3', 12, 1, 1, 1),
(325, 'TPS 4', 12, 1, 1, 1),
(326, 'TPS 5', 12, 1, 1, 1),
(327, 'TPS 6', 12, 1, 1, 1),
(328, 'TPS 7', 12, 1, 1, 1),
(329, 'TPS 8', 12, 1, 1, 1),
(330, 'TPS 9', 12, 1, 1, 1),
(331, 'TPS 10', 12, 1, 1, 1),
(332, 'TPS 11', 12, 1, 1, 1),
(333, 'TPS 12', 12, 1, 1, 1),
(334, 'TPS 13', 12, 1, 1, 1),
(335, 'TPS 14', 12, 1, 1, 1),
(336, 'TPS 15', 12, 1, 1, 1),
(337, 'TPS 16', 12, 1, 1, 1),
(338, 'TPS 17', 12, 1, 1, 1),
(339, 'TPS 18', 12, 1, 1, 1),
(340, 'TPS 1', 10, 1, 1, 1),
(341, 'TPS 2', 10, 1, 1, 1),
(342, 'TPS 3', 10, 1, 1, 1),
(343, 'TPS 4', 10, 1, 1, 1),
(344, 'TPS 5', 10, 1, 1, 1),
(345, 'TPS 6', 10, 1, 1, 1),
(346, 'TPS 7', 10, 1, 1, 1),
(347, 'TPS 8', 10, 1, 1, 1),
(348, 'TPS 9', 10, 1, 1, 1),
(349, 'TPS 10', 10, 1, 1, 1),
(350, 'TPS 11', 10, 1, 1, 1),
(351, 'TPS 1', 34, 2, 1, 1),
(352, 'TPS 2', 34, 2, 1, 1),
(353, 'TPS 3', 34, 2, 1, 1),
(354, 'TPS 4', 34, 2, 1, 1),
(355, 'TPS 5', 34, 2, 1, 1),
(356, 'TPS 6', 34, 2, 1, 1),
(357, 'TPS 7', 34, 2, 1, 1),
(358, 'TPS 8', 34, 2, 1, 1),
(359, 'TPS 9', 34, 2, 1, 1),
(360, 'TPS 10', 34, 2, 1, 1),
(361, 'TPS 11', 34, 2, 1, 1),
(362, 'TPS 12', 34, 2, 1, 1),
(363, 'TPS 13', 34, 2, 1, 1),
(364, 'TPS 1', 28, 2, 1, 1),
(365, 'TPS 2', 28, 2, 1, 1),
(366, 'TPS 3', 28, 2, 1, 1),
(367, 'TPS 4', 28, 2, 1, 1),
(368, 'TPS 5', 28, 2, 1, 1),
(369, 'TPS 6', 28, 2, 1, 1),
(370, 'TPS 7', 28, 2, 1, 1),
(371, 'TPS 1', 24, 2, 1, 1),
(372, 'TPS 2', 24, 2, 1, 1),
(373, 'TPS 3', 24, 2, 1, 1),
(374, 'TPS 4', 24, 2, 1, 1),
(375, 'TPS 5', 24, 2, 1, 1),
(376, 'TPS 6', 24, 2, 1, 1),
(377, 'TPS 7', 24, 2, 1, 1),
(378, 'TPS 8', 24, 2, 1, 1),
(379, 'TPS 9', 24, 2, 1, 1),
(380, 'TPS 10', 24, 2, 1, 1),
(381, 'TPS 11', 24, 2, 1, 1),
(382, 'TPS 12', 24, 2, 1, 1),
(383, 'TPS 13', 24, 2, 1, 1),
(384, 'TPS 14', 24, 2, 1, 1),
(385, 'TPS 15', 24, 2, 1, 1),
(386, 'TPS 16', 24, 2, 1, 1),
(387, 'TPS 17', 24, 2, 1, 1),
(388, 'TPS 18', 24, 2, 1, 1),
(389, 'TPS 19', 24, 2, 1, 1),
(390, 'TPS 20', 24, 2, 1, 1),
(391, 'TPS 21', 24, 2, 1, 1),
(392, 'TPS 22', 24, 2, 1, 1),
(393, 'TPS 23', 24, 2, 1, 1),
(394, 'TPS 1', 22, 2, 1, 1),
(395, 'TPS 2', 22, 2, 1, 1),
(396, 'TPS 3', 22, 2, 1, 1),
(397, 'TPS 4', 22, 2, 1, 1),
(398, 'TPS 5', 22, 2, 1, 1),
(399, 'TPS 6', 22, 2, 1, 1),
(400, 'TPS 7', 22, 2, 1, 1),
(401, 'TPS 8', 22, 2, 1, 1),
(402, 'TPS 1', 27, 2, 1, 1),
(403, 'TPS 2', 27, 2, 1, 1),
(404, 'TPS 3', 27, 2, 1, 1),
(405, 'TPS 4', 27, 2, 1, 1),
(406, 'TPS 5', 27, 2, 1, 1),
(407, 'TPS 6', 27, 2, 1, 1),
(408, 'TPS 7', 27, 2, 1, 1),
(409, 'TPS 8', 27, 2, 1, 1),
(410, 'TPS 1', 32, 2, 1, 1),
(411, 'TPS 2', 32, 2, 1, 1),
(412, 'TPS 3', 32, 2, 1, 1),
(413, 'TPS 4', 32, 2, 1, 1),
(414, 'TPS 5', 32, 2, 1, 1),
(415, 'TPS 6', 32, 2, 1, 1),
(416, 'TPS 7', 32, 2, 1, 1),
(417, 'TPS 8', 32, 2, 1, 1),
(418, 'TPS 9', 32, 2, 1, 1),
(419, 'TPS 10', 32, 2, 1, 1),
(420, 'TPS 11', 32, 2, 1, 1),
(421, 'TPS 12', 32, 2, 1, 1),
(422, 'TPS 13', 32, 2, 1, 1),
(423, 'TPS 14', 32, 2, 1, 1),
(424, 'TPS 1', 23, 2, 1, 1),
(425, 'TPS 2', 23, 2, 1, 1),
(426, 'TPS 3', 23, 2, 1, 1),
(427, 'TPS 4', 23, 2, 1, 1),
(428, 'TPS 5', 23, 2, 1, 1),
(429, 'TPS 6', 23, 2, 1, 1),
(430, 'TPS 7', 23, 2, 1, 1),
(431, 'TPS 8', 23, 2, 1, 1),
(432, 'TPS 9', 23, 2, 1, 1),
(433, 'TPS 10', 23, 2, 1, 1),
(434, 'TPS 1', 20, 2, 1, 1),
(435, 'TPS 2', 20, 2, 1, 1),
(436, 'TPS 3', 20, 2, 1, 1),
(437, 'TPS 4', 20, 2, 1, 1),
(438, 'TPS 5', 20, 2, 1, 1),
(439, 'TPS 6', 20, 2, 1, 1),
(440, 'TPS 7', 20, 2, 1, 1),
(441, 'TPS 8', 20, 2, 1, 1),
(442, 'TPS 9', 20, 2, 1, 1),
(443, 'TPS 10', 20, 2, 1, 1),
(444, 'TPS 11', 20, 2, 1, 1),
(445, 'TPS 12', 20, 2, 1, 1),
(446, 'TPS 13', 20, 2, 1, 1),
(447, 'TPS 14', 20, 2, 1, 1),
(448, 'TPS 1', 21, 2, 1, 1),
(449, 'TPS 2', 21, 2, 1, 1),
(450, 'TPS 3', 21, 2, 1, 1),
(451, 'TPS 4', 21, 2, 1, 1),
(452, 'TPS 5', 21, 2, 1, 1),
(453, 'TPS 6', 21, 2, 1, 1),
(454, 'TPS 7', 21, 2, 1, 1),
(455, 'TPS 8', 21, 2, 1, 1),
(456, 'TPS 9', 21, 2, 1, 1),
(457, 'TPS 10', 21, 2, 1, 1),
(458, 'TPS 1', 30, 2, 1, 1),
(459, 'TPS 2', 30, 2, 1, 1),
(460, 'TPS 3', 30, 2, 1, 1),
(461, 'TPS 4', 30, 2, 1, 1),
(462, 'TPS 5', 30, 2, 1, 1),
(463, 'TPS 6', 30, 2, 1, 1),
(464, 'TPS 7', 30, 2, 1, 1),
(465, 'TPS 8', 30, 2, 1, 1),
(466, 'TPS 9', 30, 2, 1, 1),
(467, 'TPS 10', 30, 2, 1, 1),
(468, 'TPS 1', 33, 2, 1, 1),
(469, 'TPS 2', 33, 2, 1, 1),
(470, 'TPS 3', 33, 2, 1, 1),
(471, 'TPS 4', 33, 2, 1, 1),
(472, 'TPS 5', 33, 2, 1, 1),
(473, 'TPS 6', 33, 2, 1, 1),
(474, 'TPS 7', 33, 2, 1, 1),
(475, 'TPS 8', 33, 2, 1, 1),
(476, 'TPS 9', 33, 2, 1, 1),
(477, 'TPS 10', 33, 2, 1, 1),
(478, 'TPS 1', 29, 2, 1, 1),
(479, 'TPS 2', 29, 2, 1, 1),
(480, 'TPS 3', 29, 2, 1, 1),
(481, 'TPS 4', 29, 2, 1, 1),
(482, 'TPS 5', 29, 2, 1, 1),
(483, 'TPS 6', 29, 2, 1, 1),
(484, 'TPS 7', 29, 2, 1, 1),
(485, 'TPS 1', 25, 2, 1, 1),
(486, 'TPS 2', 25, 2, 1, 1),
(487, 'TPS 3', 25, 2, 1, 1),
(488, 'TPS 4', 25, 2, 1, 1),
(489, 'TPS 5', 25, 2, 1, 1),
(490, 'TPS 1', 35, 2, 1, 1),
(491, 'TPS 2', 35, 2, 1, 1),
(492, 'TPS 3', 35, 2, 1, 1),
(493, 'TPS 4', 35, 2, 1, 1),
(494, 'TPS 5', 35, 2, 1, 1),
(495, 'TPS 6', 35, 2, 1, 1),
(496, 'TPS 7', 35, 2, 1, 1),
(497, 'TPS 8', 35, 2, 1, 1),
(498, 'TPS 9', 35, 2, 1, 1),
(499, 'TPS 10', 35, 2, 1, 1),
(500, 'TPS 11', 35, 2, 1, 1),
(501, 'TPS 12', 35, 2, 1, 1),
(502, 'TPS 13', 35, 2, 1, 1),
(503, 'TPS 14', 35, 2, 1, 1),
(504, 'TPS 15', 35, 2, 1, 1),
(505, 'TPS 1', 26, 2, 1, 1),
(506, 'TPS 2', 26, 2, 1, 1),
(507, 'TPS 3', 26, 2, 1, 1),
(508, 'TPS 4', 26, 2, 1, 1),
(509, 'TPS 5', 26, 2, 1, 1),
(510, 'TPS 6', 26, 2, 1, 1),
(511, 'TPS 7', 26, 2, 1, 1),
(512, 'TPS 8', 26, 2, 1, 1),
(513, 'TPS 9', 26, 2, 1, 1),
(514, 'TPS 10', 26, 2, 1, 1),
(515, 'TPS 11', 26, 2, 1, 1),
(516, 'TPS 12', 26, 2, 1, 1),
(517, 'TPS 13', 26, 2, 1, 1),
(518, 'TPS 14', 26, 2, 1, 1),
(519, 'TPS 15', 26, 2, 1, 1),
(520, 'TPS 16', 26, 2, 1, 1),
(521, 'TPS 17', 26, 2, 1, 1),
(522, 'TPS 1', 31, 2, 1, 1),
(523, 'TPS 2', 31, 2, 1, 1),
(524, 'TPS 3', 31, 2, 1, 1),
(525, 'TPS 4', 31, 2, 1, 1),
(526, 'TPS 5', 31, 2, 1, 1),
(527, 'TPS 6', 31, 2, 1, 1),
(528, 'TPS 7', 31, 2, 1, 1),
(529, 'TPS 8', 31, 2, 1, 1),
(530, 'TPS 9', 31, 2, 1, 1),
(531, 'TPS 10', 31, 2, 1, 1),
(532, 'TPS 11', 31, 2, 1, 1),
(533, 'TPS 12', 31, 2, 1, 1),
(534, 'TPS 13', 31, 2, 1, 1),
(535, 'TPS 14', 31, 2, 1, 1),
(536, 'TPS 1', 42, 3, 1, 1),
(537, 'TPS 2', 42, 3, 1, 1),
(538, 'TPS 3', 42, 3, 1, 1),
(539, 'TPS 4', 42, 3, 1, 1),
(540, 'TPS 5', 42, 3, 1, 1),
(541, 'TPS 6', 42, 3, 1, 1),
(542, 'TPS 7', 42, 3, 1, 1),
(543, 'TPS 1', 36, 3, 1, 1),
(544, 'TPS 2', 36, 3, 1, 1),
(545, 'TPS 3', 36, 3, 1, 1),
(546, 'TPS 4', 36, 3, 1, 1),
(547, 'TPS 5', 36, 3, 1, 1),
(548, 'TPS 6', 36, 3, 1, 1),
(549, 'TPS 7', 36, 3, 1, 1),
(550, 'TPS 8', 36, 3, 1, 1),
(551, 'TPS 9', 36, 3, 1, 1),
(552, 'TPS 10', 36, 3, 1, 1),
(553, 'TPS 11', 36, 3, 1, 1),
(554, 'TPS 12', 36, 3, 1, 1),
(555, 'TPS 13', 36, 3, 1, 1),
(556, 'TPS 14', 36, 3, 1, 1),
(557, 'TPS 15', 36, 3, 1, 1),
(558, 'TPS 1', 37, 3, 1, 1),
(559, 'TPS 2', 37, 3, 1, 1),
(560, 'TPS 3', 37, 3, 1, 1),
(561, 'TPS 4', 37, 3, 1, 1),
(562, 'TPS 5', 37, 3, 1, 1),
(563, 'TPS 1', 41, 3, 1, 1),
(564, 'TPS 2', 41, 3, 1, 1),
(565, 'TPS 3', 41, 3, 1, 1),
(566, 'TPS 4', 41, 3, 1, 1),
(567, 'TPS 5', 41, 3, 1, 1),
(568, 'TPS 6', 41, 3, 1, 1),
(569, 'TPS 7', 41, 3, 1, 1),
(570, 'TPS 8', 41, 3, 1, 1),
(571, 'TPS 9', 41, 3, 1, 1),
(572, 'TPS 10', 41, 3, 1, 1),
(573, 'TPS 11', 41, 3, 1, 1),
(574, 'TPS 12', 41, 3, 1, 1),
(575, 'TPS 1', 48, 3, 1, 1),
(576, 'TPS 2', 48, 3, 1, 1),
(577, 'TPS 3', 48, 3, 1, 1),
(578, 'TPS 4', 48, 3, 1, 1),
(579, 'TPS 5', 48, 3, 1, 1),
(580, 'TPS 6', 48, 3, 1, 1),
(581, 'TPS 7', 48, 3, 1, 1),
(582, 'TPS 8', 48, 3, 1, 1),
(583, 'TPS 9', 48, 3, 1, 1),
(584, 'TPS 10', 48, 3, 1, 1),
(585, 'TPS 11', 48, 3, 1, 1),
(586, 'TPS 12', 48, 3, 1, 1),
(587, 'TPS 1', 39, 3, 1, 1),
(588, 'TPS 2', 39, 3, 1, 1),
(589, 'TPS 3', 39, 3, 1, 1),
(590, 'TPS 4', 39, 3, 1, 1),
(591, 'TPS 5', 39, 3, 1, 1),
(592, 'TPS 6', 39, 3, 1, 1),
(593, 'TPS 7', 39, 3, 1, 1),
(594, 'TPS 8', 39, 3, 1, 1),
(595, 'TPS 9', 39, 3, 1, 1),
(596, 'TPS 10', 39, 3, 1, 1),
(597, 'TPS 11', 39, 3, 1, 1),
(598, 'TPS 12', 39, 3, 1, 1),
(599, 'TPS 13', 39, 3, 1, 1),
(600, 'TPS 14', 39, 3, 1, 1),
(601, 'TPS 15', 39, 3, 1, 1),
(602, 'TPS 16', 39, 3, 1, 1),
(603, 'TPS 1', 249, 3, 1, 1),
(604, 'TPS 2', 249, 3, 1, 1),
(605, 'TPS 3', 249, 3, 1, 1),
(606, 'TPS 4', 249, 3, 1, 1),
(607, 'TPS 5', 249, 3, 1, 1),
(608, 'TPS 6', 249, 3, 1, 1),
(609, 'TPS 7', 249, 3, 1, 1),
(610, 'TPS 8', 249, 3, 1, 1),
(611, 'TPS 1', 38, 3, 1, 1),
(612, 'TPS 2', 38, 3, 1, 1),
(613, 'TPS 3', 38, 3, 1, 1),
(614, 'TPS 4', 38, 3, 1, 1),
(615, 'TPS 5', 38, 3, 1, 1),
(616, 'TPS 1', 47, 3, 1, 1),
(617, 'TPS 2', 47, 3, 1, 1),
(618, 'TPS 3', 47, 3, 1, 1),
(619, 'TPS 4', 47, 3, 1, 1),
(620, 'TPS 5', 47, 3, 1, 1),
(621, 'TPS 6', 47, 3, 1, 1),
(622, 'TPS 7', 47, 3, 1, 1),
(623, 'TPS 8', 47, 3, 1, 1),
(624, 'TPS 9', 47, 3, 1, 1),
(625, 'TPS 10', 47, 3, 1, 1),
(626, 'TPS 11', 47, 3, 1, 1),
(627, 'TPS 1', 43, 3, 1, 1),
(628, 'TPS 2', 43, 3, 1, 1),
(629, 'TPS 3', 43, 3, 1, 1),
(630, 'TPS 4', 43, 3, 1, 1),
(631, 'TPS 5', 43, 3, 1, 1),
(632, 'TPS 6', 43, 3, 1, 1),
(633, 'TPS 1', 44, 3, 1, 1),
(634, 'TPS 2', 44, 3, 1, 1),
(635, 'TPS 3', 44, 3, 1, 1),
(636, 'TPS 4', 44, 3, 1, 1),
(637, 'TPS 5', 44, 3, 1, 1),
(638, 'TPS 6', 44, 3, 1, 1),
(639, 'TPS 7', 44, 3, 1, 1),
(640, 'TPS 8', 44, 3, 1, 1),
(641, 'TPS 9', 44, 3, 1, 1),
(642, 'TPS 10', 44, 3, 1, 1),
(643, 'TPS 1', 46, 3, 1, 1),
(644, 'TPS 2', 46, 3, 1, 1),
(645, 'TPS 3', 46, 3, 1, 1),
(646, 'TPS 4', 46, 3, 1, 1),
(647, 'TPS 5', 46, 3, 1, 1),
(648, 'TPS 6', 46, 3, 1, 1),
(649, 'TPS 7', 46, 3, 1, 1),
(650, 'TPS 1', 45, 3, 1, 1),
(651, 'TPS 2', 45, 3, 1, 1),
(652, 'TPS 3', 45, 3, 1, 1),
(653, 'TPS 4', 45, 3, 1, 1),
(654, 'TPS 5', 45, 3, 1, 1),
(655, 'TPS 6', 45, 3, 1, 1),
(656, 'TPS 7', 45, 3, 1, 1),
(657, 'TPS 1', 40, 3, 1, 1),
(658, 'TPS 2', 40, 3, 1, 1),
(659, 'TPS 3', 40, 3, 1, 1),
(660, 'TPS 4', 40, 3, 1, 1),
(661, 'TPS 5', 40, 3, 1, 1),
(662, 'TPS 6', 40, 3, 1, 1),
(663, 'TPS 7', 40, 3, 1, 1),
(664, 'TPS 8', 40, 3, 1, 1),
(665, 'TPS 9', 40, 3, 1, 1),
(666, 'TPS 10', 40, 3, 1, 1),
(667, 'TPS 1', 51, 4, 1, 1),
(668, 'TPS 2', 51, 4, 1, 1),
(669, 'TPS 3', 51, 4, 1, 1),
(670, 'TPS 4', 51, 4, 1, 1),
(671, 'TPS 5', 51, 4, 1, 1),
(672, 'TPS 6', 51, 4, 1, 1),
(673, 'TPS 7', 51, 4, 1, 1),
(674, 'TPS 8', 51, 4, 1, 1),
(675, 'TPS 1', 54, 4, 1, 1),
(676, 'TPS 2', 54, 4, 1, 1),
(677, 'TPS 3', 54, 4, 1, 1),
(678, 'TPS 4', 54, 4, 1, 1),
(679, 'TPS 5', 54, 4, 1, 1),
(680, 'TPS 6', 54, 4, 1, 1),
(681, 'TPS 7', 54, 4, 1, 1),
(682, 'TPS 8', 54, 4, 1, 1),
(683, 'TPS 9', 54, 4, 1, 1),
(684, 'TPS 10', 54, 4, 1, 1),
(685, 'TPS 11', 54, 4, 1, 1),
(686, 'TPS 12', 54, 4, 1, 1),
(687, 'TPS 1', 66, 4, 1, 1),
(688, 'TPS 2', 66, 4, 1, 1),
(689, 'TPS 3', 66, 4, 1, 1),
(690, 'TPS 4', 66, 4, 1, 1),
(691, 'TPS 1', 56, 4, 1, 1),
(692, 'TPS 2', 56, 4, 1, 1),
(693, 'TPS 3', 56, 4, 1, 1),
(694, 'TPS 4', 56, 4, 1, 1),
(695, 'TPS 5', 56, 4, 1, 1),
(696, 'TPS 6', 56, 4, 1, 1),
(697, 'TPS 7', 56, 4, 1, 1),
(698, 'TPS 8', 56, 4, 1, 1),
(699, 'TPS 1', 60, 4, 1, 1),
(700, 'TPS 2', 60, 4, 1, 1),
(701, 'TPS 3', 60, 4, 1, 1),
(702, 'TPS 4', 60, 4, 1, 1),
(703, 'TPS 5', 60, 4, 1, 1),
(704, 'TPS 6', 60, 4, 1, 1),
(705, 'TPS 1', 57, 4, 1, 1),
(706, 'TPS 2', 57, 4, 1, 1),
(707, 'TPS 3', 57, 4, 1, 1),
(708, 'TPS 4', 57, 4, 1, 1),
(709, 'TPS 5', 57, 4, 1, 1),
(710, 'TPS 6', 57, 4, 1, 1),
(711, 'TPS 7', 57, 4, 1, 1),
(712, 'TPS 8', 57, 4, 1, 1),
(713, 'TPS 9', 57, 4, 1, 1),
(714, 'TPS 10', 57, 4, 1, 1),
(715, 'TPS 11', 57, 4, 1, 1),
(716, 'TPS 1', 69, 4, 1, 1),
(717, 'TPS 2', 69, 4, 1, 1),
(718, 'TPS 3', 69, 4, 1, 1),
(719, 'TPS 4', 69, 4, 1, 1),
(720, 'TPS 5', 69, 4, 1, 1),
(721, 'TPS 6', 69, 4, 1, 1),
(722, 'TPS 7', 69, 4, 1, 1),
(723, 'TPS 8', 69, 4, 1, 1),
(724, 'TPS 9', 69, 4, 1, 1),
(725, 'TPS 10', 69, 4, 1, 1),
(726, 'TPS 11', 69, 4, 1, 1),
(727, 'TPS 12', 69, 4, 1, 1),
(728, 'TPS 13', 69, 4, 1, 1),
(729, 'TPS 14', 69, 4, 1, 1),
(730, 'TPS 1', 55, 4, 1, 1),
(731, 'TPS 2', 55, 4, 1, 1),
(732, 'TPS 3', 55, 4, 1, 1),
(733, 'TPS 4', 55, 4, 1, 1),
(734, 'TPS 5', 55, 4, 1, 1),
(735, 'TPS 6', 55, 4, 1, 1),
(736, 'TPS 7', 55, 4, 1, 1),
(737, 'TPS 8', 55, 4, 1, 1),
(738, 'TPS 9', 55, 4, 1, 1),
(739, 'TPS 10', 55, 4, 1, 1),
(740, 'TPS 11', 55, 4, 1, 1),
(741, 'TPS 12', 55, 4, 1, 1),
(742, 'TPS 13', 55, 4, 1, 1),
(743, 'TPS 1', 53, 4, 1, 1),
(744, 'TPS 2', 53, 4, 1, 1),
(745, 'TPS 3', 53, 4, 1, 1),
(746, 'TPS 4', 53, 4, 1, 1),
(747, 'TPS 5', 53, 4, 1, 1),
(748, 'TPS 6', 53, 4, 1, 1),
(749, 'TPS 7', 53, 4, 1, 1),
(750, 'TPS 8', 53, 4, 1, 1),
(751, 'TPS 9', 53, 4, 1, 1),
(752, 'TPS 10', 53, 4, 1, 1),
(753, 'TPS 11', 53, 4, 1, 1),
(754, 'TPS 12', 53, 4, 1, 1),
(755, 'TPS 13', 53, 4, 1, 1),
(756, 'TPS 14', 53, 4, 1, 1),
(757, 'TPS 15', 53, 4, 1, 1),
(758, 'TPS 16', 53, 4, 1, 1),
(759, 'TPS 17', 53, 4, 1, 1),
(760, 'TPS 1', 49, 4, 1, 1),
(761, 'TPS 2', 49, 4, 1, 1),
(762, 'TPS 3', 49, 4, 1, 1),
(763, 'TPS 4', 49, 4, 1, 1),
(764, 'TPS 5', 49, 4, 1, 1),
(765, 'TPS 6', 49, 4, 1, 1),
(766, 'TPS 7', 49, 4, 1, 1),
(767, 'TPS 8', 49, 4, 1, 1),
(768, 'TPS 9', 49, 4, 1, 1),
(769, 'TPS 10', 49, 4, 1, 1),
(770, 'TPS 11', 49, 4, 1, 1),
(771, 'TPS 12', 49, 4, 1, 1),
(772, 'TPS 13', 49, 4, 1, 1),
(773, 'TPS 14', 49, 4, 1, 1),
(774, 'TPS 15', 49, 4, 1, 1),
(775, 'TPS 1', 65, 4, 1, 1),
(776, 'TPS 2', 65, 4, 1, 1),
(777, 'TPS 3', 65, 4, 1, 1),
(778, 'TPS 4', 65, 4, 1, 1),
(779, 'TPS 5', 65, 4, 1, 1),
(780, 'TPS 6', 65, 4, 1, 1),
(781, 'TPS 7', 65, 4, 1, 1),
(782, 'TPS 8', 65, 4, 1, 1),
(783, 'TPS 9', 65, 4, 1, 1),
(784, 'TPS 10', 65, 4, 1, 1),
(785, 'TPS 11', 65, 4, 1, 1),
(786, 'TPS 12', 65, 4, 1, 1),
(787, 'TPS 13', 65, 4, 1, 1),
(788, 'TPS 14', 65, 4, 1, 1),
(789, 'TPS 15', 65, 4, 1, 1),
(790, 'TPS 16', 65, 4, 1, 1),
(791, 'TPS 1', 64, 4, 1, 1),
(792, 'TPS 2', 64, 4, 1, 1),
(793, 'TPS 3', 64, 4, 1, 1),
(794, 'TPS 4', 64, 4, 1, 1),
(795, 'TPS 5', 64, 4, 1, 1),
(796, 'TPS 6', 64, 4, 1, 1),
(797, 'TPS 7', 64, 4, 1, 1),
(798, 'TPS 8', 64, 4, 1, 1),
(799, 'TPS 9', 64, 4, 1, 1),
(800, 'TPS 10', 64, 4, 1, 1),
(801, 'TPS 11', 64, 4, 1, 1),
(802, 'TPS 12', 64, 4, 1, 1),
(803, 'TPS 13', 64, 4, 1, 1),
(804, 'TPS 14', 64, 4, 1, 1),
(805, 'TPS 15', 64, 4, 1, 1),
(806, 'TPS 16', 64, 4, 1, 1),
(807, 'TPS 1', 67, 4, 1, 1),
(808, 'TPS 2', 67, 4, 1, 1),
(809, 'TPS 3', 67, 4, 1, 1),
(810, 'TPS 4', 67, 4, 1, 1),
(811, 'TPS 5', 67, 4, 1, 1),
(812, 'TPS 6', 67, 4, 1, 1),
(813, 'TPS 7', 67, 4, 1, 1),
(814, 'TPS 8', 67, 4, 1, 1),
(815, 'TPS 9', 67, 4, 1, 1),
(816, 'TPS 1', 58, 4, 1, 1),
(817, 'TPS 2', 58, 4, 1, 1),
(818, 'TPS 3', 58, 4, 1, 1),
(819, 'TPS 4', 58, 4, 1, 1),
(820, 'TPS 5', 58, 4, 1, 1),
(821, 'TPS 6', 58, 4, 1, 1),
(822, 'TPS 7', 58, 4, 1, 1),
(823, 'TPS 8', 58, 4, 1, 1),
(824, 'TPS 9', 58, 4, 1, 1),
(825, 'TPS 10', 58, 4, 1, 1),
(826, 'TPS 11', 58, 4, 1, 1),
(827, 'TPS 12', 58, 4, 1, 1),
(828, 'TPS 13', 58, 4, 1, 1),
(829, 'TPS 14', 58, 4, 1, 1),
(830, 'TPS 1', 50, 4, 1, 1),
(831, 'TPS 2', 50, 4, 1, 1),
(832, 'TPS 3', 50, 4, 1, 1),
(833, 'TPS 4', 50, 4, 1, 1),
(834, 'TPS 5', 50, 4, 1, 1),
(835, 'TPS 6', 50, 4, 1, 1),
(836, 'TPS 7', 50, 4, 1, 1),
(837, 'TPS 1', 52, 4, 1, 1),
(838, 'TPS 2', 52, 4, 1, 1),
(839, 'TPS 3', 52, 4, 1, 1),
(840, 'TPS 4', 52, 4, 1, 1),
(841, 'TPS 5', 52, 4, 1, 1),
(842, 'TPS 6', 52, 4, 1, 1),
(843, 'TPS 7', 52, 4, 1, 1),
(844, 'TPS 8', 52, 4, 1, 1),
(845, 'TPS 9', 52, 4, 1, 1),
(846, 'TPS 10', 52, 4, 1, 1),
(847, 'TPS 11', 52, 4, 1, 1),
(848, 'TPS 12', 52, 4, 1, 1),
(849, 'TPS 13', 52, 4, 1, 1),
(850, 'TPS 14', 52, 4, 1, 1),
(851, 'TPS 15', 52, 4, 1, 1),
(852, 'TPS 16', 52, 4, 1, 1),
(853, 'TPS 17', 52, 4, 1, 1),
(854, 'TPS 1', 61, 4, 1, 1),
(855, 'TPS 2', 61, 4, 1, 1),
(856, 'TPS 3', 61, 4, 1, 1),
(857, 'TPS 4', 61, 4, 1, 1),
(858, 'TPS 5', 61, 4, 1, 1),
(859, 'TPS 6', 61, 4, 1, 1),
(860, 'TPS 7', 61, 4, 1, 1),
(861, 'TPS 8', 61, 4, 1, 1),
(862, 'TPS 9', 61, 4, 1, 1),
(863, 'TPS 10', 61, 4, 1, 1),
(864, 'TPS 11', 61, 4, 1, 1),
(865, 'TPS 12', 61, 4, 1, 1),
(866, 'TPS 13', 61, 4, 1, 1),
(867, 'TPS 14', 61, 4, 1, 1),
(868, 'TPS 15', 61, 4, 1, 1),
(869, 'TPS 16', 61, 4, 1, 1),
(870, 'TPS 1', 59, 4, 1, 1),
(871, 'TPS 2', 59, 4, 1, 1),
(872, 'TPS 3', 59, 4, 1, 1),
(873, 'TPS 4', 59, 4, 1, 1),
(874, 'TPS 5', 59, 4, 1, 1),
(875, 'TPS 6', 59, 4, 1, 1),
(876, 'TPS 7', 59, 4, 1, 1),
(877, 'TPS 8', 59, 4, 1, 1),
(878, 'TPS 9', 59, 4, 1, 1),
(879, 'TPS 10', 59, 4, 1, 1),
(880, 'TPS 11', 59, 4, 1, 1),
(881, 'TPS 12', 59, 4, 1, 1),
(882, 'TPS 13', 59, 4, 1, 1),
(883, 'TPS 1', 68, 4, 1, 1),
(884, 'TPS 2', 68, 4, 1, 1),
(885, 'TPS 3', 68, 4, 1, 1),
(886, 'TPS 4', 68, 4, 1, 1),
(887, 'TPS 5', 68, 4, 1, 1),
(888, 'TPS 6', 68, 4, 1, 1),
(889, 'TPS 7', 68, 4, 1, 1),
(890, 'TPS 8', 68, 4, 1, 1),
(891, 'TPS 9', 68, 4, 1, 1),
(892, 'TPS 10', 68, 4, 1, 1),
(893, 'TPS 11', 68, 4, 1, 1),
(894, 'TPS 12', 68, 4, 1, 1),
(895, 'TPS 13', 68, 4, 1, 1),
(896, 'TPS 14', 68, 4, 1, 1),
(897, 'TPS 1', 63, 4, 1, 1),
(898, 'TPS 2', 63, 4, 1, 1),
(899, 'TPS 3', 63, 4, 1, 1),
(900, 'TPS 4', 63, 4, 1, 1),
(901, 'TPS 5', 63, 4, 1, 1),
(902, 'TPS 6', 63, 4, 1, 1),
(903, 'TPS 7', 63, 4, 1, 1),
(904, 'TPS 8', 63, 4, 1, 1),
(905, 'TPS 9', 63, 4, 1, 1),
(906, 'TPS 10', 63, 4, 1, 1),
(907, 'TPS 1', 62, 4, 1, 1),
(908, 'TPS 2', 62, 4, 1, 1),
(909, 'TPS 3', 62, 4, 1, 1),
(910, 'TPS 4', 62, 4, 1, 1),
(911, 'TPS 5', 62, 4, 1, 1),
(912, 'TPS 6', 62, 4, 1, 1),
(913, 'TPS 7', 62, 4, 1, 1),
(914, 'TPS 8', 62, 4, 1, 1),
(915, 'TPS 9', 62, 4, 1, 1),
(916, 'TPS 10', 62, 4, 1, 1),
(917, 'TPS 11', 62, 4, 1, 1),
(918, 'TPS 12', 62, 4, 1, 1),
(919, 'TPS 1', 76, 5, 1, 1),
(920, 'TPS 2', 76, 5, 1, 1),
(921, 'TPS 3', 76, 5, 1, 1),
(922, 'TPS 4', 76, 5, 1, 1),
(923, 'TPS 5', 76, 5, 1, 1),
(924, 'TPS 6', 76, 5, 1, 1),
(925, 'TPS 7', 76, 5, 1, 1),
(926, 'TPS 8', 76, 5, 1, 1),
(927, 'TPS 9', 76, 5, 1, 1),
(928, 'TPS 10', 76, 5, 1, 1),
(929, 'TPS 11', 76, 5, 1, 1),
(930, 'TPS 1', 78, 5, 1, 1),
(931, 'TPS 2', 78, 5, 1, 1),
(932, 'TPS 3', 78, 5, 1, 1),
(933, 'TPS 4', 78, 5, 1, 1),
(934, 'TPS 5', 78, 5, 1, 1),
(935, 'TPS 6', 78, 5, 1, 1),
(936, 'TPS 7', 78, 5, 1, 1),
(937, 'TPS 8', 78, 5, 1, 1),
(938, 'TPS 9', 78, 5, 1, 1),
(939, 'TPS 10', 78, 5, 1, 1),
(940, 'TPS 11', 78, 5, 1, 1),
(941, 'TPS 1', 85, 5, 1, 1),
(942, 'TPS 2', 85, 5, 1, 1),
(943, 'TPS 3', 85, 5, 1, 1),
(944, 'TPS 4', 85, 5, 1, 1),
(945, 'TPS 5', 85, 5, 1, 1),
(946, 'TPS 6', 85, 5, 1, 1),
(947, 'TPS 7', 85, 5, 1, 1),
(948, 'TPS 8', 85, 5, 1, 1),
(949, 'TPS 9', 85, 5, 1, 1),
(950, 'TPS 10', 85, 5, 1, 1),
(951, 'TPS 11', 85, 5, 1, 1),
(952, 'TPS 12', 85, 5, 1, 1),
(953, 'TPS 1', 86, 5, 1, 1),
(954, 'TPS 2', 86, 5, 1, 1),
(955, 'TPS 3', 86, 5, 1, 1),
(956, 'TPS 4', 86, 5, 1, 1),
(957, 'TPS 5', 86, 5, 1, 1),
(958, 'TPS 6', 86, 5, 1, 1),
(959, 'TPS 7', 86, 5, 1, 1),
(960, 'TPS 8', 86, 5, 1, 1),
(961, 'TPS 9', 86, 5, 1, 1),
(962, 'TPS 10', 86, 5, 1, 1),
(963, 'TPS 11', 86, 5, 1, 1),
(964, 'TPS 12', 86, 5, 1, 1),
(965, 'TPS 13', 86, 5, 1, 1),
(966, 'TPS 14', 86, 5, 1, 1),
(967, 'TPS 15', 86, 5, 1, 1),
(968, 'TPS 16', 86, 5, 1, 1),
(969, 'TPS 17', 86, 5, 1, 1),
(970, 'TPS 18', 86, 5, 1, 1),
(971, 'TPS 19', 86, 5, 1, 1),
(972, 'TPS 20', 86, 5, 1, 1),
(973, 'TPS 21', 86, 5, 1, 1),
(974, 'TPS 22', 86, 5, 1, 1),
(975, 'TPS 23', 86, 5, 1, 1),
(976, 'TPS 24', 86, 5, 1, 1),
(977, 'TPS 25', 86, 5, 1, 1),
(978, 'TPS 26', 86, 5, 1, 1),
(979, 'TPS 27', 86, 5, 1, 1),
(980, 'TPS 1', 70, 5, 1, 1),
(981, 'TPS 2', 70, 5, 1, 1),
(982, 'TPS 3', 70, 5, 1, 1),
(983, 'TPS 4', 70, 5, 1, 1),
(984, 'TPS 5', 70, 5, 1, 1),
(985, 'TPS 6', 70, 5, 1, 1),
(986, 'TPS 7', 70, 5, 1, 1),
(987, 'TPS 8', 70, 5, 1, 1),
(988, 'TPS 9', 70, 5, 1, 1),
(989, 'TPS 10', 70, 5, 1, 1),
(990, 'TPS 11', 70, 5, 1, 1),
(991, 'TPS 1', 79, 5, 1, 1),
(992, 'TPS 2', 79, 5, 1, 1),
(993, 'TPS 3', 79, 5, 1, 1),
(994, 'TPS 4', 79, 5, 1, 1),
(995, 'TPS 5', 79, 5, 1, 1),
(996, 'TPS 6', 79, 5, 1, 1),
(997, 'TPS 7', 79, 5, 1, 1),
(998, 'TPS 8', 79, 5, 1, 1),
(999, 'TPS 9', 79, 5, 1, 1),
(1000, 'TPS 10', 79, 5, 1, 1),
(1001, 'TPS 11', 79, 5, 1, 1),
(1002, 'TPS 12', 79, 5, 1, 1),
(1003, 'TPS 13', 79, 5, 1, 1),
(1004, 'TPS 14', 79, 5, 1, 1),
(1005, 'TPS 15', 79, 5, 1, 1),
(1006, 'TPS 16', 79, 5, 1, 1),
(1007, 'TPS 17', 79, 5, 1, 1),
(1008, 'TPS 18', 79, 5, 1, 1),
(1009, 'TPS 19', 79, 5, 1, 1),
(1010, 'TPS 1', 74, 5, 1, 1),
(1011, 'TPS 2', 74, 5, 1, 1),
(1012, 'TPS 3', 74, 5, 1, 1),
(1013, 'TPS 4', 74, 5, 1, 1),
(1014, 'TPS 5', 74, 5, 1, 1),
(1015, 'TPS 6', 74, 5, 1, 1),
(1016, 'TPS 7', 74, 5, 1, 1),
(1017, 'TPS 8', 74, 5, 1, 1),
(1018, 'TPS 9', 74, 5, 1, 1),
(1019, 'TPS 10', 74, 5, 1, 1),
(1020, 'TPS 11', 74, 5, 1, 1),
(1021, 'TPS 1', 73, 5, 1, 1),
(1022, 'TPS 2', 73, 5, 1, 1),
(1023, 'TPS 3', 73, 5, 1, 1),
(1024, 'TPS 4', 73, 5, 1, 1),
(1025, 'TPS 5', 73, 5, 1, 1),
(1026, 'TPS 6', 73, 5, 1, 1),
(1027, 'TPS 7', 73, 5, 1, 1),
(1028, 'TPS 8', 73, 5, 1, 1),
(1029, 'TPS 9', 73, 5, 1, 1),
(1030, 'TPS 10', 73, 5, 1, 1),
(1031, 'TPS 11', 73, 5, 1, 1),
(1032, 'TPS 12', 73, 5, 1, 1),
(1033, 'TPS 13', 73, 5, 1, 1),
(1034, 'TPS 14', 73, 5, 1, 1),
(1035, 'TPS 15', 73, 5, 1, 1),
(1036, 'TPS 1', 80, 5, 1, 1),
(1037, 'TPS 2', 80, 5, 1, 1),
(1038, 'TPS 3', 80, 5, 1, 1),
(1039, 'TPS 4', 80, 5, 1, 1),
(1040, 'TPS 5', 80, 5, 1, 1),
(1041, 'TPS 6', 80, 5, 1, 1),
(1042, 'TPS 7', 80, 5, 1, 1),
(1043, 'TPS 8', 80, 5, 1, 1),
(1044, 'TPS 9', 80, 5, 1, 1),
(1045, 'TPS 10', 80, 5, 1, 1),
(1046, 'TPS 1', 81, 5, 1, 1),
(1047, 'TPS 2', 81, 5, 1, 1),
(1048, 'TPS 3', 81, 5, 1, 1),
(1049, 'TPS 4', 81, 5, 1, 1),
(1050, 'TPS 5', 81, 5, 1, 1),
(1051, 'TPS 6', 81, 5, 1, 1),
(1052, 'TPS 7', 81, 5, 1, 1),
(1053, 'TPS 8', 81, 5, 1, 1),
(1054, 'TPS 9', 81, 5, 1, 1),
(1055, 'TPS 10', 81, 5, 1, 1),
(1056, 'TPS 11', 81, 5, 1, 1),
(1057, 'TPS 12', 81, 5, 1, 1),
(1058, 'TPS 13', 81, 5, 1, 1),
(1059, 'TPS 14', 81, 5, 1, 1),
(1060, 'TPS 15', 81, 5, 1, 1),
(1061, 'TPS 16', 81, 5, 1, 1),
(1062, 'TPS 17', 81, 5, 1, 1),
(1063, 'TPS 1', 83, 5, 1, 1),
(1064, 'TPS 2', 83, 5, 1, 1),
(1065, 'TPS 3', 83, 5, 1, 1),
(1066, 'TPS 4', 83, 5, 1, 1),
(1067, 'TPS 5', 83, 5, 1, 1),
(1068, 'TPS 6', 83, 5, 1, 1),
(1069, 'TPS 7', 83, 5, 1, 1),
(1070, 'TPS 8', 83, 5, 1, 1),
(1071, 'TPS 9', 83, 5, 1, 1),
(1072, 'TPS 10', 83, 5, 1, 1),
(1073, 'TPS 11', 83, 5, 1, 1),
(1074, 'TPS 12', 83, 5, 1, 1),
(1075, 'TPS 13', 83, 5, 1, 1),
(1076, 'TPS 14', 83, 5, 1, 1),
(1077, 'TPS 15', 83, 5, 1, 1),
(1078, 'TPS 16', 83, 5, 1, 1),
(1079, 'TPS 17', 83, 5, 1, 1),
(1080, 'TPS 18', 83, 5, 1, 1),
(1081, 'TPS 19', 83, 5, 1, 1),
(1082, 'TPS 20', 83, 5, 1, 1),
(1083, 'TPS 21', 83, 5, 1, 1),
(1084, 'TPS 22', 83, 5, 1, 1),
(1085, 'TPS 23', 83, 5, 1, 1),
(1086, 'TPS 24', 83, 5, 1, 1),
(1087, 'TPS 25', 83, 5, 1, 1),
(1088, 'TPS 26', 83, 5, 1, 1),
(1089, 'TPS 27', 83, 5, 1, 1),
(1090, 'TPS 28', 83, 5, 1, 1),
(1091, 'TPS 1', 71, 5, 1, 1),
(1092, 'TPS 2', 71, 5, 1, 1),
(1093, 'TPS 3', 71, 5, 1, 1),
(1094, 'TPS 4', 71, 5, 1, 1),
(1095, 'TPS 5', 71, 5, 1, 1),
(1096, 'TPS 6', 71, 5, 1, 1),
(1097, 'TPS 7', 71, 5, 1, 1),
(1098, 'TPS 8', 71, 5, 1, 1),
(1099, 'TPS 9', 71, 5, 1, 1),
(1100, 'TPS 10', 71, 5, 1, 1),
(1101, 'TPS 11', 71, 5, 1, 1),
(1102, 'TPS 12', 71, 5, 1, 1),
(1103, 'TPS 13', 71, 5, 1, 1),
(1104, 'TPS 14', 71, 5, 1, 1),
(1105, 'TPS 15', 71, 5, 1, 1),
(1106, 'TPS 16', 71, 5, 1, 1),
(1107, 'TPS 1', 84, 5, 1, 1),
(1108, 'TPS 2', 84, 5, 1, 1),
(1109, 'TPS 3', 84, 5, 1, 1),
(1110, 'TPS 4', 84, 5, 1, 1),
(1111, 'TPS 5', 84, 5, 1, 1),
(1112, 'TPS 6', 84, 5, 1, 1),
(1113, 'TPS 7', 84, 5, 1, 1),
(1114, 'TPS 8', 84, 5, 1, 1),
(1115, 'TPS 9', 84, 5, 1, 1),
(1116, 'TPS 10', 84, 5, 1, 1),
(1117, 'TPS 11', 84, 5, 1, 1),
(1118, 'TPS 12', 84, 5, 1, 1),
(1119, 'TPS 1', 88, 5, 1, 1),
(1120, 'TPS 2', 88, 5, 1, 1),
(1121, 'TPS 3', 88, 5, 1, 1),
(1122, 'TPS 4', 88, 5, 1, 1),
(1123, 'TPS 5', 88, 5, 1, 1),
(1124, 'TPS 6', 88, 5, 1, 1),
(1125, 'TPS 7', 88, 5, 1, 1),
(1126, 'TPS 8', 88, 5, 1, 1),
(1127, 'TPS 9', 88, 5, 1, 1),
(1128, 'TPS 10', 88, 5, 1, 1),
(1129, 'TPS 11', 88, 5, 1, 1),
(1130, 'TPS 12', 88, 5, 1, 1),
(1131, 'TPS 13', 88, 5, 1, 1),
(1132, 'TPS 14', 88, 5, 1, 1),
(1133, 'TPS 15', 88, 5, 1, 1),
(1134, 'TPS 16', 88, 5, 1, 1),
(1135, 'TPS 17', 88, 5, 1, 1),
(1136, 'TPS 18', 88, 5, 1, 1),
(1137, 'TPS 19', 88, 5, 1, 1),
(1138, 'TPS 20', 88, 5, 1, 1),
(1139, 'TPS 1', 87, 5, 1, 1),
(1140, 'TPS 2', 87, 5, 1, 1),
(1141, 'TPS 3', 87, 5, 1, 1),
(1142, 'TPS 4', 87, 5, 1, 1),
(1143, 'TPS 5', 87, 5, 1, 1),
(1144, 'TPS 6', 87, 5, 1, 1),
(1145, 'TPS 7', 87, 5, 1, 1),
(1146, 'TPS 8', 87, 5, 1, 1),
(1147, 'TPS 9', 87, 5, 1, 1),
(1148, 'TPS 10', 87, 5, 1, 1),
(1149, 'TPS 11', 87, 5, 1, 1),
(1150, 'TPS 12', 87, 5, 1, 1),
(1151, 'TPS 13', 87, 5, 1, 1),
(1152, 'TPS 14', 87, 5, 1, 1),
(1153, 'TPS 15', 87, 5, 1, 1),
(1154, 'TPS 1', 77, 5, 1, 1),
(1155, 'TPS 2', 77, 5, 1, 1),
(1156, 'TPS 3', 77, 5, 1, 1),
(1157, 'TPS 4', 77, 5, 1, 1),
(1158, 'TPS 5', 77, 5, 1, 1),
(1159, 'TPS 6', 77, 5, 1, 1),
(1160, 'TPS 7', 77, 5, 1, 1),
(1161, 'TPS 8', 77, 5, 1, 1),
(1162, 'TPS 9', 77, 5, 1, 1),
(1163, 'TPS 10', 77, 5, 1, 1),
(1164, 'TPS 11', 77, 5, 1, 1),
(1165, 'TPS 12', 77, 5, 1, 1),
(1166, 'TPS 13', 77, 5, 1, 1),
(1167, 'TPS 1', 72, 5, 1, 1),
(1168, 'TPS 2', 72, 5, 1, 1),
(1169, 'TPS 3', 72, 5, 1, 1),
(1170, 'TPS 4', 72, 5, 1, 1),
(1171, 'TPS 5', 72, 5, 1, 1),
(1172, 'TPS 6', 72, 5, 1, 1),
(1173, 'TPS 7', 72, 5, 1, 1),
(1174, 'TPS 8', 72, 5, 1, 1),
(1175, 'TPS 9', 72, 5, 1, 1),
(1176, 'TPS 10', 72, 5, 1, 1),
(1177, 'TPS 11', 72, 5, 1, 1),
(1178, 'TPS 1', 82, 5, 1, 1),
(1179, 'TPS 2', 82, 5, 1, 1),
(1180, 'TPS 3', 82, 5, 1, 1),
(1181, 'TPS 4', 82, 5, 1, 1),
(1182, 'TPS 5', 82, 5, 1, 1),
(1183, 'TPS 6', 82, 5, 1, 1),
(1184, 'TPS 7', 82, 5, 1, 1),
(1185, 'TPS 8', 82, 5, 1, 1),
(1186, 'TPS 9', 82, 5, 1, 1),
(1187, 'TPS 10', 82, 5, 1, 1),
(1188, 'TPS 11', 82, 5, 1, 1),
(1189, 'TPS 12', 82, 5, 1, 1),
(1190, 'TPS 13', 82, 5, 1, 1),
(1191, 'TPS 14', 82, 5, 1, 1),
(1192, 'TPS 15', 82, 5, 1, 1),
(1193, 'TPS 16', 82, 5, 1, 1),
(1194, 'TPS 17', 82, 5, 1, 1),
(1195, 'TPS 1', 90, 5, 1, 1),
(1196, 'TPS 2', 90, 5, 1, 1),
(1197, 'TPS 3', 90, 5, 1, 1),
(1198, 'TPS 4', 90, 5, 1, 1),
(1199, 'TPS 5', 90, 5, 1, 1),
(1200, 'TPS 6', 90, 5, 1, 1),
(1201, 'TPS 7', 90, 5, 1, 1),
(1202, 'TPS 8', 90, 5, 1, 1),
(1203, 'TPS 9', 90, 5, 1, 1),
(1204, 'TPS 10', 90, 5, 1, 1),
(1205, 'TPS 11', 90, 5, 1, 1),
(1206, 'TPS 12', 90, 5, 1, 1),
(1207, 'TPS 1', 75, 5, 1, 1),
(1208, 'TPS 2', 75, 5, 1, 1),
(1209, 'TPS 3', 75, 5, 1, 1),
(1210, 'TPS 4', 75, 5, 1, 1),
(1211, 'TPS 5', 75, 5, 1, 1),
(1212, 'TPS 6', 75, 5, 1, 1),
(1213, 'TPS 7', 75, 5, 1, 1),
(1214, 'TPS 8', 75, 5, 1, 1),
(1215, 'TPS 9', 75, 5, 1, 1),
(1216, 'TPS 10', 75, 5, 1, 1),
(1217, 'TPS 11', 75, 5, 1, 1),
(1218, 'TPS 12', 75, 5, 1, 1),
(1219, 'TPS 13', 75, 5, 1, 1),
(1220, 'TPS 14', 75, 5, 1, 1),
(1221, 'TPS 1', 89, 5, 1, 1),
(1222, 'TPS 2', 89, 5, 1, 1),
(1223, 'TPS 3', 89, 5, 1, 1),
(1224, 'TPS 4', 89, 5, 1, 1),
(1225, 'TPS 5', 89, 5, 1, 1),
(1226, 'TPS 6', 89, 5, 1, 1),
(1227, 'TPS 7', 89, 5, 1, 1),
(1228, 'TPS 8', 89, 5, 1, 1),
(1229, 'TPS 9', 89, 5, 1, 1),
(1230, 'TPS 10', 89, 5, 1, 1),
(1231, 'TPS 11', 89, 5, 1, 1),
(1232, 'TPS 12', 89, 5, 1, 1),
(1233, 'TPS 13', 89, 5, 1, 1),
(1234, 'TPS 14', 89, 5, 1, 1),
(1235, 'TPS 15', 89, 5, 1, 1),
(1236, 'TPS 16', 89, 5, 1, 1),
(1237, 'TPS 17', 89, 5, 1, 1),
(1238, 'TPS 18', 89, 5, 1, 1),
(1239, 'TPS 19', 89, 5, 1, 1),
(1240, 'TPS 20', 89, 5, 1, 1),
(1241, 'TPS 21', 89, 5, 1, 1),
(1242, 'TPS 22', 89, 5, 1, 1),
(1243, 'TPS 23', 89, 5, 1, 1),
(1244, 'TPS 24', 89, 5, 1, 1),
(1245, 'TPS 1', 110, 6, 1, 1),
(1246, 'TPS 2', 110, 6, 1, 1),
(1247, 'TPS 3', 110, 6, 1, 1),
(1248, 'TPS 4', 110, 6, 1, 1),
(1249, 'TPS 5', 110, 6, 1, 1),
(1250, 'TPS 6', 110, 6, 1, 1),
(1251, 'TPS 7', 110, 6, 1, 1),
(1252, 'TPS 8', 110, 6, 1, 1),
(1253, 'TPS 9', 110, 6, 1, 1),
(1254, 'TPS 10', 110, 6, 1, 1),
(1255, 'TPS 11', 110, 6, 1, 1),
(1256, 'TPS 12', 110, 6, 1, 1),
(1257, 'TPS 13', 110, 6, 1, 1),
(1258, 'TPS 14', 110, 6, 1, 1),
(1259, 'TPS 15', 110, 6, 1, 1),
(1260, 'TPS 16', 110, 6, 1, 1),
(1261, 'TPS 17', 110, 6, 1, 1),
(1262, 'TPS 18', 110, 6, 1, 1),
(1263, 'TPS 19', 110, 6, 1, 1),
(1264, 'TPS 20', 110, 6, 1, 1),
(1265, 'TPS 21', 110, 6, 1, 1),
(1266, 'TPS 22', 110, 6, 1, 1),
(1267, 'TPS 23', 110, 6, 1, 1),
(1268, 'TPS 24', 110, 6, 1, 1),
(1269, 'TPS 25', 110, 6, 1, 1),
(1270, 'TPS 26', 110, 6, 1, 1),
(1271, 'TPS 27', 110, 6, 1, 1),
(1272, 'TPS 28', 110, 6, 1, 1),
(1273, 'TPS 29', 110, 6, 1, 1),
(1274, 'TPS 30', 110, 6, 1, 1),
(1275, 'TPS 31', 110, 6, 1, 1),
(1276, 'TPS 32', 110, 6, 1, 1),
(1277, 'TPS 1', 106, 6, 1, 1),
(1278, 'TPS 2', 106, 6, 1, 1),
(1279, 'TPS 3', 106, 6, 1, 1),
(1280, 'TPS 4', 106, 6, 1, 1),
(1281, 'TPS 5', 106, 6, 1, 1),
(1282, 'TPS 6', 106, 6, 1, 1),
(1283, 'TPS 7', 106, 6, 1, 1),
(1284, 'TPS 1', 107, 6, 1, 1),
(1285, 'TPS 2', 107, 6, 1, 1),
(1286, 'TPS 3', 107, 6, 1, 1),
(1287, 'TPS 4', 107, 6, 1, 1),
(1288, 'TPS 5', 107, 6, 1, 1),
(1289, 'TPS 6', 107, 6, 1, 1),
(1290, 'TPS 7', 107, 6, 1, 1),
(1291, 'TPS 8', 107, 6, 1, 1),
(1292, 'TPS 9', 107, 6, 1, 1),
(1293, 'TPS 10', 107, 6, 1, 1),
(1294, 'TPS 11', 107, 6, 1, 1),
(1295, 'TPS 12', 107, 6, 1, 1),
(1296, 'TPS 1', 102, 6, 1, 1),
(1297, 'TPS 2', 102, 6, 1, 1),
(1298, 'TPS 3', 102, 6, 1, 1),
(1299, 'TPS 4', 102, 6, 1, 1),
(1300, 'TPS 5', 102, 6, 1, 1),
(1301, 'TPS 6', 102, 6, 1, 1),
(1302, 'TPS 7', 102, 6, 1, 1),
(1303, 'TPS 8', 102, 6, 1, 1),
(1304, 'TPS 9', 102, 6, 1, 1),
(1305, 'TPS 10', 102, 6, 1, 1),
(1306, 'TPS 11', 102, 6, 1, 1),
(1307, 'TPS 12', 102, 6, 1, 1),
(1308, 'TPS 13', 102, 6, 1, 1),
(1309, 'TPS 14', 102, 6, 1, 1),
(1310, 'TPS 15', 102, 6, 1, 1),
(1311, 'TPS 16', 102, 6, 1, 1),
(1312, 'TPS 17', 102, 6, 1, 1),
(1313, 'TPS 18', 102, 6, 1, 1),
(1314, 'TPS 19', 102, 6, 1, 1),
(1315, 'TPS 20', 102, 6, 1, 1),
(1316, 'TPS 21', 102, 6, 1, 1),
(1317, 'TPS 22', 102, 6, 1, 1),
(1318, 'TPS 1', 94, 6, 1, 1),
(1319, 'TPS 2', 94, 6, 1, 1),
(1320, 'TPS 3', 94, 6, 1, 1),
(1321, 'TPS 4', 94, 6, 1, 1),
(1322, 'TPS 5', 94, 6, 1, 1),
(1323, 'TPS 6', 94, 6, 1, 1),
(1324, 'TPS 7', 94, 6, 1, 1),
(1325, 'TPS 8', 94, 6, 1, 1),
(1326, 'TPS 9', 94, 6, 1, 1),
(1327, 'TPS 10', 94, 6, 1, 1),
(1328, 'TPS 11', 94, 6, 1, 1),
(1329, 'TPS 12', 94, 6, 1, 1),
(1330, 'TPS 13', 94, 6, 1, 1),
(1331, 'TPS 14', 94, 6, 1, 1),
(1332, 'TPS 15', 94, 6, 1, 1),
(1333, 'TPS 1', 103, 6, 1, 1),
(1334, 'TPS 2', 103, 6, 1, 1),
(1335, 'TPS 3', 103, 6, 1, 1),
(1336, 'TPS 4', 103, 6, 1, 1),
(1337, 'TPS 5', 103, 6, 1, 1),
(1338, 'TPS 1', 92, 6, 1, 1),
(1339, 'TPS 2', 92, 6, 1, 1),
(1340, 'TPS 3', 92, 6, 1, 1),
(1341, 'TPS 4', 92, 6, 1, 1),
(1342, 'TPS 5', 92, 6, 1, 1),
(1343, 'TPS 1', 93, 6, 1, 1),
(1344, 'TPS 2', 93, 6, 1, 1),
(1345, 'TPS 3', 93, 6, 1, 1),
(1346, 'TPS 4', 93, 6, 1, 1),
(1347, 'TPS 5', 93, 6, 1, 1),
(1348, 'TPS 6', 93, 6, 1, 1),
(1349, 'TPS 7', 93, 6, 1, 1),
(1350, 'TPS 8', 93, 6, 1, 1),
(1351, 'TPS 9', 93, 6, 1, 1),
(1352, 'TPS 10', 93, 6, 1, 1),
(1353, 'TPS 11', 93, 6, 1, 1),
(1354, 'TPS 12', 93, 6, 1, 1),
(1355, 'TPS 13', 93, 6, 1, 1),
(1356, 'TPS 14', 93, 6, 1, 1),
(1357, 'TPS 15', 93, 6, 1, 1),
(1358, 'TPS 16', 93, 6, 1, 1),
(1359, 'TPS 17', 93, 6, 1, 1),
(1360, 'TPS 18', 93, 6, 1, 1),
(1361, 'TPS 19', 93, 6, 1, 1),
(1362, 'TPS 20', 93, 6, 1, 1),
(1363, 'TPS 21', 93, 6, 1, 1),
(1364, 'TPS 22', 93, 6, 1, 1),
(1365, 'TPS 1', 95, 6, 1, 1),
(1366, 'TPS 2', 95, 6, 1, 1),
(1367, 'TPS 3', 95, 6, 1, 1),
(1368, 'TPS 4', 95, 6, 1, 1),
(1369, 'TPS 5', 95, 6, 1, 1),
(1370, 'TPS 6', 95, 6, 1, 1),
(1371, 'TPS 7', 95, 6, 1, 1),
(1372, 'TPS 8', 95, 6, 1, 1),
(1373, 'TPS 9', 95, 6, 1, 1),
(1374, 'TPS 10', 95, 6, 1, 1),
(1375, 'TPS 11', 95, 6, 1, 1),
(1376, 'TPS 12', 95, 6, 1, 1),
(1377, 'TPS 13', 95, 6, 1, 1),
(1378, 'TPS 14', 95, 6, 1, 1),
(1379, 'TPS 15', 95, 6, 1, 1),
(1380, 'TPS 16', 95, 6, 1, 1),
(1381, 'TPS 17', 95, 6, 1, 1),
(1382, 'TPS 18', 95, 6, 1, 1),
(1383, 'TPS 19', 95, 6, 1, 1),
(1384, 'TPS 20', 95, 6, 1, 1),
(1385, 'TPS 1', 109, 6, 1, 1),
(1386, 'TPS 2', 109, 6, 1, 1),
(1387, 'TPS 3', 109, 6, 1, 1),
(1388, 'TPS 4', 109, 6, 1, 1),
(1389, 'TPS 5', 109, 6, 1, 1),
(1390, 'TPS 6', 109, 6, 1, 1),
(1391, 'TPS 7', 109, 6, 1, 1),
(1392, 'TPS 1', 96, 6, 1, 1),
(1393, 'TPS 2', 96, 6, 1, 1),
(1394, 'TPS 3', 96, 6, 1, 1),
(1395, 'TPS 4', 96, 6, 1, 1),
(1396, 'TPS 5', 96, 6, 1, 1),
(1397, 'TPS 6', 96, 6, 1, 1),
(1398, 'TPS 7', 96, 6, 1, 1),
(1399, 'TPS 8', 96, 6, 1, 1),
(1400, 'TPS 9', 96, 6, 1, 1),
(1401, 'TPS 10', 96, 6, 1, 1),
(1402, 'TPS 11', 96, 6, 1, 1),
(1403, 'TPS 12', 96, 6, 1, 1),
(1404, 'TPS 13', 96, 6, 1, 1),
(1405, 'TPS 14', 96, 6, 1, 1),
(1406, 'TPS 15', 96, 6, 1, 1),
(1407, 'TPS 1', 98, 6, 1, 1),
(1408, 'TPS 2', 98, 6, 1, 1),
(1409, 'TPS 3', 98, 6, 1, 1),
(1410, 'TPS 4', 98, 6, 1, 1),
(1411, 'TPS 5', 98, 6, 1, 1),
(1412, 'TPS 6', 98, 6, 1, 1),
(1413, 'TPS 7', 98, 6, 1, 1),
(1414, 'TPS 8', 98, 6, 1, 1),
(1415, 'TPS 1', 97, 6, 1, 1),
(1416, 'TPS 2', 97, 6, 1, 1),
(1417, 'TPS 3', 97, 6, 1, 1),
(1418, 'TPS 4', 97, 6, 1, 1),
(1419, 'TPS 5', 97, 6, 1, 1),
(1420, 'TPS 6', 97, 6, 1, 1),
(1421, 'TPS 7', 97, 6, 1, 1),
(1422, 'TPS 8', 97, 6, 1, 1),
(1423, 'TPS 9', 97, 6, 1, 1),
(1424, 'TPS 10', 97, 6, 1, 1),
(1425, 'TPS 11', 97, 6, 1, 1),
(1426, 'TPS 12', 97, 6, 1, 1),
(1427, 'TPS 13', 97, 6, 1, 1),
(1428, 'TPS 14', 97, 6, 1, 1),
(1429, 'TPS 1', 105, 6, 1, 1),
(1430, 'TPS 2', 105, 6, 1, 1),
(1431, 'TPS 3', 105, 6, 1, 1),
(1432, 'TPS 4', 105, 6, 1, 1),
(1433, 'TPS 5', 105, 6, 1, 1),
(1434, 'TPS 1', 91, 6, 1, 1),
(1435, 'TPS 2', 91, 6, 1, 1),
(1436, 'TPS 3', 91, 6, 1, 1),
(1437, 'TPS 4', 91, 6, 1, 1),
(1438, 'TPS 5', 91, 6, 1, 1),
(1439, 'TPS 6', 91, 6, 1, 1),
(1440, 'TPS 7', 91, 6, 1, 1),
(1441, 'TPS 8', 91, 6, 1, 1),
(1442, 'TPS 9', 91, 6, 1, 1),
(1443, 'TPS 10', 91, 6, 1, 1),
(1444, 'TPS 11', 91, 6, 1, 1),
(1445, 'TPS 12', 91, 6, 1, 1),
(1446, 'TPS 13', 91, 6, 1, 1),
(1447, 'TPS 14', 91, 6, 1, 1),
(1448, 'TPS 15', 91, 6, 1, 1),
(1449, 'TPS 16', 91, 6, 1, 1),
(1450, 'TPS 17', 91, 6, 1, 1),
(1451, 'TPS 1', 104, 6, 1, 1),
(1452, 'TPS 2', 104, 6, 1, 1),
(1453, 'TPS 3', 104, 6, 1, 1),
(1454, 'TPS 4', 104, 6, 1, 1),
(1455, 'TPS 5', 104, 6, 1, 1),
(1456, 'TPS 6', 104, 6, 1, 1),
(1457, 'TPS 7', 104, 6, 1, 1),
(1458, 'TPS 8', 104, 6, 1, 1),
(1459, 'TPS 9', 104, 6, 1, 1),
(1460, 'TPS 10', 104, 6, 1, 1),
(1461, 'TPS 11', 104, 6, 1, 1),
(1462, 'TPS 1', 108, 6, 1, 1),
(1463, 'TPS 2', 108, 6, 1, 1),
(1464, 'TPS 3', 108, 6, 1, 1),
(1465, 'TPS 4', 108, 6, 1, 1),
(1466, 'TPS 5', 108, 6, 1, 1),
(1467, 'TPS 6', 108, 6, 1, 1),
(1468, 'TPS 7', 108, 6, 1, 1),
(1469, 'TPS 8', 108, 6, 1, 1),
(1470, 'TPS 9', 108, 6, 1, 1),
(1471, 'TPS 1', 101, 6, 1, 1),
(1472, 'TPS 2', 101, 6, 1, 1),
(1473, 'TPS 3', 101, 6, 1, 1),
(1474, 'TPS 4', 101, 6, 1, 1),
(1475, 'TPS 5', 101, 6, 1, 1),
(1476, 'TPS 1', 100, 6, 1, 1),
(1477, 'TPS 2', 100, 6, 1, 1),
(1478, 'TPS 3', 100, 6, 1, 1),
(1479, 'TPS 4', 100, 6, 1, 1),
(1480, 'TPS 5', 100, 6, 1, 1),
(1481, 'TPS 6', 100, 6, 1, 1),
(1482, 'TPS 7', 100, 6, 1, 1),
(1483, 'TPS 8', 100, 6, 1, 1),
(1484, 'TPS 9', 100, 6, 1, 1),
(1485, 'TPS 10', 100, 6, 1, 1),
(1486, 'TPS 11', 100, 6, 1, 1),
(1487, 'TPS 12', 100, 6, 1, 1),
(1488, 'TPS 1', 99, 6, 1, 1),
(1489, 'TPS 2', 99, 6, 1, 1),
(1490, 'TPS 3', 99, 6, 1, 1),
(1491, 'TPS 4', 99, 6, 1, 1),
(1492, 'TPS 5', 99, 6, 1, 1),
(1493, 'TPS 6', 99, 6, 1, 1),
(1494, 'TPS 7', 99, 6, 1, 1),
(1495, 'TPS 8', 99, 6, 1, 1),
(1496, 'TPS 1', 124, 7, 1, 1),
(1497, 'TPS 2', 124, 7, 1, 1),
(1498, 'TPS 3', 124, 7, 1, 1),
(1499, 'TPS 4', 124, 7, 1, 1),
(1500, 'TPS 5', 124, 7, 1, 1),
(1501, 'TPS 1', 115, 7, 1, 1),
(1502, 'TPS 2', 115, 7, 1, 1),
(1503, 'TPS 3', 115, 7, 1, 1),
(1504, 'TPS 4', 115, 7, 1, 1),
(1505, 'TPS 5', 115, 7, 1, 1),
(1506, 'TPS 6', 115, 7, 1, 1),
(1507, 'TPS 7', 115, 7, 1, 1),
(1508, 'TPS 8', 115, 7, 1, 1),
(1509, 'TPS 9', 115, 7, 1, 1),
(1510, 'TPS 10', 115, 7, 1, 1),
(1511, 'TPS 11', 115, 7, 1, 1),
(1512, 'TPS 1', 116, 7, 1, 1),
(1513, 'TPS 2', 116, 7, 1, 1),
(1514, 'TPS 3', 116, 7, 1, 1),
(1515, 'TPS 4', 116, 7, 1, 1),
(1516, 'TPS 5', 116, 7, 1, 1),
(1517, 'TPS 6', 116, 7, 1, 1),
(1518, 'TPS 7', 116, 7, 1, 1),
(1519, 'TPS 8', 116, 7, 1, 1),
(1520, 'TPS 9', 116, 7, 1, 1),
(1521, 'TPS 10', 116, 7, 1, 1),
(1522, 'TPS 11', 116, 7, 1, 1),
(1523, 'TPS 12', 116, 7, 1, 1),
(1524, 'TPS 13', 116, 7, 1, 1),
(1525, 'TPS 14', 116, 7, 1, 1),
(1526, 'TPS 15', 116, 7, 1, 1),
(1527, 'TPS 16', 116, 7, 1, 1),
(1528, 'TPS 17', 116, 7, 1, 1),
(1529, 'TPS 1', 114, 7, 1, 1),
(1530, 'TPS 2', 114, 7, 1, 1),
(1531, 'TPS 3', 114, 7, 1, 1),
(1532, 'TPS 4', 114, 7, 1, 1),
(1533, 'TPS 5', 114, 7, 1, 1),
(1534, 'TPS 6', 114, 7, 1, 1),
(1535, 'TPS 7', 114, 7, 1, 1),
(1536, 'TPS 8', 114, 7, 1, 1),
(1537, 'TPS 9', 114, 7, 1, 1),
(1538, 'TPS 10', 114, 7, 1, 1),
(1539, 'TPS 11', 114, 7, 1, 1),
(1540, 'TPS 1', 121, 7, 1, 1),
(1541, 'TPS 2', 121, 7, 1, 1),
(1542, 'TPS 3', 121, 7, 1, 1),
(1543, 'TPS 4', 121, 7, 1, 1),
(1544, 'TPS 5', 121, 7, 1, 1),
(1545, 'TPS 6', 121, 7, 1, 1),
(1546, 'TPS 1', 126, 7, 1, 1),
(1547, 'TPS 2', 126, 7, 1, 1),
(1548, 'TPS 3', 126, 7, 1, 1),
(1549, 'TPS 4', 126, 7, 1, 1),
(1550, 'TPS 5', 126, 7, 1, 1),
(1551, 'TPS 6', 126, 7, 1, 1),
(1552, 'TPS 7', 126, 7, 1, 1),
(1553, 'TPS 8', 126, 7, 1, 1),
(1554, 'TPS 9', 126, 7, 1, 1),
(1555, 'TPS 10', 126, 7, 1, 1),
(1556, 'TPS 1', 128, 7, 1, 1),
(1557, 'TPS 2', 128, 7, 1, 1),
(1558, 'TPS 3', 128, 7, 1, 1),
(1559, 'TPS 4', 128, 7, 1, 1),
(1560, 'TPS 5', 128, 7, 1, 1),
(1561, 'TPS 6', 128, 7, 1, 1),
(1562, 'TPS 7', 128, 7, 1, 1),
(1563, 'TPS 8', 128, 7, 1, 1),
(1564, 'TPS 9', 128, 7, 1, 1),
(1565, 'TPS 1', 117, 7, 1, 1),
(1566, 'TPS 2', 117, 7, 1, 1),
(1567, 'TPS 3', 117, 7, 1, 1),
(1568, 'TPS 4', 117, 7, 1, 1),
(1569, 'TPS 5', 117, 7, 1, 1),
(1570, 'TPS 6', 117, 7, 1, 1),
(1571, 'TPS 7', 117, 7, 1, 1),
(1572, 'TPS 8', 117, 7, 1, 1),
(1573, 'TPS 1', 118, 7, 1, 1),
(1574, 'TPS 2', 118, 7, 1, 1),
(1575, 'TPS 3', 118, 7, 1, 1),
(1576, 'TPS 4', 118, 7, 1, 1),
(1577, 'TPS 5', 118, 7, 1, 1),
(1578, 'TPS 6', 118, 7, 1, 1),
(1579, 'TPS 7', 118, 7, 1, 1),
(1580, 'TPS 8', 118, 7, 1, 1),
(1581, 'TPS 9', 118, 7, 1, 1),
(1582, 'TPS 1', 125, 7, 1, 1),
(1583, 'TPS 2', 125, 7, 1, 1),
(1584, 'TPS 3', 125, 7, 1, 1),
(1585, 'TPS 4', 125, 7, 1, 1),
(1586, 'TPS 5', 125, 7, 1, 1),
(1587, 'TPS 6', 125, 7, 1, 1),
(1588, 'TPS 7', 125, 7, 1, 1),
(1589, 'TPS 8', 125, 7, 1, 1),
(1590, 'TPS 1', 111, 7, 1, 1),
(1591, 'TPS 2', 111, 7, 1, 1),
(1592, 'TPS 3', 111, 7, 1, 1),
(1593, 'TPS 4', 111, 7, 1, 1),
(1594, 'TPS 5', 111, 7, 1, 1),
(1595, 'TPS 6', 111, 7, 1, 1),
(1596, 'TPS 7', 111, 7, 1, 1),
(1597, 'TPS 8', 111, 7, 1, 1),
(1598, 'TPS 9', 111, 7, 1, 1),
(1599, 'TPS 10', 111, 7, 1, 1),
(1600, 'TPS 11', 111, 7, 1, 1),
(1601, 'TPS 12', 111, 7, 1, 1),
(1602, 'TPS 1', 112, 7, 1, 1),
(1603, 'TPS 2', 112, 7, 1, 1),
(1604, 'TPS 3', 112, 7, 1, 1),
(1605, 'TPS 4', 112, 7, 1, 1),
(1606, 'TPS 1', 113, 7, 1, 1),
(1607, 'TPS 2', 113, 7, 1, 1),
(1608, 'TPS 3', 113, 7, 1, 1),
(1609, 'TPS 4', 113, 7, 1, 1),
(1610, 'TPS 5', 113, 7, 1, 1),
(1611, 'TPS 6', 113, 7, 1, 1),
(1612, 'TPS 7', 113, 7, 1, 1),
(1613, 'TPS 8', 113, 7, 1, 1),
(1614, 'TPS 9', 113, 7, 1, 1),
(1615, 'TPS 10', 113, 7, 1, 1),
(1616, 'TPS 11', 113, 7, 1, 1),
(1617, 'TPS 12', 113, 7, 1, 1),
(1618, 'TPS 1', 123, 7, 1, 1),
(1619, 'TPS 2', 123, 7, 1, 1),
(1620, 'TPS 3', 123, 7, 1, 1),
(1621, 'TPS 4', 123, 7, 1, 1),
(1622, 'TPS 5', 123, 7, 1, 1),
(1623, 'TPS 6', 123, 7, 1, 1),
(1624, 'TPS 7', 123, 7, 1, 1),
(1625, 'TPS 8', 123, 7, 1, 1),
(1626, 'TPS 9', 123, 7, 1, 1),
(1627, 'TPS 10', 123, 7, 1, 1),
(1628, 'TPS 11', 123, 7, 1, 1),
(1629, 'TPS 12', 123, 7, 1, 1),
(1630, 'TPS 13', 123, 7, 1, 1),
(1631, 'TPS 1', 119, 7, 1, 1),
(1632, 'TPS 2', 119, 7, 1, 1),
(1633, 'TPS 3', 119, 7, 1, 1),
(1634, 'TPS 4', 119, 7, 1, 1),
(1635, 'TPS 5', 119, 7, 1, 1),
(1636, 'TPS 6', 119, 7, 1, 1),
(1637, 'TPS 7', 119, 7, 1, 1),
(1638, 'TPS 8', 119, 7, 1, 1),
(1639, 'TPS 9', 119, 7, 1, 1),
(1640, 'TPS 1', 122, 7, 1, 1),
(1641, 'TPS 2', 122, 7, 1, 1),
(1642, 'TPS 3', 122, 7, 1, 1),
(1643, 'TPS 4', 122, 7, 1, 1),
(1644, 'TPS 5', 122, 7, 1, 1),
(1645, 'TPS 6', 122, 7, 1, 1),
(1646, 'TPS 7', 122, 7, 1, 1),
(1647, 'TPS 8', 122, 7, 1, 1),
(1648, 'TPS 1', 120, 7, 1, 1),
(1649, 'TPS 2', 120, 7, 1, 1),
(1650, 'TPS 3', 120, 7, 1, 1),
(1651, 'TPS 4', 120, 7, 1, 1),
(1652, 'TPS 5', 120, 7, 1, 1),
(1653, 'TPS 1', 127, 7, 1, 1),
(1654, 'TPS 2', 127, 7, 1, 1),
(1655, 'TPS 3', 127, 7, 1, 1),
(1656, 'TPS 4', 127, 7, 1, 1),
(1657, 'TPS 5', 127, 7, 1, 1),
(1658, 'TPS 6', 127, 7, 1, 1),
(1659, 'TPS 1', 132, 8, 1, 1),
(1660, 'TPS 2', 132, 8, 1, 1),
(1661, 'TPS 3', 132, 8, 1, 1),
(1662, 'TPS 4', 132, 8, 1, 1),
(1663, 'TPS 5', 132, 8, 1, 1),
(1664, 'TPS 6', 132, 8, 1, 1),
(1665, 'TPS 7', 132, 8, 1, 1),
(1666, 'TPS 8', 132, 8, 1, 1),
(1667, 'TPS 9', 132, 8, 1, 1),
(1668, 'TPS 10', 132, 8, 1, 1),
(1669, 'TPS 11', 132, 8, 1, 1),
(1670, 'TPS 12', 132, 8, 1, 1),
(1671, 'TPS 13', 132, 8, 1, 1),
(1672, 'TPS 1', 138, 8, 1, 1),
(1673, 'TPS 2', 138, 8, 1, 1),
(1674, 'TPS 3', 138, 8, 1, 1),
(1675, 'TPS 4', 138, 8, 1, 1),
(1676, 'TPS 5', 138, 8, 1, 1),
(1677, 'TPS 6', 138, 8, 1, 1),
(1678, 'TPS 7', 138, 8, 1, 1),
(1679, 'TPS 8', 138, 8, 1, 1),
(1680, 'TPS 9', 138, 8, 1, 1),
(1681, 'TPS 10', 138, 8, 1, 1),
(1682, 'TPS 11', 138, 8, 1, 1),
(1683, 'TPS 12', 138, 8, 1, 1),
(1684, 'TPS 13', 138, 8, 1, 1),
(1685, 'TPS 14', 138, 8, 1, 1),
(1686, 'TPS 15', 138, 8, 1, 1),
(1687, 'TPS 16', 138, 8, 1, 1),
(1688, 'TPS 17', 138, 8, 1, 1),
(1689, 'TPS 18', 138, 8, 1, 1),
(1690, 'TPS 19', 138, 8, 1, 1),
(1691, 'TPS 20', 138, 8, 1, 1),
(1692, 'TPS 21', 138, 8, 1, 1),
(1693, 'TPS 22', 138, 8, 1, 1),
(1694, 'TPS 23', 138, 8, 1, 1),
(1695, 'TPS 24', 138, 8, 1, 1),
(1696, 'TPS 25', 138, 8, 1, 1),
(1697, 'TPS 26', 138, 8, 1, 1),
(1698, 'TPS 27', 138, 8, 1, 1),
(1699, 'TPS 28', 138, 8, 1, 1),
(1700, 'TPS 29', 138, 8, 1, 1),
(1701, 'TPS 30', 138, 8, 1, 1),
(1702, 'TPS 1', 144, 8, 1, 1),
(1703, 'TPS 2', 144, 8, 1, 1),
(1704, 'TPS 3', 144, 8, 1, 1),
(1705, 'TPS 4', 144, 8, 1, 1),
(1706, 'TPS 5', 144, 8, 1, 1),
(1707, 'TPS 6', 144, 8, 1, 1),
(1708, 'TPS 7', 144, 8, 1, 1),
(1709, 'TPS 8', 144, 8, 1, 1),
(1710, 'TPS 9', 144, 8, 1, 1),
(1711, 'TPS 10', 144, 8, 1, 1),
(1712, 'TPS 11', 144, 8, 1, 1),
(1713, 'TPS 12', 144, 8, 1, 1),
(1714, 'TPS 13', 144, 8, 1, 1),
(1715, 'TPS 14', 144, 8, 1, 1),
(1716, 'TPS 15', 144, 8, 1, 1),
(1717, 'TPS 16', 144, 8, 1, 1),
(1718, 'TPS 17', 144, 8, 1, 1),
(1719, 'TPS 18', 144, 8, 1, 1),
(1720, 'TPS 19', 144, 8, 1, 1),
(1721, 'TPS 20', 144, 8, 1, 1),
(1722, 'TPS 1', 131, 8, 1, 1),
(1723, 'TPS 2', 131, 8, 1, 1),
(1724, 'TPS 3', 131, 8, 1, 1),
(1725, 'TPS 4', 131, 8, 1, 1),
(1726, 'TPS 5', 131, 8, 1, 1),
(1727, 'TPS 6', 131, 8, 1, 1),
(1728, 'TPS 7', 131, 8, 1, 1),
(1729, 'TPS 8', 131, 8, 1, 1),
(1730, 'TPS 1', 130, 8, 1, 1),
(1731, 'TPS 2', 130, 8, 1, 1),
(1732, 'TPS 3', 130, 8, 1, 1),
(1733, 'TPS 4', 130, 8, 1, 1),
(1734, 'TPS 5', 130, 8, 1, 1),
(1735, 'TPS 6', 130, 8, 1, 1),
(1736, 'TPS 7', 130, 8, 1, 1),
(1737, 'TPS 8', 130, 8, 1, 1),
(1738, 'TPS 9', 130, 8, 1, 1),
(1739, 'TPS 10', 130, 8, 1, 1),
(1740, 'TPS 11', 130, 8, 1, 1),
(1741, 'TPS 12', 130, 8, 1, 1),
(1742, 'TPS 13', 130, 8, 1, 1),
(1743, 'TPS 14', 130, 8, 1, 1),
(1744, 'TPS 15', 130, 8, 1, 1),
(1745, 'TPS 1', 141, 8, 1, 1),
(1746, 'TPS 2', 141, 8, 1, 1),
(1747, 'TPS 3', 141, 8, 1, 1),
(1748, 'TPS 4', 141, 8, 1, 1),
(1749, 'TPS 5', 141, 8, 1, 1),
(1750, 'TPS 6', 141, 8, 1, 1),
(1751, 'TPS 7', 141, 8, 1, 1),
(1752, 'TPS 8', 141, 8, 1, 1),
(1753, 'TPS 9', 141, 8, 1, 1),
(1754, 'TPS 1', 142, 8, 1, 1),
(1755, 'TPS 2', 142, 8, 1, 1),
(1756, 'TPS 3', 142, 8, 1, 1),
(1757, 'TPS 4', 142, 8, 1, 1),
(1758, 'TPS 5', 142, 8, 1, 1),
(1759, 'TPS 6', 142, 8, 1, 1),
(1760, 'TPS 7', 142, 8, 1, 1),
(1761, 'TPS 8', 142, 8, 1, 1),
(1762, 'TPS 1', 140, 8, 1, 1),
(1763, 'TPS 2', 140, 8, 1, 1),
(1764, 'TPS 3', 140, 8, 1, 1),
(1765, 'TPS 4', 140, 8, 1, 1),
(1766, 'TPS 5', 140, 8, 1, 1),
(1767, 'TPS 6', 140, 8, 1, 1),
(1768, 'TPS 7', 140, 8, 1, 1),
(1769, 'TPS 1', 136, 8, 1, 1),
(1770, 'TPS 2', 136, 8, 1, 1),
(1771, 'TPS 3', 136, 8, 1, 1),
(1772, 'TPS 4', 136, 8, 1, 1),
(1773, 'TPS 5', 136, 8, 1, 1),
(1774, 'TPS 6', 136, 8, 1, 1),
(1775, 'TPS 7', 136, 8, 1, 1),
(1776, 'TPS 8', 136, 8, 1, 1),
(1777, 'TPS 9', 136, 8, 1, 1),
(1778, 'TPS 10', 136, 8, 1, 1),
(1779, 'TPS 11', 136, 8, 1, 1),
(1780, 'TPS 12', 136, 8, 1, 1),
(1781, 'TPS 13', 136, 8, 1, 1),
(1782, 'TPS 1', 139, 8, 1, 1),
(1783, 'TPS 2', 139, 8, 1, 1),
(1784, 'TPS 3', 139, 8, 1, 1),
(1785, 'TPS 4', 139, 8, 1, 1),
(1786, 'TPS 5', 139, 8, 1, 1),
(1787, 'TPS 6', 139, 8, 1, 1),
(1788, 'TPS 7', 139, 8, 1, 1),
(1789, 'TPS 8', 139, 8, 1, 1),
(1790, 'TPS 1', 145, 8, 1, 1),
(1791, 'TPS 2', 145, 8, 1, 1);
INSERT INTO `tps` (`id`, `tps`, `id_kel`, `id_kec`, `id_kab`, `id_prov`) VALUES
(1792, 'TPS 3', 145, 8, 1, 1),
(1793, 'TPS 4', 145, 8, 1, 1),
(1794, 'TPS 5', 145, 8, 1, 1),
(1795, 'TPS 6', 145, 8, 1, 1),
(1796, 'TPS 7', 145, 8, 1, 1),
(1797, 'TPS 8', 145, 8, 1, 1),
(1798, 'TPS 9', 145, 8, 1, 1),
(1799, 'TPS 10', 145, 8, 1, 1),
(1800, 'TPS 11', 145, 8, 1, 1),
(1801, 'TPS 12', 145, 8, 1, 1),
(1802, 'TPS 13', 145, 8, 1, 1),
(1803, 'TPS 14', 145, 8, 1, 1),
(1804, 'TPS 15', 145, 8, 1, 1),
(1805, 'TPS 16', 145, 8, 1, 1),
(1806, 'TPS 17', 145, 8, 1, 1),
(1807, 'TPS 18', 145, 8, 1, 1),
(1808, 'TPS 1', 133, 8, 1, 1),
(1809, 'TPS 2', 133, 8, 1, 1),
(1810, 'TPS 3', 133, 8, 1, 1),
(1811, 'TPS 4', 133, 8, 1, 1),
(1812, 'TPS 5', 133, 8, 1, 1),
(1813, 'TPS 6', 133, 8, 1, 1),
(1814, 'TPS 7', 133, 8, 1, 1),
(1815, 'TPS 8', 133, 8, 1, 1),
(1816, 'TPS 9', 133, 8, 1, 1),
(1817, 'TPS 10', 133, 8, 1, 1),
(1818, 'TPS 11', 133, 8, 1, 1),
(1819, 'TPS 12', 133, 8, 1, 1),
(1820, 'TPS 13', 133, 8, 1, 1),
(1821, 'TPS 14', 133, 8, 1, 1),
(1822, 'TPS 15', 133, 8, 1, 1),
(1823, 'TPS 16', 133, 8, 1, 1),
(1824, 'TPS 17', 133, 8, 1, 1),
(1825, 'TPS 18', 133, 8, 1, 1),
(1826, 'TPS 19', 133, 8, 1, 1),
(1827, 'TPS 1', 134, 8, 1, 1),
(1828, 'TPS 2', 134, 8, 1, 1),
(1829, 'TPS 3', 134, 8, 1, 1),
(1830, 'TPS 4', 134, 8, 1, 1),
(1831, 'TPS 5', 134, 8, 1, 1),
(1832, 'TPS 6', 134, 8, 1, 1),
(1833, 'TPS 7', 134, 8, 1, 1),
(1834, 'TPS 8', 134, 8, 1, 1),
(1835, 'TPS 9', 134, 8, 1, 1),
(1836, 'TPS 10', 134, 8, 1, 1),
(1837, 'TPS 11', 134, 8, 1, 1),
(1838, 'TPS 12', 134, 8, 1, 1),
(1839, 'TPS 13', 134, 8, 1, 1),
(1840, 'TPS 14', 134, 8, 1, 1),
(1841, 'TPS 15', 134, 8, 1, 1),
(1842, 'TPS 16', 134, 8, 1, 1),
(1843, 'TPS 17', 134, 8, 1, 1),
(1844, 'TPS 18', 134, 8, 1, 1),
(1845, 'TPS 19', 134, 8, 1, 1),
(1846, 'TPS 20', 134, 8, 1, 1),
(1847, 'TPS 1', 135, 8, 1, 1),
(1848, 'TPS 2', 135, 8, 1, 1),
(1849, 'TPS 3', 135, 8, 1, 1),
(1850, 'TPS 4', 135, 8, 1, 1),
(1851, 'TPS 5', 135, 8, 1, 1),
(1852, 'TPS 6', 135, 8, 1, 1),
(1853, 'TPS 7', 135, 8, 1, 1),
(1854, 'TPS 8', 135, 8, 1, 1),
(1855, 'TPS 9', 135, 8, 1, 1),
(1856, 'TPS 10', 135, 8, 1, 1),
(1857, 'TPS 11', 135, 8, 1, 1),
(1858, 'TPS 12', 135, 8, 1, 1),
(1859, 'TPS 13', 135, 8, 1, 1),
(1860, 'TPS 14', 135, 8, 1, 1),
(1861, 'TPS 15', 135, 8, 1, 1),
(1862, 'TPS 16', 135, 8, 1, 1),
(1863, 'TPS 17', 135, 8, 1, 1),
(1864, 'TPS 18', 135, 8, 1, 1),
(1865, 'TPS 1', 129, 8, 1, 1),
(1866, 'TPS 2', 129, 8, 1, 1),
(1867, 'TPS 3', 129, 8, 1, 1),
(1868, 'TPS 4', 129, 8, 1, 1),
(1869, 'TPS 5', 129, 8, 1, 1),
(1870, 'TPS 6', 129, 8, 1, 1),
(1871, 'TPS 7', 129, 8, 1, 1),
(1872, 'TPS 8', 129, 8, 1, 1),
(1873, 'TPS 9', 129, 8, 1, 1),
(1874, 'TPS 10', 129, 8, 1, 1),
(1875, 'TPS 11', 129, 8, 1, 1),
(1876, 'TPS 12', 129, 8, 1, 1),
(1877, 'TPS 1', 143, 8, 1, 1),
(1878, 'TPS 2', 143, 8, 1, 1),
(1879, 'TPS 3', 143, 8, 1, 1),
(1880, 'TPS 4', 143, 8, 1, 1),
(1881, 'TPS 5', 143, 8, 1, 1),
(1882, 'TPS 6', 143, 8, 1, 1),
(1883, 'TPS 7', 143, 8, 1, 1),
(1884, 'TPS 8', 143, 8, 1, 1),
(1885, 'TPS 9', 143, 8, 1, 1),
(1886, 'TPS 10', 143, 8, 1, 1),
(1887, 'TPS 1', 137, 8, 1, 1),
(1888, 'TPS 2', 137, 8, 1, 1),
(1889, 'TPS 3', 137, 8, 1, 1),
(1890, 'TPS 4', 137, 8, 1, 1),
(1891, 'TPS 5', 137, 8, 1, 1),
(1892, 'TPS 6', 137, 8, 1, 1),
(1893, 'TPS 7', 137, 8, 1, 1),
(1894, 'TPS 8', 137, 8, 1, 1),
(1895, 'TPS 9', 137, 8, 1, 1),
(1896, 'TPS 10', 137, 8, 1, 1),
(1897, 'TPS 11', 137, 8, 1, 1),
(1898, 'TPS 12', 137, 8, 1, 1),
(1899, 'TPS 1', 150, 9, 1, 1),
(1900, 'TPS 2', 150, 9, 1, 1),
(1901, 'TPS 3', 150, 9, 1, 1),
(1902, 'TPS 4', 150, 9, 1, 1),
(1903, 'TPS 5', 150, 9, 1, 1),
(1904, 'TPS 6', 150, 9, 1, 1),
(1905, 'TPS 7', 150, 9, 1, 1),
(1906, 'TPS 8', 150, 9, 1, 1),
(1907, 'TPS 9', 150, 9, 1, 1),
(1908, 'TPS 10', 150, 9, 1, 1),
(1909, 'TPS 11', 150, 9, 1, 1),
(1910, 'TPS 12', 150, 9, 1, 1),
(1911, 'TPS 13', 150, 9, 1, 1),
(1912, 'TPS 14', 150, 9, 1, 1),
(1913, 'TPS 1', 156, 9, 1, 1),
(1914, 'TPS 2', 156, 9, 1, 1),
(1915, 'TPS 3', 156, 9, 1, 1),
(1916, 'TPS 4', 156, 9, 1, 1),
(1917, 'TPS 5', 156, 9, 1, 1),
(1918, 'TPS 6', 156, 9, 1, 1),
(1919, 'TPS 7', 156, 9, 1, 1),
(1920, 'TPS 8', 156, 9, 1, 1),
(1921, 'TPS 9', 156, 9, 1, 1),
(1922, 'TPS 10', 156, 9, 1, 1),
(1923, 'TPS 11', 156, 9, 1, 1),
(1924, 'TPS 12', 156, 9, 1, 1),
(1925, 'TPS 13', 156, 9, 1, 1),
(1926, 'TPS 1', 153, 9, 1, 1),
(1927, 'TPS 2', 153, 9, 1, 1),
(1928, 'TPS 3', 153, 9, 1, 1),
(1929, 'TPS 4', 153, 9, 1, 1),
(1930, 'TPS 5', 153, 9, 1, 1),
(1931, 'TPS 6', 153, 9, 1, 1),
(1932, 'TPS 7', 153, 9, 1, 1),
(1933, 'TPS 8', 153, 9, 1, 1),
(1934, 'TPS 9', 153, 9, 1, 1),
(1935, 'TPS 10', 153, 9, 1, 1),
(1936, 'TPS 11', 153, 9, 1, 1),
(1937, 'TPS 12', 153, 9, 1, 1),
(1938, 'TPS 13', 153, 9, 1, 1),
(1939, 'TPS 14', 153, 9, 1, 1),
(1940, 'TPS 15', 153, 9, 1, 1),
(1941, 'TPS 16', 153, 9, 1, 1),
(1942, 'TPS 17', 153, 9, 1, 1),
(1943, 'TPS 18', 153, 9, 1, 1),
(1944, 'TPS 19', 153, 9, 1, 1),
(1945, 'TPS 20', 153, 9, 1, 1),
(1946, 'TPS 21', 153, 9, 1, 1),
(1947, 'TPS 22', 153, 9, 1, 1),
(1948, 'TPS 1', 147, 9, 1, 1),
(1949, 'TPS 2', 147, 9, 1, 1),
(1950, 'TPS 3', 147, 9, 1, 1),
(1951, 'TPS 4', 147, 9, 1, 1),
(1952, 'TPS 5', 147, 9, 1, 1),
(1953, 'TPS 6', 147, 9, 1, 1),
(1954, 'TPS 7', 147, 9, 1, 1),
(1955, 'TPS 8', 147, 9, 1, 1),
(1956, 'TPS 9', 147, 9, 1, 1),
(1957, 'TPS 10', 147, 9, 1, 1),
(1958, 'TPS 11', 147, 9, 1, 1),
(1959, 'TPS 1', 155, 9, 1, 1),
(1960, 'TPS 2', 155, 9, 1, 1),
(1961, 'TPS 3', 155, 9, 1, 1),
(1962, 'TPS 4', 155, 9, 1, 1),
(1963, 'TPS 5', 155, 9, 1, 1),
(1964, 'TPS 6', 155, 9, 1, 1),
(1965, 'TPS 7', 155, 9, 1, 1),
(1966, 'TPS 8', 155, 9, 1, 1),
(1967, 'TPS 9', 155, 9, 1, 1),
(1968, 'TPS 10', 155, 9, 1, 1),
(1969, 'TPS 1', 157, 9, 1, 1),
(1970, 'TPS 2', 157, 9, 1, 1),
(1971, 'TPS 3', 157, 9, 1, 1),
(1972, 'TPS 4', 157, 9, 1, 1),
(1973, 'TPS 5', 157, 9, 1, 1),
(1974, 'TPS 6', 157, 9, 1, 1),
(1975, 'TPS 7', 157, 9, 1, 1),
(1976, 'TPS 8', 157, 9, 1, 1),
(1977, 'TPS 9', 157, 9, 1, 1),
(1978, 'TPS 10', 157, 9, 1, 1),
(1979, 'TPS 11', 157, 9, 1, 1),
(1980, 'TPS 12', 157, 9, 1, 1),
(1981, 'TPS 13', 157, 9, 1, 1),
(1982, 'TPS 14', 157, 9, 1, 1),
(1983, 'TPS 15', 157, 9, 1, 1),
(1984, 'TPS 16', 157, 9, 1, 1),
(1985, 'TPS 17', 157, 9, 1, 1),
(1986, 'TPS 18', 157, 9, 1, 1),
(1987, 'TPS 19', 157, 9, 1, 1),
(1988, 'TPS 20', 157, 9, 1, 1),
(1989, 'TPS 21', 157, 9, 1, 1),
(1990, 'TPS 22', 157, 9, 1, 1),
(1991, 'TPS 23', 157, 9, 1, 1),
(1992, 'TPS 24', 157, 9, 1, 1),
(1993, 'TPS 25', 157, 9, 1, 1),
(1994, 'TPS 26', 157, 9, 1, 1),
(1995, 'TPS 27', 157, 9, 1, 1),
(1996, 'TPS 1', 159, 9, 1, 1),
(1997, 'TPS 2', 159, 9, 1, 1),
(1998, 'TPS 3', 159, 9, 1, 1),
(1999, 'TPS 4', 159, 9, 1, 1),
(2000, 'TPS 5', 159, 9, 1, 1),
(2001, 'TPS 6', 159, 9, 1, 1),
(2002, 'TPS 7', 159, 9, 1, 1),
(2003, 'TPS 8', 159, 9, 1, 1),
(2004, 'TPS 9', 159, 9, 1, 1),
(2005, 'TPS 10', 159, 9, 1, 1),
(2006, 'TPS 11', 159, 9, 1, 1),
(2007, 'TPS 12', 159, 9, 1, 1),
(2008, 'TPS 13', 159, 9, 1, 1),
(2009, 'TPS 14', 159, 9, 1, 1),
(2010, 'TPS 1', 154, 9, 1, 1),
(2011, 'TPS 2', 154, 9, 1, 1),
(2012, 'TPS 3', 154, 9, 1, 1),
(2013, 'TPS 4', 154, 9, 1, 1),
(2014, 'TPS 5', 154, 9, 1, 1),
(2015, 'TPS 6', 154, 9, 1, 1),
(2016, 'TPS 7', 154, 9, 1, 1),
(2017, 'TPS 8', 154, 9, 1, 1),
(2018, 'TPS 1', 151, 9, 1, 1),
(2019, 'TPS 2', 151, 9, 1, 1),
(2020, 'TPS 3', 151, 9, 1, 1),
(2021, 'TPS 4', 151, 9, 1, 1),
(2022, 'TPS 5', 151, 9, 1, 1),
(2023, 'TPS 6', 151, 9, 1, 1),
(2024, 'TPS 7', 151, 9, 1, 1),
(2025, 'TPS 8', 151, 9, 1, 1),
(2026, 'TPS 9', 151, 9, 1, 1),
(2027, 'TPS 10', 151, 9, 1, 1),
(2028, 'TPS 11', 151, 9, 1, 1),
(2029, 'TPS 12', 151, 9, 1, 1),
(2030, 'TPS 13', 151, 9, 1, 1),
(2031, 'TPS 14', 151, 9, 1, 1),
(2032, 'TPS 15', 151, 9, 1, 1),
(2033, 'TPS 16', 151, 9, 1, 1),
(2034, 'TPS 17', 151, 9, 1, 1),
(2035, 'TPS 18', 151, 9, 1, 1),
(2036, 'TPS 1', 158, 9, 1, 1),
(2037, 'TPS 2', 158, 9, 1, 1),
(2038, 'TPS 3', 158, 9, 1, 1),
(2039, 'TPS 4', 158, 9, 1, 1),
(2040, 'TPS 5', 158, 9, 1, 1),
(2041, 'TPS 6', 158, 9, 1, 1),
(2042, 'TPS 7', 158, 9, 1, 1),
(2043, 'TPS 8', 158, 9, 1, 1),
(2044, 'TPS 9', 158, 9, 1, 1),
(2045, 'TPS 1', 160, 9, 1, 1),
(2046, 'TPS 2', 160, 9, 1, 1),
(2047, 'TPS 3', 160, 9, 1, 1),
(2048, 'TPS 4', 160, 9, 1, 1),
(2049, 'TPS 5', 160, 9, 1, 1),
(2050, 'TPS 6', 160, 9, 1, 1),
(2051, 'TPS 7', 160, 9, 1, 1),
(2052, 'TPS 8', 160, 9, 1, 1),
(2053, 'TPS 1', 146, 9, 1, 1),
(2054, 'TPS 2', 146, 9, 1, 1),
(2055, 'TPS 3', 146, 9, 1, 1),
(2056, 'TPS 4', 146, 9, 1, 1),
(2057, 'TPS 5', 146, 9, 1, 1),
(2058, 'TPS 6', 146, 9, 1, 1),
(2059, 'TPS 7', 146, 9, 1, 1),
(2060, 'TPS 8', 146, 9, 1, 1),
(2061, 'TPS 9', 146, 9, 1, 1),
(2062, 'TPS 10', 146, 9, 1, 1),
(2063, 'TPS 1', 148, 9, 1, 1),
(2064, 'TPS 2', 148, 9, 1, 1),
(2065, 'TPS 3', 148, 9, 1, 1),
(2066, 'TPS 4', 148, 9, 1, 1),
(2067, 'TPS 5', 148, 9, 1, 1),
(2068, 'TPS 6', 148, 9, 1, 1),
(2069, 'TPS 1', 152, 9, 1, 1),
(2070, 'TPS 2', 152, 9, 1, 1),
(2071, 'TPS 3', 152, 9, 1, 1),
(2072, 'TPS 4', 152, 9, 1, 1),
(2073, 'TPS 5', 152, 9, 1, 1),
(2074, 'TPS 6', 152, 9, 1, 1),
(2075, 'TPS 7', 152, 9, 1, 1),
(2076, 'TPS 8', 152, 9, 1, 1),
(2077, 'TPS 9', 152, 9, 1, 1),
(2078, 'TPS 10', 152, 9, 1, 1),
(2079, 'TPS 11', 152, 9, 1, 1),
(2080, 'TPS 12', 152, 9, 1, 1),
(2081, 'TPS 1', 149, 9, 1, 1),
(2082, 'TPS 2', 149, 9, 1, 1),
(2083, 'TPS 3', 149, 9, 1, 1),
(2084, 'TPS 4', 149, 9, 1, 1),
(2085, 'TPS 5', 149, 9, 1, 1),
(2086, 'TPS 1', 163, 10, 1, 1),
(2087, 'TPS 2', 163, 10, 1, 1),
(2088, 'TPS 3', 163, 10, 1, 1),
(2089, 'TPS 4', 163, 10, 1, 1),
(2090, 'TPS 5', 163, 10, 1, 1),
(2091, 'TPS 6', 163, 10, 1, 1),
(2092, 'TPS 7', 163, 10, 1, 1),
(2093, 'TPS 8', 163, 10, 1, 1),
(2094, 'TPS 9', 163, 10, 1, 1),
(2095, 'TPS 10', 163, 10, 1, 1),
(2096, 'TPS 11', 163, 10, 1, 1),
(2097, 'TPS 12', 163, 10, 1, 1),
(2098, 'TPS 13', 163, 10, 1, 1),
(2099, 'TPS 14', 163, 10, 1, 1),
(2100, 'TPS 15', 163, 10, 1, 1),
(2101, 'TPS 16', 163, 10, 1, 1),
(2102, 'TPS 17', 163, 10, 1, 1),
(2103, 'TPS 18', 163, 10, 1, 1),
(2104, 'TPS 19', 163, 10, 1, 1),
(2105, 'TPS 20', 163, 10, 1, 1),
(2106, 'TPS 21', 163, 10, 1, 1),
(2107, 'TPS 22', 163, 10, 1, 1),
(2108, 'TPS 23', 163, 10, 1, 1),
(2109, 'TPS 24', 163, 10, 1, 1),
(2110, 'TPS 25', 163, 10, 1, 1),
(2111, 'TPS 26', 163, 10, 1, 1),
(2112, 'TPS 27', 163, 10, 1, 1),
(2113, 'TPS 28', 163, 10, 1, 1),
(2114, 'TPS 29', 163, 10, 1, 1),
(2115, 'TPS 1', 172, 10, 1, 1),
(2116, 'TPS 2', 172, 10, 1, 1),
(2117, 'TPS 3', 172, 10, 1, 1),
(2118, 'TPS 4', 172, 10, 1, 1),
(2119, 'TPS 5', 172, 10, 1, 1),
(2120, 'TPS 6', 172, 10, 1, 1),
(2121, 'TPS 7', 172, 10, 1, 1),
(2122, 'TPS 8', 172, 10, 1, 1),
(2123, 'TPS 9', 172, 10, 1, 1),
(2124, 'TPS 10', 172, 10, 1, 1),
(2125, 'TPS 11', 172, 10, 1, 1),
(2126, 'TPS 12', 172, 10, 1, 1),
(2127, 'TPS 13', 172, 10, 1, 1),
(2128, 'TPS 14', 172, 10, 1, 1),
(2129, 'TPS 15', 172, 10, 1, 1),
(2130, 'TPS 16', 172, 10, 1, 1),
(2131, 'TPS 17', 172, 10, 1, 1),
(2132, 'TPS 18', 172, 10, 1, 1),
(2133, 'TPS 19', 172, 10, 1, 1),
(2134, 'TPS 20', 172, 10, 1, 1),
(2135, 'TPS 21', 172, 10, 1, 1),
(2136, 'TPS 22', 172, 10, 1, 1),
(2137, 'TPS 23', 172, 10, 1, 1),
(2138, 'TPS 24', 172, 10, 1, 1),
(2139, 'TPS 25', 172, 10, 1, 1),
(2140, 'TPS 1', 166, 10, 1, 1),
(2141, 'TPS 2', 166, 10, 1, 1),
(2142, 'TPS 3', 166, 10, 1, 1),
(2143, 'TPS 4', 166, 10, 1, 1),
(2144, 'TPS 5', 166, 10, 1, 1),
(2145, 'TPS 6', 166, 10, 1, 1),
(2146, 'TPS 7', 166, 10, 1, 1),
(2147, 'TPS 8', 166, 10, 1, 1),
(2148, 'TPS 9', 166, 10, 1, 1),
(2149, 'TPS 10', 166, 10, 1, 1),
(2150, 'TPS 11', 166, 10, 1, 1),
(2151, 'TPS 12', 166, 10, 1, 1),
(2152, 'TPS 13', 166, 10, 1, 1),
(2153, 'TPS 14', 166, 10, 1, 1),
(2154, 'TPS 15', 166, 10, 1, 1),
(2155, 'TPS 1', 170, 10, 1, 1),
(2156, 'TPS 2', 170, 10, 1, 1),
(2157, 'TPS 3', 170, 10, 1, 1),
(2158, 'TPS 4', 170, 10, 1, 1),
(2159, 'TPS 5', 170, 10, 1, 1),
(2160, 'TPS 6', 170, 10, 1, 1),
(2161, 'TPS 7', 170, 10, 1, 1),
(2162, 'TPS 8', 170, 10, 1, 1),
(2163, 'TPS 9', 170, 10, 1, 1),
(2164, 'TPS 10', 170, 10, 1, 1),
(2165, 'TPS 11', 170, 10, 1, 1),
(2166, 'TPS 12', 170, 10, 1, 1),
(2167, 'TPS 13', 170, 10, 1, 1),
(2168, 'TPS 14', 170, 10, 1, 1),
(2169, 'TPS 15', 170, 10, 1, 1),
(2170, 'TPS 16', 170, 10, 1, 1),
(2171, 'TPS 17', 170, 10, 1, 1),
(2172, 'TPS 1', 171, 10, 1, 1),
(2173, 'TPS 2', 171, 10, 1, 1),
(2174, 'TPS 3', 171, 10, 1, 1),
(2175, 'TPS 4', 171, 10, 1, 1),
(2176, 'TPS 5', 171, 10, 1, 1),
(2177, 'TPS 6', 171, 10, 1, 1),
(2178, 'TPS 7', 171, 10, 1, 1),
(2179, 'TPS 8', 171, 10, 1, 1),
(2180, 'TPS 9', 171, 10, 1, 1),
(2181, 'TPS 10', 171, 10, 1, 1),
(2182, 'TPS 11', 171, 10, 1, 1),
(2183, 'TPS 12', 171, 10, 1, 1),
(2184, 'TPS 13', 171, 10, 1, 1),
(2185, 'TPS 14', 171, 10, 1, 1),
(2186, 'TPS 15', 171, 10, 1, 1),
(2187, 'TPS 16', 171, 10, 1, 1),
(2188, 'TPS 17', 171, 10, 1, 1),
(2189, 'TPS 18', 171, 10, 1, 1),
(2190, 'TPS 19', 171, 10, 1, 1),
(2191, 'TPS 20', 171, 10, 1, 1),
(2192, 'TPS 21', 171, 10, 1, 1),
(2193, 'TPS 22', 171, 10, 1, 1),
(2194, 'TPS 23', 171, 10, 1, 1),
(2195, 'TPS 24', 171, 10, 1, 1),
(2196, 'TPS 25', 171, 10, 1, 1),
(2197, 'TPS 26', 171, 10, 1, 1),
(2198, 'TPS 27', 171, 10, 1, 1),
(2199, 'TPS 28', 171, 10, 1, 1),
(2200, 'TPS 29', 171, 10, 1, 1),
(2201, 'TPS 30', 171, 10, 1, 1),
(2202, 'TPS 31', 171, 10, 1, 1),
(2203, 'TPS 1', 168, 10, 1, 1),
(2204, 'TPS 2', 168, 10, 1, 1),
(2205, 'TPS 3', 168, 10, 1, 1),
(2206, 'TPS 4', 168, 10, 1, 1),
(2207, 'TPS 5', 168, 10, 1, 1),
(2208, 'TPS 6', 168, 10, 1, 1),
(2209, 'TPS 7', 168, 10, 1, 1),
(2210, 'TPS 8', 168, 10, 1, 1),
(2211, 'TPS 9', 168, 10, 1, 1),
(2212, 'TPS 10', 168, 10, 1, 1),
(2213, 'TPS 11', 168, 10, 1, 1),
(2214, 'TPS 12', 168, 10, 1, 1),
(2215, 'TPS 13', 168, 10, 1, 1),
(2216, 'TPS 14', 168, 10, 1, 1),
(2217, 'TPS 15', 168, 10, 1, 1),
(2218, 'TPS 16', 168, 10, 1, 1),
(2219, 'TPS 17', 168, 10, 1, 1),
(2220, 'TPS 18', 168, 10, 1, 1),
(2221, 'TPS 19', 168, 10, 1, 1),
(2222, 'TPS 20', 168, 10, 1, 1),
(2223, 'TPS 21', 168, 10, 1, 1),
(2224, 'TPS 22', 168, 10, 1, 1),
(2225, 'TPS 23', 168, 10, 1, 1),
(2226, 'TPS 24', 168, 10, 1, 1),
(2227, 'TPS 25', 168, 10, 1, 1),
(2228, 'TPS 26', 168, 10, 1, 1),
(2229, 'TPS 27', 168, 10, 1, 1),
(2230, 'TPS 28', 168, 10, 1, 1),
(2231, 'TPS 29', 168, 10, 1, 1),
(2232, 'TPS 30', 168, 10, 1, 1),
(2233, 'TPS 31', 168, 10, 1, 1),
(2234, 'TPS 32', 168, 10, 1, 1),
(2235, 'TPS 33', 168, 10, 1, 1),
(2236, 'TPS 34', 168, 10, 1, 1),
(2237, 'TPS 35', 168, 10, 1, 1),
(2238, 'TPS 36', 168, 10, 1, 1),
(2239, 'TPS 37', 168, 10, 1, 1),
(2240, 'TPS 38', 168, 10, 1, 1),
(2241, 'TPS 1', 164, 10, 1, 1),
(2242, 'TPS 2', 164, 10, 1, 1),
(2243, 'TPS 3', 164, 10, 1, 1),
(2244, 'TPS 4', 164, 10, 1, 1),
(2245, 'TPS 5', 164, 10, 1, 1),
(2246, 'TPS 6', 164, 10, 1, 1),
(2247, 'TPS 7', 164, 10, 1, 1),
(2248, 'TPS 8', 164, 10, 1, 1),
(2249, 'TPS 9', 164, 10, 1, 1),
(2250, 'TPS 10', 164, 10, 1, 1),
(2251, 'TPS 11', 164, 10, 1, 1),
(2252, 'TPS 12', 164, 10, 1, 1),
(2253, 'TPS 13', 164, 10, 1, 1),
(2254, 'TPS 14', 164, 10, 1, 1),
(2255, 'TPS 15', 164, 10, 1, 1),
(2256, 'TPS 16', 164, 10, 1, 1),
(2257, 'TPS 17', 164, 10, 1, 1),
(2258, 'TPS 18', 164, 10, 1, 1),
(2259, 'TPS 19', 164, 10, 1, 1),
(2260, 'TPS 20', 164, 10, 1, 1),
(2261, 'TPS 1', 165, 10, 1, 1),
(2262, 'TPS 2', 165, 10, 1, 1),
(2263, 'TPS 3', 165, 10, 1, 1),
(2264, 'TPS 4', 165, 10, 1, 1),
(2265, 'TPS 5', 165, 10, 1, 1),
(2266, 'TPS 6', 165, 10, 1, 1),
(2267, 'TPS 7', 165, 10, 1, 1),
(2268, 'TPS 8', 165, 10, 1, 1),
(2269, 'TPS 9', 165, 10, 1, 1),
(2270, 'TPS 10', 165, 10, 1, 1),
(2271, 'TPS 11', 165, 10, 1, 1),
(2272, 'TPS 12', 165, 10, 1, 1),
(2273, 'TPS 13', 165, 10, 1, 1),
(2274, 'TPS 14', 165, 10, 1, 1),
(2275, 'TPS 15', 165, 10, 1, 1),
(2276, 'TPS 16', 165, 10, 1, 1),
(2277, 'TPS 17', 165, 10, 1, 1),
(2278, 'TPS 1', 162, 10, 1, 1),
(2279, 'TPS 2', 162, 10, 1, 1),
(2280, 'TPS 3', 162, 10, 1, 1),
(2281, 'TPS 4', 162, 10, 1, 1),
(2282, 'TPS 5', 162, 10, 1, 1),
(2283, 'TPS 6', 162, 10, 1, 1),
(2284, 'TPS 7', 162, 10, 1, 1),
(2285, 'TPS 8', 162, 10, 1, 1),
(2286, 'TPS 9', 162, 10, 1, 1),
(2287, 'TPS 10', 162, 10, 1, 1),
(2288, 'TPS 11', 162, 10, 1, 1),
(2289, 'TPS 12', 162, 10, 1, 1),
(2290, 'TPS 13', 162, 10, 1, 1),
(2291, 'TPS 14', 162, 10, 1, 1),
(2292, 'TPS 15', 162, 10, 1, 1),
(2293, 'TPS 16', 162, 10, 1, 1),
(2294, 'TPS 17', 162, 10, 1, 1),
(2295, 'TPS 1', 161, 10, 1, 1),
(2296, 'TPS 2', 161, 10, 1, 1),
(2297, 'TPS 3', 161, 10, 1, 1),
(2298, 'TPS 4', 161, 10, 1, 1),
(2299, 'TPS 5', 161, 10, 1, 1),
(2300, 'TPS 6', 161, 10, 1, 1),
(2301, 'TPS 7', 161, 10, 1, 1),
(2302, 'TPS 8', 161, 10, 1, 1),
(2303, 'TPS 9', 161, 10, 1, 1),
(2304, 'TPS 10', 161, 10, 1, 1),
(2305, 'TPS 11', 161, 10, 1, 1),
(2306, 'TPS 12', 161, 10, 1, 1),
(2307, 'TPS 13', 161, 10, 1, 1),
(2308, 'TPS 14', 161, 10, 1, 1),
(2309, 'TPS 15', 161, 10, 1, 1),
(2310, 'TPS 16', 161, 10, 1, 1),
(2311, 'TPS 17', 161, 10, 1, 1),
(2312, 'TPS 18', 161, 10, 1, 1),
(2313, 'TPS 19', 161, 10, 1, 1),
(2314, 'TPS 20', 161, 10, 1, 1),
(2315, 'TPS 21', 161, 10, 1, 1),
(2316, 'TPS 22', 161, 10, 1, 1),
(2317, 'TPS 23', 161, 10, 1, 1),
(2318, 'TPS 24', 161, 10, 1, 1),
(2319, 'TPS 25', 161, 10, 1, 1),
(2320, 'TPS 26', 161, 10, 1, 1),
(2321, 'TPS 27', 161, 10, 1, 1),
(2322, 'TPS 28', 161, 10, 1, 1),
(2323, 'TPS 29', 161, 10, 1, 1),
(2324, 'TPS 30', 161, 10, 1, 1),
(2325, 'TPS 31', 161, 10, 1, 1),
(2326, 'TPS 32', 161, 10, 1, 1),
(2327, 'TPS 1', 169, 10, 1, 1),
(2328, 'TPS 2', 169, 10, 1, 1),
(2329, 'TPS 3', 169, 10, 1, 1),
(2330, 'TPS 4', 169, 10, 1, 1),
(2331, 'TPS 5', 169, 10, 1, 1),
(2332, 'TPS 6', 169, 10, 1, 1),
(2333, 'TPS 7', 169, 10, 1, 1),
(2334, 'TPS 8', 169, 10, 1, 1),
(2335, 'TPS 9', 169, 10, 1, 1),
(2336, 'TPS 10', 169, 10, 1, 1),
(2337, 'TPS 11', 169, 10, 1, 1),
(2338, 'TPS 12', 169, 10, 1, 1),
(2339, 'TPS 13', 169, 10, 1, 1),
(2340, 'TPS 14', 169, 10, 1, 1),
(2341, 'TPS 15', 169, 10, 1, 1),
(2342, 'TPS 16', 169, 10, 1, 1),
(2343, 'TPS 17', 169, 10, 1, 1),
(2344, 'TPS 18', 169, 10, 1, 1),
(2345, 'TPS 19', 169, 10, 1, 1),
(2346, 'TPS 20', 169, 10, 1, 1),
(2347, 'TPS 21', 169, 10, 1, 1),
(2348, 'TPS 22', 169, 10, 1, 1),
(2349, 'TPS 1', 167, 10, 1, 1),
(2350, 'TPS 2', 167, 10, 1, 1),
(2351, 'TPS 3', 167, 10, 1, 1),
(2352, 'TPS 4', 167, 10, 1, 1),
(2353, 'TPS 5', 167, 10, 1, 1),
(2354, 'TPS 6', 167, 10, 1, 1),
(2355, 'TPS 7', 167, 10, 1, 1),
(2356, 'TPS 8', 167, 10, 1, 1),
(2357, 'TPS 9', 167, 10, 1, 1),
(2358, 'TPS 10', 167, 10, 1, 1),
(2359, 'TPS 11', 167, 10, 1, 1),
(2360, 'TPS 12', 167, 10, 1, 1),
(2361, 'TPS 13', 167, 10, 1, 1),
(2362, 'TPS 14', 167, 10, 1, 1),
(2363, 'TPS 15', 167, 10, 1, 1),
(2364, 'TPS 16', 167, 10, 1, 1),
(2365, 'TPS 17', 167, 10, 1, 1),
(2366, 'TPS 18', 167, 10, 1, 1),
(2367, 'TPS 19', 167, 10, 1, 1),
(2368, 'TPS 20', 167, 10, 1, 1),
(2369, 'TPS 1', 174, 11, 1, 1),
(2370, 'TPS 2', 174, 11, 1, 1),
(2371, 'TPS 3', 174, 11, 1, 1),
(2372, 'TPS 4', 174, 11, 1, 1),
(2373, 'TPS 5', 174, 11, 1, 1),
(2374, 'TPS 6', 174, 11, 1, 1),
(2375, 'TPS 7', 174, 11, 1, 1),
(2376, 'TPS 8', 174, 11, 1, 1),
(2377, 'TPS 9', 174, 11, 1, 1),
(2378, 'TPS 10', 174, 11, 1, 1),
(2379, 'TPS 11', 174, 11, 1, 1),
(2380, 'TPS 12', 174, 11, 1, 1),
(2381, 'TPS 13', 174, 11, 1, 1),
(2382, 'TPS 14', 174, 11, 1, 1),
(2383, 'TPS 15', 174, 11, 1, 1),
(2384, 'TPS 16', 174, 11, 1, 1),
(2385, 'TPS 17', 174, 11, 1, 1),
(2386, 'TPS 18', 174, 11, 1, 1),
(2387, 'TPS 19', 174, 11, 1, 1),
(2388, 'TPS 20', 174, 11, 1, 1),
(2389, 'TPS 21', 174, 11, 1, 1),
(2390, 'TPS 22', 174, 11, 1, 1),
(2391, 'TPS 23', 174, 11, 1, 1),
(2392, 'TPS 24', 174, 11, 1, 1),
(2393, 'TPS 25', 174, 11, 1, 1),
(2394, 'TPS 1', 182, 11, 1, 1),
(2395, 'TPS 2', 182, 11, 1, 1),
(2396, 'TPS 3', 182, 11, 1, 1),
(2397, 'TPS 4', 182, 11, 1, 1),
(2398, 'TPS 5', 182, 11, 1, 1),
(2399, 'TPS 6', 182, 11, 1, 1),
(2400, 'TPS 7', 182, 11, 1, 1),
(2401, 'TPS 8', 182, 11, 1, 1),
(2402, 'TPS 9', 182, 11, 1, 1),
(2403, 'TPS 10', 182, 11, 1, 1),
(2404, 'TPS 11', 182, 11, 1, 1),
(2405, 'TPS 12', 182, 11, 1, 1),
(2406, 'TPS 13', 182, 11, 1, 1),
(2407, 'TPS 14', 182, 11, 1, 1),
(2408, 'TPS 15', 182, 11, 1, 1),
(2409, 'TPS 16', 182, 11, 1, 1),
(2410, 'TPS 17', 182, 11, 1, 1),
(2411, 'TPS 18', 182, 11, 1, 1),
(2412, 'TPS 19', 182, 11, 1, 1),
(2413, 'TPS 20', 182, 11, 1, 1),
(2414, 'TPS 21', 182, 11, 1, 1),
(2415, 'TPS 22', 182, 11, 1, 1),
(2416, 'TPS 23', 182, 11, 1, 1),
(2417, 'TPS 24', 182, 11, 1, 1),
(2418, 'TPS 25', 182, 11, 1, 1),
(2419, 'TPS 26', 182, 11, 1, 1),
(2420, 'TPS 27', 182, 11, 1, 1),
(2421, 'TPS 28', 182, 11, 1, 1),
(2422, 'TPS 29', 182, 11, 1, 1),
(2423, 'TPS 30', 182, 11, 1, 1),
(2424, 'TPS 31', 182, 11, 1, 1),
(2425, 'TPS 32', 182, 11, 1, 1),
(2426, 'TPS 33', 182, 11, 1, 1),
(2427, 'TPS 34', 182, 11, 1, 1),
(2428, 'TPS 35', 182, 11, 1, 1),
(2429, 'TPS 36', 182, 11, 1, 1),
(2430, 'TPS 37', 182, 11, 1, 1),
(2431, 'TPS 38', 182, 11, 1, 1),
(2432, 'TPS 39', 182, 11, 1, 1),
(2433, 'TPS 40', 182, 11, 1, 1),
(2434, 'TPS 41', 182, 11, 1, 1),
(2435, 'TPS 42', 182, 11, 1, 1),
(2436, 'TPS 43', 182, 11, 1, 1),
(2437, 'TPS 44', 182, 11, 1, 1),
(2438, 'TPS 45', 182, 11, 1, 1),
(2439, 'TPS 46', 182, 11, 1, 1),
(2440, 'TPS 47', 182, 11, 1, 1),
(2441, 'TPS 48', 182, 11, 1, 1),
(2442, 'TPS 1', 187, 11, 1, 1),
(2443, 'TPS 2', 187, 11, 1, 1),
(2444, 'TPS 3', 187, 11, 1, 1),
(2445, 'TPS 4', 187, 11, 1, 1),
(2446, 'TPS 5', 187, 11, 1, 1),
(2447, 'TPS 6', 187, 11, 1, 1),
(2448, 'TPS 7', 187, 11, 1, 1),
(2449, 'TPS 8', 187, 11, 1, 1),
(2450, 'TPS 9', 187, 11, 1, 1),
(2451, 'TPS 10', 187, 11, 1, 1),
(2452, 'TPS 11', 187, 11, 1, 1),
(2453, 'TPS 12', 187, 11, 1, 1),
(2454, 'TPS 13', 187, 11, 1, 1),
(2455, 'TPS 14', 187, 11, 1, 1),
(2456, 'TPS 15', 187, 11, 1, 1),
(2457, 'TPS 16', 187, 11, 1, 1),
(2458, 'TPS 17', 187, 11, 1, 1),
(2459, 'TPS 18', 187, 11, 1, 1),
(2460, 'TPS 19', 187, 11, 1, 1),
(2461, 'TPS 20', 187, 11, 1, 1),
(2462, 'TPS 21', 187, 11, 1, 1),
(2463, 'TPS 22', 187, 11, 1, 1),
(2464, 'TPS 23', 187, 11, 1, 1),
(2465, 'TPS 24', 187, 11, 1, 1),
(2466, 'TPS 25', 187, 11, 1, 1),
(2467, 'TPS 26', 187, 11, 1, 1),
(2468, 'TPS 1', 179, 11, 1, 1),
(2469, 'TPS 2', 179, 11, 1, 1),
(2470, 'TPS 3', 179, 11, 1, 1),
(2471, 'TPS 4', 179, 11, 1, 1),
(2472, 'TPS 5', 179, 11, 1, 1),
(2473, 'TPS 6', 179, 11, 1, 1),
(2474, 'TPS 7', 179, 11, 1, 1),
(2475, 'TPS 8', 179, 11, 1, 1),
(2476, 'TPS 9', 179, 11, 1, 1),
(2477, 'TPS 10', 179, 11, 1, 1),
(2478, 'TPS 11', 179, 11, 1, 1),
(2479, 'TPS 12', 179, 11, 1, 1),
(2480, 'TPS 13', 179, 11, 1, 1),
(2481, 'TPS 14', 179, 11, 1, 1),
(2482, 'TPS 15', 179, 11, 1, 1),
(2483, 'TPS 1', 180, 11, 1, 1),
(2484, 'TPS 2', 180, 11, 1, 1),
(2485, 'TPS 3', 180, 11, 1, 1),
(2486, 'TPS 4', 180, 11, 1, 1),
(2487, 'TPS 5', 180, 11, 1, 1),
(2488, 'TPS 6', 180, 11, 1, 1),
(2489, 'TPS 7', 180, 11, 1, 1),
(2490, 'TPS 8', 180, 11, 1, 1),
(2491, 'TPS 9', 180, 11, 1, 1),
(2492, 'TPS 10', 180, 11, 1, 1),
(2493, 'TPS 11', 180, 11, 1, 1),
(2494, 'TPS 12', 180, 11, 1, 1),
(2495, 'TPS 13', 180, 11, 1, 1),
(2496, 'TPS 14', 180, 11, 1, 1),
(2497, 'TPS 15', 180, 11, 1, 1),
(2498, 'TPS 16', 180, 11, 1, 1),
(2499, 'TPS 17', 180, 11, 1, 1),
(2500, 'TPS 18', 180, 11, 1, 1),
(2501, 'TPS 19', 180, 11, 1, 1),
(2502, 'TPS 20', 180, 11, 1, 1),
(2503, 'TPS 21', 180, 11, 1, 1),
(2504, 'TPS 22', 180, 11, 1, 1),
(2505, 'TPS 23', 180, 11, 1, 1),
(2506, 'TPS 24', 180, 11, 1, 1),
(2507, 'TPS 1', 185, 11, 1, 1),
(2508, 'TPS 2', 185, 11, 1, 1),
(2509, 'TPS 3', 185, 11, 1, 1),
(2510, 'TPS 4', 185, 11, 1, 1),
(2511, 'TPS 5', 185, 11, 1, 1),
(2512, 'TPS 6', 185, 11, 1, 1),
(2513, 'TPS 7', 185, 11, 1, 1),
(2514, 'TPS 8', 185, 11, 1, 1),
(2515, 'TPS 9', 185, 11, 1, 1),
(2516, 'TPS 10', 185, 11, 1, 1),
(2517, 'TPS 11', 185, 11, 1, 1),
(2518, 'TPS 12', 185, 11, 1, 1),
(2519, 'TPS 13', 185, 11, 1, 1),
(2520, 'TPS 14', 185, 11, 1, 1),
(2521, 'TPS 15', 185, 11, 1, 1),
(2522, 'TPS 16', 185, 11, 1, 1),
(2523, 'TPS 17', 185, 11, 1, 1),
(2524, 'TPS 18', 185, 11, 1, 1),
(2525, 'TPS 19', 185, 11, 1, 1),
(2526, 'TPS 20', 185, 11, 1, 1),
(2527, 'TPS 21', 185, 11, 1, 1),
(2528, 'TPS 22', 185, 11, 1, 1),
(2529, 'TPS 23', 185, 11, 1, 1),
(2530, 'TPS 24', 185, 11, 1, 1),
(2531, 'TPS 25', 185, 11, 1, 1),
(2532, 'TPS 26', 185, 11, 1, 1),
(2533, 'TPS 27', 185, 11, 1, 1),
(2534, 'TPS 28', 185, 11, 1, 1),
(2535, 'TPS 29', 185, 11, 1, 1),
(2536, 'TPS 30', 185, 11, 1, 1),
(2537, 'TPS 31', 185, 11, 1, 1),
(2538, 'TPS 32', 185, 11, 1, 1),
(2539, 'TPS 33', 185, 11, 1, 1),
(2540, 'TPS 34', 185, 11, 1, 1),
(2541, 'TPS 35', 185, 11, 1, 1),
(2542, 'TPS 36', 185, 11, 1, 1),
(2543, 'TPS 37', 185, 11, 1, 1),
(2544, 'TPS 38', 185, 11, 1, 1),
(2545, 'TPS 39', 185, 11, 1, 1),
(2546, 'TPS 40', 185, 11, 1, 1),
(2547, 'TPS 1', 175, 11, 1, 1),
(2548, 'TPS 2', 175, 11, 1, 1),
(2549, 'TPS 3', 175, 11, 1, 1),
(2550, 'TPS 4', 175, 11, 1, 1),
(2551, 'TPS 5', 175, 11, 1, 1),
(2552, 'TPS 6', 175, 11, 1, 1),
(2553, 'TPS 7', 175, 11, 1, 1),
(2554, 'TPS 8', 175, 11, 1, 1),
(2555, 'TPS 9', 175, 11, 1, 1),
(2556, 'TPS 10', 175, 11, 1, 1),
(2557, 'TPS 11', 175, 11, 1, 1),
(2558, 'TPS 12', 175, 11, 1, 1),
(2559, 'TPS 13', 175, 11, 1, 1),
(2560, 'TPS 14', 175, 11, 1, 1),
(2561, 'TPS 15', 175, 11, 1, 1),
(2562, 'TPS 16', 175, 11, 1, 1),
(2563, 'TPS 17', 175, 11, 1, 1),
(2564, 'TPS 18', 175, 11, 1, 1),
(2565, 'TPS 19', 175, 11, 1, 1),
(2566, 'TPS 20', 175, 11, 1, 1),
(2567, 'TPS 21', 175, 11, 1, 1),
(2568, 'TPS 22', 175, 11, 1, 1),
(2569, 'TPS 23', 175, 11, 1, 1),
(2570, 'TPS 24', 175, 11, 1, 1),
(2571, 'TPS 25', 175, 11, 1, 1),
(2572, 'TPS 26', 175, 11, 1, 1),
(2573, 'TPS 27', 175, 11, 1, 1),
(2574, 'TPS 28', 175, 11, 1, 1),
(2575, 'TPS 29', 175, 11, 1, 1),
(2576, 'TPS 30', 175, 11, 1, 1),
(2577, 'TPS 31', 175, 11, 1, 1),
(2578, 'TPS 32', 175, 11, 1, 1),
(2579, 'TPS 33', 175, 11, 1, 1),
(2580, 'TPS 34', 175, 11, 1, 1),
(2581, 'TPS 35', 175, 11, 1, 1),
(2582, 'TPS 36', 175, 11, 1, 1),
(2583, 'TPS 37', 175, 11, 1, 1),
(2584, 'TPS 38', 175, 11, 1, 1),
(2585, 'TPS 39', 175, 11, 1, 1),
(2586, 'TPS 40', 175, 11, 1, 1),
(2587, 'TPS 41', 175, 11, 1, 1),
(2588, 'TPS 42', 175, 11, 1, 1),
(2589, 'TPS 43', 175, 11, 1, 1),
(2590, 'TPS 44', 175, 11, 1, 1),
(2591, 'TPS 45', 175, 11, 1, 1),
(2592, 'TPS 46', 175, 11, 1, 1),
(2593, 'TPS 47', 175, 11, 1, 1),
(2594, 'TPS 48', 175, 11, 1, 1),
(2595, 'TPS 49', 175, 11, 1, 1),
(2596, 'TPS 50', 175, 11, 1, 1),
(2597, 'TPS 51', 175, 11, 1, 1),
(2598, 'TPS 52', 175, 11, 1, 1),
(2599, 'TPS 53', 175, 11, 1, 1),
(2600, 'TPS 54', 175, 11, 1, 1),
(2601, 'TPS 55', 175, 11, 1, 1),
(2602, 'TPS 56', 175, 11, 1, 1),
(2603, 'TPS 57', 175, 11, 1, 1),
(2604, 'TPS 58', 175, 11, 1, 1),
(2605, 'TPS 59', 175, 11, 1, 1),
(2606, 'TPS 60', 175, 11, 1, 1),
(2607, 'TPS 61', 175, 11, 1, 1),
(2608, 'TPS 62', 175, 11, 1, 1),
(2609, 'TPS 63', 175, 11, 1, 1),
(2610, 'TPS 64', 175, 11, 1, 1),
(2611, 'TPS 65', 175, 11, 1, 1),
(2612, 'TPS 66', 175, 11, 1, 1),
(2613, 'TPS 67', 175, 11, 1, 1),
(2614, 'TPS 68', 175, 11, 1, 1),
(2615, 'TPS 69', 175, 11, 1, 1),
(2616, 'TPS 70', 175, 11, 1, 1),
(2617, 'TPS 71', 175, 11, 1, 1),
(2618, 'TPS 72', 175, 11, 1, 1),
(2619, 'TPS 73', 175, 11, 1, 1),
(2620, 'TPS 74', 175, 11, 1, 1),
(2621, 'TPS 75', 175, 11, 1, 1),
(2622, 'TPS 76', 175, 11, 1, 1),
(2623, 'TPS 77', 175, 11, 1, 1),
(2624, 'TPS 78', 175, 11, 1, 1),
(2625, 'TPS 79', 175, 11, 1, 1),
(2626, 'TPS 80', 175, 11, 1, 1),
(2627, 'TPS 81', 175, 11, 1, 1),
(2628, 'TPS 82', 175, 11, 1, 1),
(2629, 'TPS 83', 175, 11, 1, 1),
(2630, 'TPS 84', 175, 11, 1, 1),
(2631, 'TPS 85', 175, 11, 1, 1),
(2632, 'TPS 86', 175, 11, 1, 1),
(2633, 'TPS 87', 175, 11, 1, 1),
(2634, 'TPS 88', 175, 11, 1, 1),
(2635, 'TPS 89', 175, 11, 1, 1),
(2636, 'TPS 90', 175, 11, 1, 1),
(2637, 'TPS 91', 175, 11, 1, 1),
(2638, 'TPS 92', 175, 11, 1, 1),
(2639, 'TPS 93', 175, 11, 1, 1),
(2640, 'TPS 94', 175, 11, 1, 1),
(2641, 'TPS 1', 173, 11, 1, 1),
(2642, 'TPS 2', 173, 11, 1, 1),
(2643, 'TPS 3', 173, 11, 1, 1),
(2644, 'TPS 4', 173, 11, 1, 1),
(2645, 'TPS 5', 173, 11, 1, 1),
(2646, 'TPS 6', 173, 11, 1, 1),
(2647, 'TPS 7', 173, 11, 1, 1),
(2648, 'TPS 8', 173, 11, 1, 1),
(2649, 'TPS 9', 173, 11, 1, 1),
(2650, 'TPS 10', 173, 11, 1, 1),
(2651, 'TPS 11', 173, 11, 1, 1),
(2652, 'TPS 12', 173, 11, 1, 1),
(2653, 'TPS 13', 173, 11, 1, 1),
(2654, 'TPS 14', 173, 11, 1, 1),
(2655, 'TPS 15', 173, 11, 1, 1),
(2656, 'TPS 16', 173, 11, 1, 1),
(2657, 'TPS 17', 173, 11, 1, 1),
(2658, 'TPS 18', 173, 11, 1, 1),
(2659, 'TPS 19', 173, 11, 1, 1),
(2660, 'TPS 20', 173, 11, 1, 1),
(2661, 'TPS 21', 173, 11, 1, 1),
(2662, 'TPS 22', 173, 11, 1, 1),
(2663, 'TPS 23', 173, 11, 1, 1),
(2664, 'TPS 1', 176, 11, 1, 1),
(2665, 'TPS 2', 176, 11, 1, 1),
(2666, 'TPS 3', 176, 11, 1, 1),
(2667, 'TPS 4', 176, 11, 1, 1),
(2668, 'TPS 5', 176, 11, 1, 1),
(2669, 'TPS 6', 176, 11, 1, 1),
(2670, 'TPS 7', 176, 11, 1, 1),
(2671, 'TPS 8', 176, 11, 1, 1),
(2672, 'TPS 9', 176, 11, 1, 1),
(2673, 'TPS 10', 176, 11, 1, 1),
(2674, 'TPS 11', 176, 11, 1, 1),
(2675, 'TPS 12', 176, 11, 1, 1),
(2676, 'TPS 13', 176, 11, 1, 1),
(2677, 'TPS 14', 176, 11, 1, 1),
(2678, 'TPS 15', 176, 11, 1, 1),
(2679, 'TPS 16', 176, 11, 1, 1),
(2680, 'TPS 1', 183, 11, 1, 1),
(2681, 'TPS 2', 183, 11, 1, 1),
(2682, 'TPS 3', 183, 11, 1, 1),
(2683, 'TPS 4', 183, 11, 1, 1),
(2684, 'TPS 5', 183, 11, 1, 1),
(2685, 'TPS 6', 183, 11, 1, 1),
(2686, 'TPS 7', 183, 11, 1, 1),
(2687, 'TPS 8', 183, 11, 1, 1),
(2688, 'TPS 9', 183, 11, 1, 1),
(2689, 'TPS 10', 183, 11, 1, 1),
(2690, 'TPS 11', 183, 11, 1, 1),
(2691, 'TPS 12', 183, 11, 1, 1),
(2692, 'TPS 13', 183, 11, 1, 1),
(2693, 'TPS 14', 183, 11, 1, 1),
(2694, 'TPS 15', 183, 11, 1, 1),
(2695, 'TPS 16', 183, 11, 1, 1),
(2696, 'TPS 17', 183, 11, 1, 1),
(2697, 'TPS 18', 183, 11, 1, 1),
(2698, 'TPS 19', 183, 11, 1, 1),
(2699, 'TPS 20', 183, 11, 1, 1),
(2700, 'TPS 21', 183, 11, 1, 1),
(2701, 'TPS 22', 183, 11, 1, 1),
(2702, 'TPS 23', 183, 11, 1, 1),
(2703, 'TPS 24', 183, 11, 1, 1),
(2704, 'TPS 25', 183, 11, 1, 1),
(2705, 'TPS 26', 183, 11, 1, 1),
(2706, 'TPS 27', 183, 11, 1, 1),
(2707, 'TPS 28', 183, 11, 1, 1),
(2708, 'TPS 29', 183, 11, 1, 1),
(2709, 'TPS 30', 183, 11, 1, 1),
(2710, 'TPS 31', 183, 11, 1, 1),
(2711, 'TPS 1', 181, 11, 1, 1),
(2712, 'TPS 2', 181, 11, 1, 1),
(2713, 'TPS 3', 181, 11, 1, 1),
(2714, 'TPS 4', 181, 11, 1, 1),
(2715, 'TPS 5', 181, 11, 1, 1),
(2716, 'TPS 6', 181, 11, 1, 1),
(2717, 'TPS 7', 181, 11, 1, 1),
(2718, 'TPS 8', 181, 11, 1, 1),
(2719, 'TPS 9', 181, 11, 1, 1),
(2720, 'TPS 10', 181, 11, 1, 1),
(2721, 'TPS 11', 181, 11, 1, 1),
(2722, 'TPS 12', 181, 11, 1, 1),
(2723, 'TPS 13', 181, 11, 1, 1),
(2724, 'TPS 14', 181, 11, 1, 1),
(2725, 'TPS 15', 181, 11, 1, 1),
(2726, 'TPS 16', 181, 11, 1, 1),
(2727, 'TPS 17', 181, 11, 1, 1),
(2728, 'TPS 18', 181, 11, 1, 1),
(2729, 'TPS 1', 188, 11, 1, 1),
(2730, 'TPS 2', 188, 11, 1, 1),
(2731, 'TPS 3', 188, 11, 1, 1),
(2732, 'TPS 4', 188, 11, 1, 1),
(2733, 'TPS 5', 188, 11, 1, 1),
(2734, 'TPS 6', 188, 11, 1, 1),
(2735, 'TPS 7', 188, 11, 1, 1),
(2736, 'TPS 8', 188, 11, 1, 1),
(2737, 'TPS 9', 188, 11, 1, 1),
(2738, 'TPS 10', 188, 11, 1, 1),
(2739, 'TPS 11', 188, 11, 1, 1),
(2740, 'TPS 1', 186, 11, 1, 1),
(2741, 'TPS 2', 186, 11, 1, 1),
(2742, 'TPS 3', 186, 11, 1, 1),
(2743, 'TPS 4', 186, 11, 1, 1),
(2744, 'TPS 5', 186, 11, 1, 1),
(2745, 'TPS 6', 186, 11, 1, 1),
(2746, 'TPS 7', 186, 11, 1, 1),
(2747, 'TPS 8', 186, 11, 1, 1),
(2748, 'TPS 9', 186, 11, 1, 1),
(2749, 'TPS 10', 186, 11, 1, 1),
(2750, 'TPS 11', 186, 11, 1, 1),
(2751, 'TPS 1', 184, 11, 1, 1),
(2752, 'TPS 2', 184, 11, 1, 1),
(2753, 'TPS 3', 184, 11, 1, 1),
(2754, 'TPS 4', 184, 11, 1, 1),
(2755, 'TPS 5', 184, 11, 1, 1),
(2756, 'TPS 6', 184, 11, 1, 1),
(2757, 'TPS 7', 184, 11, 1, 1),
(2758, 'TPS 8', 184, 11, 1, 1),
(2759, 'TPS 9', 184, 11, 1, 1),
(2760, 'TPS 10', 184, 11, 1, 1),
(2761, 'TPS 11', 184, 11, 1, 1),
(2762, 'TPS 12', 184, 11, 1, 1),
(2763, 'TPS 13', 184, 11, 1, 1),
(2764, 'TPS 14', 184, 11, 1, 1),
(2765, 'TPS 1', 178, 11, 1, 1),
(2766, 'TPS 2', 178, 11, 1, 1),
(2767, 'TPS 3', 178, 11, 1, 1),
(2768, 'TPS 4', 178, 11, 1, 1),
(2769, 'TPS 5', 178, 11, 1, 1),
(2770, 'TPS 6', 178, 11, 1, 1),
(2771, 'TPS 7', 178, 11, 1, 1),
(2772, 'TPS 8', 178, 11, 1, 1),
(2773, 'TPS 9', 178, 11, 1, 1),
(2774, 'TPS 10', 178, 11, 1, 1),
(2775, 'TPS 11', 178, 11, 1, 1),
(2776, 'TPS 12', 178, 11, 1, 1),
(2777, 'TPS 13', 178, 11, 1, 1),
(2778, 'TPS 1', 191, 11, 1, 1),
(2779, 'TPS 2', 191, 11, 1, 1),
(2780, 'TPS 3', 191, 11, 1, 1),
(2781, 'TPS 4', 191, 11, 1, 1),
(2782, 'TPS 5', 191, 11, 1, 1),
(2783, 'TPS 6', 191, 11, 1, 1),
(2784, 'TPS 7', 191, 11, 1, 1),
(2785, 'TPS 8', 191, 11, 1, 1),
(2786, 'TPS 9', 191, 11, 1, 1),
(2787, 'TPS 10', 191, 11, 1, 1),
(2788, 'TPS 11', 191, 11, 1, 1),
(2789, 'TPS 12', 191, 11, 1, 1),
(2790, 'TPS 13', 191, 11, 1, 1),
(2791, 'TPS 14', 191, 11, 1, 1),
(2792, 'TPS 15', 191, 11, 1, 1),
(2793, 'TPS 16', 191, 11, 1, 1),
(2794, 'TPS 17', 191, 11, 1, 1),
(2795, 'TPS 18', 191, 11, 1, 1),
(2796, 'TPS 19', 191, 11, 1, 1),
(2797, 'TPS 20', 191, 11, 1, 1),
(2798, 'TPS 21', 191, 11, 1, 1),
(2799, 'TPS 22', 191, 11, 1, 1),
(2800, 'TPS 23', 191, 11, 1, 1),
(2801, 'TPS 24', 191, 11, 1, 1),
(2802, 'TPS 25', 191, 11, 1, 1),
(2803, 'TPS 26', 191, 11, 1, 1),
(2804, 'TPS 1', 190, 11, 1, 1),
(2805, 'TPS 2', 190, 11, 1, 1),
(2806, 'TPS 3', 190, 11, 1, 1),
(2807, 'TPS 4', 190, 11, 1, 1),
(2808, 'TPS 5', 190, 11, 1, 1),
(2809, 'TPS 6', 190, 11, 1, 1),
(2810, 'TPS 7', 190, 11, 1, 1),
(2811, 'TPS 8', 190, 11, 1, 1),
(2812, 'TPS 9', 190, 11, 1, 1),
(2813, 'TPS 10', 190, 11, 1, 1),
(2814, 'TPS 11', 190, 11, 1, 1),
(2815, 'TPS 12', 190, 11, 1, 1),
(2816, 'TPS 13', 190, 11, 1, 1),
(2817, 'TPS 1', 189, 11, 1, 1),
(2818, 'TPS 2', 189, 11, 1, 1),
(2819, 'TPS 3', 189, 11, 1, 1),
(2820, 'TPS 4', 189, 11, 1, 1),
(2821, 'TPS 5', 189, 11, 1, 1),
(2822, 'TPS 6', 189, 11, 1, 1),
(2823, 'TPS 7', 189, 11, 1, 1),
(2824, 'TPS 8', 189, 11, 1, 1),
(2825, 'TPS 9', 189, 11, 1, 1),
(2826, 'TPS 10', 189, 11, 1, 1),
(2827, 'TPS 11', 189, 11, 1, 1),
(2828, 'TPS 12', 189, 11, 1, 1),
(2829, 'TPS 13', 189, 11, 1, 1),
(2830, 'TPS 14', 189, 11, 1, 1),
(2831, 'TPS 15', 189, 11, 1, 1),
(2832, 'TPS 16', 189, 11, 1, 1),
(2833, 'TPS 17', 189, 11, 1, 1),
(2834, 'TPS 1', 177, 11, 1, 1),
(2835, 'TPS 2', 177, 11, 1, 1),
(2836, 'TPS 3', 177, 11, 1, 1),
(2837, 'TPS 4', 177, 11, 1, 1),
(2838, 'TPS 5', 177, 11, 1, 1),
(2839, 'TPS 6', 177, 11, 1, 1),
(2840, 'TPS 7', 177, 11, 1, 1),
(2841, 'TPS 8', 177, 11, 1, 1),
(2842, 'TPS 9', 177, 11, 1, 1),
(2843, 'TPS 10', 177, 11, 1, 1),
(2844, 'TPS 11', 177, 11, 1, 1),
(2845, 'TPS 12', 177, 11, 1, 1),
(2846, 'TPS 13', 177, 11, 1, 1),
(2847, 'TPS 14', 177, 11, 1, 1),
(2848, 'TPS 1', 194, 12, 1, 1),
(2849, 'TPS 2', 194, 12, 1, 1),
(2850, 'TPS 3', 194, 12, 1, 1),
(2851, 'TPS 4', 194, 12, 1, 1),
(2852, 'TPS 5', 194, 12, 1, 1),
(2853, 'TPS 6', 194, 12, 1, 1),
(2854, 'TPS 7', 194, 12, 1, 1),
(2855, 'TPS 8', 194, 12, 1, 1),
(2856, 'TPS 9', 194, 12, 1, 1),
(2857, 'TPS 10', 194, 12, 1, 1),
(2858, 'TPS 11', 194, 12, 1, 1),
(2859, 'TPS 12', 194, 12, 1, 1),
(2860, 'TPS 13', 194, 12, 1, 1),
(2861, 'TPS 14', 194, 12, 1, 1),
(2862, 'TPS 15', 194, 12, 1, 1),
(2863, 'TPS 16', 194, 12, 1, 1),
(2864, 'TPS 17', 194, 12, 1, 1),
(2865, 'TPS 18', 194, 12, 1, 1),
(2866, 'TPS 1', 193, 12, 1, 1),
(2867, 'TPS 2', 193, 12, 1, 1),
(2868, 'TPS 3', 193, 12, 1, 1),
(2869, 'TPS 4', 193, 12, 1, 1),
(2870, 'TPS 5', 193, 12, 1, 1),
(2871, 'TPS 6', 193, 12, 1, 1),
(2872, 'TPS 7', 193, 12, 1, 1),
(2873, 'TPS 8', 193, 12, 1, 1),
(2874, 'TPS 9', 193, 12, 1, 1),
(2875, 'TPS 10', 193, 12, 1, 1),
(2876, 'TPS 1', 211, 12, 1, 1),
(2877, 'TPS 2', 211, 12, 1, 1),
(2878, 'TPS 3', 211, 12, 1, 1),
(2879, 'TPS 4', 211, 12, 1, 1),
(2880, 'TPS 5', 211, 12, 1, 1),
(2881, 'TPS 6', 211, 12, 1, 1),
(2882, 'TPS 7', 211, 12, 1, 1),
(2883, 'TPS 8', 211, 12, 1, 1),
(2884, 'TPS 9', 211, 12, 1, 1),
(2885, 'TPS 10', 211, 12, 1, 1),
(2886, 'TPS 11', 211, 12, 1, 1),
(2887, 'TPS 12', 211, 12, 1, 1),
(2888, 'TPS 13', 211, 12, 1, 1),
(2889, 'TPS 14', 211, 12, 1, 1),
(2890, 'TPS 15', 211, 12, 1, 1),
(2891, 'TPS 1', 201, 12, 1, 1),
(2892, 'TPS 2', 201, 12, 1, 1),
(2893, 'TPS 3', 201, 12, 1, 1),
(2894, 'TPS 4', 201, 12, 1, 1),
(2895, 'TPS 5', 201, 12, 1, 1),
(2896, 'TPS 6', 201, 12, 1, 1),
(2897, 'TPS 7', 201, 12, 1, 1),
(2898, 'TPS 8', 201, 12, 1, 1),
(2899, 'TPS 9', 201, 12, 1, 1),
(2900, 'TPS 10', 201, 12, 1, 1),
(2901, 'TPS 11', 201, 12, 1, 1),
(2902, 'TPS 1', 200, 12, 1, 1),
(2903, 'TPS 2', 200, 12, 1, 1),
(2904, 'TPS 3', 200, 12, 1, 1),
(2905, 'TPS 4', 200, 12, 1, 1),
(2906, 'TPS 5', 200, 12, 1, 1),
(2907, 'TPS 6', 200, 12, 1, 1),
(2908, 'TPS 7', 200, 12, 1, 1),
(2909, 'TPS 8', 200, 12, 1, 1),
(2910, 'TPS 9', 200, 12, 1, 1),
(2911, 'TPS 10', 200, 12, 1, 1),
(2912, 'TPS 11', 200, 12, 1, 1),
(2913, 'TPS 1', 208, 12, 1, 1),
(2914, 'TPS 2', 208, 12, 1, 1),
(2915, 'TPS 3', 208, 12, 1, 1),
(2916, 'TPS 4', 208, 12, 1, 1),
(2917, 'TPS 5', 208, 12, 1, 1),
(2918, 'TPS 6', 208, 12, 1, 1),
(2919, 'TPS 7', 208, 12, 1, 1),
(2920, 'TPS 8', 208, 12, 1, 1),
(2921, 'TPS 1', 195, 12, 1, 1),
(2922, 'TPS 2', 195, 12, 1, 1),
(2923, 'TPS 3', 195, 12, 1, 1),
(2924, 'TPS 4', 195, 12, 1, 1),
(2925, 'TPS 5', 195, 12, 1, 1),
(2926, 'TPS 6', 195, 12, 1, 1),
(2927, 'TPS 7', 195, 12, 1, 1),
(2928, 'TPS 8', 195, 12, 1, 1),
(2929, 'TPS 9', 195, 12, 1, 1),
(2930, 'TPS 10', 195, 12, 1, 1),
(2931, 'TPS 11', 195, 12, 1, 1),
(2932, 'TPS 12', 195, 12, 1, 1),
(2933, 'TPS 13', 195, 12, 1, 1),
(2934, 'TPS 14', 195, 12, 1, 1),
(2935, 'TPS 15', 195, 12, 1, 1),
(2936, 'TPS 16', 195, 12, 1, 1),
(2937, 'TPS 17', 195, 12, 1, 1),
(2938, 'TPS 18', 195, 12, 1, 1),
(2939, 'TPS 19', 195, 12, 1, 1),
(2940, 'TPS 20', 195, 12, 1, 1),
(2941, 'TPS 21', 195, 12, 1, 1),
(2942, 'TPS 1', 204, 12, 1, 1),
(2943, 'TPS 2', 204, 12, 1, 1),
(2944, 'TPS 3', 204, 12, 1, 1),
(2945, 'TPS 4', 204, 12, 1, 1),
(2946, 'TPS 5', 204, 12, 1, 1),
(2947, 'TPS 6', 204, 12, 1, 1),
(2948, 'TPS 7', 204, 12, 1, 1),
(2949, 'TPS 8', 204, 12, 1, 1),
(2950, 'TPS 9', 204, 12, 1, 1),
(2951, 'TPS 10', 204, 12, 1, 1),
(2952, 'TPS 1', 203, 12, 1, 1),
(2953, 'TPS 2', 203, 12, 1, 1),
(2954, 'TPS 3', 203, 12, 1, 1),
(2955, 'TPS 4', 203, 12, 1, 1),
(2956, 'TPS 5', 203, 12, 1, 1),
(2957, 'TPS 6', 203, 12, 1, 1),
(2958, 'TPS 7', 203, 12, 1, 1),
(2959, 'TPS 8', 203, 12, 1, 1),
(2960, 'TPS 9', 203, 12, 1, 1),
(2961, 'TPS 10', 203, 12, 1, 1),
(2962, 'TPS 11', 203, 12, 1, 1),
(2963, 'TPS 12', 203, 12, 1, 1),
(2964, 'TPS 13', 203, 12, 1, 1),
(2965, 'TPS 14', 203, 12, 1, 1),
(2966, 'TPS 1', 197, 12, 1, 1),
(2967, 'TPS 2', 197, 12, 1, 1),
(2968, 'TPS 3', 197, 12, 1, 1),
(2969, 'TPS 4', 197, 12, 1, 1),
(2970, 'TPS 5', 197, 12, 1, 1),
(2971, 'TPS 6', 197, 12, 1, 1),
(2972, 'TPS 7', 197, 12, 1, 1),
(2973, 'TPS 8', 197, 12, 1, 1),
(2974, 'TPS 9', 197, 12, 1, 1),
(2975, 'TPS 10', 197, 12, 1, 1),
(2976, 'TPS 11', 197, 12, 1, 1),
(2977, 'TPS 12', 197, 12, 1, 1),
(2978, 'TPS 13', 197, 12, 1, 1),
(2979, 'TPS 1', 199, 12, 1, 1),
(2980, 'TPS 2', 199, 12, 1, 1),
(2981, 'TPS 3', 199, 12, 1, 1),
(2982, 'TPS 4', 199, 12, 1, 1),
(2983, 'TPS 5', 199, 12, 1, 1),
(2984, 'TPS 6', 199, 12, 1, 1),
(2985, 'TPS 7', 199, 12, 1, 1),
(2986, 'TPS 8', 199, 12, 1, 1),
(2987, 'TPS 1', 205, 12, 1, 1),
(2988, 'TPS 2', 205, 12, 1, 1),
(2989, 'TPS 3', 205, 12, 1, 1),
(2990, 'TPS 4', 205, 12, 1, 1),
(2991, 'TPS 5', 205, 12, 1, 1),
(2992, 'TPS 6', 205, 12, 1, 1),
(2993, 'TPS 7', 205, 12, 1, 1),
(2994, 'TPS 8', 205, 12, 1, 1),
(2995, 'TPS 9', 205, 12, 1, 1),
(2996, 'TPS 1', 206, 12, 1, 1),
(2997, 'TPS 2', 206, 12, 1, 1),
(2998, 'TPS 3', 206, 12, 1, 1),
(2999, 'TPS 4', 206, 12, 1, 1),
(3000, 'TPS 5', 206, 12, 1, 1),
(3001, 'TPS 6', 206, 12, 1, 1),
(3002, 'TPS 7', 206, 12, 1, 1),
(3003, 'TPS 8', 206, 12, 1, 1),
(3004, 'TPS 9', 206, 12, 1, 1),
(3005, 'TPS 10', 206, 12, 1, 1),
(3006, 'TPS 11', 206, 12, 1, 1),
(3007, 'TPS 12', 206, 12, 1, 1),
(3008, 'TPS 13', 206, 12, 1, 1),
(3009, 'TPS 14', 206, 12, 1, 1),
(3010, 'TPS 15', 206, 12, 1, 1),
(3011, 'TPS 16', 206, 12, 1, 1),
(3012, 'TPS 17', 206, 12, 1, 1),
(3013, 'TPS 18', 206, 12, 1, 1),
(3014, 'TPS 19', 206, 12, 1, 1),
(3015, 'TPS 20', 206, 12, 1, 1),
(3016, 'TPS 21', 206, 12, 1, 1),
(3017, 'TPS 22', 206, 12, 1, 1),
(3018, 'TPS 23', 206, 12, 1, 1),
(3019, 'TPS 24', 206, 12, 1, 1),
(3020, 'TPS 25', 206, 12, 1, 1),
(3021, 'TPS 1', 192, 12, 1, 1),
(3022, 'TPS 2', 192, 12, 1, 1),
(3023, 'TPS 3', 192, 12, 1, 1),
(3024, 'TPS 4', 192, 12, 1, 1),
(3025, 'TPS 5', 192, 12, 1, 1),
(3026, 'TPS 6', 192, 12, 1, 1),
(3027, 'TPS 7', 192, 12, 1, 1),
(3028, 'TPS 8', 192, 12, 1, 1),
(3029, 'TPS 9', 192, 12, 1, 1),
(3030, 'TPS 10', 192, 12, 1, 1),
(3031, 'TPS 11', 192, 12, 1, 1),
(3032, 'TPS 12', 192, 12, 1, 1),
(3033, 'TPS 13', 192, 12, 1, 1),
(3034, 'TPS 14', 192, 12, 1, 1),
(3035, 'TPS 15', 192, 12, 1, 1),
(3036, 'TPS 16', 192, 12, 1, 1),
(3037, 'TPS 1', 198, 12, 1, 1),
(3038, 'TPS 2', 198, 12, 1, 1),
(3039, 'TPS 3', 198, 12, 1, 1),
(3040, 'TPS 4', 198, 12, 1, 1),
(3041, 'TPS 5', 198, 12, 1, 1),
(3042, 'TPS 6', 198, 12, 1, 1),
(3043, 'TPS 7', 198, 12, 1, 1),
(3044, 'TPS 8', 198, 12, 1, 1),
(3045, 'TPS 9', 198, 12, 1, 1),
(3046, 'TPS 10', 198, 12, 1, 1),
(3047, 'TPS 11', 198, 12, 1, 1),
(3048, 'TPS 12', 198, 12, 1, 1),
(3049, 'TPS 13', 198, 12, 1, 1),
(3050, 'TPS 14', 198, 12, 1, 1),
(3051, 'TPS 15', 198, 12, 1, 1),
(3052, 'TPS 16', 198, 12, 1, 1),
(3053, 'TPS 1', 196, 12, 1, 1),
(3054, 'TPS 2', 196, 12, 1, 1),
(3055, 'TPS 3', 196, 12, 1, 1),
(3056, 'TPS 4', 196, 12, 1, 1),
(3057, 'TPS 5', 196, 12, 1, 1),
(3058, 'TPS 6', 196, 12, 1, 1),
(3059, 'TPS 7', 196, 12, 1, 1),
(3060, 'TPS 8', 196, 12, 1, 1),
(3061, 'TPS 9', 196, 12, 1, 1),
(3062, 'TPS 10', 196, 12, 1, 1),
(3063, 'TPS 1', 207, 12, 1, 1),
(3064, 'TPS 2', 207, 12, 1, 1),
(3065, 'TPS 3', 207, 12, 1, 1),
(3066, 'TPS 4', 207, 12, 1, 1),
(3067, 'TPS 5', 207, 12, 1, 1),
(3068, 'TPS 6', 207, 12, 1, 1),
(3069, 'TPS 7', 207, 12, 1, 1),
(3070, 'TPS 1', 202, 12, 1, 1),
(3071, 'TPS 2', 202, 12, 1, 1),
(3072, 'TPS 3', 202, 12, 1, 1),
(3073, 'TPS 4', 202, 12, 1, 1),
(3074, 'TPS 5', 202, 12, 1, 1),
(3075, 'TPS 6', 202, 12, 1, 1),
(3076, 'TPS 7', 202, 12, 1, 1),
(3077, 'TPS 8', 202, 12, 1, 1),
(3078, 'TPS 9', 202, 12, 1, 1),
(3079, 'TPS 10', 202, 12, 1, 1),
(3080, 'TPS 11', 202, 12, 1, 1),
(3081, 'TPS 12', 202, 12, 1, 1),
(3082, 'TPS 13', 202, 12, 1, 1),
(3083, 'TPS 1', 209, 12, 1, 1),
(3084, 'TPS 2', 209, 12, 1, 1),
(3085, 'TPS 3', 209, 12, 1, 1),
(3086, 'TPS 4', 209, 12, 1, 1),
(3087, 'TPS 5', 209, 12, 1, 1),
(3088, 'TPS 6', 209, 12, 1, 1),
(3089, 'TPS 7', 209, 12, 1, 1),
(3090, 'TPS 8', 209, 12, 1, 1),
(3091, 'TPS 1', 210, 12, 1, 1),
(3092, 'TPS 2', 210, 12, 1, 1),
(3093, 'TPS 3', 210, 12, 1, 1),
(3094, 'TPS 4', 210, 12, 1, 1),
(3095, 'TPS 5', 210, 12, 1, 1),
(3096, 'TPS 6', 210, 12, 1, 1),
(3097, 'TPS 7', 210, 12, 1, 1),
(3098, 'TPS 8', 210, 12, 1, 1),
(3099, 'TPS 9', 210, 12, 1, 1),
(3100, 'TPS 10', 210, 12, 1, 1),
(3101, 'TPS 1', 221, 13, 1, 1),
(3102, 'TPS 2', 221, 13, 1, 1),
(3103, 'TPS 3', 221, 13, 1, 1),
(3104, 'TPS 4', 221, 13, 1, 1),
(3105, 'TPS 5', 221, 13, 1, 1),
(3106, 'TPS 6', 221, 13, 1, 1),
(3107, 'TPS 7', 221, 13, 1, 1),
(3108, 'TPS 8', 221, 13, 1, 1),
(3109, 'TPS 1', 215, 13, 1, 1),
(3110, 'TPS 2', 215, 13, 1, 1),
(3111, 'TPS 3', 215, 13, 1, 1),
(3112, 'TPS 4', 215, 13, 1, 1),
(3113, 'TPS 5', 215, 13, 1, 1),
(3114, 'TPS 6', 215, 13, 1, 1),
(3115, 'TPS 7', 215, 13, 1, 1),
(3116, 'TPS 8', 215, 13, 1, 1),
(3117, 'TPS 9', 215, 13, 1, 1),
(3118, 'TPS 10', 215, 13, 1, 1),
(3119, 'TPS 11', 215, 13, 1, 1),
(3120, 'TPS 1', 222, 13, 1, 1),
(3121, 'TPS 2', 222, 13, 1, 1),
(3122, 'TPS 3', 222, 13, 1, 1),
(3123, 'TPS 4', 222, 13, 1, 1),
(3124, 'TPS 5', 222, 13, 1, 1),
(3125, 'TPS 6', 222, 13, 1, 1),
(3126, 'TPS 7', 222, 13, 1, 1),
(3127, 'TPS 8', 222, 13, 1, 1),
(3128, 'TPS 9', 222, 13, 1, 1),
(3129, 'TPS 10', 222, 13, 1, 1),
(3130, 'TPS 11', 222, 13, 1, 1),
(3131, 'TPS 12', 222, 13, 1, 1),
(3132, 'TPS 1', 213, 13, 1, 1),
(3133, 'TPS 2', 213, 13, 1, 1),
(3134, 'TPS 3', 213, 13, 1, 1),
(3135, 'TPS 4', 213, 13, 1, 1),
(3136, 'TPS 5', 213, 13, 1, 1),
(3137, 'TPS 6', 213, 13, 1, 1),
(3138, 'TPS 7', 213, 13, 1, 1),
(3139, 'TPS 8', 213, 13, 1, 1),
(3140, 'TPS 9', 213, 13, 1, 1),
(3141, 'TPS 10', 213, 13, 1, 1),
(3142, 'TPS 11', 213, 13, 1, 1),
(3143, 'TPS 12', 213, 13, 1, 1),
(3144, 'TPS 13', 213, 13, 1, 1),
(3145, 'TPS 14', 213, 13, 1, 1),
(3146, 'TPS 15', 213, 13, 1, 1),
(3147, 'TPS 16', 213, 13, 1, 1),
(3148, 'TPS 17', 213, 13, 1, 1),
(3149, 'TPS 18', 213, 13, 1, 1),
(3150, 'TPS 19', 213, 13, 1, 1),
(3151, 'TPS 20', 213, 13, 1, 1),
(3152, 'TPS 21', 213, 13, 1, 1),
(3153, 'TPS 22', 213, 13, 1, 1),
(3154, 'TPS 1', 220, 13, 1, 1),
(3155, 'TPS 2', 220, 13, 1, 1),
(3156, 'TPS 3', 220, 13, 1, 1),
(3157, 'TPS 4', 220, 13, 1, 1),
(3158, 'TPS 5', 220, 13, 1, 1),
(3159, 'TPS 6', 220, 13, 1, 1),
(3160, 'TPS 7', 220, 13, 1, 1),
(3161, 'TPS 8', 220, 13, 1, 1),
(3162, 'TPS 9', 220, 13, 1, 1),
(3163, 'TPS 10', 220, 13, 1, 1),
(3164, 'TPS 11', 220, 13, 1, 1),
(3165, 'TPS 1', 219, 13, 1, 1),
(3166, 'TPS 2', 219, 13, 1, 1),
(3167, 'TPS 3', 219, 13, 1, 1),
(3168, 'TPS 4', 219, 13, 1, 1),
(3169, 'TPS 5', 219, 13, 1, 1),
(3170, 'TPS 6', 219, 13, 1, 1),
(3171, 'TPS 7', 219, 13, 1, 1),
(3172, 'TPS 8', 219, 13, 1, 1),
(3173, 'TPS 9', 219, 13, 1, 1),
(3174, 'TPS 10', 219, 13, 1, 1),
(3175, 'TPS 11', 219, 13, 1, 1),
(3176, 'TPS 12', 219, 13, 1, 1),
(3177, 'TPS 1', 224, 13, 1, 1),
(3178, 'TPS 2', 224, 13, 1, 1),
(3179, 'TPS 3', 224, 13, 1, 1),
(3180, 'TPS 4', 224, 13, 1, 1),
(3181, 'TPS 5', 224, 13, 1, 1),
(3182, 'TPS 6', 224, 13, 1, 1),
(3183, 'TPS 7', 224, 13, 1, 1),
(3184, 'TPS 8', 224, 13, 1, 1),
(3185, 'TPS 9', 224, 13, 1, 1),
(3186, 'TPS 10', 224, 13, 1, 1),
(3187, 'TPS 1', 218, 13, 1, 1),
(3188, 'TPS 2', 218, 13, 1, 1),
(3189, 'TPS 3', 218, 13, 1, 1),
(3190, 'TPS 4', 218, 13, 1, 1),
(3191, 'TPS 5', 218, 13, 1, 1),
(3192, 'TPS 6', 218, 13, 1, 1),
(3193, 'TPS 7', 218, 13, 1, 1),
(3194, 'TPS 8', 218, 13, 1, 1),
(3195, 'TPS 9', 218, 13, 1, 1),
(3196, 'TPS 1', 214, 13, 1, 1),
(3197, 'TPS 2', 214, 13, 1, 1),
(3198, 'TPS 3', 214, 13, 1, 1),
(3199, 'TPS 4', 214, 13, 1, 1),
(3200, 'TPS 5', 214, 13, 1, 1),
(3201, 'TPS 6', 214, 13, 1, 1),
(3202, 'TPS 7', 214, 13, 1, 1),
(3203, 'TPS 8', 214, 13, 1, 1),
(3204, 'TPS 9', 214, 13, 1, 1),
(3205, 'TPS 10', 214, 13, 1, 1),
(3206, 'TPS 11', 214, 13, 1, 1),
(3207, 'TPS 12', 214, 13, 1, 1),
(3208, 'TPS 13', 214, 13, 1, 1),
(3209, 'TPS 14', 214, 13, 1, 1),
(3210, 'TPS 1', 216, 13, 1, 1),
(3211, 'TPS 2', 216, 13, 1, 1),
(3212, 'TPS 3', 216, 13, 1, 1),
(3213, 'TPS 4', 216, 13, 1, 1),
(3214, 'TPS 5', 216, 13, 1, 1),
(3215, 'TPS 6', 216, 13, 1, 1),
(3216, 'TPS 7', 216, 13, 1, 1),
(3217, 'TPS 8', 216, 13, 1, 1),
(3218, 'TPS 9', 216, 13, 1, 1),
(3219, 'TPS 10', 216, 13, 1, 1),
(3220, 'TPS 11', 216, 13, 1, 1),
(3221, 'TPS 12', 216, 13, 1, 1),
(3222, 'TPS 13', 216, 13, 1, 1),
(3223, 'TPS 14', 216, 13, 1, 1),
(3224, 'TPS 15', 216, 13, 1, 1),
(3225, 'TPS 16', 216, 13, 1, 1),
(3226, 'TPS 17', 216, 13, 1, 1),
(3227, 'TPS 1', 217, 13, 1, 1),
(3228, 'TPS 2', 217, 13, 1, 1),
(3229, 'TPS 3', 217, 13, 1, 1),
(3230, 'TPS 4', 217, 13, 1, 1),
(3231, 'TPS 5', 217, 13, 1, 1),
(3232, 'TPS 6', 217, 13, 1, 1),
(3233, 'TPS 7', 217, 13, 1, 1),
(3234, 'TPS 8', 217, 13, 1, 1),
(3235, 'TPS 9', 217, 13, 1, 1),
(3236, 'TPS 1', 228, 13, 1, 1),
(3237, 'TPS 2', 228, 13, 1, 1),
(3238, 'TPS 3', 228, 13, 1, 1),
(3239, 'TPS 4', 228, 13, 1, 1),
(3240, 'TPS 5', 228, 13, 1, 1),
(3241, 'TPS 6', 228, 13, 1, 1),
(3242, 'TPS 7', 228, 13, 1, 1),
(3243, 'TPS 8', 228, 13, 1, 1),
(3244, 'TPS 9', 228, 13, 1, 1),
(3245, 'TPS 10', 228, 13, 1, 1),
(3246, 'TPS 11', 228, 13, 1, 1),
(3247, 'TPS 12', 228, 13, 1, 1),
(3248, 'TPS 13', 228, 13, 1, 1),
(3249, 'TPS 14', 228, 13, 1, 1),
(3250, 'TPS 15', 228, 13, 1, 1),
(3251, 'TPS 1', 227, 13, 1, 1),
(3252, 'TPS 2', 227, 13, 1, 1),
(3253, 'TPS 3', 227, 13, 1, 1),
(3254, 'TPS 4', 227, 13, 1, 1),
(3255, 'TPS 5', 227, 13, 1, 1),
(3256, 'TPS 6', 227, 13, 1, 1),
(3257, 'TPS 7', 227, 13, 1, 1),
(3258, 'TPS 8', 227, 13, 1, 1),
(3259, 'TPS 9', 227, 13, 1, 1),
(3260, 'TPS 10', 227, 13, 1, 1),
(3261, 'TPS 1', 212, 13, 1, 1),
(3262, 'TPS 2', 212, 13, 1, 1),
(3263, 'TPS 3', 212, 13, 1, 1),
(3264, 'TPS 4', 212, 13, 1, 1),
(3265, 'TPS 5', 212, 13, 1, 1),
(3266, 'TPS 6', 212, 13, 1, 1),
(3267, 'TPS 7', 212, 13, 1, 1),
(3268, 'TPS 8', 212, 13, 1, 1),
(3269, 'TPS 9', 212, 13, 1, 1),
(3270, 'TPS 10', 212, 13, 1, 1),
(3271, 'TPS 11', 212, 13, 1, 1),
(3272, 'TPS 12', 212, 13, 1, 1),
(3273, 'TPS 13', 212, 13, 1, 1),
(3274, 'TPS 1', 223, 13, 1, 1),
(3275, 'TPS 2', 223, 13, 1, 1),
(3276, 'TPS 3', 223, 13, 1, 1),
(3277, 'TPS 4', 223, 13, 1, 1),
(3278, 'TPS 5', 223, 13, 1, 1),
(3279, 'TPS 6', 223, 13, 1, 1),
(3280, 'TPS 7', 223, 13, 1, 1),
(3281, 'TPS 8', 223, 13, 1, 1),
(3282, 'TPS 9', 223, 13, 1, 1),
(3283, 'TPS 10', 223, 13, 1, 1),
(3284, 'TPS 1', 226, 13, 1, 1),
(3285, 'TPS 2', 226, 13, 1, 1),
(3286, 'TPS 3', 226, 13, 1, 1),
(3287, 'TPS 4', 226, 13, 1, 1),
(3288, 'TPS 5', 226, 13, 1, 1),
(3289, 'TPS 6', 226, 13, 1, 1),
(3290, 'TPS 7', 226, 13, 1, 1),
(3291, 'TPS 8', 226, 13, 1, 1),
(3292, 'TPS 9', 226, 13, 1, 1),
(3293, 'TPS 10', 226, 13, 1, 1),
(3294, 'TPS 11', 226, 13, 1, 1),
(3295, 'TPS 12', 226, 13, 1, 1),
(3296, 'TPS 1', 225, 13, 1, 1),
(3297, 'TPS 2', 225, 13, 1, 1),
(3298, 'TPS 3', 225, 13, 1, 1),
(3299, 'TPS 4', 225, 13, 1, 1),
(3300, 'TPS 5', 225, 13, 1, 1),
(3301, 'TPS 6', 225, 13, 1, 1),
(3302, 'TPS 7', 225, 13, 1, 1),
(3303, 'TPS 8', 225, 13, 1, 1),
(3304, 'TPS 1', 231, 14, 1, 1),
(3305, 'TPS 2', 231, 14, 1, 1),
(3306, 'TPS 3', 231, 14, 1, 1),
(3307, 'TPS 4', 231, 14, 1, 1),
(3308, 'TPS 5', 231, 14, 1, 1),
(3309, 'TPS 6', 231, 14, 1, 1),
(3310, 'TPS 7', 231, 14, 1, 1),
(3311, 'TPS 8', 231, 14, 1, 1),
(3312, 'TPS 9', 231, 14, 1, 1),
(3313, 'TPS 10', 231, 14, 1, 1),
(3314, 'TPS 11', 231, 14, 1, 1),
(3315, 'TPS 12', 231, 14, 1, 1),
(3316, 'TPS 13', 231, 14, 1, 1),
(3317, 'TPS 1', 232, 14, 1, 1),
(3318, 'TPS 2', 232, 14, 1, 1),
(3319, 'TPS 3', 232, 14, 1, 1),
(3320, 'TPS 4', 232, 14, 1, 1),
(3321, 'TPS 5', 232, 14, 1, 1),
(3322, 'TPS 6', 232, 14, 1, 1),
(3323, 'TPS 7', 232, 14, 1, 1),
(3324, 'TPS 8', 232, 14, 1, 1),
(3325, 'TPS 9', 232, 14, 1, 1),
(3326, 'TPS 10', 232, 14, 1, 1),
(3327, 'TPS 11', 232, 14, 1, 1),
(3328, 'TPS 1', 234, 14, 1, 1),
(3329, 'TPS 2', 234, 14, 1, 1),
(3330, 'TPS 3', 234, 14, 1, 1),
(3331, 'TPS 4', 234, 14, 1, 1),
(3332, 'TPS 5', 234, 14, 1, 1),
(3333, 'TPS 6', 234, 14, 1, 1),
(3334, 'TPS 7', 234, 14, 1, 1),
(3335, 'TPS 8', 234, 14, 1, 1),
(3336, 'TPS 9', 234, 14, 1, 1),
(3337, 'TPS 10', 234, 14, 1, 1),
(3338, 'TPS 11', 234, 14, 1, 1),
(3339, 'TPS 12', 234, 14, 1, 1),
(3340, 'TPS 13', 234, 14, 1, 1),
(3341, 'TPS 14', 234, 14, 1, 1),
(3342, 'TPS 15', 234, 14, 1, 1),
(3343, 'TPS 16', 234, 14, 1, 1),
(3344, 'TPS 1', 235, 14, 1, 1),
(3345, 'TPS 2', 235, 14, 1, 1),
(3346, 'TPS 3', 235, 14, 1, 1),
(3347, 'TPS 4', 235, 14, 1, 1),
(3348, 'TPS 5', 235, 14, 1, 1),
(3349, 'TPS 6', 235, 14, 1, 1),
(3350, 'TPS 7', 235, 14, 1, 1),
(3351, 'TPS 8', 235, 14, 1, 1),
(3352, 'TPS 9', 235, 14, 1, 1),
(3353, 'TPS 10', 235, 14, 1, 1),
(3354, 'TPS 11', 235, 14, 1, 1),
(3355, 'TPS 12', 235, 14, 1, 1),
(3356, 'TPS 13', 235, 14, 1, 1),
(3357, 'TPS 14', 235, 14, 1, 1),
(3358, 'TPS 15', 235, 14, 1, 1),
(3359, 'TPS 16', 235, 14, 1, 1),
(3360, 'TPS 17', 235, 14, 1, 1),
(3361, 'TPS 18', 235, 14, 1, 1),
(3362, 'TPS 19', 235, 14, 1, 1),
(3363, 'TPS 20', 235, 14, 1, 1),
(3364, 'TPS 21', 235, 14, 1, 1),
(3365, 'TPS 22', 235, 14, 1, 1),
(3366, 'TPS 23', 235, 14, 1, 1),
(3367, 'TPS 24', 235, 14, 1, 1),
(3368, 'TPS 25', 235, 14, 1, 1),
(3369, 'TPS 26', 235, 14, 1, 1),
(3370, 'TPS 27', 235, 14, 1, 1),
(3371, 'TPS 28', 235, 14, 1, 1),
(3372, 'TPS 29', 235, 14, 1, 1),
(3373, 'TPS 30', 235, 14, 1, 1),
(3374, 'TPS 31', 235, 14, 1, 1),
(3375, 'TPS 32', 235, 14, 1, 1),
(3376, 'TPS 1', 236, 14, 1, 1),
(3377, 'TPS 2', 236, 14, 1, 1),
(3378, 'TPS 3', 236, 14, 1, 1),
(3379, 'TPS 4', 236, 14, 1, 1),
(3380, 'TPS 5', 236, 14, 1, 1),
(3381, 'TPS 6', 236, 14, 1, 1),
(3382, 'TPS 7', 236, 14, 1, 1),
(3383, 'TPS 8', 236, 14, 1, 1),
(3384, 'TPS 9', 236, 14, 1, 1),
(3385, 'TPS 10', 236, 14, 1, 1),
(3386, 'TPS 11', 236, 14, 1, 1),
(3387, 'TPS 12', 236, 14, 1, 1),
(3388, 'TPS 13', 236, 14, 1, 1),
(3389, 'TPS 1', 238, 14, 1, 1),
(3390, 'TPS 2', 238, 14, 1, 1),
(3391, 'TPS 3', 238, 14, 1, 1),
(3392, 'TPS 4', 238, 14, 1, 1),
(3393, 'TPS 5', 238, 14, 1, 1),
(3394, 'TPS 6', 238, 14, 1, 1),
(3395, 'TPS 7', 238, 14, 1, 1),
(3396, 'TPS 8', 238, 14, 1, 1),
(3397, 'TPS 9', 238, 14, 1, 1),
(3398, 'TPS 10', 238, 14, 1, 1),
(3399, 'TPS 11', 238, 14, 1, 1),
(3400, 'TPS 12', 238, 14, 1, 1),
(3401, 'TPS 1', 239, 14, 1, 1),
(3402, 'TPS 2', 239, 14, 1, 1),
(3403, 'TPS 3', 239, 14, 1, 1),
(3404, 'TPS 4', 239, 14, 1, 1),
(3405, 'TPS 5', 239, 14, 1, 1),
(3406, 'TPS 6', 239, 14, 1, 1),
(3407, 'TPS 7', 239, 14, 1, 1),
(3408, 'TPS 8', 239, 14, 1, 1),
(3409, 'TPS 9', 239, 14, 1, 1),
(3410, 'TPS 10', 239, 14, 1, 1),
(3411, 'TPS 1', 246, 14, 1, 1),
(3412, 'TPS 2', 246, 14, 1, 1),
(3413, 'TPS 3', 246, 14, 1, 1),
(3414, 'TPS 4', 246, 14, 1, 1),
(3415, 'TPS 5', 246, 14, 1, 1),
(3416, 'TPS 6', 246, 14, 1, 1),
(3417, 'TPS 7', 246, 14, 1, 1),
(3418, 'TPS 8', 246, 14, 1, 1),
(3419, 'TPS 9', 246, 14, 1, 1),
(3420, 'TPS 1', 237, 14, 1, 1),
(3421, 'TPS 2', 237, 14, 1, 1),
(3422, 'TPS 3', 237, 14, 1, 1),
(3423, 'TPS 4', 237, 14, 1, 1),
(3424, 'TPS 5', 237, 14, 1, 1),
(3425, 'TPS 6', 237, 14, 1, 1),
(3426, 'TPS 7', 237, 14, 1, 1),
(3427, 'TPS 8', 237, 14, 1, 1),
(3428, 'TPS 9', 237, 14, 1, 1),
(3429, 'TPS 10', 237, 14, 1, 1),
(3430, 'TPS 1', 241, 14, 1, 1),
(3431, 'TPS 2', 241, 14, 1, 1),
(3432, 'TPS 3', 241, 14, 1, 1),
(3433, 'TPS 4', 241, 14, 1, 1),
(3434, 'TPS 5', 241, 14, 1, 1),
(3435, 'TPS 6', 241, 14, 1, 1),
(3436, 'TPS 7', 241, 14, 1, 1),
(3437, 'TPS 8', 241, 14, 1, 1),
(3438, 'TPS 9', 241, 14, 1, 1),
(3439, 'TPS 10', 241, 14, 1, 1);
INSERT INTO `tps` (`id`, `tps`, `id_kel`, `id_kec`, `id_kab`, `id_prov`) VALUES
(3440, 'TPS 11', 241, 14, 1, 1),
(3441, 'TPS 12', 241, 14, 1, 1),
(3442, 'TPS 13', 241, 14, 1, 1),
(3443, 'TPS 14', 241, 14, 1, 1),
(3444, 'TPS 15', 241, 14, 1, 1),
(3445, 'TPS 16', 241, 14, 1, 1),
(3446, 'TPS 17', 241, 14, 1, 1),
(3447, 'TPS 18', 241, 14, 1, 1),
(3448, 'TPS 19', 241, 14, 1, 1),
(3449, 'TPS 20', 241, 14, 1, 1),
(3450, 'TPS 21', 241, 14, 1, 1),
(3451, 'TPS 22', 241, 14, 1, 1),
(3452, 'TPS 23', 241, 14, 1, 1),
(3453, 'TPS 24', 241, 14, 1, 1),
(3454, 'TPS 25', 241, 14, 1, 1),
(3455, 'TPS 1', 244, 14, 1, 1),
(3456, 'TPS 2', 244, 14, 1, 1),
(3457, 'TPS 3', 244, 14, 1, 1),
(3458, 'TPS 4', 244, 14, 1, 1),
(3459, 'TPS 5', 244, 14, 1, 1),
(3460, 'TPS 6', 244, 14, 1, 1),
(3461, 'TPS 7', 244, 14, 1, 1),
(3462, 'TPS 8', 244, 14, 1, 1),
(3463, 'TPS 9', 244, 14, 1, 1),
(3464, 'TPS 10', 244, 14, 1, 1),
(3465, 'TPS 11', 244, 14, 1, 1),
(3466, 'TPS 12', 244, 14, 1, 1),
(3467, 'TPS 13', 244, 14, 1, 1),
(3468, 'TPS 14', 244, 14, 1, 1),
(3469, 'TPS 15', 244, 14, 1, 1),
(3470, 'TPS 16', 244, 14, 1, 1),
(3471, 'TPS 17', 244, 14, 1, 1),
(3472, 'TPS 18', 244, 14, 1, 1),
(3473, 'TPS 19', 244, 14, 1, 1),
(3474, 'TPS 20', 244, 14, 1, 1),
(3475, 'TPS 21', 244, 14, 1, 1),
(3476, 'TPS 22', 244, 14, 1, 1),
(3477, 'TPS 23', 244, 14, 1, 1),
(3478, 'TPS 24', 244, 14, 1, 1),
(3479, 'TPS 25', 244, 14, 1, 1),
(3480, 'TPS 26', 244, 14, 1, 1),
(3481, 'TPS 27', 244, 14, 1, 1),
(3482, 'TPS 28', 244, 14, 1, 1),
(3483, 'TPS 29', 244, 14, 1, 1),
(3484, 'TPS 30', 244, 14, 1, 1),
(3485, 'TPS 31', 244, 14, 1, 1),
(3486, 'TPS 32', 244, 14, 1, 1),
(3487, 'TPS 33', 244, 14, 1, 1),
(3488, 'TPS 34', 244, 14, 1, 1),
(3489, 'TPS 1', 230, 14, 1, 1),
(3490, 'TPS 2', 230, 14, 1, 1),
(3491, 'TPS 3', 230, 14, 1, 1),
(3492, 'TPS 4', 230, 14, 1, 1),
(3493, 'TPS 5', 230, 14, 1, 1),
(3494, 'TPS 6', 230, 14, 1, 1),
(3495, 'TPS 7', 230, 14, 1, 1),
(3496, 'TPS 8', 230, 14, 1, 1),
(3497, 'TPS 9', 230, 14, 1, 1),
(3498, 'TPS 10', 230, 14, 1, 1),
(3499, 'TPS 1', 240, 14, 1, 1),
(3500, 'TPS 2', 240, 14, 1, 1),
(3501, 'TPS 3', 240, 14, 1, 1),
(3502, 'TPS 4', 240, 14, 1, 1),
(3503, 'TPS 5', 240, 14, 1, 1),
(3504, 'TPS 6', 240, 14, 1, 1),
(3505, 'TPS 7', 240, 14, 1, 1),
(3506, 'TPS 8', 240, 14, 1, 1),
(3507, 'TPS 9', 240, 14, 1, 1),
(3508, 'TPS 10', 240, 14, 1, 1),
(3509, 'TPS 11', 240, 14, 1, 1),
(3510, 'TPS 12', 240, 14, 1, 1),
(3511, 'TPS 13', 240, 14, 1, 1),
(3512, 'TPS 14', 240, 14, 1, 1),
(3513, 'TPS 15', 240, 14, 1, 1),
(3514, 'TPS 16', 240, 14, 1, 1),
(3515, 'TPS 17', 240, 14, 1, 1),
(3516, 'TPS 1', 242, 14, 1, 1),
(3517, 'TPS 2', 242, 14, 1, 1),
(3518, 'TPS 3', 242, 14, 1, 1),
(3519, 'TPS 4', 242, 14, 1, 1),
(3520, 'TPS 5', 242, 14, 1, 1),
(3521, 'TPS 6', 242, 14, 1, 1),
(3522, 'TPS 7', 242, 14, 1, 1),
(3523, 'TPS 8', 242, 14, 1, 1),
(3524, 'TPS 9', 242, 14, 1, 1),
(3525, 'TPS 10', 242, 14, 1, 1),
(3526, 'TPS 11', 242, 14, 1, 1),
(3527, 'TPS 12', 242, 14, 1, 1),
(3528, 'TPS 13', 242, 14, 1, 1),
(3529, 'TPS 14', 242, 14, 1, 1),
(3530, 'TPS 15', 242, 14, 1, 1),
(3531, 'TPS 16', 242, 14, 1, 1),
(3532, 'TPS 17', 242, 14, 1, 1),
(3533, 'TPS 18', 242, 14, 1, 1),
(3534, 'TPS 19', 242, 14, 1, 1),
(3535, 'TPS 1', 233, 14, 1, 1),
(3536, 'TPS 2', 233, 14, 1, 1),
(3537, 'TPS 3', 233, 14, 1, 1),
(3538, 'TPS 4', 233, 14, 1, 1),
(3539, 'TPS 5', 233, 14, 1, 1),
(3540, 'TPS 6', 233, 14, 1, 1),
(3541, 'TPS 7', 233, 14, 1, 1),
(3542, 'TPS 8', 233, 14, 1, 1),
(3543, 'TPS 9', 233, 14, 1, 1),
(3544, 'TPS 10', 233, 14, 1, 1),
(3545, 'TPS 11', 233, 14, 1, 1),
(3546, 'TPS 12', 233, 14, 1, 1),
(3547, 'TPS 13', 233, 14, 1, 1),
(3548, 'TPS 1', 247, 14, 1, 1),
(3549, 'TPS 2', 247, 14, 1, 1),
(3550, 'TPS 3', 247, 14, 1, 1),
(3551, 'TPS 4', 247, 14, 1, 1),
(3552, 'TPS 5', 247, 14, 1, 1),
(3553, 'TPS 6', 247, 14, 1, 1),
(3554, 'TPS 7', 247, 14, 1, 1),
(3555, 'TPS 8', 247, 14, 1, 1),
(3556, 'TPS 9', 247, 14, 1, 1),
(3557, 'TPS 10', 247, 14, 1, 1),
(3558, 'TPS 11', 247, 14, 1, 1),
(3559, 'TPS 1', 245, 14, 1, 1),
(3560, 'TPS 2', 245, 14, 1, 1),
(3561, 'TPS 3', 245, 14, 1, 1),
(3562, 'TPS 4', 245, 14, 1, 1),
(3563, 'TPS 5', 245, 14, 1, 1),
(3564, 'TPS 6', 245, 14, 1, 1),
(3565, 'TPS 7', 245, 14, 1, 1),
(3566, 'TPS 8', 245, 14, 1, 1),
(3567, 'TPS 9', 245, 14, 1, 1),
(3568, 'TPS 1', 248, 14, 1, 1),
(3569, 'TPS 2', 248, 14, 1, 1),
(3570, 'TPS 3', 248, 14, 1, 1),
(3571, 'TPS 4', 248, 14, 1, 1),
(3572, 'TPS 5', 248, 14, 1, 1),
(3573, 'TPS 6', 248, 14, 1, 1),
(3574, 'TPS 7', 248, 14, 1, 1),
(3575, 'TPS 8', 248, 14, 1, 1),
(3576, 'TPS 9', 248, 14, 1, 1),
(3577, 'TPS 10', 248, 14, 1, 1),
(3578, 'TPS 11', 248, 14, 1, 1),
(3579, 'TPS 12', 248, 14, 1, 1),
(3580, 'TPS 13', 248, 14, 1, 1),
(3581, 'TPS 14', 248, 14, 1, 1),
(3582, 'TPS 15', 248, 14, 1, 1),
(3583, 'TPS 16', 248, 14, 1, 1),
(3584, 'TPS 17', 248, 14, 1, 1),
(3585, 'TPS 18', 248, 14, 1, 1),
(3586, 'TPS 1', 243, 14, 1, 1),
(3587, 'TPS 2', 243, 14, 1, 1),
(3588, 'TPS 3', 243, 14, 1, 1),
(3589, 'TPS 4', 243, 14, 1, 1),
(3590, 'TPS 5', 243, 14, 1, 1),
(3591, 'TPS 6', 243, 14, 1, 1),
(3592, 'TPS 7', 243, 14, 1, 1),
(3593, 'TPS 8', 243, 14, 1, 1),
(3594, 'TPS 9', 243, 14, 1, 1),
(3595, 'TPS 10', 243, 14, 1, 1),
(3596, 'TPS 11', 243, 14, 1, 1),
(3597, 'TPS 12', 243, 14, 1, 1),
(3598, 'TPS 13', 243, 14, 1, 1),
(3599, 'TPS 14', 243, 14, 1, 1),
(3600, 'TPS 15', 243, 14, 1, 1),
(3601, 'TPS 16', 243, 14, 1, 1),
(3602, 'TPS 17', 243, 14, 1, 1),
(3603, 'TPS 1', 229, 14, 1, 1),
(3604, 'TPS 2', 229, 14, 1, 1),
(3605, 'TPS 3', 229, 14, 1, 1),
(3606, 'TPS 4', 229, 14, 1, 1),
(3607, 'TPS 5', 229, 14, 1, 1),
(3608, 'TPS 6', 229, 14, 1, 1),
(3609, 'TPS 7', 229, 14, 1, 1),
(3610, 'TPS 8', 229, 14, 1, 1),
(3611, 'TPS 9', 229, 14, 1, 1),
(3612, 'TPS 10', 229, 14, 1, 1),
(3613, 'TPS 11', 229, 14, 1, 1),
(3614, 'TPS 12', 229, 14, 1, 1),
(3615, 'TPS 13', 229, 14, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(2) NOT NULL,
  `username` varchar(25) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `id_saksi` int(2) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'l' COMMENT '''l'' untuk data masih digunakan, ''d'' untuk data sudah dihapus',
  `role_id` int(1) DEFAULT '123'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `pass`, `id_saksi`, `status`, `role_id`) VALUES
(1, '3322423974879066', '$2y$10$nNpw3KvE4WM3ZIrUb8rRhutB1GwaalCR7kh/VJNW/.ujgN30yaJdy', 1, 'l', 123);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `id_details` (`id_details`);

--
-- Indexes for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `suara_desa`
--
ALTER TABLE `suara_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kel` (`id_kel`),
  ADD KEY `id_partai` (`id_partai`);

--
-- Indexes for table `tps`
--
ALTER TABLE `tps`
  ADD PRIMARY KEY (`id`),
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
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `admin_details`
--
ALTER TABLE `admin_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dapil`
--
ALTER TABLE `dapil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `kab`
--
ALTER TABLE `kab`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `kec`
--
ALTER TABLE `kec`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `kel`
--
ALTER TABLE `kel`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;
--
-- AUTO_INCREMENT for table `partai`
--
ALTER TABLE `partai`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `pil`
--
ALTER TABLE `pil`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;
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
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `suara`
--
ALTER TABLE `suara`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `suara_desa`
--
ALTER TABLE `suara_desa`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tps`
--
ALTER TABLE `tps`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3616;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_details`) REFERENCES `admin_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `saksi_rel_kab` FOREIGN KEY (`id_kab`) REFERENCES `kab` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `saksi_rel_kec` FOREIGN KEY (`id_kec`) REFERENCES `kec` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `saksi_rel_kel` FOREIGN KEY (`id_kel`) REFERENCES `kel` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `saksi_rel_prov` FOREIGN KEY (`id_prov`) REFERENCES `prov` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `saksi_tps` FOREIGN KEY (`id_tps`) REFERENCES `tps` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `suara_desa`
--
ALTER TABLE `suara_desa`
  ADD CONSTRAINT `suara_desa_ibfk_3` FOREIGN KEY (`id_kel`) REFERENCES `kel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `suara_desa_ibfk_4` FOREIGN KEY (`id_partai`) REFERENCES `partai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tps`
--
ALTER TABLE `tps`
  ADD CONSTRAINT `tps_ibfk_2` FOREIGN KEY (`id_kel`) REFERENCES `kel` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tps_ibfk_3` FOREIGN KEY (`id_kec`) REFERENCES `kec` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tps_ibfk_4` FOREIGN KEY (`id_kab`) REFERENCES `kab` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tps_ibfk_5` FOREIGN KEY (`id_prov`) REFERENCES `prov` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
