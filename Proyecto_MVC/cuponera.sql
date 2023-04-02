
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Base de datos: Cuponera

CREATE DATABASE Cuponera;
USE Cuponera;

-- Estructura de las Tablas

-- Tabla Tipo_Usuario

CREATE TABLE IF NOT EXISTS `Tipo_Usuarios` (
    `ID_Tipo_Usuario` int(11) NOT NULL,
    `Tipo_Usuario` varchar(30) NOT NULL,
    PRIMARY KEY(`ID_Tipo_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertando Datos
INSERT INTO `Tipo_Usuarios` (`ID_Tipo_Usuario`, `Tipo_Usuario`) VALUES
(1, 'ADMIN'),
(2, 'ADMIN_EMPRESA'),
(3, 'USUARIO_EMPRESA'),
(4, 'USUARIO'),
(5, 'EMPLEADO');

-- Tabla Clientes

CREATE TABLE IF NOT EXISTS `Usuarios` (
    `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT,
    `Nombres` varchar(30) NOT NULL,
    `Apellidos` varchar(30) NOT NULL,
    `Telefono` varchar(9) NOT NULL,
    `Correo` varchar(50) NOT NULL,
    `Direccion` varchar(80) NOT NULL,
    `DUI` varchar(10) NOT NULL,
    `Pass` varchar(60) NOT NULL,
    `id_tipo_usuario` int(11) NOT NULL,
    PRIMARY KEY(`ID_Usuario`),
    KEY `FK_USUARIO` (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertando Datos
INSERT INTO `Usuarios` (`ID_Usuario`, `Nombres`, `Apellidos`, `Telefono`, `Correo`, `Direccion`, `DUI`, `Pass`,`id_tipo_usuario`) VALUES
('','Marco', 'Lopez', '62096080', 'marcolopez121@outlook.com', 'Por mi casa', '06020214-1', '123456', 4);

-- Tabla Empresa

CREATE TABLE IF NOT EXISTS `Empresa` (
    `ID_Empresa` varchar(6) NOT NULL,
    `Nombre_Empresa` varchar(30) NOT NULL,
    `Direccion` varchar(80) NOT NULL,
    `Nombre_Contacto` varchar(30) NOT NULL,
    `Telefono` varchar(9) NOT NULL,
    `Correo` varchar(50) NOT NULL,
    `Pass` varchar(60) NOT NULL,
    `Rubro` varchar(60) NOT NULL,
    `Porcentaje_Comision` Decimal(10,2) NOT NULL,
    `id_tipo_usuario` int(11) NOT NULL,
    PRIMARY KEY(`ID_Empresa`),
    KEY `FK_ADMIN_EMPRESA` (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertando Datos
INSERT INTO `Empresa` (`ID_Empresa`, `Nombre_Empresa`, `Direccion`, `Nombre_Contacto`, `Telefono`, `Correo`, `Pass`, `Rubro`,`Porcentaje_Comision`, `id_tipo_usuario`) VALUES
('EMP001','Coca Cola', 'San salvador', 'Luis', '71255695', 'JoseLuis@hotmail.com', '12345', 'Restaurante', 0.08, 2);

-- Tabla Empleados

CREATE TABLE IF NOT EXISTS `Empleados` (
    `ID_Empleado` int(11) NOT NULL AUTO_INCREMENT,
    `Nombres` varchar(30) NOT NULL,
    `Apellidos` varchar(30) NOT NULL,
    `Correo` varchar(50) NOT NULL,
    `Pass` varchar(60) NOT NULL,
    `id_empresa` varchar(6) NOT NULL,
    `id_tipo_usuario` int(11) NOT NULL,
    PRIMARY KEY(`ID_Empleado`),
    KEY `FK_USUARIO_EMPRESA` (`id_tipo_usuario`),
    kEY `FK_EMPRESA` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertando Datos
INSERT INTO `Empleados` (`ID_Empleado`, `Nombres`, `Apellidos`, `Correo`, `Pass`, `id_empresa`, `id_tipo_usuario`) VALUES
('','Roberto', 'Sanchez', 'Robert@hotmail.com', 'roberto12345', 'EMP001', 3);

-- Tabla Ofertas

CREATE TABLE IF NOT EXISTS `Ofertas` (
    `ID_Oferta` int(11) NOT NULL AUTO_INCREMENT,
    `Titulo_Oferta` varchar(30) NOT NULL,
    `Precio_Regular` varchar(30) NOT NULL,
    `Precio_Oferta` varchar(50) NOT NULL,
    `Fecha_Inicio_Oferta` DATE NOT NULL,
    `Fecha_Fin_Oferta` DATE NOT NULL,
    `Cantidad_Cupones` int(11),
    `Descripcion` varchar(80) NOT NULL,
    `Estado_Oferta` varchar(20),
    `Justificacion` varchar(80),
    `Imagen` varchar(50),
    `id_empresa` varchar(6) NOT NULL,
    PRIMARY KEY(`ID_Oferta`),
    kEY `FK_EMPRESA_OFERTA` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertando Datos
INSERT INTO `Ofertas` (`ID_Oferta`, `Titulo_Oferta`, `Precio_Regular`, `Precio_Oferta`, `Fecha_Inicio_Oferta`, `Fecha_Fin_Oferta`, `Cantidad_Cupones`, `Descripcion`, `Estado_Oferta`, `Justificacion`, `Imagen`, `id_empresa`) VALUES
('','Promocion de Botellas 6x2', 8.40, 2.25, '2023-03-26', '2023-05-22', NULL, 'Botellas a buen precio', NULL, NULL, NULL, 'EMP001');

-- Tabla Cupones

CREATE TABLE IF NOT EXISTS `Cupones` (
    `ID_Cupon` varchar(13) NOT NULL,
    `id_oferta` int(11) NOT NULL,
    `id_orden` int(11) NOT NULL,
    `Estado_Cupon` varchar(30) NOT NULL,
    `Cantidad` int(11) NOT NULL,
    PRIMARY KEY(`ID_Cupon`),
    kEY `FK_CUPON_OFERTA` (`id_oferta`),
    KEY `FK_CUPON_ORDEN` (`id_orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabla Orden

CREATE TABLE IF NOT EXISTS `Ordenes` (
    `ID_Orden` int(11) NOT NULL AUTO_INCREMENT,
    `id_usuario` int(11) NOT NULL,
    `Total` Decimal(10,2) NOT NULL,
    PRIMARY KEY(`ID_Orden`),
    kEY `FK_USUARIO_ORDEN` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- Insertando Datos
/*INSERT INTO `Cupones_Clientes` (`ID_Cupon`, `id_oferta`, `id_usuario`, `Estado_Cupon`, `Cantidad`) VALUES
('EMP0010000001',0, 0,'Disponible', 2);*/

-- Llaves Foraneas
ALTER TABLE `Ordenes`
 ADD CONSTRAINT `FK_USUARIO_ORDEN` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`ID_Usuario`); 

ALTER TABLE `Usuarios`
  ADD CONSTRAINT `FK_USUARIO` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `Tipo_Usuarios` (`ID_Tipo_Usuario`); 

ALTER TABLE `Empleados`
 ADD CONSTRAINT `FK_USUARIO_EMPRESA` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `Tipo_Usuarios` (`ID_Tipo_Usuario`), 
 ADD CONSTRAINT `FK_EMPRESA` FOREIGN KEY (`id_empresa`) REFERENCES `Empresa` (`ID_Empresa`); 

ALTER TABLE `Empresa`
 ADD CONSTRAINT `FK_ADMIN_EMPRESA` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `Tipo_Usuarios` (`ID_Tipo_Usuario`); 

ALTER TABLE `Ofertas`
  ADD CONSTRAINT `FK_EMPRESA_OFERTA` FOREIGN KEY (`id_empresa`) REFERENCES `Empresa` (`ID_Empresa`); 

ALTER TABLE `Cupones`
  ADD CONSTRAINT `FK_CUPON_OFERTA` FOREIGN KEY (`id_oferta`) REFERENCES `Ofertas` (`ID_Oferta`),
  ADD CONSTRAINT `FK_CUPON_ORDEN` FOREIGN KEY (`id_orden`) REFERENCES `Ordenes` (`ID_Orden`);