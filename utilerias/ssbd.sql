-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-02-2017 a las 18:13:30
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `serviciosocial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE IF NOT EXISTS `carreras` (
  `CARCVE` int(11) NOT NULL DEFAULT '0',
  `CARNOM` varchar(80) DEFAULT NULL,
  `CARNCO` varchar(20) DEFAULT NULL,
  `CARSIT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`CARCVE`, `CARNOM`, `CARNCO`, `CARSIT`) VALUES
(0, 'APLICA CUALQUIER CARRERA', 'INDISTINTA', 1),
(4, 'INGENIERIA INDUSTRIAL', 'ING. INDUSTRIAL', 1),
(6, 'INGENIERIA BIOQUIMICA', 'ING. BIOQUIMICA', 1),
(7, 'INGENIERIA MECANICA', 'ING. MECANICA', 1),
(8, 'INGENIERIA ELECTRICA', 'ING. ELECTRICA', 1),
(9, 'INGENIERIA ELECTRONICA', 'ING. ELECTRONICA', 1),
(11, 'INGENIERIA EN SISTEMAS COMPUTACIONALES', 'ING. SIST. COMP.', 1),
(13, 'INGENIERIA MECATRONICA', 'ING. MECATRONICA', 1),
(16, 'INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES', 'ING. TICS', 1),
(18, 'INGENIERIA AMBIENTAL', 'ING. AMBIENTAL', 1),
(19, 'INGENIERIA EN ENERGIAS RENOVABLES', 'ING. RENOVABLE', 1),
(21, 'INGENIERIA EN GESTION EMPRESARIAL', 'ING. EN GESTION EMP.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera_programa`
--

CREATE TABLE IF NOT EXISTS `carrera_programa` (
`cvecarpro` int(11) NOT NULL,
  `cveprograma` int(11) NOT NULL,
  `cvecarrera` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `carrera_programa`
--

INSERT INTO `carrera_programa` (`cvecarpro`, `cveprograma`, `cvecarrera`) VALUES
(1, 1, 11),
(2, 2, 11),
(3, 9, 16),
(4, 10, 11),
(5, 14, 11),
(6, 16, 7),
(7, 21, 11),
(18, 41, 11),
(19, 42, 11),
(89, 1, 19),
(90, 1, 7),
(91, 1, 21),
(113, 43, 4),
(114, 43, 6),
(115, 43, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `cvedepartamento` int(11) NOT NULL,
  `cvedependencia` int(11) NOT NULL,
  `nomdepartamento` varchar(30) NOT NULL,
  `puesto` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`cvedepartamento`, `cvedependencia`, `nomdepartamento`, `puesto`) VALUES
(1, 1, 'departamento', 'gerente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencias`
--

CREATE TABLE IF NOT EXISTS `dependencias` (
  `cvedependencia` int(11) NOT NULL,
  `nomdependencia` varchar(35) NOT NULL,
  `cveusuario_1` varchar(15) NOT NULL,
  `rfc` varchar(12) NOT NULL,
  `titular` varchar(50) NOT NULL,
  `direccion` varchar(70) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `estado` enum('ALTA','BAJA','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dependencias`
--

INSERT INTO `dependencias` (`cvedependencia`, `nomdependencia`, `cveusuario_1`, `rfc`, `titular`, `direccion`, `telefono`, `estado`) VALUES
(0, 'Apple', 'appleuser', 'QWERTYUIOEEE', 'J', 'QWE', '6677123456789', 'ALTA'),
(1, 'Nombre Dependencia', 'dependencia', 'RFC', 'pebble', 'direccion', '7104603', 'ALTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE IF NOT EXISTS `documentos` (
  `cveexpediente_1` int(10) NOT NULL,
`cvedocumento` int(11) NOT NULL,
  `tipo` int(1) NOT NULL,
  `tipoDoc` enum('s','cA','pT','rU','rD','rT','cT') NOT NULL,
  `archivonombre` varchar(30) NOT NULL,
  `archivo` varchar(80) NOT NULL,
  `calificacion` int(3) DEFAULT NULL,
  `revisado` int(1) NOT NULL DEFAULT '0' COMMENT '0-sin revisar 1-aceptado 2-rechazado'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`cveexpediente_1`, `cvedocumento`, `tipo`, `tipoDoc`, `archivonombre`, `archivo`, `calificacion`, `revisado`) VALUES
(1, 1, 4, 'rU', 'reporteUno', '12170618-RU.pdf', NULL, 0),
(1, 2, 2, 'cA', 'carta de aceptacion', '12170618-CA.pdf', NULL, 0),
(1, 3, 3, 'pT', 'plan trabajo', '12170618-PT.pdf', NULL, 0),
(1, 4, 5, 'rD', 'reporte dos', '12170618-RD.pdf', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes`
--

CREATE TABLE IF NOT EXISTS `expedientes` (
`cveexpediente` int(10) NOT NULL,
  `cvesolicitud` int(11) NOT NULL,
  `cveusuario_1` varchar(15) NOT NULL,
  `cveprograma_1` int(4) NOT NULL,
  `fechainicio` date NOT NULL,
  `comentario` text NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1-Captura 2-Finalizado',
  `reporteuno` int(11) DEFAULT NULL,
  `reportedos` int(11) DEFAULT NULL,
  `reportetres` int(11) DEFAULT NULL,
  `plantrabajo` int(11) DEFAULT NULL,
  `cartaacep` int(11) DEFAULT NULL,
  `cartatermina` int(11) DEFAULT NULL,
  `fechafinal` date DEFAULT NULL,
  `constanciaOf` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-NO ENTREGADA 1-ENTREGADA'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `expedientes`
--

INSERT INTO `expedientes` (`cveexpediente`, `cvesolicitud`, `cveusuario_1`, `cveprograma_1`, `fechainicio`, `comentario`, `estado`, `reporteuno`, `reportedos`, `reportetres`, `plantrabajo`, `cartaacep`, `cartatermina`, `fechafinal`, `constanciaOf`) VALUES
(1, 2, '12170618', 1, '2017-02-02', 'esxte es un comentario', 1, 1, NULL, NULL, NULL, NULL, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE IF NOT EXISTS `programas` (
`cveprograma` int(11) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `cvedependencia` int(11) NOT NULL,
  `cvedepartamento` int(11) NOT NULL,
  `objetivo` text NOT NULL,
  `vacantes` int(4) NOT NULL,
  `modalidad` enum('Interno','Externo','','') NOT NULL,
  `tipoprog` int(11) NOT NULL,
  `tipoact` enum('Administrativas','Tecnicas','Asesorias','Investigacion','Docentes','Otros') NOT NULL,
  `tipoactdes` text NOT NULL,
  `nomresp` varchar(100) NOT NULL,
  `puestoresp` varchar(60) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '0-Pendiente 1-Aceptado 2-Rechazado',
  `vigencia` int(1) NOT NULL DEFAULT '0' COMMENT '0- Sin Asignar 1- Vigente 2- Expirado'
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`cveprograma`, `nombre`, `cvedependencia`, `cvedepartamento`, `objetivo`, `vacantes`, `modalidad`, `tipoprog`, `tipoact`, `tipoactdes`, `nomresp`, `puestoresp`, `estado`, `vigencia`) VALUES
(1, 'Nombre Programa', 1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin suscipit, libero vitae pharetra suscipit, nulla lectus tincidunt nulla, ac suscipit nisi libero quis urna. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse nec iaculis nulla. Pellentesque at egestas velit. Phasellus varius erat aliquam laoreet fermentum. Aliquam fermentum sed felis vel hendrerit. Maecenas nec finibus leo. Duis accumsan suscipit elit, ut porta odio euismod sit amet. Maecenas orci lorem, feugiat a ullamcorper sit amet, condimentum qui', 1, 'Interno', 1, 'Investigacion', 'Se trata de realzar actividades de documentacion y ayudar en los pendientes que salgan.', 'responsable', 'puesto', 1, 1),
(2, 'Desarrollo ', 1, 1, '', 5, 'Interno', 2, 'Otros', '', 'Martin Nevarez', 'Jefe del area de desarrollo ', 2, 0),
(9, 'p3', 1, 1, 'a', 10, 'Interno', 4, 'Investigacion', 'aa', 'aaa', 'aaa', 1, 0),
(10, 'apw', 1, 1, 'si', 4, 'Externo', 4, 'Docentes', 'adsa', 'asd', 'ds', 2, 0),
(14, 'ssa', 1, 1, 'df', 1, 'Interno', 1, 'Administrativas', 'rg', 'agf', 'fdg', 2, 0),
(16, 'ejem', 1, 1, 'abc', 85, 'Interno', 4, 'Investigacion', 'qwer', 'abc', 'abc', 2, 0),
(21, 'wr', 1, 1, 'ABC', 5, 'Interno', 2, 'Administrativas', 'no', 'abc', 'dfd', 1, 0),
(23, 'test', 1, 1, 'sqas', 2, 'Externo', 4, 'Administrativas', 'sws', 'asd', 'az', 2, 0),
(24, 'za', 1, 1, 'ytre', 44, 'Interno', 1, 'Tecnicas', 'jhhn', 'hh', 'gg', 2, 0),
(41, 'za', 1, 1, 'ytre', 44, 'Interno', 1, 'Tecnicas', 'jhhn', 'hh', 'gg', 2, 0),
(42, 'za', 1, 1, 'ytre', 44, 'Interno', 1, 'Tecnicas', 'jhhn', 'hh', 'gg', 2, 0),
(43, 'TEST PROGRAMA', 1, 1, '1234567890', 5, 'Externo', 2, 'Docentes', 'SI ACTIVIDAD', 'NO', 'NO', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE IF NOT EXISTS `solicitudes` (
`cvesolicitud` int(11) NOT NULL,
  `cveusuario_1` varchar(15) NOT NULL,
  `cveprograma_1` int(4) NOT NULL,
  `estado` int(1) NOT NULL COMMENT '0-Pendiente 1-Aceptado 2-Rechazado',
  `pdocve_1` varchar(4) NOT NULL,
  `motivo` varchar(300) NOT NULL,
  `observaciones` varchar(300) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`cvesolicitud`, `cveusuario_1`, `cveprograma_1`, `estado`, `pdocve_1`, `motivo`, `observaciones`) VALUES
(2, '12170618', 1, 1, '0', '1', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_programa`
--

CREATE TABLE IF NOT EXISTS `tipo_programa` (
`cvetipo` int(11) NOT NULL,
  `tipoprograma` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_programa`
--

INSERT INTO `tipo_programa` (`cvetipo`, `tipoprograma`) VALUES
(1, 'Educacion para adultos'),
(2, 'Contingencia'),
(3, 'Apoyo a la salud'),
(4, 'Establecido por el ITC'),
(5, 'Gubernamental'),
(6, 'Actividades deportivas, culturales y civicas'),
(7, 'Cuidado al medio ambiente y desarrollo sustentable'),
(8, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `cveusuario` varchar(15) NOT NULL,
  `clave` varchar(32) NOT NULL,
  `tipousuario` int(1) NOT NULL COMMENT '1 admin 2 dependencia 3 alumno'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cveusuario`, `clave`, `tipousuario`) VALUES
('12170556', '41d1de28e96dc1cde568d3b068fa17bb', 3),
('12170618', 'd3233f85ca354bcccb2b8e350114edee', 3),
('admin', '21232f297a57a5a743894a0e4a801fc3', 1),
('appleuser', 'e52e843214a94020fc77d67403f10690', 2),
('dependencia', 'e52e843214a94020fc77d67403f10690', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
 ADD PRIMARY KEY (`CARCVE`);

--
-- Indices de la tabla `carrera_programa`
--
ALTER TABLE `carrera_programa`
 ADD PRIMARY KEY (`cvecarpro`), ADD KEY `cvecarrera` (`cvecarrera`), ADD KEY `cveprograma` (`cveprograma`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
 ADD PRIMARY KEY (`cvedependencia`,`cvedepartamento`), ADD KEY `fk_dependencia` (`cvedependencia`);

--
-- Indices de la tabla `dependencias`
--
ALTER TABLE `dependencias`
 ADD PRIMARY KEY (`cvedependencia`), ADD UNIQUE KEY `cveusuario_1` (`cveusuario_1`), ADD KEY `fk_usuarios` (`cveusuario_1`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
 ADD PRIMARY KEY (`cvedocumento`), ADD KEY `fk_expedientes` (`cveexpediente_1`);

--
-- Indices de la tabla `expedientes`
--
ALTER TABLE `expedientes`
 ADD PRIMARY KEY (`cveexpediente`), ADD KEY `cveusuario_1` (`cveusuario_1`,`cveprograma_1`), ADD KEY `reporteuno` (`reporteuno`), ADD KEY `reportedos` (`reportedos`,`reportetres`,`plantrabajo`,`cartaacep`,`cartatermina`), ADD KEY `reportedos_2` (`reportedos`), ADD KEY `reportetres` (`reportetres`,`plantrabajo`), ADD KEY `cartaacep` (`cartaacep`,`cartatermina`), ADD KEY `plantrabajo` (`plantrabajo`,`cartatermina`), ADD KEY `cartatermina` (`cartatermina`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
 ADD PRIMARY KEY (`cveprograma`), ADD KEY `fk_departamentos` (`cvedepartamento`), ADD KEY `cvedependencia` (`cvedependencia`), ADD KEY `cvedependencia_2` (`cvedependencia`,`cvedepartamento`), ADD KEY `tipoprog` (`tipoprog`), ADD KEY `tipoprog_2` (`tipoprog`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
 ADD PRIMARY KEY (`cvesolicitud`), ADD KEY `fk_programas` (`cveprograma_1`);

--
-- Indices de la tabla `tipo_programa`
--
ALTER TABLE `tipo_programa`
 ADD PRIMARY KEY (`cvetipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`cveusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrera_programa`
--
ALTER TABLE `carrera_programa`
MODIFY `cvecarpro` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=119;
--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
MODIFY `cvedocumento` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `expedientes`
--
ALTER TABLE `expedientes`
MODIFY `cveexpediente` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
MODIFY `cveprograma` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
MODIFY `cvesolicitud` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tipo_programa`
--
ALTER TABLE `tipo_programa`
MODIFY `cvetipo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrera_programa`
--
ALTER TABLE `carrera_programa`
ADD CONSTRAINT `fk_carreraprog` FOREIGN KEY (`cvecarrera`) REFERENCES `carreras` (`CARCVE`),
ADD CONSTRAINT `fk_programa` FOREIGN KEY (`cveprograma`) REFERENCES `programas` (`cveprograma`);

--
-- Filtros para la tabla `departamentos`
--
ALTER TABLE `departamentos`
ADD CONSTRAINT `fk_dependencia` FOREIGN KEY (`cvedependencia`) REFERENCES `dependencias` (`cvedependencia`);

--
-- Filtros para la tabla `dependencias`
--
ALTER TABLE `dependencias`
ADD CONSTRAINT `dependencias_ibfk_1` FOREIGN KEY (`cveusuario_1`) REFERENCES `usuarios` (`cveusuario`);

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`cveexpediente_1`) REFERENCES `expedientes` (`cveexpediente`);

--
-- Filtros para la tabla `expedientes`
--
ALTER TABLE `expedientes`
ADD CONSTRAINT `fk_exp_cartaAc` FOREIGN KEY (`cartaacep`) REFERENCES `documentos` (`cvedocumento`),
ADD CONSTRAINT `fk_exp_cartaTer` FOREIGN KEY (`cartatermina`) REFERENCES `documentos` (`cvedocumento`),
ADD CONSTRAINT `fk_exp_planTrabajo` FOREIGN KEY (`plantrabajo`) REFERENCES `documentos` (`cvedocumento`),
ADD CONSTRAINT `fk_exp_reporteDos` FOREIGN KEY (`reportedos`) REFERENCES `documentos` (`cvedocumento`),
ADD CONSTRAINT `fk_exp_reporteTres` FOREIGN KEY (`reportetres`) REFERENCES `documentos` (`cvedocumento`),
ADD CONSTRAINT `fk_exp_reporteUno` FOREIGN KEY (`reporteuno`) REFERENCES `documentos` (`cvedocumento`);

--
-- Filtros para la tabla `programas`
--
ALTER TABLE `programas`
ADD CONSTRAINT `fk_tipo_programa` FOREIGN KEY (`tipoprog`) REFERENCES `tipo_programa` (`cvetipo`),
ADD CONSTRAINT `programas_ibfk_1` FOREIGN KEY (`cvedependencia`, `cvedepartamento`) REFERENCES `departamentos` (`cvedependencia`, `cvedepartamento`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
