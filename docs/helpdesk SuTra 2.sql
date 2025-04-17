-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-04-2025 a las 19:22:53
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
-- Base de datos: `helpdesk`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_i_ticketdetalle_01` (IN `xtick_id` INT, IN `xusu_id` INT)   BEGIN
	INSERT INTO 
    td_ticketdetalle 
    (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,est) 
    VALUES 
    (NULL,xtick_id,xusu_id,'Ticket cerrado',now(),'1');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_l_usuario_01` ()   BEGIN
	SELECT * from tm_usuario 
            INNER JOIN tm_area on tm_usuario.area_id = tm_area.area_id
            where est='1';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_l_usuario_02` (IN `xusu_id` INT)   BEGIN
	SELECT * from tm_usuario 
            INNER JOIN tm_area on tm_usuario.area_id = tm_area.area_id
            where usu_id=xusu_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_documento`
--

CREATE TABLE `td_documento` (
  `doc_id` int(11) NOT NULL,
  `tick_id` int(11) NOT NULL,
  `doc_nom` varchar(450) NOT NULL,
  `fech_crea` datetime NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `td_documento`
--

INSERT INTO `td_documento` (`doc_id`, `tick_id`, `doc_nom`, `fech_crea`, `est`) VALUES
(1, 33, '___Consulta Tickets TLA SuTra.pdf', '2025-04-08 10:38:18', 1),
(2, 34, '2DAPARTE REPORTE FINAL.pdf', '2025-04-08 12:34:30', 1),
(3, 35, 'REPORTE FINAL SIN PORTADA.pdf', '2025-04-08 12:40:23', 1),
(4, 36, 'REPORTE FINAL AVANCES.pdf', '2025-04-08 12:41:15', 1),
(5, 36, 'REPORTE FINAL SIN PORTADA.pdf', '2025-04-08 12:41:15', 1),
(6, 36, 'REPORTE FINAL.pdf', '2025-04-08 12:41:15', 1),
(7, 60, '2DAPARTE REPORTE FINAL.pdf', '2025-04-09 18:57:27', 1),
(8, 61, 'Tabla de Contenido.pdf', '2025-04-10 09:25:02', 1),
(9, 62, 'Tabla de Contenido.pdf', '2025-04-10 09:29:07', 1),
(10, 63, 'REPORTE FINAL AVANCES.pdf', '2025-04-10 09:41:24', 1),
(11, 64, 'REPORTE FINAL AVANCES.pdf', '2025-04-10 09:50:49', 1),
(12, 65, '2DAPARTE REPORTE FINAL.pdf', '2025-04-10 10:16:06', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_ticketdetalle`
--

CREATE TABLE `td_ticketdetalle` (
  `tickd_id` int(11) NOT NULL,
  `tick_id` int(11) NOT NULL,
  `usu_id` int(11) NOT NULL,
  `tickd_descrip` mediumtext NOT NULL,
  `fech_crea` datetime NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `td_ticketdetalle`
--

INSERT INTO `td_ticketdetalle` (`tickd_id`, `tick_id`, `usu_id`, `tickd_descrip`, `fech_crea`, `est`) VALUES
(11, 2, 1, 'Hola', '2025-03-05 17:49:08', 1),
(12, 2, 4, 'Hola que tal en que te puedo ayudar?', '2025-03-06 17:50:01', 1),
(50, 3, 4, '<p>r55f5f</p><p><br></p>', '2025-03-11 17:38:52', 1),
(51, 3, 4, 'Ticket cerrado', '2025-03-11 18:48:47', 1),
(52, 2, 4, 'Ticket cerrado', '2025-03-11 18:49:15', 1),
(84, 3, 4, 'Ticket re-abierto', '2025-04-15 10:31:30', 1),
(85, 4, 4, 'Ticket re-abierto', '2025-04-15 10:31:40', 1),
(87, 2, 4, 'Ticket re-abierto', '2025-04-15 13:48:17', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_area`
--

CREATE TABLE `tm_area` (
  `area_id` int(11) NOT NULL,
  `area_nom` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tm_area`
--

INSERT INTO `tm_area` (`area_id`, `area_nom`) VALUES
(1, 'Sistemas'),
(2, 'Trafico'),
(3, 'Contabilidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_categoria`
--

CREATE TABLE `tm_categoria` (
  `cat_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `cat_nom` varchar(150) NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tm_categoria`
--

INSERT INTO `tm_categoria` (`cat_id`, `area_id`, `cat_nom`, `est`) VALUES
(1, 1, 'Hardware', 1),
(2, 1, 'Software', 1),
(3, 0, 'Petición de servicio', 1),
(4, 0, 'Otros', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_subcategoria`
--

CREATE TABLE `tm_subcategoria` (
  `cats_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `cats_nom` varchar(150) NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tm_subcategoria`
--

INSERT INTO `tm_subcategoria` (`cats_id`, `cat_id`, `cats_nom`, `est`) VALUES
(1, 1, 'Teclado', 1),
(2, 1, 'Monitor', 1),
(3, 1, 'Mouse', 1),
(4, 1, 'Disco Duro', 1),
(5, 1, 'Calentamiento', 1),
(6, 1, 'Otro', 1),
(7, 2, 'Sistema CASA', 1),
(8, 2, 'Sistema CONTPAQ', 1),
(9, 2, 'SUA', 1),
(10, 2, 'Conversión Factura a Layout', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_ticket`
--

CREATE TABLE `tm_ticket` (
  `tick_id` int(11) NOT NULL,
  `usu_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `cats_id` int(11) NOT NULL,
  `tick_titulo` varchar(250) NOT NULL,
  `tick_descrip` mediumtext NOT NULL,
  `tick_estado` varchar(15) DEFAULT NULL,
  `fech_crea` datetime DEFAULT NULL,
  `usu_asig` int(11) DEFAULT NULL,
  `fech_asig` datetime DEFAULT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tm_ticket`
--

INSERT INTO `tm_ticket` (`tick_id`, `usu_id`, `cat_id`, `cats_id`, `tick_titulo`, `tick_descrip`, `tick_estado`, `fech_crea`, `usu_asig`, `fech_asig`, `est`) VALUES
(2, 4, 3, 0, 'Programa lento', '<p>cecetg4t</p>', 'Abierto', '2025-02-14 16:41:04', NULL, NULL, 1),
(3, 4, 4, 0, 'Mal servicio de internet', '<p>werwefwf3</p>', 'Abierto', '2025-02-20 16:41:16', NULL, NULL, 1),
(4, 1, 2, 8, 'Paint lento', '<p>fweferg</p>', 'Abierto', '2025-02-21 16:41:27', NULL, NULL, 1),
(81, 21, 1, 2, 'TEST 81', '<p>test</p>', 'Abierto', '2025-04-16 10:39:41', NULL, NULL, 1),
(82, 21, 1, 4, 'TEST 82', '<p>test</p>', 'Abierto', '2025-04-16 10:54:21', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_usuario`
--

CREATE TABLE `tm_usuario` (
  `usu_id` int(11) NOT NULL,
  `usu_nom` varchar(150) DEFAULT NULL,
  `usu_ape` varchar(150) DEFAULT NULL,
  `usu_correo` varchar(150) DEFAULT NULL,
  `usu_pass` varchar(150) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `area_id` int(11) NOT NULL,
  `fech_crea` datetime NOT NULL,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabla Mantenedor de Usuarios';

--
-- Volcado de datos para la tabla `tm_usuario`
--

INSERT INTO `tm_usuario` (`usu_id`, `usu_nom`, `usu_ape`, `usu_correo`, `usu_pass`, `rol_id`, `area_id`, `fech_crea`, `fech_modi`, `fech_elim`, `est`) VALUES
(1, 'Gerardo', 'Cruz', 'gerarojo243@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, '2025-02-13 16:37:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(2, 'Luis Eduardo', 'Ortiz Torres', 'luistorres07@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 2, '2025-02-19 18:17:04', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(3, 'Victor', 'Perez', 'victorperez123@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, '2025-02-21 14:18:11', '0000-00-00 00:00:00', '2025-03-19 16:45:27', 1),
(4, 'Pablo', 'Maya', 'sistemas@tecnologisticaaduanal.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 1, '2025-02-27 15:36:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(6, 'Eduardo', 'Tellez', 'eduardotellez@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 2, '2025-03-11 15:04:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(7, 'demo', 'demo', 'demodemo@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 2, '2025-03-13 17:37:29', '0000-00-00 00:00:00', '2025-03-13 17:52:07', 0),
(14, 'Jorge', 'Negrete', 'negretejorge@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 3, '2025-03-18 14:10:01', NULL, NULL, 1),
(15, 'Bad ', 'bunny', 'badbunny@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 2, '2025-03-18 14:56:46', NULL, '2025-03-18 14:56:52', 0),
(16, 'Ricardo', 'Cantu', 'ricardocantu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 1, '2025-03-19 13:24:23', NULL, NULL, 1),
(17, 'Usuario', 'apellido', 'example@example.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 2, '2025-04-02 10:36:24', NULL, '2025-04-02 13:54:52', 0),
(18, 'Roberto', 'Diaz', 'robertodiaz@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 3, '2025-04-02 10:38:40', NULL, '2025-04-02 13:53:14', 0),
(19, 'Roberto', 'Diaz', 'robertodiaz@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 1, '2025-04-02 13:54:57', NULL, NULL, 1),
(20, 'Usuario', 'Apellido', 'correorandom@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 2, '2025-04-02 16:19:15', NULL, NULL, 1),
(21, 'Priscila', 'Cruz', 'priscilacruz00@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 2, '2025-04-02 17:13:17', NULL, NULL, 1),
(22, 'user', 'admindefault', 'sistemas@tecnologisticaaduanal.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, '2025-04-10 13:19:09', NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `td_documento`
--
ALTER TABLE `td_documento`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indices de la tabla `td_ticketdetalle`
--
ALTER TABLE `td_ticketdetalle`
  ADD PRIMARY KEY (`tickd_id`),
  ADD KEY `tick_id` (`tick_id`),
  ADD KEY `usu_id` (`usu_id`);

--
-- Indices de la tabla `tm_area`
--
ALTER TABLE `tm_area`
  ADD PRIMARY KEY (`area_id`);

--
-- Indices de la tabla `tm_categoria`
--
ALTER TABLE `tm_categoria`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indices de la tabla `tm_subcategoria`
--
ALTER TABLE `tm_subcategoria`
  ADD PRIMARY KEY (`cats_id`);

--
-- Indices de la tabla `tm_ticket`
--
ALTER TABLE `tm_ticket`
  ADD PRIMARY KEY (`tick_id`),
  ADD KEY `usu_id` (`usu_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indices de la tabla `tm_usuario`
--
ALTER TABLE `tm_usuario`
  ADD PRIMARY KEY (`usu_id`),
  ADD KEY `area_id` (`area_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `td_documento`
--
ALTER TABLE `td_documento`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `td_ticketdetalle`
--
ALTER TABLE `td_ticketdetalle`
  MODIFY `tickd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `tm_area`
--
ALTER TABLE `tm_area`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tm_categoria`
--
ALTER TABLE `tm_categoria`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tm_subcategoria`
--
ALTER TABLE `tm_subcategoria`
  MODIFY `cats_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tm_ticket`
--
ALTER TABLE `tm_ticket`
  MODIFY `tick_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `tm_usuario`
--
ALTER TABLE `tm_usuario`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `td_ticketdetalle`
--
ALTER TABLE `td_ticketdetalle`
  ADD CONSTRAINT `td_ticketdetalle_ibfk_1` FOREIGN KEY (`tick_id`) REFERENCES `tm_ticket` (`tick_id`),
  ADD CONSTRAINT `td_ticketdetalle_ibfk_2` FOREIGN KEY (`usu_id`) REFERENCES `tm_usuario` (`usu_id`);

--
-- Filtros para la tabla `tm_ticket`
--
ALTER TABLE `tm_ticket`
  ADD CONSTRAINT `tm_ticket_ibfk_1` FOREIGN KEY (`usu_id`) REFERENCES `tm_usuario` (`usu_id`),
  ADD CONSTRAINT `tm_ticket_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `tm_categoria` (`cat_id`);

--
-- Filtros para la tabla `tm_usuario`
--
ALTER TABLE `tm_usuario`
  ADD CONSTRAINT `tm_usuario_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `tm_area` (`area_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
