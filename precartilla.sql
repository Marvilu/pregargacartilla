-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 28-07-2022 a las 20:30:35
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `precartilla`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartillas`
--

CREATE TABLE `cartillas` (
  `id` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_profesional` int(11) NOT NULL,
  `unidad_academica` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cartillas`
--

INSERT INTO `cartillas` (`id`, `id_alumno`, `id_profesional`, `unidad_academica`) VALUES
(1, 1, 2, 'Facultad de Ciencias Exactas, Fisicas y Naturales'),
(2, 1, 2, 'Facultad de Ciencias Exactas, Fisicas y Naturales'),
(116, 1, 0, 'Facultad de Ciencias Sociales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `est1_audiometria`
--

CREATE TABLE `est1_audiometria` (
  `id_cartilla` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `estado_estudio` enum('Aprobado','Rechazado','Completo','Incompleto') NOT NULL,
  `archivo` blob NOT NULL,
  `obs-estudiante` varchar(255) NOT NULL,
  `obs-revisor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `est1_audiometria`
--

INSERT INTO `est1_audiometria` (`id_cartilla`, `id`, `estado_estudio`, `archivo`, `obs-estudiante`, `obs-revisor`) VALUES
(1, 1, 'Incompleto', '', 'nada', 'nada'),
(2, 2, 'Completo', '', 'bien', 'bien');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `est2_laboratorio`
--

