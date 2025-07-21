-- Database: `db_crud_example`

CREATE DATABASE IF NOT EXISTS `db_crud_example`;
USE `db_crud_example`;

-- Table structure for table `emp`
CREATE TABLE IF NOT EXISTS `emp` (
  `nim` INT(12) NOT NULL,
  `nama_lengkap` VARCHAR(150) NOT NULL,
  `alamat` TEXT NOT NULL,
  `jurusan` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
