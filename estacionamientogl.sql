-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-07-2024 a las 12:53:45
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
-- Base de datos: `estacionamientogl`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id` int(11) NOT NULL,
  `num_placa` varchar(10) DEFAULT NULL,
  `fecha_hora_entrada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`id`, `num_placa`, `fecha_hora_entrada`) VALUES
(3, 'ABC 1234', '2024-07-30 03:07:00'),
(5, 'aev-3310', '2024-07-30 02:28:00'),
(6, 'gjc-4124', '2024-07-30 03:29:00'),
(9, 'aev-3310', '2024-07-30 07:35:00'),
(10, 'gjc-4124', '2024-07-30 07:36:00'),
(11, 'ABC 1234', '2024-07-30 10:11:00'),
(12, 'XYZ-5677', '2024-07-30 11:22:00');

--
-- Disparadores `entradas`
--
DELIMITER $$
CREATE TRIGGER `before_update_entrada` BEFORE UPDATE ON `entradas` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No se permite actualizar la fecha y hora de entrada';
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas`
--

CREATE TABLE `salidas` (
  `id` int(11) NOT NULL,
  `num_placa` varchar(10) DEFAULT NULL,
  `fecha_hora_salida` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `salidas`
--

INSERT INTO `salidas` (`id`, `num_placa`, `fecha_hora_salida`) VALUES
(3, 'ABC 1234', '2024-07-30 03:44:00'),
(5, 'gjc-4124', '2024-07-30 04:29:00'),
(6, 'aev-3310', '2024-07-30 05:30:00'),
(7, 'aev-3310', '2024-07-30 10:28:00'),
(8, 'gjc-4124', '2024-07-30 10:28:00'),
(9, 'ABC 1234', '2024-07-30 11:12:00'),
(10, 'XYZ-5677', '2024-07-30 13:23:00');

--
-- Disparadores `salidas`
--
DELIMITER $$
CREATE TRIGGER `before_update_salida` BEFORE UPDATE ON `salidas` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No se permite actualizar la fecha y hora de salida';
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_vehiculos`
--

CREATE TABLE `tipos_vehiculos` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `tarifa_minuto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_vehiculos`
--

INSERT INTO `tipos_vehiculos` (`id`, `tipo`, `tarifa_minuto`) VALUES
(1, 'oficial', 0.00),
(2, 'residente', 1.00),
(3, 'no_residente', 3.00),
(9, 'taxi', 2.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `num_placa` varchar(10) NOT NULL,
  `tipo_vehiculo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `num_placa`, `tipo_vehiculo_id`) VALUES
(1, 'ABC 1234', 2),
(3, 'aev-3310', 1),
(4, 'gjc-4124', 3),
(14, 'XYZ-5677', 9);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `num_placa` (`num_placa`);

--
-- Indices de la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `num_placa` (`num_placa`);

--
-- Indices de la tabla `tipos_vehiculos`
--
ALTER TABLE `tipos_vehiculos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `num_placa` (`num_placa`),
  ADD KEY `tipo_vehiculo_id` (`tipo_vehiculo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipos_vehiculos`
--
ALTER TABLE `tipos_vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`num_placa`) REFERENCES `vehiculos` (`num_placa`);

--
-- Filtros para la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD CONSTRAINT `salidas_ibfk_1` FOREIGN KEY (`num_placa`) REFERENCES `vehiculos` (`num_placa`);

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`tipo_vehiculo_id`) REFERENCES `tipos_vehiculos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
