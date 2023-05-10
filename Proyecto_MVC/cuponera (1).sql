-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 10-05-2023 a las 17:56:23
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

--
-- Volcado de datos para la tabla `cupones`
--

INSERT INTO `cupones` (`ID_Cupon`, `id_oferta`, `id_orden`, `Estado_Cupon`, `Cantidad`) VALUES
('EMP0013131662', 4, 8, 'Canjeado', 1),
('EMP0015557551', 4, 9, 'Canjeado', 10),
('EMP0021913860', 2, 5, 'Canjeado', 1),
('EMP0024025689', 2, 6, 'Disponible', 1),
('EMP0028660676', 2, 9, 'Disponible', 4),
('EMP0032952613', 3, 7, 'Disponible', 1),
('EMP0033789135', 3, 11, 'Disponible', 7),
('EMP0034119145', 3, 10, 'Disponible', 1);

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
  `Rubro` int NOT NULL,
  `Porcentaje_Comision` decimal(10,2) NOT NULL,
  `id_tipo_usuario` int NOT NULL,
  PRIMARY KEY (`ID_Empresa`),
  KEY `FK_ADMIN_EMPRESA` (`id_tipo_usuario`),
  KEY `FK_RUBRO_EMPRESA` (`Rubro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`ID_Empresa`, `Nombre_Empresa`, `Direccion`, `Nombre_Contacto`, `Telefono`, `Correo`, `Pass`, `Rubro`, `Porcentaje_Comision`, `id_tipo_usuario`) VALUES
('EMP001', 'Coca Cola', 'San salvador', 'Luis', '71255695', 'JoseLuis@hotmail.com', '12345', 1, '8.00', 2),
('EMP002', 'Mister Burger', 'San salvador', 'Kelly Maria', '6523-1474', 'MariaJose@hotmail.com', '12345', 2, '4.00', 2),
('EMP003', 'Organic food', 'Santa Tecla', 'Antonio', '62096080', 'MarioAntonio@hotmail.com', '12345', 2, '18.00', 2),
('EMP004', 'Los tilines', 'Por la Libertad', 'Tilin Ramirez', '2525-2525', 'tekmo120@gmail.com', '266617c5', 1, '8.00', 2);

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
  `Descripcion` varchar(800) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Estado_Oferta` varchar(20) DEFAULT NULL,
  `Justificacion` varchar(80) DEFAULT NULL,
  `Imagen` varchar(50) DEFAULT NULL,
  `id_empresa` varchar(6) NOT NULL,
  PRIMARY KEY (`ID_Oferta`),
  KEY `FK_EMPRESA_OFERTA` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`ID_Oferta`, `Titulo_Oferta`, `Precio_Regular`, `Precio_Oferta`, `Fecha_Inicio_Oferta`, `Fecha_Fin_Oferta`, `Cantidad_Cupones`, `Descripcion`, `Estado_Oferta`, `Justificacion`, `Imagen`, `id_empresa`) VALUES
(1, 'Hot Burger al 2x1', '5.50', '2.75', '2023-04-25', '2023-05-30', 0, 'Disfruta de nuestras Hamburguesas picantes al 2x1 y a mitad de precio, cupón por tiempo limitado.', 'Activa', '', '34310126_011nov1_5.jpg', 'EMP002'),
(2, 'Pizza Personal', '5.50', '3.25', '2023-04-26', '2023-05-28', 0, 'Rica Pizza personal de un ingrediente, puedes cangear el cupon en nuestras sucursales.', 'Activa', '', 'Pizza.jpg', 'EMP002'),
(3, 'Desayuno Saludable', '15.50', '8.25', '2023-04-26', '2023-05-28', NULL, 'Al canjear el cupon, dispondras de una visita a nuestro local para degustar de nuestros ricos desayunos.', 'Activa', NULL, 'Organico.jpg', 'EMP003'),
(4, 'Sixpack de Red Energy 2x1', '8.40', '2.25', '2023-03-26', '2023-05-22', NULL, 'Solo por tiempo limitado, por la compra de un paquete te llevas la bebida energizante Red Energy por otro paquete.', 'Activa', NULL, 'Red_Energy.jpg', 'EMP001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
CREATE TABLE IF NOT EXISTS `ordenes` (
  `ID_Orden` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `Fecha` date NOT NULL,
  `Tarjeta` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_Orden`),
  KEY `FK_USUARIO_ORDEN` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`ID_Orden`, `id_usuario`, `Total`, `Fecha`, `Tarjeta`) VALUES
(5, 26, '3.25', '2023-04-13', '5412 7512 3412 3456'),
(6, 26, '3.25', '2023-04-13', '5412 7512 3412 3456'),
(7, 26, '8.25', '2023-04-13', '5412 7512 3412 3456'),
(8, 26, '2.25', '2023-04-13', '5412 7512 3412 3456'),
(9, 27, '35.50', '2023-04-13', '5412 7512 3412 3456'),
(10, 27, '8.25', '2023-04-14', '5412 7512 3412 3456'),
(11, 28, '57.75', '2023-04-14', '5412 7512 3412 3456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubros`
--

DROP TABLE IF EXISTS `rubros`;
CREATE TABLE IF NOT EXISTS `rubros` (
  `ID_Rubro` int NOT NULL AUTO_INCREMENT,
  `Nombre_Rubro` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_Rubro`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `rubros`
--

INSERT INTO `rubros` (`ID_Rubro`, `Nombre_Rubro`) VALUES
(1, 'Distribuidora'),
(2, 'Restaurante'),
(4, 'Servicios');

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_Usuario`, `Nombres`, `Apellidos`, `Telefono`, `Correo`, `Direccion`, `DUI`, `Pass`, `Estado`, `Codigo`, `id_tipo_usuario`) VALUES
(24, 'Gerardo', 'Serrano', '62096080', 'marckxsx@gmail.com', 'Calle a Plan del Pino', '06021224-1', '123456', 'Activo', 1371, 4),
(26, 'Luis', 'Sosa', '71455689', 'marcolopez121@outlook.com', 'Calle a Plan del Pino', '06022124-1', '123456', 'Activo', 5136, 4),
(27, 'Marco ', 'Lopez', '71455689', 'tekmo120@gmail.com', 'Calle a Plan del Pino', '06021224-1', '123456', 'Activo', 6581, 4),
(28, 'Fernando', 'Lopez', '78417443', 'fernando.eribs@gmail.com', 'por su casa', '06021224-1', '123456', 'Activo', 8887, 4),
(29, 'Marcos', 'Lopez', '62669985', 'marco111@gmail.com', 'Por su casa', '2323232-85', '123456', 'Activo', 2356, 1);

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
  ADD CONSTRAINT `FK_ADMIN_EMPRESA` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuarios` (`ID_Tipo_Usuario`),
  ADD CONSTRAINT `FK_RUBRO_EMPRESA` FOREIGN KEY (`Rubro`) REFERENCES `rubros` (`ID_Rubro`);

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
