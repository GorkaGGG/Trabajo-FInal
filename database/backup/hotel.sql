-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-05-2026 a las 00:09:06
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
-- Base de datos: `hotel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atencion`
--

CREATE TABLE `atencion` (
  `RECEPCIONISTA` varchar(9) NOT NULL,
  `CLIENTE` varchar(9) NOT NULL,
  `FECHA` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `botones`
--

CREATE TABLE `botones` (
  `DNI` varchar(9) NOT NULL,
  `PISO` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `DNI` varchar(9) NOT NULL,
  `NOMBRE` varchar(15) NOT NULL,
  `APELLIDO` varchar(20) NOT NULL,
  `MAIL` varchar(30) NOT NULL,
  `TELEFONO` int(9) NOT NULL,
  `CONTRASEÑA` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`DNI`, `NOMBRE`, `APELLIDO`, `MAIL`, `TELEFONO`, `CONTRASEÑA`) VALUES
('72852501R', 'Gorka', 'Garcia de Garayo', 'ggdegarayo@gmail.com', 640031294, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `DNI` varchar(9) NOT NULL,
  `NUM_EMP` int(3) NOT NULL,
  `NOMBRE` varchar(15) NOT NULL,
  `APELLIDO` varchar(25) NOT NULL,
  `DEPARTAMENTO` varchar(20) NOT NULL,
  `TELEFONO` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`DNI`, `NUM_EMP`, `NOMBRE`, `APELLIDO`, `DEPARTAMENTO`, `TELEFONO`) VALUES
('11111111A', 1, 'GORKA', 'GARCIA DE GARAYO', 'ADMINISTRACION', 640031294),
('22222222B', 2, 'JUAN', 'GOMEZ', 'DIRECCION', 654987321),
('33333333C', 3, 'ASIER', 'JIMENEZ DE ABERASTURI', 'IT', 625011254),
('44444444D', 4, 'HECTO', 'GARCIA DE VICUNA', 'RECEPCION', 648100628);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `NUM_HAB` int(3) NOT NULL,
  `TIPO` varchar(10) NOT NULL,
  `PERSONAS` int(1) NOT NULL,
  `CAMA` varchar(15) NOT NULL,
  `PISO` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO `habitacion` (`NUM_HAB`, `TIPO`, `PERSONAS`, `CAMA`, `PISO`) VALUES
(101, 'BUSINESS', 2, 'INDIVIDUAL', 1),
(102, 'BUSINESS', 3, 'INDIVIDUAL', 1),
(103, 'BUSINESS', 4, 'INDIVIDUAL', 1),
(104, 'BUSINESS', 1, 'INDIVIDUAL', 1),
(105, 'BUSINESS', 2, 'DOBLE', 1),
(106, 'XL', 2, 'DOBLE', 1),
(107, 'XL', 3, 'INDIVIDUAL', 1),
(108, 'DELUXE', 2, 'DOBLE', 1),
(109, 'XL', 4, 'INDIVIDUAL', 1),
(201, 'DELUXE', 2, 'DOBLE', 2),
(202, 'DELUXE', 2, 'INDIVIDUAL', 2),
(203, 'SUITE', 2, 'DOBLE', 2),
(204, 'SUITE', 2, 'INDIVIDUAL', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `limpieza`
--

CREATE TABLE `limpieza` (
  `DNI` varchar(9) NOT NULL,
  `PISO` int(1) NOT NULL COMMENT 'Piso donde trabaja'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piso`
--

CREATE TABLE `piso` (
  `NUM_PISO` int(1) NOT NULL,
  `CATEGORIA` varchar(15) NOT NULL COMMENT 'Actividad del piso'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `piso`
--

INSERT INTO `piso` (`NUM_PISO`, `CATEGORIA`) VALUES
(0, 'AREA COMUN'),
(1, 'HABITACIONES'),
(2, 'HABITACIONES VI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcion`
--

CREATE TABLE `recepcion` (
  `DNI` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `CLIENTE` varchar(9) NOT NULL,
  `HABITACION` int(3) NOT NULL,
  `FECHA_ENT` date NOT NULL,
  `FECHA_SAL` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `atencion`
--
ALTER TABLE `atencion`
  ADD PRIMARY KEY (`RECEPCIONISTA`,`CLIENTE`,`FECHA`),
  ADD KEY `CLIENTE` (`CLIENTE`);

--
-- Indices de la tabla `botones`
--
ALTER TABLE `botones`
  ADD PRIMARY KEY (`DNI`),
  ADD KEY `CA_pisonum_piso_piso_botones` (`PISO`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`DNI`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`DNI`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`NUM_HAB`),
  ADD KEY `NUM_PISO` (`CAMA`),
  ADD KEY `PISO` (`PISO`);

--
-- Indices de la tabla `limpieza`
--
ALTER TABLE `limpieza`
  ADD PRIMARY KEY (`DNI`),
  ADD KEY `CA_pisonum_piso_limpiezapiso` (`PISO`);

--
-- Indices de la tabla `piso`
--
ALTER TABLE `piso`
  ADD PRIMARY KEY (`NUM_PISO`);

--
-- Indices de la tabla `recepcion`
--
ALTER TABLE `recepcion`
  ADD PRIMARY KEY (`DNI`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`CLIENTE`,`HABITACION`,`FECHA_ENT`,`FECHA_SAL`),
  ADD KEY `HABITACION` (`HABITACION`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `atencion`
--
ALTER TABLE `atencion`
  ADD CONSTRAINT `atencion_ibfk_1` FOREIGN KEY (`RECEPCIONISTA`) REFERENCES `recepcion` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `atencion_ibfk_2` FOREIGN KEY (`CLIENTE`) REFERENCES `cliente` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `botones`
--
ALTER TABLE `botones`
  ADD CONSTRAINT `botones_ibfk_1` FOREIGN KEY (`DNI`) REFERENCES `empleado` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `botones_ibfk_2` FOREIGN KEY (`PISO`) REFERENCES `piso` (`NUM_PISO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD CONSTRAINT `habitacion_ibfk_1` FOREIGN KEY (`PISO`) REFERENCES `piso` (`NUM_PISO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `limpieza`
--
ALTER TABLE `limpieza`
  ADD CONSTRAINT `limpieza_ibfk_1` FOREIGN KEY (`DNI`) REFERENCES `empleado` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `limpieza_ibfk_2` FOREIGN KEY (`PISO`) REFERENCES `piso` (`NUM_PISO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recepcion`
--
ALTER TABLE `recepcion`
  ADD CONSTRAINT `recepcion_ibfk_1` FOREIGN KEY (`DNI`) REFERENCES `empleado` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`HABITACION`) REFERENCES `habitacion` (`NUM_HAB`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`CLIENTE`) REFERENCES `cliente` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
