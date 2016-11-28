-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Nov 27, 2016 at 07:05 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `reports`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_customer`(IN `cst_id` INT)
BEGIN
 delete from customer_fone where customer_id=cst_id;
 delete from customer_emails where customer_id=cst_id;
 delete from customer_address where customer_id=cst_id;
 delete from customer_social_name where customer_id=cst_id;
 delete from customer_social_name where customer_id=cst_id;
 delete from customers where id=cst_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `type` char(4) NOT NULL DEFAULT '0',
  `document` char(15) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `type`, `document`) VALUES
(12, 'Cadmiel Jorges', '2', '24234234234234'),
(14, 'Thiago Silva', '1', '52098262280'),
(15, 'Marcelina Rodrigo', '2', '45125745000115'),
(16, 'Lucas Silva', '1', '80360354807'),
(17, 'Vinicius Ramos', '2', '94653744000159');

--
-- Triggers `customers`
--
DELIMITER $$
CREATE TRIGGER `customer_delete_trigger` BEFORE DELETE ON `customers`
 FOR EACH ROW BEGIN
INSERT INTO customer_update
SET action = 'update', customer_id=OLD.id,
name =  OLD.name,
update_at = NOW();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `customer_update_trigger` BEFORE UPDATE ON `customers`
 FOR EACH ROW BEGIN
INSERT INTO customer_update
SET action = 'update', customer_id=OLD.id,
name =  OLD.name,
update_at = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `customers_view`
--
CREATE TABLE `customers_view` (
`id` int(10) unsigned
,`name` varchar(50)
,`document` char(15)
,`address` varchar(50)
,`email` varchar(50)
,`fone` varchar(50)
,`type` varchar(8)
,`social_name` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `id` int(11) unsigned NOT NULL,
  `customer_id` int(11) unsigned NOT NULL,
  `address` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_emails`
--

CREATE TABLE `customer_emails` (
  `id` int(11) unsigned NOT NULL,
  `customer_id` int(11) unsigned NOT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_emails`
--

INSERT INTO `customer_emails` (`id`, `customer_id`, `email`) VALUES
(19, 14, 'thiagosilva@hotmail.com'),
(20, 15, 'marcelina@hotmail.com'),
(21, 12, 'cadmieljorge@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `customer_fone`
--

CREATE TABLE `customer_fone` (
  `id` int(11) unsigned NOT NULL,
  `customer_id` int(11) unsigned NOT NULL,
  `fone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_social_name`
--

CREATE TABLE `customer_social_name` (
  `id` int(11) unsigned NOT NULL,
  `customer_id` int(11) unsigned NOT NULL,
  `social_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_social_name`
--

INSERT INTO `customer_social_name` (`id`, `customer_id`, `social_name`) VALUES
(9, 17, 'Global project'),
(12, 15, 'Minuto Seguro Ltda'),
(13, 12, 'Porto Seguro');

-- --------------------------------------------------------

--
-- Table structure for table `customer_update`
--

CREATE TABLE `customer_update` (
  `id` int(11) unsigned NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_update`
--

INSERT INTO `customer_update` (`id`, `customer_id`, `name`, `action`, `update_at`) VALUES
(1, 19, 'teste', 'update', '2016-11-27 16:04:35'),
(2, 19, 'teste cd', 'update', '2016-11-27 16:04:47'),
(3, 19, 'teste cd jorge', 'update', '2016-11-27 16:04:56');

-- --------------------------------------------------------

--
-- Structure for view `customers_view`
--
DROP TABLE IF EXISTS `customers_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customers_view` AS select `customers`.`id` AS `id`,`customers`.`name` AS `name`,`customers`.`document` AS `document`,`customer_address`.`address` AS `address`,`customer_emails`.`email` AS `email`,`customer_fone`.`fone` AS `fone`,if((`customers`.`type` = 1),'Física','Juridica') AS `type`,if(isnull(`customer_social_name`.`social_name`),'-',`customer_social_name`.`social_name`) AS `social_name` from ((((`customers` left join `customer_address` on((`customer_address`.`customer_id` = `customers`.`id`))) left join `customer_emails` on((`customer_emails`.`customer_id` = `customers`.`id`))) left join `customer_fone` on((`customer_fone`.`customer_id` = `customers`.`id`))) left join `customer_social_name` on((`customer_social_name`.`customer_id` = `customers`.`id`))) group by `customers`.`id`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD KEY `id` (`id`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD KEY `id` (`id`),
  ADD KEY `fk_address_customer_id` (`customer_id`);

--
-- Indexes for table `customer_emails`
--
ALTER TABLE `customer_emails`
  ADD KEY `id` (`id`),
  ADD KEY `fk_email_customer_id` (`customer_id`);

--
-- Indexes for table `customer_fone`
--
ALTER TABLE `customer_fone`
  ADD KEY `id` (`id`),
  ADD KEY `fk_fone_customer_id` (`customer_id`);

--
-- Indexes for table `customer_social_name`
--
ALTER TABLE `customer_social_name`
  ADD KEY `id` (`id`),
  ADD KEY `fk_social_name_customer_id` (`customer_id`);

--
-- Indexes for table `customer_update`
--
ALTER TABLE `customer_update`
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `customer_emails`
--
ALTER TABLE `customer_emails`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `customer_fone`
--
ALTER TABLE `customer_fone`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `customer_social_name`
--
ALTER TABLE `customer_social_name`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `customer_update`
--
ALTER TABLE `customer_update`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD CONSTRAINT `fk_address_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `customer_emails`
--
ALTER TABLE `customer_emails`
  ADD CONSTRAINT `fk_email_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `customer_fone`
--
ALTER TABLE `customer_fone`
  ADD CONSTRAINT `fk_fone_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `customer_social_name`
--
ALTER TABLE `customer_social_name`
  ADD CONSTRAINT `fk_social_name_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);