CREATE TABLE `est2_laboratorio` (
  `id` int(11) NOT NULL,
  `id_cartilla` int(11) NOT NULL,
  `estado_estudio` enum('Completo','Incompleto','Aprobado','Rechazado') NOT NULL,
  `archivo` blob NOT NULL,
  `eritrocito` int(10) UNSIGNED NOT NULL,
  `hematocrito` int(10) UNSIGNED NOT NULL,
  `hemoglobina` int(10) UNSIGNED NOT NULL,
  `leucocito` int(10) UNSIGNED NOT NULL,
  `neutrofilos` int(10) UNSIGNED NOT NULL,
  `eosinofilos` int(10) UNSIGNED NOT NULL,
  `basofilos` int(10) UNSIGNED NOT NULL,
  `linfocitos` int(10) UNSIGNED NOT NULL,
  `monocitos` int(10) UNSIGNED NOT NULL,
  `eritrosedimentacion` int(10) UNSIGNED NOT NULL,
  `glucemia` int(10) UNSIGNED NOT NULL,
  `colesterol` int(10) UNSIGNED NOT NULL,
  `trigliceridos` int(10) UNSIGNED NOT NULL,
  `creatinina` int(10) UNSIGNED NOT NULL,
  `o_ph` int(10) UNSIGNED NOT NULL,
  `o_densidad` int(10) UNSIGNED NOT NULL,
  `o_proteinas` int(10) UNSIGNED NOT NULL,
  `o_glucosa` int(10) UNSIGNED NOT NULL,
  `o_cetonicos` int(10) UNSIGNED NOT NULL,
  `o_pigmbiliares` int(10) UNSIGNED NOT NULL,
  `o_hemoglobina` int(10) UNSIGNED NOT NULL,
  `gruposanguineo` varchar(11) NOT NULL,
  `rh` varchar(11) NOT NULL,
  `obs-estudiante` varchar(255) NOT NULL,
  `obs-revisor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `est2_laboratorio`
--

INSERT INTO `est2_laboratorio` (`id`, `id_cartilla`, `estado_estudio`, `archivo`, `eritrocito`, `hematocrito`, `hemoglobina`, `leucocito`, `neutrofilos`, `eosinofilos`, `basofilos`, `linfocitos`, `monocitos`, `eritrosedimentacion`, `glucemia`, `colesterol`, `trigliceridos`, `creatinina`, `o_ph`, `o_densidad`, `o_proteinas`, `o_glucosa`, `o_cetonicos`, `o_pigmbiliares`, `o_hemoglobina`, `gruposanguineo`, `rh`, `obs-estudiante`, `obs-revisor`) VALUES
(1, 1, 'Completo', '', 23, 56, 332, 343, 54, 654, 657, 34, 76, 98, 763, 938, 24, 545, 67, 665, 45, 75, 45, 987, 76, 'A', 'negativo', 'nada', 'nada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `est3_oftalmologico`
--

CREATE TABLE `est3_oftalmologico` (
  `id` int(11) NOT NULL,
  `id_cartilla` int(11) NOT NULL,
  `estado_estudio` enum('Aprobado','Rechazado','Completo','Incompleto') NOT NULL,
  `archivo` blob NOT NULL,
  `agudeza_visual_der` varchar(100) NOT NULL,
  `agudeza_visual_izq` varchar(100) NOT NULL,
  `presion_ocular_der` varchar(100) NOT NULL,
  `presion_ocular_izq` varchar(100) NOT NULL,
  `obs-estudiante` varchar(255) NOT NULL,
  `obs-revisor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `est3_oftalmologico`
--

INSERT INTO `est3_oftalmologico` (`id`, `id_cartilla`, `estado_estudio`, `archivo`, `agudeza_visual_der`, `agudeza_visual_izq`, `presion_ocular_der`, `presion_ocular_izq`, `obs-estudiante`, `obs-revisor`) VALUES
(1, 1, 'Incompleto', '', '12', '13', '31', '24', 'nada', 'nada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `est4_otorrinolaringologico`
--

CREATE TABLE `est4_otorrinolaringologico` (
  `id` int(11) NOT NULL,
  `id_cartilla` int(11) NOT NULL,
  `archivo` blob NOT NULL,
  `estado_estudio` enum('Aprobado','Rechazado','Completo','Incompleto') NOT NULL,
  `otoscopia` varchar(255) NOT NULL,
  `exploracion_garganta` varchar(255) NOT NULL,
  `rinoscopia` varchar(255) NOT NULL,
  `obs-estudiante` varchar(255) NOT NULL,
  `obs-revisor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `est4_otorrinolaringologico`
--

INSERT INTO `est4_otorrinolaringologico` (`id`, `id_cartilla`, `archivo`, `estado_estudio`, `otoscopia`, `exploracion_garganta`, `rinoscopia`, `obs-estudiante`, `obs-revisor`) VALUES
(1, 1, '', 'Aprobado', 'sad', 'fd', 'sfd', 'ds', 'fss');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `est5_carnet_de_vacunacion`
--

CREATE TABLE `est5_carnet_de_vacunacion` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_cartilla` int(11) NOT NULL,
  `estado_estudio` enum('Aprobado','Rechazado','Completo','Incompleto') NOT NULL,
  `archivo` blob NOT NULL,
  `obs-estudiante` varchar(255) NOT NULL,
  `obs-revisor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `est5_carnet_de_vacunacion`
--

INSERT INTO `est5_carnet_de_vacunacion` (`id`, `id_cartilla`, `estado_estudio`, `archivo`, `obs-estudiante`, `obs-revisor`) VALUES
(1, 1, 'Rechazado', '', 'fsd', 'fsd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `est6_antecedentes_patologicos`
--

CREATE TABLE `est6_antecedentes_patologicos` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_cartilla` int(11) NOT NULL,
  `estado_estudio` enum('Aprobado','Rechazado','Completo','Incompleto') NOT NULL,
  `archivo` blob NOT NULL,
  `condiciones_de_riesgo` varchar(255) NOT NULL,
  `enfermedades_importantes` varchar(255) NOT NULL,
  `cirugias` varchar(255) NOT NULL,
  `enfermedades_cardiovasculares` varchar(255) NOT NULL,
  `trauma_con_alta_funcional` varchar(255) NOT NULL,
  `alergias` varchar(255) NOT NULL,
  `oftalmologicos` varchar(255) NOT NULL,
  `auditivos` varchar(255) NOT NULL,
  `condiciones` enum('Asma','Chagas','Diabetes','Hipertension','Neurologico') NOT NULL,
  `condiciones_otros` varchar(255) NOT NULL,
  `medicamentos_prescriptos` varchar(255) NOT NULL,
  `durante_actividad_fisica` enum('Cansancio extremo','Falta de aire','Perdida de conocimiento','Palpitaciones','Precordalgias','Cefaleas','Vomitos') NOT NULL,
  `durante_actividad_fisica_otro` varchar(255) NOT NULL,
  `obs-estudiante` varchar(255) NOT NULL,
  `obs-revisor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `est6_antecedentes_patologicos`
--

INSERT INTO `est6_antecedentes_patologicos` (`id`, `id_cartilla`, `estado_estudio`, `archivo`, `condiciones_de_riesgo`, `enfermedades_importantes`, `cirugias`, `enfermedades_cardiovasculares`, `trauma_con_alta_funcional`, `alergias`, `oftalmologicos`, `auditivos`, `condiciones`, `condiciones_otros`, `medicamentos_prescriptos`, `durante_actividad_fisica`, `durante_actividad_fisica_otro`, `obs-estudiante`, `obs-revisor`) VALUES
(1, 1, 'Completo', '', 'nsiu', 'sjh', 'sjn', 'fsa', 'faf', 'gf', 'hfg', 'vcb', 'Asma', '', '', 'Falta de aire', '', 'und', 'ad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_cartilla` int(11) NOT NULL,
  `usuario_resp` enum('Profesional','Alumno','','') NOT NULL,
  `fecha` date NOT NULL,
  `estado` enum('Aprobado','Rechazado','Cargando','Enviado','Caducado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_cartilla`, `usuario_resp`, `fecha`, `estado`) VALUES
(1, 'Alumno', '2022-01-17', 'Cargando'),
(2, 'Profesional', '2021-08-19', 'Aprobado'),
(116, 'Alumno', '2022-07-07', 'Cargando');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tipo_usuario` enum('Alumno','Profesional','','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estado` enum('desactivado','activado') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_act` date NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `dni` int(11) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `domicilio` varchar(50) NOT NULL,
  `telefono` int(15) NOT NULL,
  `password` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `correo`, `tipo_usuario`, `estado`, `fecha_act`, `nombre`, `apellido`, `dni`, `fecha_nacimiento`, `sexo`, `domicilio`, `telefono`, `password`) VALUES
(1, 'juanperez@gmail.com', 'Alumno', 'activado', '0000-00-00', 'Juan', 'Perez', 12356748, '2002-03-11', 'Masculino', 'Mendoza 456 sur', 273657283, '81dc9bdb52d04dc20036dbd8313ed055'),
(68, 'mbelenperez.98@gmail.com', 'Alumno', 'activado', '2022-07-26', 'Belen', 'Perez', 41157278, '1998-08-11', 'Femenino', 'Aberastain 654', 2147483647, '81dc9bdb52d04dc20036dbd8313ed055'),
(69, 'mabazan99@gmail.com', 'Profesional', 'activado', '2022-07-28', 'Maria', 'Muñoz', 42987265, '1999-08-25', 'Femenino', 'caseros123', 127564387, '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cartillas`
--
ALTER TABLE `cartillas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alumno` (`id_alumno`) USING BTREE;

--
-- Indices de la tabla `est1_audiometria`
--
ALTER TABLE `est1_audiometria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cartilla` (`id_cartilla`);

--
-- Indices de la tabla `est2_laboratorio`
--
ALTER TABLE `est2_laboratorio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cartilla` (`id_cartilla`);

--
-- Indices de la tabla `est3_oftalmologico`
--
ALTER TABLE `est3_oftalmologico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cartilla` (`id_cartilla`);

--
-- Indices de la tabla `est4_otorrinolaringologico`
--
ALTER TABLE `est4_otorrinolaringologico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cartilla` (`id_cartilla`);

--
-- Indices de la tabla `est5_carnet_de_vacunacion`
--
ALTER TABLE `est5_carnet_de_vacunacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cartilla` (`id_cartilla`);

--
-- Indices de la tabla `est6_antecedentes_patologicos`
--
ALTER TABLE `est6_antecedentes_patologicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cartilla` (`id_cartilla`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD KEY `id_cartilla` (`id_cartilla`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cartillas`
--
ALTER TABLE `cartillas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `est1_audiometria`
--
ALTER TABLE `est1_audiometria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `est2_laboratorio`
--
ALTER TABLE `est2_laboratorio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `est3_oftalmologico`
--
ALTER TABLE `est3_oftalmologico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `est4_otorrinolaringologico`
--
ALTER TABLE `est4_otorrinolaringologico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `est5_carnet_de_vacunacion`
--
ALTER TABLE `est5_carnet_de_vacunacion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `est6_antecedentes_patologicos`
--
ALTER TABLE `est6_antecedentes_patologicos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cartillas`
--
ALTER TABLE `cartillas`
  ADD CONSTRAINT `cartillas_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `est1_audiometria`
--
ALTER TABLE `est1_audiometria`
  ADD CONSTRAINT `est1_audiometria_ibfk_1` FOREIGN KEY (`id_cartilla`) REFERENCES `cartillas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `est2_laboratorio`
--
ALTER TABLE `est2_laboratorio`
  ADD CONSTRAINT `est2_laboratorio_ibfk_1` FOREIGN KEY (`id_cartilla`) REFERENCES `cartillas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `est3_oftalmologico`
--
ALTER TABLE `est3_oftalmologico`
  ADD CONSTRAINT `est3_oftalmologico_ibfk_1` FOREIGN KEY (`id_cartilla`) REFERENCES `cartillas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `est4_otorrinolaringologico`
--
ALTER TABLE `est4_otorrinolaringologico`
  ADD CONSTRAINT `est4_otorrinolaringologico_ibfk_1` FOREIGN KEY (`id_cartilla`) REFERENCES `cartillas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `est5_carnet_de_vacunacion`
--
ALTER TABLE `est5_carnet_de_vacunacion`
  ADD CONSTRAINT `est5_carnet_de_vacunacion_ibfk_1` FOREIGN KEY (`id_cartilla`) REFERENCES `cartillas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `est6_antecedentes_patologicos`
--
ALTER TABLE `est6_antecedentes_patologicos`
  ADD CONSTRAINT `est6_antecedentes_patologicos_ibfk_1` FOREIGN KEY (`id_cartilla`) REFERENCES `cartillas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estado`
--
ALTER TABLE `estado`
  ADD CONSTRAINT `estado_ibfk_1` FOREIGN KEY (`id_cartilla`) REFERENCES `cartillas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
