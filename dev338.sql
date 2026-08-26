-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 20, 2025 at 11:03 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dev338`
--

-- --------------------------------------------------------

--
-- Table structure for table `anios`
--

CREATE TABLE `anios` (
  `id` bigint UNSIGNED NOT NULL,
  `anio` int NOT NULL,
  `descripcion` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `anios`
--

INSERT INTO `anios` (`id`, `anio`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 1, 'PRIMERO', NULL, NULL),
(2, 2, 'SEGUNDO', NULL, NULL),
(3, 3, 'TERCERO', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aptitudes`
--

CREATE TABLE `aptitudes` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `aptitud` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `aptitudes`
--

INSERT INTO `aptitudes` (`id`, `usuario_id`, `aptitud`, `created_at`, `updated_at`) VALUES
(1, 1, 'Voluptas distinctio quam quod aliquid quo est ut. Eos vitae et qui et iste omnis aut assumenda.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 1, 'Expedita ratione aspernatur non est. Cupiditate cupiditate sunt necessitatibus.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(3, 1, 'Alias quaerat porro numquam sunt tempore. Quas accusantium natus ut aut.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(4, 1, 'Et exercitationem sed odio adipisci repudiandae in. Iusto sapiente et saepe iste dignissimos et rerum.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(5, 22, 'asdasdasd', '2025-09-25 00:50:38', '2025-09-25 00:50:38');

-- --------------------------------------------------------

--
-- Table structure for table `año_academico`
--

CREATE TABLE `año_academico` (
  `id` bigint UNSIGNED NOT NULL,
  `año` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `año_academico`
--

INSERT INTO `año_academico` (`id`, `año`, `created_at`, `updated_at`) VALUES
(1, '1° año', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(2, '2° año', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(3, '3° año', '2025-09-24 11:13:26', '2025-09-24 11:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `beneficios_ofertas`
--

CREATE TABLE `beneficios_ofertas` (
  `id` bigint UNSIGNED NOT NULL,
  `oferta_id` bigint UNSIGNED NOT NULL,
  `beneficio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `beneficios_ofertas`
--

INSERT INTO `beneficios_ofertas` (`id`, `oferta_id`, `beneficio`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ipsa accusamus tenetur harum nihil et et magni.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 1, 'Excepturi error maxime dolore nulla dignissimos aspernatur aut voluptatem.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(3, 1, 'Et distinctio deserunt eaque quo.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(4, 2, 'Nihil dolor repudiandae hic inventore aliquam.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(5, 2, 'Architecto dolorum quos et ipsa impedit consequatur ratione.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(6, 2, 'Aut beatae molestiae architecto quis.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(7, 3, 'Labore facere et est officia dolorum.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(8, 3, 'Corporis cupiditate sunt animi qui.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(9, 3, 'Aspernatur dolorem sed labore possimus nihil numquam ex.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(10, 4, 'Consequuntur eos est nemo et ab.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(11, 4, 'Aliquid sint nulla iure.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(12, 4, 'Optio adipisci blanditiis enim dolorem atque velit.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(13, 5, 'Voluptas quod sunt sed modi commodi eaque quod.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(14, 5, 'Ut adipisci et fugiat est vel nemo temporibus.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(15, 5, 'Et corrupti eum unde tempora consequatur culpa repudiandae.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(16, 6, 'Fuga velit qui soluta voluptas.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(17, 6, 'Rerum expedita eius occaecati et illo.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(18, 6, 'Commodi natus sed ea.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(19, 7, 'Voluptas doloribus soluta ipsa molestiae id.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(20, 7, 'Quia quo nisi rerum eos.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(21, 7, 'Ipsam ut qui quis odit.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(22, 8, 'Velit rerum rerum enim laboriosam.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(23, 8, 'Consectetur dignissimos reprehenderit possimus cupiditate.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(24, 8, 'Quo veritatis dolor sint alias similique id.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(25, 9, 'Et atque corrupti in dolores reprehenderit.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(26, 9, 'Placeat quo nihil aliquam quam vel fugiat ut tenetur.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(27, 9, 'Et molestias rerum libero et aut tempora.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(28, 10, 'Occaecati consequatur saepe quidem alias.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(29, 10, 'Nulla voluptatem voluptatem eius et sunt aperiam corrupti.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(30, 10, 'Consequuntur temporibus natus neque reiciendis expedita assumenda.', '2025-09-24 11:13:28', '2025-09-24 11:13:28');

-- --------------------------------------------------------

--
-- Table structure for table `carreras`
--

CREATE TABLE `carreras` (
  `id` bigint UNSIGNED NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `anios` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `resolucion` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `texto` varchar(3000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `imagen` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `nombre_carpeta` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `carreras`
--

INSERT INTO `carreras` (`id`, `descripcion`, `anios`, `resolucion`, `texto`, `imagen`, `nombre_carpeta`, `created_at`, `updated_at`) VALUES
(1, 'Tecnicatura Superior en Logística', '3', '5312/24', 'Es el profesional capacitado para gestionar, diseñar, implementar, evaluar y optimizar los procesos que componen la administración del flujo de materiales y servicios desde el proveedor hasta el cliente. Tendrá la capacidad de implementar técnicas que faciliten la toma de decisiones y procedimientos para la gestión en el área, de acuerdo a los marcos conceptuales que sustentan los principios y normas pertinente al campo de la logística.', 'carreras/1/logistica.jfif', 'Logistica', NULL, '2025-03-30 09:08:57'),
(2, 'Tecnicatura Superior en Análisis de Sistemas', '3', '6790/19', 'Es el profesional capacitado para diagnosticar necesidades, diseñar, desarrollar, poner en servicio y mantener productos, servicios o soluciones informáticas acorde a los requerimientos de las organizaciones.\r\n\r\nTendrá la capacidad de diagnosticar el conflicto de una organización, podrá ordenar sus recursos y actividades, además diseñar y desarrollar sistemas informáticos.', 'carreras/2/Sistemas.jpeg', 'Sistemas', NULL, '2022-10-22 13:23:17'),
(3, 'Tecnicatura Superior en Administración Contable', '3', '455/23', 'El Técnico Superior en Administración Contable es un profesional que estará capacitado para desarrollar las competencias para: organizar, programar, ejecutar y controlar las operaciones comerciales, financieras y administrativas de la organización; elaborar, controlar y registrar el flujo de información; organizar y planificar los recursos referidos para desarrollar sus actividades interactuando con el entorno y participando en la toma de decisiones relacionadas con sus actividades. Coordinando equipos de trabajo relacionado con su especialidad. Estas competencias serán desarrolladas según las incumbencias y las normas técnicas y legales que rigen su campo profesional.', 'carreras/3/contable.jpg', 'Contable', NULL, '2025-03-30 09:07:57'),
(4, 'Tecnicatura Superior en Administración de Recursos Humanos', '3', '5311/24', 'Es el profesional capacitado para organizar, programar, planificar y ejecutar diversas actividades del sector de Recursos Humanos de las organizaciones en las cuales se inserte. Tendrá la capacidad de organizar, programar, ejecutar y controlar en las áreas de desarrollo de dirección y planeamiento, producción, recursos humanos, financiamiento, contabilización, gestión integral dentro de los distintos tipos de organización.', 'carreras/4/RRHH.jpg', 'RRHH', NULL, '2025-03-30 09:08:17'),
(5, 'Tecnicatura Superior en Gestión Ambiental y Salud', '3', '442/08 y 2257/08', 'Es el profesional con formación científica, tecnológica y ética, competente para la intervención en los procesos técnicos y específicos del campo de la gestión ambiental. Diseñará y ejecutará planes y programas tendientes a la vigilancia ambiental y sanitaria, en ámbitos urbanos y rurales.\r\n\r\nTendrá la capacidad de coordinar actividades de protección y promoción de la salud ambiental e implementar estrategias de atención primaria.', 'carreras/5/GestionAmbiental.jpg', 'Gestion', NULL, '2023-03-10 04:59:32'),
(6, 'Tecnicatura Superior en Higiene y Seguridad en el Trabajo', '3', '320/13', 'Es el profesional capacitado para el asesoramiento a reparticiones, empresas y asociaciones profesionales en todo lo concerniente a su actividad. Estará habilitado para controlar el cumplimiento de las normas de seguridad e higiene en el trabajo en el área de su competencia, adoptando las medidas preventivas de acuerdo a cada tipo de industria o actividad. Tendrá la capacidad de elaborar normas manuales de higiene y seguridad en el trabajo, además de realizar tareas de investigación y desarrollo para el mejor desenvolvimiento de su labor.', 'carreras/6/Seguridad.jpeg', 'Seguridad', NULL, '2022-11-03 15:05:07'),
(8, 'Tecnicatura Superior en Mantenimiento Industrial', '3', '3650/00', 'Es el profesional que tendrá como propósito identificar problemas, buscar alternativas y tomar decisiones ante la presencia de fallas. A su vez, estará habilitado para evaluar situaciones y diseñar propuestas de mejora en el mantenimiento. Tendrá la capacidad de la organización del trabajo propio y de los otros a su cargo. Podrá formular y ejecutar planes de mantenimiento preventivo y predictivo óptimos, en función de los mecanismos de deterioros detectados. Tendrá además la habilidad para inspeccionar e identificar el estado de deterioro de un equipo para lograr su restauración, mejorando la confiabilidad y mantenibilidad del mismo.', 'carreras/8/maintenance-trends.jpeg', 'Industrial', NULL, '2025-03-30 09:07:03'),
(26, 'Tecnicatura Superior en Internet de las Cosas y Sistemas Embebidos', '3', '3780/22', 'La/el Técnica/o Superior en Internet de las Cosas y Sistemas Embebidos estará capacitada/o para afrontar con éxito los desafíos requeridos para el despliegue y mantenimiento de esta transformación digital; como así también analizará, gestionará y mitigará los riesgos detectados del ecosistema IoT de una organización. A su vez, su tarea se realizará en interconexión con el resto de las/os trabajadores/as de los ámbitos en los que se desempeñe ya que, al digitalizar todos los controles de los procesos de fabricación y prestación de servicios, se amplía la información de la que disponen los equipos de trabajo para la toma de decisiones. De esta forma, se podría promover una cultura de trabajo interdisciplinaria y más democrática y, a la vez, con aumento de la productividad de las cadenas de valor.', 'carreras/26/Sistemas2.jpeg', 'TSIC', '2025-02-20 10:38:39', '2025-02-22 09:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `carrerasedes`
--

CREATE TABLE `carrerasedes` (
  `id` bigint UNSIGNED NOT NULL,
  `sede_id` bigint UNSIGNED DEFAULT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `carrerasedes`
--

INSERT INTO `carrerasedes` (`id`, `sede_id`, `carrera_id`, `created_at`, `updated_at`) VALUES
(11, 1, 11, '2022-09-30 08:54:39', '2022-09-30 08:54:39'),
(14, 1, 12, '2022-10-14 12:28:33', '2022-10-14 12:28:33'),
(15, 1, 13, '2022-10-20 14:03:11', '2022-10-20 14:03:11'),
(25, 1, 2, '2022-10-29 17:23:59', '2022-10-29 17:23:59'),
(32, 1, 6, '2022-11-03 15:05:07', '2022-11-03 15:05:07'),
(33, 1, 14, '2023-02-24 07:53:18', '2023-02-24 07:53:18'),
(34, 1, 15, '2023-02-24 07:55:30', '2023-02-24 07:55:30'),
(35, 1, 16, '2023-02-24 08:03:29', '2023-02-24 08:03:29'),
(36, 1, 17, '2023-02-24 08:09:32', '2023-02-24 08:09:32'),
(37, 1, 18, '2023-02-24 08:23:14', '2023-02-24 08:23:14'),
(38, 1, 19, '2023-02-24 08:39:34', '2023-02-24 08:39:34'),
(39, 1, 20, '2023-02-24 08:43:48', '2023-02-24 08:43:48'),
(40, 1, 21, '2023-02-25 00:49:14', '2023-02-25 00:49:14'),
(41, 1, 22, '2023-02-25 01:09:26', '2023-02-25 01:09:26'),
(42, 1, 23, '2023-02-25 01:19:50', '2023-02-25 01:19:50'),
(43, 1, 24, '2023-02-25 01:26:13', '2023-02-25 01:26:13'),
(44, 1, 25, '2023-02-25 07:05:46', '2023-02-25 07:05:46'),
(45, 1, 5, '2023-03-10 04:59:32', '2023-03-10 04:59:32'),
(56, 1, 26, '2025-02-22 09:22:05', '2025-02-22 09:22:05'),
(57, 1, 8, '2025-03-30 09:07:03', '2025-03-30 09:07:03'),
(61, 1, 4, '2025-03-30 09:08:17', '2025-03-30 09:08:17'),
(62, 1, 1, '2025-03-30 09:08:57', '2025-03-30 09:08:57'),
(63, 1, 3, '2025-10-02 01:32:05', '2025-10-02 01:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `carreras_ofertas`
--

CREATE TABLE `carreras_ofertas` (
  `id` bigint UNSIGNED NOT NULL,
  `carrera_id` bigint UNSIGNED NOT NULL,
  `oferta_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `id` int NOT NULL,
  `categoria` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id`, `categoria`, `descripcion`) VALUES
(1, 'Sistemas/ICSE', 'Materias relacionadas a computación, programación.'),
(2, 'Matematica, Física y Química', 'Materias relacionadas a los numeros.'),
(3, 'Idiomas', 'Materias relacionada a idiomas.'),
(4, 'Ciencias Sociales', 'Materias relacionadas a las ciencias.'),
(5, 'Derecho', 'Materias relacionada a las leyes.'),
(6, 'Administración Contable', 'Materias relacionadas a contable.'),
(7, 'Administración de RRHH', 'Materias relacionadas a RRHH.'),
(8, 'Mantenimiento', 'Materias relacionadas a mantenimiento.'),
(9, 'Gestión Ambiental y Salud', 'Materias relacionadas a Gestión ambiental.'),
(10, 'Higiene y Seguridad', 'Materias relacionadas a Higiene y Seguridad.'),
(11, 'Logistica', 'Materias relacionadas a logística.');

-- --------------------------------------------------------

--
-- Table structure for table `comisions`
--

CREATE TABLE `comisions` (
  `id` bigint UNSIGNED NOT NULL,
  `sede_id` bigint UNSIGNED DEFAULT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `comision` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `comisions`
--

INSERT INTO `comisions` (`id`, `sede_id`, `carrera_id`, `comision`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'A', NULL, NULL),
(2, NULL, NULL, 'B', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `configuraciones`
--

CREATE TABLE `configuraciones` (
  `id` bigint UNSIGNED NOT NULL,
  `clave` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `configuraciones`
--

INSERT INTO `configuraciones` (`id`, `clave`, `valor`, `created_at`, `updated_at`) VALUES
(1, 'mostrar_mesas', 1, '2025-09-04 03:51:07', '2025-09-18 02:05:25'),
(2, 'mostrar_mesas_frontend', 1, '2025-09-08 16:49:58', '2025-09-08 16:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `correlativas`
--

CREATE TABLE `correlativas` (
  `id` bigint UNSIGNED NOT NULL,
  `materia_id` bigint UNSIGNED NOT NULL,
  `correlativa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `correlativas`
--

INSERT INTO `correlativas` (`id`, `materia_id`, `correlativa_id`, `created_at`, `updated_at`) VALUES
(1, 16, 5, NULL, '2025-08-22 02:24:35'),
(2, 12, 212, NULL, NULL),
(3, 12, 7, NULL, NULL),
(4, 14, 212, NULL, NULL),
(5, 14, 7, NULL, NULL),
(6, 15, 8, NULL, NULL),
(7, 9, 4, NULL, NULL),
(8, 11, 6, NULL, NULL),
(9, 10, 4, NULL, NULL),
(10, 13, 8, NULL, NULL),
(11, 13, 2, NULL, NULL),
(12, 23, 16, NULL, NULL),
(13, 20, 11, NULL, NULL),
(14, 22, 15, NULL, NULL),
(15, 18, 212, NULL, NULL),
(16, 18, 9, NULL, NULL),
(17, 1, 13, NULL, NULL),
(18, 1, 9, NULL, NULL),
(19, 1, 10, NULL, NULL),
(20, 1, 15, NULL, NULL),
(21, 230, 227, NULL, NULL),
(22, 230, 223, NULL, NULL),
(23, 231, 227, NULL, NULL),
(24, 231, 225, NULL, NULL),
(25, 239, 231, NULL, NULL),
(26, 233, 230, NULL, NULL),
(27, 242, 231, NULL, NULL),
(28, 241, 240, NULL, NULL),
(29, 48, NULL, NULL, NULL),
(30, 50, NULL, NULL, NULL),
(31, 51, NULL, NULL, NULL),
(32, 52, NULL, NULL, NULL),
(33, 53, NULL, NULL, NULL),
(34, 55, NULL, NULL, NULL),
(35, 56, NULL, NULL, NULL),
(36, 62, NULL, NULL, NULL),
(37, 67, 56, NULL, NULL),
(38, 60, 50, NULL, NULL),
(39, 61, 50, NULL, NULL),
(40, 65, 55, NULL, NULL),
(41, 66, 55, NULL, NULL),
(42, 68, 56, NULL, NULL),
(43, 68, 51, NULL, NULL),
(44, 63, 56, NULL, NULL),
(45, 215, 62, NULL, NULL),
(46, 64, 52, NULL, NULL),
(47, 244, 61, NULL, NULL),
(48, 70, 64, NULL, NULL),
(49, 247, 66, NULL, NULL),
(50, 247, 65, NULL, NULL),
(51, 246, 65, NULL, NULL),
(52, 246, 66, NULL, NULL),
(53, 245, 67, NULL, NULL),
(54, 248, 63, NULL, NULL),
(55, 249, 61, NULL, NULL),
(56, 249, 63, NULL, NULL),
(57, 249, 67, NULL, NULL),
(58, 108, NULL, NULL, NULL),
(59, 109, NULL, NULL, NULL),
(60, 110, NULL, NULL, NULL),
(61, 111, NULL, NULL, NULL),
(62, 112, NULL, NULL, NULL),
(63, 113, NULL, NULL, NULL),
(64, 114, NULL, NULL, NULL),
(65, 115, NULL, NULL, NULL),
(66, 116, NULL, NULL, NULL),
(67, 124, 113, NULL, NULL),
(68, 124, 114, NULL, NULL),
(69, 124, 109, NULL, NULL),
(70, 121, 109, NULL, NULL),
(71, 121, 114, NULL, NULL),
(72, 121, 112, NULL, NULL),
(73, 118, 109, NULL, NULL),
(74, 123, 113, NULL, NULL),
(75, 123, 111, NULL, NULL),
(76, 123, 108, NULL, NULL),
(77, 117, 108, NULL, NULL),
(78, 119, 113, NULL, NULL),
(79, 119, 114, NULL, NULL),
(80, 119, 109, NULL, NULL),
(81, 119, 111, NULL, NULL),
(82, 119, 112, NULL, NULL),
(83, 119, 108, NULL, NULL),
(84, 119, 110, NULL, NULL),
(85, 132, 117, NULL, NULL),
(86, 131, 118, NULL, NULL),
(87, 131, 124, NULL, NULL),
(88, 131, 121, NULL, NULL),
(89, 126, 116, NULL, NULL),
(90, 126, 118, NULL, NULL),
(91, 129, 124, NULL, NULL),
(92, 129, 121, NULL, NULL),
(93, 129, 118, NULL, NULL),
(94, 129, 117, NULL, NULL),
(95, 127, 123, NULL, NULL),
(96, 128, 124, NULL, NULL),
(97, 128, 120, NULL, NULL),
(98, 128, 121, NULL, NULL),
(99, 128, 118, NULL, NULL),
(100, 128, 123, NULL, NULL),
(101, 128, 117, NULL, NULL),
(102, 128, 119, NULL, NULL),
(103, 133, NULL, NULL, NULL),
(104, 134, NULL, NULL, NULL),
(105, 135, NULL, NULL, NULL),
(106, 136, NULL, NULL, NULL),
(107, 137, NULL, NULL, NULL),
(108, 138, NULL, NULL, NULL),
(109, 139, NULL, NULL, NULL),
(110, 141, NULL, NULL, NULL),
(111, 142, NULL, NULL, NULL),
(112, 149, 137, NULL, NULL),
(113, 144, 134, NULL, NULL),
(114, 146, 136, NULL, NULL),
(115, 150, 136, NULL, NULL),
(116, 160, 135, NULL, NULL),
(117, 143, 133, NULL, NULL),
(118, 161, 141, NULL, NULL),
(119, 153, 143, NULL, NULL),
(120, 157, 148, NULL, NULL),
(121, 159, 148, NULL, NULL),
(122, 184, NULL, NULL, NULL),
(123, 185, NULL, NULL, NULL),
(124, 186, NULL, NULL, NULL),
(125, 187, NULL, NULL, NULL),
(126, 188, NULL, NULL, NULL),
(127, 189, NULL, NULL, NULL),
(128, 190, NULL, NULL, NULL),
(129, 191, NULL, NULL, NULL),
(130, 192, NULL, NULL, NULL),
(131, 193, NULL, NULL, NULL),
(132, 196, 189, NULL, NULL),
(133, 196, 191, NULL, NULL),
(134, 196, 190, NULL, NULL),
(135, 196, 188, NULL, NULL),
(136, 196, 186, NULL, NULL),
(137, 197, 191, NULL, NULL),
(138, 197, 190, NULL, NULL),
(139, 197, 188, NULL, NULL),
(140, 197, 186, NULL, NULL),
(141, 200, 188, NULL, NULL),
(142, 200, 186, NULL, NULL),
(143, 201, 186, NULL, NULL),
(144, 201, 190, NULL, NULL),
(145, 201, 188, NULL, NULL),
(146, 199, 188, NULL, NULL),
(147, 199, 186, NULL, NULL),
(148, 195, 185, NULL, NULL),
(149, 195, 191, NULL, NULL),
(150, 195, 192, NULL, NULL),
(151, 195, 188, NULL, NULL),
(152, 198, 187, NULL, NULL),
(153, 210, 201, NULL, NULL),
(154, 210, 197, NULL, NULL),
(155, 210, 188, NULL, NULL),
(156, 210, 190, NULL, NULL),
(157, 210, 191, NULL, NULL),
(158, 208, NULL, NULL, NULL),
(159, 207, 193, NULL, NULL),
(160, 207, 188, NULL, NULL),
(161, 207, 186, NULL, NULL),
(162, 207, 190, NULL, NULL),
(163, 207, 192, NULL, NULL),
(164, 207, 191, NULL, NULL),
(165, 207, 189, NULL, NULL),
(166, 205, 184, NULL, NULL),
(167, 204, 186, NULL, NULL),
(168, 204, 193, NULL, NULL),
(169, 206, 193, NULL, NULL),
(170, 206, 186, NULL, NULL),
(171, 209, 184, NULL, NULL),
(172, 209, 185, NULL, NULL),
(173, 209, 186, NULL, NULL),
(174, 209, 187, NULL, NULL),
(175, 209, 188, NULL, NULL),
(176, 209, 189, NULL, NULL),
(177, 209, 190, NULL, NULL),
(178, 209, 191, NULL, NULL),
(179, 209, 192, NULL, NULL),
(180, 209, 193, NULL, NULL),
(181, 209, 201, NULL, NULL),
(182, 209, 200, NULL, NULL),
(183, 209, 199, NULL, NULL),
(184, 209, 198, NULL, NULL),
(185, 209, 196, NULL, NULL),
(186, 209, 197, NULL, NULL),
(187, 209, 195, NULL, NULL),
(188, 203, 184, NULL, NULL),
(189, 203, 185, NULL, NULL),
(190, 203, 186, NULL, NULL),
(191, 203, 187, NULL, NULL),
(192, 203, 188, NULL, NULL),
(193, 203, 189, NULL, NULL),
(194, 203, 190, NULL, NULL),
(195, 203, 191, NULL, NULL),
(196, 203, 192, NULL, NULL),
(197, 203, 193, NULL, NULL),
(198, 203, 195, NULL, NULL),
(199, 203, 196, NULL, NULL),
(200, 203, 197, NULL, NULL),
(201, 203, 198, NULL, NULL),
(202, 203, 199, NULL, NULL),
(203, 203, 200, NULL, NULL),
(204, 203, 201, NULL, NULL),
(206, 218, 24, NULL, NULL),
(207, 270, 33, NULL, NULL),
(208, 266, 216, NULL, NULL),
(209, 269, 27, NULL, NULL),
(210, 271, 266, NULL, NULL),
(211, 278, 269, NULL, NULL),
(212, 281, 270, NULL, NULL),
(221, 89, 84, NULL, NULL),
(222, 97, 84, NULL, NULL),
(223, 255, 86, NULL, NULL),
(224, 252, 83, NULL, NULL),
(225, 94, 81, NULL, NULL),
(226, 258, 82, NULL, NULL),
(227, 259, 254, NULL, NULL),
(228, 106, 87, NULL, NULL),
(229, 282, 258, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cuatrimestres`
--

CREATE TABLE `cuatrimestres` (
  `id` tinyint UNSIGNED NOT NULL,
  `nombre` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `cuatrimestres`
--

INSERT INTO `cuatrimestres` (`id`, `nombre`) VALUES
(1, 'PRIMERO'),
(2, 'SEGUNDO');

-- --------------------------------------------------------

--
-- Table structure for table `cupos`
--

CREATE TABLE `cupos` (
  `id` bigint UNSIGNED NOT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `cupos` int NOT NULL,
  `reservados` int NOT NULL,
  `inscriptos` int NOT NULL,
  `perdidos` int DEFAULT NULL,
  `pendientes` int DEFAULT NULL,
  `pendientes_sd` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `institucion` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_fin` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temas_principales` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `cursos`
--

INSERT INTO `cursos` (`id`, `usuario_id`, `nombre`, `institucion`, `fecha`, `fecha_fin`, `temas_principales`, `created_at`, `updated_at`) VALUES
(1, 1, 'Et in quis facilis.', 'Agosto, Aragón y Sedillo', '2022-08', '2026-05', 'Et aut atque laboriosam necessitatibus voluptatem sed voluptatem cum laborum et numquam.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 22, 'asdasd', 'asdasdasd', '2025-07', '2025-12', 'adasdasdasd', '2025-09-25 00:51:03', '2025-09-25 00:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `cvs`
--

CREATE TABLE `cvs` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `nombre_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `cvs`
--

INSERT INTO `cvs` (`id`, `usuario_id`, `nombre_archivo`, `created_at`, `updated_at`) VALUES
(1, 1, '1758736296_gisela.docx', '2025-09-25 00:51:36', '2025-09-25 00:51:36');

-- --------------------------------------------------------

--
-- Table structure for table `estados`
--

CREATE TABLE `estados` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `estados`
--

INSERT INTO `estados` (`id`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'Activa', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 'Finalizada', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(3, 'Borrador', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(4, 'Expirada', '2025-09-24 21:53:20', '2025-09-24 21:53:20');

-- --------------------------------------------------------

--
-- Table structure for table `estudios`
--

CREATE TABLE `estudios` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `institucion` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` enum('cursando','recibido') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `materias_aprobadas` int DEFAULT NULL,
  `materias_totales` int DEFAULT NULL,
  `promedio_final` decimal(4,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `estudios`
--

INSERT INTO `estudios` (`id`, `usuario_id`, `institucion`, `titulo`, `descripcion`, `fecha_inicio`, `fecha_fin`, `estado`, `materias_aprobadas`, `materias_totales`, `promedio_final`, `created_at`, `updated_at`) VALUES
(1, 22, 'asdasd', 'asdasdas', 'dasdasdasdasd', '2025-11-01', NULL, 'cursando', 20, 80, '0.00', '2025-09-25 00:50:31', '2025-09-25 00:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `etiquetas`
--

CREATE TABLE `etiquetas` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `descripcion` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `etiquetas`
--

INSERT INTO `etiquetas` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'novedades', 'Novedades', '2022-09-22 12:47:39', '2022-09-22 12:47:39'),
(23, 'cronograma', 'Calendario Académico', NULL, '2024-11-08 08:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `experiencias_laborales`
--

CREATE TABLE `experiencias_laborales` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `empresa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `puesto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `logros` json DEFAULT NULL,
  `horario` enum('Full-Time','Part-Time','Rotativo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Full-Time',
  `año_inicio` date NOT NULL,
  `año_fin` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `experiencias_laborales`
--

INSERT INTO `experiencias_laborales` (`id`, `usuario_id`, `empresa`, `puesto`, `descripcion`, `logros`, `horario`, `año_inicio`, `año_fin`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ornelas de Barajas', 'ut', 'Quibusdam officiis dolores minus. Omnis eius qui eum sed voluptatem mollitia enim. Suscipit qui dignissimos nisi. Facilis aliquam iste est minus. Quia ipsum totam eos voluptatum dolore. Nobis laudantium veritatis quia sint voluptas. In iste molestiae et ullam et.', '[\"Et enim voluptatem qui et dolores occaecati similique.\", \"Aliquam eos nihil et similique ipsa ab quis eveniet.\", \"Natus id voluptatem et veniam.\"]', 'Rotativo', '2018-03-31', '2024-07-17', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 1, 'Orosco-Galván', 'tempora', 'Et deleniti fuga molestias animi qui officiis perferendis consequatur. Qui qui quis saepe molestiae. Animi consequatur iusto saepe nobis placeat. Sed et veniam ducimus natus quis vel laborum. Omnis architecto sapiente modi cupiditate sed blanditiis. Fugit qui incidunt est in enim atque. Omnis optio corporis nobis et ut id et.', '[\"Iure enim dolorem nihil laborum quo omnis distinctio sint.\", \"Voluptas impedit sunt quia ut.\", \"Deleniti est voluptates et ut.\"]', 'Part-Time', '2020-02-26', '2021-04-06', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(3, 1, 'Pérez de Orosco', 'quia', 'Dolorem iure et accusamus temporibus at. Exercitationem itaque molestiae eos minima. Placeat exercitationem ducimus soluta adipisci laboriosam animi velit. Reprehenderit reprehenderit dolorem aut quaerat iusto. Voluptatum ad nesciunt sit minima quisquam rerum magnam. Sunt impedit et sunt architecto rem tempora enim similique. Animi expedita doloremque veritatis voluptas sint. Dolores porro saepe eligendi.', '[\"Et voluptate harum libero et dolor inventore.\", \"Voluptatem placeat doloremque perferendis et.\", \"Ut natus doloribus modi veritatis quia reprehenderit.\"]', 'Rotativo', '2019-07-20', '2022-07-22', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(4, 22, 'asdasdas', 'asdasdasdasdasdas', 'adsasdasdas', '[\"asdasdasdasdasd\"]', 'Full-Time', '2025-07-01', '2025-08-01', '2025-09-25 00:49:54', '2025-09-25 00:50:01');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `habilidades_blandas`
--

CREATE TABLE `habilidades_blandas` (
  `id` bigint UNSIGNED NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `habilidades_blandas`
--

INSERT INTO `habilidades_blandas` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Comunicación efectiva', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(2, 'Resolución de problemas', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(3, 'Pensamiento analítico', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(4, 'Capacidad de trabajo en equipo', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(5, 'Adaptabilidad', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(6, 'Organización y gestion del tiempo', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(7, 'Creatividad e innovación', '2025-09-24 11:13:26', '2025-09-24 21:56:26'),
(8, 'Empatía y habilidades interpersonales', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(9, 'Pensamiento crítico', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(10, 'Habilidades de negociación', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(11, 'Liderazgo', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(12, 'Toma de decisiones', '2025-09-24 11:13:26', '2025-09-24 11:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `habilidades_blandas_ofertas`
--

CREATE TABLE `habilidades_blandas_ofertas` (
  `id` bigint UNSIGNED NOT NULL,
  `oferta_id` bigint UNSIGNED NOT NULL,
  `habilidad_blanda_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `habilidades_blandas_ofertas`
--

INSERT INTO `habilidades_blandas_ofertas` (`id`, `oferta_id`, `habilidad_blanda_id`, `created_at`, `updated_at`) VALUES
(1, 3, 8, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 3, 7, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(3, 3, 11, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(4, 5, 11, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(5, 5, 6, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(6, 5, 10, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(7, 8, 7, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(8, 8, 4, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(9, 8, 4, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(10, 1, 10, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(11, 1, 12, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(12, 1, 4, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(13, 2, 7, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(14, 2, 3, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(15, 2, 1, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(16, 6, 2, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(17, 6, 10, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(18, 6, 5, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(19, 7, 7, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(20, 7, 10, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(21, 7, 12, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(22, 10, 10, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(23, 10, 3, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(24, 10, 4, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(25, 4, 6, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(26, 4, 6, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(27, 4, 7, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(28, 9, 7, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(29, 9, 3, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(30, 9, 7, '2025-09-24 11:13:29', '2025-09-24 11:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `historias`
--

CREATE TABLE `historias` (
  `id` bigint UNSIGNED NOT NULL,
  `historia` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sede_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `historias`
--

INSERT INTO `historias` (`id`, `historia`, `sede_id`, `created_at`, `updated_at`) VALUES
(2, '<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"es\" style=\"font-size:\r\n14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\"\"=\"\"><b><u>Historia Institucional</u></b></span></p><p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"es\" style=\"font-size:\r\n14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\"\"=\"\">En estos 50\r\naños de historia festejamos la vida del instituto y&nbsp; lo haremos honrando la actividad aca</span><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\r\n\" comic=\"\" sans=\"\" ms\";mso-ansi-language:es-ar\"=\"\">démica resaltando el respeto, la\r\nresponsabilidad y el compromiso ético con la educación superior tal como lo\r\nplanificaron aquellos que quisieron brindar a la sociedad profesionales\r\ncompetentes para responder a la intensa demanda de nuestra ciudad y alrededores.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">Gracias a la iniciativa de un grupo de visionarios\r\nsurge a comienzos de la década del 70 la necesidad de creación de un INSTITUTO\r\nSuperior destinado a la enseñanza técnica de nivel superior para los habitantes\r\nde nuestra zona.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">Por entonces se vislumbró que la estructura interna\r\ndel sector productivo había alcanzado un grado de heterogeneidad mucho mayor que\r\nel que tuviera hasta ese momento generando en consecuencia y un estancamiento\r\ndel volumen de mano de obra especializada para las ramas más dinámicas de la\r\nindustria y el comercio. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">Con el objeto de satisfacer la demanda de ocupaciones\r\nque requerían nivele educacionales específicos de alta calificación, se\r\ncanalizaron los objetivos al sector de servicios. También se tuvo en cuenta la\r\nrealidad económica y las crecientes aspiraciones&nbsp; de las personas del lugar que deseaban\r\nmejorar su nivel técnico formativo.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">Como consecuencia de la crítica situación económica de\r\nnuestra zona y alrededores cada vez fue mayor la cantidad de jóvenes egresados\r\nde escuelas secundarias que dejaban de emigrar hacia las grandes urbes en busca\r\nde educación superior volcándose a las nuevas e interesantes carreras que la\r\nregión demandaba asegurando amplios campos laborales y futuros a su egreso. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">De esta manera los estudiantes no solo no afectaban el\r\npresupuesto familiar (viajando, o manteniendo viviendas en grandes ciudades)\r\nsino que también podían contribuir a la economía familiar realizando alguna\r\nactividad.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">Este cumulo de circunstancias ayudó a definir los ejes\r\nque permitieron enfocar un nuevo tratamiento de la educación superior. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">Atento a lo expuesto, el 28 de Noviembre de 1972 el entonces\r\nMinisterio de Educación de la Provincia de Buenos Aires emitió la Resolución\r\nN°2965/72 que dispuso la creación del Instituto Superior de Formación Técnica\r\nN°38 fue el 7 de diciembre de 1972 cuando se concretó la fundación al inaugurar\r\nel edificio que ocupó hasta el año 2007.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">Este Instituto Superior se caracterizó por la\r\nflexibilidad estructural desde que en el año 1973 comenzó su actividad\r\nacadémica&nbsp; con el dictado de las\r\nLicenciaturas en Administración de Empresas y en Administración Personal.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">En 1979 se reestructura con carreras de técnicos\r\nSuperiores Análisis de Sistemas Resol 0144/78; Administración de Empresas Resol\r\n1404/78, Seguridad e Higiene Industrial Resol 03035/72 y Mantenimiento\r\nIndustrial con Orientación Mecánica Resol 472/81.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">A partir de 1982 se inicia el dictado de carreras\r\norientadas hacia la formación docente comenzando con la carrera Asistente\r\nEducacional Resol N555/82&nbsp; y se modifica\r\nel nombre del establecimiento pues pasa a denominarse Instituto Superior de\r\nFormación técnica y Docente N 38. Para&nbsp;\r\nlos docentes en actividad desde 1985 se&nbsp;\r\nimplementaron carreras con modalidad “no residentes”; Actualización\r\ndocente; Conducción de Servicios Educativos y Supervisión de Servicios\r\nEducativos resol N29/85; como así también Capacitación Docente&nbsp; Nivel I y II Resol N67/87. Con las mismas características\r\nse&nbsp;&nbsp; abrió en 1991 la carrera Bibliotecología;\r\nauxiliar escolar y profesional resol N°29/85. En 1988 Magisterio Especializado\r\nen Educación de adultos Resol N° 368/85 y en 1992 se dictó Capacitación Docente\r\nNivel III Resol N° 2643/86, orientada especialmente a los profesores de la casa\r\n(egresados universitarios) para mejorar su quehacer pedagógico.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">En 1991 se crea en la Unidad Penal N3 una extensión\r\ndestinada &nbsp;a brindar educación superior a\r\nlos internos allí alojados (resolN1613/83). Por esa razón el personal del establecimiento\r\ndiseño especialmente un Curso de Operador de PC&nbsp;\r\nResol N4008/95, que tuvo vigencia en todo el territorio provincial, con\r\nuna duración de un año y que fuera impartido con mucho éxito entre la población\r\nmasculina y femenina alojada en la referida Unidad Penal.En 1999 se discontinuó\r\nel dictado por cierre de dicha extensión.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">En 1994 se crea la extensión Ramallo Resol N14675/94,\r\niniciándose con el dictado de las carreras Técnico Superior en Administración\r\nde Empresas Resol 0724/81 y el Profesorado Especializado en jardín maternal\r\nResol&nbsp; n181/89. Posteriormente esta última\r\ncarrera fue sustituida por el referido Curso de Operador de PC Resol N 4008/95\r\nhasta el año 2001, cuando fue a su vez, sustituida por la carrera Tecnicatura\r\nSoporte Operativo de PC Resol N° 4762/96.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">A partir del 2003 se dictó en su lugar la carrera Técnico\r\nSuperior en Sistemas informatizados Resol N 5293/91 y se incorporó&nbsp; Tecnicatura Superior en Administración con\r\nOrientación en Pequeñas y Medianas Empresas Resol N° 5835/03. También en esta\r\nextensión en 2005 se abre la carrera Técnico superior en Seguridad Higiene y\r\nControl ambiental e Industrial Resol N° 931/95 y desde 2006 se comenzaron a dictar\r\nla Tecnicatura Superior en Transporte Almacenamiento y Embarque de&nbsp; Cereales y Productos alimenticios&nbsp; Resol N° 1678/06 y la Tecnicatura Superior en\r\nMantenimiento Industrial Resol N°3650/00.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">Hasta 2020 se dictaron las carreras: Tecnicatura\r\nSuperior en Enfermería Resol Nª 4259/09; Tecnicatura Superior en Tecnología en\r\nSalud con Especialidad en Instrumentación Quirúrgica Resol Nª 5141/03;\r\nTecnicatura Superior en Tecnología en Salud con Especialidad en Hemoterapia\r\nResol&nbsp; Nª1789/09; Tecnicatura Superior en\r\nAdministración de Pequeñas y Medianas Empresas Resol Nª5835/03; Tecnicatura\r\nSuperior en Administración de Recursos Humanos Resol Nª276/03<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">En diciembre de 2020 dicha extensión se independiza de\r\nnuestro instituto pasando a llamarse Instituto Superior de Formación Docente y\r\nTécnica N° 236. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">Nuestro establecimiento pretende contar con los\r\nmejores recursos técnicos pedagógicos y para llevar adelante esta propuesta\r\ncuenta con profesores de primer nivel, una tradición académica de\r\nconsideración, una creciente actividad en la capacitación de su personal y un\r\nincondicional apoyo de s Asociación Cooperadora. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">En abril de 2020 como es de público conocimiento\r\ntransitamos emergencia sanitaria por Covid 19, situación histórico social de\r\nimpacto que nos posibilitó a su vez la utilización de diversos recursos\r\ntecnológicos en todas las carreras y que en la actualidad continúan como\r\nsoporte pedagógico posibilitando interacción y dinámica permanente acorde a la\r\nsociedad actual; contando con cuatro laboratorios de informática equipados y\r\ncon red wifi en todo el edificio posibilitando la tarea&nbsp; docente y administrativa. Asimismo contamos\r\ncon una completa biblioteca que facilita la consulta y el trabajo a todas las\r\ncarreras.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">En Diciembre 2021 reacondicionamos&nbsp; e inauguramos la sala de Profesores Ing\r\nCarlos Fernández en honor de quién fuera el Director del Instituto en el\r\nperíodo del 2014 al 2020 fallecido en tiempo de pandemia. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-AR\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\";=\"\" mso-ansi-language:es-ar\"=\"\">A inicios del corriente año se incorpora una nueva\r\ncarrera a nuestra oferta académica, la Tecnicatura Superior en Laboratorio de\r\nAnálisis Clínicos, con modalidad de ciclo cerrado.<o:p></o:p></span></p>', 1, NULL, '2023-02-23 21:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `horarios`
--

CREATE TABLE `horarios` (
  `id` bigint UNSIGNED NOT NULL,
  `sede_id` bigint UNSIGNED DEFAULT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `anio_id` bigint UNSIGNED DEFAULT NULL,
  `profesor_id` bigint UNSIGNED DEFAULT NULL,
  `materia_id` bigint UNSIGNED DEFAULT NULL,
  `comision_id` bigint UNSIGNED DEFAULT NULL,
  `dia` bigint UNSIGNED DEFAULT NULL,
  `modulohorario_id` bigint UNSIGNED DEFAULT NULL,
  `comentario` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `modalidad_id` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `cuatrimestre_id` tinyint UNSIGNED DEFAULT NULL,
  `resolucion_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `horarios`
--

INSERT INTO `horarios` (`id`, `sede_id`, `carrera_id`, `anio_id`, `profesor_id`, `materia_id`, `comision_id`, `dia`, `modulohorario_id`, `comentario`, `modalidad_id`, `cuatrimestre_id`, `resolucion_id`, `created_at`, `updated_at`) VALUES
(75, 1, 1, 2, 16, 38, 1, 1, 3, NULL, 1, NULL, 11, NULL, NULL),
(76, 1, 1, 2, 16, 38, 1, 1, 4, NULL, 1, NULL, 11, NULL, NULL),
(77, 1, 1, 2, 29, 40, 1, 2, 1, NULL, 1, NULL, 11, NULL, NULL),
(78, 1, 1, 2, 29, 40, 1, 2, 2, NULL, 1, NULL, 11, NULL, NULL),
(79, 1, 1, 2, 29, 40, 1, 2, 3, NULL, 1, NULL, 11, NULL, NULL),
(80, 1, 1, 2, 14, 39, 1, 3, 1, NULL, 1, NULL, 11, NULL, NULL),
(81, 1, 1, 2, 14, 39, 1, 3, 2, NULL, 1, NULL, 11, NULL, NULL),
(82, 1, 1, 2, 14, 37, 1, 3, 3, NULL, 1, NULL, 11, NULL, NULL),
(86, 1, 1, 2, 14, 37, 1, 3, 4, NULL, 1, NULL, 11, NULL, NULL),
(90, 1, 1, 2, 195, 35, 1, 4, 1, NULL, 1, NULL, 11, NULL, '2025-03-24 12:02:48'),
(95, 1, 1, 2, 195, 35, 1, 4, 2, NULL, 1, NULL, 11, NULL, '2025-03-24 12:02:36'),
(100, 1, 1, 2, 35, 41, 1, 4, 3, NULL, 1, NULL, 11, NULL, NULL),
(102, 1, 1, 2, 35, 41, 1, 4, 4, NULL, 1, NULL, 11, NULL, NULL),
(104, 1, 1, 2, 29, 34, 1, 5, 1, NULL, 1, NULL, 11, NULL, NULL),
(105, 1, 1, 2, 29, 34, 1, 5, 2, NULL, 1, NULL, 11, NULL, NULL),
(106, 1, 1, 2, 29, 34, 1, 5, 3, NULL, 1, NULL, 11, NULL, NULL),
(107, 1, 1, 3, 29, 47, 1, 1, 1, NULL, 1, NULL, 11, NULL, NULL),
(111, 1, 1, 3, 29, 47, 1, 1, 2, NULL, 1, NULL, 11, NULL, NULL),
(115, 1, 1, 3, 29, 45, 1, 1, 3, NULL, 1, NULL, 11, NULL, NULL),
(116, 1, 1, 3, 29, 45, 1, 1, 4, NULL, 1, NULL, 11, NULL, NULL),
(117, 1, 1, 3, 14, 43, 1, 2, 1, NULL, 1, NULL, 11, NULL, NULL),
(118, 1, 1, 3, 14, 43, 1, 2, 2, NULL, 1, NULL, 11, NULL, NULL),
(119, 1, 1, 3, 14, 43, 1, 2, 3, NULL, 1, NULL, 11, NULL, NULL),
(120, 1, 1, 3, 14, 43, 1, 2, 4, NULL, 1, NULL, 11, NULL, NULL),
(121, 1, 1, 3, 13, 42, 1, 3, 1, NULL, 1, NULL, 11, NULL, NULL),
(123, 1, 1, 3, 13, 42, 1, 3, 2, NULL, 1, NULL, 11, NULL, NULL),
(125, 1, 1, 3, 29, 47, 1, 3, 3, NULL, 1, NULL, 11, NULL, NULL),
(129, 1, 1, 3, 29, 47, 1, 3, 4, NULL, 1, NULL, 11, NULL, NULL),
(133, 1, 1, 3, 29, 45, 1, 4, 3, NULL, 1, NULL, 11, NULL, NULL),
(134, 1, 1, 3, 29, 45, 1, 4, 4, NULL, 1, NULL, 11, NULL, NULL),
(139, 1, 3, 1, 52, 55, 1, 3, 1, NULL, 1, NULL, 6, NULL, NULL),
(141, 1, 3, 1, 52, 55, 1, 3, 2, NULL, 1, NULL, 6, NULL, NULL),
(143, 1, 3, 1, 55, 56, 1, 3, 3, NULL, 1, NULL, 6, NULL, NULL),
(145, 1, 3, 1, 55, 56, 1, 3, 4, NULL, 1, NULL, 6, NULL, NULL),
(152, 1, 3, 1, 55, 51, 1, 5, 1, NULL, 1, NULL, 6, NULL, NULL),
(153, 1, 3, 1, 55, 51, 1, 5, 2, NULL, 1, NULL, 6, NULL, NULL),
(154, 1, 3, 1, 82, 48, 1, 5, 3, NULL, 1, NULL, 6, NULL, NULL),
(157, 1, 3, 1, 82, 48, 1, 5, 4, NULL, 1, NULL, 6, NULL, NULL),
(160, 1, 3, 2, 55, 67, 1, 1, 1, NULL, 1, NULL, 6, NULL, NULL),
(161, 1, 3, 2, 55, 67, 1, 1, 2, NULL, 1, NULL, 6, NULL, NULL),
(168, 1, 3, 2, 56, 61, 1, 2, 1, NULL, 1, NULL, 6, NULL, '2023-03-11 07:31:02'),
(169, 1, 3, 2, 56, 61, 1, 2, 2, NULL, 1, NULL, 6, NULL, '2023-03-11 07:31:15'),
(170, 1, 3, 2, 74, 66, 1, 3, 2, NULL, 1, NULL, 6, NULL, '2025-03-30 11:29:46'),
(171, 1, 3, 2, 74, 66, 1, 3, 1, NULL, 1, NULL, 6, NULL, '2025-03-30 11:27:51'),
(172, 1, 3, 2, 20, 68, 1, 4, 3, NULL, 1, NULL, 6, NULL, NULL),
(174, 1, 3, 2, 20, 68, 1, 4, 4, NULL, 1, NULL, 6, NULL, NULL),
(176, 1, 3, 3, 82, 77, 1, 1, 1, NULL, 1, NULL, 7, NULL, NULL),
(177, 1, 3, 3, 82, 77, 1, 1, 2, NULL, 1, NULL, 7, NULL, NULL),
(178, 1, 3, 3, 42, 74, 1, 2, 1, NULL, 1, NULL, 7, NULL, NULL),
(180, 1, 3, 3, 42, 74, 1, 2, 2, NULL, 1, NULL, 7, NULL, NULL),
(182, 1, 3, 3, 177, 73, 1, 2, 3, NULL, 1, NULL, 7, NULL, '2025-03-30 11:31:28'),
(183, 1, 3, 3, 177, 73, 1, 2, 4, NULL, 1, NULL, 7, NULL, '2025-03-30 11:31:33'),
(184, 1, 3, 3, 55, 72, 1, 3, 1, NULL, 1, NULL, 7, NULL, NULL),
(186, 1, 3, 3, 55, 72, 1, 3, 2, NULL, 1, NULL, 7, NULL, NULL),
(188, 1, 3, 3, 84, 69, 1, 3, 3, NULL, 1, NULL, 7, NULL, NULL),
(189, 1, 3, 3, 84, 69, 1, 3, 4, NULL, 1, NULL, 7, NULL, NULL),
(190, 1, 3, 3, 55, 76, 1, 4, 1, NULL, 1, NULL, 7, NULL, NULL),
(191, 1, 3, 3, 55, 76, 1, 4, 2, NULL, 1, NULL, 7, NULL, NULL),
(192, 1, 3, 3, 55, 70, 1, 4, 3, NULL, 1, NULL, 7, NULL, NULL),
(195, 1, 3, 3, 55, 70, 1, 4, 4, NULL, 1, NULL, 7, NULL, NULL),
(198, 1, 3, 3, 82, 78, 1, 5, 1, NULL, 1, NULL, 7, NULL, NULL),
(199, 1, 3, 3, 82, 78, 1, 5, 2, NULL, 1, NULL, 7, NULL, NULL),
(204, 1, 4, 1, 18, 87, 1, 1, 3, NULL, 1, NULL, 8, NULL, NULL),
(205, 1, 4, 1, 18, 87, 1, 1, 4, NULL, 1, NULL, 8, NULL, NULL),
(206, 1, 4, 1, 55, 85, 1, 2, 1, NULL, 1, NULL, 8, NULL, '2024-04-13 15:21:44'),
(208, 1, 4, 1, 55, 85, 1, 2, 2, NULL, 1, NULL, 8, NULL, '2024-04-13 15:21:33'),
(210, 1, 4, 1, 55, 85, 1, 2, 3, NULL, 1, NULL, 8, NULL, '2024-04-13 15:21:17'),
(224, 1, 4, 1, 37, 86, 1, 5, 3, NULL, 1, NULL, 8, NULL, '2023-03-11 07:45:57'),
(226, 1, 4, 1, 37, 86, 1, 5, 4, NULL, 1, NULL, 8, NULL, '2023-03-11 07:46:14'),
(228, 1, 4, 1, 66, 79, 1, 5, 1, NULL, 1, NULL, 8, NULL, NULL),
(231, 1, 4, 1, 66, 79, 1, 5, 2, NULL, 1, NULL, 8, NULL, NULL),
(234, 1, 4, 2, 194, 98, 1, 1, 3, NULL, 1, NULL, 9, NULL, '2025-03-30 11:45:28'),
(236, 1, 4, 2, 194, 98, 1, 1, 4, NULL, 1, NULL, 9, NULL, '2025-03-30 11:45:36'),
(238, 1, 4, 2, 12, 90, 1, 2, 1, NULL, 1, NULL, 9, NULL, NULL),
(239, 1, 4, 2, 12, 90, 1, 2, 2, NULL, 1, NULL, 9, NULL, NULL),
(240, 1, 4, 2, 12, 89, 1, 2, 3, NULL, 1, NULL, 9, NULL, NULL),
(241, 1, 4, 2, 44, 96, 1, 4, 1, NULL, 1, NULL, 9, NULL, NULL),
(245, 1, 4, 2, 44, 96, 1, 4, 2, NULL, 1, NULL, 9, NULL, NULL),
(249, 1, 4, 2, 44, 92, 1, 4, 3, NULL, 1, NULL, 9, NULL, '2023-02-24 23:03:12'),
(252, 1, 4, 2, 44, 92, 1, 4, 4, NULL, 1, NULL, 9, NULL, '2023-02-24 23:03:23'),
(255, 1, 4, 2, 69, 93, 1, 5, 1, NULL, 1, NULL, 9, NULL, '2023-02-24 23:03:03'),
(257, 1, 4, 2, 69, 95, 1, 5, 2, NULL, 1, NULL, 9, NULL, '2025-03-30 11:47:20'),
(262, 1, 4, 3, 73, 103, 1, 1, 1, NULL, 1, NULL, 9, NULL, '2023-02-24 23:04:00'),
(265, 1, 4, 3, 73, 103, 1, 1, 2, NULL, 1, NULL, 9, NULL, NULL),
(266, 1, 4, 3, 73, 103, 1, 1, 3, NULL, 1, NULL, 9, NULL, '2023-02-24 23:04:36'),
(268, 1, 4, 3, 73, 103, 1, 1, 4, NULL, 1, NULL, 9, NULL, '2023-02-24 23:04:52'),
(270, 1, 4, 3, 59, 100, 1, 2, 1, NULL, 1, NULL, 9, NULL, '2023-02-24 23:04:08'),
(273, 1, 4, 3, 59, 100, 1, 2, 2, NULL, 1, NULL, 9, NULL, '2023-02-24 23:04:24'),
(276, 1, 4, 3, 59, 100, 1, 2, 3, NULL, 1, NULL, 9, NULL, '2023-02-24 23:04:43'),
(280, 1, 4, 3, 73, 105, 1, 3, 2, NULL, 1, NULL, 9, NULL, NULL),
(281, 1, 4, 3, 80, 106, 1, 4, 1, NULL, 1, NULL, 9, NULL, NULL),
(282, 1, 4, 3, 80, 106, 1, 4, 2, NULL, 1, NULL, 9, NULL, NULL),
(283, 1, 4, 3, 59, 101, 1, 4, 3, NULL, 1, NULL, 9, NULL, NULL),
(284, 1, 4, 3, 59, 101, 1, 4, 4, NULL, 1, NULL, 9, NULL, NULL),
(285, 1, 4, 3, 44, 107, 1, 5, 1, NULL, 1, NULL, 9, NULL, NULL),
(286, 1, 4, 3, 44, 107, 1, 5, 2, NULL, 1, NULL, 9, NULL, NULL),
(287, 1, 4, 3, 66, 104, 1, 5, 3, NULL, 1, NULL, 9, NULL, NULL),
(288, 1, 5, 1, 10, 110, 1, 5, 4, NULL, 1, NULL, 2, NULL, '2023-04-06 15:42:21'),
(291, 1, 5, 1, 9, 112, 1, 2, 1, NULL, 1, NULL, 2, NULL, NULL),
(292, 1, 5, 1, 9, 112, 1, 2, 2, NULL, 1, NULL, 2, NULL, NULL),
(293, 1, 5, 1, 17, 109, 1, 3, 1, NULL, 1, NULL, 2, NULL, NULL),
(294, 1, 5, 1, 17, 109, 1, 3, 2, NULL, 1, NULL, 2, NULL, NULL),
(295, 1, 5, 1, 5, 114, 1, 3, 3, NULL, 1, NULL, 2, NULL, '2023-03-11 07:19:11'),
(296, 1, 5, 1, 5, 114, 1, 3, 4, NULL, 1, NULL, 2, NULL, '2023-03-11 07:19:21'),
(297, 1, 5, 1, 12, 116, 1, 4, 1, NULL, 1, NULL, 2, NULL, NULL),
(298, 1, 5, 1, 12, 116, 1, 4, 2, NULL, 1, NULL, 2, NULL, NULL),
(299, 1, 5, 1, 6, 113, 1, 4, 3, NULL, 1, NULL, 2, NULL, NULL),
(300, 1, 5, 1, 6, 113, 1, 4, 4, NULL, 1, NULL, 2, NULL, NULL),
(310, 1, 5, 2, 177, 119, 1, 5, 1, NULL, 1, NULL, 2, NULL, '2025-03-24 11:49:17'),
(313, 1, 5, 2, 4, 124, 1, 1, 2, NULL, 1, NULL, 2, NULL, NULL),
(315, 1, 5, 2, 4, 124, 1, 1, 3, NULL, 1, NULL, 2, NULL, NULL),
(317, 1, 5, 2, 4, 124, 1, 1, 4, NULL, 1, NULL, 2, NULL, NULL),
(319, 1, 5, 2, 8, 123, 1, 3, 1, NULL, 1, NULL, 2, NULL, NULL),
(320, 1, 5, 2, 8, 117, 1, 3, 2, NULL, 1, NULL, 2, NULL, NULL),
(321, 1, 5, 2, 8, 117, 1, 3, 3, NULL, 1, NULL, 2, NULL, NULL),
(322, 1, 5, 2, 8, 117, 1, 3, 4, NULL, 1, NULL, 2, NULL, NULL),
(323, 1, 5, 2, 4, 121, 1, 4, 1, NULL, 1, NULL, 2, NULL, NULL),
(324, 1, 5, 2, 4, 121, 1, 4, 2, NULL, 1, NULL, 2, NULL, NULL),
(325, 1, 5, 2, 4, 121, 1, 4, 3, NULL, 1, NULL, 2, NULL, NULL),
(326, 1, 5, 2, 16, 122, 1, 1, 1, NULL, 1, NULL, 2, NULL, '2025-03-24 11:50:23'),
(330, 1, 5, 3, 177, 128, 1, 1, 2, NULL, 1, NULL, 2, NULL, '2025-03-24 11:51:40'),
(331, 1, 5, 3, 13, 126, 1, 2, 1, NULL, 1, NULL, 2, NULL, NULL),
(332, 1, 5, 3, 13, 126, 1, 2, 2, NULL, 1, NULL, 2, NULL, NULL),
(333, 1, 5, 3, 197, 131, 1, 2, 3, NULL, 1, NULL, 2, NULL, '2025-03-24 11:52:59'),
(334, 1, 5, 3, 197, 131, 1, 2, 4, NULL, 1, NULL, 2, NULL, '2025-03-24 11:53:14'),
(335, 1, 5, 3, 177, 132, 1, 3, 1, NULL, 1, NULL, 2, NULL, '2025-03-24 11:53:30'),
(338, 1, 5, 3, 177, 132, 1, 3, 2, NULL, 1, NULL, 2, NULL, '2025-03-24 11:53:36'),
(339, 1, 5, 3, 30, 129, 1, 3, 4, NULL, 1, NULL, 2, NULL, NULL),
(340, 1, 5, 3, 177, 128, 1, 4, 1, NULL, 1, NULL, 2, NULL, '2025-03-24 11:53:46'),
(341, 1, 5, 3, 177, 128, 1, 4, 2, NULL, 1, NULL, 2, NULL, '2025-03-24 11:53:54'),
(342, 1, 5, 3, 30, 129, 1, 4, 3, NULL, 1, NULL, 2, NULL, NULL),
(343, 1, 5, 3, 30, 129, 1, 4, 4, NULL, 1, NULL, 2, NULL, NULL),
(344, 1, 5, 3, 197, 131, 1, 5, 3, NULL, 1, NULL, 2, NULL, '2025-03-24 11:54:15'),
(345, 1, 5, 3, 197, 131, 1, 5, 4, NULL, 1, NULL, 2, NULL, '2025-03-24 11:54:07'),
(346, 1, 6, 1, 40, 136, 1, 1, 1, NULL, 1, NULL, 3, NULL, NULL),
(347, 1, 6, 1, 12, 141, 2, 1, 1, NULL, 1, NULL, 3, NULL, NULL),
(348, 1, 6, 1, 40, 136, 1, 1, 2, NULL, 1, NULL, 3, NULL, NULL),
(349, 1, 6, 1, 12, 141, 2, 1, 2, NULL, 1, NULL, 3, NULL, NULL),
(350, 1, 6, 1, 17, 137, 1, 1, 3, NULL, 1, NULL, 3, NULL, NULL),
(351, 1, 6, 1, 12, 139, 2, 1, 3, NULL, 1, NULL, 3, NULL, NULL),
(353, 1, 6, 1, 17, 137, 1, 1, 4, NULL, 1, NULL, 3, NULL, NULL),
(354, 1, 6, 1, 12, 139, 2, 1, 4, NULL, 1, NULL, 3, NULL, NULL),
(357, 1, 6, 1, 62, 133, 2, 2, 1, NULL, 1, NULL, 3, NULL, NULL),
(358, 1, 6, 1, 18, 135, 1, 2, 3, NULL, 1, NULL, 3, NULL, '2025-03-24 11:55:58'),
(360, 1, 6, 1, 62, 133, 2, 2, 2, NULL, 1, NULL, 3, NULL, NULL),
(361, 1, 6, 1, 18, 135, 1, 2, 4, NULL, 1, NULL, 3, NULL, '2025-03-24 11:56:06'),
(362, 1, 6, 1, 50, 134, 1, 2, 1, NULL, 1, NULL, 3, NULL, '2025-03-24 11:55:20'),
(363, 1, 6, 1, 62, 142, 2, 4, 3, NULL, 1, NULL, 3, NULL, '2025-03-24 11:59:57'),
(365, 1, 6, 1, 50, 134, 1, 2, 2, NULL, 1, NULL, 3, NULL, '2025-03-24 11:55:28'),
(366, 1, 6, 1, 62, 142, 2, 4, 4, NULL, 1, NULL, 3, NULL, '2025-03-24 12:00:08'),
(368, 1, 6, 1, 72, 133, 1, 3, 1, NULL, 1, NULL, 3, NULL, NULL),
(369, 1, 6, 1, 26, 136, 2, 3, 1, NULL, 1, NULL, 3, NULL, NULL),
(370, 1, 6, 1, 72, 133, 1, 3, 2, NULL, 1, NULL, 3, NULL, NULL),
(371, 1, 6, 1, 26, 136, 2, 3, 2, NULL, 1, NULL, 3, NULL, NULL),
(373, 1, 6, 1, 18, 135, 2, 3, 3, NULL, 1, NULL, 3, NULL, NULL),
(374, 1, 6, 1, 72, 142, 1, 3, 3, NULL, 1, NULL, 3, NULL, NULL),
(377, 1, 6, 1, 18, 135, 2, 3, 4, NULL, 1, NULL, 3, NULL, NULL),
(378, 1, 6, 1, 72, 142, 1, 3, 4, NULL, 1, NULL, 3, NULL, NULL),
(380, 1, 6, 1, 169, 137, 2, 4, 1, NULL, 1, NULL, 3, NULL, '2023-02-24 15:48:39'),
(381, 1, 6, 1, 169, 137, 2, 4, 2, NULL, 1, NULL, 3, NULL, '2023-02-24 15:48:47'),
(382, 1, 6, 1, 168, 138, 2, 5, 1, NULL, 1, NULL, 3, NULL, '2024-04-13 15:06:03'),
(383, 1, 6, 1, 168, 138, 2, 5, 2, NULL, 1, NULL, 3, NULL, '2024-04-13 15:06:24'),
(384, 1, 6, 1, 58, 134, 2, 5, 3, NULL, 1, NULL, 3, NULL, '2024-04-13 15:06:12'),
(385, 1, 6, 1, 12, 139, 1, 5, 1, NULL, 1, NULL, 3, NULL, NULL),
(387, 1, 6, 1, 58, 134, 2, 5, 4, NULL, 1, NULL, 3, NULL, '2024-04-13 15:06:42'),
(388, 1, 6, 1, 12, 139, 1, 5, 2, NULL, 1, NULL, 3, NULL, NULL),
(394, 1, 6, 2, 56, 152, 1, 1, 1, NULL, 1, NULL, 3, NULL, NULL),
(399, 1, 6, 2, 56, 152, 1, 1, 2, NULL, 1, NULL, 3, NULL, NULL),
(404, 1, 6, 2, 169, 149, 1, 1, 3, NULL, 1, NULL, 3, NULL, '2025-03-24 11:57:17'),
(405, 1, 6, 2, 56, 152, 2, 1, 3, NULL, 1, NULL, 3, NULL, '2023-03-11 13:03:25'),
(410, 1, 6, 2, 169, 149, 1, 1, 4, NULL, 1, NULL, 3, NULL, '2025-03-24 11:57:25'),
(411, 1, 6, 2, 56, 152, 2, 1, 4, NULL, 1, NULL, 3, NULL, '2023-03-11 13:03:41'),
(412, 1, 6, 2, 188, 144, 1, 2, 1, NULL, 1, NULL, 3, NULL, '2023-06-09 11:28:50'),
(413, 1, 6, 2, 17, 144, 2, 2, 1, NULL, 1, NULL, 3, NULL, NULL),
(414, 1, 6, 2, 188, 144, 1, 2, 2, NULL, 1, NULL, 3, NULL, '2023-06-09 11:29:16'),
(415, 1, 6, 2, 17, 144, 2, 2, 2, NULL, 1, NULL, 3, NULL, NULL),
(417, 1, 6, 2, 68, 147, 1, 2, 3, NULL, 1, NULL, 3, NULL, NULL),
(419, 1, 6, 2, 68, 147, 1, 2, 4, NULL, 1, NULL, 3, NULL, NULL),
(420, 1, 6, 2, 62, 145, 1, 3, 2, NULL, 1, NULL, 3, NULL, NULL),
(421, 1, 6, 2, 62, 145, 1, 3, 3, NULL, 1, NULL, 3, NULL, NULL),
(422, 1, 6, 2, 26, 146, 2, 3, 3, NULL, 1, NULL, 3, NULL, NULL),
(423, 1, 6, 2, 62, 145, 1, 3, 1, NULL, 1, NULL, 3, NULL, '2025-03-24 11:57:44'),
(424, 1, 6, 2, 26, 146, 2, 3, 4, NULL, 1, NULL, 3, NULL, NULL),
(425, 1, 6, 2, 72, 143, 2, 4, 1, NULL, 1, NULL, 3, NULL, NULL),
(426, 1, 6, 2, 65, 150, 1, 4, 1, NULL, 1, NULL, 3, NULL, NULL),
(427, 1, 6, 2, 72, 143, 2, 4, 2, NULL, 1, NULL, 3, NULL, NULL),
(428, 1, 6, 2, 65, 150, 1, 4, 2, NULL, 1, NULL, 3, NULL, NULL),
(429, 1, 6, 2, 72, 143, 2, 4, 3, NULL, 1, NULL, 3, NULL, NULL),
(430, 1, 6, 2, 40, 146, 1, 4, 3, NULL, 1, NULL, 3, NULL, NULL),
(431, 1, 6, 2, 72, 145, 2, 4, 4, NULL, 1, NULL, 3, NULL, NULL),
(432, 1, 6, 2, 40, 146, 1, 4, 4, NULL, 1, NULL, 3, NULL, NULL),
(433, 1, 6, 2, 65, 143, 1, 5, 1, NULL, 1, NULL, 3, NULL, NULL),
(434, 1, 6, 2, 72, 145, 2, 5, 1, NULL, 1, NULL, 3, NULL, NULL),
(435, 1, 6, 2, 65, 143, 1, 5, 2, NULL, 1, NULL, 3, NULL, NULL),
(436, 1, 6, 2, 72, 145, 2, 5, 2, NULL, 1, NULL, 3, NULL, NULL),
(437, 1, 6, 2, 16, 149, 2, 5, 3, NULL, 1, NULL, 3, NULL, NULL),
(438, 1, 6, 2, 16, 149, 2, 5, 4, NULL, 1, NULL, 3, NULL, NULL),
(439, 1, 6, 3, 72, 154, 2, 1, 1, NULL, 1, NULL, 3, NULL, NULL),
(441, 1, 6, 3, 72, 154, 2, 1, 2, NULL, 1, NULL, 3, NULL, NULL),
(443, 1, 6, 3, 72, 154, 2, 1, 3, NULL, 1, NULL, 3, NULL, NULL),
(445, 1, 6, 3, 72, 154, 2, 1, 4, NULL, 1, NULL, 3, NULL, NULL),
(447, 1, 6, 3, 72, 154, 2, 2, 1, NULL, 1, NULL, 3, NULL, NULL),
(449, 1, 6, 3, 46, 153, 2, 3, 1, NULL, 1, NULL, 3, NULL, NULL),
(450, 1, 6, 3, 46, 153, 2, 3, 2, NULL, 1, NULL, 3, NULL, NULL),
(451, 1, 6, 3, 46, 153, 2, 3, 3, NULL, 1, NULL, 3, NULL, NULL),
(452, 1, 6, 3, 46, 153, 2, 3, 4, NULL, 1, NULL, 3, NULL, NULL),
(453, 1, 6, 3, 18, 160, 2, 5, 3, NULL, 1, NULL, 3, NULL, '2025-03-24 11:59:11'),
(454, 1, 6, 3, 18, 160, 2, 5, 4, NULL, 1, NULL, 3, NULL, '2025-03-24 11:59:20'),
(455, 1, 6, 3, 41, 161, 2, 4, 3, NULL, 1, NULL, 3, NULL, NULL),
(456, 1, 6, 3, 41, 161, 2, 4, 4, NULL, 1, NULL, 3, NULL, NULL),
(457, 1, 6, 3, 30, 159, 2, 5, 1, NULL, 1, NULL, 3, NULL, NULL),
(458, 1, 6, 3, 30, 159, 2, 5, 2, NULL, 1, NULL, 3, NULL, NULL),
(459, 1, 6, 3, 30, 159, 2, 5, 5, NULL, 1, NULL, 3, NULL, '2025-03-24 11:58:49'),
(473, 1, 8, 1, 5, 189, 1, 1, 1, NULL, 1, NULL, 4, NULL, NULL),
(474, 1, 8, 1, 5, 185, 1, 1, 2, NULL, 1, NULL, 4, NULL, NULL),
(475, 1, 8, 1, 5, 185, 1, 1, 3, NULL, 1, NULL, 4, NULL, NULL),
(476, 1, 8, 1, 5, 185, 1, 1, 4, NULL, 1, NULL, 4, NULL, NULL),
(480, 1, 8, 1, 68, 187, 1, 2, 1, NULL, 1, NULL, 4, NULL, NULL),
(484, 1, 8, 1, 68, 187, 1, 2, 2, NULL, 1, NULL, 4, NULL, NULL),
(485, 1, 8, 1, 37, 192, 1, 2, 3, NULL, 1, NULL, 4, NULL, '2023-03-18 05:54:10'),
(486, 1, 8, 1, 37, 192, 1, 2, 4, NULL, 1, NULL, 4, NULL, '2023-03-18 05:54:21'),
(487, 1, 8, 1, 9, 186, 1, 3, 3, NULL, 1, NULL, 4, NULL, NULL),
(488, 1, 8, 1, 9, 186, 1, 3, 4, NULL, 1, NULL, 4, NULL, NULL),
(489, 1, 8, 1, 41, 184, 1, 4, 1, NULL, 1, NULL, 4, NULL, NULL),
(490, 1, 8, 1, 41, 184, 1, 4, 2, NULL, 1, NULL, 4, NULL, NULL),
(491, 1, 8, 1, 65, 193, 1, 5, 3, NULL, 1, NULL, 4, NULL, NULL),
(492, 1, 8, 1, 188, 190, 1, 5, 2, NULL, 1, NULL, 4, NULL, '2024-04-13 15:10:23'),
(494, 1, 8, 2, 69, 201, 1, 1, 1, NULL, 1, NULL, 4, NULL, NULL),
(496, 1, 8, 2, 69, 201, 1, 1, 2, NULL, 1, NULL, 4, NULL, NULL),
(497, 1, 8, 2, 85, 196, 1, 2, 3, NULL, 1, NULL, 4, NULL, NULL),
(498, 1, 8, 2, 85, 196, 1, 2, 4, NULL, 1, NULL, 4, NULL, NULL),
(500, 1, 8, 2, 195, 198, 1, 3, 1, NULL, 1, NULL, 4, NULL, '2025-03-24 12:04:29'),
(502, 1, 8, 2, 195, 198, 1, 3, 2, NULL, 1, NULL, 4, NULL, '2025-03-24 12:04:38'),
(503, 1, 8, 2, 45, 197, 1, 3, 3, NULL, 1, NULL, 4, NULL, NULL),
(504, 1, 8, 2, 45, 197, 1, 3, 4, NULL, 1, NULL, 4, NULL, NULL),
(505, 1, 8, 2, 164, 200, 1, 4, 1, NULL, 1, NULL, 4, NULL, NULL),
(506, 1, 8, 2, 164, 200, 1, 4, 2, NULL, 1, NULL, 4, NULL, NULL),
(507, 1, 8, 2, 45, 197, 1, 4, 3, NULL, 1, NULL, 4, NULL, NULL),
(508, 1, 8, 2, 45, 197, 1, 4, 4, NULL, 1, NULL, 4, NULL, NULL),
(509, 1, 8, 2, 198, 199, 1, 5, 1, NULL, 1, NULL, 4, NULL, '2025-03-24 12:05:31'),
(510, 1, 8, 2, 198, 199, 1, 5, 2, NULL, 1, NULL, 4, NULL, '2025-03-24 12:05:40'),
(511, 1, 8, 2, 198, 199, 1, 5, 3, NULL, 1, NULL, 4, NULL, '2025-03-24 12:05:50'),
(512, 1, 8, 2, 164, 200, 1, 5, 4, NULL, 1, NULL, 4, NULL, NULL),
(513, 1, 8, 3, 45, 209, 1, 1, 2, NULL, 1, NULL, 4, NULL, NULL),
(514, 1, 8, 3, 44, 208, 1, 5, 3, NULL, 1, NULL, 4, NULL, '2024-04-13 15:13:03'),
(515, 1, 8, 3, 85, 211, 1, 2, 1, NULL, 1, NULL, 4, NULL, NULL),
(516, 1, 8, 3, 85, 211, 1, 2, 2, NULL, 1, NULL, 4, NULL, NULL),
(517, 1, 8, 3, 45, 203, 1, 2, 3, NULL, 1, NULL, 4, NULL, '2025-03-24 12:06:34'),
(518, 1, 8, 3, 45, 203, 1, 2, 4, NULL, 1, NULL, 4, NULL, '2025-03-24 12:06:46'),
(519, 1, 8, 3, 45, 203, 1, 3, 1, NULL, 1, NULL, 4, NULL, '2025-03-24 12:06:56'),
(520, 1, 8, 3, 45, 203, 1, 3, 2, NULL, 1, NULL, 4, NULL, '2025-03-24 12:07:08'),
(521, 1, 8, 3, 85, 206, 1, 3, 3, NULL, 1, NULL, 4, NULL, NULL),
(522, 1, 8, 3, 85, 207, 1, 3, 4, NULL, 1, NULL, 4, NULL, NULL),
(523, 1, 8, 3, 16, 205, 1, 5, 1, NULL, 1, NULL, 4, NULL, NULL),
(524, 1, 8, 3, 45, 204, 1, 1, 1, NULL, 1, NULL, 4, NULL, '2023-06-09 11:42:45'),
(525, 1, 8, 3, 5, 210, 1, 5, 2, NULL, 1, NULL, 4, NULL, '2023-06-09 11:44:06'),
(526, 1, 2, 1, 77, 3, 1, 1, 1, NULL, 1, NULL, 1, NULL, NULL),
(527, 1, 2, 1, 77, 3, 1, 1, 2, NULL, 1, NULL, 1, NULL, NULL),
(528, 1, 2, 1, 146, 6, 1, 1, 3, NULL, 1, NULL, 1, NULL, NULL),
(529, 1, 2, 1, 146, 6, 1, 1, 4, NULL, 1, NULL, 1, NULL, NULL),
(530, 1, 2, 1, 164, 4, 1, 2, 1, NULL, 1, NULL, 1, NULL, '2025-07-18 01:16:32'),
(531, 1, 2, 1, 164, 4, 1, 2, 2, NULL, 1, NULL, 1, NULL, NULL),
(532, 1, 2, 1, 9, 212, 1, 2, 3, NULL, 1, NULL, 1, NULL, NULL),
(533, 1, 2, 1, 9, 212, 1, 2, 4, NULL, 1, NULL, 1, NULL, NULL),
(534, 1, 2, 1, 15, 8, 1, 3, 1, NULL, 1, NULL, 1, NULL, NULL),
(535, 1, 2, 1, 15, 8, 1, 3, 2, NULL, 1, NULL, 1, NULL, NULL),
(536, 1, 2, 1, 164, 4, 1, 3, 3, NULL, 1, NULL, 1, NULL, NULL),
(537, 1, 2, 1, 164, 4, 1, 3, 4, NULL, 1, NULL, 1, NULL, NULL),
(538, 1, 2, 1, 91, 7, 1, 5, 1, NULL, 1, NULL, 1, NULL, '2024-04-13 15:54:48'),
(539, 1, 2, 1, 91, 7, 1, 5, 2, NULL, 1, NULL, 1, NULL, '2024-04-13 15:54:57'),
(540, 1, 2, 2, 164, 9, 1, 1, 1, NULL, 1, NULL, 1, NULL, '2025-08-22 02:44:14'),
(541, 1, 2, 2, 164, 9, 1, 1, 2, NULL, 1, NULL, 1, NULL, NULL),
(542, 1, 2, 2, 196, 14, 1, 2, 3, NULL, 1, NULL, 1, NULL, '2025-03-24 11:45:01'),
(547, 1, 2, 2, 196, 14, 1, 2, 4, NULL, 1, NULL, 1, NULL, '2025-03-24 11:45:14'),
(552, 1, 8, 1, 188, 190, 1, 5, 1, NULL, 1, NULL, 4, '2023-02-24 15:30:00', '2024-04-13 15:09:23'),
(553, 1, 8, 1, 188, 190, 1, 5, 5, NULL, 1, NULL, 4, '2023-02-24 15:30:12', '2024-04-13 15:09:07'),
(554, 1, 8, 1, 169, 188, 1, 4, 3, NULL, 1, NULL, 4, '2023-02-24 15:30:28', '2023-06-09 11:41:20'),
(555, 1, 8, 1, 166, 191, 1, 4, 4, NULL, 1, NULL, 4, '2023-02-24 15:31:13', '2023-02-24 15:31:13'),
(557, 1, 8, 2, 166, 195, 1, 1, 3, NULL, 1, NULL, 4, '2023-02-24 15:32:07', '2023-02-24 15:32:07'),
(558, 1, 8, 2, 166, 195, 1, 1, 4, NULL, 1, NULL, 4, '2023-02-24 15:32:20', '2023-02-24 15:32:20'),
(559, 1, 8, 2, 166, 195, 1, 2, 1, NULL, 1, NULL, 4, '2023-02-24 15:32:35', '2023-02-24 15:32:35'),
(560, 1, 8, 2, 166, 195, 1, 2, 2, NULL, 1, NULL, 4, '2023-02-24 15:32:55', '2023-02-24 15:32:55'),
(563, 1, 8, 3, 45, 203, 1, 3, 5, NULL, 1, NULL, 4, '2023-02-24 15:34:41', '2025-03-24 12:07:50'),
(564, 1, 6, 1, 72, 133, 1, 3, 5, NULL, 1, NULL, 3, '2023-02-24 15:45:18', '2023-02-24 15:45:18'),
(565, 1, 6, 1, 167, 141, 1, 4, 5, NULL, 1, NULL, 3, '2023-02-24 15:46:33', '2023-02-24 15:46:33'),
(566, 1, 6, 1, 167, 141, 1, 4, 1, NULL, 1, NULL, 3, '2023-02-24 15:46:43', '2023-02-24 15:46:43'),
(567, 1, 6, 1, 167, 141, 1, 4, 2, NULL, 1, NULL, 3, '2023-02-24 15:46:56', '2023-02-24 15:46:56'),
(568, 1, 6, 1, 168, 138, 1, 5, 3, NULL, 1, NULL, 3, '2023-02-24 15:47:13', '2024-04-13 15:03:06'),
(569, 1, 6, 1, 168, 138, 1, 5, 4, NULL, 1, NULL, 3, '2023-02-24 15:47:24', '2024-04-13 15:03:15'),
(570, 1, 6, 2, 65, 143, 1, 5, 5, NULL, 1, NULL, 3, '2023-02-24 15:49:33', '2023-02-24 15:49:33'),
(571, 1, 6, 2, 170, 148, 1, 5, 3, NULL, 1, NULL, 3, '2023-02-24 15:50:09', '2023-02-24 15:50:09'),
(572, 1, 6, 2, 170, 148, 1, 5, 4, NULL, 1, NULL, 3, '2023-02-24 15:50:20', '2023-02-24 15:50:20'),
(573, 1, 6, 2, 171, 150, 2, 1, 1, NULL, 1, NULL, 3, '2023-02-24 15:51:18', '2023-02-24 15:51:18'),
(574, 1, 6, 2, 171, 150, 2, 1, 2, NULL, 1, NULL, 3, '2023-02-24 15:51:28', '2023-02-24 15:51:28'),
(575, 1, 6, 2, 28, 147, 2, 2, 3, NULL, 1, NULL, 3, '2023-02-24 15:51:45', '2023-02-24 15:51:45'),
(576, 1, 6, 2, 28, 147, 2, 2, 4, NULL, 1, NULL, 3, '2023-02-24 15:51:55', '2023-02-24 15:51:55'),
(577, 1, 6, 2, 170, 148, 2, 3, 1, NULL, 1, NULL, 3, '2023-02-24 15:52:13', '2023-02-24 15:52:13'),
(578, 1, 6, 2, 170, 148, 2, 3, 2, NULL, 1, NULL, 3, '2023-02-24 15:52:22', '2023-02-24 15:52:22'),
(579, 1, 6, 3, 72, 154, 2, 2, 5, NULL, 1, NULL, 3, '2023-02-24 15:53:01', '2023-02-24 15:53:01'),
(581, 1, 6, 3, 46, 157, 2, 2, 2, NULL, 1, NULL, 3, '2023-02-24 15:54:49', '2023-02-24 15:54:49'),
(582, 1, 6, 3, 46, 157, 2, 2, 3, NULL, 1, NULL, 3, '2023-02-24 15:54:58', '2023-02-24 15:54:58'),
(583, 1, 6, 3, 46, 157, 2, 2, 4, NULL, 1, NULL, 3, '2023-02-24 15:55:16', '2023-02-24 15:55:16'),
(584, 1, 4, 1, 28, 81, 1, 2, 5, NULL, 1, NULL, 8, '2023-02-24 15:58:55', '2025-03-30 11:39:59'),
(585, 1, 4, 1, 81, 84, 1, 3, 1, NULL, 1, NULL, 8, '2023-02-24 15:59:24', '2023-02-24 15:59:24'),
(586, 1, 4, 1, 81, 84, 1, 3, 2, NULL, 1, NULL, 8, '2023-02-24 15:59:33', '2023-02-24 15:59:33'),
(587, 1, 4, 1, 173, 83, 1, 1, 1, NULL, 1, NULL, 8, '2023-02-24 16:00:09', '2025-03-30 11:39:00'),
(588, 1, 4, 1, 173, 83, 1, 1, 2, NULL, 1, NULL, 8, '2023-02-24 16:00:18', '2025-03-30 11:39:17'),
(589, 1, 4, 2, 176, 91, 1, 1, 1, NULL, 1, NULL, 9, '2023-02-24 16:01:16', '2023-02-24 16:01:16'),
(590, 1, 4, 2, 176, 91, 1, 1, 2, NULL, 1, NULL, 9, '2023-02-24 16:01:26', '2023-02-24 16:01:26'),
(591, 1, 4, 2, 177, 94, 1, 5, 4, NULL, 1, NULL, 9, '2023-02-24 16:02:04', '2025-03-30 11:46:12'),
(592, 1, 4, 2, 177, 94, 1, 5, 3, NULL, 1, NULL, 9, '2023-02-24 16:02:11', '2025-03-30 11:46:01'),
(593, 1, 4, 2, 147, 213, 1, 3, 1, NULL, 1, NULL, 9, '2023-02-24 16:06:03', '2025-03-30 11:46:29'),
(594, 1, 4, 2, 147, 213, 1, 3, 2, NULL, 1, NULL, 9, '2023-02-24 16:06:13', '2025-03-30 11:46:37'),
(595, 1, 4, 3, 28, 102, 1, 3, 3, NULL, 1, NULL, 9, '2023-02-24 16:06:48', '2023-02-24 16:06:48'),
(596, 1, 4, 3, 28, 102, 1, 3, 4, NULL, 1, NULL, 9, '2023-02-24 16:06:56', '2023-02-24 16:06:56'),
(605, 1, 1, 2, 146, 36, 1, 1, 1, NULL, 1, NULL, 11, '2023-03-05 04:00:50', '2023-03-11 07:40:01'),
(606, 1, 1, 2, 146, 36, 1, 1, 2, NULL, 1, NULL, 11, '2023-03-05 04:01:16', '2023-03-11 07:40:17'),
(607, 1, 1, 2, 16, 38, 1, 2, 4, NULL, 1, NULL, 11, '2023-03-05 04:01:43', '2023-03-05 04:01:43'),
(608, 1, 1, 3, 11, 44, 1, 4, 1, NULL, 1, NULL, 11, '2023-03-05 04:02:58', '2023-03-05 04:02:58'),
(609, 1, 1, 3, 11, 44, 1, 4, 2, NULL, 1, NULL, 11, '2023-03-05 04:03:14', '2023-03-05 04:03:14'),
(610, 1, 1, 3, 53, 46, 1, 5, 1, NULL, 1, NULL, 11, '2023-03-05 04:03:28', '2023-03-05 04:03:28'),
(611, 1, 1, 3, 53, 46, 1, 5, 2, NULL, 1, NULL, 11, '2023-03-05 04:03:41', '2023-03-05 04:03:41'),
(612, 1, 5, 1, 189, 108, 1, 1, 5, NULL, 1, NULL, 2, '2023-03-05 04:10:53', '2025-03-24 11:47:46'),
(613, 1, 5, 1, 189, 108, 1, 1, 1, NULL, 1, NULL, 2, '2023-03-05 04:11:04', '2025-03-24 11:47:54'),
(614, 1, 5, 1, 10, 110, 1, 5, 2, NULL, 1, NULL, 2, '2023-03-05 04:13:12', '2023-03-11 07:20:16'),
(615, 1, 5, 1, 10, 110, 1, 5, 3, NULL, 1, NULL, 2, '2023-03-05 04:14:57', '2023-03-11 07:20:26'),
(616, 1, 5, 1, 9, 112, 1, 2, 5, NULL, 1, NULL, 2, '2023-03-05 04:15:22', '2023-03-05 04:15:22'),
(617, 1, 5, 1, 174, 111, 1, 2, 3, NULL, 1, NULL, 2, '2023-03-05 04:15:43', '2023-03-05 04:15:43'),
(618, 1, 5, 1, 174, 111, 1, 2, 4, NULL, 1, NULL, 2, '2023-03-05 04:15:55', '2023-03-05 04:15:55'),
(619, 1, 5, 1, 12, 116, 1, 4, 5, NULL, 1, NULL, 2, '2023-03-05 04:17:18', '2023-03-05 04:17:18'),
(620, 1, 5, 1, 194, 115, 1, 1, 2, NULL, 1, NULL, 2, '2023-03-05 04:17:38', '2025-03-24 11:48:09'),
(621, 1, 5, 2, 177, 119, 1, 5, 5, NULL, 1, NULL, 2, '2023-03-05 04:18:34', '2025-03-24 11:49:04'),
(622, 1, 5, 2, 193, 118, 1, 2, 2, NULL, 1, NULL, 2, '2023-03-05 04:19:26', '2024-04-13 15:59:13'),
(623, 1, 5, 2, 193, 118, 1, 2, 4, NULL, 1, NULL, 2, '2023-03-05 04:19:38', '2024-04-13 15:59:33'),
(624, 1, 5, 2, 193, 118, 1, 2, 3, NULL, 1, NULL, 2, '2023-03-05 04:19:53', '2024-04-13 15:59:23'),
(625, 1, 5, 2, 8, 123, 1, 3, 5, NULL, 1, NULL, 2, '2023-03-05 04:20:52', '2023-03-05 04:20:52'),
(626, 1, 5, 2, 177, 119, 1, 5, 2, NULL, 1, NULL, 2, '2023-03-05 04:21:18', '2025-03-24 11:51:03'),
(627, 1, 5, 2, 28, 120, 1, 5, 3, NULL, 1, NULL, 2, '2023-03-05 04:21:38', '2023-03-05 04:21:38'),
(628, 1, 5, 2, 28, 120, 1, 5, 4, NULL, 1, NULL, 2, '2023-03-05 04:21:47', '2023-03-05 04:21:47'),
(629, 1, 5, 3, 170, 130, 1, 1, 5, NULL, 1, NULL, 2, '2023-03-05 04:22:28', '2023-03-05 04:22:28'),
(630, 1, 5, 3, 170, 130, 1, 1, 1, NULL, 1, NULL, 2, '2023-03-05 04:23:20', '2023-03-05 04:23:20'),
(631, 1, 5, 3, 170, 127, 1, 3, 3, NULL, 1, NULL, 2, '2023-03-05 04:23:41', '2023-03-11 07:23:16'),
(632, 1, 5, 3, 177, 128, 1, 1, 3, NULL, 1, NULL, 2, '2023-03-05 04:24:03', '2025-03-24 11:51:57'),
(633, 1, 5, 3, 170, 127, 1, 5, 1, NULL, 1, NULL, 2, '2023-03-05 04:24:51', '2023-03-05 04:24:51'),
(634, 1, 5, 3, 170, 127, 1, 5, 2, NULL, 1, NULL, 2, '2023-03-05 04:25:05', '2023-03-05 04:25:05'),
(635, 1, 2, 1, 28, 5, 1, 4, 1, NULL, 1, NULL, 1, '2023-03-05 04:26:43', '2023-03-05 04:26:43'),
(636, 1, 2, 1, 28, 5, 1, 4, 2, NULL, 1, NULL, 1, '2023-03-05 04:26:56', '2023-03-05 04:26:56'),
(637, 1, 2, 1, 181, 2, 1, 4, 3, NULL, 1, NULL, 1, '2023-03-05 04:27:49', '2023-03-05 04:27:49'),
(638, 1, 2, 1, 181, 2, 1, 4, 4, NULL, 1, NULL, 1, '2023-03-05 04:28:08', '2023-03-05 04:28:08'),
(639, 1, 2, 2, 182, 13, 1, 1, 3, NULL, 1, NULL, 1, '2023-03-05 04:29:19', '2023-03-05 04:29:19'),
(640, 1, 2, 2, 182, 13, 1, 1, 4, NULL, 1, NULL, 1, '2023-03-05 04:29:32', '2023-03-05 04:29:32'),
(641, 1, 2, 2, 87, 10, 1, 2, 1, NULL, 1, NULL, 1, '2023-03-05 04:29:53', '2023-03-05 04:29:53'),
(642, 1, 2, 2, 87, 10, 1, 2, 2, NULL, 1, NULL, 1, '2023-03-05 04:30:04', '2023-03-05 04:30:04'),
(643, 1, 2, 2, 184, 11, 1, 3, 1, NULL, 1, NULL, 1, '2023-03-05 04:31:41', '2023-03-05 04:31:41'),
(644, 1, 2, 2, 184, 11, 1, 3, 2, NULL, 1, NULL, 1, '2023-03-05 04:31:52', '2023-03-05 04:31:52'),
(645, 1, 2, 2, 182, 15, 1, 3, 3, NULL, 1, NULL, 1, '2023-03-05 04:32:05', '2023-03-05 04:32:05'),
(646, 1, 2, 2, 182, 15, 1, 3, 4, NULL, 1, NULL, 1, '2023-03-05 04:32:17', '2023-03-05 04:32:17'),
(647, 1, 2, 2, 9, 12, 1, 4, 1, NULL, 1, NULL, 1, '2023-03-05 04:32:56', '2023-03-05 04:32:56'),
(648, 1, 2, 2, 9, 12, 1, 4, 2, NULL, 1, NULL, 1, '2023-03-05 04:33:10', '2023-03-05 04:33:10'),
(649, 1, 2, 2, 195, 16, 1, 4, 3, NULL, 1, NULL, 1, '2023-03-05 04:33:21', '2025-03-24 11:43:21'),
(650, 1, 2, 2, 195, 16, 1, 4, 4, NULL, 1, NULL, 1, '2023-03-05 04:33:30', '2025-03-24 11:43:31'),
(651, 1, 2, 2, 164, 9, 1, 5, 1, NULL, 1, NULL, 1, '2023-03-05 04:33:44', '2023-03-05 04:33:44'),
(652, 1, 2, 2, 164, 9, 1, 5, 2, NULL, 1, NULL, 1, '2023-03-05 04:33:51', '2023-03-05 04:33:51'),
(653, 1, 2, 2, 182, 13, 1, 5, 3, NULL, 1, NULL, 1, '2023-03-05 04:34:07', '2023-03-05 04:34:07'),
(654, 1, 2, 2, 182, 13, 1, 5, 4, NULL, 1, NULL, 1, '2023-03-05 04:34:20', '2023-03-05 04:34:20'),
(656, 1, 2, 3, 15, 18, 1, 1, 1, NULL, 1, NULL, 1, '2023-03-05 04:34:58', '2023-03-05 04:34:58'),
(657, 1, 2, 3, 15, 18, 1, 1, 2, NULL, 1, NULL, 1, '2023-03-05 04:35:09', '2023-03-05 04:35:09'),
(658, 1, 2, 3, 45, 19, 1, 1, 3, NULL, 1, NULL, 1, '2023-03-05 04:35:18', '2023-03-05 04:35:18'),
(659, 1, 2, 3, 45, 19, 1, 1, 4, NULL, 1, NULL, 1, '2023-03-05 04:35:25', '2023-03-05 04:35:25'),
(660, 1, 2, 3, 185, 21, 1, 2, 1, NULL, 1, NULL, 1, '2023-03-05 04:36:07', '2023-03-05 04:36:07'),
(661, 1, 2, 3, 185, 21, 1, 2, 2, NULL, 1, NULL, 1, '2023-03-05 04:36:23', '2023-03-05 04:36:23'),
(662, 1, 2, 3, 87, 20, 1, 2, 3, NULL, 1, NULL, 1, '2023-03-05 04:36:30', '2023-03-05 04:36:44'),
(663, 1, 2, 3, 87, 20, 1, 2, 4, NULL, 1, NULL, 1, '2023-03-05 04:36:56', '2023-03-05 04:36:56'),
(664, 1, 2, 3, 32, 1, 1, 3, 1, NULL, 1, NULL, 1, '2023-03-05 04:37:04', '2023-03-05 04:37:04'),
(665, 1, 2, 3, 32, 1, 1, 3, 2, NULL, 1, NULL, 1, '2023-03-05 04:37:10', '2023-03-05 04:37:10'),
(666, 1, 2, 3, 184, 22, 1, 3, 3, NULL, 1, NULL, 1, '2023-03-05 04:37:22', '2023-03-05 04:37:22'),
(667, 1, 2, 3, 184, 22, 1, 3, 4, NULL, 1, NULL, 1, '2023-03-05 04:37:30', '2023-03-05 04:37:30'),
(668, 1, 2, 3, 32, 1, 1, 4, 1, NULL, 1, NULL, 1, '2023-03-05 04:37:36', '2023-03-05 04:37:36'),
(669, 1, 2, 3, 32, 1, 1, 4, 2, NULL, 1, NULL, 1, '2023-03-05 04:37:43', '2023-03-05 04:37:43'),
(670, 1, 2, 3, 32, 1, 1, 4, 3, NULL, 1, NULL, 1, '2023-03-05 04:37:50', '2023-03-05 04:37:50'),
(671, 1, 2, 3, 32, 1, 1, 4, 4, NULL, 1, NULL, 1, '2023-03-05 04:37:57', '2023-03-05 04:37:57'),
(672, 1, 2, 3, 15, 18, 1, 5, 1, NULL, 1, NULL, 1, '2023-03-05 04:38:07', '2023-03-05 04:38:07'),
(673, 1, 2, 3, 15, 18, 1, 5, 2, NULL, 1, NULL, 1, '2023-03-05 04:38:16', '2023-03-05 04:38:16'),
(674, 1, 2, 3, 68, 23, 1, 5, 3, NULL, 1, NULL, 1, '2023-03-05 04:38:27', '2023-03-05 04:38:27'),
(675, 1, 2, 3, 68, 23, 1, 5, 4, NULL, 1, NULL, 1, '2023-03-05 04:38:45', '2023-03-05 04:38:45'),
(698, 1, 3, 1, 55, 56, 1, 1, 5, NULL, 1, NULL, 6, '2023-03-11 07:26:15', '2023-03-11 07:26:15'),
(699, 1, 3, 1, 187, 53, 1, 1, 1, NULL, 1, NULL, 6, '2023-03-11 07:27:29', '2024-04-13 15:27:59'),
(700, 1, 3, 1, 187, 53, 1, 1, 2, NULL, 1, NULL, 6, '2023-03-11 07:27:42', '2024-04-13 15:28:07'),
(703, 1, 3, 1, 56, 50, 1, 2, 3, NULL, 1, NULL, 6, '2023-03-11 07:29:10', '2023-03-11 07:29:10'),
(704, 1, 3, 1, 56, 50, 1, 2, 4, NULL, 1, NULL, 6, '2023-03-11 07:29:22', '2023-03-11 07:29:22'),
(707, 1, 3, 2, 55, 64, 1, 5, 3, NULL, 1, NULL, 6, '2023-03-11 07:31:28', '2025-03-30 11:26:45'),
(708, 1, 3, 2, 55, 64, 1, 5, 4, NULL, 1, NULL, 6, '2023-03-11 07:31:37', '2025-03-30 11:26:35'),
(710, 1, 3, 2, 52, 65, 1, 3, 3, NULL, 1, NULL, 6, '2023-03-11 07:32:03', '2025-03-30 11:29:59'),
(711, 1, 3, 2, 177, 60, 1, 4, 1, NULL, 1, NULL, 6, '2023-03-11 07:32:14', '2025-03-30 11:26:59'),
(712, 1, 3, 2, 27, 63, 1, 2, 3, NULL, 1, NULL, 6, '2023-03-11 07:32:22', '2025-03-30 11:25:15'),
(713, 1, 3, 2, 28, 62, 1, 5, 1, NULL, 1, NULL, 6, '2023-03-11 07:32:38', '2023-03-11 07:32:38'),
(714, 1, 3, 2, 28, 62, 1, 5, 2, NULL, 1, NULL, 6, '2023-03-11 07:32:47', '2023-03-11 07:32:47'),
(715, 1, 3, 3, 55, 72, 1, 3, 5, NULL, 1, NULL, 7, '2023-03-11 07:33:51', '2023-03-11 07:33:51'),
(716, 1, 3, 3, 177, 71, 1, 1, 3, NULL, 1, NULL, 7, '2023-03-11 07:34:41', '2025-03-30 11:31:01'),
(717, 1, 3, 3, 177, 71, 1, 1, 4, NULL, 1, NULL, 7, '2023-03-11 07:34:54', '2025-03-30 11:31:16'),
(719, 1, 6, 1, 12, 141, 2, 1, 5, NULL, 1, NULL, 3, '2023-03-11 13:02:04', '2023-03-11 13:02:04'),
(720, 1, 6, 1, 62, 133, 2, 2, 3, NULL, 1, NULL, 3, '2023-03-11 13:02:24', '2025-03-24 12:00:33'),
(721, 1, 8, 1, 5, 189, 1, 3, 1, NULL, 1, NULL, 4, '2023-03-18 05:53:36', '2024-04-13 15:09:45'),
(722, 1, 4, 2, 74, 97, 1, 3, 5, NULL, 1, NULL, 9, '2023-04-06 15:24:57', '2023-04-06 15:24:57'),
(723, 1, 4, 3, 44, 107, 1, 5, 5, NULL, 1, NULL, 9, '2023-04-06 15:26:39', '2023-04-06 15:26:39'),
(724, 1, 8, 1, 5, 189, 1, 3, 2, NULL, 1, NULL, 4, '2023-04-06 15:29:55', '2023-04-06 15:29:55'),
(725, 1, 4, 2, 44, 96, 1, 4, 5, NULL, 1, NULL, 9, '2023-04-12 12:01:33', '2023-04-12 12:01:33'),
(750, 1, 8, 3, 45, 203, 1, 4, 5, NULL, 1, NULL, 4, '2025-03-24 12:08:16', '2025-03-24 12:08:16'),
(751, 1, 8, 3, 45, 203, 1, 4, 1, NULL, 1, NULL, 4, '2025-03-24 12:08:28', '2025-03-24 12:08:28'),
(752, 1, 8, 3, 45, 203, 1, 4, 2, NULL, 1, NULL, 4, '2025-03-24 12:08:37', '2025-03-24 12:08:37'),
(753, 1, 3, 1, 28, 62, 1, 2, 1, 'EACI Ascúa, Daniel', 1, NULL, 6, '2025-03-30 11:23:16', '2025-03-30 11:23:16'),
(754, 1, 3, 1, 28, 62, 1, 2, 2, 'EACI Ascúa, Daniel', 1, NULL, 6, '2025-03-30 11:23:33', '2025-03-30 11:23:33'),
(755, 1, 3, 1, 47, 52, 1, 4, 1, NULL, 1, NULL, 6, '2025-03-30 11:23:57', '2025-03-30 11:23:57'),
(756, 1, 3, 1, 47, 52, 1, 4, 2, NULL, 1, NULL, 6, '2025-03-30 11:24:11', '2025-03-30 11:24:11'),
(757, 1, 3, 1, 47, 52, 1, 4, 3, NULL, 1, NULL, 6, '2025-03-30 11:24:21', '2025-03-30 11:24:21'),
(758, 1, 3, 2, 27, 63, 1, 2, 4, NULL, 1, NULL, 6, '2025-03-30 11:25:36', '2025-03-30 11:25:36'),
(759, 1, 3, 2, 177, 60, 1, 4, 2, NULL, 1, NULL, 6, '2025-03-30 11:27:27', '2025-03-30 11:27:27'),
(760, 1, 3, 2, 55, 64, 1, 1, 3, NULL, 1, NULL, 6, '2025-03-30 11:29:13', '2025-03-30 11:29:13'),
(761, 1, 3, 2, 55, 64, 1, 1, 4, NULL, 1, NULL, 6, '2025-03-30 11:29:21', '2025-03-30 11:29:21'),
(762, 1, 3, 2, 52, 65, 1, 3, 4, NULL, 1, NULL, 6, '2025-03-30 11:30:19', '2025-03-30 11:30:19'),
(763, 1, 4, 1, 35, 82, 1, 4, 5, NULL, 1, NULL, 8, '2025-03-30 11:40:52', '2025-03-30 11:40:52'),
(764, 1, 4, 1, 35, 82, 1, 4, 1, NULL, 1, NULL, 8, '2025-03-30 11:41:05', '2025-03-30 11:41:05'),
(765, 1, 4, 1, 35, 82, 1, 4, 2, NULL, 1, NULL, 8, '2025-03-30 11:41:15', '2025-03-30 11:41:15'),
(766, 1, 4, 1, 175, 80, 1, 4, 3, NULL, 1, NULL, 8, '2025-03-30 11:41:30', '2025-03-30 11:41:30'),
(767, 1, 4, 1, 175, 80, 1, 4, 4, NULL, 1, NULL, 8, '2025-03-30 11:41:41', '2025-03-30 11:41:41'),
(768, 1, 4, 1, 28, 81, 1, 5, 5, NULL, 1, NULL, 8, '2025-03-30 11:41:50', '2025-03-30 11:41:50'),
(769, 1, 1, 1, 16, 27, 1, 1, 2, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:39:49', '2025-04-29 11:39:49'),
(771, 1, 1, 1, 187, 28, 1, 1, 3, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:40:58', '2025-04-29 11:40:58'),
(772, 1, 1, 1, 187, 28, 1, 1, 4, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:41:11', '2025-04-29 11:41:11'),
(773, 1, 1, 1, 16, 29, 1, 2, 1, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:41:31', '2025-04-29 11:41:31'),
(774, 1, 1, 1, 194, 26, 1, 2, 2, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:41:54', '2025-04-29 11:41:54'),
(775, 1, 1, 1, 194, 26, 1, 2, 3, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:42:08', '2025-04-29 11:42:08'),
(776, 1, 1, 1, 194, 26, 1, 2, 4, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:42:23', '2025-04-29 11:42:23'),
(777, 1, 1, 1, 201, 32, 1, 3, 1, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:42:55', '2025-04-29 11:42:55'),
(778, 1, 1, 1, 201, 32, 1, 3, 2, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:43:25', '2025-04-29 11:43:25'),
(779, 1, 1, 1, 16, 27, 1, 3, 3, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:43:40', '2025-04-29 11:43:40'),
(780, 1, 1, 1, 16, 29, 1, 3, 4, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:43:53', '2025-04-29 11:43:53'),
(781, 1, 1, 1, 16, 27, 1, 4, 1, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:44:07', '2025-04-29 11:44:07'),
(782, 1, 1, 1, 16, 27, 1, 4, 2, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:44:20', '2025-04-29 11:44:20'),
(783, 1, 1, 1, 28, 24, 1, 4, 3, 'RES. 5312/24', 1, NULL, 10, '2025-04-29 11:44:38', '2025-04-29 11:44:38'),
(784, 1, 1, 1, 28, 24, 1, 4, 4, 'RES. 5312/24', 1, NULL, 10, '2025-04-29 11:44:50', '2025-04-29 11:44:50'),
(785, 1, 1, 1, 177, 25, 1, 5, 1, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:45:05', '2025-04-29 11:45:05'),
(786, 1, 1, 1, 177, 25, 1, 5, 2, 'RES. 5312/24\n', 2, 1, 10, '2025-04-29 11:45:15', '2025-04-29 11:45:15'),
(787, 1, 3, 2, 28, 215, 1, 5, 1, NULL, 1, NULL, 7, NULL, NULL),
(788, 1, 3, 2, 28, 215, 1, 5, 2, NULL, 1, NULL, 7, NULL, NULL),
(789, 1, 1, 1, 194, 216, 1, 2, 2, 'RES. 5312/24\n', 2, 2, 10, NULL, NULL),
(790, 1, 1, 1, 194, 216, 1, 2, 3, 'RES. 5312/24\n', 2, 2, 10, NULL, NULL),
(791, 1, 1, 1, 194, 216, 1, 2, 4, 'RES. 5312/24\n', 2, 2, 10, NULL, NULL),
(792, 1, 26, 1, 199, 220, 1, 1, 1, NULL, 2, 1, 5, NULL, NULL),
(793, 1, 26, 1, 199, 220, 1, 1, 2, NULL, 2, 1, 5, NULL, NULL),
(794, 1, 26, 1, 199, 220, 1, 3, 1, NULL, 2, 1, 5, NULL, NULL),
(795, 1, 26, 1, 199, 220, 1, 3, 2, NULL, 2, 1, 5, NULL, NULL),
(796, 1, 26, 1, 200, 221, 1, 1, 3, NULL, 1, NULL, 5, NULL, NULL),
(797, 1, 26, 1, 200, 221, 1, 1, 4, NULL, 1, NULL, 5, NULL, NULL),
(798, 1, 26, 1, 184, 222, 1, 2, 5, NULL, 2, 1, 5, NULL, NULL),
(799, 1, 26, 1, 184, 222, 1, 2, 1, NULL, 2, 1, 5, NULL, NULL),
(800, 1, 26, 1, 184, 222, 1, 2, 2, NULL, 2, 1, 5, NULL, NULL),
(801, 1, 26, 1, 184, 222, 1, 4, 3, NULL, 2, 1, 5, NULL, NULL),
(802, 1, 26, 1, 184, 223, 1, 2, 3, NULL, 2, 1, 5, NULL, NULL),
(803, 1, 26, 1, 184, 223, 1, 2, 4, NULL, 2, 1, 5, NULL, NULL),
(804, 1, 26, 1, 184, 223, 1, 4, 1, NULL, 2, 1, 5, NULL, NULL),
(805, 1, 26, 1, 184, 223, 1, 4, 2, NULL, 2, 1, 5, NULL, NULL),
(806, 1, 26, 1, 195, 224, 1, 3, 3, NULL, 2, 1, 5, NULL, NULL),
(807, 1, 26, 1, 195, 224, 1, 3, 4, NULL, 2, 1, 5, NULL, NULL),
(808, 1, 26, 1, 199, 225, 1, 1, 1, NULL, 2, 2, 5, NULL, NULL),
(809, 1, 26, 1, 199, 225, 1, 1, 2, NULL, 2, 2, 5, NULL, NULL),
(810, 1, 26, 1, 199, 225, 1, 3, 1, NULL, 2, 2, 5, NULL, NULL),
(811, 1, 26, 1, 199, 225, 1, 3, 2, NULL, 2, 2, 5, NULL, NULL),
(814, 1, 26, 1, 184, 226, 1, 2, 5, NULL, 2, 2, 5, NULL, NULL),
(815, 1, 26, 1, 184, 226, 1, 2, 1, NULL, 2, 2, 5, NULL, NULL),
(816, 1, 26, 1, 184, 226, 1, 2, 2, NULL, 2, 2, 5, NULL, NULL),
(817, 1, 26, 1, 184, 226, 1, 4, 3, NULL, 2, 2, 5, NULL, NULL),
(818, 1, 26, 1, 184, 227, 1, 2, 3, NULL, 2, 2, 5, NULL, NULL),
(819, 1, 26, 1, 184, 227, 1, 2, 4, NULL, 2, 2, 5, NULL, NULL),
(820, 1, 26, 1, 184, 227, 1, 4, 1, NULL, 2, 2, 5, NULL, NULL),
(821, 1, 26, 1, 184, 227, 1, 4, 2, NULL, 2, 2, 5, NULL, NULL),
(822, 1, 26, 1, 195, 228, 1, 3, 3, NULL, 2, 2, 5, NULL, NULL),
(823, 1, 26, 1, 195, 228, 1, 3, 4, NULL, 2, 2, 5, NULL, NULL),
(824, 1, 1, 1, 201, 32, 1, 1, 1, 'RES. 5312/24\n', 2, 1, 10, NULL, NULL),
(825, 1, 1, 1, 187, 31, 1, 1, 3, 'RES. 5312/24\n', 2, 2, 10, NULL, NULL),
(826, 1, 1, 1, 187, 31, 1, 1, 4, 'RES. 5312/24\n', 2, 2, 10, NULL, NULL),
(827, 1, 1, 1, 9, 217, 1, 1, 1, 'RES. 5312/24\r\n', 2, 2, 10, NULL, NULL),
(828, 1, 1, 1, 9, 217, 1, 3, 1, 'RES. 5312/24', 2, 2, 10, NULL, NULL),
(829, 1, 1, 1, 9, 217, 1, 3, 2, 'RES. 5312/24', 2, 2, 10, NULL, NULL),
(830, 1, 1, 1, 16, 33, 1, 1, 2, 'RES. 5312/24', 2, 2, 10, NULL, NULL),
(831, 1, 1, 1, 16, 33, 1, 2, 1, 'RES. 5312/24', 2, 2, 10, NULL, NULL),
(832, 1, 1, 1, 16, 33, 1, 3, 3, 'RES. 5312/24', 2, 2, 10, NULL, NULL),
(833, 1, 1, 1, 16, 33, 1, 3, 4, 'RES. 5312/24', 2, 2, 10, NULL, NULL),
(834, 1, 1, 1, 16, 33, 1, 4, 1, 'RES. 5312/24', 2, 2, 10, NULL, NULL),
(835, 1, 1, 1, 16, 33, 1, 4, 2, 'RES. 5312/24', 2, 2, 10, NULL, NULL),
(838, 1, 1, 1, 189, 219, 1, 5, 1, 'RES. 5312/24\n', 2, 2, 10, NULL, NULL),
(839, 1, 1, 1, 189, 219, 1, 5, 2, 'RES. 5312/24\n', 2, 2, 10, NULL, NULL),
(840, 1, 1, 2, 14, 39, 1, 3, 5, NULL, 1, NULL, 10, NULL, '2025-07-18 17:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `idiomas`
--

CREATE TABLE `idiomas` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `idioma` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `idiomas`
--

INSERT INTO `idiomas` (`id`, `usuario_id`, `idioma`, `nivel`, `created_at`, `updated_at`) VALUES
(1, 1, 'Italiano', 'Básico', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 1, 'Francés', 'Intermedio', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(3, 2, 'Italiano', 'Intermedio', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(4, 2, 'Italiano', 'Intermedio', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(5, 3, 'Italiano', 'Intermedio', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(6, 3, 'Italiano', 'Intermedio', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(7, 4, 'Italiano', 'Nativo', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(8, 4, 'Alemán', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(9, 5, 'Inglés', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(10, 5, 'Inglés', 'Básico', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(11, 6, 'Portugués', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(12, 6, 'Portugués', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(13, 7, 'Portugués', 'Básico', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(14, 7, 'Inglés', 'Intermedio', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(15, 8, 'Alemán', 'Básico', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(16, 8, 'Portugués', 'Básico', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(17, 9, 'Italiano', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(18, 9, 'Portugués', 'Básico', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(19, 10, 'Italiano', 'Intermedio', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(20, 10, 'Italiano', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(21, 11, 'Portugués', 'Intermedio', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(22, 11, 'Portugués', 'Intermedio', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(23, 12, 'Alemán', 'Nativo', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(24, 12, 'Alemán', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(25, 13, 'Francés', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(26, 13, 'Inglés', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(27, 14, 'Alemán', 'Básico', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(28, 14, 'Francés', 'Nativo', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(29, 15, 'Portugués', 'Básico', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(30, 15, 'Inglés', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(31, 16, 'Alemán', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(32, 16, 'Francés', 'Intermedio', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(33, 17, 'Inglés', 'Básico', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(34, 17, 'Portugués', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(35, 18, 'Alemán', 'Básico', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(36, 18, 'Portugués', 'Avanzado', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(37, 19, 'Italiano', 'Básico', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(38, 19, 'Italiano', 'Nativo', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(39, 20, 'Alemán', 'Básico', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(40, 20, 'Alemán', 'Nativo', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(41, 22, 'adasdasd', 'Nativo', '2025-09-25 00:50:49', '2025-09-25 00:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `idiomas_disponibles`
--

CREATE TABLE `idiomas_disponibles` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre_idioma` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `idiomas_disponibles`
--

INSERT INTO `idiomas_disponibles` (`id`, `nombre_idioma`, `created_at`, `updated_at`) VALUES
(1, 'Español', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(2, 'Inglés', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(3, 'Francés', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(4, 'Alemán', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(5, 'Italiano', '2025-09-24 11:13:26', '2025-09-24 11:13:26'),
(6, 'Portugués', '2025-09-24 11:13:26', '2025-09-24 11:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `idiomas_ofertas`
--

CREATE TABLE `idiomas_ofertas` (
  `id` bigint UNSIGNED NOT NULL,
  `oferta_id` bigint UNSIGNED NOT NULL,
  `idioma_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `idiomas_ofertas`
--

INSERT INTO `idiomas_ofertas` (`id`, `oferta_id`, `idioma_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(2, 1, 4, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(3, 1, 5, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(4, 2, 2, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(5, 2, 4, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(6, 2, 4, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(7, 3, 1, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(8, 3, 4, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(9, 3, 1, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(10, 4, 5, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(11, 4, 1, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(12, 4, 2, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(13, 5, 6, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(14, 5, 4, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(15, 5, 3, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(16, 6, 2, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(17, 6, 3, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(18, 6, 5, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(19, 7, 6, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(20, 7, 2, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(21, 7, 6, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(22, 8, 4, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(23, 8, 1, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(24, 8, 6, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(25, 9, 6, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(26, 9, 3, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(27, 9, 5, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(28, 10, 3, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(29, 10, 6, '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(30, 10, 3, '2025-09-24 11:13:29', '2025-09-24 11:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `lista_espera`
--

CREATE TABLE `lista_espera` (
  `id` bigint UNSIGNED NOT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `dni` int NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `tel_alternativo` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materias`
--

CREATE TABLE `materias` (
  `id` bigint UNSIGNED NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `categoria_id` int DEFAULT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `anio_id` bigint UNSIGNED DEFAULT NULL,
  `profesor_id` bigint UNSIGNED DEFAULT NULL,
  `resolucion_id` bigint UNSIGNED DEFAULT NULL,
  `orden` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `laboratorio` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `materias`
--

INSERT INTO `materias` (`id`, `descripcion`, `categoria_id`, `carrera_id`, `anio_id`, `profesor_id`, `resolucion_id`, `orden`, `created_at`, `updated_at`, `laboratorio`) VALUES
(1, 'PRÁCTICAS PROFESIONALIZANTES III', 1, 2, 3, 32, 1, 23, NULL, '2025-10-14 01:31:17', 0),
(2, 'PRÁCTICAS PROFESIONALIZANTES I', 1, 2, 1, 181, 1, 8, '2022-10-08 08:05:08', '2023-09-25 19:49:05', 0),
(3, 'CIENCIA, TECNOLOGÍA Y SOCIEDAD', 4, 2, 1, 77, 1, 2, '2022-11-04 03:06:11', '2023-10-29 22:53:59', 0),
(4, 'ALGORITMOS Y ESTRUCTURAS DE DATOS I', 1, 2, 1, 164, 1, 5, '2022-11-04 03:06:22', '2023-10-29 22:54:25', 1),
(5, 'INGLÉS I', 3, 2, 1, 28, 1, 1, '2022-11-04 03:06:28', '2023-10-29 22:52:46', 0),
(6, 'ARQUITECTURA DE LAS COMPUTADORAS', 1, 2, 1, 146, 1, 7, '2022-11-04 03:06:39', '2023-10-29 22:54:40', 0),
(7, 'ÁLGEBRA', 2, 2, 1, 91, 1, 4, '2022-11-04 03:08:06', '2023-10-29 22:54:16', 0),
(8, 'SISTEMAS Y ORGANIZACIONES', 1, 2, 1, 15, 1, 6, '2022-11-04 03:08:13', '2023-10-29 22:54:35', 0),
(9, 'ALGORITMOS Y ESTRUCTURAS DE DATOS II', 1, 2, 2, 164, 1, 13, '2022-11-04 03:09:19', '2023-11-29 04:52:32', 1),
(10, 'BASE DE DATOS', 1, 2, 2, 87, 1, 15, '2022-11-04 03:09:28', '2023-11-29 04:52:50', 1),
(11, 'SISTEMAS OPERATIVOS', 1, 2, 2, 184, 1, 14, '2022-11-04 03:09:34', '2023-11-29 04:52:44', 0),
(12, 'ANÁLISIS MATEMÁTICO II ', 2, 2, 2, 9, 1, 10, '2022-11-04 03:09:39', '2023-11-29 04:52:17', 0),
(13, 'PRÁCTICAS PROFESIONALIZANTES II', 1, 2, 2, 182, 1, 16, '2022-11-04 03:09:52', '2023-11-29 04:52:59', 0),
(14, 'ESTADÍSTICA', 2, 2, 2, 196, 1, 11, '2022-11-04 03:09:57', '2023-11-29 04:52:19', 0),
(15, 'INGENIERIA DE SOFTWARE I', 1, 2, 2, 182, 1, 12, '2022-11-04 03:10:03', '2023-11-29 04:52:25', 0),
(16, 'INGLÉS II', 3, 2, 2, 195, 1, 9, '2022-11-04 03:10:09', '2023-11-29 04:52:07', 0),
(18, 'ALGORITMOS Y ESTRUCTURAS DE DATOS III', 1, 2, 3, 15, 1, 22, '2022-11-04 03:10:29', '2023-11-29 04:53:47', 0),
(19, 'SEMINARIO DE ACTUALIZACIÓN', 1, 2, 3, 45, 1, 19, '2022-11-04 03:10:35', '2023-09-25 19:51:31', 0),
(20, 'REDES Y COMUNICACIONES', 1, 2, 3, 87, 1, 20, '2022-11-04 03:10:40', '2023-11-29 04:53:35', 1),
(21, 'ASPECTOS LEGALES DE LA PROFESIÓN', 5, 2, 3, 185, 1, 18, '2022-11-04 03:10:47', '2023-09-25 19:52:23', 0),
(22, 'INGENIERÍA DE SOFTWARE II', 1, 2, 3, 184, 1, 21, '2022-11-04 03:11:01', '2023-11-29 04:53:41', 0),
(23, 'INGLÉS III', 3, 2, 3, 68, 1, 17, '2022-11-04 03:11:05', '2023-11-29 04:53:25', 0),
(24, 'INGLES PARA  LA LOGÍSTICA 1 (1° C)', 3, 1, 1, 28, 10, 6, '2022-11-04 03:12:23', '2025-04-29 20:35:15', 0),
(25, 'METODOLOGIA DE  LA INVESTIGACION 1 (1° C)', 4, 1, 1, 189, 10, 7, '2022-11-04 03:12:26', '2025-04-29 20:35:34', 0),
(26, 'TECNOLOGÍAS Y SISTEMAS DE LA INFORMACIÓN EN LOGÍSTICA 1 (1° C)', 1, 1, 1, 194, 10, 4, '2022-11-04 03:12:30', '2025-04-29 20:34:26', 0),
(27, 'INTRODUCCIÓN A LA  LOGÍSTICA Y LA  DISTRIBUCIÓN (1° C)', 11, 1, 1, 16, 10, 3, '2022-11-04 03:12:47', '2025-04-29 20:33:54', 0),
(28, 'FUNDAMENTOS DE ADMINISTRACIÓN  Y ECONOMÍA (1° C)', 11, 1, 1, 187, 10, 2, '2022-11-04 03:12:58', '2025-04-29 20:33:42', 0),
(29, 'INTRODUCCIÓN A LA  LOGÍSTICA Y LA  DISTRIBUCIÓN (1° C)', 11, 1, 1, 16, 10, 1, '2022-11-04 03:13:02', '2025-04-29 20:33:23', 0),
(31, 'ADMINISTRACIÓN  DE LAS ORGANIZACIONES EN LOGÍSTICA (2° C)', 11, 1, 1, 187, 10, 9, '2022-11-04 03:13:07', '2025-04-29 20:36:16', 0),
(32, 'FUNDAMENTOS DE LA  MATEMÁTICA  PARA LA LOGÍSTICA (1° C)', 2, 1, 1, 9, 10, 5, '2022-11-04 03:13:11', '2025-04-29 20:34:52', 0),
(33, 'PRACTICA  PROFESIONAL 1 (2° C)', 11, 1, 1, 16, 10, 8, '2022-11-04 03:13:14', '2025-04-29 20:35:58', 0),
(34, 'LOGÍSTICA I', 11, 1, 2, 29, 11, 13, '2022-11-04 03:13:19', '2023-11-29 04:48:42', 0),
(35, 'INGLÉS II', 3, 1, 2, 195, 11, 10, '2022-11-04 03:13:24', '2023-11-29 04:48:14', 0),
(36, 'INFORMÁTICA APLICADA', 1, 1, 2, 146, 11, 16, '2022-11-04 03:13:28', '2023-11-29 04:49:01', 0),
(37, 'ESPACIO DE DEFINICION INSTITUCIONAL', 11, 1, 2, 11, 11, 17, '2022-11-04 03:13:32', '2023-09-25 20:46:25', 0),
(38, 'DISTRIBUCIÓN II', 11, 1, 2, 16, 11, 14, '2022-11-04 03:13:37', '2023-11-29 04:48:50', 0),
(39, 'CALIDAD, PRODUCCIÓN Y SERVICIO', 11, 1, 2, 14, 11, 15, '2022-11-04 03:13:42', '2023-10-29 22:30:39', 0),
(40, 'ADMINISTRACIÓN DE INVENTARIOS Y COMPRAS', 11, 1, 2, 29, 11, 12, '2022-11-04 03:13:46', '2023-11-29 04:48:27', 0),
(41, 'SOCIOLOGÍA DE LAS ORGANIZACIONES', 4, 1, 2, 35, 11, 11, '2022-11-04 03:13:51', '2023-11-29 04:48:21', 0),
(42, 'SEGURIDAD E HIGIENE', 10, 1, 3, 13, 11, 20, '2022-11-04 03:14:01', '2023-11-29 04:49:40', 0),
(43, 'PRÁCTICA PROFESIONAL', 11, 1, 3, 14, 11, 21, '2022-11-04 03:14:05', '2023-11-29 04:49:50', 0),
(44, 'PORTUGUÉS', 3, 1, 3, 11, 11, 18, '2022-11-04 03:14:09', '2023-09-25 20:48:52', 0),
(45, 'LOGÍSTICA II', 11, 1, 3, 29, 11, 19, '2022-11-04 03:14:14', '2023-11-29 04:49:28', 0),
(46, 'LEGISLACIÓN', 5, 1, 3, 53, 11, 22, '2022-11-04 03:14:18', '2023-09-25 20:49:34', 0),
(47, 'ESPACIO DE DEFINICIÓN INSTITUCIONAL II', 11, 1, 3, 29, 11, 23, '2022-11-04 03:14:22', '2023-09-25 20:49:57', 0),
(48, 'PRINCIPIOS DE ADMINISTRACIÓN', 6, 3, 1, 82, 6, 3, '2022-11-04 03:15:02', '2025-03-30 20:11:17', 0),
(50, 'FUNDAMENTOS DE LA MATEMÁTICA', 2, 3, 1, 56, 6, 5, '2022-11-04 03:15:13', '2025-03-30 20:11:05', 0),
(51, 'GESTIÓN ADMINISTRATIVO CONTABLE', 6, 3, 1, 55, 6, 7, '2022-11-04 03:15:18', '2025-03-30 20:11:44', 0),
(52, 'PRÁCTICA PROFESIONAL I', 6, 3, 1, 47, 6, 8, '2022-11-04 03:15:23', '2025-03-30 20:12:27', 0),
(53, 'ECONOMÍA', 6, 3, 1, 187, 6, 4, '2022-11-04 03:15:28', '2023-09-25 20:51:39', 0),
(55, 'DERECHO', 5, 3, 1, 52, 6, 1, '2022-11-04 03:15:34', '2025-03-30 20:03:05', 0),
(56, 'PRINCIPIOS DE CONTABILIDAD', 6, 3, 1, 55, 6, 6, '2022-11-04 03:15:39', '2025-03-30 20:11:31', 0),
(60, 'MATEMATICA PARA ADMINISTRACION', 2, 3, 2, 201, 6, 11, '2022-11-04 03:16:27', '2025-03-30 20:17:43', 0),
(61, 'MATEMATICA FINANCIERA', 2, 3, 2, 56, 6, 16, '2022-11-04 03:16:33', '2025-03-30 20:18:48', 0),
(62, 'INGLÉS I', 3, 3, 1, 28, 6, 2, '2022-11-04 03:16:39', '2025-03-30 20:10:47', 0),
(63, 'COSTOS Y PLANIFICACION', 6, 3, 2, 27, 6, 15, '2022-11-04 03:16:59', '2025-03-30 20:19:02', 0),
(64, 'PRÁCTICA PROFESIONAL II', 6, 3, 2, 55, 6, 17, '2022-11-04 03:17:06', '2025-03-30 20:19:31', 0),
(65, 'DERECHO LABORAL', 5, 3, 2, 52, 6, 12, '2022-11-04 03:17:11', '2025-03-30 20:17:57', 0),
(66, 'DERECHO COMERCIAL', 5, 3, 2, 74, 6, 13, '2022-11-04 03:17:17', '2025-03-30 20:18:09', 0),
(67, 'CONTABILIDAD Y GESTION', 6, 3, 2, 55, 6, 14, '2022-11-04 03:17:26', '2025-03-30 20:18:26', 0),
(68, 'TECNOLOGIAS Y SISTEMAS PARA ADMINISTRACION', 1, 3, 2, 20, 6, 10, '2022-11-04 03:17:31', '2025-03-30 20:17:12', 0),
(69, 'RÉGIMEN TRIBUTARIO', 6, 3, 3, 84, 7, 21, '2022-11-04 03:17:40', '2025-03-30 20:21:18', 0),
(70, 'PRÁCTICA PROFESIONAL III', 6, 3, 3, 55, 7, 26, '2022-11-04 03:17:46', '2025-03-30 20:31:54', 0),
(71, 'INGLÉS III', 3, 3, 3, 28, 7, 19, '2022-11-04 03:17:51', '2025-03-30 20:21:00', 0),
(72, 'ESPACIO DE DEFINICION INSTITUCIONAL', 6, 3, 3, 55, 7, 27, '2022-11-04 03:17:57', '2025-03-30 20:22:12', 0),
(73, 'COSTOS Y PRESUPUESTOS', 6, 3, 3, 82, 7, 23, '2022-11-04 03:18:02', '2025-03-30 20:21:41', 0),
(74, 'CONTABILIDAD III', 6, 3, 3, 42, 7, 22, '2022-11-04 03:18:07', '2025-03-30 20:21:32', 0),
(76, 'ADMINISTRACION FINANCIERA', 6, 3, 3, 55, 7, 24, '2022-11-04 03:18:15', '2025-03-30 20:21:49', 0),
(77, 'ADMINISTRACION ESTRATÉGICA', 6, 3, 3, 82, 7, 25, '2022-11-04 03:18:22', '2025-03-30 20:21:56', 0),
(78, 'TÉCNICA IMPOSITIVA Y LABORAL', 6, 3, 3, 82, 7, 20, '2022-11-04 03:18:27', '2025-03-30 20:21:08', 0),
(79, 'PRINCIPIOS DE ADMINISTRACIÓN', 7, 4, 1, 66, 8, 3, '2022-11-04 03:18:46', '2025-03-30 20:34:54', 0),
(80, 'ECONOMÍA', 7, 4, 1, 175, 8, 4, '2022-11-04 03:18:52', '2025-03-30 20:36:48', 0),
(81, 'INGLÉS 1', 3, 4, 1, 28, 8, 2, '2022-11-04 03:18:58', '2025-03-30 20:34:43', 0),
(82, 'PRÁCTICA PROFESIONALIZANTE 1', 7, 4, 1, 35, 8, 9, '2022-11-04 03:19:03', '2025-03-30 20:36:28', 0),
(83, 'FUNDAMENTOS DE MATEMATICA', 2, 4, 1, 173, 8, 5, '2022-11-04 03:19:19', '2025-03-30 20:35:27', 0),
(84, 'DERECHO', 5, 4, 1, 81, 8, 1, '2022-11-04 03:19:27', '2025-03-30 20:34:24', 0),
(85, 'PRINCIPIOS DE CONTABILIDAD', 7, 4, 1, 55, 8, 6, '2022-11-04 03:19:33', '2025-03-30 20:35:44', 0),
(86, 'GESTIÓN DE INFORMACIÓN PARA ADMINISTRACIÓN DE RECURSOS HUMANOS', 7, 4, 1, 37, 8, 7, '2022-11-04 03:19:38', '2025-03-30 20:36:03', 0),
(87, 'ADMINISTRACION DE PERSONAL', 7, 4, 1, 18, 8, 8, '2022-11-04 03:19:45', '2025-03-30 20:36:17', 0),
(89, 'SEGURIDAD SOCIAL', 4, 4, 2, 12, 9, 14, '2022-11-04 03:20:58', '2025-03-30 20:42:46', 0),
(90, 'RELACIONES LABORALES', 7, 4, 2, 12, 9, 17, '2022-11-04 03:21:03', '2025-03-30 20:43:18', 0),
(91, 'PSICOLOGÍA LABORAL', 4, 4, 2, 176, 9, 15, '2022-11-04 03:21:08', '2025-03-30 20:42:54', 0),
(92, 'PRÁCTICA PROFESIONAL I', 7, 4, 2, 44, 9, 19, '2022-11-04 03:21:19', '2025-03-30 20:43:35', 0),
(93, 'MATEMÁTICA II', 2, 4, 2, 69, 9, 10, '2022-11-04 03:22:09', '2025-03-30 20:42:17', 0),
(94, 'INGLES II', 3, 4, 2, 195, 9, 12, '2022-11-04 03:22:20', '2025-03-30 20:42:32', 0),
(95, 'ESTADÍSTICA', 2, 4, 2, 69, 9, 11, '2022-11-04 03:22:25', '2025-03-30 20:42:26', 0),
(96, 'ESPACIO DE DEFINICION INSTITUCIONAL II', 7, 4, 2, 44, 9, 20, '2022-11-04 03:22:39', '2025-03-30 20:43:42', 0),
(97, 'DERECHO LABORAL', 5, 4, 2, 74, 9, 18, '2022-11-04 03:22:43', '2025-03-30 20:43:26', 0),
(98, 'COMPUTACIÓN II', 1, 4, 2, 194, 9, 13, '2022-11-04 03:22:49', '2025-03-30 20:42:40', 0),
(100, 'PRÁCTICA PROFESIONALIZANTE II', 7, 4, 3, 59, 9, 27, '2022-11-04 03:23:02', '2025-03-30 20:44:41', 0),
(101, 'LIQUIDACIÓN DE SUELDOS Y JORNALES', 7, 4, 3, 59, 9, 22, '2022-11-04 03:23:10', '2025-03-30 20:44:01', 0),
(102, 'INGLÉS III', 3, 4, 3, 28, 9, 21, '2022-11-04 03:23:15', '2025-03-30 20:43:50', 0),
(103, 'ESPACIO DE DEFINICION INSTITUCIONAL III', 7, 4, 3, 73, 9, 28, '2022-11-04 03:23:20', '2025-03-30 20:44:47', 0),
(104, 'DINÁMICA GRUPAL', 7, 4, 3, 66, 9, 24, '2022-11-04 03:23:26', '2025-03-30 20:44:16', 0),
(105, 'COMUNICACIÓN ORGANIZACIONAL', 7, 4, 3, 73, 9, 26, '2022-11-04 03:23:32', '2025-03-30 20:44:33', 0),
(106, 'ADMINISTRACIÓN ESTRATÉGICA DE LOS RRHH', 7, 4, 3, 80, 9, 25, '2022-11-04 03:23:38', '2025-03-30 20:44:25', 0),
(107, 'SELECCION DE PERSONAL, EVALUACIÓN Y CAPACITACIÓN', 7, 4, 3, 44, 9, 23, '2022-11-04 03:23:45', '2025-03-30 20:44:06', 0),
(108, 'SALUD Y PROBLEMÁTICA AMBIENTAL I', 9, 5, 1, 189, 2, 7, '2022-11-04 03:24:02', '2023-10-01 07:55:20', 0),
(109, 'QUÍMICA', 2, 5, 1, 17, 2, 2, '2022-11-04 03:24:09', '2023-10-01 07:53:55', 0),
(110, 'PRÁCTICA PROFESIONAL I', 9, 5, 1, 10, 2, 8, '2022-11-04 03:24:15', '2023-10-29 23:00:29', 0),
(111, 'METODOLOGÍA DE LA INVESTIGACIÓN', 4, 5, 1, 174, 2, 5, '2022-11-04 03:24:22', '2023-10-01 07:54:36', 0),
(112, 'MATEMÁTICA Y ESTADÍSTICA', 2, 5, 1, 9, 2, 4, '2022-11-04 03:24:27', '2023-10-01 07:54:20', 0),
(113, 'BIOLOGÍA', 9, 5, 1, 6, 2, 1, '2022-11-04 03:24:32', '2023-10-01 07:53:27', 0),
(114, 'FÍSICA', 2, 5, 1, 5, 2, 3, '2022-11-04 03:24:37', '2023-10-01 07:54:05', 0),
(115, 'ESPACIO DE DEFINICIÓN INSTITUCIONAL I', 9, 5, 1, 194, 2, 9, '2022-11-04 03:24:45', '2023-10-01 07:55:54', 0),
(116, 'DERECHO AMBIENTAL', 5, 5, 1, 12, 2, 6, '2022-11-04 03:24:53', '2023-10-01 07:54:51', 0),
(117, 'SALUD Y PROBLEMÁTICA AMBIENTAL II (7)', 9, 5, 2, 8, 2, 15, '2022-11-04 03:25:55', '2023-11-29 05:04:31', 0),
(118, 'QUÍMICA DEL AMBIENTE', 9, 5, 2, 193, 2, 13, '2022-11-04 03:26:00', '2023-11-29 05:04:18', 0),
(119, 'PRÁCTICA PROFESIONAL II', 9, 5, 2, 55, 2, 16, '2022-11-04 03:26:06', '2023-11-29 05:08:22', 0),
(120, 'INGLÉS TÉCNICO', 3, 5, 2, 28, 2, 11, '2022-11-04 03:26:11', '2023-10-01 07:56:51', 0),
(121, 'GEOLOGÍA E HIDROLOGÍA', 9, 5, 2, 4, 2, 12, '2022-11-04 03:26:17', '2023-11-29 05:04:11', 0),
(122, 'ESPACIO DE DEFINICIÓN INSTITUCIONAL II', 9, 5, 2, 16, 2, 17, '2022-11-04 03:26:23', '2023-10-01 07:58:30', 0),
(123, 'EPIDEMIOLOGÍA', 9, 5, 2, 8, 2, 14, '2022-11-04 03:26:31', '2023-11-29 05:04:25', 0),
(124, 'ECOLOGÍA', 9, 5, 2, 4, 2, 10, '2022-11-04 03:26:36', '2023-11-29 05:04:00', 0),
(126, 'SEGURIDAD E HIGIENE EN EL TRABAJO', 10, 5, 3, 13, 2, 20, '2022-11-04 03:26:45', '2023-11-29 05:05:06', 0),
(127, 'SALUD Y PROBLEMÁTICA AMBIENTAL III', 9, 5, 3, 170, 2, 22, '2022-11-04 03:26:52', '2023-11-29 05:05:36', 0),
(128, 'PRÁCTICA PROFESIONAL III', 9, 5, 3, 55, 2, 23, '2022-11-04 03:27:00', '2023-11-29 05:05:53', 0),
(129, 'GESTIÓN MEDIO AMBIENTAL', 9, 5, 3, 30, 2, 21, '2022-11-04 03:27:04', '2023-11-29 05:05:30', 0),
(130, 'ESPACIO DE DEFINICIÓN INSTITUCIONAL III', 9, 5, 3, 170, 2, 24, '2022-11-04 03:27:10', '2023-10-01 08:01:13', 0),
(131, 'CONTROL AMBIENTAL', 9, 5, 3, 197, 2, 19, '2022-11-04 03:27:16', '2023-11-29 05:04:57', 0),
(132, 'SOCIOLOGÍA DE LAS ORGANIZACIONES', 4, 5, 3, 202, 2, 18, '2022-11-04 03:27:22', '2023-11-29 05:04:46', 0),
(133, 'SEGURIDAD 1', 10, 6, 1, 72, 3, 7, '2022-11-04 03:27:34', '2023-10-29 23:02:33', 0),
(134, 'QUÍMICA 1', 2, 6, 1, 50, 3, 4, '2022-11-04 03:27:45', '2023-10-29 23:02:09', 0),
(135, 'PSICOLOGÍA LABORAL', 4, 6, 1, 18, 3, 2, '2022-11-04 03:28:27', '2023-10-01 08:02:35', 0),
(136, 'MEDICINA DEL TRABAJO 1', 10, 6, 1, 40, 3, 6, '2022-11-04 03:28:36', '2023-10-29 23:02:25', 0),
(137, 'FÍSICA 1', 2, 6, 1, 17, 3, 3, '2022-11-04 03:28:39', '2023-10-29 23:02:04', 0),
(138, 'MEDIOS DE REPRESENTACIÓN', 10, 6, 1, 168, 3, 5, '2022-11-04 03:28:46', '2023-10-01 08:03:15', 0),
(139, 'DERECHO DEL TRABAJO', 5, 6, 1, 12, 3, 8, '2022-11-04 03:28:52', '2023-10-01 08:03:44', 0),
(141, 'ADMINISTRACIÓN DE LAS ORGANIZACIONES', 4, 6, 1, 167, 3, 1, '2022-11-04 03:28:57', '2023-10-01 08:02:07', 0),
(142, 'PRÁCTICA PROFESIONALIZANTE 1', 10, 6, 1, 72, 3, 9, '2022-11-04 03:29:02', '2023-10-29 23:02:52', 0),
(143, 'SEGURIDAD 2', 10, 6, 2, 65, 3, 15, '2022-11-04 03:29:09', '2023-11-29 05:10:50', 0),
(144, 'QUÍMICA 2', 2, 6, 2, 188, 3, 12, '2022-11-04 03:29:20', '2023-11-29 05:10:37', 0),
(145, 'PRÁCTICA PROFESIONALIZANTE 2', 10, 6, 2, 62, 3, 18, '2022-11-04 03:29:39', '2023-10-29 23:04:05', 0),
(146, 'MEDICINA DEL TRABAJO 2', 10, 6, 2, 40, 3, 17, '2022-11-04 03:32:00', '2023-11-29 05:10:57', 0),
(147, 'INGLÉS TÉCNICO I', 3, 6, 2, 68, 3, 13, '2022-11-04 03:32:11', '2023-10-01 08:05:07', 0),
(148, 'HIGIENE LABORAL Y MEDIO AMBIENTE 1', 10, 6, 2, 170, 3, 16, '2022-11-04 03:32:18', '2023-10-29 23:04:10', 0),
(149, 'FISICA 2 (3)', 2, 6, 2, 169, 3, 11, '2022-11-04 03:32:23', '2023-11-29 05:10:32', 0),
(150, 'ERGONOMÍA', 10, 6, 2, 65, 3, 14, '2022-11-04 03:32:28', '2023-11-29 05:10:43', 0),
(152, 'ESTADÍSTICA', 2, 6, 2, 56, 3, 10, '2022-11-04 03:32:42', '2023-10-01 08:04:26', 0),
(153, 'SEGURIDAD 3', 10, 6, 3, 46, 3, 21, '2022-11-04 03:32:48', '2023-11-29 05:11:18', 0),
(154, 'PRÁCTICA PROFESIONALIZANTE 3', 10, 6, 3, 72, 3, 24, '2022-11-04 03:32:55', '2023-10-29 23:03:57', 0),
(157, 'HIGIENE LABORAL Y MEDIO AMBIENTE 2', 10, 6, 3, 46, 3, 22, '2022-11-04 03:33:29', '2023-11-29 05:11:23', 0),
(159, 'CONTROL DE LA CONTAMINACIÓN', 10, 6, 3, 30, 3, 23, '2022-11-04 03:33:51', '2023-11-29 05:11:27', 0),
(160, 'CAPACITACIÓN DEL PERSONAL', 7, 6, 3, 18, 3, 20, '2022-11-04 03:34:02', '2023-11-29 05:11:13', 0),
(161, 'COMUNICACIÓN ADMINISTRACIÓN DE MEDIOS', 4, 6, 3, 41, 3, 19, '2022-11-04 03:34:07', '2023-11-29 05:11:04', 0),
(184, 'PROBLEMÁTICA TECNOLÓGICA', 4, 8, 1, 41, 4, 1, '2022-11-04 03:41:23', '2023-10-01 08:11:10', 0),
(185, 'METROLOGÍA', 8, 8, 1, 5, 4, 3, '2022-11-04 03:41:27', '2023-10-01 08:11:32', 0),
(186, 'MATEMÁTICA Y ESTADÍSTICA APLICADAS', 2, 8, 1, 9, 4, 9, '2022-11-04 03:41:34', '2023-10-29 23:07:42', 0),
(187, 'INGLÉS I', 3, 8, 1, 68, 4, 6, '2022-11-04 03:41:41', '2023-10-01 08:12:07', 0),
(188, 'FÍSICA APLICADA', 2, 8, 1, 169, 4, 8, '2022-11-04 03:41:45', '2023-10-01 08:12:27', 0),
(189, 'ELEMENTOS DE MÁQUINAS', 8, 8, 1, 5, 4, 2, '2022-11-04 03:41:50', '2023-10-01 08:11:22', 0),
(190, 'ELECTRICIDAD BÁSICA', 8, 8, 1, 188, 4, 7, '2022-11-04 03:41:55', '2023-10-01 08:12:18', 0),
(191, 'CONOCIMIENTO DE MATERIALES', 8, 8, 1, 166, 4, 4, '2022-11-04 03:42:03', '2023-10-01 08:11:46', 0),
(192, 'APLICACIONES COMPUTACIONALES', 1, 8, 1, 37, 4, 5, '2022-11-04 03:42:10', '2023-10-01 08:11:53', 0),
(193, 'SEGURIDAD Y MEDIO AMBIENTE', 10, 8, 1, 65, 4, 10, '2022-11-04 03:42:15', '2023-10-01 08:13:00', 0),
(195, 'MECANIZADO', 8, 8, 2, 166, 4, 16, '2022-11-04 03:42:43', '2023-11-29 05:13:33', 0),
(196, 'MÁQUINAS Y EQUIPOS INDUSTRIALES', 8, 8, 2, 85, 4, 11, '2022-11-04 03:42:49', '2023-11-29 05:13:01', 0),
(197, 'INSTALACIONES Y MÁQUINAS ELÉCTRICAS', 8, 8, 2, 45, 4, 12, '2022-11-04 03:43:00', '2023-11-29 05:13:08', 0),
(198, 'INGLÉS II', 3, 8, 2, 166, 4, 17, '2022-11-04 03:43:05', '2023-11-29 05:13:38', 0),
(199, 'HIDRÁULICA Y NEUMÁTICA', 8, 8, 2, 83, 4, 15, '2022-11-04 03:43:10', '2023-11-29 05:13:28', 0),
(200, 'CONTROL AUTOMÁTICO', 8, 8, 2, 164, 4, 13, '2022-11-04 04:40:28', '2023-11-29 05:13:13', 0),
(201, 'ELECTRONICA', 8, 8, 2, 69, 4, 14, '2022-11-04 04:40:34', '2023-11-29 05:13:19', 0),
(203, 'PROYECTO PARA LA INDUSTRIA', 8, 8, 3, 83, 4, 26, '2022-11-04 04:40:47', '2023-11-29 05:15:04', 0),
(204, 'ORGANIZACIÓN DEL MANTENIMIENTO', 8, 8, 3, 45, 4, 23, '2022-11-04 04:40:52', '2023-11-29 05:14:42', 0),
(205, 'GESTIÓN DE LAS ORGANIZACIONES', 4, 8, 3, 16, 4, 21, '2022-11-04 04:41:00', '2023-11-29 05:14:27', 0),
(206, 'GARANTIA DE CALIDAD', 8, 8, 3, 85, 4, 24, '2022-11-04 04:41:05', '2023-11-29 05:14:52', 0),
(207, 'FILOSOFIA Y GESTION DE MANTENIMIENTO', 8, 8, 3, 85, 4, 20, '2022-11-04 04:41:12', '2023-11-29 05:14:21', 0),
(208, 'ENTRENAMIENTO EN HABILIDADES COMUNICACIONALES', 4, 8, 3, 44, 4, 19, '2022-11-04 04:41:18', '2023-10-01 08:17:28', 0),
(209, 'SEMINARIO DE TEMATICA OPTATIVA', 8, 8, 3, 45, 4, 25, '2022-11-04 04:41:26', '2023-11-29 05:14:59', 0),
(210, 'SOLDADURA', 8, 8, 3, 5, 4, 18, '2022-11-04 04:41:30', '2023-11-29 05:14:15', 0),
(211, 'TÉCNICAS DE MANTENIMIENTO PREVENTIVO Y PREDICTIVO (3-4)', 8, 8, 3, 85, 4, 22, '2022-11-04 04:41:35', '2023-11-29 05:14:34', 0),
(212, 'ANÁLISIS MATEMATICO I', 2, 2, 1, 9, 1, 3, '2022-11-04 05:03:09', '2025-09-18 01:17:03', 0),
(213, 'SEGURIDAD E HIGIENE DEL TRABAJO', 7, 4, 2, 147, 9, 16, '2023-10-01 07:47:00', '2025-03-30 20:43:01', 0),
(215, 'INGLES II', 3, 3, 2, 28, 6, 9, '2025-03-30 20:15:26', '2025-03-30 20:15:26', 0),
(216, 'TECNOLOGÍAS Y SISTEMAS DE LA INFORMACIÓN EN LOGÍSTICA 2 (2° C)', 1, 1, 1, 194, 10, 9, '2025-04-29 20:36:46', '2025-04-29 20:38:48', 0),
(217, 'ESTADÍSTICA  PARA LA LOGÍSTICA (2° C)', 2, 1, 1, 9, 10, 9, '2025-04-29 20:37:21', '2025-04-29 20:38:41', 0),
(218, 'INGLES PARA  LA LOGÍSTICA 2 (2° C)', 3, 1, 1, 28, 10, 9, '2025-04-29 20:37:55', '2025-04-29 20:38:32', 0),
(219, 'METODOLOGIA DE LA INVESTIGACION 2 (2° C)', 4, 1, 1, 189, 10, 9, '2025-04-29 20:39:09', '2025-04-29 20:39:09', 0),
(220, 'ELEMENTOS DE \r\nMATEMATICA', 2, 26, 1, 199, 5, 2, NULL, NULL, 0),
(221, 'COMUNICACIÓN', 4, 26, 1, 200, 5, 9, NULL, NULL, 0),
(222, 'TECNICAS DE\r\nPROGRAMACIÓN', 1, 26, 1, 184, 5, 4, NULL, NULL, 0),
(223, 'LOGICA \r\nCOMPUTACIONAL', 1, 26, 1, 184, 5, 1, NULL, NULL, 0),
(224, 'INGLÉS I', 3, 26, 1, 195, 5, 3, NULL, NULL, 0),
(225, 'ESTADISTICA Y\r\nPROB. PARA \r\nGESTIÓN DE DATOS', 2, 26, 1, 199, 5, 6, NULL, NULL, 0),
(226, 'PRÁCTICA \r\nPROFESIONALIZANTE I', 1, 26, 1, 184, 5, 8, NULL, NULL, 0),
(227, 'ADMIN Y GESTIÓNDE BASE DE DATOS', 1, 26, 1, 184, 5, 5, NULL, '2025-09-09 16:54:06', 0),
(228, 'INGLÉS II', 3, 26, 1, 195, 5, 7, NULL, NULL, 0),
(230, 'Desarrollo de Sistemas de Inteligencia Artificial', 1, 26, 2, NULL, 5, NULL, NULL, NULL, 0),
(231, 'Ciencia de datos', 1, 26, 2, NULL, 5, NULL, NULL, NULL, 0),
(232, 'Seguridad para IOT', 1, 26, 2, NULL, 5, NULL, NULL, NULL, 0),
(233, 'Procesamiento de Aprendizaje Automático', 1, 26, 2, NULL, 5, NULL, NULL, NULL, 0),
(234, 'PP2: Programación para IOT', 1, 26, 2, NULL, 5, NULL, NULL, NULL, 0),
(235, 'Arquitectura del nodo IoT', 1, 26, 2, NULL, 5, NULL, NULL, NULL, 0),
(236, 'Redes, Protocolos e interfaces I', 1, 26, 2, NULL, 5, NULL, NULL, NULL, 0),
(237, 'Redes, protocolos e interfaces II', 1, 26, 2, NULL, 5, NULL, NULL, NULL, 0),
(238, 'Trabajo, Tecnología y Sociedad', 4, 26, 3, NULL, 5, NULL, NULL, NULL, 0),
(239, 'Modelizado de minería de datos', 1, 26, 3, NULL, 5, NULL, NULL, NULL, 0),
(240, 'Inteligencia artificial aplicada a Internet de las Cosas', 1, 26, 3, NULL, 5, NULL, NULL, NULL, 0),
(241, 'Diseño de infraestructura inteligente para el Internet de las Cosas ', 1, 26, 3, NULL, 5, NULL, NULL, NULL, 0),
(242, 'PP3: Análisis y exploración\r\nde datos', 1, 26, 3, NULL, 5, NULL, NULL, NULL, 0),
(243, 'PP4: Implementación de\nsistemas inteligentes sobre\nInternet de las Cosas', 1, 26, 3, NULL, 5, NULL, NULL, NULL, 0),
(244, 'ADMINISTRACIÓN FINANCIERA', 6, 3, 3, NULL, 6, NULL, NULL, NULL, 0),
(245, 'ADMINISTRACIÓN ESTRATÉGICA', 6, 3, 3, NULL, 6, NULL, NULL, NULL, 0),
(246, 'TECNICA IMPOSITIVA Y LABORAL', 6, 3, 3, NULL, 6, NULL, NULL, NULL, 0),
(247, 'REGIMEN TRIBUTARIO\r\n', 6, 3, 3, NULL, 6, NULL, NULL, NULL, 0),
(248, 'GESTIÓN DE ESTADOS CONTABLES', 6, 3, 3, NULL, 6, NULL, NULL, NULL, 0),
(249, 'FINANZAS DE EMPRESAS', 6, 3, 3, NULL, 6, NULL, NULL, NULL, 0),
(250, 'PRÁCTICAS PROFESIONALIZANTES III', 6, 3, 3, NULL, 6, NULL, NULL, NULL, 0),
(251, 'INGLES II', 3, 4, 2, NULL, 8, NULL, NULL, NULL, 0),
(252, 'MATEMÁTICA FINANCIERA', 2, 4, 2, NULL, 8, NULL, NULL, NULL, 0),
(253, 'DERECHO LABORAL Y SEGURIDAD SOCIAL', 5, 4, 2, NULL, 8, NULL, NULL, NULL, 0),
(254, 'PSICOLOGÍA 1', 7, 4, 3, NULL, 8, NULL, NULL, NULL, 0),
(255, 'TECNOLOGÍA Y SISTEMAS DE ADMINISTRACIÓN DE RECURSOS HUMANOS', 7, 4, 2, NULL, 8, NULL, NULL, NULL, 0),
(256, 'SALUD Y SEGURIDAD EN EL TRABAJO', 7, 4, 2, NULL, 8, NULL, NULL, NULL, 0),
(257, 'RELACIONES DEL TRABAJO', 7, 4, 2, NULL, 8, NULL, NULL, NULL, 0),
(258, 'Práctica Profesionalizante 2:\nDiseño de Proyectos de\nAdministración de Recursos\nHumanos', 7, 4, 2, NULL, 8, NULL, NULL, NULL, 0),
(259, 'PSICOLOGÍA 2', 7, 4, 3, NULL, 8, NULL, NULL, NULL, 0),
(260, 'LIQUIDACIÓN DE SUELDO Y JORNALES', 7, 4, 3, NULL, 8, NULL, NULL, NULL, 0),
(261, 'SELECCIÓN DE PERSONAL', 7, 4, 3, NULL, 8, NULL, NULL, NULL, 0),
(262, 'CAPACITACIÓN Y EVALUACIÓN DE DESEMPEÑO', 7, 4, 3, NULL, 8, NULL, NULL, NULL, 0),
(263, 'ADMINISTRACÓN ESTRATÉGICA DE RECURSOS HUMANOS', 7, 4, 3, NULL, 8, NULL, NULL, NULL, 0),
(264, 'COMUNICACIÓN ORGANIZACIONAL', 7, 4, 3, NULL, 8, NULL, NULL, NULL, 0),
(265, 'INGLÉS PARA LA LOGISTA 2', 3, 1, 2, NULL, 10, NULL, NULL, NULL, 0),
(266, 'Tecnologías y\nSistemas de Información\nen Logística 3', 11, 1, 2, NULL, 10, NULL, NULL, NULL, 0),
(267, 'Administración deInventarios y Compras 1', 11, 1, 2, NULL, 10, 0, NULL, '2025-09-19 16:11:06', 1),
(268, 'Procesos de\r\nDistribución en Logística 1', 11, 1, 2, NULL, 10, NULL, NULL, NULL, 0),
(269, 'Logística 1', 11, 1, 2, NULL, 10, NULL, NULL, NULL, 0),
(270, 'PP2: Diseño de Procesos Logísticos', 11, 1, 2, NULL, 10, NULL, NULL, NULL, 0),
(271, 'Tecnologías y\nSistemas de Información\nen Logística 4', 11, 1, 2, NULL, 10, NULL, NULL, NULL, 0),
(272, 'Administración de\r\nInventarios y Compras 2', 11, 1, 2, NULL, 10, NULL, NULL, NULL, 0),
(273, 'Procesos de\r\nDistribución en Logística 2', 11, 1, 2, NULL, 10, NULL, NULL, NULL, 0),
(274, 'Portugués para Logística', 3, 1, 3, NULL, 10, NULL, NULL, NULL, 0),
(275, 'Legislación en logística 1', 5, 1, 3, NULL, 10, NULL, NULL, NULL, 0),
(276, 'Seguridad y Salud\r\nOcupacional en Logística', 11, 1, 3, NULL, 10, NULL, NULL, NULL, 0),
(277, 'Gestión de la Calidad\r\nen Logística 1', 11, 1, 3, NULL, 10, NULL, NULL, NULL, 0),
(278, 'Logística 2', 11, 1, 3, NULL, 10, NULL, NULL, NULL, 0),
(281, 'PP3: Gestión de Proyectos de Logística', 11, 1, 3, NULL, 10, NULL, NULL, NULL, 0),
(282, 'Práctica Profesionalizante 3: Gestión de proyectos de administración de Recursos Humanos', 7, 4, 3, NULL, 8, NULL, NULL, NULL, 0),
(294, 'Gestión de la calidad en logística 2', 11, 1, 3, NULL, 10, NULL, NULL, NULL, 0),
(295, 'Seguridad y Ambiente en Logística (2C)', 11, 1, 3, NULL, 10, NULL, NULL, NULL, 0),
(296, 'Legislación en Logística 2', 11, 1, 3, NULL, 10, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mesas`
--

CREATE TABLE `mesas` (
  `id` int NOT NULL,
  `materia_id` int NOT NULL,
  `carrera_id` int NOT NULL,
  `anio_id` int NOT NULL,
  `profesor_id` int DEFAULT NULL,
  `vocal_id` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `horario` time NOT NULL,
  `comision` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `resolucion_id` bigint UNSIGNED DEFAULT NULL,
  `inscriptos` int UNSIGNED DEFAULT '0',
  `salon` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `salon_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `mesas`
--

INSERT INTO `mesas` (`id`, `materia_id`, `carrera_id`, `anio_id`, `profesor_id`, `vocal_id`, `fecha`, `horario`, `comision`, `resolucion_id`, `inscriptos`, `salon`, `salon_id`) VALUES
(1, 38, 1, 2, 16, 29, '2025-10-06', '18:00:00', 'A', 11, 7, NULL, 32),
(2, 40, 1, 2, 29, 14, '2025-10-07', '18:00:00', 'A', 11, 2, NULL, 32),
(3, 39, 1, 2, 14, 16, '2025-10-08', '18:00:00', 'A', 11, 10, NULL, 32),
(4, 37, 1, 2, 11, 14, '2025-10-15', '18:00:00', 'A', 11, 4, NULL, 32),
(5, 35, 1, 2, 195, 11, '2025-10-09', '18:00:00', 'A', 11, 8, NULL, 32),
(6, 41, 1, 2, 35, 41, '2025-10-16', '18:00:00', 'A', 11, 7, NULL, 32),
(7, 34, 1, 2, 29, 29, '2025-10-10', '18:00:00', 'A', 11, 2, NULL, 32),
(8, 47, 1, 3, 29, 187, '2025-10-06', '18:00:00', 'A', 11, 6, NULL, 32),
(9, 45, 1, 3, 29, 16, '2025-10-13', '18:00:00', 'A', 11, 5, NULL, 32),
(10, 42, 1, 3, 13, 62, '2025-10-08', '18:00:00', 'A', 11, 8, NULL, 32),
(11, 55, 3, 1, 52, 74, '2025-10-08', '18:00:00', 'A', 6, 3, NULL, 18),
(12, 56, 3, 1, 55, 84, '2025-10-15', '18:00:00', 'A', 6, 3, NULL, 18),
(13, 51, 3, 1, 55, 82, '2025-10-10', '18:00:00', 'A', 6, 3, NULL, 18),
(14, 48, 3, 1, 82, 55, '2025-10-17', '18:00:00', 'A', 6, 4, NULL, 18),
(15, 67, 3, 2, 55, 187, '2025-10-06', '18:00:00', 'A', 6, 3, NULL, 18),
(16, 61, 3, 2, 56, 196, '2025-10-07', '18:00:00', 'A', 6, 2, NULL, 18),
(17, 66, 3, 2, 74, 81, '2025-10-08', '18:00:00', 'A', 6, 3, NULL, 18),
(18, 68, 3, 2, 20, 184, '2025-10-09', '18:00:00', 'A', 6, 5, NULL, 18),
(19, 77, 3, 3, 82, 55, '2025-10-06', '18:00:00', 'A', 7, 5, NULL, 18),
(20, 74, 3, 3, 42, 82, '2025-10-07', '18:00:00', 'A', 7, 9, NULL, 18),
(21, 73, 3, 3, 82, 42, '2025-10-14', '18:00:00', 'A', 7, 10, NULL, 18),
(22, 72, 3, 3, 55, 84, '2025-10-08', '18:00:00', 'A', 7, 4, NULL, 18),
(23, 69, 3, 3, 84, 55, '2025-10-15', '18:00:00', 'A', 7, 10, NULL, 18),
(24, 76, 3, 3, 55, 47, '2025-10-09', '18:00:00', 'A', 7, 5, NULL, 18),
(25, 78, 3, 3, 82, 55, '2025-10-10', '18:00:00', 'A', 7, 8, NULL, 18),
(26, 87, 4, 1, 18, 73, '2025-10-06', '18:00:00', 'A', 8, 2, NULL, 20),
(27, 85, 4, 1, 55, 12, '2025-10-07', '18:00:00', 'A', 8, 6, NULL, 20),
(28, 86, 4, 1, 37, 18, '2025-10-10', '18:00:00', 'A', 8, 3, NULL, 20),
(29, 79, 4, 1, 66, 37, '2025-10-17', '18:00:00', 'A', 8, 6, NULL, 20),
(30, 98, 4, 2, 194, 182, '2025-10-06', '18:00:00', 'A', 9, 3, NULL, 20),
(31, 90, 4, 2, 12, 55, '2025-10-07', '18:00:00', 'A', 9, 6, NULL, 20),
(32, 89, 4, 2, 12, 174, '2025-10-14', '18:00:00', 'A', 9, 10, NULL, 20),
(33, 96, 4, 2, 44, 80, '2025-10-09', '18:00:00', 'A', 9, 3, NULL, 20),
(34, 93, 4, 2, 69, 91, '2025-10-10', '18:00:00', 'A', 9, 1, NULL, 20),
(35, 95, 4, 2, 69, 91, '2025-10-17', '18:00:00', 'A', 9, 8, NULL, 20),
(36, 103, 4, 3, 73, 18, '2025-10-06', '18:00:00', 'A', 9, 8, NULL, 20),
(37, 105, 4, 3, 73, 147, '2025-10-08', '18:00:00', 'A', 9, 4, NULL, 20),
(38, 106, 4, 3, 80, 44, '2025-10-09', '18:00:00', 'A', 9, 6, NULL, 20),
(39, 101, 4, 3, 59, 175, '2025-10-16', '18:00:00', 'A', 9, 6, NULL, 20),
(40, 107, 4, 3, 44, 37, '2025-10-10', '18:00:00', 'A', 9, 3, NULL, 20),
(41, 104, 4, 3, 66, 37, '2025-10-17', '18:00:00', 'A', 9, 5, NULL, 20),
(42, 112, 5, 1, 9, 188, '2025-10-07', '18:00:00', 'A', 2, 6, NULL, 17),
(43, 109, 5, 1, 17, 9, '2025-10-08', '18:00:00', 'A', 2, 6, NULL, 17),
(44, 114, 5, 1, 5, 9, '2025-10-15', '18:00:00', 'A', 2, 2, NULL, 17),
(45, 116, 5, 1, 12, 195, '2025-10-09', '18:00:00', 'A', 2, 9, NULL, 21),
(46, 113, 5, 1, 6, 4, '2025-10-16', '18:00:00', 'A', 2, 10, NULL, 21),
(47, 124, 5, 2, 4, 170, '2025-10-06', '18:00:00', 'A', 2, 3, NULL, 17),
(48, 123, 5, 2, 8, 170, '2025-10-08', '18:00:00', 'A', 2, 2, NULL, 17),
(49, 117, 5, 2, 8, 170, '2025-10-15', '18:00:00', 'A', 2, 2, NULL, 17),
(50, 121, 5, 2, 4, 6, '2025-10-09', '18:00:00', 'A', 2, 2, NULL, 17),
(51, 122, 5, 2, 16, 189, '2025-10-13', '18:00:00', 'A', 2, 6, NULL, 17),
(52, 126, 5, 3, 13, 72, '2025-10-07', '18:00:00', 'A', 2, 4, NULL, 17),
(53, 131, 5, 3, 197, 193, '2025-10-14', '18:00:00', 'A', 2, 2, NULL, 17),
(54, 132, 5, 3, 202, 18, '2025-10-08', '18:00:00', 'A', 2, 7, NULL, 17),
(55, 129, 5, 3, 30, 8, '2025-10-15', '18:00:00', 'A', 2, 8, NULL, 21),
(56, 136, 6, 1, 40, 65, '2025-10-06', '18:00:00', 'A', 3, 8, NULL, 19),
(57, 136, 6, 1, 40, 72, '2025-10-08', '18:00:00', 'B', 3, 4, NULL, 19),
(58, 141, 6, 1, 167, 41, '2025-10-09', '18:00:00', 'A', 3, 8, NULL, 19),
(59, 141, 6, 1, 167, 200, '2025-10-06', '18:00:00', 'B', 3, 7, NULL, 19),
(60, 137, 6, 1, 17, 9, '2025-10-13', '18:00:00', 'A', 3, 10, NULL, 19),
(61, 137, 6, 1, 17, 201, '2025-10-09', '18:00:00', 'B', 3, 7, NULL, 19),
(62, 139, 6, 1, 12, 53, '2025-10-10', '18:00:00', 'A', 3, 6, NULL, 19),
(63, 139, 6, 1, 12, 16, '2025-10-13', '18:00:00', 'B', 3, 10, NULL, 19),
(64, 133, 6, 1, 72, 40, '2025-10-08', '18:00:00', 'A', 3, 1, NULL, 19),
(65, 133, 6, 1, 72, 46, '2025-10-07', '18:00:00', 'B', 3, 3, NULL, 19),
(66, 135, 6, 1, 18, 174, '2025-10-07', '18:00:00', 'A', 3, 2, NULL, 19),
(67, 135, 6, 1, 18, 202, '2025-10-15', '18:00:00', 'B', 3, 9, NULL, 19),
(68, 134, 6, 1, 50, 9, '2025-10-14', '18:00:00', 'A', 3, 8, NULL, 19),
(69, 134, 6, 1, 50, 69, '2025-10-10', '18:00:00', 'B', 3, 3, NULL, 19),
(70, 138, 6, 1, 168, 30, '2025-10-17', '18:00:00', 'A', 3, 1, NULL, 19),
(71, 138, 6, 1, 168, 30, '2025-10-17', '18:00:00', 'B', 3, 5, NULL, 19),
(72, 152, 6, 2, 56, 199, '2025-10-06', '18:00:00', 'A', 3, 3, NULL, 19),
(73, 152, 6, 2, 56, 199, '2025-10-06', '18:00:00', 'B', 3, 10, NULL, 19),
(74, 149, 6, 2, 169, 199, '2025-10-13', '18:00:00', 'A', 3, 9, NULL, 19),
(75, 149, 6, 2, 169, 50, '2025-10-10', '18:00:00', 'B', 3, 6, NULL, 19),
(76, 144, 6, 2, 188, 9, '2025-10-07', '18:00:00', 'A', 3, 10, NULL, 19),
(77, 144, 6, 2, 188, 9, '2025-10-07', '18:00:00', 'B', 3, 1, NULL, 19),
(78, 147, 6, 2, 68, 28, '2025-10-14', '18:00:00', 'A', 3, 6, NULL, 19),
(79, 147, 6, 2, 68, 28, '2025-10-14', '18:00:00', 'B', 3, 8, NULL, 19),
(80, 146, 6, 2, 40, 62, '2025-10-09', '18:00:00', 'A', 3, 10, NULL, 19),
(81, 146, 6, 2, 40, 72, '2025-10-08', '18:00:00', 'B', 3, 7, NULL, 19),
(82, 143, 6, 2, 65, 170, '2025-10-10', '18:00:00', 'A', 3, 3, NULL, 19),
(83, 143, 6, 2, 65, 40, '2025-10-09', '18:00:00', 'B', 3, 5, NULL, 19),
(84, 150, 6, 2, 65, 62, '2025-10-16', '18:00:00', 'A', 3, 3, NULL, 19),
(85, 150, 6, 2, 65, 40, '2025-10-13', '18:00:00', 'B', 3, 1, NULL, 19),
(86, 153, 6, 3, 46, 62, '2025-10-08', '18:00:00', 'B', 3, 4, NULL, 19),
(87, 160, 6, 3, 18, 37, '2025-10-10', '18:00:00', 'B', 3, 9, NULL, 19),
(88, 161, 6, 3, 41, 35, '2025-10-09', '18:00:00', 'B', 3, 1, NULL, 19),
(89, 159, 6, 3, 30, 168, '2025-10-17', '18:00:00', 'B', 3, 6, NULL, 19),
(90, 189, 8, 1, 5, 69, '2025-10-06', '18:00:00', 'A', 4, 9, NULL, 24),
(91, 185, 8, 1, 5, 45, '2025-10-13', '18:00:00', 'A', 4, 4, NULL, 24),
(92, 187, 8, 1, 68, 28, '2025-10-07', '18:00:00', 'A', 4, 4, NULL, 24),
(93, 192, 8, 1, 37, 87, '2025-10-14', '18:00:00', 'A', 4, 5, NULL, 24),
(94, 186, 8, 1, 9, 199, '2025-10-08', '18:00:00', 'A', 4, 5, NULL, 24),
(95, 184, 8, 1, 41, 35, '2025-10-09', '18:00:00', 'A', 4, 9, NULL, 24),
(96, 193, 8, 1, 65, 170, '2025-10-10', '18:00:00', 'A', 4, 10, NULL, 24),
(97, 190, 8, 1, 188, 164, '2025-10-17', '18:00:00', 'A', 4, 2, NULL, 24),
(98, 201, 8, 2, 69, 45, '2025-10-06', '18:00:00', 'A', 4, 10, NULL, 24),
(99, 196, 8, 2, 85, 166, '2025-10-07', '18:00:00', 'A', 4, 3, NULL, 24),
(100, 198, 8, 2, 166, 195, '2025-10-08', '18:00:00', 'A', 4, 5, NULL, 24),
(101, 197, 8, 2, 45, 83, '2025-10-15', '18:00:00', 'A', 4, 3, NULL, 24),
(102, 200, 8, 2, 164, 166, '2025-10-09', '18:00:00', 'A', 4, 2, NULL, 24),
(103, 199, 8, 2, 83, 188, '2025-10-10', '18:00:00', 'A', 4, 9, NULL, 24),
(104, 209, 8, 3, 45, 69, '2025-10-06', '18:00:00', 'A', 4, 1, NULL, 24),
(105, 208, 8, 3, 44, 37, '2025-10-10', '18:00:00', 'A', 4, 5, NULL, 24),
(106, 211, 8, 3, 85, 166, '2025-10-07', '18:00:00', 'A', 4, 4, NULL, 24),
(107, 203, 8, 3, 83, 166, '2025-10-14', '18:00:00', 'A', 4, 3, NULL, 24),
(108, 206, 8, 3, 85, 83, '2025-10-08', '18:00:00', 'A', 4, 1, NULL, 24),
(109, 207, 8, 3, 85, 45, '2025-10-15', '18:00:00', 'A', 4, 7, NULL, 24),
(110, 205, 8, 3, 16, 189, '2025-10-17', '18:00:00', 'A', 4, 1, NULL, 24),
(111, 204, 8, 3, 45, 5, '2025-10-13', '18:00:00', 'A', 4, 2, NULL, 24),
(112, 210, 8, 3, 5, 164, '2025-10-10', '18:00:00', 'A', 4, 6, NULL, 24),
(113, 3, 2, 1, 77, 176, '2025-10-06', '18:00:00', 'A', 1, 5, NULL, 25),
(114, 6, 2, 1, 146, 164, '2025-10-13', '18:00:00', 'A', 1, 6, NULL, 25),
(115, 4, 2, 1, 164, 37, '2025-10-07', '18:00:00', 'A', 1, 7, NULL, 37),
(116, 212, 2, 1, 9, 196, '2025-10-14', '18:00:00', 'A', 1, 4, NULL, 25),
(117, 8, 2, 1, 15, 182, '2025-10-08', '18:00:00', 'A', 1, 9, NULL, 25),
(118, 7, 2, 1, 91, 169, '2025-10-10', '18:00:00', 'A', 1, 3, NULL, 25),
(119, 9, 2, 2, 164, 45, '2025-10-06', '18:00:00', 'A', 1, 7, NULL, 37),
(120, 14, 2, 2, 196, 50, '2025-10-07', '18:00:00', 'A', 1, 8, NULL, 25),
(121, 188, 8, 1, 169, 9, '2025-10-16', '18:00:00', 'A', 4, 6, NULL, 24),
(122, 191, 8, 1, 166, 83, '2025-10-09', '18:00:00', 'A', 4, 6, NULL, 24),
(123, 195, 8, 2, 166, 45, '2025-10-13', '18:00:00', 'A', 4, 1, NULL, 24),
(124, 148, 6, 2, 170, 30, '2025-10-17', '18:00:00', 'A', 3, 5, NULL, 19),
(125, 148, 6, 2, 170, 40, '2025-10-15', '18:00:00', 'B', 3, 3, NULL, 19),
(126, 157, 6, 3, 46, 72, '2025-10-07', '18:00:00', 'B', 3, 1, NULL, 19),
(127, 81, 4, 1, 28, 68, '2025-10-14', '18:00:00', 'A', 8, 4, NULL, 20),
(128, 84, 4, 1, 81, 52, '2025-10-08', '18:00:00', 'A', 8, 7, NULL, 20),
(129, 83, 4, 1, 173, 199, '2025-10-13', '18:00:00', 'A', 8, 4, NULL, 20),
(130, 91, 4, 2, 176, 200, '2025-10-13', '18:00:00', 'A', 9, 8, NULL, 20),
(131, 94, 4, 2, 195, 28, '2025-10-10', '18:00:00', 'A', 9, 5, NULL, 20),
(132, 213, 4, 2, 147, 73, '2025-10-08', '18:00:00', 'A', 9, 2, NULL, 20),
(133, 102, 4, 3, 28, 195, '2025-10-15', '18:00:00', 'A', 9, 3, NULL, 20),
(134, 36, 1, 2, 146, 164, '2025-10-13', '18:00:00', 'A', 11, 9, NULL, 32),
(135, 44, 1, 3, 11, 28, '2025-10-09', '18:00:00', 'A', 11, 5, NULL, 32),
(136, 46, 1, 3, 53, 12, '2025-10-10', '18:00:00', 'A', 11, 7, NULL, 32),
(137, 108, 5, 1, 189, 4, '2025-10-06', '18:00:00', 'A', 2, 9, NULL, 21),
(138, 111, 5, 1, 174, 18, '2025-10-14', '18:00:00', 'A', 2, 5, NULL, 17),
(139, 115, 5, 1, 194, 55, '2025-10-13', '18:00:00', 'A', 2, 6, NULL, 17),
(140, 118, 5, 2, 193, 197, '2025-10-07', '18:00:00', 'A', 2, 7, NULL, 17),
(141, 120, 5, 2, 28, 195, '2025-10-10', '18:00:00', 'A', 2, 4, NULL, 17),
(142, 130, 5, 3, 170, 194, '2025-10-06', '18:00:00', 'A', 2, 10, NULL, 21),
(143, 127, 5, 3, 170, 8, '2025-10-08', '18:00:00', 'A', 2, 5, NULL, 17),
(144, 5, 2, 1, 28, 195, '2025-10-09', '18:00:00', 'A', 1, 8, NULL, 25),
(145, 10, 2, 2, 87, 194, '2025-10-14', '18:00:00', 'A', 1, 2, NULL, 37),
(146, 11, 2, 2, 184, 32, '2025-10-08', '18:00:00', 'A', 1, 7, NULL, 25),
(147, 15, 2, 2, 182, 164, '2025-10-15', '18:00:00', 'A', 1, 8, NULL, 25),
(148, 12, 2, 2, 9, 17, '2025-10-09', '18:00:00', 'A', 1, 7, NULL, 25),
(149, 16, 2, 2, 195, 28, '2025-10-16', '18:00:00', 'A', 1, 2, NULL, 25),
(150, 18, 2, 3, 15, 194, '2025-10-06', '18:00:00', 'A', 1, 9, NULL, 25),
(151, 19, 2, 3, 45, 5, '2025-10-13', '18:00:00', 'A', 1, 9, NULL, 25),
(152, 21, 2, 3, 185, 193, '2025-10-07', '18:00:00', 'A', 1, 8, NULL, 25),
(153, 20, 2, 3, 87, 194, '2025-10-14', '18:00:00', 'A', 1, 2, NULL, 37),
(154, 22, 2, 3, 184, 32, '2025-10-08', '18:00:00', 'A', 1, 7, NULL, 25),
(155, 23, 2, 3, 68, 28, '2025-10-10', '18:00:00', 'A', 1, 8, NULL, 25),
(156, 53, 3, 1, 187, 55, '2025-10-06', '18:00:00', 'A', 6, 8, NULL, 18),
(157, 50, 3, 1, 56, 196, '2025-10-07', '18:00:00', 'A', 6, 6, NULL, 18),
(158, 65, 3, 2, 52, 74, '2025-10-15', '18:00:00', 'A', 6, 7, NULL, 18),
(159, 60, 3, 2, 201, 17, '2025-10-16', '18:00:00', 'A', 6, 4, NULL, 18),
(160, 63, 3, 2, 27, 42, '2025-10-14', '18:00:00', 'A', 6, 10, NULL, 18),
(161, 62, 3, 1, 28, 195, '2025-10-10', '18:00:00', 'A', 6, 9, NULL, 18),
(162, 71, 3, 3, 28, 12, '2025-10-13', '18:00:00', 'A', 7, 2, NULL, 18),
(163, 97, 4, 2, 74, 52, '2025-10-15', '18:00:00', 'A', 9, 4, NULL, 20),
(164, 80, 4, 1, 175, 80, '2025-10-09', '18:00:00', 'A', 8, 4, NULL, 20),
(165, 27, 1, 1, 16, 29, '2025-10-06', '18:00:00', 'A', 10, 5, NULL, 32),
(166, 28, 1, 1, 187, 29, '2025-10-13', '18:00:00', 'A', 10, 4, NULL, 32),
(167, 29, 1, 1, 16, 14, '2025-10-07', '18:00:00', 'A', 10, 3, NULL, 32),
(168, 26, 1, 1, 194, 37, '2025-10-14', '18:00:00', 'A', 10, 4, NULL, 32),
(169, 32, 1, 1, 9, 199, '2025-10-08', '18:00:00', 'A', 10, 2, NULL, 32),
(170, 24, 1, 1, 28, 195, '2025-10-09', '18:00:00', 'A', 10, 5, NULL, 32),
(171, 25, 1, 1, 189, 44, '2025-10-10', '18:00:00', 'A', 10, 9, NULL, 32),
(172, 215, 3, 2, 28, 195, '2025-10-10', '18:00:00', 'A', 6, 8, NULL, 18),
(173, 216, 1, 1, 194, 184, '2025-10-07', '18:00:00', 'A', 10, 3, NULL, 32),
(174, 220, 26, 1, 199, 17, '2025-10-06', '18:00:00', 'A', 5, 1, NULL, 23),
(175, 221, 26, 1, 200, 176, '2025-10-13', '18:00:00', 'A', 5, 5, NULL, 23),
(176, 222, 26, 1, 184, 194, '2025-10-07', '18:00:00', 'A', 5, 3, NULL, 23),
(177, 223, 26, 1, 184, 87, '2025-10-14', '18:00:00', 'A', 5, 7, NULL, 23),
(178, 224, 26, 1, 195, 28, '2025-10-08', '18:00:00', 'A', 5, 7, NULL, 23),
(179, 225, 26, 1, 199, 17, '2025-10-06', '18:00:00', 'A', 5, 3, NULL, 23),
(180, 227, 26, 1, 184, 194, '2025-10-07', '18:00:00', 'A', 5, 2, NULL, 23),
(181, 228, 26, 1, 195, 166, '2025-10-15', '18:00:00', 'A', 5, 1, NULL, 23),
(182, 31, 1, 1, 187, 55, '2025-10-06', '18:00:00', 'A', 10, 3, NULL, 32),
(183, 217, 1, 1, 9, 169, '2025-10-06', '18:00:00', 'A', 10, 7, NULL, 32),
(184, 219, 1, 1, 189, 44, '2025-10-17', '18:00:00', 'A', 10, 1, NULL, 32);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2025_06_15_210947_create_presidentes_table', 1),
(4, '2025_09_04_003308_create_configuraciones_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `modalidades`
--

CREATE TABLE `modalidades` (
  `id` tinyint UNSIGNED NOT NULL,
  `nombre` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `modalidades`
--

INSERT INTO `modalidades` (`id`, `nombre`) VALUES
(1, 'ANUAL'),
(2, 'CUATRIMESTRAL');

-- --------------------------------------------------------

--
-- Table structure for table `modalidad_trabajos`
--

CREATE TABLE `modalidad_trabajos` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modalidad_trabajos`
--

INSERT INTO `modalidad_trabajos` (`id`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'Presencial', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 'Remoto', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(3, 'Híbrido', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(4, 'Práctica Profesional', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(5, 'Freelance', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(6, 'Eventual', '2025-09-24 11:13:28', '2025-09-24 11:13:28');

-- --------------------------------------------------------

--
-- Table structure for table `modulos`
--

CREATE TABLE `modulos` (
  `id` bigint UNSIGNED NOT NULL,
  `horainicio` time NOT NULL,
  `horafin` time NOT NULL,
  `duracion` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `modulos`
--

INSERT INTO `modulos` (`id`, `horainicio`, `horafin`, `duracion`, `created_at`, `updated_at`) VALUES
(1, '17:45:00', '18:45:00', 60, NULL, NULL),
(2, '18:45:00', '19:45:00', 60, NULL, NULL),
(3, '20:00:00', '21:00:00', 60, NULL, NULL),
(4, '21:00:00', '22:00:00', 60, NULL, NULL),
(5, '16:45:00', '17:45:00', 60, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `noticias`
--

CREATE TABLE `noticias` (
  `id` bigint UNSIGNED NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `cuerpo` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `imagen` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `imagen2` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `autor` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `archivo1` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `archivo2` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `archivo3` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `cuerpo`, `imagen`, `imagen2`, `created_at`, `updated_at`, `carrera_id`, `autor`, `deleted_at`, `archivo1`, `archivo2`, `archivo3`) VALUES
(4, 'ISFT N° 38', '<!-- Inscripciones 2024 -->\r\n<!-- <a href=\"http://dev.isft38.edu.ar/inscripciones\" class=\"news d-none d-md-block btn btn-success\" target=\"blank\"><b>Turnos Ingreso</b></a> -->', 'noticias/4/descarga.jfif', NULL, '2022-09-29 18:17:10', '2024-11-08 08:06:41', 2, 1, '2024-11-08 08:06:41', NULL, NULL, NULL),
(5, 'Mesas de examen', 'Comienzan el 7/11\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'noticias/5/mesas-2022.jpg', NULL, '2022-10-29 15:56:10', '2022-11-11 22:03:52', 2, 1, '2022-11-11 22:03:52', 'noticias/5/Nuevo Documento de Microsoft Word.docx', NULL, NULL),
(6, 'Oferta académica', '<a href=\"http://dev.isft38.edu.ar/carreras\"  class=\"btn btn-success\" >\r\n<b>Conocé nuestras carreras</b>\r\n</a><br/><br/>', 'noticias/6/inscripciones-abiertas.jpg', NULL, '2022-11-11 22:03:17', '2024-11-08 08:08:20', 2, 1, '2024-11-08 08:08:20', 'noticias/6/Oferta-Academica-1024x570-1.jpg', NULL, NULL),
(7, 'Mesas de Examen Julio/Agosto', '<p>Inscripciones abiertas hasta el 28/Junio 22hs.\r\n<a href=\"https://docs.google.com/document/d/1jGuYass-Afd-fVobzFuCQeIX6Kptv79OOMpLEICJjO0/edit?usp=sharing\">https://docs.google.com/document/d/1jGuYass-Afd-fVobzFuCQeIX6Kptv79OOMpLEICJjO0/edit?usp=sharing</a></p>', 'noticias/7/mesas-de-examen-1-scaled.jpg', NULL, '2022-11-11 22:08:59', '2024-11-08 08:08:29', 2, 1, '2024-11-08 08:08:29', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `noticias_etiquetas`
--

CREATE TABLE `noticias_etiquetas` (
  `noticia_id` bigint UNSIGNED NOT NULL,
  `etiqueta_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `noticias_etiquetas`
--

INSERT INTO `noticias_etiquetas` (`noticia_id`, `etiqueta_id`, `user_id`, `created_at`, `updated_at`) VALUES
(13, 23, 12, '2025-03-24 09:53:52', '2025-03-24 09:53:52'),
(12, 23, 12, '2025-03-24 09:54:40', '2025-03-24 09:54:40');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `objetivos`
--

CREATE TABLE `objetivos` (
  `id` bigint UNSIGNED NOT NULL,
  `objetivo` varchar(5000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sede_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `objetivos`
--

INSERT INTO `objetivos` (`id`, `objetivo`, `sede_id`, `created_at`, `updated_at`) VALUES
(1, '<p class=\"MsoNormal\"><b><u><span lang=\"es\" style=\"font-size:14.0pt;line-height:115%\">Labor Pedagógica</span></u></b></p><p class=\"MsoNormal\"><b><u><span lang=\"es\" style=\"font-size:14.0pt;line-height:115%\"><br></span></u></b><span style=\"background-color: var(--bs-card-bg); font-size: 14pt; font-weight: var(--bs-body-font-weight); text-align: justify;\">Actualmente la\r\nactividad pedagógica se centra en el diseño de la Educación&nbsp; Técnicos Superior.</span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><b><span lang=\"es\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\r\n\" comic=\"\" sans=\"\" ms\"\"=\"\">MISIÓN</span></b><span lang=\"es\" style=\"font-size:14.0pt;\r\nline-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\"\"=\"\">: Cumplir con\r\nservicio educativo acorde a las necesidades de la zona de actuación y los\r\nobjetivos generales de la Educación Superior Técnica en la Provincia de Buenos\r\nAires <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"es\" style=\"font-size:\r\n14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\"\"=\"\">&nbsp;</span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><b><span lang=\"es\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\r\n\" comic=\"\" sans=\"\" ms\"\"=\"\">Objetivos: <o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"es\" style=\"font-size:\r\n14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\"\"=\"\">Proporcionar a\r\nnuestros estudiantes una adecuada orientación personal y&nbsp; profesional en función &nbsp;de los requerimientos de la Empresa, de la\r\nCiudad, la zona y la región <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"es\" style=\"font-size:\r\n14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\"\"=\"\">Proporcionar formación\r\nespecializada y de carácter interdisciplinario en las diferentes áreas de la\r\nCiencia y la Tecnología.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"es\" style=\"font-size:\r\n14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\"\"=\"\">Promover la capacitación,\r\nactualización y especialización Técnico Profesional.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"es\" style=\"font-size:\r\n14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\"\"=\"\">Acceder a un\r\npermanente incremento de los niveles de calidad y eficiencia de la Educación Técnico\r\nSuperior<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"es\" style=\"font-size:\r\n14.0pt;line-height:115%;mso-fareast-font-family:\" comic=\"\" sans=\"\" ms\"\"=\"\">Formar\r\nprofesionales capacitados para insertarse y competir en el mercado laboral con\r\nun alto nivel de compromiso y responsabilidad<b><u><o:p></o:p></u></b></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify\"><b><span lang=\"es\" style=\"font-size:14.0pt;line-height:115%;mso-fareast-font-family:\r\n\" comic=\"\" sans=\"\" ms\"\"=\"\">&nbsp;</span></b></p>', 1, NULL, '2023-02-25 01:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `ofertas`
--

CREATE TABLE `ofertas` (
  `id` bigint UNSIGNED NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ubicacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `modalidad_id` bigint UNSIGNED DEFAULT NULL,
  `horario_id` bigint UNSIGNED DEFAULT NULL,
  `salario` int DEFAULT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `año_academico_id` bigint UNSIGNED DEFAULT NULL,
  `estado_id` bigint UNSIGNED DEFAULT NULL,
  `años_experiencia` int DEFAULT NULL,
  `fecha_expiracion` datetime DEFAULT NULL,
  `imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `ofertas`
--

INSERT INTO `ofertas` (`id`, `titulo`, `empresa`, `descripcion`, `ubicacion`, `modalidad_id`, `horario_id`, `salario`, `carrera_id`, `año_academico_id`, `estado_id`, `años_experiencia`, `fecha_expiracion`, `imagen`, `created_at`, `updated_at`) VALUES
(1, 'explicabo', 'Mercado S. de H.', 'Optio esse totam et. Ea vel cumque et iure suscipit. Fugiat est sapiente voluptas iste. Qui et assumenda placeat aut nihil eos. Hic consequuntur ut aperiam in.', 'Sergio del Mirador', 3, 2, 478034, 6, 2, 1, 2, '2025-10-08 20:28:11', NULL, '2025-09-20 16:34:18', '2025-09-24 11:13:28'),
(2, 'et', 'Montemayor-Valdés', 'Repudiandae id ex consequatur dolorem ut odit. Dolorum ut hic omnis laudantium. Impedit libero provident ut consectetur quaerat non aut. Excepturi sint distinctio enim. Odio sunt ab esse maxime quo maxime adipisci. Eveniet velit consequatur modi esse aut et. Eaque velit ratione harum saepe deleniti saepe provident. Qui aliquam sit et.', 'Alex del Mirador', 3, 3, 318025, 2, 1, 1, 6, '2025-10-23 07:40:33', NULL, '2025-09-20 20:39:52', '2025-09-24 11:13:28'),
(3, 'a', 'Maldonado de Balderas', 'Deleniti ut est sequi et consequatur harum ab qui. Dolorum sed officia fugiat saepe nostrum voluptas. Totam architecto mollitia dicta delectus aliquid ut aperiam ducimus. Voluptatem ipsam exercitationem aperiam labore et. Nulla ipsam aut veniam ad repellat reprehenderit. Aut rerum nihil deserunt.', 'Lucía del Este', 1, 2, 180187, 4, 2, 1, 6, '2025-10-15 23:16:55', NULL, '2025-09-24 00:20:02', '2025-09-24 11:13:28'),
(4, 'veniam', 'Reyes-Caballero', 'Fugit facere sequi illo facere ipsa iure nemo. Ex quis architecto quia dolores totam. Cumque assumenda excepturi molestias veniam. Pariatur et accusantium sit facilis eos autem qui. Occaecati et minima rerum id. Provident nesciunt modi consectetur. Quis omnis nobis vero autem. Soluta molestias aut laborum quis fugit.', 'Nahuel del Mar', 6, 3, 362829, 6, 1, 1, 6, '2025-10-16 12:33:11', NULL, '2025-09-24 06:26:27', '2025-09-24 11:13:28'),
(6, 'dolores', 'Bustos-Badillo', 'Dolores voluptatem ut eum qui occaecati ad recusandae placeat. Neque tempore reprehenderit ab necessitatibus suscipit et enim culpa. Consequatur officia eligendi inventore aut. Sunt expedita omnis in officiis ratione. Eum quis provident alias expedita recusandae dolorum. Soluta magni debitis ipsum in.', 'Pablo del Sur', 3, 1, 426443, 5, 2, 1, 9, '2025-11-04 22:22:25', NULL, '2025-09-18 14:07:30', '2025-09-24 11:13:28'),
(8, 'esse', 'Ulloa e Hijo', 'Dolorum quibusdam illum commodi ratione id quasi. Explicabo vitae nihil non fugiat nisi officia voluptas. Voluptas eos earum expedita qui alias. Laboriosam nam quia ab voluptas perferendis maxime est quisquam. Eveniet deleniti consectetur assumenda id itaque ut reprehenderit neque. Qui odit quibusdam consequuntur odit est nulla. Libero neque et ea corrupti laudantium.', 'Cervántez del Mirador', 1, 3, 345435, 6, 1, 1, 4, '2025-10-10 20:20:01', NULL, '2025-09-21 14:16:36', '2025-09-24 11:13:28'),
(9, 'sunt', 'Calderón, Rentería y Esquivel', 'Ut nulla saepe officiis quia non qui rerum exercitationem. Eos aut dolores eligendi qui sit quia dolores ut. Est eius eligendi quaerat autem nihil saepe. Et sit eligendi expedita praesentium animi illo. Cum rerum qui quidem. Ea ut officia est fuga molestias ut accusamus voluptates. Adipisci dolores suscipit sit tempore. Impedit totam aliquid sint similique quas.', 'Niño del Norte', 6, 3, 286587, 8, 1, 1, 7, '2025-10-17 17:54:23', NULL, '2025-09-18 16:52:10', '2025-09-24 11:13:28'),
(10, 'nostrum', 'Carrasco, Palomino y Ceja', 'Nam maiores ut dolor. Commodi quia eius qui. Blanditiis tempora quos rerum nulla. Est molestiae quos perferendis non atque ut dolores deleniti. Est omnis impedit ipsum expedita iure accusamus occaecati. Nobis quidem voluptatum non neque nemo. Totam suscipit ex consequatur ipsam.', 'Juan Pablo del Este', 4, 2, 268074, 4, 3, 1, 3, '2025-10-20 13:53:34', NULL, '2025-09-20 13:54:10', '2025-09-24 11:13:28');

-- --------------------------------------------------------

--
-- Table structure for table `ofertas_guardadas`
--

CREATE TABLE `ofertas_guardadas` (
  `id` bigint UNSIGNED NOT NULL,
  `oferta_id` bigint UNSIGNED DEFAULT NULL,
  `usuario_id` bigint UNSIGNED DEFAULT NULL,
  `fecha_guardado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `ofertas_guardadas`
--

INSERT INTO `ofertas_guardadas` (`id`, `oferta_id`, `usuario_id`, `fecha_guardado`) VALUES
(1, 3, 22, NULL),
(2, 8, 22, NULL),
(3, 3, 21, NULL),
(5, 4, 21, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `palabras_claves`
--

CREATE TABLE `palabras_claves` (
  `id` bigint UNSIGNED NOT NULL,
  `oferta_id` bigint UNSIGNED NOT NULL,
  `palabra` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `palabras_claves`
--

INSERT INTO `palabras_claves` (`id`, `oferta_id`, `palabra`, `created_at`, `updated_at`) VALUES
(1, 1, 'aut', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 1, 'placeat', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(3, 1, 'fugit', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(4, 2, 'qui', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(5, 2, 'cumque', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(6, 2, 'tenetur', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(7, 3, 'modi', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(8, 3, 'vitae', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(9, 3, 'animi', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(10, 4, 'aut', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(11, 4, 'est', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(12, 4, 'consequuntur', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(13, 5, 'ipsum', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(14, 5, 'ea', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(15, 5, 'at', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(16, 6, 'et', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(17, 6, 'voluptatum', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(18, 6, 'facilis', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(19, 7, 'quia', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(20, 7, 'et', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(21, 7, 'aliquid', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(22, 8, 'eum', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(23, 8, 'ipsum', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(24, 8, 'culpa', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(25, 9, 'eius', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(26, 9, 'consequatur', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(27, 9, 'et', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(28, 10, 'alias', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(29, 10, 'et', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(30, 10, 'a', '2025-09-24 11:13:28', '2025-09-24 11:13:28');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postulaciones`
--

CREATE TABLE `postulaciones` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `oferta_id` bigint UNSIGNED NOT NULL,
  `estado_postulacion` enum('En proceso','Aceptado','Rechazado','Cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'En proceso',
  `fecha_postulacion` date NOT NULL,
  `fecha_contratacion` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `postulaciones`
--

INSERT INTO `postulaciones` (`id`, `usuario_id`, `oferta_id`, `estado_postulacion`, `fecha_postulacion`, `fecha_contratacion`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Aceptado', '2022-02-26', '1994-01-16', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 22, 4, 'En proceso', '2025-09-24', NULL, '2025-09-25 00:43:53', '2025-09-25 00:43:53'),
(3, 21, 3, 'En proceso', '2025-09-25', NULL, '2025-09-26 00:42:12', '2025-09-26 00:42:12');

-- --------------------------------------------------------

--
-- Table structure for table `preguntas_ofertas`
--

CREATE TABLE `preguntas_ofertas` (
  `id` bigint UNSIGNED NOT NULL,
  `oferta_id` bigint UNSIGNED NOT NULL,
  `pregunta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `preguntas_ofertas`
--

INSERT INTO `preguntas_ofertas` (`id`, `oferta_id`, `pregunta`, `created_at`, `updated_at`) VALUES
(1, 1, 'Consequuntur architecto delectus vel qui deserunt reprehenderit labore.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(2, 1, 'Debitis sunt illo sapiente quis.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(3, 1, 'Asperiores itaque accusantium eos in est assumenda laudantium.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(4, 2, 'Iste ut quidem et provident.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(5, 2, 'Et itaque esse ullam et corporis.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(6, 2, 'Eligendi illo ut in rerum error dolor.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(7, 3, 'Doloremque quia est a dolores pariatur voluptatem.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(8, 3, 'Id mollitia odio est.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(9, 3, 'Et quia blanditiis facere ipsa et ut.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(10, 4, 'Accusantium temporibus neque consequatur fuga possimus enim cum.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(11, 4, 'Adipisci totam vel laboriosam nihil.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(12, 4, 'Hic fugit fugiat delectus maiores ratione quibusdam voluptas.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(13, 5, 'Tempore et et harum consequatur deserunt placeat modi.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(14, 5, 'Qui iste accusantium molestiae modi blanditiis et sequi a.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(15, 5, 'Temporibus ut accusamus et consequuntur delectus architecto sit.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(16, 6, 'Ipsum sint eius quos quo iure fugit.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(17, 6, 'Aspernatur dicta repellat architecto ut accusantium.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(18, 6, 'Dicta ullam est facere consequatur eum deserunt.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(19, 7, 'Nihil cum et illo qui veniam voluptates.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(20, 7, 'Dolores eum labore doloremque voluptas porro at.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(21, 7, 'Placeat itaque ipsam a sunt facere voluptate odio.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(22, 8, 'Autem sit et sapiente qui perferendis molestiae quidem.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(23, 8, 'Vero earum est illum.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(24, 8, 'Cumque eos est aut quas aut adipisci.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(25, 9, 'Nihil aliquid molestias amet soluta.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(26, 9, 'Fugit architecto qui quia nulla.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(27, 9, 'Dolorem atque non sint.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(28, 10, 'Numquam dolores vero dolorum veritatis placeat omnis.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(29, 10, 'Expedita dolor quaerat voluptatem est.', '2025-09-24 11:13:29', '2025-09-24 11:13:29'),
(30, 10, 'Illo facere aliquam nemo cumque et eos.', '2025-09-24 11:13:29', '2025-09-24 11:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `presidentes`
--

CREATE TABLE `presidentes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre_id` bigint UNSIGNED NOT NULL,
  `apellido_id` bigint UNSIGNED NOT NULL,
  `materia_id` bigint UNSIGNED NOT NULL,
  `carrera_id` bigint UNSIGNED NOT NULL,
  `horario` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profesors`
--

CREATE TABLE `profesors` (
  `id` bigint UNSIGNED NOT NULL,
  `apellido` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `profesors`
--

INSERT INTO `profesors` (`id`, `apellido`, `nombre`, `created_at`, `updated_at`) VALUES
(4, 'Milesi', 'Juan Carlos', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(5, 'Racosevich', 'Emilio', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(6, 'Simonetti', 'Vanina', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(7, 'Sautu de la Riestra', 'Maite', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(8, 'Rubio', 'Débora', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(9, 'Stroppiana', 'Walter', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(10, 'Policardo', 'Julio', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(11, 'Civilotti', 'María Eugenia', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(12, 'Guiñazu', 'Julio', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(13, 'Szittyay', 'Jorge', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(14, 'Rabo', 'Mónica', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(15, 'Goñi', 'Claudio', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(16, 'Segura', 'Milton', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(17, 'Marchesi', 'Alberto', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(18, 'Caramuto', 'Soledad', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(19, 'Carletti', 'Néstor', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(20, 'Nataloni', 'Ariel', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(21, 'Buxman', 'Jorge', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(22, 'Cairo', 'Ana María', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(23, 'Caparolini', 'Leonardo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(24, 'Blanco', 'Laura', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(25, 'Boffi', 'Pablo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(26, 'Bay', 'Ricardo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(27, 'Biava', 'Christian', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(28, 'Baigorria', 'María', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(29, 'Barr', 'Sebastián', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(30, 'Astorquiza', 'Alejandro', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(31, 'Auce', 'María Laura', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(32, 'Agusti', 'Gisela', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(33, 'Aleman De Gallardo', 'Margarita', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(34, 'Algarra', 'Luis', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(35, 'Arias', 'Miriam', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(36, 'Armoa', 'Osvaldo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(37, 'Ascua', 'Daniel', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(38, 'Chiaraluce', 'Oscar', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(39, 'Fritzler', 'Luciano', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(40, 'Casa', 'Héctor', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(41, 'Chaparro', 'Gabriel', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(42, 'Chitarroni', 'Natalia', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(43, 'Cremona', 'Pablo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(44, 'Devia', 'José', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(45, 'Entisne', 'Martín', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(46, 'Rito', 'Eufemio', '2022-11-03 13:44:48', '2023-02-24 12:54:38'),
(47, 'Di Bernardo', 'María Fernanda', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(48, 'Abud', 'Carolina', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(49, 'Herrera', 'Omar', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(50, 'Generale', 'Marcelo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(51, 'Lattanzio', 'Marcelo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(52, 'Guadagnoli', 'Romina', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(53, 'Lapuyade', 'María', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(54, 'Lopez', 'Alberto Julio', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(55, 'Jakubowski', 'Daniela', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(56, 'Martinese', 'Valeria', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(57, 'Marziali', 'Mariana', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(58, 'Migliaro', 'Susana', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(59, 'Mildemberger', 'Mariela', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(60, 'Medrano', 'Guadalupe', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(61, 'Mildenberger', 'Karina', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(62, 'Magni', 'Marcelo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(63, 'Leiva', 'Eduardo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(64, 'Mussini', 'Jorge', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(65, 'Vitrano', 'Victor', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(66, 'Pericih', 'Romina', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(67, 'Peretti', 'Néstor', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(68, 'Pasciullo', 'Raquel', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(69, 'Perez', 'Federico', '2022-11-03 13:44:48', '2024-04-13 12:11:27'),
(70, 'Nataloni', 'Diego', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(71, 'Russo', 'Patricia', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(72, 'Raminger', 'Javier', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(73, 'Santiso', 'Alejandra', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(74, 'Sauret', 'Javiera', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(75, 'Roldan', 'Fernando', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(76, 'Tanco', 'Miguel', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(77, 'Scaglione', 'Javier', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(78, 'Tofe', 'Guillermo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(79, 'Ugarte', 'Rosa', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(80, 'Murri', 'Axel', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(81, 'Strappa', 'Érica', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(82, 'Mozzicafredo', 'Belén', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(83, 'Zaffalon', 'Rafael', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(84, 'Van Lacke', 'Daniel', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(85, 'Vozza', 'Gabriel', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(86, 'Bo', 'M. Laura', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(87, 'Declerk', 'Víctor', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(88, 'Acosta', 'Héctor', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(89, 'Szretter', 'Raul', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(90, 'Sagrera', 'Agustina', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(91, 'Gamito', 'Juan Ignacio', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(92, 'Dottavio', 'Lucia V.', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(93, 'Zampa', 'Laura', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(94, 'Acosta', 'Pablo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(95, 'Allegretti', 'Luis', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(96, 'Ardissone', 'Nadia', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(97, 'Benedetti', 'Sandra', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(98, 'Berenstein', 'Liliana', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(99, 'Beron', 'Gustavo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(100, 'Borselli', 'Mauricio', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(101, 'Buiter', 'Cecilia', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(102, 'Castro', 'Antonela', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(103, 'Ceballos', 'Griselda', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(104, 'Cerpelloni', 'Loida', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(105, 'Chiapparoli', 'Walter', '2022-11-03 13:44:48', '2025-07-22 19:16:06'),
(106, 'Covacich', 'Lucas', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(107, 'Cuevas', 'Manuel', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(108, 'De Carlo', 'Miriam', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(109, 'De Carlo', 'Carina', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(110, 'Ducchi', 'Silvia', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(111, 'Eroles', 'Gabriela', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(112, 'Ferreira', 'Claudia', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(113, 'Forti', 'Maria M', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(114, 'Franzia', 'Juan Manuel', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(115, 'Gallego', 'Sebastian', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(116, 'Garcia', 'Carolina', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(117, 'Laule', 'Laura', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(118, 'Marcangelo', 'Leandro', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(119, 'Marchesano', 'Patricia', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(120, 'Mari Maita', 'Paola', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(121, 'Mattacotta', 'Alicia', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(122, 'Medica', 'Andrea', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(123, 'Meoniz', 'Mariel', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(124, 'Meraviglia', 'Mauro', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(125, 'Miretti', 'Daniela', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(126, 'Pacchioni', 'Maria', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(127, 'Pavoni', 'Pamela', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(128, 'Perie', 'Gustavo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(129, 'Prado', 'Adriana', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(130, 'Purino', 'Juan l', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(131, 'Ragusa', 'Jose L', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(132, 'Rios', 'Eva', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(133, 'Ramirez', 'Gaston', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(134, 'Rivero', 'Paola', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(135, 'Rodriguez', 'Daniela', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(136, 'Santia', 'Barbara', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(137, 'Solis', 'Ayelen', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(138, 'Stoppani', 'Silvia', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(139, 'Yaworski', 'Julio', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(140, 'Taborda', 'Pablo', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(141, 'Zaffalon', 'Maria Jose', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(142, 'Segovia', 'Enrique', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(143, 'Sanchez', 'Ana', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(144, 'Giacosa', '-', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(146, 'Lamberto', 'Andrés', '2022-11-03 13:44:48', '2022-11-03 17:01:32'),
(147, 'Vivas', 'Diego', '2022-11-03 13:44:48', '2024-04-13 12:23:04'),
(148, 'Fió', '-', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(150, 'Festa', '-', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(151, 'Conca', '-', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(152, 'Taruselli', '-', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(153, 'Migliaro', 'U.', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(154, 'Carre', 'Jorge', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(155, 'Temporetti', 'Giuliano', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(156, 'Piana', 'Nicolás', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(157, 'Piana', 'Julieta', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(158, 'Andenmaten', 'Rocío', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(159, 'Moreno Parra', 'Rodrigo', '2022-11-03 13:44:48', '2023-03-11 04:24:29'),
(161, 'Jacob', 'D', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(162, 'Cairo', 'S', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(163, 'Viggiano', 'Jesica', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(164, 'Baigorria Porres', 'Luis', '2022-11-03 13:44:48', '2022-11-03 13:44:48'),
(165, 'Galdeano', 'Alejandro', '2023-02-24 12:29:39', '2023-02-24 12:29:39'),
(166, 'Romero', 'Eugenia', '2023-02-24 12:30:58', '2023-02-24 12:30:58'),
(167, 'Brucelliaria', 'Agustina', '2023-02-24 12:45:58', '2023-02-24 12:45:58'),
(168, 'Merlo', 'Mariana', '2023-02-24 12:46:11', '2023-02-24 12:46:11'),
(169, 'Gomez', 'Gustavo', '2023-02-24 12:48:20', '2023-02-24 12:48:20'),
(170, 'Rodriguez', 'Oscar', '2023-02-24 12:49:54', '2023-02-24 12:49:54'),
(171, 'Cuadranti', 'Martín', '2023-02-24 12:51:02', '2023-02-24 12:51:02'),
(173, 'Stochi', 'Sabrina', '2023-02-24 12:57:27', '2023-04-06 12:46:48'),
(174, 'Listrani', 'Carolina', '2023-02-24 12:58:40', '2023-03-05 00:57:30'),
(175, 'Derrico', 'Agostina', '2023-02-24 12:59:57', '2023-03-05 00:56:28'),
(176, 'Frias', 'V.', '2023-02-24 13:00:51', '2023-02-24 13:00:51'),
(177, '-', '-', '2023-03-05 01:00:31', '2023-03-05 01:00:31'),
(178, 'Borras', 'Juan C.', '2023-03-05 01:10:41', '2023-03-05 01:10:41'),
(180, 'Turcutto', 'Fania', '2023-03-05 01:19:07', '2023-03-05 01:19:07'),
(181, 'Ramirez', 'Ezequiel', '2023-03-05 01:27:34', '2025-09-05 01:13:20'),
(182, 'Toledo', 'Federico', '2023-03-05 01:29:06', '2023-03-05 01:29:06'),
(183, 'Alarcón', 'Bernardo', '2023-03-05 01:30:33', '2023-03-05 01:30:33'),
(184, 'Valles', 'Roberto', '2023-03-05 01:31:28', '2023-03-05 01:31:28'),
(185, 'Reinholds', 'Reinis Ismael', '2023-03-05 01:35:55', '2023-03-05 01:35:55'),
(187, 'Bazán', 'Nadia', '2023-03-11 04:36:12', '2023-03-11 04:36:12'),
(188, 'Dorsch', 'Mauro', '2023-04-06 12:28:46', '2023-04-06 12:28:46'),
(189, 'Trebucobich', 'Mara', '2023-04-06 12:38:44', '2023-04-06 12:38:44'),
(190, 'Pochettino', 'Sebastián', '2023-06-09 08:32:49', '2023-06-09 08:32:49'),
(193, 'Gonzalez', 'Carolina', '2024-04-13 12:58:45', '2024-04-13 12:58:45'),
(194, 'Pistan', 'Esteban', '2024-04-13 13:03:02', '2024-04-13 13:03:02'),
(195, 'Escuri', 'Soledad', '2025-03-24 08:42:53', '2025-03-24 08:42:53'),
(196, 'Berthet', 'Gustavo', '2025-03-24 08:44:31', '2025-03-24 08:44:31'),
(197, 'Fernández Cariaga', 'Florencia', '2025-03-24 08:52:41', '2025-03-24 08:52:41'),
(198, 'Saab', 'Roberto', '2025-03-24 09:05:14', '2025-03-24 09:05:14'),
(199, 'Marti', 'Lautaro', NULL, NULL),
(200, 'Alegrini', 'Emiliano', NULL, NULL),
(201, 'Rinaldi', 'Mauro', NULL, NULL),
(202, 'Gonzalez', 'Gustavo', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `programas`
--

CREATE TABLE `programas` (
  `id` bigint UNSIGNED NOT NULL,
  `sede_id` bigint UNSIGNED DEFAULT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `anio_id` bigint UNSIGNED DEFAULT NULL,
  `materia_id` bigint UNSIGNED DEFAULT NULL,
  `comision_id` bigint UNSIGNED DEFAULT NULL,
  `profesor_id` bigint UNSIGNED DEFAULT NULL,
  `nombrearchivo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `ruta` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `fechaentrega` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registros`
--

CREATE TABLE `registros` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sexo` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `dni` bigint NOT NULL,
  `cuil` bigint NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `est_civil` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `domicilio` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `numero` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `piso` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `depto` varchar(6) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `barrio` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `partido` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `provincia` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `cod_postal` int NOT NULL,
  `fec_nac` date NOT NULL,
  `lug_nac` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `prov_nac` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `nacionalidad` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `celular` bigint NOT NULL,
  `tel_fijo` bigint DEFAULT NULL,
  `tel_alternativo` bigint DEFAULT NULL,
  `pertenece_a` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `titulo_intermedio` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `año_egreso` int NOT NULL,
  `escuela_egreso` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `distrito_egreso` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `hijos` int DEFAULT NULL,
  `fam_a_cargo` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `trabaja` tinyint(1) DEFAULT NULL,
  `actividad_trabajo` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `horario_trabajo` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `obra_social` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `otro_estudio` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `otro_estudio_inst` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `otro_estudio_egreso_dist` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `otro_estudio_egreso` int DEFAULT NULL,
  `otro_estudio2` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `otro_estudio_inst2` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `otro_estudio_egreso_dist2` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `otro_estudio_egreso2` int DEFAULT NULL,
  `fotoc_dni` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `titulo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `certificado` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `foto` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `visado_por` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `fotoc_dni_ok` tinyint(1) DEFAULT NULL,
  `fotoc_titulo_ok` tinyint(1) DEFAULT NULL,
  `certificado_sec_ok` tinyint(1) DEFAULT NULL,
  `foto_ok` tinyint(1) DEFAULT NULL,
  `partida_nac_ok` tinyint(1) DEFAULT NULL,
  `confirmado` tinyint DEFAULT NULL,
  `backup` tinyint DEFAULT NULL,
  `materias_adeudadas` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requisitos_ofertas`
--

CREATE TABLE `requisitos_ofertas` (
  `id` bigint UNSIGNED NOT NULL,
  `oferta_id` bigint UNSIGNED NOT NULL,
  `requisito` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `requisitos_ofertas`
--

INSERT INTO `requisitos_ofertas` (`id`, `oferta_id`, `requisito`, `created_at`, `updated_at`) VALUES
(1, 1, 'Quis at incidunt sit laborum ad.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 1, 'Aliquam quam fugiat voluptas veritatis.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(3, 1, 'Earum et ducimus rerum deleniti.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(4, 2, 'Et exercitationem minus expedita necessitatibus.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(5, 2, 'Tempore natus reprehenderit doloremque sunt.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(6, 2, 'Vel ut eum distinctio repellendus autem.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(7, 3, 'Atque est dolorem debitis voluptatem.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(8, 3, 'Et est veritatis et minima.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(9, 3, 'Culpa accusantium non suscipit quidem aut blanditiis est.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(10, 4, 'Eveniet et exercitationem officiis.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(11, 4, 'Atque enim dignissimos velit sequi consectetur nulla.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(12, 4, 'Nihil rem inventore ut neque eum.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(13, 5, 'Veritatis in numquam nesciunt ut et omnis voluptatum.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(14, 5, 'Reprehenderit deserunt praesentium totam dolor officia illum.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(15, 5, 'Voluptatem accusamus commodi velit ut odio distinctio omnis.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(16, 6, 'Fugit omnis et numquam eaque ratione dolor.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(17, 6, 'Necessitatibus ut nulla sed.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(18, 6, 'Veritatis sed nihil odio maxime distinctio et non.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(19, 7, 'Numquam alias maxime corporis hic.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(20, 7, 'Facilis dolorem officia asperiores ea sed.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(21, 7, 'Consequuntur quasi ut libero iste quia laudantium.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(22, 8, 'Quo soluta nostrum est voluptatem.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(23, 8, 'Et ad ut officia vel.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(24, 8, 'Assumenda ipsam deserunt ut in excepturi facere et.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(25, 9, 'Laborum in et commodi similique temporibus eligendi veniam.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(26, 9, 'Illo repellat quia rerum consequatur.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(27, 9, 'Aliquid et qui aut earum facere corrupti.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(28, 10, 'Ut voluptate ipsam reprehenderit voluptas expedita reiciendis.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(29, 10, 'Sunt dolorem magni occaecati omnis voluptate asperiores.', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(30, 10, 'Sint qui consequatur architecto nisi qui et.', '2025-09-24 11:13:28', '2025-09-24 11:13:28');

-- --------------------------------------------------------

--
-- Table structure for table `resoluciones`
--

CREATE TABLE `resoluciones` (
  `id` bigint UNSIGNED NOT NULL,
  `resolucion` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `resoluciones`
--

INSERT INTO `resoluciones` (`id`, `resolucion`, `created_at`, `updated_at`) VALUES
(1, 'RES. 6790/19', NULL, NULL),
(2, 'RES. 442/08 y 2257/08', NULL, NULL),
(3, 'RES. 320/13', NULL, NULL),
(4, 'RES. 3650/00', NULL, NULL),
(5, 'RES. 3780/22', NULL, NULL),
(6, 'RES. 455/23', NULL, NULL),
(7, 'RES. 273/03', NULL, NULL),
(8, 'RES. 5311/24', NULL, NULL),
(9, 'RES. 276/03', NULL, NULL),
(10, 'RES. 5312/24', NULL, NULL),
(11, 'RES. 1557/08', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `salons`
--

CREATE TABLE `salons` (
  `id` bigint UNSIGNED NOT NULL,
  `numero_salon` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `capacidad` int NOT NULL,
  `carrera_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `anio_id` int DEFAULT NULL,
  `comision_id` int DEFAULT NULL,
  `laboratorio` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `salons`
--

INSERT INTO `salons` (`id`, `numero_salon`, `capacidad`, `carrera_id`, `created_at`, `updated_at`, `anio_id`, `comision_id`, `laboratorio`) VALUES
(13, '233', 28, 6, '2025-09-01 15:52:51', '2025-09-01 15:52:51', 2, 1, 0),
(14, '229', 58, 3, '2025-09-01 18:30:02', '2025-09-01 18:54:17', 1, 1, 0),
(15, '236', 57, 6, '2025-09-01 18:30:36', '2025-09-01 18:30:36', 1, 1, 0),
(17, '227', 7, 5, '2025-09-01 18:34:02', '2025-09-01 18:34:02', 2, 1, 0),
(18, '225', 17, 3, '2025-09-01 18:34:31', '2025-09-01 18:34:31', 2, 1, 0),
(19, '224', 24, 6, '2025-09-01 18:35:14', '2025-09-01 18:35:14', 2, 2, 0),
(20, '222', 25, 4, '2025-09-01 18:35:43', '2025-09-01 18:35:43', 2, 1, 0),
(21, '219', 34, 5, '2025-09-01 18:40:43', '2025-09-01 18:40:43', 1, 1, 0),
(22, '216', 42, 1, '2025-09-01 18:43:48', '2025-09-01 18:43:48', 1, 1, 0),
(23, '214', 18, 26, '2025-09-01 18:45:25', '2025-09-01 18:45:25', 1, 1, 0),
(24, '113', 13, 8, '2025-09-01 18:45:44', '2025-09-01 18:56:55', 3, 1, 0),
(25, '112', 25, 2, '2025-09-01 18:46:05', '2025-09-19 15:29:23', 3, 1, 0),
(26, '210', 52, 6, '2025-09-01 18:46:35', '2025-09-01 18:46:35', 1, 2, 0),
(27, '253', 35, 2, '2025-09-01 18:47:01', '2025-09-01 18:47:01', 2, 1, 0),
(28, '206', 56, 4, '2025-09-01 18:47:28', '2025-09-01 18:47:28', 1, 1, 0),
(29, '239', 53, 2, '2025-09-01 18:53:02', '2025-09-01 18:53:02', 1, 1, 0),
(32, '241', 22, 1, '2025-09-06 04:27:04', '2025-09-06 04:27:04', 2, 1, 0),
(34, 'LAB. SALA 1 (243)', 15, 2, '2025-09-13 23:03:08', '2025-09-14 19:53:56', 1, 1, 1),
(35, 'LAB. SALA 2 (245)', 10, 2, '2025-09-13 23:03:23', '2025-09-14 19:54:02', 1, 1, 1),
(36, 'LAB. SALA 3 ()', 16, 2, '2025-09-13 23:03:50', '2025-10-02 17:18:12', 3, 1, 1),
(37, 'LAB. SALA 4 (254)', 10, 2, '2025-09-13 23:04:16', '2025-09-14 19:54:20', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sedeemails`
--

CREATE TABLE `sedeemails` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sede_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `sedeemails`
--

INSERT INTO `sedeemails` (`id`, `email`, `sede_id`, `created_at`, `updated_at`) VALUES
(4, 'isft38sannicolas@abc.gob.ar', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sedes`
--

CREATE TABLE `sedes` (
  `id` bigint UNSIGNED NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `calle` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `numero` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `ciudad` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sedeimagen` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `sedes`
--

INSERT INTO `sedes` (`id`, `descripcion`, `calle`, `numero`, `ciudad`, `sedeimagen`, `created_at`, `updated_at`) VALUES
(1, 'Sede Central San Nicolás', 'Av. Central', '1825', 'San Nicolás de los Arroyos', 'sedes/1/descarga.jfif', NULL, '2022-10-01 19:55:10');

-- --------------------------------------------------------

--
-- Table structure for table `sedetelefonos`
--

CREATE TABLE `sedetelefonos` (
  `id` bigint UNSIGNED NOT NULL,
  `caracteristica` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `numero` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sede_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `sedetelefonos`
--

INSERT INTO `sedetelefonos` (`id`, `caracteristica`, `numero`, `sede_id`, `created_at`, `updated_at`) VALUES
(3, '0336', '4461110', 1, '2022-11-03 14:59:51', '2022-11-03 14:59:51'),
(4, '0336', '4462857', 1, '2022-11-03 15:01:09', '2022-11-03 15:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `times`
--

CREATE TABLE `times` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `times`
--

INSERT INTO `times` (`id`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'Full-Time', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 'Part-Time', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(3, 'Rotativo', '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(4, 'Libre', '2025-09-24 21:56:26', '2025-09-24 21:56:26');

-- --------------------------------------------------------

--
-- Table structure for table `turnos`
--

CREATE TABLE `turnos` (
  `id` bigint UNSIGNED NOT NULL,
  `dia_hora` datetime NOT NULL,
  `dni` int DEFAULT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `is_admin`, `created_at`, `updated_at`) VALUES
(99, 'test', 'test@isft38.edu.ar', NULL, '$2y$10$7ew2HtFW8WecXcoVnXRPd.sLaZzQ1ymrZpEVvGnG2vf1AwAY.lOJ.', NULL, 1, NULL, NULL),
(100, 'Regente', 'regente@example.com', NULL, '$2y$10$9Ivd6dZfo/cSe9B0DrTBc.cwxYNrRRVHruRGBjuAtUsOWk4R/jGVS', NULL, 2, '2025-07-06 22:00:45', '2025-07-06 22:00:45'),
(101, 'Preceptor', 'preceptor@example.com', NULL, '$2y$10$NbGrH5TYn.g6PA5MQBv0Hu8uP/1I3tIwoqHFx9e90uP1IR06GBBU6', NULL, 3, '2025-09-11 01:02:48', '2025-09-11 01:02:48');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` enum('Masculino','Femenino','No Binario','Transgénero','Otro','Prefiero no decirlo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nacionalidad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ciudad_residencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pais_residencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_perfil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `telefono` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sitio_web` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `rol` enum('usuario','administrador') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `perfil_completado` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `dni`, `fecha_nacimiento`, `genero`, `nacionalidad`, `ciudad_residencia`, `pais_residencia`, `foto_perfil`, `descripcion`, `telefono`, `sitio_web`, `carrera_id`, `rol`, `perfil_completado`, `created_at`, `updated_at`) VALUES
(1, 'Joshua', 'Báez', 'miguel66@example.net', '$2y$10$EtWCvUZJ1/fldUKyuXJy7.l9aHF/T2ENR5cB5oFXFdABpPLTrwHAy', '49256780', '1999-11-01', 'Femenino', 'Lituania', 'Martina del Este', 'Chile', NULL, 'Voluptate est iure vel est. Ut et omnis sit rem placeat. A exercitationem eos laboriosam. Consequatur quia architecto veniam eaque. Voluptatem placeat ut laudantium quo. Eaque saepe aut ducimus. Non labore reiciendis repellat omnis incidunt quis ut nostrum. At molestiae est id sapiente.', '30659776', 'http://www.vasquez.biz/ut-voluptatem-perspiciatis-dolorum-repellat-recusandae-sed-omnis.html', 6, 'administrador', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(2, 'Carolina', 'Villarreal', 'zvalles@example.com', '$2y$10$/eadNz1L3w.BKGK0FxOqhO6iU6sFhzBOpw2lNqmse20KqBOfyDo/6', '93538452', '2007-04-30', 'Otro', 'Micronesia', 'Bahena del Oeste', 'Irlanda', NULL, 'Necessitatibus fuga voluptatum qui dolorem est est molestias. Quasi vitae sequi est ea occaecati sequi. In consequatur ullam accusantium placeat libero praesentium nulla. Dolores et iusto commodi itaque sed perspiciatis. Beatae ab qui iste nihil. Odit minima porro necessitatibus eius repellat quisquam. Sed ab officiis culpa ad omnis. Dolores et magnam quia sunt.', '71590358', 'https://www.santana.biz/sequi-aspernatur-ea-et-sit', 6, 'usuario', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(3, 'Renata', 'Varela', 'lautaro72@example.com', '$2y$10$e0j/YaWFB.9CUifgFkzySOlhUpTwFTyslnbJS457iT63FDZ08aF7i', '42089327', '1993-03-09', 'Masculino', 'Burundi', 'Aguayo del Mirador', 'Australia', NULL, 'Aut non minima nesciunt delectus cumque et. Explicabo eius non aut non ratione id quia et. Rerum accusamus exercitationem sed. Veritatis repellat autem odit voluptatibus nostrum. Et consequatur quia ut nihil vel dolor omnis. Ipsam minus labore itaque doloremque. Eius omnis tenetur dolores facilis qui dolores. Excepturi laborum quasi sed exercitationem quae.', '02124094', 'http://www.ocampo.com/commodi-dolorum-rerum-doloremque-rerum-corporis-quo-ipsum-blanditiis.html', 4, 'administrador', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(4, 'Ian', 'Cortez', 'camila.romero@example.net', '$2y$10$ZL7XoSEMOYSanGlRu.FNdOQTA4mzgtGCP.KAtkS0/eoYqf.y4LsOK', '29927487', '1971-09-13', 'Femenino', 'Rumanía', 'Gral. Ivanna del Sur', 'Brunéi Darusalam', NULL, 'Quaerat aperiam nihil voluptatem animi. Placeat deleniti ut ratione totam occaecati. Blanditiis autem non alias voluptatem voluptas sapiente et provident. Earum accusantium maxime deleniti. Ullam corporis in cum iusto. Et beatae exercitationem recusandae dolores quo saepe facere autem. Modi ea saepe atque deleniti. Distinctio minus modi nam animi. Rerum architecto nostrum ex aut.', '22603913', 'http://www.gallardo.info/ad-sint-quia-ea-quis-ab.html', 3, 'usuario', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(5, 'Gabriel', 'Arevalo', 'aalcala@example.org', '$2y$10$xRV5nF8GyWltYGXVP.HVkOOjrub0oE5Q3.CbytUgI/UMQvR/oWAkm', '13472682', '1972-12-31', 'Femenino', 'Siria', 'Daniela del Mirador', 'Uzbekistán', NULL, 'Consectetur necessitatibus excepturi laudantium ipsa quia aliquam. Quisquam cupiditate in eos occaecati vel. Qui laboriosam ea natus quo. Sed maxime non ut labore voluptate. Tempore vitae aperiam tempora laborum tempore quam. Voluptatum at culpa vero saepe dolor. Ut cum quis eum animi quod.', '43801675', 'http://gutierrez.com/et-beatae-omnis-cumque-nesciunt-in', 4, 'usuario', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(6, 'Fabiana', 'Roldán', 'jesus.munoz@example.org', '$2y$10$0ABvtiKoTxquI0bSpojHYOnMjdcdWVsNvVhODa2v4f72I4x58cyH2', '69702599', '1978-11-28', 'Otro', 'Birmania', 'Michelle del Oeste', 'Afganistán', NULL, 'Voluptatem omnis odio nobis recusandae aut tempore occaecati. Nihil dignissimos hic incidunt sed. Nam ex est qui et laborum fugiat. Nam necessitatibus fugiat quae itaque et non sunt. Error dolore perspiciatis consectetur asperiores. Et dolores aut consectetur libero repudiandae voluptas sit. Aut voluptatem itaque quis. Dolor perferendis illum unde similique.', '66027139', 'http://www.mendez.info/nemo-perspiciatis-ut-praesentium-delectus-alias-animi-qui.html', 1, 'administrador', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(7, 'Josué', 'Miramontes', 'hpedroza@example.org', '$2y$10$kQo4rKiBsPeuw9T.Rl585exufjrXVSK6ezHzdoNA0vzPqdOC5nX02', '26142855', '1982-02-14', 'Femenino', 'Canadá', 'Amelia del Mar', 'Botsuana', NULL, 'Quisquam quasi quaerat perferendis distinctio possimus. Aliquid ipsam excepturi similique dolor optio et. Perferendis quas quidem laboriosam molestias cum distinctio. Ut in alias eius corporis dolorem. Saepe molestiae sit ipsam veritatis. Eveniet enim alias quidem porro quaerat. Quibusdam aut quod voluptates enim et. Saepe dolores et ad sit.', '73926378', 'http://www.laboy.com/aut-harum-autem-deleniti-eligendi-mollitia-et-explicabo-quaerat.html', 6, 'usuario', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(8, 'Joaquín', 'Apodaca', 'ivanna34@example.com', '$2y$10$VHZnDJO.MeFbBo59kEePgeYgVCVGHPN3os1EJMF8VEKKsooD3VUfG', '56585217', '1989-08-19', 'Femenino', 'Ciudad del Vaticano', 'Tamayo del Mirador', 'Comoras', NULL, 'Est error doloremque laudantium veritatis. Quam omnis sequi ut repellat. Impedit exercitationem debitis occaecati. Repellat et consequatur ut. Assumenda numquam ut quis quia eius laboriosam. Officia quibusdam voluptas inventore et corporis explicabo officia. Eius ut dolores nobis iure est. Quos maiores rerum quam. Cumque et possimus dolore reiciendis. Et culpa optio repellat dolores quidem.', '49515560', 'http://franco.org/fugit-est-quam-exercitationem-ut-quidem', 1, 'usuario', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(9, 'Renata', 'Molina', 'simon.vera@example.com', '$2y$10$od4ES4hiesI.Kwhn7VaN.up7irafKKeIKIrDPA9wbWc6w7ZWUhHMe', '68667849', '2002-03-28', 'Masculino', 'Malasia', 'Puerto Malena', 'Israel', NULL, 'Et voluptate magnam facere ipsum consequuntur quae. Est suscipit exercitationem excepturi error nemo. Adipisci ducimus quos ratione. Molestias et molestiae fugiat. Cumque id hic dolorum officiis quo. Consequuntur sapiente incidunt voluptate accusamus voluptatum non optio. Repellendus provident voluptatem eos nobis sit. Et sint quam blanditiis possimus.', '05801687', 'http://www.guerra.net/', 2, 'usuario', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(10, 'Isabella', 'Tejeda', 'silvana.barrientos@example.net', '$2y$10$S4zreGpyvlHt0EF9hfQ8.OY4TBem7mQ5lhSAXFhJbUgAYmlxUv/XO', '51368634', '1970-05-07', 'Femenino', 'Liechtenstein', 'Gral. Sebastián', 'Canadá', NULL, 'Consectetur similique quaerat porro reiciendis reprehenderit doloribus. Tempora sed aut sit aperiam nobis sed voluptas. Et qui est quos aspernatur aut. Magni voluptas quia sint earum nihil omnis molestiae. Et culpa ut recusandae dolore. Magnam consequatur qui aut qui voluptatibus commodi vitae.', '98465442', 'https://www.olmos.net/sapiente-labore-reprehenderit-sit-provident-suscipit', 7, 'administrador', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(11, 'Julia', 'Menéndez', 'michelle29@example.com', '$2y$10$ukM8Vx2xhA5X6rSl1RlKE.PckMvTjxqzM7CqC43PrIcBaHhkaxq3m', '44426161', '1975-07-19', 'Otro', 'Uruguay', 'Mata del Mar', 'Brunéi Darusalam', NULL, 'Illum voluptates non ut. Quia reprehenderit vel quae voluptatem voluptatem rerum. Est molestias asperiores corporis laborum magnam dolores. Nostrum ut dicta totam dicta. Aspernatur quod necessitatibus id enim voluptas explicabo. Architecto tempore consequatur sit quidem eos tenetur. Rem aut velit praesentium aut culpa minus. Et facilis id enim minus dolores cum id.', '31153854', 'http://puente.com/', 8, 'administrador', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(12, 'Paula', 'Domínguez', 'gracia.benjamin@example.com', '$2y$10$1KgqV7D.5GWq6vQJ2EfBXuPrahv4S3nL9XDlYF6yICCopDD.lViQq', '75578707', '1973-05-30', 'Femenino', 'Benín', 'Miranda del Mirador', 'Túnez', NULL, 'Consequatur et numquam illum beatae quis. Culpa recusandae eaque voluptatem autem at qui quia. Perspiciatis molestiae et molestiae delectus temporibus est accusamus. Quisquam molestiae reprehenderit sapiente vero. Possimus ab voluptas in aperiam necessitatibus. Tempora consequatur voluptates nostrum et inventore quia suscipit. Quia libero ab qui et mollitia.', '29194736', 'http://delacruz.com/qui-ut-ut-nostrum-necessitatibus-quisquam-quis', 7, 'administrador', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(13, 'Hidalgo', 'Cortez', 'bcovarrubias@example.net', '$2y$10$3biss6dVs.a7pTkdYwfR..UGIhvcHNaGfMAdQnekxv7ayiRoCJP2.', '07509818', '1983-06-28', 'Femenino', 'Fiyi', 'Don Rebeca del Este', 'Somalia', NULL, 'Quod et at aliquam vel ex quia. Rem similique aperiam repellat consequatur. Sint quasi ipsam magnam sed sed non. Quisquam consequatur eum ex aut. Aut est doloremque harum voluptatum sed. Est consequuntur velit et. Amet non quo quisquam explicabo. Eos odio ratione molestias aut dolorem eos suscipit.', '82074292', 'http://cruz.biz/non-maxime-harum-aliquam-debitis.html', 2, 'administrador', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(14, 'María José', 'Blanco', 'antonella91@example.org', '$2y$10$u1B7YrTOO03s21uIc.xPh.PtVZlEvmUe0qexgLOtBIleTLxYItw26', '54557051', '2001-11-21', 'Femenino', 'Chipre', 'Gral. Jesús del Norte', 'China', NULL, 'Nulla vitae magnam voluptatem delectus omnis. Dignissimos rerum vel nostrum facere nulla a quo. Esse reiciendis tenetur reiciendis dolorum similique. Nisi vero repudiandae molestiae officia aliquam. Cumque saepe saepe dolor. Asperiores animi qui beatae voluptates quas quo non repellendus.', '11970676', 'http://www.velazquez.info/', 2, 'usuario', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(15, 'Julieta', 'Uribe', 'facundo.alcantar@example.com', '$2y$10$tfD7DiZN/0t4RzmuA5hbHOSKA0LJNPB0.LFiw7.Isw1dBIKPQEBta', '09785925', '1972-04-23', 'Otro', 'Uzbekistán', 'Ocampo del Este', 'Uruguay', NULL, 'Similique iure vel quo vel non ullam. Odio sed quis quia quo. Omnis blanditiis enim recusandae quod reiciendis. Dolor temporibus voluptatem non. Veniam animi velit vero debitis. Aut deserunt commodi ex occaecati.', '30276244', 'http://soto.com/est-dolorem-est-sint-soluta', 2, 'usuario', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(16, 'Luna', 'Cabrera', 'violeta.chavez@example.net', '$2y$10$yyVuWSOUHB9j.2Cl7/Ta9.ssqMIgHgU7rBMfKZUToioOJTCkoZoXS', '43967005', '1979-04-24', 'Femenino', 'Japón', 'Quintanilla del Norte', 'Bangladés', NULL, 'Libero dolore deserunt numquam quaerat minima. Ut vitae laboriosam cumque expedita cupiditate nesciunt. Temporibus ut est eligendi et quo inventore. Omnis illum qui et molestias quisquam ut est minus. Voluptatibus cumque qui eligendi ut officia quis illo. Et sit qui aperiam. Officia quia rem facere voluptatibus sed reprehenderit deserunt. Voluptates doloremque ut et dolorem.', '20113218', 'https://www.borrego.net/neque-possimus-optio-placeat-voluptatem', 6, 'administrador', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(17, 'Miguel Ángel', 'Zapata', 'diegoalejandro.baeza@example.org', '$2y$10$Ev2AajRbQbNm.9CkqQE5xeFcdC/q0GvB8gkuIH9UKTZF4XsyRgNQC', '87720941', '1979-02-25', 'Femenino', 'Yemen', 'Don Abril', 'Islas Salomón', NULL, 'Sed ut velit quisquam. Neque est voluptate placeat ullam. Qui consequatur ex aperiam cumque et. Aut totam officia officia atque id. Labore magni at nobis commodi neque dolor fugiat. Eum deserunt eum ipsam omnis vel voluptas quo. Qui repellat rerum doloremque. Aut qui aut asperiores excepturi. Omnis incidunt aperiam ipsam laboriosam quis voluptates odit sequi.', '19590973', 'http://www.cordero.net/facilis-et-voluptatem-et-corrupti-ut-nihil-nisi', 2, 'usuario', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(18, 'Miguel', 'Tórrez', 'axel.batista@example.org', '$2y$10$.rCmPks/6VwZOSxfxyY70.0.uPHTB1KO5VnQWYYX.XK5vnv1UfV7C', '26774383', '2003-10-04', 'Femenino', 'Guinea', 'Emma del Este', 'Omán', NULL, 'Temporibus nemo repudiandae autem aut expedita qui et. Ab at doloremque aut harum voluptatem in aliquid. Quia consectetur blanditiis sint fuga officia labore. Quo eligendi neque sed voluptates. Unde est quisquam quis aut. Assumenda molestiae quo est et et. Possimus neque amet mollitia dolore eum aliquid quibusdam.', '22801943', 'http://www.cardona.com/quos-illum-sint-voluptate-beatae-autem.html', 4, 'usuario', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(19, 'Ariana', 'Godínez', 'gabeyta@example.com', '$2y$10$dFlpWZe6RNw1XskN47jyPeHn9kjvJJDlpC4ZStpu.UrhkRyU0G1cy', '70834284', '1984-06-12', 'Masculino', 'Maldivas', 'Martina del Sur', 'Honduras', NULL, 'Similique dignissimos tempore fugiat. Voluptas voluptatem aut aperiam. Reprehenderit ipsam nesciunt itaque. Beatae quam et reiciendis fugiat sit. Voluptatibus suscipit tempora cumque tempore. Vero a voluptas ea culpa. Vel dolorem sit et porro. Quo nesciunt perferendis voluptatem sint provident. Officia officia delectus velit non nihil. Voluptatem tempora modi sunt.', '10683089', 'https://curiel.com/totam-et-consequuntur-tenetur-possimus.html', 6, 'administrador', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(20, 'Sebastián', 'Casares', 'facundo87@example.org', '$2y$10$/XLbWIzfjzIUP4mtQ/b74ONyWRGrX/Q1TSmOPQcfvzcJtLQ/PMCyS', '06590103', '2007-02-07', 'Masculino', 'Vanuatu', 'Villa Damián del Oeste', 'Costa Rica', NULL, 'Commodi eveniet enim quod eos perferendis. Earum doloremque esse aspernatur voluptates totam asperiores voluptatem veritatis. Et quas repellendus in. Ipsum minus quae porro sit dolorem sequi sit. In velit at fuga aperiam maxime similique. Eligendi similique culpa vitae numquam excepturi velit accusantium. Ullam corporis quo ad quasi rem in quam eligendi.', '43250041', 'http://www.arana.biz/aliquam-eius-modi-dignissimos-nisi-explicabo-aperiam.html', 1, 'usuario', 0, '2025-09-24 11:13:28', '2025-09-24 11:13:28'),
(21, 'Gisela', 'Agusti', 'test@isft38.edu.ar', '$2y$10$IvswKJns/lEyxFBKYm5evOaDXJnRdfY.t2Q0zydULVarRsmReT8qu', '31559632', '2008-09-10', 'Femenino', 'gtyhgg', 'gtyhhv', NULL, NULL, 'gghyggh', '255555', NULL, 6, 'usuario', 1, '2025-09-24 21:31:02', '2025-09-25 00:06:19'),
(22, 'Gisela', 'Agusti', 'gagusti@isft38.edu.ar', '$2y$10$1ythz9h.FAPKbxir1Cf0Lup5aYUoXV035d5kHQAXoMX1d4lXYa9IW', '31555669', '2000-01-01', 'Femenino', 'asdasdasd', 'asdadasd', NULL, '1758735928_contacto.jpg', 'asdasdas', '21312312', 'http://www.google.com', 2, 'usuario', 1, '2025-09-24 21:39:44', '2025-09-25 00:46:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aptitudes`
--
ALTER TABLE `aptitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aptitudes_usuario_id_foreign` (`usuario_id`);

--
-- Indexes for table `año_academico`
--
ALTER TABLE `año_academico`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `a??o_academico_a??o_unique` (`año`);

--
-- Indexes for table `beneficios_ofertas`
--
ALTER TABLE `beneficios_ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beneficios_ofertas_oferta_id_foreign` (`oferta_id`);

--
-- Indexes for table `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carrerasedes`
--
ALTER TABLE `carrerasedes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carrerasedes_carrera_id_foreign` (`carrera_id`),
  ADD KEY `carrerasedes_sede_id_foreign` (`sede_id`);

--
-- Indexes for table `carreras_ofertas`
--
ALTER TABLE `carreras_ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carreras_ofertas_carrera_id_foreign` (`carrera_id`),
  ADD KEY `carreras_ofertas_oferta_id_foreign` (`oferta_id`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comisions`
--
ALTER TABLE `comisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configuraciones`
--
ALTER TABLE `configuraciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `configuraciones_clave_unique` (`clave`);

--
-- Indexes for table `correlativas`
--
ALTER TABLE `correlativas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuatrimestres`
--
ALTER TABLE `cuatrimestres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cupos`
--
ALTER TABLE `cupos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cursos_usuario_id_foreign` (`usuario_id`);

--
-- Indexes for table `cvs`
--
ALTER TABLE `cvs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cvs_usuario_id_foreign` (`usuario_id`);

--
-- Indexes for table `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estudios`
--
ALTER TABLE `estudios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudios_usuario_id_foreign` (`usuario_id`);

--
-- Indexes for table `etiquetas`
--
ALTER TABLE `etiquetas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiencias_laborales`
--
ALTER TABLE `experiencias_laborales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `experiencias_laborales_usuario_id_foreign` (`usuario_id`);

--
-- Indexes for table `habilidades_blandas`
--
ALTER TABLE `habilidades_blandas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `habilidades_blandas_ofertas`
--
ALTER TABLE `habilidades_blandas_ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habilidades_blandas_ofertas_oferta_id_foreign` (`oferta_id`),
  ADD KEY `habilidades_blandas_ofertas_habilidad_blanda_id_foreign` (`habilidad_blanda_id`);

--
-- Indexes for table `historias`
--
ALTER TABLE `historias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modalidad_id` (`modalidad_id`),
  ADD KEY `cuatrimestre_id` (`cuatrimestre_id`),
  ADD KEY `fk_horarios_resolucion` (`resolucion_id`);

--
-- Indexes for table `idiomas`
--
ALTER TABLE `idiomas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idiomas_usuario_id_foreign` (`usuario_id`);

--
-- Indexes for table `idiomas_disponibles`
--
ALTER TABLE `idiomas_disponibles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idiomas_disponibles_nombre_idioma_unique` (`nombre_idioma`);

--
-- Indexes for table `idiomas_ofertas`
--
ALTER TABLE `idiomas_ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idiomas_ofertas_oferta_id_foreign` (`oferta_id`),
  ADD KEY `idiomas_ofertas_idioma_id_foreign` (`idioma_id`);

--
-- Indexes for table `lista_espera`
--
ALTER TABLE `lista_espera`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_materias_resolucion` (`resolucion_id`);

--
-- Indexes for table `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mesas_salon` (`salon_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modalidades`
--
ALTER TABLE `modalidades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modalidad_trabajos`
--
ALTER TABLE `modalidad_trabajos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `objetivos`
--
ALTER TABLE `objetivos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ofertas_modalidad_id_foreign` (`modalidad_id`),
  ADD KEY `ofertas_horario_id_foreign` (`horario_id`),
  ADD KEY `ofertas_carrera_id_foreign` (`carrera_id`),
  ADD KEY `ofertas_a??o_academico_id_foreign` (`año_academico_id`),
  ADD KEY `ofertas_estado_id_foreign` (`estado_id`);

--
-- Indexes for table `ofertas_guardadas`
--
ALTER TABLE `ofertas_guardadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ofertas_guardadas_oferta_id_foreign` (`oferta_id`),
  ADD KEY `ofertas_guardadas_usuario_id_foreign` (`usuario_id`);

--
-- Indexes for table `palabras_claves`
--
ALTER TABLE `palabras_claves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `palabras_claves_oferta_id_foreign` (`oferta_id`);

--
-- Indexes for table `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postulaciones_usuario_id_foreign` (`usuario_id`),
  ADD KEY `postulaciones_oferta_id_foreign` (`oferta_id`);

--
-- Indexes for table `preguntas_ofertas`
--
ALTER TABLE `preguntas_ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `preguntas_ofertas_oferta_id_foreign` (`oferta_id`);

--
-- Indexes for table `presidentes`
--
ALTER TABLE `presidentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presidentes_nombre_id_foreign` (`nombre_id`),
  ADD KEY `presidentes_apellido_id_foreign` (`apellido_id`),
  ADD KEY `presidentes_materia_id_foreign` (`materia_id`),
  ADD KEY `presidentes_carrera_id_foreign` (`carrera_id`);

--
-- Indexes for table `profesors`
--
ALTER TABLE `profesors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requisitos_ofertas`
--
ALTER TABLE `requisitos_ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requisitos_ofertas_oferta_id_foreign` (`oferta_id`);

--
-- Indexes for table `resoluciones`
--
ALTER TABLE `resoluciones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salons`
--
ALTER TABLE `salons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sedetelefonos`
--
ALTER TABLE `sedetelefonos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `times`
--
ALTER TABLE `times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `turnos`
--
ALTER TABLE `turnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `turnos_carrera_id_foreign` (`carrera_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuarios_email_unique` (`email`),
  ADD KEY `usuarios_carrera_id_foreign` (`carrera_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aptitudes`
--
ALTER TABLE `aptitudes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `año_academico`
--
ALTER TABLE `año_academico`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `beneficios_ofertas`
--
ALTER TABLE `beneficios_ofertas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `carrerasedes`
--
ALTER TABLE `carrerasedes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `carreras_ofertas`
--
ALTER TABLE `carreras_ofertas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `comisions`
--
ALTER TABLE `comisions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `configuraciones`
--
ALTER TABLE `configuraciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `correlativas`
--
ALTER TABLE `correlativas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `cuatrimestres`
--
ALTER TABLE `cuatrimestres`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cupos`
--
ALTER TABLE `cupos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cvs`
--
ALTER TABLE `cvs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `estados`
--
ALTER TABLE `estados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `estudios`
--
ALTER TABLE `estudios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `etiquetas`
--
ALTER TABLE `etiquetas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `experiencias_laborales`
--
ALTER TABLE `experiencias_laborales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `habilidades_blandas`
--
ALTER TABLE `habilidades_blandas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `habilidades_blandas_ofertas`
--
ALTER TABLE `habilidades_blandas_ofertas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `historias`
--
ALTER TABLE `historias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=846;

--
-- AUTO_INCREMENT for table `idiomas`
--
ALTER TABLE `idiomas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `idiomas_disponibles`
--
ALTER TABLE `idiomas_disponibles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `idiomas_ofertas`
--
ALTER TABLE `idiomas_ofertas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `lista_espera`
--
ALTER TABLE `lista_espera`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materias`
--
ALTER TABLE `materias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT for table `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `modalidades`
--
ALTER TABLE `modalidades`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `modalidad_trabajos`
--
ALTER TABLE `modalidad_trabajos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `objetivos`
--
ALTER TABLE `objetivos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ofertas_guardadas`
--
ALTER TABLE `ofertas_guardadas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `palabras_claves`
--
ALTER TABLE `palabras_claves`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `postulaciones`
--
ALTER TABLE `postulaciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `preguntas_ofertas`
--
ALTER TABLE `preguntas_ofertas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `presidentes`
--
ALTER TABLE `presidentes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profesors`
--
ALTER TABLE `profesors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `programas`
--
ALTER TABLE `programas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registros`
--
ALTER TABLE `registros`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requisitos_ofertas`
--
ALTER TABLE `requisitos_ofertas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `resoluciones`
--
ALTER TABLE `resoluciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `salons`
--
ALTER TABLE `salons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `sedetelefonos`
--
ALTER TABLE `sedetelefonos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `times`
--
ALTER TABLE `times`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `turnos`
--
ALTER TABLE `turnos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_horarios_resolucion` FOREIGN KEY (`resolucion_id`) REFERENCES `resoluciones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`modalidad_id`) REFERENCES `modalidades` (`id`),
  ADD CONSTRAINT `horarios_ibfk_2` FOREIGN KEY (`cuatrimestre_id`) REFERENCES `cuatrimestres` (`id`);

--
-- Constraints for table `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `fk_materias_resolucion` FOREIGN KEY (`resolucion_id`) REFERENCES `resoluciones` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `mesas`
--
ALTER TABLE `mesas`
  ADD CONSTRAINT `fk_mesas_salon` FOREIGN KEY (`salon_id`) REFERENCES `salons` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `presidentes`
--
ALTER TABLE `presidentes`
  ADD CONSTRAINT `presidentes_apellido_id_foreign` FOREIGN KEY (`apellido_id`) REFERENCES `profesors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `presidentes_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `presidentes_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `presidentes_nombre_id_foreign` FOREIGN KEY (`nombre_id`) REFERENCES `profesors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
