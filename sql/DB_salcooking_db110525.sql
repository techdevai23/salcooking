-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql305.infinityfree.com
-- Tiempo de generación: 11-05-2025 a las 12:52:41
-- Versión del servidor: 10.6.19-MariaDB
-- Versión de PHP: 7.2.22

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `if0_38954546_salcooking_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alergias`
--

CREATE TABLE `alergias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `alergias`
--

INSERT INTO `alergias` (`id`, `nombre`) VALUES
(1, 'frutos secos'),
(2, 'glúten'),
(3, 'pescado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos_premium`
--

CREATE TABLE `codigos_premium` (
  `id_codigo` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `usado_por_usuario_id` int(11) DEFAULT NULL,
  `fecha_uso` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `codigos_premium`
--

INSERT INTO `codigos_premium` (`id_codigo`, `codigo`, `activo`, `fecha_creacion`, `usado_por_usuario_id`, `fecha_uso`) VALUES
(1, '2987354', 0, '2025-05-11 12:54:08', 1, '2025-05-11 05:54:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dietas`
--

CREATE TABLE `dietas` (
  `id_dieta` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `nombre_dieta` varchar(100) DEFAULT NULL,
  `tipo` enum('Diaria','Semanal') DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dieta_receta`
--

CREATE TABLE `dieta_receta` (
  `id_dieta` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `comida` enum('Desayuno','Comida-entrante','Comida-principal','Comida-postre') NOT NULL,
  `dia_semana` enum('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfermedades`
--

CREATE TABLE `enfermedades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `enfermedades`
--

INSERT INTO `enfermedades` (`id`, `nombre`) VALUES
(2, 'colesterol'),
(1, 'diabetes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id`, `nombre`) VALUES
(86, 'Aceite de coco'),
(205, 'Aceite de coco virgen'),
(361, 'Aceite de girasol'),
(31, 'Aceite de oliva'),
(46, 'Aceite de oliva virgen extra'),
(168, 'Aceite de sésamo'),
(269, 'Aceite de sésamo tostado'),
(29, 'Aceitunas negras'),
(533, 'Aceitunas negras sin hueso'),
(422, 'Acelgas'),
(144, 'Agua'),
(736, 'Agua o caldo de verduras'),
(44, 'Aguacate'),
(5, 'Ajo'),
(567, 'Ajo en polvo'),
(806, 'Ajo laminado'),
(407, 'Albahaca fresca'),
(693, 'Albaricoques secos'),
(901, 'Alcachofas'),
(268, 'Alga nori'),
(585, 'Alga wakame'),
(915, 'Almendras crudas'),
(45, 'Almendras laminadas'),
(146, 'Apio'),
(125, 'Arándanos'),
(483, 'Arándanos deshidratados sin azúcar'),
(648, 'Arroz basmati'),
(587, 'Arroz integral'),
(910, 'Arroz redondo'),
(98, 'Avena sin gluten'),
(36, 'Azúcar'),
(252, 'Azúcar de coco'),
(643, 'Azúcar moreno'),
(112, 'Bebida vegetal de almendras'),
(159, 'Bebida vegetal de arroz'),
(107, 'Bebida vegetal de avena'),
(135, 'Bebida vegetal sin azúcar'),
(245, 'Bebida vegetal sin frutos secos'),
(79, 'Berenjena'),
(474, 'Bisaltos'),
(771, 'Blimis'),
(231, 'Boniato'),
(812, 'Brocheta de madera'),
(164, 'Brócoli'),
(856, 'Brócoli fresco'),
(521, 'Brotes de espinaca'),
(414, 'Bulbo de hinojo'),
(673, 'Bulgur'),
(719, 'Caballa'),
(39, 'Cacao en polvo'),
(77, 'Calabacín'),
(442, 'Calabaza'),
(912, 'Calamares'),
(914, 'Caldo de pescado'),
(310, 'Caldo de verduras'),
(326, 'Caldo de verduras sin gluten'),
(888, 'Caldo vegetal'),
(204, 'Canela'),
(85, 'Canela en polvo'),
(298, 'Canela en rama'),
(523, 'Canónigos'),
(765, 'Carne picada de pavo'),
(100, 'Cebolla'),
(80, 'Cebolla morada'),
(766, 'Cebolla tierna'),
(584, 'Cebolleta'),
(475, 'Champiñones'),
(735, 'Chile ancho seco'),
(768, 'Chile en polvo'),
(734, 'Chile guajillo seco'),
(642, 'Chile molido'),
(504, 'Chile rojo'),
(41, 'Chocolate negro'),
(289, 'Chocolate negro 70%'),
(641, 'Chuleta de cerdo'),
(692, 'Chuletillas de cordero'),
(362, 'Cilantro'),
(723, 'Cilantro fresco'),
(526, 'Cilantro fresco picado'),
(360, 'Col'),
(196, 'Colágeno hidrolizado en polvo'),
(704, 'Coliflor'),
(373, 'Coliflor rallada'),
(271, 'Comino molido'),
(244, 'Copos de arroz sin gluten'),
(106, 'Copos de avena'),
(279, 'Copos de avena integral'),
(84, 'Copos de avena sin gluten'),
(837, 'Crackers de arroz inflado'),
(4, 'Crema de leche'),
(145, 'Cúrcuma'),
(189, 'Cúrcuma en polvo'),
(463, 'Curry en polvo'),
(544, 'Curry suave en polvo'),
(628, 'Cuscús integral'),
(40, 'Dulce de leche'),
(154, 'Eritritol'),
(225, 'Esencia de vainilla'),
(867, 'Espaguetis de mar'),
(659, 'Espaguetis integrales'),
(889, 'Espárragos trigueros'),
(398, 'Espárragos verdes'),
(188, 'Espinacas'),
(683, 'Espinacas baby'),
(111, 'Espinacas frescas'),
(618, 'Filete de pechuga de pavo'),
(681, 'Filete de salmón fresco'),
(152, 'Frambuesas'),
(124, 'Fresas'),
(239, 'Frutas del bosque'),
(93, 'Frutas frescas'),
(117, 'Frutos rojos'),
(195, 'Frutos rojos congelados'),
(913, 'Gambas'),
(707, 'Garam masala'),
(260, 'Garbanzos cocidos'),
(389, 'Granada'),
(674, 'Guindilla roja seca'),
(900, 'Guisantes'),
(309, 'Guisantes verdes'),
(899, 'Habas'),
(134, 'Harina de arroz integral'),
(286, 'Harina de avena integral'),
(143, 'Harina de garbanzo'),
(820, 'Harina de maíz'),
(237, 'Harina de sorgo'),
(35, 'Harina de trigo'),
(224, 'Harina de yuca'),
(916, 'Hebras de azafrán'),
(176, 'Hielo'),
(317, 'Hierbabuena'),
(519, 'Higos frescos'),
(482, 'Hinojo'),
(197, 'Hojas de menta fresca'),
(91, 'Huevo'),
(37, 'Huevos'),
(232, 'Hummus natural'),
(733, 'Jaca verde en conserva'),
(756, 'Jamón cocido bajo en sodio'),
(167, 'Jengibre'),
(645, 'Jengibre en polvo'),
(299, 'Jengibre fresco'),
(462, 'Jengibre fresco rallado'),
(332, 'Judías verdes'),
(769, 'Judías verdes redondas'),
(721, 'Jugo de lima'),
(32, 'Jugo de limón'),
(153, 'Kiwi'),
(254, 'Kiwi oro'),
(672, 'Langostinos'),
(807, 'Leche'),
(123, 'Leche de coco'),
(543, 'Leche de coco ligera'),
(649, 'Leche de coco sin azúcar'),
(767, 'Leche de coco sin azúcares añadidos'),
(481, 'Leche vegetal sin azúcar'),
(26, 'Lechuga'),
(722, 'Lenteja verdina cocida'),
(491, 'Lentejas cocidas'),
(784, 'Lentejas rojas'),
(502, 'Lima'),
(81, 'Limón'),
(376, 'Maicena'),
(288, 'Mandarina'),
(644, 'Mango'),
(432, 'Mango maduro'),
(38, 'Mantequilla'),
(160, 'Manzana'),
(324, 'Manzana verde'),
(911, 'Mejillones'),
(316, 'Melón'),
(311, 'Menta fresca'),
(108, 'Miel'),
(158, 'Mijo'),
(887, 'Mostaza de Dijon'),
(399, 'Mostaza de Dijon sin gluten'),
(287, 'Naranja'),
(42, 'Nata para montar'),
(2, 'Nueces'),
(520, 'Nueces peladas'),
(431, 'Nuez moscada'),
(511, 'Ocras'),
(234, 'Orégano seco'),
(884, 'Ortigas frescas'),
(89, 'Pan integral'),
(261, 'Pan integral sin frutos secos'),
(808, 'Pan rallado sin gluten'),
(501, 'Papaya verde'),
(629, 'Pasas sultanas'),
(1, 'Pasta'),
(876, 'Pasta de koji'),
(582, 'Pasta de miso'),
(525, 'Pasta harissa'),
(597, 'Pasta integral'),
(312, 'Patata'),
(532, 'Patata cocida'),
(142, 'Patatas'),
(128, 'Pechuga de pavo'),
(598, 'Pechuga de pollo'),
(783, 'Pechuga de pollo sin piel'),
(28, 'Pepino'),
(174, 'Pera'),
(82, 'Perejil'),
(444, 'Perejil fresco'),
(809, 'Perejil fresco picado'),
(706, 'Pierna de cordero magra'),
(7, 'Pimienta'),
(313, 'Pimienta blanca'),
(48, 'Pimienta negra'),
(130, 'Pimienta negra molida'),
(388, 'Pimiento amarillo'),
(78, 'Pimiento rojo'),
(387, 'Pimiento verde'),
(810, 'Pimientos del padrón'),
(413, 'Piña natural'),
(83, 'Plátano'),
(759, 'Polenta instantánea'),
(703, 'Pollo'),
(136, 'Polvo de hornear sin gluten'),
(175, 'Proteína de guisante'),
(844, 'Proteína vegetal de guisante texturizada'),
(325, 'Puerro'),
(282, 'Puré de plátano'),
(405, 'Queso batido 0% grasa'),
(297, 'Queso cottage bajo en grasa'),
(129, 'Queso crema sin lactosa'),
(30, 'Queso feta'),
(819, 'Queso fresco batido 0%'),
(344, 'Queso fresco desnatado'),
(662, 'Queso parmesano rallado'),
(374, 'Queso rallado bajo en grasa'),
(811, 'Queso roquefort'),
(43, 'Quinoa'),
(569, 'Ralladura de lima'),
(253, 'Ralladura de limón'),
(342, 'Remolacha cocida'),
(331, 'Repollo'),
(745, 'Repollo morado'),
(238, 'Ricotta vegana'),
(705, 'Romero fresco'),
(619, 'Romero seco'),
(522, 'Rúcula'),
(343, 'Rúcula fresca'),
(6, 'Sal'),
(162, 'Sal marina'),
(3, 'Salmón'),
(720, 'Salsa de pescado'),
(503, 'Salsa de pescado vegetal'),
(464, 'Salsa de soja baja en sodio'),
(553, 'Salsa de soja sin gluten'),
(166, 'Salsa tamari'),
(300, 'Salvia'),
(757, 'Salvia fresca'),
(524, 'Salvia roja'),
(834, 'Sardinas frescas'),
(118, 'Semillas de calabaza'),
(113, 'Semillas de chía'),
(281, 'Semillas de girasol'),
(280, 'Semillas de lino'),
(246, 'Semillas de lino molidas'),
(270, 'Semillas de sésamo'),
(163, 'Semillas de sésamo tostado'),
(583, 'Setas shiitake'),
(886, 'Setas variadas'),
(206, 'Sirope de agave'),
(161, 'Sirope de arroz'),
(885, 'Soja texturizada fina'),
(805, 'Solomillo de cerdo'),
(660, 'Solomillo de vacuno'),
(119, 'Stevia líquida'),
(165, 'Tahini'),
(566, 'Tempeh de garbanzos'),
(661, 'Tirabeques'),
(461, 'Tofu firme'),
(262, 'Tomate'),
(27, 'Tomate cherry'),
(835, 'Tomate maduro'),
(542, 'Tomate natural triturado'),
(845, 'Tomate triturado natural'),
(233, 'Tomates cherry'),
(406, 'Tomates secos'),
(836, 'Tomillo fresco'),
(599, 'Tomillo seco'),
(284, 'Uvas moscatel'),
(92, 'Vinagre blanco'),
(554, 'Vinagre de arroz'),
(684, 'Vinagre de granada'),
(318, 'Vinagre de manzana'),
(772, 'Vinagre de manzana sin filtrar'),
(902, 'Vinagre de vino blanco'),
(758, 'Vino blanco seco'),
(675, 'Vino de Jerez seco'),
(116, 'Yogur griego natural sin azúcar'),
(682, 'Yogur natural desnatado sin azúcar'),
(283, 'Yogur natural sin azúcar'),
(708, 'Yogur vegetal natural'),
(568, 'Yogur vegetal natural sin azúcar'),
(443, 'Za\'atar'),
(99, 'Zanahoria'),
(646, 'Zanahoria baby'),
(855, 'Zanahoria rallada'),
(770, 'Zanahorias baby'),
(433, 'Zumo de lima'),
(47, 'Zumo de limón'),
(857, 'Zumo de limón natural'),
(375, 'Zumo de naranja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_compra`
--

CREATE TABLE `lista_compra` (
  `id_lista` int(11) NOT NULL,
  `id_dieta` int(11) NOT NULL,
  `nombre_ingrediente` varchar(100) NOT NULL,
  `cantidad_total` decimal(10,2) DEFAULT NULL,
  `unidad` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id_perfil` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `enfermedades` text DEFAULT NULL,
  `alergias` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id_perfil`, `id_usuario`, `nick`, `enfermedades`, `alergias`) VALUES
(1, 1, 'JS', 'Diabetes,Colesterol', 'Frutos secos,Gluten'),
(2, 1, 'esposa', 'Hipertensión', 'Pescado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `instrucciones` text NOT NULL,
  `sustitutos` text DEFAULT NULL,
  `tiempo_preparacion` int(11) NOT NULL DEFAULT 1,
  `porciones` int(11) NOT NULL DEFAULT 4,
  `enlace_receta` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`id`, `nombre`, `instrucciones`, `sustitutos`, `tiempo_preparacion`, `porciones`, `enlace_receta`) VALUES
(1, 'pechuga\r\n', 'ddfs', 'sas', 1, 4, NULL),
(2, 'sopa', 'ddsfdssdf', 'dsffsddfs', 5, 4, NULL),
(3, 'ensalada', 'dfdsfdsfd', 'dsfdsf', 4, 4, 'fdsfsfd'),
(7, 'Ensalada Mediterránea con Queso Feta', 'Lava y corta la lechuga en trozos pequeños. Corta los tomates cherry y el pepino en rodajas. Mezcla los ingredientes en un bol y añade el queso feta desmenuzado. Prepara un aderezo con aceite de oliva, jugo de limón, sal y pimienta. Mezcla todo bien y sirve fresca.', 'No se utilizaron frutos secos en la receta.', 15, 2, 'https://www.recetasmediterraneas.com/ensalada-feta'),
(8, 'Pasta con Salsa de Nueces y Salmón', 'Cocinar la pasta en agua hirviendo con sal hasta que esté al dente. Mientras tanto, triturar las nueces con crema y ajo. En una sartén, dorar el salmón y agregar la salsa de nueces. Mezclar con la pasta cocida y servir caliente.', 'Pasta sin gluten en lugar de pasta regular', 30, 2, 'https://www.recetasgratis.net/receta-de-pasta-con-salmon-y-nueces-71069.html'),
(9, 'Ensalada de Quinoa con Aguacate y Almendras', 'Lavar bien la quinoa y cocinarla en agua durante 12-15 minutos. Cortar el aguacate, tomates y pepino. Tostar almendras. Mezclar todo con la quinoa enfriada. Aliñar con aceite, limón, sal y pimienta. Servir fresca.', 'No se utilizaron sustitutos; todos los ingredientes son naturalmente sin gluten.', 25, 2, 'https://www.recetasgratis.net/receta-de-ensalada-de-quinoa-con-aguacate-y-almendras-68591.html'),
(10, 'Tarta de Chocolate con Dulce de Leche', 'Precalienta el horno a 180 °C. En un bol, mezcla la mantequilla derretida con el azúcar y los huevos hasta que esté espumoso. Añade la harina y el cacao tamizados. Mezcla bien. Vierte la mezcla en un molde engrasado y hornea durante 25 minutos. Deja enfriar completamente. Cubre con una capa generosa de dulce de leche. Derrite el chocolate con la nata y vierte por encima. Refrigera al menos 2 horas antes de servir.', 'Ninguno, se usaron ingredientes tradicionales.', 60, 8, 'https://www.recetasdesbieta.com/tarta-chocolate-dulce-de-leche/'),
(11, 'Ensalada de Quinoa con Verduras Asadas', 'Enjuagar la quinoa y cocinarla en agua con sal. Cortar verduras y asar con aceite de oliva. Mezclar con la quinoa cocida, aliñar con limón y perejil. Servir templado o frío.', 'Ninguno. La receta ya es libre de frutos secos.', 35, 2, 'https://www.recetasgratis.net/receta-de-ensalada-de-quinoa-y-verduras-77158.html'),
(12, 'Tortitas de Avena y Plátano sin Gluten', 'Tritura el plátano, añade huevos y mezcla con avena y canela. Cocina en sartén con aceite de coco 2-3 min por lado.', 'Copos de avena sin gluten en lugar de avena tradicional', 15, 2, 'https://www.recetasgratis.net/receta-de-tortitas-de-avena-y-platano-sin-gluten-68512.html'),
(14, 'Tostadas Integrales con Crema de Aguacate y Nueces', 'Tostar pan integral. Triturar aguacate con ajo, limón, aceite, sal y pimienta. Untar sobre el pan y añadir nueces picadas. Servir inmediatamente.', 'Ninguno', 10, 1, 'https://www.recetasgratis.net/receta-de-tostadas-de-aguacate-con-nueces-67893.html'),
(15, 'Tostadas integrales con aguacate, huevo poché y frutas frescas', 'Tostar el pan integral. Aplastar el aguacate y sazonar. Untar sobre el pan. Cocinar un huevo poché y colocar sobre la tostada. Servir con frutas frescas.', 'Ninguno necesario. Opcionalmente usar pan integral sin gluten para celíacos.', 15, 1, 'https://www.pequerecetas.com/receta/tostadas-aguacate-huevo'),
(16, 'Tortilla de Verduras con Avena sin Gluten', 'Bate los huevos en un bol grande. Agrega la avena sin gluten, zanahoria rallada, calabacín rallado y cebolla picada. Mezcla y deja reposar 5 minutos. Calienta aceite en una sartén, cocina la mezcla hasta dorar por ambos lados. Sirve caliente.', 'Avena certificada sin gluten en lugar de avena convencional', 20, 2, 'https://www.pequerecetas.com/receta/tortilla-de-verduras/'),
(17, 'Avena cocida con plátano y canela', 'Calentar la bebida vegetal o leche. Añadir la avena y cocinar a fuego lento hasta espesar. Servir con plátano en rodajas y canela espolvoreada. Opcionalmente, endulzar con miel.', 'Se ha utilizado bebida de avena en lugar de leche de vaca para una versión más ligera.', 10, 1, 'https://www.pequerecetas.com/receta/avena-con-platano'),
(18, 'Smoothie Verde de Espinacas, Plátano y Almendras', 'Lavar las espinacas. Pelar el plátano y cortarlo en rodajas. Mezclar espinacas, plátano, bebida vegetal de almendras y semillas de chía en una licuadora. Triturar hasta obtener un batido cremoso. Añadir miel si se desea. Servir frío.', 'Bebida vegetal de almendras en lugar de leche de vaca', 5, 1, 'https://www.pequerecetas.com/receta/batido-verde-espinacas-platano/'),
(19, 'Parfait de Yogur Griego con Frutas y Semillas', 'En un vaso o bol, colocar una capa de yogur griego en el fondo. Añadir una capa de frutos rojos frescos. Espolvorear con semillas de chía y calabaza. Repetir hasta llenar el vaso. Espolvorear canela por encima y endulzar con stevia si se desea. Servir frío.', 'Stevia o eritritol en lugar de azúcar convencional. Yogur griego natural sin azúcar en lugar de yogures azucarados.', 10, 1, 'https://www.pequerecetas.com/receta/parfait-yogur-griego-frutas/'),
(20, 'Pudding de Chía con Leche de Coco y Fruta', 'Mezclar semillas de chía con leche de coco. Añadir miel si se desea. Refrigerar 4 horas o toda la noche. Servir con fresas y arándanos frescos.', 'Semillas de chía en lugar de cereales con gluten. Leche de coco sin azúcar en vez de leche de vaca.', 10, 1, 'https://www.pequerecetas.com/receta/pudding-chia/'),
(21, 'Rollitos de Pavo con Espinacas y Queso', 'Lavar las espinacas y secarlas. Saltear en mantequilla con sal y pimienta. Untar queso crema sobre lonchas de pavo, colocar espinacas y enrollar. Servir fríos o calientes.', 'No se utilizaron sustitutos', 10, 1, 'https://www.pequerecetas.com/receta/rollitos-de-pavo-y-espinacas/'),
(22, 'Tortitas de Plátano y Harina de Arroz (sin gluten, sin frutos secos, sin pescado, sin lácteos)', 'En un bol, machaca el plátano hasta obtener un puré. Añade el huevo y mezcla bien. Incorpora la harina de arroz, el polvo de hornear, la canela y la sal. Mezcla hasta obtener una masa homogénea. Agrega la bebida vegetal poco a poco, mezclando hasta que la masa tenga una consistencia adecuada para verter en la sartén. Calienta una sartén antiadherente a fuego medio y engrásala ligeramente con aceite de oliva. Vierte porciones de la masa en la sartén, formando tortitas del tamaño deseado. Cocina cada tortita durante aproximadamente 2-3 minutos por cada lado, o hasta que estén doradas y cocidas por dentro. Sirve calientes. Puedes acompañarlas con rodajas de plátano fresco o una compota de frutas sin azúcar añadida.', 'Harina de arroz integral en lugar de harina de trigo. Bebida vegetal sin azúcar en lugar de leche de vaca.', 15, 1, 'https://www.pinterest.com/pin/303289356163735064/'),
(23, 'Tortilla Vegana de Patatas con Crudités', 'Pelar y cortar las patatas en rodajas finas y la cebolla en juliana. En una sartén antiadherente, saltear las patatas y la cebolla con aceite de oliva hasta que estén tiernas. Mezclar la harina de garbanzo con agua, sal y cúrcuma. Añadir las patatas y cebolla cocinadas. Verter la mezcla en la sartén y cocinar durante 5-7 minutos por cada lado. Servir con bastones de zanahoria, pepino y apio.', 'Harina de garbanzo en lugar de huevo', 30, 1, 'https://www.veganoporaccidentespain.com/receta-tortilla-de-patatas-vegana/'),
(24, 'Ensalada Dulce de Frutos Rojos, Kiwi y Almendras', 'Lavar fresas y frambuesas. Cortar fresas y kiwi en trozos pequeños. Mezclar en bol. Añadir jugo de limón y edulcorante si se desea. Espolvorear almendras antes de servir.', 'Edulcorante natural en lugar de miel o azúcar.', 10, 1, 'https://www.recetasgratis.net/receta-de-ensalada-de-frutas-rojas-y-kiwi-71349.html'),
(25, 'Porridge de Mijo con Manzana y Canela', 'Lavar el mijo. Cocinar en bebida de arroz con una pizca de sal a fuego bajo hasta que esté cremoso. Añadir manzana a mitad de cocción. Agregar canela y sirope de arroz opcionalmente. Servir caliente decorado con semillas de sésamo tostado.', 'Bebida vegetal de arroz en lugar de leche de vaca. Mijo como base sin gluten.', 25, 1, 'https://www.recetasgratis.net/receta-de-porridge-de-mijo-con-manzana-69287.html'),
(26, 'Bowl Macrobiótico de Mijo con Verduras y Tahini', 'Lavar el mijo y cocerlo con agua y sal. Saltear las verduras en aceite de sésamo con jengibre. Mezclar tahini con tamari para crear salsa. Servir el mijo con verduras por encima y rociar con la salsa.', 'Salsa tamari en lugar de salsa de soja convencional (para evitar gluten). Tahini como fuente de grasa saludable. Mijo como cereal sin gluten.', 30, 1, 'https://www.lacocinadevero.com/buddha-bowl-macrobiotico/'),
(27, 'Batido Verde de Pera, Perejil y Proteína de Guisante', 'Trocear la pera y colocar en licuadora con perejil, proteína de guisante, jugo de limón y bebida vegetal o agua. Triturar hasta obtener textura homogénea. Añadir hielo si se desea.', 'Proteína de guisante como fuente vegetal. Bebida vegetal en lugar de leche. Sin plátano ni frutos secos.', 5, 1, 'https://www.recetasgratis.net/receta-de-batido-verde-de-pera-y-perejil-71581.html'),
(29, 'Tortilla de Espinacas con Aguacate y Cúrcuma', 'Bate los huevos junto con la cúrcuma, sal y pimienta. Calienta el aceite de coco y saltea las espinacas. Vierte los huevos sobre las espinacas y cocina hasta formar la tortilla. Sirve con rodajas de aguacate.', 'Ninguno necesario', 15, 1, 'https://www.recetasgratis.net/receta-de-tortilla-de-espinacas-con-aguacate-71643.html'),
(30, 'Smoothie Antiinflamatorio de Frutos Rojos, Aguacate y Colágeno', 'En una licuadora, combina los frutos rojos congelados, el aguacate, la bebida vegetal, las semillas de chía, el colágeno en polvo, la cúrcuma, la pimienta negra y el jugo de limón. Licúa hasta obtener una mezcla suave y homogénea. Si deseas una consistencia más líquida, puedes añadir más bebida vegetal. Sirve en un vaso y decora con hojas de menta fresca si lo deseas. Disfruta inmediatamente para aprovechar al máximo sus nutrientes.', 'Semillas de chía en lugar de frutos secos para aportar ácidos grasos omega-3 y fibra. Bebida vegetal sin azúcar en lugar de leche convencional para evitar lácteos y azúcares añadidos. Colágeno hidrolizado en polvo como fuente de proteína sin recurrir a productos de origen animal completo.', 10, 2, 'https://www.hazteveg.com/receta/7869'),
(32, 'Porridge de avena sin gluten con frutos rojos, chía y cúrcuma', 'Calentar bebida vegetal, añadir avena, cúrcuma, pimienta y canela. Cocinar removiendo hasta espesar. Agregar chía y reposar. Servir con frutos rojos, aceite de coco y miel opcional.', 'Avena sin gluten en lugar de avena común', 15, 1, 'https://www.recetasgratis.net/receta-de-gachas-de-avena-con-frutas-71699.html'),
(33, 'Panqueques de Yuca y Coco sin Gluten', 'Mezclar harina de yuca, huevo, leche de coco, aceite, vainilla, sal y eritritol. Cocinar en sartén 2-3 min por lado. Servir tibios.', 'Harina de yuca sin gluten en lugar de harina de trigo. Leche de coco en lugar de leche animal.', 20, 2, 'https://www.recetasgratis.net/receta-de-panqueques-de-yuca-y-coco-sin-gluten-78942.html'),
(34, 'Tostadas de Boniato con Hummus y Tomates Cherry', 'Cortar el boniato en lonchas y asar. Untar con hummus y cubrir con tomates cherry. Añadir sal, orégano y aceite. Servir caliente o templado.', 'Boniato en lugar de pan. Hummus sin tahini opcional como proteína vegetal.', 20, 1, 'https://www.recetasgratis.net/receta-de-tostadas-de-boniato-con-hummus-y-tomates-90002.html'),
(35, 'Crepes de Harina de Sorgo con Ricotta Vegana y Frutas del Bosque', 'Mezclar harina de sorgo, huevo y bebida vegetal. Cocinar crepes. Rellenar con ricotta vegana y frutas. Servir con stevia si se desea.', 'Harina de sorgo sin gluten. Ricotta vegetal. Stevia en lugar de azúcar.', 20, 1, 'https://www.recetasvegansaludable.com/crepes-de-sorgo-con-ricotta-vegana-y-frutas'),
(36, 'Porridge de Copos de Arroz con Frutas y Semillas', '1. En un cazo, calienta la bebida vegetal hasta que comience a hervir. 2. Añade los copos de arroz y cocina a fuego lento durante 5-7 minutos, removiendo ocasionalmente, hasta que la mezcla espese. 3. Incorpora las semillas de chía, las semillas de lino molidas y la canela. Mezcla bien y cocina por 2 minutos más. 4. Retira del fuego y deja reposar un par de minutos. 5. Sirve en un bol, añade el plátano en rodajas y los frutos rojos por encima. 6. Si lo deseas, añade un toque de sirope de agave para endulzar.', 'Se usaron copos de arroz y bebida vegetal sin frutos secos para evitar alérgenos.', 15, 1, 'https://www.huffingtonpost.es/life/salud/la-avena-queda-desactualizada-nuevo-desayuno-mazazo-colesterol-malo.html'),
(37, 'Pa de Pessic con Harina de Arroz y Kiwi Oro', 'Precalentar horno a 180 °C. Separar claras y yemas. Batir claras a punto de nieve. Batir yemas con azúcar hasta esponjoso. Añadir ralladura, harina y polvo de hornear. Integrar claras suavemente. Hornear 30 minutos. Servir con kiwi oro fresco.', 'Harina de arroz integral en lugar de trigo. Azúcar de coco como opción saludable.', 40, 6, 'https://www.recetasparaninos.net/pa-de-pessic-con-harina-de-arroz-y-kiwi'),
(38, 'Tostadas de Garbanzo Batido con Tomate y Orégano', 'Tritura garbanzos con sal, orégano y aceite. Tuesta pan. Ralla tomate y úntalo sobre el pan con garbanzo. Añade orégano y pimienta. Servir inmediatamente.', 'Garbanzos en lugar de aguacate o queso. Pan sin frutos secos.', 15, 1, 'https://www.recetassaludables.com/tostadas-de-garbanzo-y-tomate'),
(39, 'Chips de Alga Nori con Sésamo y Paté de Berenjena', 'Cortar alga nori y untar con aceite de sésamo, espolvorear semillas y hornear 10-12 min a 150°C. Asar berenjenas 40 min, triturar con tahini, ajo, aceite de oliva, limón, comino, sal y pimienta. Servir el paté con las chips.', 'Tahini como alternativa cremosa saludable sin frutos secos ni lácteos.', 50, 2, 'https://www.elespanol.com/cocinillas/recetas/aperitivos-y-entrantes/20140325/pate-berenjena-receta-facil-rapida/1000045045502_30.html'),
(40, 'Cereal crujiente horneado con yogur y uvas moscatel', 'Mezclar avena, semillas, canela y sal. Añadir puré de plátano y aceite. Formar grumos y hornear a 160 °C por 25 min. Enfriar y servir con yogur y uvas moscatel.', 'Puré de plátano en vez de miel. Yogur sin azúcar. Avena certificada sin gluten si se desea.', 35, 1, 'https://www.recetas-saludables.net/cereal-horneado-yogur-uvas'),
(41, 'Gofre de Avena con Mermelada Casera de Cítricos y Chocolate 70%', 'Preparar la mermelada cocinando los cítricos con agua y luego mezclando con chía y stevia. Mezclar ingredientes del gofre y cocinar en gofrera. Servir con la mermelada y chocolate negro rallado.', 'Stevia en lugar de azúcar. Harina de avena y bebida vegetal sin azúcar en lugar de harina refinada y leche.', 25, 1, 'https://www.recetasgratis.net/receta-de-gofres-de-avena-con-mermelada-de-citricos-y-chocolate-71550.html'),
(42, 'Muffins Salados con Té de Canela, Jengibre y Salvia (Desayuno funcional para diabetes)', 'Preparar los muffins batiendo huevos con bebida vegetal, añadir espinacas, queso cottage, harina de garbanzo, sal y pimienta. Hornear 25 min. Para el té: hervir agua con canela y jengibre 5 min, infusionar con salvia 10 min. Colar, enfriar y servir. Acompañar juntos.', 'Harina de garbanzo en vez de refinada. Bebida vegetal sin azúcar. Salvia en vez de moringa.', 30, 1, 'https://www.recetasgratis.net/receta-de-desayuno-funcional-muffins-y-te-de-salvia-89483.html'),
(43, 'Crema fría de guisantes y menta', 'Hervir patata y guisantes en caldo de verduras. Triturar con menta. Ajustar textura. Sazonar. Refrigerar y servir con aceite y menta.', 'No se utilizaron sustitutos. Todos los ingredientes son naturalmente libres de pescado, gluten y frutos secos.', 20, 2, 'https://www.recetasgratis.net/receta-de-crema-fria-de-guisantes-y-menta-vegetariana-72123.html'),
(44, 'Gazpacho de Melón y Pepino con Hierbabuena', 'Pelar y cortar melón y pepino. Triturar junto a hierbabuena, aceite, vinagre, sal y pimienta hasta obtener textura cremosa. Servir frío con hoja decorativa.', 'No se utilizaron sustitutos. Todos los ingredientes son naturalmente libres de gluten, pescado, marisco y frutos secos.', 10, 2, 'https://www.recetasgratis.net/receta-de-gazpacho-de-melon-y-pepino-con-hierbabuena-82391.html'),
(45, 'Crema fría de calabacín y manzana sin gluten', 'Lavar y trocear el calabacín, la manzana y el puerro. Sofreír el puerro en aceite. Añadir el calabacín y la manzana. Incorporar caldo sin gluten y cocer. Triturar y enfriar. Servir fría.', 'Caldo de verduras sin gluten en lugar de otros con posibles trazas de gluten o pescado.', 25, 2, 'https://www.recetasparaceliacos.com/receta-crema-fria-de-calabacin-y-manzana'),
(46, 'Sopa Juliana de Verduras Saludable', 'Lava y corta las verduras en juliana. Sofríe el ajo y puerro con aceite. Añade el resto de verduras, rehoga, agrega agua, sal y pimienta. Cocina 25 min. Sirve caliente.', 'No se utilizaron sustitutos. Todos los ingredientes son naturalmente sin gluten, sin frutos secos ni pescado.', 30, 2, 'https://www.recetasgratis.net/receta-de-sopa-juliana-de-verduras-saludable-94815.html'),
(47, 'Ensalada de Remolacha, Naranja y Rúcula', 'Cortar la remolacha y la naranja. Lavar rúcula. Mezclar todos los ingredientes, añadir queso si se desea. Aliñar con aceite, vinagre, sal y pimienta. Servir fresca.', 'No se usaron sustitutos. Todos los ingredientes son naturalmente libres de gluten, frutos secos y pescado. El queso puede omitirse para una versión vegana.', 10, 2, 'https://www.recetasgratis.net/receta-de-ensalada-de-remolacha-naranja-y-rucula-79820.html'),
(48, 'Gazpacho de Remolacha y Yogur Natural', 'Pelar y trocear remolacha, tomate, pepino y pimiento. Añadir ajo, aceite, vinagre, sal y pimienta. Triturar. Agregar yogur y volver a batir. Refrigerar. Servir frío.', 'No se utilizaron sustitutos, todos los ingredientes son naturalmente libres de frutos secos.', 15, 2, 'https://www.recetasgratis.net/receta-de-gazpacho-de-remolacha-con-yogur-80088.html'),
(49, 'Rollitos de col rellenos de verduras con mayonesa de cilantro', 'Preparar las hojas de col blanqueándolas. Saltear las verduras cortadas en juliana. Enrollar el relleno en las hojas de col. Preparar la mayonesa de cilantro emulsionando el huevo con aceite, ajo, jugo de limón y cilantro. Servir los rollitos con la mayonesa.', 'Se ha utilizado aceite de girasol en lugar de aceite de oliva en la mayonesa para obtener un sabor más neutro y evitar posibles amargores.', 30, 2, 'https://www.recetasaludable.es/rollitos-col-verduras-mayonesa-cilantro'),
(50, 'Tartaletas de Coliflor con Wok de Verduras y Salsa Cítrica', 'Preparar la base de coliflor mezclando coliflor rallada, huevo, queso, sal y pimienta. Hornear en moldes durante 20 minutos a 180°C. Saltear brócoli, zanahoria y pimiento con ajo en aceite de oliva. Preparar la salsa cítrica con zumo de naranja y limón, jengibre y maicena. Montar las tartaletas con las verduras y la salsa.', 'Se ha utilizado coliflor en lugar de harinas para la base, evitando el gluten y reduciendo los carbohidratos.', 45, 2, 'https://www.recetasgratis.net/receta-de-tartaletas-de-coliflor-con-verduras-y-salsa-citrica-70000.html'),
(51, 'Escalivada de Berenjena, Calabacín y Pimientos con Salsa de Granada', 'Precalienta el horno a 200 °C. Lava y corta la berenjena, el calabacín y los pimientos en tiras o rodajas. Coloca las verduras en una bandeja de horno, rocíalas con el aceite de oliva, salpimienta al gusto y mezcla bien. Asa las verduras durante 25-30 minutos, volteándolas a mitad de cocción para que se doren uniformemente. Mientras se asan las verduras, prepara la salsa: en un bol, mezcla los granos de granada, la miel, el aceite de oliva, el zumo de limón y una pizca de sal. Remueve bien y reserva. Una vez asadas las verduras, colócalas en una fuente y vierte la salsa de granada por encima antes de servir.', 'No se han utilizado sustitutos; todos los ingredientes son naturalmente libres de frutos secos y adecuados para personas con colesterol alto.', 45, 2, 'https://www.recetasgratis.net/receta-de-escalivada-de-berenjena-calabacin-y-pimientos-con-salsa-de-granada-92502.html'),
(52, 'Espárragos Verdes a la Plancha con Huevo Mollet y Vinagreta de Mostaza', 'Lava los espárragos y corta la base. Ásalos a la plancha 4-5 min. Cuece el huevo 6 min y pélalo. Mezcla aceite, vinagre, mostaza, sal y pimienta para la vinagreta. Sirve espárragos con huevo encima y vinagreta.', 'Mostaza sin gluten en lugar de mostaza convencional.', 15, 1, 'https://www.recetasgratis.net/receta-de-esparragos-a-la-plancha-con-huevo-y-vinagreta-78932.html'),
(53, 'Rollitos de Calabacín con Queso Batido y Tomate Seco', 'Cortar el calabacín en tiras finas. Asarlas ligeramente. Mezclar queso batido con tomate seco, albahaca, sal y pimienta. Rellenar tiras y enrollar. Aliñar con aceite y limón.', 'Queso batido 0% grasa en lugar de ricotta tradicional.', 15, 1, 'https://www.recetaslightysaludables.com/rollitos-de-calacacin-queso-batido'),
(54, 'Ensalada Tropical de Pepino, Piña y Hinojo', 'Lava y prepara todos los ingredientes según las indicaciones. En un bol grande, mezcla el pepino, la piña, el hinojo y la cebolla morada. En un recipiente pequeño, emulsiona el aceite de oliva con el zumo de limón, la sal y la pimienta. Vierte el aliño sobre la ensalada y mezcla suavemente para integrar los sabores. Decora con hojas de menta fresca y sirve inmediatamente.', 'El hinojo se utiliza como alternativa al regaliz, aportando un sabor similar sin los azúcares añadidos que suelen contener los productos de regaliz comerciales.', 15, 1, 'https://www.recetasgratis.net/receta-de-ensalada-tropical-de-pepino-pina-y-hinojo-70000.html'),
(55, 'Pisto Saludable de Acelgas y Calabacín', 'Lavar y cortar las acelgas (pencas aparte), calabacín, pimiento, tomate, cebolla y ajo. Sofreír cebolla y ajo con aceite. Añadir pencas y pimiento. Agregar calabacín, hojas de acelga y tomate. Cocinar 15 min tapado. Servir caliente.', 'No se utilizaron sustitutos; todos los ingredientes son aptos para colesterol alto.', 25, 2, 'https://www.recetasgratis.net/receta-de-pisto-de-acelgas-y-calabacin-100003.html'),
(56, 'Milhojas de Patata con Crema de Verduras y Salsa de Mango', 'Cortar patatas finas y cocer al vapor. Saltear verduras y triturar. Triturar mango con lima y menta. Montar milhojas alternando capas de patata y crema. Servir con salsa de mango.', 'No se utilizaron sustitutos; todos los ingredientes son aptos y naturales.', 30, 1, 'https://www.recetasgratis.net/receta-de-milhojas-de-patata-con-crema-de-verduras-y-salsa-de-mango-82341.html'),
(57, 'Calabaza Asada con Za\'atar y Yogur Griego al Limón', 'Asar calabaza en gajos con aceite, za\'atar, sal y pimienta a 200°C durante 30 minutos. Preparar crema de yogur con ajo, zumo de limón y perejil. Servir calabaza caliente con la crema.', 'Yogur griego sin azúcar en lugar de salsas comerciales. Za\'atar opcional o casero.', 30, 2, 'https://www.recetasgratis.net/receta-de-calabaza-asada-con-yogur-y-zaatar-82377.html'),
(58, 'Crema de Calabaza con Leche de Coco', 'Pelar y cortar verduras. Sofreír cebolla y ajo, añadir calabaza, zanahoria, patata y agua. Cocinar 20 min. Añadir leche de coco y triturar. Salpimentar y servir caliente.', 'Leche de coco sin azúcar en lugar de nata o lácteos tradicionales.', 30, 1, 'https://www.recetasgratis.net/receta-de-crema-de-calabaza-con-leche-de-coco-72301.html'),
(59, 'Wok de Verduras al Curry con Tofu', 'Lava y corta verduras. Dora el tofu con ajo y jengibre. Añade verduras y cocina al dente. Agrega curry, soja y limón. Sirve caliente.', 'No contiene ingredientes alergénicos comunes. Se usa tofu en vez de carne o pescado.', 20, 2, 'https://www.recetasgratis.net/receta-de-wok-de-verduras-al-curry-con-tofu-88888.html'),
(60, 'Ensalada tibia de bisaltos y champiñones al limón', 'Cocer los bisaltos al vapor 5 minutos. Saltear ajo en aceite, añadir champiñones, luego bisaltos. Aliñar con limón, sal y pimienta. Servir templado.', 'No se utilizaron sustitutos: todos los ingredientes son naturalmente aptos.', 15, 1, 'https://www.recetasgratis.net/receta-de-ensalada-tibia-de-bisaltos-y-champinones-89232.html'),
(61, 'Pudding de Puerros y Zanahorias sobre Crema de Hinojo con Perejil y Arándanos Deshidratados', 'Precalienta el horno a 180 °C. Cocina los puerros y zanahorias en sartén o al vapor. Bate el huevo con leche vegetal, mezcla con verduras y hornea. Cocina y tritura el hinojo para hacer la crema. Sirve el pudding sobre la crema y decora con perejil y arándanos.', 'Leche vegetal sin azúcar. Sin gluten, sin frutos secos ni pescado.', 40, 1, 'https://www.recetas-saludables.net/pudding-puerros-zanahoria-hinojo'),
(62, 'Ensalada templada de lentejas con verduras asadas', 'Asar verduras en dados (calabacín, berenjena, pimiento, cebolla). Mezclar con lentejas cocidas. Aliñar con aceite, vinagre, sal, pimienta y perejil picado. Servir templado o frío.', 'No se utilizaron frutos secos, ni gluten, ni ingredientes de alto contenido graso animal.', 25, 2, 'https://www.recetasvegetarianas.net/ensalada-templada-de-lentejas-y-verduras-asadas'),
(63, 'Ensalada Thai de Papaya Verde sin Frutos Secos', 'Rallar papaya y zanahoria. Blanquear judías verdes. Preparar aliño con ajo, chile, zumo de lima, salsa de soja, salsa de pescado vegetal y eritritol. Mezclar todo con tomates cherry y servir fresca.', 'Salsa de pescado vegetal en lugar de animal. Eritritol como edulcorante sin impacto glucémico.', 15, 2, 'https://www.recetasgratis.net/receta-de-ensalada-thai-de-papaya-verde-sin-frutos-secos-98521.html'),
(64, 'Ocras Salteadas con Tomate y Albahaca (Estilo Norteafricano)', 'Lavar y cortar ocras en rodajas. Sofreír ajo en aceite de oliva. Añadir ocras y saltear. Agregar tomates cherry y comino. Cocinar unos minutos más. Retirar del fuego y añadir sal, limón y albahaca troceada. Servir templado.', 'Ninguno. Todos los ingredientes son naturalmente libres de gluten, frutos secos y pescado.', 20, 1, 'https://www.recetasgratis.net/receta-de-ocras-salteadas-con-tomate-y-albahaca-73820.html'),
(65, 'Ensalada templada de higos y tofu a la parrilla con aliño de harissa y limón', 'Mezclar aceite, zumo de limón, harissa, cilantro, sal y pimienta. Asar el tofu y los higos en parrilla. Tostar nueces. Mezclar los brotes frescos y añadir el tofu, los higos y las nueces. Aliñar justo antes de servir.', 'Se sustituyó la mostaza por aliño de harissa, limón y cilantro. Se añadió mezcla de brotes.', 20, 1, 'https://www.recetasvegetarianas.net/ensalada-parrilla-higos-tofu-harissa'),
(66, 'Ensalada Niçoise Adaptada con Judías Verdes y Huevo', 'Cocer judías verdes y huevo por separado. Cortar patata cocida, tomate cherry, pimiento y mezclar con aceitunas. Añadir el huevo en cuartos. Aliñar con aceite, vinagre, sal y pimienta. Servir fría.', 'Huevo duro en lugar de pescado. Patata enfriada como hidrato de índice glucémico bajo.', 20, 1, 'https://www.recetasgratis.net/receta-de-ensalada-nicoise-sin-pescado-82490.html'),
(67, 'Curry suave de Espinacas, Tomate y Calabaza', 'Pelar y cortar calabaza. Cocinar al vapor. Sofreír cebolla, ajo y jengibre. Añadir tomate, luego calabaza, espinacas y curry. Agregar leche de coco, sal y pimienta. Cocinar hasta espesar. Servir caliente.', 'Leche de coco ligera en lugar de crema para hacerla apta para colesterol.', 25, 1, 'https://www.recetasgratis.net/receta-de-curry-de-espinacas-tomate-y-calabaza-vegetariano-aptos-72500.html'),
(68, 'Brochetas de Verduras Asadas con Ensalada Oriental de Pepino y Sésamo', 'Cortar las verduras. Insertar en brochetas. Pintar con mezcla de aceite, soja y pimienta. Asar 15-20 minutos. Preparar ensalada cortando pepino y mezclando con vinagre, salsa de soja, sésamo y aceite de sésamo. Servir todo junto.', 'Salsa de soja sin gluten. Aceite de sésamo opcional, no es un fruto seco.', 30, 2, 'https://www.recetasgratis.net/receta-de-brochetas-de-verduras-con-ensalada-oriental-79221.html'),
(69, 'Rollitos de Calabacín con Tempeh Marinado y Salsa de Yogur, Lima y Hierbabuena', 'Cortar el tempeh y marinarlo con tamari, vinagre, jengibre, ajo, aceite, sal y pimienta. Cortar verduras. Saltear tempeh. Rellenar tiras de calabacín con tempeh y vegetales y enrollar. Preparar la salsa mezclando yogur vegetal, zumo y ralladura de lima, hierbabuena picada, aceite y sal. Servir rollitos con salsa aparte.', 'Tempeh de garbanzos en lugar de soja. Salsa tamari sin gluten. Yogur vegetal sin azúcar en lugar de yogur animal.', 45, 2, 'https://www.recetasvegetarianas.net/rollitos-de-calabacin-con-tempeh-y-salsa-citricos'),
(70, 'Sopa de Miso con Setas Shiitake', 'Limpia las setas, córtalas. Corta tofu en cubos y la cebolleta. Hierve agua con setas y alga wakame. Añade miso disuelto, luego tofu y cebolleta. Sirve caliente.', 'Se usó miso blanco sin pescado y wakame libre de trazas marinas.', 20, 2, 'https://www.recetasgratis.net/receta-de-sopa-de-miso-con-setas-shiitake-88201.html'),
(71, 'Bowl de Garbanzos Asados con Arroz Integral y Verduras al Curry', 'Precalienta el horno y asa los garbanzos con curry, sal y aceite. Saltea cebolla, ajo, zanahoria y brócoli. Sirve con arroz integral y garbanzos encima.', 'No se usaron ingredientes alérgenos. Todo es naturalmente libre de pescado y marisco.', 35, 2, 'https://www.recetasgratis.net/receta-de-bowl-de-garbanzos-asados-con-arroz-integral-y-verduras-79045.html'),
(72, 'Pasta Integral con Pollo al Tomillo y Verduras Asadas', 'Cocer pasta. Cocinar el pollo con tomillo. Asar verduras. Mezclar todo y servir caliente con más tomillo si se desea.', 'No se usaron ingredientes alérgenos. Receta naturalmente libre de pescado y frutos secos.', 35, 2, 'https://www.recetasgratis.net/receta-de-pasta-integral-con-pollo-y-verduras-asadas-79072.html'),
(73, 'Berenjena Asada con Tofu Marinado al Estilo Oriental', 'Corta berenjena, deja reposar con sal. Marina tofu en tamari, jengibre y ajo. Asa la berenjena 30 min. Saltea las verduras, añade tofu y mezcla. Sirve sobre la berenjena. Añade sésamo al gusto.', 'Salsa tamari sin gluten como sustituto de soja. Tofu como proteína vegetal en vez de pescado.', 40, 2, 'https://www.recetasgratis.net/receta-de-berenjena-asada-con-tofu-marino-estilo-oriental-70021.html'),
(74, 'Papillote de Pavo con Verduras y Boniato Asado', 'Precalentar el horno. Hornear boniato en cubos con aceite. Cortar verduras en juliana. Colocar el pavo con verduras y condimentos en papel para papillote. Hornear 20 min. Servir con boniato asado.', 'No se usaron sustitutos. Todos los ingredientes son aptos para personas con alergias y enfermedades indicadas.', 40, 1, 'https://www.recetasgratis.net/receta-de-papillote-de-pavo-con-verduras-y-boniato-98311.html'),
(75, 'Tajine de Garbanzos con Verduras y Cuscús Integral', 'Sofríe la cebolla con especias. Añade zanahoria, calabacín, pasas y garbanzos. Cocina tapado 10 min. Hidrata el cuscús con agua caliente. Sirve con el tajine encima y decora con cilantro.', 'No contiene sustitutos específicos; todos los ingredientes son naturalmente aptos.', 30, 2, 'https://www.recetasgratis.net/receta-de-tajine-de-garbanzos-con-verduras-y-cuscus-80310.html'),
(76, 'Chuleta de cerdo sazonada al estilo sureño con salsa de mango y guarnición de arroz y verduras baby', 'Preparar salsa triturando mango, vinagre, miel, jengibre y agua. Sazonar la chuleta con chile, azúcar, sal y pimienta. Cocinar a la plancha: marcar fuerte, bajar, luego subir para caramelizar. Acompañar con arroz integral y verduras al vapor.', 'Sin frutos secos, sin gluten, sin pescado. Azúcar en cantidad mínima.', 40, 1, 'https://www.recetasgratis.net/receta-de-chuleta-de-cerdo-al-estilo-sureño-con-salsa-de-mango-80399.html'),
(77, 'Pollo al Curry con Arroz Basmati y Verduras', 'Cocina el arroz. Sofríe ajo y cebolla. Añade el pollo y verduras. Incorpora leche de coco y curry. Cocina 10 min. Sirve con arroz.', 'Ninguno necesario; todos los ingredientes son naturalmente sin gluten ni frutos secos.', 30, 2, 'https://www.recetasgratis.net/receta-de-pollo-al-curry-con-arroz-basmati-sin-gluten-100000.html'),
(78, 'Espaguetis “Picante Verde” con Solomillo y Rúcula', 'Cocer espaguetis. Saltear solomillo con ajo y chile, añadir tomates secos, aceitunas, tirabeques y cherry. Mezclar con la pasta, rúcula y parmesano. Servir caliente.', 'Espagueti integral usado por su bajo índice glucémico. No se usaron frutos secos ni azúcares.', 30, 2, 'https://www.recetasgratis.net/receta-de-espaguetis-picante-verde-solomillo-rucula-98765.html'),
(79, 'Susurro del Estrecho', 'Cocinar el bulgur con agua y sal durante 12-15 minutos. En sartén, sofreír ajo y guindilla en aceite. Añadir langostinos y saltear. Agregar Jerez y reducir. Servir sobre bulgur y decorar con perejil.', 'No se utilizaron frutos secos ni ingredientes con colesterol perjudicial.', 25, 2, 'https://www.recetasgratis.net/receta-de-langostinos-bulgar-jerez-susurro-del-estrecho-78621.html'),
(80, 'Salmón al Horno con Ensalada Verde', 'Hornear el salmón salpimentado a 180 °C por 12-15 min. Preparar salsa de yogur, pepino y limón. Mezclar canónigos, salvia roja y espinacas con vinagreta de granada. Servir todo junto.', 'Yogur desnatado en vez de salsas grasas. Vinagreta casera ligera en lugar de aderezos procesados.', 25, 1, 'https://www.recetasgratis.net/receta-de-salmon-al-horno-con-ensalada-verde-78921.html'),
(81, 'Chuletillas de Cordero con Menta y Quinoa con Albaricoques', 'Marinar chuletillas con ajo, menta, aceite, sal y pimienta. Asar por ambos lados. Cocer quinoa con caldo. Mezclar con cebolla y albaricoques picados. Servir las chuletillas sobre la quinoa con un toque de limón.', 'Quinoa en lugar de cuscús tradicional con gluten.', 30, 1, 'https://www.recetasgratis.net/receta-de-chuletillas-de-cordero-con-quinoa-y-albaricoques-79000.html'),
(82, 'Pollo al Horno con Puré de Coliflor y Espárragos Verdes', 'Precalienta el horno a 200 °C. Sazona el muslo de pollo con sal, pimienta y romero. Hornéalo 30-35 minutos. Cuece la coliflor, tritúrala con ajo y aceite. Saltea los espárragos. Sirve todo caliente.', 'No se utilizaron sustitutos; todos los ingredientes son naturalmente sin gluten.', 45, 1, 'https://www.recetasgratis.net/receta-de-pollo-al-horno-con-pure-de-coliflor-y-esparragos-89641.html'),
(83, 'Curry Saag de Pierna de Cordero Magra con Espinacas y Arroz Basmati', 'Cocinar arroz basmati. Sellar cordero magro. Sofreír cebolla, ajo y jengibre. Añadir especias y espinacas. Incorporar yogur vegetal y el cordero. Cocinar todo junto. Servir con arroz.', 'Yogur vegetal en lugar de yogur lácteo. Cordero magro sin grasa visible.', 45, 2, 'https://www.recetasgratis.net/receta-de-curry-saag-de-cordero-con-espinacas-69148.html'),
(84, 'Caballa al Estilo Thai con Ensalada de Pepino y Lenteja Verdina', 'Marinar la caballa con salsa de pescado, jugo de lima, jengibre, ajo y aceite de sésamo. Preparar la ensalada mezclando pepino, cebolla, lenteja verdina cocida y cilantro, aderezada con vinagre de arroz y aceite de oliva. Cocinar la caballa en sartén y servir con la ensalada.', 'Se ha utilizado caballa, un pescado azul rico en ácidos grasos omega-3. Lenteja verdina en lugar de lentejas comunes, ideal para ensaladas por su textura firme.', 30, 2, 'https://www.recetasaludables.org/caballa-thai-ensalada-pepino-lenteja-verdina'),
(85, 'Pipián Rojo con Jaca Deshilachada', 'Escurrir y desmenuzar la jaca verde. Hidratar los chiles secos en agua caliente. Tostar las semillas de calabaza. Licuar chiles, tomates, ajo, cebolla, semillas, comino, orégano, sal y agua hasta obtener una salsa. Sofreír la jaca en aceite de oliva, añadir la salsa y cocinar hasta que espese. Servir con arroz integral o tortillas de maíz y ensalada fresca.', 'La jaca verde se utiliza como sustituto vegetal de la carne, aportando una textura similar sin grasas saturadas. Las semillas de calabaza aportan grasas saludables y proteínas vegetales.', 45, 2, 'https://elpais.com/us/proyecto-cocina/2024-12-17/pipian-rojo.html'),
(86, 'Buddha Bowl Antiinflamatorio con Lentejas, Calabaza y Cúrcuma', 'Asar calabaza con cúrcuma. Cocinar quinoa y brócoli. Mezclar lentejas con limón. Disponer todo en un bol con repollo crudo. Aliñar con aceite, limón y decorar con menta.', 'Quinoa en lugar de cereales con gluten. Lentejas como proteína vegetal.', 35, 1, 'https://www.recetasfit.org/receta-buddha-bowl-lentejas-calabaza-antinflamatorio'),
(87, 'Saltimbocca de Pollo con Polenta Cremosa', 'Preparar la saltimbocca: Aplanar los filetes de pollo, sazonar, colocar salvia y jamón, enrollar y cocinar en aceite de oliva. Añadir vino blanco y reducir. Preparar la polenta: Hervir agua con sal, añadir polenta en forma de lluvia, cocinar hasta que esté cremosa y añadir aceite de oliva. Servir la polenta con los rollos de saltimbocca.', 'Jamón cocido bajo en sodio en lugar de prosciutto; aceite de oliva en lugar de mantequilla.', 30, 2, 'https://www.elnueve.com.ar/escuela-de-cocina/31060-aprende-cocinar-saltimbocca-la-romana-con-polenta-cremosa'),
(88, 'Albóndigas de Pavo con Salsa Thai y Ensalada Tibia con Vinagreta de Manzana', 'Formar albóndigas con pavo, huevo, soja, ajo, jengibre, cilantro y cebolla. Hornear. Preparar salsa Thai con coco y lima. Cocinar verduras al vapor y aliñar con AOVE, vinagre de manzana y sal. Servir todo junto.', 'Salsa de soja sin gluten, vinagre de manzana sin filtrar como ácido.', 40, 2, 'https://www.recetas-saludables.net/pavo-thai-con-ensalada-verde'),
(89, 'Pollo al Curry con Lentejas Rojas', 'Lavar lentejas. Cortar pollo en dados. Sofreír cebolla, ajo y jengibre. Añadir curry y pollo. Incorporar lentejas, agua y cocinar 20 min. Añadir limón antes de servir.', 'No se utilizaron sustitutos. Todos los ingredientes son naturalmente libres de gluten, frutos secos y pescado.', 30, 2, 'https://www.recetas-sanas.com/receta/pollo-curry-lentejas-rojas'),
(90, 'Pisto Manchego con Huevo al Horno', 'Lava y corta todas las verduras. Sofríe la cebolla, luego los pimientos, luego la berenjena y calabacín. Añade el tomate, cocina 20 min. Coloca en cazuela, añade un huevo encima y hornea hasta cuajar. Servir caliente.', 'No se utilizaron sustitutos. Todos los ingredientes son naturalmente libres de pescado, frutos secos y bajos en grasas saturadas.', 45, 2, 'https://www.recetasderechupete.com/receta-de-pisto-manchego-con-huevo/26623/'),
(91, 'Brochetas de Solomillo al Roquefort con Verduras y Patatas al Tomillo', 'Cortar el solomillo en dados. Marinar con leche, ajo, perejil, pan rallado, sal y pimienta durante 1 hora. Montar las brochetas con carne, tomates cherry y pimientos. Cocinar hasta dorar. Fundir roquefort para salsa. Cocer patatas, pelarlas y aliñar con aceite, tomillo, sal y pimienta. Servir todo caliente.', 'Pan rallado sin gluten en lugar de pan convencional.', 60, 2, 'https://www.recetasgratis.net/receta-de-brochetas-de-solomillo-al-roquefort-con-patatas-82132.html'),
(92, 'Soufflé de Coliflor con Salsa de Albahaca y Ensalada Fresca', 'Cocinar coliflor al vapor y triturar. Mezclar con yemas, queso batido, harina de maíz, sal, pimienta y nuez moscada. Añadir claras montadas. Hornear en moldes. Triturar ingredientes de salsa y calentar. Preparar ensalada y aliñar. Servir todo junto.', 'Harina de maíz en lugar de trigo. Bebida vegetal en lugar de nata.', 45, 2, 'https://www.recetasgratis.net/receta-de-souffle-de-coliflor-con-salsa-de-albahaca-y-ensalada-fresca-89873.html'),
(93, 'Sardinas en papillote con compota de tomate', 'Preparar compota de tomate con ajo, aceite, sal, pimienta y tomillo. Hornear las sardinas en papillote con la compota. Cortar patatas finas, remojar en agua fría, secar y freír. Servir con crackers de arroz o regañás sin gluten.', 'Crackers de arroz inflado o regañás sin gluten en lugar de regañás tradicionales.', 40, 2, 'https://www.recetasgratis.net/receta-de-sardinas-en-papillote-con-compota-de-tomate-89651.html'),
(94, 'Lasaña Vegetal con Proteína de Guisante (sin pasta)', 'Hidratar proteína de guisante. Asar calabacín, berenjena y pimiento. Sofreír cebolla y ajo, añadir proteína y tomate. Montar capas en fuente y hornear. Servir caliente.', 'Proteína vegetal de guisante en vez de carne; láminas de verduras en lugar de pasta.', 45, 2, 'https://www.recetasgratis.net/receta-de-lasana-vegetal-sin-pasta-con-proteina-de-guisante-80201.html'),
(95, 'Albóndigas de Lentejas con Brócoli al Vapor', 'Triturar lentejas y mezclar con zanahoria, huevo, avena sin gluten, ajo y perejil. Formar albóndigas y hornear. Cocinar tomate para salsa. Cocer brócoli al vapor, aliñar con limón y aceite. Servir todo junto.', 'Avena sin gluten en lugar de pan rallado tradicional.', 40, 2, 'https://www.recetas-saludables.net/albondigas-lentejas-brocoli'),
(96, 'Salteado de Espaguetis de Mar con Verduras y Tofu', 'Hidratar espaguetis de mar. Dorar tofu. Saltear verduras. Añadir algas, tofu, salsa de soja, ajo y jengibre. Cocinar todo junto. Servir caliente.', 'Salsa de soja sin gluten y tofu como alternativa proteica sin colesterol.', 30, 2, 'https://www.recetasaludable.net/espaguetis-mar-con-verduras-y-tofu'),
(97, 'Pechuga de Pollo al Koji con Verduras Asadas', 'Marinar el pollo con koji. Asar verduras con aceite, sal y pimienta. Añadir el pollo a mitad de cocción y hornear hasta dorar. Servir caliente.', 'No se utilizaron frutos secos ni ingredientes con gluten. El koji es sin gluten.', 60, 1, 'https://www.recetasgratis.net/receta-de-pollo-al-koji-con-verduras-asadas-82301.html'),
(98, 'Croquetas de Ortigas y Setas con Soja Texturizada, Espárragos a la Brasa y Salsa de Tomate Casera', 'Preparar croquetas con soja, ortigas y setas. Hornear o dorar en sartén. Asar espárragos trigueros. Preparar salsa cocinando tomate triturado con ajo, orégano, sal y pimienta. Servir todo junto.', 'Pan rallado sin gluten y harina de garbanzo. Salsa sin azúcar ni aceites industriales.', 50, 2, 'https://www.recetasveganas.net/croquetas-ortigas-setas-soja-con-esparragos-y-tomate'),
(99, 'Habas a la Siciliana con Guisantes y Alcachofas', 'Sofreír cebolla y ajo en aceite. Añadir tomate, orégano, sal y pimienta, cocinar 10 min. Agregar habas, guisantes y alcachofas. Cocinar 20 min más. Añadir vinagre, mezclar y servir caliente.', 'Todos los ingredientes son naturalmente sin gluten, frutos secos ni pescado.', 45, 2, 'https://www.recetasgratis.net/receta-de-habas-guisantes-y-alcachofas-a-la-siciliana-73402.html'),
(100, 'Paella de Mariscos con Almendras Tostadas', 'Tostar almendras. Sofreír ajo, pimiento y tomate. Añadir calamares y saltear. Agregar arroz y caldo con azafrán, cocer 10 min. Añadir gambas y mejillones, cocer 10 min más. Añadir almendras, reposar y servir.', 'Ninguno. Todos los ingredientes tradicionales con gluten, frutos secos y mariscos.', 45, 4, 'https://www.recetasgratis.net/receta-de-paella-de-mariscos-con-almendras-80001.html');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta_alergia`
--

CREATE TABLE `receta_alergia` (
  `id_receta` int(11) NOT NULL,
  `id_alergia` int(11) NOT NULL,
  `observaciones` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `receta_alergia`
--

INSERT INTO `receta_alergia` (`id_receta`, `id_alergia`, `observaciones`) VALUES
(8, 1, 'Contiene nueces en la salsa'),
(8, 2, 'Contiene pasta con gluten'),
(8, 3, 'Contiene salmón'),
(9, 1, 'Contiene almendras laminadas'),
(10, 2, 'Contiene harina de trigo con gluten'),
(14, 1, 'Contiene nueces'),
(14, 2, 'Contiene pan integral con gluten'),
(15, 3, 'Receta libre de pescado.'),
(16, 2, 'Utiliza avena certificada sin gluten, no contiene gluten'),
(16, 3, 'No contiene pescado'),
(18, 1, 'Contiene almendras en la bebida vegetal.'),
(19, 1, 'Contiene nueces si se agregan al topping'),
(24, 1, 'Contiene almendras laminadas.'),
(39, 1, 'Contiene sésamo en semillas, aceite y tahini'),
(57, 1, 'Za\'atar puede contener sésamo.'),
(65, 1, 'Contiene nueces peladas'),
(71, 3, 'Receta libre de pescado y marisco'),
(72, 1, 'No contiene frutos secos'),
(72, 3, 'Libre de pescado y marisco'),
(79, 3, 'Contiene marisco (langostinos)'),
(80, 3, 'Contiene pescado: salmón fresco'),
(84, 3, 'Contiene pescado (caballa).'),
(91, 2, 'Contiene productos lácteos (roquefort y leche)'),
(93, 3, 'Contiene pescado (sardinas)'),
(94, 3, 'Receta libre de pescado y mariscos'),
(100, 1, 'Contiene almendras crudas'),
(100, 2, 'Puede contener gluten según el caldo utilizado'),
(100, 3, 'Contiene mejillones, calamares y gambas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta_enfermedad`
--

CREATE TABLE `receta_enfermedad` (
  `id_receta` int(11) NOT NULL,
  `id_enfermedad` int(11) NOT NULL,
  `indicaciones` varchar(350) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `receta_enfermedad`
--

INSERT INTO `receta_enfermedad` (`id_receta`, `id_enfermedad`, `indicaciones`) VALUES
(7, 1, 'Apta para diabetes, ya que es baja en carbohidratos y rica en fibra.'),
(7, 2, 'Apta con moderación para colesterol, se recomienda reducir la cantidad de queso feta o sustituir por queso bajo en grasa.'),
(8, 1, 'Apta con moderación para diabetes, se recomienda usar pasta integral sin gluten.'),
(8, 2, 'No recomendable para colesterol alto debido a la crema de leche y el salmón. Se puede reducir el impacto usando crema vegetal y salmón al horno sin aceite.'),
(9, 1, 'Apta para personas con diabetes.'),
(9, 2, 'Apta para personas con colesterol alto.'),
(10, 1, 'No apta para personas con diabetes, contiene altos niveles de azúcar.'),
(10, 2, 'No apta para personas con colesterol alto, contiene mantequilla, nata y dulce de leche con grasas saturadas.'),
(11, 1, 'Apta para personas con diabetes, bajo índice glucémico.'),
(11, 2, 'Apta para colesterol alto, rica en fibra y sin grasas saturadas.'),
(12, 1, 'Apta, bajo índice glucémico y sin azúcares añadidos.'),
(12, 2, 'Apta.'),
(14, 1, 'Apta, bajo índice glucémico.'),
(14, 2, 'Apta con moderación por el contenido graso del aguacate y nueces.'),
(15, 1, 'Apta para diabetes controlando el consumo de pan y prefiriendo frutas de bajo índice glucémico.'),
(15, 2, 'Apta para colesterol si se limita el consumo de huevo a 1 unidad.'),
(16, 1, 'Apta para diabetes debido al bajo índice glucémico de la avena sin gluten.'),
(16, 2, 'Apta para colesterol si se usa aceite de oliva con moderación.'),
(17, 1, 'Apta para personas con diabetes usando poca miel o sin miel.'),
(17, 2, 'Apta para personas con colesterol.'),
(18, 1, 'Apta para diabetes si se omite o reduce la cantidad de miel.'),
(18, 2, 'Apta para colesterol gracias al uso de bebida vegetal y frutas frescas.'),
(19, 1, 'Apta para diabetes si se usa stevia o eritritol y se controla la cantidad de frutas.'),
(19, 2, 'Apta para colesterol alto.'),
(20, 1, 'Apta para diabetes si se omite o reduce la miel.'),
(20, 2, 'Apta para colesterol alto, moderar el consumo de leche de coco por su contenido graso.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta_ingrediente`
--

CREATE TABLE `receta_ingrediente` (
  `id_receta` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL,
  `cantidad` decimal(6,2) DEFAULT NULL,
  `fraccion` varchar(10) DEFAULT NULL,
  `id_unidad` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `receta_ingrediente`
--

INSERT INTO `receta_ingrediente` (`id_receta`, `id_ingrediente`, `cantidad`, `fraccion`, `id_unidad`) VALUES
(7, 6, NULL, NULL, NULL),
(7, 7, NULL, NULL, NULL),
(7, 26, NULL, NULL, NULL),
(7, 27, NULL, NULL, NULL),
(7, 28, NULL, NULL, NULL),
(7, 29, NULL, NULL, NULL),
(7, 30, NULL, NULL, NULL),
(7, 31, NULL, NULL, NULL),
(7, 32, NULL, NULL, NULL),
(8, 1, '100.00', NULL, 22),
(8, 2, '25.00', NULL, 22),
(8, 3, '1.00', NULL, 23),
(8, 4, '100.00', NULL, 25),
(8, 5, '4.00', NULL, 42),
(8, 6, '1.00', NULL, 37),
(8, 7, '1.00', NULL, 37),
(9, 6, '1.00', NULL, 37),
(9, 27, '50.00', NULL, 22),
(9, 28, '30.00', NULL, 22),
(9, 43, '100.00', NULL, 22),
(9, 44, '1.00', NULL, 39),
(9, 45, '30.00', NULL, 22),
(9, 46, '10.00', NULL, 25),
(9, 47, '5.00', NULL, 25),
(9, 48, '1.00', NULL, 37),
(10, 35, '150.00', NULL, 22),
(10, 36, '200.00', NULL, 22),
(10, 37, '3.00', NULL, 39),
(10, 38, '100.00', NULL, 22),
(10, 39, '50.00', NULL, 22),
(10, 40, '200.00', NULL, 22),
(10, 41, '100.00', NULL, 22),
(10, 42, '100.00', NULL, 25),
(11, 6, '1.00', NULL, 37),
(11, 7, '1.00', NULL, 37),
(11, 31, '2.00', NULL, 34),
(11, 43, '100.00', NULL, 22),
(11, 77, '1.00', NULL, NULL),
(11, 78, '1.00', NULL, NULL),
(11, 79, '1.00', NULL, NULL),
(11, 80, '1.00', NULL, NULL),
(11, 81, '0.50', NULL, NULL),
(11, 82, '1.00', NULL, NULL),
(12, 37, '2.00', NULL, NULL),
(12, 83, '1.00', NULL, NULL),
(12, 84, '50.00', NULL, 22),
(12, 85, '1.00', '1/2', 35),
(12, 86, '1.00', NULL, 35),
(14, 2, '6.00', NULL, NULL),
(14, 5, '1.00', '1/2', 42),
(14, 6, '1.00', NULL, 37),
(14, 7, '1.00', NULL, 37),
(14, 44, '1.00', NULL, NULL),
(14, 46, '1.00', NULL, 35),
(14, 47, '1.00', NULL, 35),
(14, 89, '2.00', NULL, NULL),
(15, 6, '1.00', NULL, 37),
(15, 44, '1.00', NULL, 39),
(15, 48, '1.00', NULL, 37),
(15, 89, '2.00', NULL, 39),
(15, 91, '1.00', NULL, 39),
(15, 92, '1.00', NULL, 34),
(15, 93, '1.00', NULL, 30),
(16, 6, '1.00', NULL, 37),
(16, 7, '1.00', NULL, 37),
(16, 31, '1.00', NULL, 35),
(16, 37, '3.00', NULL, 39),
(16, 77, '0.50', NULL, 39),
(16, 98, '50.00', NULL, 22),
(16, 99, '1.00', NULL, 39),
(16, 100, '0.50', NULL, 39),
(17, 83, '1.00', NULL, 39),
(17, 85, '1.00', NULL, 35),
(17, 106, '50.00', NULL, 22),
(17, 107, '200.00', NULL, 25),
(17, 108, '1.00', NULL, 35),
(18, 83, '1.00', NULL, 39),
(18, 108, '1.00', NULL, 35),
(18, 111, '1.00', NULL, 30),
(18, 112, '200.00', NULL, 25),
(18, 113, '1.00', NULL, 34),
(19, 2, '10.00', NULL, 22),
(19, 85, '1.00', NULL, 35),
(19, 113, '10.00', NULL, 22),
(19, 116, '150.00', NULL, 22),
(19, 117, '50.00', NULL, 22),
(19, 118, '10.00', NULL, 22),
(19, 119, '1.00', NULL, 35),
(20, 108, '1.00', NULL, 35),
(20, 113, '30.00', NULL, 22),
(20, 123, '200.00', NULL, 25),
(20, 124, '50.00', NULL, 22),
(20, 125, '50.00', NULL, 22),
(21, 6, '1.00', NULL, 37),
(21, 38, '1.00', NULL, 35),
(21, 111, '50.00', NULL, 22),
(21, 128, '150.00', NULL, 22),
(21, 129, '30.00', NULL, 22),
(21, 130, '1.00', NULL, 37),
(22, 6, '1.00', NULL, 37),
(22, 46, '1.00', NULL, 35),
(22, 83, '1.00', NULL, 39),
(22, 85, '0.50', NULL, 35),
(22, 91, '1.00', NULL, 39),
(22, 134, '60.00', NULL, 22),
(22, 135, '60.00', NULL, 25),
(22, 136, '0.50', NULL, 35),
(23, 6, '1.00', NULL, 37),
(23, 28, '50.00', NULL, 22),
(23, 46, '5.00', NULL, 25),
(23, 99, '50.00', NULL, 22),
(23, 100, '50.00', NULL, 22),
(23, 142, '200.00', NULL, 22),
(23, 143, '50.00', NULL, 22),
(23, 144, '150.00', NULL, 25),
(23, 145, '1.00', NULL, 37),
(23, 146, '50.00', NULL, 22),
(24, 32, '1.00', NULL, 35),
(24, 45, '10.00', NULL, 22),
(24, 124, '50.00', NULL, 22),
(24, 152, '50.00', NULL, 22),
(24, 153, '1.00', NULL, NULL),
(24, 154, '1.00', NULL, 35),
(25, 85, '1.00', NULL, 35),
(25, 158, '60.00', NULL, 22),
(25, 159, '200.00', NULL, 25),
(25, 160, '1.00', NULL, 39),
(25, 161, '1.00', NULL, 35),
(25, 162, '1.00', NULL, 37),
(25, 163, '1.00', NULL, 35),
(26, 77, '1.00', NULL, 39),
(26, 99, '1.00', NULL, 39),
(26, 144, '1.00', NULL, NULL),
(26, 158, '80.00', NULL, 22),
(26, 162, '1.00', NULL, 37),
(26, 164, '1.00', NULL, 30),
(26, 165, '1.00', NULL, 34),
(26, 166, '1.00', NULL, 34),
(26, 167, '1.00', NULL, 35),
(26, 168, '1.00', NULL, 34),
(27, 81, '1.00', NULL, 35),
(27, 82, '1.00', NULL, NULL),
(27, 135, '200.00', NULL, 25),
(27, 174, '1.00', NULL, 39),
(27, 175, '1.00', NULL, 34),
(27, 176, '3.00', NULL, NULL),
(29, 37, '3.00', NULL, 39),
(29, 44, '0.50', NULL, 39),
(29, 48, '1.00', NULL, 37),
(29, 86, '1.00', NULL, 34),
(29, 162, '1.00', NULL, 37),
(29, 188, '1.00', NULL, 30),
(29, 189, '1.00', NULL, 35),
(30, 32, '0.50', NULL, 39),
(30, 44, '0.50', NULL, 39),
(30, 113, '1.00', NULL, 34),
(30, 130, '1.00', NULL, 37),
(30, 135, '1.00', NULL, 30),
(30, 189, '0.50', NULL, 35),
(30, 195, '1.00', NULL, 30),
(30, 196, '1.00', NULL, 34),
(30, 197, '3.00', NULL, NULL),
(32, 48, '1.00', NULL, 37),
(32, 98, '40.00', NULL, 22),
(32, 108, '1.00', NULL, 35),
(32, 113, '1.00', NULL, 35),
(32, 117, '50.00', NULL, 22),
(32, 135, '200.00', NULL, 25),
(32, 145, '0.50', NULL, 35),
(32, 204, '0.50', NULL, 35),
(32, 205, '1.00', NULL, 35),
(33, 6, '1.00', NULL, 37),
(33, 46, '1.00', NULL, 34),
(33, 91, '1.00', NULL, 39),
(33, 123, '150.00', NULL, 25),
(33, 154, '1.00', NULL, 35),
(33, 224, '100.00', NULL, 22),
(33, 225, '1.00', NULL, 35),
(34, 6, '1.00', NULL, 29),
(34, 46, '1.00', NULL, 26),
(34, 231, '1.00', NULL, 39),
(34, 232, '3.00', NULL, 24),
(34, 233, '4.00', NULL, 39),
(34, 234, '1.00', NULL, 29),
(35, 31, '0.50', NULL, 40),
(35, 91, '1.00', NULL, 39),
(35, 119, '1.00', NULL, 40),
(35, 135, '100.00', NULL, 25),
(35, 237, '50.00', NULL, 22),
(35, 238, '60.00', NULL, 22),
(35, 239, '40.00', NULL, 22),
(36, 83, '0.50', NULL, 39),
(36, 85, '1.00', NULL, 41),
(36, 113, '1.00', NULL, 30),
(36, 117, '50.00', NULL, 22),
(36, 206, '1.00', NULL, 30),
(36, 244, '40.00', NULL, 22),
(36, 245, '200.00', NULL, 25),
(36, 246, '1.00', NULL, 30),
(37, 6, '1.00', NULL, 37),
(37, 37, '4.00', NULL, 39),
(37, 46, '1.00', NULL, 35),
(37, 134, '120.00', NULL, 22),
(37, 136, '1.00', NULL, 35),
(37, 252, '120.00', NULL, 22),
(37, 253, '1.00', NULL, 35),
(37, 254, '2.00', NULL, 39),
(38, 5, '1.00', NULL, 42),
(38, 6, '1.00', NULL, 37),
(38, 46, '1.00', NULL, 35),
(38, 48, '1.00', NULL, 37),
(38, 234, '1.00', NULL, 37),
(38, 260, '100.00', NULL, 22),
(38, 261, '2.00', NULL, 39),
(38, 262, '1.00', NULL, 39),
(39, 5, '1.00', NULL, 42),
(39, 6, '1.00', NULL, 37),
(39, 46, '10.00', NULL, 25),
(39, 47, '10.00', NULL, 25),
(39, 48, '1.00', NULL, 37),
(39, 79, '2.00', NULL, 39),
(39, 165, '15.00', NULL, 22),
(39, 268, '4.00', NULL, 39),
(39, 269, '10.00', NULL, 25),
(39, 270, '5.00', NULL, 22),
(39, 271, '1.00', NULL, 37),
(40, 6, '1.00', NULL, 37),
(40, 46, '1.00', NULL, 35),
(40, 85, '0.50', NULL, 35),
(40, 118, '1.00', NULL, 34),
(40, 279, '60.00', NULL, 22),
(40, 280, '1.00', NULL, 34),
(40, 281, '1.00', NULL, 34),
(40, 282, '1.00', NULL, 34),
(40, 283, '100.00', NULL, 22),
(40, 284, '80.00', NULL, 22),
(41, 46, '1.00', NULL, 35),
(41, 91, '1.00', NULL, 39),
(41, 113, '1.00', NULL, 35),
(41, 119, '0.50', NULL, 35),
(41, 135, '100.00', NULL, 25),
(41, 136, '0.50', NULL, 35),
(41, 204, '1.00', NULL, 37),
(41, 286, '60.00', NULL, 22),
(41, 287, '1.00', NULL, 39),
(41, 288, '1.00', NULL, 39),
(41, 289, '5.00', NULL, 22),
(42, 6, '1.00', NULL, 37),
(42, 37, '2.00', NULL, 39),
(42, 48, '1.00', NULL, 37),
(42, 81, '1.00', NULL, NULL),
(42, 111, '50.00', NULL, 22),
(42, 135, '1.00', NULL, 34),
(42, 143, '30.00', NULL, 22),
(42, 144, '300.00', NULL, 25),
(42, 297, '50.00', NULL, 22),
(42, 298, '1.00', NULL, NULL),
(42, 299, '5.00', NULL, 22),
(42, 300, '1.00', NULL, 35),
(43, 6, '1.00', NULL, 37),
(43, 46, '5.00', NULL, 25),
(43, 309, '200.00', NULL, 22),
(43, 310, '200.00', NULL, 25),
(43, 311, '10.00', NULL, NULL),
(43, 312, '1.00', NULL, 39),
(43, 313, '1.00', NULL, 37),
(44, 6, '1.00', NULL, 37),
(44, 28, '100.00', NULL, 22),
(44, 46, '30.00', NULL, 25),
(44, 176, '1.00', NULL, 39),
(44, 313, '1.00', NULL, 37),
(44, 316, '300.00', NULL, 22),
(44, 317, '10.00', NULL, NULL),
(44, 318, '5.00', NULL, 25),
(45, 6, '1.00', NULL, 37),
(45, 46, '5.00', NULL, 25),
(45, 77, '200.00', NULL, 22),
(45, 313, '1.00', NULL, 37),
(45, 324, '150.00', NULL, 22),
(45, 325, '50.00', NULL, 22),
(45, 326, '250.00', NULL, 25),
(46, 5, '1.00', NULL, 42),
(46, 6, '1.00', NULL, 37),
(46, 46, '1.00', NULL, 34),
(46, 48, '1.00', NULL, 37),
(46, 77, '1.00', NULL, 39),
(46, 99, '1.00', NULL, 39),
(46, 144, '750.00', NULL, 25),
(46, 146, '1.00', NULL, NULL),
(46, 325, '1.00', NULL, 39),
(46, 331, '100.00', NULL, 22),
(46, 332, '50.00', NULL, 22),
(47, 6, '1.00', NULL, 37),
(47, 46, '10.00', NULL, 25),
(47, 48, '1.00', NULL, 37),
(47, 287, '1.00', NULL, 39),
(47, 318, '5.00', NULL, 25),
(47, 342, '100.00', NULL, 22),
(47, 343, '50.00', NULL, 22),
(47, 344, '30.00', NULL, 22),
(48, 5, '1.00', NULL, 42),
(48, 6, '1.00', NULL, 37),
(48, 28, '50.00', NULL, 22),
(48, 46, '10.00', NULL, 25),
(48, 48, '1.00', NULL, 37),
(48, 78, '30.00', NULL, 22),
(48, 262, '1.00', NULL, 39),
(48, 283, '100.00', NULL, 25),
(48, 318, '5.00', NULL, 25),
(48, 342, '200.00', NULL, 22),
(49, 5, '2.00', NULL, 42),
(49, 6, '1.00', NULL, 37),
(49, 7, '1.00', NULL, 37),
(49, 32, '1.00', NULL, 34),
(49, 46, '1.00', NULL, 34),
(49, 77, '1.00', NULL, 39),
(49, 78, '0.50', NULL, 39),
(49, 80, '0.50', NULL, 39),
(49, 91, '1.00', NULL, 39),
(49, 99, '1.00', NULL, 39),
(49, 360, '6.00', NULL, 39),
(49, 361, '150.00', NULL, 25),
(49, 362, '0.50', NULL, NULL),
(50, 5, '1.00', NULL, 42),
(50, 6, '1.00', NULL, 37),
(50, 46, '15.00', NULL, 25),
(50, 47, '1.00', NULL, 39),
(50, 48, '1.00', NULL, 37),
(50, 78, '50.00', NULL, 22),
(50, 91, '1.00', NULL, 39),
(50, 99, '50.00', NULL, 22),
(50, 164, '50.00', NULL, 22),
(50, 167, '1.00', NULL, 35),
(50, 373, '200.00', NULL, 22),
(50, 374, '30.00', NULL, 22),
(50, 375, '1.00', NULL, 39),
(50, 376, '1.00', NULL, 35),
(51, 6, '1.00', NULL, 37),
(51, 46, '2.00', NULL, 34),
(51, 47, '0.50', NULL, 39),
(51, 48, '1.00', NULL, 37),
(51, 77, '1.00', NULL, 39),
(51, 78, '1.00', NULL, 39),
(51, 79, '1.00', NULL, 39),
(51, 108, '1.00', NULL, 34),
(51, 387, '1.00', NULL, 39),
(51, 388, '1.00', NULL, 39),
(51, 389, '1.00', NULL, 39),
(52, 6, '1.00', NULL, 37),
(52, 46, '10.00', NULL, 25),
(52, 48, '1.00', NULL, 37),
(52, 91, '1.00', NULL, 39),
(52, 318, '10.00', NULL, 25),
(52, 398, '8.00', NULL, 39),
(52, 399, '1.00', NULL, 35),
(53, 6, '1.00', NULL, 37),
(53, 46, '1.00', NULL, 35),
(53, 47, '1.00', NULL, 35),
(53, 48, '1.00', NULL, 37),
(53, 77, '1.00', NULL, 39),
(53, 405, '50.00', NULL, 22),
(53, 406, '2.00', NULL, 39),
(53, 407, '1.00', NULL, 35),
(54, 6, '1.00', NULL, 37),
(54, 28, '100.00', NULL, 22),
(54, 46, '10.00', NULL, 25),
(54, 47, '5.00', NULL, 25),
(54, 80, '10.00', NULL, 22),
(54, 130, '1.00', NULL, 37),
(54, 311, '1.00', NULL, 37),
(54, 413, '100.00', NULL, 22),
(54, 414, '30.00', NULL, 22),
(55, 5, '1.00', NULL, 42),
(55, 6, '1.00', NULL, 37),
(55, 46, '10.00', NULL, 25),
(55, 48, '1.00', NULL, 37),
(55, 77, '1.00', NULL, 39),
(55, 78, '1.00', NULL, 39),
(55, 100, '0.50', NULL, 39),
(55, 262, '1.00', NULL, 39),
(55, 422, '150.00', NULL, 22),
(56, 6, '1.00', NULL, 37),
(56, 46, '5.00', NULL, 25),
(56, 48, '1.00', NULL, 37),
(56, 77, '50.00', NULL, 22),
(56, 99, '50.00', NULL, 22),
(56, 311, '2.00', NULL, NULL),
(56, 312, '150.00', NULL, 22),
(56, 325, '40.00', NULL, 22),
(56, 431, '1.00', NULL, 37),
(56, 432, '50.00', NULL, 22),
(56, 433, '1.00', NULL, 35),
(57, 5, '0.50', NULL, 42),
(57, 6, '1.00', NULL, 37),
(57, 46, '1.00', NULL, 34),
(57, 47, '5.00', NULL, 25),
(57, 48, '1.00', NULL, 37),
(57, 116, '100.00', NULL, 22),
(57, 442, '200.00', NULL, 22),
(57, 443, '1.00', NULL, 35),
(57, 444, '1.00', NULL, NULL),
(58, 5, '1.00', NULL, 42),
(58, 6, '1.00', NULL, 37),
(58, 46, '10.00', NULL, 25),
(58, 48, '1.00', NULL, 37),
(58, 99, '1.00', NULL, 39),
(58, 100, '0.50', NULL, 39),
(58, 123, '200.00', NULL, 25),
(58, 145, '0.50', NULL, 35),
(58, 312, '100.00', NULL, 22),
(58, 442, '250.00', NULL, 22),
(59, 5, '1.00', NULL, 42),
(59, 46, '1.00', NULL, 34),
(59, 47, '1.00', NULL, 34),
(59, 48, '1.00', NULL, 37),
(59, 77, '80.00', NULL, 22),
(59, 78, '50.00', NULL, 22),
(59, 99, '40.00', NULL, 22),
(59, 164, '100.00', NULL, 22),
(59, 387, '50.00', NULL, 22),
(59, 461, '100.00', NULL, 22),
(59, 462, '1.00', NULL, 35),
(59, 463, '1.00', NULL, 35),
(59, 464, '2.00', NULL, 34),
(60, 5, '1.00', NULL, 42),
(60, 6, '1.00', NULL, 37),
(60, 46, '1.00', NULL, 35),
(60, 47, '5.00', NULL, 25),
(60, 48, '1.00', NULL, 37),
(60, 474, '100.00', NULL, 22),
(60, 475, '80.00', NULL, 22),
(61, 6, '1.00', NULL, 37),
(61, 46, '1.00', NULL, 35),
(61, 48, '1.00', NULL, 37),
(61, 91, '1.00', NULL, 39),
(61, 99, '100.00', NULL, 22),
(61, 325, '100.00', NULL, 22),
(61, 444, '5.00', NULL, 22),
(61, 481, '50.00', NULL, 25),
(61, 482, '100.00', NULL, 22),
(61, 483, '10.00', NULL, 22),
(62, 6, '1.00', NULL, 37),
(62, 46, '10.00', NULL, 25),
(62, 48, '1.00', NULL, 37),
(62, 77, '50.00', NULL, 22),
(62, 78, '30.00', NULL, 22),
(62, 79, '50.00', NULL, 22),
(62, 80, '20.00', NULL, 22),
(62, 318, '5.00', NULL, 25),
(62, 444, '1.00', NULL, 35),
(62, 491, '100.00', NULL, 22),
(63, 5, '1.00', NULL, 42),
(63, 27, '4.00', NULL, 39),
(63, 99, '50.00', NULL, 22),
(63, 154, '1.00', NULL, 35),
(63, 332, '50.00', NULL, 22),
(63, 464, '1.00', NULL, 34),
(63, 501, '200.00', NULL, 22),
(63, 502, '1.00', NULL, 39),
(63, 503, '1.00', NULL, 35),
(63, 504, '1.00', NULL, 37),
(64, 5, '1.00', NULL, 42),
(64, 6, '1.00', NULL, 37),
(64, 27, '50.00', NULL, 22),
(64, 46, '10.00', NULL, 25),
(64, 47, '5.00', NULL, 25),
(64, 271, '1.00', NULL, 37),
(64, 407, '3.00', NULL, NULL),
(64, 511, '100.00', NULL, 22),
(65, 46, '5.00', NULL, 25),
(65, 47, '1.00', NULL, 35),
(65, 130, '1.00', NULL, 37),
(65, 162, '1.00', NULL, 37),
(65, 461, '80.00', NULL, 22),
(65, 519, '3.00', NULL, 39),
(65, 520, '20.00', NULL, 22),
(65, 521, '20.00', NULL, 22),
(65, 522, '15.00', NULL, 22),
(65, 523, '10.00', NULL, 22),
(65, 524, '5.00', NULL, 22),
(65, 525, '0.50', NULL, 35),
(65, 526, '1.00', NULL, 35),
(66, 6, '1.00', NULL, 37),
(66, 27, '50.00', NULL, 22),
(66, 46, '1.00', NULL, 34),
(66, 48, '1.00', NULL, 37),
(66, 78, '30.00', NULL, 22),
(66, 91, '1.00', NULL, 39),
(66, 318, '1.00', NULL, 35),
(66, 332, '100.00', NULL, 22),
(66, 532, '50.00', NULL, 22),
(66, 533, '30.00', NULL, 22),
(67, 5, '1.00', NULL, 42),
(67, 6, '1.00', NULL, 37),
(67, 46, '5.00', NULL, 25),
(67, 100, '0.25', NULL, 39),
(67, 111, '100.00', NULL, 22),
(67, 130, '1.00', NULL, 37),
(67, 299, '5.00', NULL, 22),
(67, 442, '150.00', NULL, 22),
(67, 542, '100.00', NULL, 22),
(67, 543, '100.00', NULL, 25),
(67, 544, '0.50', NULL, 35),
(68, 6, '1.00', NULL, 37),
(68, 28, '1.00', NULL, 39),
(68, 46, '1.00', NULL, 34),
(68, 48, '1.00', NULL, 37),
(68, 77, '1.00', NULL, 39),
(68, 78, '1.00', NULL, 39),
(68, 79, '1.00', NULL, 39),
(68, 80, '1.00', NULL, 39),
(68, 168, '1.00', NULL, 35),
(68, 270, '1.00', NULL, 35),
(68, 475, '100.00', NULL, 22),
(68, 553, '1.00', NULL, 35),
(68, 554, '1.00', NULL, 34),
(69, 6, '1.00', NULL, 37),
(69, 7, '1.00', NULL, 37),
(69, 28, '0.50', NULL, 39),
(69, 46, '2.00', NULL, 34),
(69, 77, '1.00', NULL, 39),
(69, 78, '0.50', NULL, 39),
(69, 99, '1.00', NULL, 39),
(69, 166, '2.00', NULL, 34),
(69, 299, '1.00', NULL, 35),
(69, 317, '1.00', NULL, 34),
(69, 318, '1.00', NULL, 34),
(69, 433, '1.00', NULL, 39),
(69, 566, '200.00', NULL, 22),
(69, 567, '1.00', NULL, 35),
(69, 568, '100.00', NULL, 22),
(69, 569, '1.00', NULL, 35),
(70, 144, '500.00', NULL, 25),
(70, 168, '1.00', NULL, 35),
(70, 270, '1.00', NULL, 37),
(70, 461, '50.00', NULL, 22),
(70, 582, '2.00', NULL, 34),
(70, 583, '100.00', NULL, 22),
(70, 584, '30.00', NULL, 22),
(70, 585, '2.00', NULL, 22),
(71, 5, '1.00', NULL, 42),
(71, 6, '1.00', NULL, 37),
(71, 46, '10.00', NULL, 25),
(71, 48, '1.00', NULL, 37),
(71, 80, '30.00', NULL, 22),
(71, 99, '50.00', NULL, 22),
(71, 164, '50.00', NULL, 22),
(71, 260, '100.00', NULL, 22),
(71, 463, '1.00', NULL, 35),
(71, 587, '80.00', NULL, 22),
(72, 6, '1.00', NULL, 37),
(72, 46, '10.00', NULL, 25),
(72, 48, '1.00', NULL, 37),
(72, 77, '50.00', NULL, 22),
(72, 79, '50.00', NULL, 22),
(72, 388, '30.00', NULL, 22),
(72, 597, '100.00', NULL, 22),
(72, 598, '120.00', NULL, 22),
(72, 599, '1.00', NULL, 35),
(73, 5, '1.00', NULL, 42),
(73, 6, '1.00', NULL, 37),
(73, 46, '10.00', NULL, 25),
(73, 48, '1.00', NULL, 37),
(73, 78, '0.50', NULL, 39),
(73, 79, '1.00', NULL, 39),
(73, 99, '1.00', NULL, 39),
(73, 164, '100.00', NULL, 22),
(73, 166, '10.00', NULL, 25),
(73, 270, '1.00', NULL, 35),
(73, 461, '150.00', NULL, 22),
(73, 462, '1.00', NULL, 35),
(74, 6, '1.00', NULL, 37),
(74, 46, '10.00', NULL, 25),
(74, 47, '5.00', NULL, 25),
(74, 77, '60.00', NULL, 22),
(74, 80, '40.00', NULL, 22),
(74, 99, '50.00', NULL, 22),
(74, 130, '1.00', NULL, 37),
(74, 231, '100.00', NULL, 22),
(74, 618, '120.00', NULL, 22),
(74, 619, '1.00', NULL, 37),
(75, 6, '1.00', NULL, 37),
(75, 46, '1.00', NULL, 34),
(75, 77, '1.00', NULL, 39),
(75, 80, '0.50', NULL, 39),
(75, 99, '1.00', NULL, 39),
(75, 144, '200.00', NULL, 25),
(75, 145, '0.50', NULL, 35),
(75, 204, '1.00', NULL, 37),
(75, 260, '100.00', NULL, 22),
(75, 271, '0.50', NULL, 35),
(75, 362, '5.00', NULL, 22),
(75, 628, '80.00', NULL, 22),
(75, 629, '10.00', NULL, 22),
(76, 46, '0.50', NULL, 35),
(76, 48, '1.00', NULL, 37),
(76, 77, '20.00', NULL, 22),
(76, 108, '1.00', NULL, 35),
(76, 144, '1.00', NULL, 34),
(76, 162, '0.50', NULL, 35),
(76, 164, '30.00', NULL, 22),
(76, 318, '1.00', NULL, 35),
(76, 587, '60.00', NULL, 22),
(76, 641, '180.00', NULL, 22),
(76, 642, '0.50', NULL, 35),
(76, 643, '0.50', NULL, 35),
(76, 644, '0.50', NULL, 39),
(76, 645, '1.00', NULL, 37),
(76, 646, '50.00', NULL, 22),
(77, 5, '1.00', NULL, 42),
(77, 6, '1.00', NULL, 37),
(77, 46, '5.00', NULL, 25),
(77, 48, '1.00', NULL, 37),
(77, 77, '0.50', NULL, 39),
(77, 99, '1.00', NULL, 39),
(77, 100, '0.25', NULL, 39),
(77, 463, '1.00', NULL, 35),
(77, 598, '150.00', NULL, 22),
(77, 648, '100.00', NULL, 22),
(77, 649, '100.00', NULL, 25),
(78, 5, '1.00', NULL, 42),
(78, 6, '1.00', NULL, 37),
(78, 29, '20.00', NULL, 22),
(78, 46, '10.00', NULL, 25),
(78, 48, '1.00', NULL, 37),
(78, 233, '50.00', NULL, 22),
(78, 343, '20.00', NULL, 22),
(78, 406, '30.00', NULL, 22),
(78, 504, '0.50', NULL, 39),
(78, 659, '80.00', NULL, 22),
(78, 660, '100.00', NULL, 22),
(78, 661, '40.00', NULL, 22),
(78, 662, '10.00', NULL, 22),
(79, 5, '2.00', NULL, 42),
(79, 6, '1.00', NULL, 37),
(79, 46, '10.00', NULL, 25),
(79, 130, '1.00', NULL, 37),
(79, 444, '1.00', NULL, 34),
(79, 672, '200.00', NULL, 22),
(79, 673, '100.00', NULL, 22),
(79, 674, '1.00', NULL, 39),
(79, 675, '30.00', NULL, 25),
(80, 6, '1.00', NULL, 37),
(80, 28, '30.00', NULL, 22),
(80, 46, '10.00', NULL, 25),
(80, 47, '5.00', NULL, 25),
(80, 48, '1.00', NULL, 37),
(80, 523, '30.00', NULL, 22),
(80, 524, '20.00', NULL, 22),
(80, 681, '150.00', NULL, 22),
(80, 682, '50.00', NULL, 22),
(80, 683, '30.00', NULL, 22),
(80, 684, '10.00', NULL, 25),
(81, 5, '1.00', NULL, 42),
(81, 6, '1.00', NULL, 37),
(81, 43, '60.00', NULL, 22),
(81, 46, '1.00', NULL, 34),
(81, 47, '1.00', NULL, 35),
(81, 48, '1.00', NULL, 37),
(81, 80, '0.25', NULL, 39),
(81, 144, '100.00', NULL, 25),
(81, 311, '1.00', NULL, 34),
(81, 692, '3.00', NULL, 39),
(81, 693, '2.00', NULL, 39),
(82, 5, '1.00', NULL, 42),
(82, 6, '1.00', NULL, 37),
(82, 46, '5.00', NULL, 25),
(82, 48, '1.00', NULL, 37),
(82, 398, '100.00', NULL, 22),
(82, 703, '1.00', NULL, 39),
(82, 704, '150.00', NULL, 22),
(82, 705, '1.00', NULL, NULL),
(83, 5, '2.00', NULL, 42),
(83, 6, '1.00', NULL, 37),
(83, 46, '5.00', NULL, 25),
(83, 48, '1.00', NULL, 37),
(83, 100, '0.50', NULL, 39),
(83, 111, '150.00', NULL, 22),
(83, 145, '0.50', NULL, 35),
(83, 271, '0.50', NULL, 35),
(83, 299, '1.00', NULL, NULL),
(83, 648, '160.00', NULL, 22),
(83, 706, '200.00', NULL, 22),
(83, 707, '1.00', NULL, 35),
(83, 708, '150.00', NULL, 25),
(84, 5, '1.00', NULL, 42),
(84, 6, '1.00', NULL, 37),
(84, 28, '1.00', NULL, 39),
(84, 46, '1.00', NULL, 35),
(84, 48, '1.00', NULL, 37),
(84, 80, '0.50', NULL, 39),
(84, 168, '1.00', NULL, 35),
(84, 299, '1.00', NULL, 35),
(84, 554, '1.00', NULL, 34),
(84, 719, '2.00', NULL, 39),
(84, 720, '1.00', NULL, 34),
(84, 721, '1.00', NULL, 34),
(84, 722, '0.25', NULL, 30),
(84, 723, '1.00', NULL, 34),
(85, 5, '1.00', NULL, 42),
(85, 6, '0.50', NULL, 35),
(85, 46, '1.00', NULL, 34),
(85, 100, '0.25', NULL, 39),
(85, 118, '30.00', NULL, 22),
(85, 234, '1.00', NULL, 35),
(85, 262, '2.00', NULL, 39),
(85, 271, '1.00', NULL, 35),
(85, 733, '200.00', NULL, 22),
(85, 734, '2.00', NULL, 39),
(85, 735, '1.00', NULL, 39),
(85, 736, '250.00', NULL, 25),
(86, 43, '40.00', NULL, 22),
(86, 46, '1.00', NULL, 35),
(86, 47, '5.00', NULL, 25),
(86, 48, '1.00', NULL, 37),
(86, 162, '1.00', NULL, 37),
(86, 164, '50.00', NULL, 22),
(86, 189, '0.25', NULL, 35),
(86, 311, '2.00', NULL, NULL),
(86, 442, '80.00', NULL, 22),
(86, 491, '100.00', NULL, 22),
(86, 745, '50.00', NULL, 22),
(87, 6, '1.00', NULL, 37),
(87, 46, '2.00', NULL, 34),
(87, 48, '1.00', NULL, 37),
(87, 144, '500.00', NULL, 25),
(87, 598, '2.00', NULL, 39),
(87, 756, '2.00', NULL, 39),
(87, 757, '4.00', NULL, 39),
(87, 758, '0.25', NULL, 30),
(87, 759, '100.00', NULL, 22),
(88, 5, '1.00', NULL, 42),
(88, 6, '1.00', NULL, 37),
(88, 46, '1.00', NULL, 34),
(88, 48, '1.00', NULL, 37),
(88, 91, '1.00', NULL, 39),
(88, 299, '1.00', NULL, 35),
(88, 433, '1.00', NULL, 34),
(88, 553, '2.00', NULL, 34),
(88, 569, '1.00', NULL, 35),
(88, 723, '1.00', NULL, 34),
(88, 765, '300.00', NULL, 22),
(88, 766, '1.00', NULL, 34),
(88, 767, '100.00', NULL, 25),
(88, 768, '1.00', NULL, 37),
(88, 769, '200.00', NULL, 22),
(88, 770, '150.00', NULL, 22),
(88, 771, '150.00', NULL, 22),
(88, 772, '1.00', NULL, 34),
(89, 5, '1.00', NULL, 42),
(89, 6, '1.00', NULL, 37),
(89, 46, '10.00', NULL, 25),
(89, 47, '1.00', NULL, 34),
(89, 48, '1.00', NULL, 37),
(89, 78, '30.00', NULL, 22),
(89, 100, '50.00', NULL, 22),
(89, 144, '250.00', NULL, 25),
(89, 462, '5.00', NULL, 22),
(89, 463, '1.00', NULL, 35),
(89, 783, '150.00', NULL, 22),
(89, 784, '70.00', NULL, 22),
(90, 6, '1.00', NULL, 37),
(90, 46, '2.00', NULL, 34),
(90, 77, '1.00', NULL, 39),
(90, 78, '1.00', NULL, 39),
(90, 79, '1.00', NULL, 39),
(90, 91, '1.00', NULL, 39),
(90, 100, '1.00', NULL, 39),
(90, 130, '1.00', NULL, 37),
(90, 262, '2.00', NULL, 39),
(90, 387, '1.00', NULL, 39),
(91, 6, '1.00', NULL, 37),
(91, 46, '1.00', NULL, 34),
(91, 48, '1.00', NULL, 37),
(91, 142, '300.00', NULL, 22),
(91, 233, '8.00', NULL, 39),
(91, 599, '0.50', NULL, 35),
(91, 805, '400.00', NULL, 22),
(91, 806, '1.00', NULL, 42),
(91, 807, '100.00', NULL, 25),
(91, 808, '2.00', NULL, 34),
(91, 809, '1.00', NULL, 34),
(91, 810, '6.00', NULL, 39),
(91, 811, '80.00', NULL, 22),
(91, 812, '4.00', NULL, 39),
(92, 5, '1.00', NULL, 42),
(92, 6, '2.00', NULL, 37),
(92, 7, '1.00', NULL, 37),
(92, 28, '50.00', NULL, 22),
(92, 46, '2.00', NULL, 35),
(92, 91, '2.00', NULL, 39),
(92, 135, '30.00', NULL, 25),
(92, 318, '1.00', NULL, 35),
(92, 389, '40.00', NULL, 22),
(92, 407, '10.00', NULL, NULL),
(92, 431, '1.00', NULL, 37),
(92, 523, '30.00', NULL, 22),
(92, 704, '300.00', NULL, 22),
(92, 819, '30.00', NULL, 22),
(92, 820, '10.00', NULL, 22),
(93, 5, '1.00', NULL, 42),
(93, 6, '1.00', NULL, 37),
(93, 46, '30.00', NULL, 25),
(93, 48, '1.00', NULL, 37),
(93, 144, '1.00', NULL, 30),
(93, 312, '150.00', NULL, 22),
(93, 834, '4.00', NULL, 39),
(93, 835, '200.00', NULL, 22),
(93, 836, '2.00', NULL, NULL),
(93, 837, '3.00', NULL, 39),
(94, 5, '2.00', NULL, 42),
(94, 6, '1.00', NULL, 37),
(94, 46, '10.00', NULL, 25),
(94, 48, '1.00', NULL, 37),
(94, 77, '1.00', NULL, 39),
(94, 78, '1.00', NULL, 39),
(94, 79, '1.00', NULL, 39),
(94, 100, '1.00', NULL, 39),
(94, 234, '1.00', NULL, 35),
(94, 844, '150.00', NULL, 22),
(94, 845, '200.00', NULL, 22),
(95, 5, '1.00', NULL, 42),
(95, 6, '1.00', NULL, 37),
(95, 46, '1.00', NULL, 34),
(95, 48, '1.00', NULL, 37),
(95, 91, '1.00', NULL, 39),
(95, 98, '30.00', NULL, 22),
(95, 444, '5.00', NULL, 22),
(95, 491, '150.00', NULL, 22),
(95, 845, '200.00', NULL, 22),
(95, 855, '50.00', NULL, 22),
(95, 856, '150.00', NULL, 22),
(95, 857, '1.00', NULL, 35),
(96, 46, '5.00', NULL, 25),
(96, 77, '50.00', NULL, 22),
(96, 78, '50.00', NULL, 22),
(96, 80, '30.00', NULL, 22),
(96, 461, '100.00', NULL, 22),
(96, 553, '10.00', NULL, 25),
(96, 567, '1.00', NULL, 37),
(96, 645, '1.00', NULL, 37),
(96, 867, '30.00', NULL, 22),
(97, 6, '1.00', NULL, 37),
(97, 46, '10.00', NULL, 25),
(97, 48, '1.00', NULL, 37),
(97, 77, '1.00', NULL, 39),
(97, 80, '0.50', NULL, 39),
(97, 99, '1.00', NULL, 39),
(97, 598, '150.00', NULL, 22),
(97, 876, '1.00', NULL, 34),
(98, 5, '1.00', NULL, 42),
(98, 6, '1.00', NULL, 37),
(98, 46, '1.50', NULL, 35),
(98, 48, '1.00', NULL, 37),
(98, 100, '0.50', NULL, 39),
(98, 143, '2.00', NULL, 34),
(98, 234, '0.50', NULL, 35),
(98, 808, '4.00', NULL, 34),
(98, 845, '200.00', NULL, 22),
(98, 884, '60.00', NULL, 22),
(98, 885, '80.00', NULL, 22),
(98, 886, '150.00', NULL, 22),
(98, 887, '1.00', NULL, 35),
(98, 888, '100.00', NULL, 25),
(98, 889, '6.00', NULL, 39),
(99, 5, '2.00', NULL, 42),
(99, 6, '1.00', NULL, 37),
(99, 46, '2.00', NULL, 34),
(99, 48, '1.00', NULL, 37),
(99, 100, '1.00', NULL, 39),
(99, 234, '1.00', NULL, 35),
(99, 542, '200.00', NULL, 22),
(99, 899, '250.00', NULL, 22),
(99, 900, '100.00', NULL, 22),
(99, 901, '2.00', NULL, 39),
(99, 902, '1.00', NULL, 34),
(100, 5, '2.00', NULL, 42),
(100, 6, '1.00', NULL, 37),
(100, 46, '4.00', NULL, 34),
(100, 48, '1.00', NULL, 37),
(100, 78, '1.00', NULL, 39),
(100, 444, '1.00', NULL, NULL),
(100, 835, '1.00', NULL, 39),
(100, 910, '300.00', NULL, 22),
(100, 911, '100.00', NULL, 22),
(100, 912, '100.00', NULL, 22),
(100, 913, '100.00', NULL, 22),
(100, 914, '1000.00', NULL, 25),
(100, 915, '50.00', NULL, 22),
(100, 916, '1.00', NULL, 37);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `conversion_base` decimal(10,4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `nombre`, `conversion_base`) VALUES
(22, 'Gramo', '1.0000'),
(23, 'Kilogramo', '1000.0000'),
(24, 'Miligramo', '0.0010'),
(25, 'Mililitro', '1.0000'),
(26, 'Litro', '1000.0000'),
(27, 'Centímetro cúbico', '1.0000'),
(28, 'Decilitro', '100.0000'),
(29, 'Centilitro', '10.0000'),
(30, 'Taza', '240.0000'),
(31, 'Media taza', '120.0000'),
(32, 'Tres cuartos de taza', '180.0000'),
(33, 'Cuarto de taza', '60.0000'),
(34, 'Cucharada', '15.0000'),
(35, 'Cucharadita', '5.0000'),
(36, 'Media cucharada', '7.5000'),
(37, 'Pizca', '0.5000'),
(38, 'Gota', '0.0500'),
(39, 'Unidad', NULL),
(40, 'Docena', '720.0000'),
(41, 'Media docena', '360.0000'),
(42, 'diente', '10.0000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `sexo` enum('Masculino','Femenino','Otro','Prefiero no decirlo') DEFAULT NULL,
  `peso_kg` decimal(5,2) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `contrasena_hash` varchar(255) NOT NULL,
  `es_premium` tinyint(1) DEFAULT 0,
  `codigo_premium_usado` varchar(50) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultima_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_completo`, `email`, `direccion`, `ciudad`, `pais`, `sexo`, `peso_kg`, `edad`, `contrasena_hash`, `es_premium`, `codigo_premium_usado`, `fecha_registro`, `ultima_actualizacion`) VALUES
(1, 'Joaquín Salvador Sánchez', 'jsalvador@e-itaca.es ', 'Calle Falsa 123', 'Zaragoza', 'España', 'Masculino', '78.50', 52, 'hash123456', 1, '2987354', '2025-05-11 12:54:08', '2025-05-11 12:57:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_favoritos`
--

CREATE TABLE `usuario_favoritos` (
  `id_usuario` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alergias`
--
ALTER TABLE `alergias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `codigos_premium`
--
ALTER TABLE `codigos_premium`
  ADD PRIMARY KEY (`id_codigo`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `dietas`
--
ALTER TABLE `dietas`
  ADD PRIMARY KEY (`id_dieta`),
  ADD KEY `id_perfil` (`id_perfil`);

--
-- Indices de la tabla `dieta_receta`
--
ALTER TABLE `dieta_receta`
  ADD PRIMARY KEY (`id_dieta`,`id_receta`,`dia_semana`,`comida`),
  ADD KEY `id_receta` (`id_receta`);

--
-- Indices de la tabla `enfermedades`
--
ALTER TABLE `enfermedades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `lista_compra`
--
ALTER TABLE `lista_compra`
  ADD PRIMARY KEY (`id_lista`),
  ADD KEY `id_dieta` (`id_dieta`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id_perfil`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `receta_alergia`
--
ALTER TABLE `receta_alergia`
  ADD PRIMARY KEY (`id_receta`,`id_alergia`),
  ADD KEY `id_alergia` (`id_alergia`);

--
-- Indices de la tabla `receta_enfermedad`
--
ALTER TABLE `receta_enfermedad`
  ADD PRIMARY KEY (`id_receta`,`id_enfermedad`),
  ADD KEY `id_enfermedad` (`id_enfermedad`);

--
-- Indices de la tabla `receta_ingrediente`
--
ALTER TABLE `receta_ingrediente`
  ADD PRIMARY KEY (`id_receta`,`id_ingrediente`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `usuario_favoritos`
--
ALTER TABLE `usuario_favoritos`
  ADD PRIMARY KEY (`id_usuario`,`id_receta`),
  ADD KEY `id_receta` (`id_receta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alergias`
--
ALTER TABLE `alergias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `codigos_premium`
--
ALTER TABLE `codigos_premium`
  MODIFY `id_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `dietas`
--
ALTER TABLE `dietas`
  MODIFY `id_dieta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enfermedades`
--
ALTER TABLE `enfermedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=918;

--
-- AUTO_INCREMENT de la tabla `lista_compra`
--
ALTER TABLE `lista_compra`
  MODIFY `id_lista` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
