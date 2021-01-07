-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 06 Oca 2021, 20:12:09
-- Sunucu sürümü: 10.4.14-MariaDB
-- PHP Sürümü: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `restapi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `authentication`
--

CREATE TABLE `authentication` (
  `id` int(11) NOT NULL,
  `user` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `authorization` varchar(10) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `authentication`
--

INSERT INTO `authentication` (`id`, `user`, `pass`, `authorization`) VALUES
(1, 'beratyavuzyigit', '202cb962ac59075b964b07152d234b70', '1111');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `product_desc` text COLLATE utf8_turkish_ci NOT NULL,
  `img_url` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `product_price` float NOT NULL,
  `product_discount` int(11) NOT NULL,
  `product_status` tinyint(4) NOT NULL,
  `products_author` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `created_at` varchar(25) COLLATE utf8_turkish_ci NOT NULL,
  `stock_code` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_desc`, `img_url`, `product_price`, `product_discount`, `product_status`, `products_author`, `created_at`, `stock_code`, `views`) VALUES
(1, 'Apple iPhone XS 64GB', 'Buraya ürün açıklaması gelecek', 'urun_resim/urun1.jpg', 10200, 0, 1, 'beratyavuzyigit', '04.01.2021 20:17', 'IPH-XS64', 2156),
(2, 'Samsung Galaxy A11 32GB ', 'Buraya ürün açıklaması gelecek', 'urun_resim/urun2.jpg', 2000, 50, 1, 'beratyavuzyigit', '04.01.2021 22:30', 'SAM-GA11', 2156),
(3, 'URUN_TEST', 'restapi post test updated', 'urun_resim/test.jpg', 20, 0, 1, 'beratyavuzyigit', '06.01.2021 02.44.AM', 'TEST-001', 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `authentication`
--
ALTER TABLE `authentication`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `authentication`
--
ALTER TABLE `authentication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
