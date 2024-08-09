-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2023 a las 15:39:26
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
-- Base de datos: `neolabdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email`
--

CREATE TABLE `email` (
  `idEmail` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `idPerson` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `email`
--

INSERT INTO `email` (`idEmail`, `email`, `idPerson`) VALUES
(8, 'dasdasd@gmail.com', 10),
(9, 'dasdasd@gmail.com', 11),
(10, 'dasdasd@gmail.com', 12),
(11, 'dasdasd@gmail.com', 13),
(12, 'dasdasd@gmail.com', 14),
(13, 'ddfsdfdsfsd@gmail.com', 15),
(14, 'dara@gmail.com', 16),
(15, 'dara@gmail.com', 17),
(16, 'daraelizabeth1502@gmail.com', 18),
(17, 'darae@gmail.com', 19),
(19, 'angelobedvr@gmail.com', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `module`
--

CREATE TABLE `module` (
  `idModule` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `url` varchar(30) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `submodule` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `module`
--

INSERT INTO `module` (`idModule`, `description`, `url`, `icon`, `submodule`) VALUES
(1, 'Administration', 'Admin', '<i class=\"fa-solid fa-globe\"></i>', NULL),
(2, 'User', 'user', NULL, 1),
(3, 'Modulos', 'modules', NULL, 1),
(4, 'Roles', 'roles', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission`
--

CREATE TABLE `permission` (
  `idPermission` int(11) NOT NULL,
  `idModule` int(11) NOT NULL,
  `idRole` int(11) NOT NULL,
  `c` int(11) NOT NULL,
  `r` tinyint(4) NOT NULL,
  `u` tinyint(4) NOT NULL,
  `d` tinyint(4) NOT NULL,
  `p` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `permission`
--

INSERT INTO `permission` (`idPermission`, `idModule`, `idRole`, `c`, `r`, `u`, `d`, `p`) VALUES
(168, 2, 2, 1, 1, 1, 1, 1),
(169, 3, 2, 1, 1, 1, 1, 1),
(170, 4, 2, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `person`
--

CREATE TABLE `person` (
  `idPerson` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `dni` int(8) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `bornDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `person`
--

INSERT INTO `person` (`idPerson`, `name`, `lastName`, `dni`, `gender`, `bornDate`) VALUES
(9, 'Dara', 'Elizabeth', 12345678, 'f', '2023-07-04'),
(10, 'Ddaddgfdgfd', 'dsfdsdfgg', 73772377, 'Femenino', '2023-08-04'),
(11, 'Ddaddgfdgfd', 'dsfdsdfgg', 73772377, 'Femenino', '2023-08-04'),
(12, 'Ddaddgfdgfd', 'dsfdsdfgg', 73772377, 'Femenino', '2023-08-04'),
(13, 'Ddaddgfdgfd', 'dsfdsdfgg', 73772377, 'Femenino', '2023-08-04'),
(14, 'Ddaddgfdgfd', 'dsfdsdfgg', 73772377, 'Femenino', '2023-08-04'),
(15, 'Ddadd', 'dsfds', 73772377, 'Femenino', '2002-07-21'),
(16, 'Ddadd', 'dsfds', 73772377, 'Femenino', '2023-07-12'),
(17, 'Ddadd', 'dsfds', 73772377, 'Femenino', '2023-07-12'),
(18, 'Dara', 'dsfds', 12345678, 'Femenino', '2023-07-20'),
(19, 'Dara', 'dsfds', 73772377, 'Femenino', '2023-07-12'),
(21, 'Angel Obed', 'Villanueva Rojas', 74124977, 'Masculino', '2003-05-05'),
(25, 'Deyvi Jhair', 'Romero lizano', 88888888, 'Masculino', '2023-09-12'),
(26, 'Brando', 'hola', 41414141, 'Femenino', '2023-09-12'),
(27, 'Deyvi Jhair', 'dddd', 21313134, 'Masculino', '2023-09-12'),
(28, 'brand', 'med', 66666666, 'Masculino', '2023-09-13'),
(29, 'brand', 'med', 66666666, 'Masculino', '2023-09-13'),
(30, 'brand', 'med', 66666666, 'Masculino', '2023-09-14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phone`
--

CREATE TABLE `phone` (
  `idPhone` int(11) NOT NULL,
  `number` varchar(11) NOT NULL,
  `idPerson` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `phone`
--

INSERT INTO `phone` (`idPhone`, `number`, `idPerson`) VALUES
(8, '123456789', 10),
(9, '123456789', 11),
(10, '123456789', 12),
(11, '123456789', 13),
(12, '123456789', 14),
(13, '123456789', 15),
(14, '123456789', 16),
(15, '123456789', 17),
(16, '123456789', 18),
(17, '123456789', 19),
(19, '910866082', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `idRole` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`idRole`, `name`, `image`, `state`) VALUES
(2, 'Administrador', '4a7f4d922a.jpg', 1),
(5, 'UserSimple', 'c36864dd2e.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `idPerson` int(11) NOT NULL,
  `idRole` int(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `login_attempts` int(11) DEFAULT 0,
  `login_visit` int(11) DEFAULT NULL,
  `login_visit_day` int(11) NOT NULL,
  `modifications` int(11) DEFAULT NULL,
  `savedLoginToken` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`idUser`, `idPerson`, `idRole`, `username`, `password`, `avatar`, `created_at`, `updated_at`, `last_login`, `state`, `login_attempts`, `login_visit`, `login_visit_day`, `modifications`, `savedLoginToken`) VALUES
(15, 21, 2, 'AngelObedVR', '$2y$10$2Ej2rsf/CWFZMkPfepOcmup2A/Tce67Rz/qkOY5.hxwwfnU6B3cve', '9ece2c1f78.jpg', '2023-07-30 15:20:33', '2023-07-30 23:02:24', '2023-10-15 22:23:20', 1, 1, 33, 24, 5, NULL),
(19, 25, 5, '75235454', '$2y$10$osPD1d5dPO2nXzsZydaSnua.CosK1jumn0rul.ZLFW.JYGGN7wWdW', '197e6bdc4f.png', '2023-09-12 15:13:18', '2023-09-12 15:53:53', '2023-09-12 15:13:18', 0, 0, 1, 0, 2, NULL),
(20, 26, 2, '41414141', '$2y$10$5QWHNYI7xYwZlunP2OhHtO.Xm4y1o8I/ZXxiu8vxppmIJL7OjwI4a', '17a812a930.png', '2023-09-12 16:28:53', '2023-09-12 16:35:52', '2023-09-12 16:28:53', 1, 0, 1, 0, 2, NULL),
(21, 27, 5, '21313134', 'Brandomedina22', '443934da22.jpg', '2023-09-12 16:36:44', '2023-09-12 16:37:08', '2023-09-12 16:36:44', 1, 0, 2, 0, 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`idModule`),
  ADD KEY `FK_module_submodule` (`submodule`);

--
-- Indices de la tabla `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`idPermission`),
  ADD KEY `FK_PermissionRole` (`idRole`),
  ADD KEY `FK_PermissionModule` (`idModule`);

--
-- Indices de la tabla `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`idPerson`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idRole`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `FK_NewUser` (`idPerson`),
  ADD KEY `FK_RoleUser` (`idRole`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `module`
--
ALTER TABLE `module`
  MODIFY `idModule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `permission`
--
ALTER TABLE `permission`
  MODIFY `idPermission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT de la tabla `person`
--
ALTER TABLE `person`
  MODIFY `idPerson` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `idRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `FK_module_submodule` FOREIGN KEY (`submodule`) REFERENCES `module` (`idModule`);

--
-- Filtros para la tabla `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `FK_PermissionModule` FOREIGN KEY (`idModule`) REFERENCES `module` (`idModule`),
  ADD CONSTRAINT `FK_PermissionRole` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_NewUser` FOREIGN KEY (`idPerson`) REFERENCES `person` (`idPerson`),
  ADD CONSTRAINT `FK_RoleUser` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
