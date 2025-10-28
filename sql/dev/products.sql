CREATE TABLE `PRODUCTS` (
  `cod` INT AUTO_INCREMENT PRIMARY KEY,
  `short_name` varchar(20) NOT NULL,
  `pvp` decimal(5,2) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `PRODUCTS` (`cod`, `short_name`, `pvp`, `nombre`) VALUES
(1, 'HD', '100.00', 'Samsung'),
(2, 'NOTEBOOK', '800.00', 'Lenovo IdeaPad'),
(3, 'MOUSE', '20.00', 'Logitech M90');