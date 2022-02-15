CREATE SCHEMA db_storeRP;
USE db_storeRP;
CREATE TABLE `customers` (
  
  cust_id int(11) NOT NULL AUTO_INCREMENT,
  credential_id int(11),
  names varchar(45),
  paternal varchar(45),
  maternal varchar(45),
  phone varchar(20),
  gender char(1),
  registration_date date,
  
  PRIMARY KEY (`cust_id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
CREATE TABLE `vendors` (

  vendor_id int(11) NOT NULL AUTO_INCREMENT,
  credential_id int(11),
  business_id int(11),
  names varchar(45),
  paternal varchar(45),
  maternal varchar(45),
  phone varchar(20),
  gender char(1),
  registration_date date,
  
  PRIMARY KEY (`vendor_id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
CREATE TABLE `business` (
  business_id int(11) NOT NULL AUTO_INCREMENT,
  vendor_id int(11),
  name varchar(45),
  address text,
  about text,
  phone varchar(20),
  email varchar(45),
  image blob,
  PRIMARY KEY (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
CREATE TABLE `addresses_customers` (

  address_id int(11) NOT NULL AUTO_INCREMENT,
  cust_id int(11),
  address text,
  default_address boolean NOT NULL DEFAULT 0,
  PRIMARY KEY (`address_id`)

) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8mb4;
CREATE TABLE `addresses_vendors` (

  address_id int(11) NOT NULL AUTO_INCREMENT,
  vendor_id int(11),
  address text,
  default_address boolean NOT NULL DEFAULT 0,
  PRIMARY KEY (`address_id`)

) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8mb4;
CREATE TABLE `credentials` (
  credential_id int(11) NOT NULL AUTO_INCREMENT,
  vendor_id int(11),
  cust_id int(11),
  email varchar(45),
  passwd varchar(45),
  role ENUM('Vendor', 'Customer') NOT NULL,

  PRIMARY KEY (`credential_id`)

) ENGINE=InnoDB AUTO_INCREMENT=100;
CREATE TABLE `products` (
  product_id int(11) NOT NULL AUTO_INCREMENT,
  vendor_id int(11),
  business_id int(11),
  product_name varchar(45),
  description text,
  price int(11),
  brand varchar(45),
  quantity int(11),
  category varchar(45),
  image blob,
  registration_date date NOT NULL,

  PRIMARY KEY (`product_id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
CREATE TABLE `files` (
  file_id int(11) NOT NULL AUTO_INCREMENT,
  product_id int(11),
  name varchar(45),
  path varchar(45),
  description text,

  PRIMARY KEY (`file_id`)

) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4;
ALTER TABLE `addresses_customers`
  ADD CONSTRAINT `FK_CustomerForAddress` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`) ON DELETE CASCADE;
ALTER TABLE `addresses_vendors`
  ADD CONSTRAINT `FK_VendorForAddress` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`) ON DELETE CASCADE;
ALTER TABLE `business`
  ADD CONSTRAINT `FK_VendorForBusiness` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`) ON DELETE CASCADE;
ALTER TABLE `credentials`
  ADD CONSTRAINT `FK_CustomerForCredentials` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_VendorForCredentials` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`) ON DELETE CASCADE;
ALTER TABLE `products`
  ADD CONSTRAINT `FK_BusinessForProduct` FOREIGN KEY (`business_id`) REFERENCES `business` (`business_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_VendorForProduct` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`) ON DELETE CASCADE;
ALTER TABLE `files`
  ADD CONSTRAINT `FK_ProductForFile` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;




DROP TRIGGER IF EXISTS `InsertCustomerID_onCredentials`;
DELIMITER $$
CREATE TRIGGER `InsertCustomerID_onCredentials` AFTER INSERT ON `customers` FOR EACH ROW BEGIN
 INSERT INTO `credentials`(`vendor_id`, `cust_id`, `email`, `passwd`, `role`) VALUES (NULL,NEW.cust_id,NULL,NULL,'Customer'); 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `InsertVendorID_onBusiness`;
DELIMITER $$
CREATE TRIGGER `InsertVendorID_onBusiness` AFTER INSERT ON `vendors` FOR EACH ROW BEGIN
	INSERT INTO `business`(`vendor_id`, `name`, `address`, `about`, `phone`, `email`, `image`) VALUES (NEW.vendor_id,NULL,NULL,NULL,NULL,NULL,NULL);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `InsertVendorID_onCredentials`;
DELIMITER $$
CREATE TRIGGER `InsertVendorID_onCredentials` AFTER INSERT ON `vendors` FOR EACH ROW BEGIN
INSERT INTO `credentials`(`vendor_id`, `cust_id`, `email`, `passwd`, `role`) VALUES (NEW.vendor_id,NULL,NULL,NULL,'Vendor');
END
$$
DELIMITER ;
