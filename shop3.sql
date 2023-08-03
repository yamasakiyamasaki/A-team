-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2023-08-01 08:41:45
-- サーバのバージョン： 10.4.28-MariaDB
-- PHP のバージョン: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `shop3`
--
CREATE DATABASE shop3;
USE shop3;
-- --------------------------------------------------------

--
-- テーブルの構造 `shop3`
--

CREATE TABLE `shop3` (
  `id` int(20) NOT NULL,
  `order_date` date NOT NULL,
  `itemA` int(20) NOT NULL,
  `itemB` int(20) NOT NULL,
  `itemC` int(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `zip01` varchar(20) NOT NULL,
  `addr11` varchar(100) NOT NULL,
  `total_amount` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `shop3`
--

INSERT INTO `shop3` (`id`, `order_date`, `itemA`, `itemB`, `itemC`, `name`, `email`, `zip01`, `addr11`, `total_amount`) VALUES
(27, '2023-08-01', 1, 1, 1, 'シナモン', 'kimimarosan@arigatou.com', '5360023', '大阪府大阪市城東区東中浜1-1', 2070),
(28, '2023-08-01', 1, 1, 1, 'マイメロ', 'tokenai@ice.com', '5360023', '大阪府大阪市城東区東中浜1-1', 2070),
(30, '2023-08-01', 1, 1, 1, 'キティ', 'kimimarosan@arigatou.com', '5360023', '大阪府大阪市城東区東中浜1-1', 2070),
(31, '2023-08-01', 1, 1, 1, 'チャーミーキティ', 'kimimarosan@arigatou.com', '5360023', '大阪府大阪市城東区東中浜1-1', 2070);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `shop3`
--
ALTER TABLE `shop3`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `shop3`
--
ALTER TABLE `shop3`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
