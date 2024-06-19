-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2024 a las 00:25:27
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
-- Base de datos: `basenomina`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `identificacion` varchar(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `tipoDocumento` varchar(5) NOT NULL,
  `genero` varchar(10) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `fechaExpedicion` date NOT NULL,
  `estadoCivil` varchar(30) NOT NULL,
  `nivelEstudio` varchar(30) NOT NULL,
  `nit` varchar(50) NOT NULL,
  `departamento` varchar(50) NOT NULL,
  `codEstadoEmpleado` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `nit` varchar(50) NOT NULL,
  `tipoContribuyente` varchar(50) NOT NULL,
  `digitoVerificacion` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `logo` varchar(50) NOT NULL,
  `rut` int(15) NOT NULL,
  `camaraComercio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadoempleado`
--

CREATE TABLE `estadoempleado` (
  `codEstadoEmpleado` int(2) NOT NULL,
  `descripcionEstadoEmpleado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadoempleado`
--

INSERT INTO `estadoempleado` (`codEstadoEmpleado`, `descripcionEstadoEmpleado`) VALUES
(0, 'Desvinculado'),
(1, 'vinculado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadousuario`
--

CREATE TABLE `estadousuario` (
  `codEstadoUsuario` int(2) NOT NULL,
  `descripcionUsuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadousuario`
--

INSERT INTO `estadousuario` (`codEstadoUsuario`, `descripcionUsuario`) VALUES
(0, 'Inactivo'),
(1, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `codRol` int(2) NOT NULL,
  `descripcionRol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`codRol`, `descripcionRol`) VALUES
(1, 'Jefe Recursos Humano'),
(2, 'Contador'),
(3, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` varchar(11) NOT NULL,
  `tipoDocumento` varchar(2) NOT NULL,
  `nombreU` varchar(20) NOT NULL,
  `apellidoU` varchar(20) NOT NULL,
  `correoU` varchar(50) NOT NULL,
  `contraseña` varchar(100) NOT NULL,
  `codRol` int(2) NOT NULL,
  `codEstadoUsuario` int(2) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL,
  `intentos_fallidos` int(11) DEFAULT 0,
  `cuenta_bloqueada` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD KEY `codEstadoEmpleado` (`codEstadoEmpleado`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`nit`);

--
-- Indices de la tabla `estadoempleado`
--
ALTER TABLE `estadoempleado`
  ADD PRIMARY KEY (`codEstadoEmpleado`);

--
-- Indices de la tabla `estadousuario`
--
ALTER TABLE `estadousuario`
  ADD PRIMARY KEY (`codEstadoUsuario`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`codRol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `codRol` (`codRol`),
  ADD KEY `codEstado` (`codEstadoUsuario`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`nit`) REFERENCES `empresa` (`nit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empleado_ibfk_3` FOREIGN KEY (`codEstadoEmpleado`) REFERENCES `estadoempleado` (`codEstadoEmpleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`codRol`) REFERENCES `rol` (`codRol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`codEstadoUsuario`) REFERENCES `estadousuario` (`codEstadoUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
