-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2024 a las 18:21:15
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

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
  `nit` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`identificacion`, `nombre`, `apellido`, `tipoDocumento`, `genero`, `correo`, `fechaNacimiento`, `telefono`, `direccion`, `ciudad`, `fechaExpedicion`, `estadoCivil`, `nivelEstudio`, `nit`) VALUES
('123213213', 'jorge', 'Martinez', 'CC', '0', '0', '2024-03-14', '2147483647', 'calle 33 # 24B - 123', 'Bogotá', '2024-03-01', 'Soltero', 'Tecnologo', '1000000000');

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

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`nit`, `tipoContribuyente`, `digitoVerificacion`, `nombre`, `telefono`, `correo`, `direccion`, `logo`, `rut`, `camaraComercio`) VALUES
('1000000000', 'Natural', '09', 'Claro Colombia', '3182632123', 'clarocolombia@gmail.com', 'calle 123 # 24B - 123', '../form-Data/klipartz.com.png', 2, 'claro.jpg'),
('1112323212', 'Natural', '12', 'Jorge Martinez', '32132132', 'jlmartinezpinto@gmail.com', 'calle 33 # 24B - 123', '../form-Data/klipartz.com.png', 1232123, '../form-data/IMG_20231031_225215.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `codTipoUsuario` int(11) NOT NULL,
  `nombreTipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`codTipoUsuario`, `nombreTipo`) VALUES
(1, 'Jefe RH'),
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
  `codTipoUsuario` int(11) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `tipoDocumento`, `nombreU`, `apellidoU`, `correoU`, `contraseña`, `codTipoUsuario`, `reset_token`, `token_expiration`) VALUES
('1024582197', 'CC', 'Jorge ', 'Martinez', 'jorgelm65@gmail.com', '$2y$10$L1Sw2kIdSk6iWamn4yEcbO4bn4mAkGZYf64/EhxQC2WoSZNmmmkVO', 3, NULL, NULL),
('1024582973', 'CC', 'Jorge', 'Luis', 'jlmartinezpinto@gmail.com', '$2y$10$hgeeZYyg.trq5aiq40MrQe0VaLQlv4w/gWSdGcYnOfNzBs8sWTJ4K', 3, NULL, NULL),
('1111111111', 'CC', 'Jorge', 'Martinez', 'jlmartinezpinto@gmail.com', '$2y$10$hgeeZYyg.trq5aiq40MrQe0VaLQlv4w/gWSdGcYnOfNzBs8sWTJ4K', 1, NULL, NULL),
('12345678', 'CC', 'Juan', 'Mariño', 'juanmarin@gmail.com', '$2y$10$aQnfP/b1t1GOk/dQgNTx2etsvzoU1NH2lZM7E7VdKHQwVlVPXti1u', 2, NULL, NULL),
('123456789', 'CC', 'Juan', 'Mariño', 'juanmarino@gmail.com', '$2y$10$LwxV1yokPXNJ5emlUU8Khu2PKeezJ4HlM1GRZ4MOotb0vhL05fRA2', 1, NULL, NULL),
('12345678910', 'CC', 'Jorge', 'Martinez', 'jorgelm65@gmail.com', '$2y$10$IT2sBJemKXaY0YQz4OSXJuuIkHYqvOPqSPvoRbxy9qeeuF2ilqbMO', 2, NULL, NULL),
('22222222', 'CC', 'Jorge', 'Luis', 'jorgelm65@gmail.com', '$2y$10$YIAs7mqjrn1dZR2kbRMjRe7Gc3zJPlNxOXSFVFcrTmneSqmvpsTtW', 2, NULL, NULL),
('3333333333', 'CC', 'Jorge', 'Martinez', 'jlmartinezpinto@gmail.com', '$2y$10$hgeeZYyg.trq5aiq40MrQe0VaLQlv4w/gWSdGcYnOfNzBs8sWTJ4K', 3, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
