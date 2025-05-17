-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-05-2025 a las 02:52:48
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
-- Base de datos: `contactos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id_contactos` int(8) NOT NULL,
  `id_usuario` int(8) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `telefono` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `tipo_usuario` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id_contactos`, `id_usuario`, `nombre`, `direccion`, `telefono`, `email`, `tipo_usuario`) VALUES
(1, 1, 'Luis Sánchez', 'Av. Revolución 123', '555-1111', 'luis@example.com', 1),
(3, 2, 'Carlos Jiménez', 'Blvd. Tecnológico', '555-3333', 'carlos@example.com', 3),
(4, 2, 'Elena Ríos', 'Callejón del Sol', '555-4444', 'elena@example.com', 4),
(5, 3, 'Manuel Torres', 'Avenida 5 de Mayo', '555-5555', 'manuel@example.com', 1),
(6, 3, 'Isabel Martínez', 'Calle Rosas 45', '555-6666', 'isabel@example.com', 2),
(7, 3, 'Fernando Vargas', 'Zona Centro', '555-7777', 'fernando@example.com', 3),
(8, 4, 'Diana Pérez', 'Col. Jardines', '555-8888', 'diana@example.com', 4),
(9, 4, 'Gabriel Romero', 'Calle Laguna Azul', '555-9999', 'gabriel@example.com', 1),
(10, 4, 'Verónica Silva', 'Av. Universidad', '555-1010', 'veronica@example.com', 2),
(11, 1, 'Ricardo Ortega', 'Calle 13 Sur', '555-1212', 'ricardo@example.com', 3),
(12, 2, 'Mariana Delgado', 'Fracc. Las Palmas', '555-1313', 'mariana@example.com', 4),
(13, 3, 'Héctor Navarro', 'Av. Insurgentes', '555-1414', 'hector@example.com', 1),
(14, 4, 'Laura Contreras', 'Col. Centro', '555-1515', 'laura@example.com', 2),
(15, 1, 'Pablo Ramírez', 'Calle Victoria', '555-1616', 'pablo@example.com', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(8) NOT NULL,
  `contraseña` varchar(40) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `telefono` varchar(40) NOT NULL,
  `tipo` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `contraseña`, `nombre`, `telefono`, `tipo`) VALUES
(1, '12345', 'Kevin Hernández', '2165462198', 1),
(2, 'c456', 'Sofía Castro', '1546879216', 1),
(3, 'c789', 'Mario Torres', '16484221546', 2),
(4, 'c234', 'Jose Maria', '21354651651', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id_contactos`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id_contactos` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `contactos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
