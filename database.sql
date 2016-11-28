-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           10.0.20-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.4.0.5127
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para reports
CREATE DATABASE IF NOT EXISTS `reports` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `reports`;

-- Copiando estrutura para tabela reports.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `type` char(4) NOT NULL DEFAULT '0',
  `document` char(15) NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela reports.customers: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

-- Copiando estrutura para tabela reports.customer_address
CREATE TABLE IF NOT EXISTS `customer_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) unsigned NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  KEY `id` (`id`),
  KEY `fk_address_customer_id` (`customer_id`),
  CONSTRAINT `fk_address_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela reports.customer_address: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `customer_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_address` ENABLE KEYS */;

-- Copiando estrutura para tabela reports.customer_emails
CREATE TABLE IF NOT EXISTS `customer_emails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) unsigned NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  KEY `id` (`id`),
  KEY `fk_email_customer_id` (`customer_id`),
  CONSTRAINT `fk_email_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela reports.customer_emails: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `customer_emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_emails` ENABLE KEYS */;

-- Copiando estrutura para tabela reports.customer_fone
CREATE TABLE IF NOT EXISTS `customer_fone` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) unsigned NOT NULL,
  `fone` varchar(50) DEFAULT NULL,
  KEY `id` (`id`),
  KEY `fk_fone_customer_id` (`customer_id`),
  CONSTRAINT `fk_fone_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `customer_social_name` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) unsigned NOT NULL,
  `social_name` varchar(50) DEFAULT NULL,
  KEY `id` (`id`),
  KEY `fk_social_name_customer_id` (`customer_id`),
  CONSTRAINT `fk_social_name_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `customer_update` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` int(11) unsigned NOT NULL,
   `action` varchar(50) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- Procedures
--
DROP PROCEDURE IF EXISTS delete_customer;
DELIMITER $$
CREATE PROCEDURE `delete_customer`(cst_id INT)
BEGIN
 delete from customer_fone where customer_id=cst_id;
 delete from customer_emails where customer_id=cst_id;
 delete from customer_address where customer_id=cst_id;
 delete from customers where id=cst_id; 
END$$


CREATE VIEW customers_view as
SELECT
customers.id,customers.name,customers.type,customers.document,
customer_address.address,
customer_emails.email,
customer_fone.fone,
if(customers.type=1,'Física','Juridica') as type,
if(customer_social_name.social_name is null,'-',customer_social_name.social_name) as social_name
FROM customers
LEFT JOIN customer_address on customer_address.customer_id = customers.id
LEFT JOIN customer_emails on customer_emails.customer_id = customers.id
LEFT JOIN customer_fone on customer_fone.customer_id = customers.id
LEFT JOIN customer_social_name on customer_social_name.customer_id=customers.id
group by customers.id;
-- Copiando dados para a tabela reports.customer_fone: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `customer_fone` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_fone` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;


DELIMITER $$
CREATE TRIGGER customer_update_trigger
BEFORE UPDATE ON customers
FOR EACH ROW BEGIN
INSERT INTO customer_update
SET action = 'update', customer_id=OLD.id,
name =  OLD.name,
update_at = NOW();
END$$

DELIMITER $$
CREATE TRIGGER customer_delete_trigger
BEFORE DELETE ON customers
FOR EACH ROW BEGIN
INSERT INTO customer_update
SET action = 'update', customer_id=OLD.id,
name =  OLD.name,
update_at = NOW();
END$$
