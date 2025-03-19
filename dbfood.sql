-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2020 at 07:58 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbfood`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbfood`
--

CREATE TABLE `tbfood` (
  `food_id` int(11) NOT NULL,
  `fldvendor_id` int(11) NOT NULL,
  `foodname` varchar(100) NOT NULL,
  `cost` bigint(15) NOT NULL,
  `cuisines` varchar(50) NOT NULL,
  `paymentmode` varchar(50) NOT NULL,
  `fldimage` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbfood`
--

INSERT INTO `tbfood` (`food_id`, `fldvendor_id`, `foodname`, `cost`, `cuisines`, `paymentmode`, `fldimage`) VALUES
(1, 25, 'Egg Fried Rice', 120, 'Chinese', 'Non-Veg', 'fried_rice.jpg'),
(2, 26, 'Burger', 75, 'Fast Food', 'Non-Veg', 'photo-1534790566855-4cb788d389ec.jpg'),
(3, 26, 'Pizza', 150, 'Italian', 'Veg', 'phut_0.jpg'),
(4, 25, 'Chow mein', 60, 'Chinese', 'Veg', 'vegchow-mein.jpg'),
(5, 27, 'Chole Kulche', 50, 'Indian', 'Veg', 'maxresdefault.jpg'),
(6, 27, 'Shahi Panner', 118, 'Indian', 'Veg', 'Shahi-Paneer-Recipe.jpg'),
(7, 26, 'Sushi', 200, 'Japanese', 'Non-Veg', 'makisushi.jpg'),
(8, 27, 'Butter Chicken', 250, 'Indian', 'Non-Veg', 'butterchi.jpg'),
(9, 27, 'Dal Fry', 200, 'Indian', 'Veg', 'Dhaba_Style_Dal_Fry_Recipe-1.jpg'),
(10, 25, 'Chicken Shawarma', 90, ' Middle Eastern', 'Non-Veg', '9dbe823a-5bae-47cf-be42-ee5e886a0378.jpg'),
(11, 25, 'Veg Manchurian', 175, 'Chinese', 'Veg', 'manchu.webp');

-- --------------------------------------------------------

--
-- Table structure for table `tblcart`
--

CREATE TABLE `tblcart` (
  `fld_cart_id` int(11) NOT NULL,
  `fld_product_id` bigint(11) NOT NULL,
  `fld_customer_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomer`
--

CREATE TABLE `tblcustomer` (
  `fld_cust_id` int(10) NOT NULL,
  `fld_name` varchar(30) NOT NULL,
  `fld_email` varchar(30) NOT NULL,
  `fld_mobile` bigint(10) NOT NULL,
  `fld_preference` text NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcustomer`
--

INSERT INTO `tblcustomer` (`fld_cust_id`, `fld_name`, `fld_email`, `fld_mobile`, `fld_preference`, `password`) VALUES
(1, 'Sam', 'sam@email.com', 9956247821, 'Veg', '123456'),
(2, 'Anish', 'anish@email.com', 9725632148, 'Non-Veg', '123456'),
(3, 'Rahul', 'rahul@email.com', 9326587412, 'Non-Veg', '123456'),
(4, 'Sweta', 'sweta@email.com', 9154823657, 'Veg', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `tblmessage`
--

CREATE TABLE `tblmessage` (
  `fld_msg_id` int(10) NOT NULL,
  `fld_name` varchar(50) NOT NULL,
  `fld_email` varchar(50) NOT NULL,
  `fld_phone` bigint(10) DEFAULT NULL,
  `fld_msg` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblorder`
--

CREATE TABLE `tblorder` (
  `fld_order_id` int(10) NOT NULL,
  `fld_cart_id` bigint(10) NOT NULL,
  `fldvendor_id` bigint(10) DEFAULT NULL,
  `fld_food_id` bigint(10) DEFAULT NULL,
  `fld_email_id` varchar(50) DEFAULT NULL,
  `fld_payment` varchar(20) DEFAULT NULL,
  `fldstatus` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblorder`
--

INSERT INTO `tblorder` (`fld_order_id`, `fld_cart_id`, `fldvendor_id`, `fld_food_id`, `fld_email_id`, `fld_payment`, `fldstatus`) VALUES
(1, 22, 25, 4, 'sweta@email.com', '60', 'Out Of Stock'),
(2, 24, 25, 4, 'sam@email.com', '60', 'cancelled'),
(3, 25, 27, 6, 'sam@email.com', '118', 'Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `tblvendor`
--

CREATE TABLE `tblvendor` (
  `fldvendor_id` int(10) NOT NULL,
  `fld_name` varchar(30) NOT NULL,
  `fld_email` varchar(50) NOT NULL,
  `fld_password` varchar(50) NOT NULL,
  `fld_mob` bigint(10) NOT NULL,
  `fld_address` varchar(50) NOT NULL,
  `fld_logo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblvendor`
--

INSERT INTO `tblvendor` (`fldvendor_id`, `fld_name`, `fld_email`, `fld_password`, `fld_mob`, `fld_address`, `fld_logo`) VALUES
(25, 'Jhon\'s Kitchen', 'john@email.com', '123456', 9955123657, 'Kolkata', 'john.jpg'),
(26, 'Hotel Eden', 'hoteleden@email.com', '123456', 9568712354, 'Delhi', 'hotel_eden.jpg'),
(27, 'D Dhaba', 'ddhaba@email.com', '123456', 9563214785, 'Punjab', 'dhaba.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbfood`
--
ALTER TABLE `tbfood`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `fldvendor_id` (`fldvendor_id`);

--
-- Indexes for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD PRIMARY KEY (`fld_cart_id`);

--
-- Indexes for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  ADD PRIMARY KEY (`fld_cust_id`);

--
-- Indexes for table `tblmessage`
--
ALTER TABLE `tblmessage`
  ADD PRIMARY KEY (`fld_msg_id`);

--
-- Indexes for table `tblorder`
--
ALTER TABLE `tblorder`
  ADD PRIMARY KEY (`fld_order_id`);

--
-- Indexes for table `tblvendor`
--
ALTER TABLE `tblvendor`
  ADD PRIMARY KEY (`fldvendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbfood`
--
ALTER TABLE `tbfood`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblcart`
--
ALTER TABLE `tblcart`
  MODIFY `fld_cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  MODIFY `fld_cust_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblmessage`
--
ALTER TABLE `tblmessage`
  MODIFY `fld_msg_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblorder`
--
ALTER TABLE `tblorder`
  MODIFY `fld_order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblvendor`
--
ALTER TABLE `tblvendor`
  MODIFY `fldvendor_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbfood`
--
ALTER TABLE `tbfood`
  ADD CONSTRAINT `tbfood_ibfk_1` FOREIGN KEY (`fldvendor_id`) REFERENCES `tblvendor` (`fldvendor_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
