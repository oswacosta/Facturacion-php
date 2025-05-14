-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2025 a las 00:00:35
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `informatic`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `telefono`, `direccion`) VALUES
(2, 'Ainhoa', 'Rodríguez Collado', '65646546', 'C/Clara Sánchez, 12'),
(3, 'Rubén', 'López', '65845642', 'Madrid'),
(4, 'Carlos', 'Sánchez', '64483333', 'Málaga'),
(5, 'Oswaldo', 'Acosta', '654718222', 'Madrid');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `proveedor` varchar(100) DEFAULT NULL,
  `producto` varchar(100) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `proveedor`, `producto`, `cantidad`, `precio_unitario`, `total`, `fecha`) VALUES
(1, 'electronic', 'teclado', 5, 58, 290, '2025-04-29'),
(2, 'informatic', 'pantalla', 5, 24, 120, '2025-05-13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `puesto` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_compras`
--

CREATE TABLE `facturas_compras` (
  `id` int(11) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `observaciones` text DEFAULT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas_compras`
--

INSERT INTO `facturas_compras` (`id`, `proveedor_id`, `numero_factura`, `fecha`, `observaciones`, `total`) VALUES
(1, 3, '1234567', '2025-05-11', '', 5.00),
(2, 3, '122222', '2025-05-11', '', 10.00),
(3, 2, '1234356', '2025-05-11', '', 2.00),
(4, 3, '1234567', '2025-05-12', '', 25.00),
(5, 3, '1234567', '2025-05-12', '', 10.00),
(6, 2, '123456', '2025-05-14', '', 5.00),
(7, 2, '12345677', '2025-05-14', '', 5.00),
(8, 3, '1234556', '2025-05-14', '', 45.00),
(9, 3, '1234567', '2025-05-14', '', 5.00),
(10, 2, '123344', '2025-05-14', '', 5.00),
(11, 4, '123344', '2025-05-14', '', 5.00),
(12, 2, '12312314', '2025-05-14', '', 5.00),
(13, 2, '12312314', '2025-05-14', '', 5.00),
(14, 2, '12312314', '2025-05-14', '', 5.00),
(15, 2, '123123123', '2025-05-14', '', 75.00),
(16, 3, '12345678', '2025-05-14', '', 10.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_ventas`
--

CREATE TABLE `facturas_ventas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `observaciones` text DEFAULT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_factura_compra`
--

CREATE TABLE `lineas_factura_compra` (
  `id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total_linea` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lineas_factura_compra`
--

INSERT INTO `lineas_factura_compra` (`id`, `factura_id`, `producto_id`, `cantidad`, `precio_unitario`, `total_linea`) VALUES
(1, 1, 2, 1, 5.00, 5.00),
(2, 2, 5, 2, 5.00, 10.00),
(3, 3, 5, 1, 2.00, 2.00),
(4, 4, 5, 1, 5.00, 5.00),
(5, 4, 2, 2, 10.00, 20.00),
(6, 5, 2, 1, 5.00, 5.00),
(7, 5, 5, 1, 5.00, 5.00),
(8, 6, 2, 1, 5.00, 5.00),
(9, 7, 3, 1, 5.00, 5.00),
(10, 8, 2, 3, 5.00, 15.00),
(11, 8, 3, 3, 5.00, 15.00),
(12, 8, 5, 3, 5.00, 15.00),
(13, 9, 2, 1, 5.00, 5.00),
(14, 10, 2, 1, 5.00, 5.00),
(15, 11, 2, 1, 5.00, 5.00),
(16, 12, 2, 1, 5.00, 5.00),
(17, 13, 2, 1, 5.00, 5.00),
(18, 14, 2, 1, 5.00, 5.00),
(19, 15, 2, 5, 5.00, 25.00),
(20, 15, 3, 5, 5.00, 25.00),
(21, 15, 5, 5, 5.00, 25.00),
(22, 16, 3, 1, 10.00, 10.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_factura_venta`
--

CREATE TABLE `lineas_factura_venta` (
  `id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total_linea` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cliente` varchar(255) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente`, `producto`, `cantidad`, `precio_unitario`, `total`, `fecha`) VALUES
(1, 'Elon', 'Tesla Model X', 1, 50000.00, 50000.00, '2025-05-11'),
(2, 'Asus', 'Portatil', 1, 1500.00, 1500.00, '2025-05-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `iva` decimal(5,2) DEFAULT NULL,
  `pvp` decimal(10,2) DEFAULT NULL,
  `almacen` varchar(100) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `tipo`, `iva`, `pvp`, `almacen`, `cantidad`) VALUES
(2, 'Auriculares Bluetooth', 'Sony', 21.00, 6.00, '', 10),
(3, 'Teclado', 'Logitech', 21.00, 58.00, '1', 4),
(5, 'Cargador', 'Tipo C', 21.00, 24.99, '', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `contacto`, `telefono`, `direccion`) VALUES
(2, 'Techno Imp', 'Carlos', '45647365', 'Madrid'),
(3, 'Electronic Master', 'Miguel Rodriguez', '54846415', 'Madrid'),
(4, 'Auriculares Inc.', 'Maria', '45646152', 'Madrid'),
(5, 'Tesla', 'Elon Musk', '12345653', 'Madrid');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `contraseña`) VALUES
(1, 'ainhoa@email.com', '20dfb63cf951e15515deca932d70be9d7ae631a6484b20e4a723bdfaf9b6bcd5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `cliente` varchar(100) DEFAULT NULL,
  `producto` varchar(100) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` float DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `cliente`, `producto`, `cantidad`, `precio_unitario`, `total`, `fecha`) VALUES
(1, 'roberto', 'teclado', 2, 5, 10.00, '2025-05-06'),
(2, '2', 'monitor', 1, 5, 5.00, '2025-05-11'),
(9, '2', NULL, NULL, NULL, 42.99, '2025-05-12'),
(16, '3', NULL, NULL, NULL, 88.99, '2025-05-14'),
(17, '2', NULL, NULL, NULL, 58.00, '2025-05-14');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facturas_compras`
--
ALTER TABLE `facturas_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedor_id` (`proveedor_id`);

--
-- Indices de la tabla `facturas_ventas`
--
ALTER TABLE `facturas_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `lineas_factura_compra`
--
ALTER TABLE `lineas_factura_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factura_id` (`factura_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `lineas_factura_venta`
--
ALTER TABLE `lineas_factura_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factura_id` (`factura_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas_compras`
--
ALTER TABLE `facturas_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `facturas_ventas`
--
ALTER TABLE `facturas_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `lineas_factura_compra`
--
ALTER TABLE `lineas_factura_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `lineas_factura_venta`
--
ALTER TABLE `lineas_factura_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `facturas_compras`
--
ALTER TABLE `facturas_compras`
  ADD CONSTRAINT `facturas_compras_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`);

--
-- Filtros para la tabla `facturas_ventas`
--
ALTER TABLE `facturas_ventas`
  ADD CONSTRAINT `facturas_ventas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lineas_factura_compra`
--
ALTER TABLE `lineas_factura_compra`
  ADD CONSTRAINT `lineas_factura_compra_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `facturas_compras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lineas_factura_compra_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `lineas_factura_venta`
--
ALTER TABLE `lineas_factura_venta`
  ADD CONSTRAINT `lineas_factura_venta_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `facturas_ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lineas_factura_venta_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
