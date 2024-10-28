-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-10-2024 a las 02:50:02
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tiendaonline`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_articulo`
--

CREATE TABLE `tbl_articulo` (
  `id_articulo_pk` int(11) NOT NULL,
  `nombre_articulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `precio_unitario` float NOT NULL,
  `inventario` int(11) NOT NULL,
  `id_categoria_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carrito`
--

CREATE TABLE `tbl_carrito` (
  `id_carrito_pk` int(11) NOT NULL,
  `id_cliente_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_categoria`
--

CREATE TABLE `tbl_categoria` (
  `id_categoria_pk` int(11) NOT NULL,
  `nombre_categoria` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cliente`
--

CREATE TABLE `tbl_cliente` (
  `id_cliente_pk` int(11) NOT NULL,
  `membresia` varchar(255) NOT NULL,
  `id_tienda_fk` int(11) NOT NULL,
  `id_usuario_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detalle_carrito`
--

CREATE TABLE `tbl_detalle_carrito` (
  `id_detalle_carrito_pk` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_articulo_fk` int(11) NOT NULL,
  `id_carrito_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detalle_factura`
--

CREATE TABLE `tbl_detalle_factura` (
  `id_detalle_factura_pk` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL,
  `id_factura_fk` int(11) NOT NULL,
  `id_carrito_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_empleado`
--

CREATE TABLE `tbl_empleado` (
  `id_empleado_pk` int(11) NOT NULL,
  `fecha_contratacion` date NOT NULL,
  `id_tipo_empleado_fk` int(11) NOT NULL,
  `id_usuario_fk` int(11) NOT NULL,
  `id_tienda_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_factura`
--

CREATE TABLE `tbl_factura` (
  `id_factura_pk` int(11) NOT NULL,
  `fecha_emision` date NOT NULL,
  `subtotal` float NOT NULL,
  `impuesto` float NOT NULL,
  `total` float NOT NULL,
  `numero_factura` int(11) NOT NULL,
  `id_venta_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log`
--

CREATE TABLE `tbl_log` (
  `id_log_pk` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `evento` varchar(300) NOT NULL,
  `detalles` varchar(300) NOT NULL,
  `id_usuario_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tienda`
--

CREATE TABLE `tbl_tienda` (
  `id_tienda_pk` int(11) NOT NULL,
  `nombre_tienda` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_empleado`
--

CREATE TABLE `tbl_tipo_empleado` (
  `id_tipo_empleado_pk` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_pago`
--

CREATE TABLE `tbl_tipo_pago` (
  `id_tipo_pago_pk` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `id_usuario_pk` int(11) NOT NULL,
  `nombre_tienda` varchar(100) NOT NULL,
  `apellido_usuario` varchar(100) NOT NULL,
  `fecha_registro` date NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_venta`
--

CREATE TABLE `tbl_venta` (
  `id_venta_pk` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `subtotal` float NOT NULL,
  `impuesto` float NOT NULL,
  `total` float NOT NULL,
  `id_cliente_fk` int(11) NOT NULL,
  `id_empleado_fk` int(11) NOT NULL,
  `id_tipo_pago_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_articulo`
--
ALTER TABLE `tbl_articulo`
  ADD PRIMARY KEY (`id_articulo_pk`),
  ADD KEY `fk_tbl_articulo_tbl_categoria_idx` (`id_categoria_fk`);

--
-- Indices de la tabla `tbl_carrito`
--
ALTER TABLE `tbl_carrito`
  ADD PRIMARY KEY (`id_carrito_pk`);

--
-- Indices de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  ADD PRIMARY KEY (`id_categoria_pk`);

--
-- Indices de la tabla `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  ADD PRIMARY KEY (`id_cliente_pk`,`id_usuario_fk`),
  ADD KEY `fk_tbl_cliente_tbl_usuario_idx` (`id_usuario_fk`),
  ADD KEY `fk_tbl_cliente_tbl_tienda_idx` (`id_tienda_fk`);

--
-- Indices de la tabla `tbl_detalle_carrito`
--
ALTER TABLE `tbl_detalle_carrito`
  ADD PRIMARY KEY (`id_detalle_carrito_pk`),
  ADD KEY `fk_tbl_detalle_carrito_tbl_articulo_idx` (`id_articulo_fk`),
  ADD KEY `fk_tbl_detalle_carrito_tbl_carrito_idx` (`id_carrito_fk`) USING BTREE;

--
-- Indices de la tabla `tbl_detalle_factura`
--
ALTER TABLE `tbl_detalle_factura`
  ADD PRIMARY KEY (`id_detalle_factura_pk`,`id_carrito_fk`),
  ADD KEY `fk_tbl_detalle_factura_tbl_factura_idx` (`id_factura_fk`),
  ADD KEY `fk_tbl_detalle_factura_tbl_carrito_idx` (`id_carrito_fk`);

--
-- Indices de la tabla `tbl_empleado`
--
ALTER TABLE `tbl_empleado`
  ADD PRIMARY KEY (`id_empleado_pk`,`id_usuario_fk`),
  ADD KEY `fk_tbl_empleado_tbl_usuario_idx` (`id_usuario_fk`) USING BTREE,
  ADD KEY `fk_tbl_empleado_tbl_tienda_idx` (`id_tienda_fk`),
  ADD KEY `fk_tbl_empleado_tbl_tipo_empleado_idx` (`id_tipo_empleado_fk`);

--
-- Indices de la tabla `tbl_factura`
--
ALTER TABLE `tbl_factura`
  ADD PRIMARY KEY (`id_factura_pk`,`id_venta_fk`),
  ADD KEY `fk_tbl_factura_tbl_venta_idx` (`id_venta_fk`);

--
-- Indices de la tabla `tbl_log`
--
ALTER TABLE `tbl_log`
  ADD PRIMARY KEY (`id_log_pk`),
  ADD KEY `fk_tbl_log_tbl_usuario_idx` (`id_usuario_fk`);

--
-- Indices de la tabla `tbl_tienda`
--
ALTER TABLE `tbl_tienda`
  ADD PRIMARY KEY (`id_tienda_pk`);

--
-- Indices de la tabla `tbl_tipo_empleado`
--
ALTER TABLE `tbl_tipo_empleado`
  ADD PRIMARY KEY (`id_tipo_empleado_pk`);

--
-- Indices de la tabla `tbl_tipo_pago`
--
ALTER TABLE `tbl_tipo_pago`
  ADD PRIMARY KEY (`id_tipo_pago_pk`);

--
-- Indices de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`id_usuario_pk`);

--
-- Indices de la tabla `tbl_venta`
--
ALTER TABLE `tbl_venta`
  ADD PRIMARY KEY (`id_venta_pk`),
  ADD KEY `fk_tbl_venta_tbl_cliente_idx` (`id_cliente_fk`),
  ADD KEY `fk_tbl_venta_tbl_empleado_idx` (`id_empleado_fk`),
  ADD KEY `fk_tbl_venta_tbl_tipo_pago_idx` (`id_tipo_pago_fk`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_articulo`
--
ALTER TABLE `tbl_articulo`
  MODIFY `id_articulo_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_carrito`
--
ALTER TABLE `tbl_carrito`
  MODIFY `id_carrito_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  MODIFY `id_categoria_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  MODIFY `id_cliente_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_detalle_carrito`
--
ALTER TABLE `tbl_detalle_carrito`
  MODIFY `id_detalle_carrito_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_detalle_factura`
--
ALTER TABLE `tbl_detalle_factura`
  MODIFY `id_detalle_factura_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_empleado`
--
ALTER TABLE `tbl_empleado`
  MODIFY `id_empleado_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_factura`
--
ALTER TABLE `tbl_factura`
  MODIFY `id_factura_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_log`
--
ALTER TABLE `tbl_log`
  MODIFY `id_log_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_tienda`
--
ALTER TABLE `tbl_tienda`
  MODIFY `id_tienda_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_empleado`
--
ALTER TABLE `tbl_tipo_empleado`
  MODIFY `id_tipo_empleado_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_pago`
--
ALTER TABLE `tbl_tipo_pago`
  MODIFY `id_tipo_pago_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  MODIFY `id_usuario_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_venta`
--
ALTER TABLE `tbl_venta`
  MODIFY `id_venta_pk` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_articulo`
--
ALTER TABLE `tbl_articulo`
  ADD CONSTRAINT `flk_tbl_articulo_tbl_categoria` FOREIGN KEY (`id_categoria_fk`) REFERENCES `tbl_categoria` (`id_categoria_pk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  ADD CONSTRAINT `fk_tbl_cliente_tbl_tienda` FOREIGN KEY (`id_tienda_fk`) REFERENCES `tbl_tienda` (`id_tienda_pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tbl_cliente_tbl_usuario` FOREIGN KEY (`id_usuario_fk`) REFERENCES `tbl_usuario` (`id_usuario_pk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_detalle_carrito`
--
ALTER TABLE `tbl_detalle_carrito`
  ADD CONSTRAINT `fk_tbl_detalle_carrito_tbl_articulo` FOREIGN KEY (`id_articulo_fk`) REFERENCES `tbl_articulo` (`id_articulo_pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tbl_detalle_carrito_tbl_carrito` FOREIGN KEY (`id_carrito_fk`) REFERENCES `tbl_carrito` (`id_carrito_pk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_detalle_factura`
--
ALTER TABLE `tbl_detalle_factura`
  ADD CONSTRAINT `fk_tbl_detalle_factura_tbl_carrito` FOREIGN KEY (`id_carrito_fk`) REFERENCES `tbl_carrito` (`id_carrito_pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tbl_detalle_factura_tbl_factura` FOREIGN KEY (`id_factura_fk`) REFERENCES `tbl_factura` (`id_factura_pk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_empleado`
--
ALTER TABLE `tbl_empleado`
  ADD CONSTRAINT `fk_tbl_empleado_tbl_tienda` FOREIGN KEY (`id_tienda_fk`) REFERENCES `tbl_tienda` (`id_tienda_pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tbl_empleado_tbl_tipo_empleado` FOREIGN KEY (`id_tipo_empleado_fk`) REFERENCES `tbl_tipo_empleado` (`id_tipo_empleado_pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tbl_empleado_tbl_usuario` FOREIGN KEY (`id_usuario_fk`) REFERENCES `tbl_usuario` (`id_usuario_pk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_factura`
--
ALTER TABLE `tbl_factura`
  ADD CONSTRAINT `fk_tbl_factuta_tbl_venta` FOREIGN KEY (`id_venta_fk`) REFERENCES `tbl_venta` (`id_venta_pk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_log`
--
ALTER TABLE `tbl_log`
  ADD CONSTRAINT `fk_tbl_log_tbl_usuario` FOREIGN KEY (`id_usuario_fk`) REFERENCES `tbl_usuario` (`id_usuario_pk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_venta`
--
ALTER TABLE `tbl_venta`
  ADD CONSTRAINT `fk_tbl_venta_tbl_cliente` FOREIGN KEY (`id_cliente_fk`) REFERENCES `tbl_cliente` (`id_cliente_pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tbl_venta_tbl_empleado` FOREIGN KEY (`id_empleado_fk`) REFERENCES `tbl_empleado` (`id_empleado_pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tbl_venta_tbl_tipo_pago` FOREIGN KEY (`id_tipo_pago_fk`) REFERENCES `tbl_tipo_pago` (`id_tipo_pago_pk`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
