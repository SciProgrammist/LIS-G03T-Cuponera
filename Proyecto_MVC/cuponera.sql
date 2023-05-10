-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 11-04-2023 a las 03:31:00
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cuponera`
CREATE DATABASE cuponera;
use cuponera;
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupones`
--

DROP TABLE IF EXISTS `cupones`;
CREATE TABLE IF NOT EXISTS `cupones` (
  `ID_Cupon` varchar(13) NOT NULL,
  `id_oferta` int NOT NULL,
  `id_orden` int NOT NULL,
  `Estado_Cupon` varchar(30) NOT NULL,
  `Cantidad` int NOT NULL,
  PRIMARY KEY (`ID_Cupon`),
  KEY `FK_CUPON_OFERTA` (`id_oferta`),
  KEY `FK_CUPON_ORDEN` (`id_orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE IF NOT EXISTS `empleados` (
  `ID_Empleado` int NOT NULL AUTO_INCREMENT,
  `Nombres` varchar(30) NOT NULL,
  `Apellidos` varchar(30) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Pass` varchar(60) NOT NULL,
  `id_empresa` varchar(6) NOT NULL,
  `id_tipo_usuario` int NOT NULL,
  PRIMARY KEY (`ID_Empleado`),
  KEY `FK_USUARIO_EMPRESA` (`id_tipo_usuario`),
  KEY `FK_EMPRESA` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`ID_Empleado`, `Nombres`, `Apellidos`, `Correo`, `Pass`, `id_empresa`, `id_tipo_usuario`) VALUES
(0, 'Roberto', 'Sanchez', 'Robert@hotmail.com', 'roberto12345', 'EMP001', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE IF NOT EXISTS `empresa` (
  `ID_Empresa` varchar(6) NOT NULL,
  `Nombre_Empresa` varchar(30) NOT NULL,
  `Direccion` varchar(80) NOT NULL,
  `Nombre_Contacto` varchar(30) NOT NULL,
  `Telefono` varchar(9) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Pass` varchar(60) NOT NULL,
  `Rubro` varchar(60) NOT NULL,
  `Porcentaje_Comision` decimal(10,2) NOT NULL,
  `id_tipo_usuario` int NOT NULL,
  PRIMARY KEY (`ID_Empresa`),
  KEY `FK_ADMIN_EMPRESA` (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`ID_Empresa`, `Nombre_Empresa`, `Direccion`, `Nombre_Contacto`, `Telefono`, `Correo`, `Pass`, `Rubro`, `Porcentaje_Comision`, `id_tipo_usuario`) VALUES
('EMP001', 'Coca Cola', 'San salvador', 'Luis', '71255695', 'JoseLuis@hotmail.com', '12345', 'Restaurante', '0.08', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

DROP TABLE IF EXISTS `ofertas`;
CREATE TABLE IF NOT EXISTS `ofertas` (
  `ID_Oferta` int NOT NULL AUTO_INCREMENT,
  `Titulo_Oferta` varchar(30) NOT NULL,
  `Precio_Regular` varchar(30) NOT NULL,
  `Precio_Oferta` varchar(50) NOT NULL,
  `Fecha_Inicio_Oferta` date NOT NULL,
  `Fecha_Fin_Oferta` date NOT NULL,
  `Cantidad_Cupones` int DEFAULT NULL,
  `Descripcion` varchar(80) NOT NULL,
  `Estado_Oferta` varchar(20) DEFAULT NULL,
  `Justificacion` varchar(80) DEFAULT NULL,
  `Imagen` varchar(50) DEFAULT NULL,
  `id_empresa` varchar(6) NOT NULL,
  PRIMARY KEY (`ID_Oferta`),
  KEY `FK_EMPRESA_OFERTA` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`ID_Oferta`, `Titulo_Oferta`, `Precio_Regular`, `Precio_Oferta`, `Fecha_Inicio_Oferta`, `Fecha_Fin_Oferta`, `Cantidad_Cupones`, `Descripcion`, `Estado_Oferta`, `Justificacion`, `Imagen`, `id_empresa`) VALUES
(0, 'Promocion de Botellas 6x2', '8.40', '2.25', '2023-03-26', '2023-05-22', NULL, 'Botellas a buen precio', NULL, NULL, NULL, 'EMP001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
CREATE TABLE IF NOT EXISTS `ordenes` (
  `ID_Orden` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ID_Orden`),
  KEY `FK_USUARIO_ORDEN` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuarios`
--

DROP TABLE IF EXISTS `tipo_usuarios`;
CREATE TABLE IF NOT EXISTS `tipo_usuarios` (
  `ID_Tipo_Usuario` int NOT NULL,
  `Tipo_Usuario` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_Tipo_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tipo_usuarios`
--

INSERT INTO `tipo_usuarios` (`ID_Tipo_Usuario`, `Tipo_Usuario`) VALUES
(1, 'ADMIN'),
(2, 'ADMIN_EMPRESA'),
(3, 'USUARIO_EMPRESA'),
(4, 'USUARIO'),
(5, 'EMPLEADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID_Usuario` int NOT NULL AUTO_INCREMENT,
  `Nombres` varchar(30) NOT NULL,
  `Apellidos` varchar(30) NOT NULL,
  `Telefono` varchar(9) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Direccion` varchar(80) NOT NULL,
  `DUI` varchar(10) NOT NULL,
  `Pass` varchar(60) NOT NULL,
  `Estado` varchar(30) NOT NULL,
  `Codigo` int NOT NULL,
  `id_tipo_usuario` int NOT NULL,
  PRIMARY KEY (`ID_Usuario`),
  KEY `FK_USUARIO` (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_Usuario`, `Nombres`, `Apellidos`, `Telefono`, `Correo`, `Direccion`, `DUI`, `Pass`, `Estado`, `Codigo`, `id_tipo_usuario`) VALUES
(24, 'Gerardo', 'Serrano', '62096080', 'marckxsx@gmail.com', 'Calle a Plan del Pino', '06021224-1', '123456', 'Activo', 1371, 4);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD CONSTRAINT `FK_CUPON_OFERTA` FOREIGN KEY (`id_oferta`) REFERENCES `ofertas` (`ID_Oferta`),
  ADD CONSTRAINT `FK_CUPON_ORDEN` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`ID_Orden`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `FK_EMPRESA` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`ID_Empresa`),
  ADD CONSTRAINT `FK_USUARIO_EMPRESA` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuarios` (`ID_Tipo_Usuario`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `FK_ADMIN_EMPRESA` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuarios` (`ID_Tipo_Usuario`);

--
-- Filtros para la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD CONSTRAINT `FK_EMPRESA_OFERTA` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`ID_Empresa`);

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `FK_USUARIO_ORDEN` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`ID_Usuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_USUARIO` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuarios` (`ID_Tipo_Usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
