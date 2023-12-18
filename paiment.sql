-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 25 nov. 2023 à 02:14
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `paiment`
--

-- --------------------------------------------------------

--
-- Structure de la table `advanced_salary`
--

CREATE TABLE `advanced_salary` (
  `advanced_salary_id` int NOT NULL,
  `company_id` int NOT NULL,
  `staff_id` int NOT NULL,
  `avance_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avance_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avance_reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `salary_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'avance',
  `paiement_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `advance_amount` decimal(65,2) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `added_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `month_year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `advanced_salary`
--

INSERT INTO `advanced_salary` (`advanced_salary_id`, `company_id`, `staff_id`, `avance_value`, `avance_code`, `avance_reference`, `salary_type`, `paiement_type`, `advance_amount`, `description`, `added_by`, `created_at`, `month_year`) VALUES
(1, 11, 72, '1236', '789653256', '12365', 'avance', 'cash', 520.00, 'ok', 68, '2023-10-24 09:17:33', '2023-10'),
(4, 11, 85, 'qxk47Dx7OBQZHC8WF23E4H9qp6TekD', '#5E9X0JHH5V', '689789009', 'avance', 'carte bancaire', 800.00, 'test', 68, '2023-10-24 11:42:54', '2023-10');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`) VALUES
(5, 'FUDICIAIRE', '2023-08-31 11:19:20'),
(6, 'ONG LOCALE', '2023-08-31 11:19:20'),
(7, 'ONG INTERNATIONALE', '2023-08-31 11:19:20'),
(8, 'SOUS-TRAITANCE', '2023-08-31 11:19:20'),
(9, 'ASBL', '2023-10-12 14:51:51'),
(10, 'PRIVEE', '2023-10-12 14:51:51'),
(11, 'PUBLIC', '2023-10-12 14:52:13');

-- --------------------------------------------------------

--
-- Structure de la table `company`
--

CREATE TABLE `company` (
  `id` int NOT NULL,
  `unique_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `country_id` int NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `code_postale` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idnat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rccm` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bank_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bank_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int NOT NULL,
  `company_charge` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'none',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `company`
--

INSERT INTO `company` (`id`, `unique_id`, `user_id`, `name`, `username`, `country_id`, `address`, `city`, `province`, `code_postale`, `image`, `idnat`, `rccm`, `bank_name`, `bank_number`, `email`, `category_id`, `company_charge`, `password`, `status`, `phone`, `created_at`) VALUES
(11, 'LKD96536', NULL, 'linked-solution', 'linkedSolution', 1, 'Gombe, Kinshasa ', 'Kinshasa', 'Kinshasa', '10', 'uploads/16983059081488629900670751003mrfinker_Manga_style_clean_lines_black_boy_24_years_intimidatin_59ad18b7-e847-4f4c-8a94-5d47996b8333.png', '4455886', '99996663333', 'RAWBANK', '11114444444', 'info@linked-solution.com', 5, 'none', '$2y$10$kC5fg.cZ.8RKtS1ykj5X8.OAW2QhxvYyXEJm.XKL/2ZTUoLt4dmGi', NULL, '24382183153', '2023-09-19 10:57:10'),
(14, 'LKD90882', NULL, 'regideso', 'regideso', 1, 'Gwani 5, Kinshasa Gombe', '', '', '', '', '', '', '', '', 'regideso@gmail.com', 6, 'none', '$2y$10$80vs7wlUSPctItZkM8iUSeV9B5n9nclF1GlA.UqHl20tH1lwrXcFW', NULL, '2435869878', '2023-09-23 04:57:08'),
(15, 'LKD37145', NULL, 'snel', 'snel', 72, 'Gwani 5, Kinshasa Gombe', '', '', '', '', '', '', '', '', 'info@snel.com', 5, 'regideso', '$2y$10$b47FgR/ac1tHG2yW.O7YCuGhup.phIjILqTljXGI38DRxcl4cpoZO', NULL, '243824444444', '2023-09-25 10:49:01'),
(16, 'LKD12523', NULL, 'dgrk', 'dgrk', 243, 'Gwani 5, Kinshasa Gombe', 'kinshasa', 'kinshasa', '458MON', NULL, '152222698745', '447MNC788895', 'RAWBANK', '444555566666', 'info@dgrk.com', 5, '11', '$2y$10$JnlVnnQlM28kmf9pODwBWezR0gpFAREvhdwBwTK2nCSSTs.a/Hqd6', NULL, '243821831153', '2023-09-27 04:03:15'),
(17, 'LKD92527', NULL, 'Mapa', 'mapa', 243, 'Kintambo', 'Kinshasa', 'Kinshasa', '8444kkk', NULL, '888855556666', '888555KKKK', 'FBNBANK', '488888555555', 'mapa@gmail.com', 5, '14', '$2y$10$RSwq2pA3Iggzd3.0SDxcfOhWLpEfhKuhB2upV8OURJvKukZp6xtZm', NULL, '243888888', '2023-09-30 09:03:37');

-- --------------------------------------------------------

--
-- Structure de la table `constants_dep_exp`
--

CREATE TABLE `constants_dep_exp` (
  `constants_id` int NOT NULL,
  `company_id` int NOT NULL,
  `added_by` int NOT NULL,
  `type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `constants_dep_exp`
--

INSERT INTO `constants_dep_exp` (`constants_id`, `company_id`, `added_by`, `type`, `category_name`, `created_at`) VALUES
(1, 11, 68, 'depot', 'Pona', '2023-10-10 12:47:41'),
(2, 11, 68, 'depot', 'Autres revenus', '2023-10-10 13:00:49'),
(3, 11, 68, 'depense', 'Autres depenses', '2023-10-10 13:03:19'),
(4, 12, 71, 'depense', 'cnss', '2023-10-11 05:15:17'),
(5, 12, 71, 'depense', 'loyer', '2023-10-11 05:15:29'),
(6, 12, 71, 'depot', 'investissement', '2023-10-11 05:15:52'),
(7, 11, 68, 'depot', 'Investissement', '2023-10-12 11:27:57'),
(8, 11, 68, 'depense', 'Loyerr', '2023-10-12 11:28:09'),
(17, 11, 68, 'depense', 'Retrait', '2023-10-14 11:49:29'),
(18, 11, 68, 'depot', 'Depot CNSS', '2023-10-14 11:50:10');

-- --------------------------------------------------------

--
-- Structure de la table `country`
--

CREATE TABLE `country` (
  `id` int NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `country`
--

INSERT INTO `country` (`id`, `code`, `name`) VALUES
(1, '+93', 'Afghanistan'),
(2, '+355', 'Albania'),
(3, 'DZ', 'Algeria'),
(4, 'DS', 'American Samoa'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antarctica'),
(9, 'AG', 'Antigua and Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia and Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British Indian Ocean Territory'),
(32, 'BN', 'Brunei Darussalam'),
(33, 'BG', 'Bulgaria'),
(34, 'BF', 'Burkina Faso'),
(35, 'BI', 'Burundi'),
(36, 'KH', 'Cambodia'),
(37, 'CM', 'Cameroon'),
(38, 'CA', 'Canada'),
(39, 'CV', 'Cape Verde'),
(40, 'KY', 'Cayman Islands'),
(41, 'CF', 'Central African Republic'),
(42, 'TD', 'Chad'),
(43, 'CL', 'Chile'),
(44, 'CN', 'China'),
(45, 'CX', 'Christmas Island'),
(46, 'CC', 'Cocos (Keeling) Islands'),
(47, 'CO', 'Colombia'),
(48, 'KM', 'Comoros'),
(49, 'CG', 'Congo'),
(50, 'CK', 'Cook Islands'),
(51, 'CR', 'Costa Rica'),
(52, 'HR', 'Croatia (Hrvatska)'),
(53, 'CU', 'Cuba'),
(54, 'CY', 'Cyprus'),
(55, 'CZ', 'Czech Republic'),
(56, 'DK', 'Denmark'),
(57, 'DJ', 'Djibouti'),
(58, 'DM', 'Dominica'),
(59, 'DO', 'Dominican Republic'),
(60, 'TP', 'East Timor'),
(61, 'EC', 'Ecuador'),
(62, 'EG', 'Egypt'),
(63, 'SV', 'El Salvador'),
(64, 'GQ', 'Equatorial Guinea'),
(65, 'ER', 'Eritrea'),
(66, 'EE', 'Estonia'),
(67, 'ET', 'Ethiopia'),
(68, 'FK', 'Falkland Islands (Malvinas)'),
(69, 'FO', 'Faroe Islands'),
(70, 'FJ', 'Fiji'),
(71, 'FI', 'Finland'),
(72, 'FR', 'France'),
(73, 'FX', 'France, Metropolitan'),
(74, 'GF', 'French Guiana'),
(75, 'PF', 'French Polynesia'),
(76, 'TF', 'French Southern Territories'),
(77, 'GA', 'Gabon'),
(78, 'GM', 'Gambia'),
(79, 'GE', 'Georgia'),
(80, 'DE', 'Germany'),
(81, 'GH', 'Ghana'),
(82, 'GI', 'Gibraltar'),
(83, 'GK', 'Guernsey'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GN', 'Guinea'),
(91, 'GW', 'Guinea-Bissau'),
(92, 'GY', 'Guyana'),
(93, 'HT', 'Haiti'),
(94, 'HM', 'Heard and Mc Donald Islands'),
(95, 'HN', 'Honduras'),
(96, 'HK', 'Hong Kong'),
(97, 'HU', 'Hungary'),
(98, 'IS', 'Iceland'),
(99, 'IN', 'India'),
(100, 'IM', 'Isle of Man'),
(101, 'ID', 'Indonesia'),
(102, 'IR', 'Iran (Islamic Republic of)'),
(103, 'IQ', 'Iraq'),
(104, 'IE', 'Ireland'),
(105, 'IL', 'Israel'),
(106, 'IT', 'Italy'),
(107, 'CI', 'Ivory Coast'),
(108, 'JE', 'Jersey'),
(109, 'JM', 'Jamaica'),
(110, 'JP', 'Japan'),
(111, 'JO', 'Jordan'),
(112, 'KZ', 'Kazakhstan'),
(113, 'KE', 'Kenya'),
(114, 'KI', 'Kiribati'),
(115, 'KP', 'Korea, Democratic People\'s Republic of'),
(116, 'KR', 'Korea, Republic of'),
(117, 'XK', 'Kosovo'),
(118, 'KW', 'Kuwait'),
(119, 'KG', 'Kyrgyzstan'),
(120, 'LA', 'Lao People\'s Democratic Republic'),
(121, 'LV', 'Latvia'),
(122, 'LB', 'Lebanon'),
(123, 'LS', 'Lesotho'),
(124, 'LR', 'Liberia'),
(125, 'LY', 'Libyan Arab Jamahiriya'),
(126, 'LI', 'Liechtenstein'),
(127, 'LT', 'Lithuania'),
(128, 'LU', 'Luxembourg'),
(129, 'MO', 'Macau'),
(130, 'MK', 'Macedonia'),
(131, 'MG', 'Madagascar'),
(132, 'MW', 'Malawi'),
(133, 'MY', 'Malaysia'),
(134, 'MV', 'Maldives'),
(135, 'ML', 'Mali'),
(136, 'MT', 'Malta'),
(137, 'MH', 'Marshall Islands'),
(138, 'MQ', 'Martinique'),
(139, 'MR', 'Mauritania'),
(140, 'MU', 'Mauritius'),
(141, 'TY', 'Mayotte'),
(142, 'MX', 'Mexico'),
(143, 'FM', 'Micronesia, Federated States of'),
(144, 'MD', 'Moldova, Republic of'),
(145, 'MC', 'Monaco'),
(146, 'MN', 'Mongolia'),
(147, 'ME', 'Montenegro'),
(148, 'MS', 'Montserrat'),
(149, 'MA', 'Morocco'),
(150, 'MZ', 'Mozambique'),
(151, 'MM', 'Myanmar'),
(152, 'NA', 'Namibia'),
(153, 'NR', 'Nauru'),
(154, 'NP', 'Nepal'),
(155, 'NL', 'Netherlands'),
(156, 'AN', 'Netherlands Antilles'),
(157, 'NC', 'New Caledonia'),
(158, 'NZ', 'New Zealand'),
(159, 'NI', 'Nicaragua'),
(160, 'NE', 'Niger'),
(161, 'NG', 'Nigeria'),
(162, 'NU', 'Niue'),
(163, 'NF', 'Norfolk Island'),
(164, 'MP', 'Northern Mariana Islands'),
(165, 'NO', 'Norway'),
(166, 'OM', 'Oman'),
(167, 'PK', 'Pakistan'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestine'),
(170, 'PA', 'Panama'),
(171, 'PG', 'Papua New Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Peru'),
(174, 'PH', 'Philippines'),
(175, 'PN', 'Pitcairn'),
(176, 'PL', 'Poland'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'RE', 'Reunion'),
(181, 'RO', 'Romania'),
(182, 'RU', 'Russian Federation'),
(183, 'RW', 'Rwanda'),
(184, 'KN', 'Saint Kitts and Nevis'),
(185, 'LC', 'Saint Lucia'),
(186, 'VC', 'Saint Vincent and the Grenadines'),
(187, 'WS', 'Samoa'),
(188, 'SM', 'San Marino'),
(189, 'ST', 'Sao Tome and Principe'),
(190, 'SA', 'Saudi Arabia'),
(191, 'SN', 'Senegal'),
(192, 'RS', 'Serbia'),
(193, 'SC', 'Seychelles'),
(194, 'SL', 'Sierra Leone'),
(195, 'SG', 'Singapore'),
(196, 'SK', 'Slovakia'),
(197, 'SI', 'Slovenia'),
(198, 'SB', 'Solomon Islands'),
(199, 'SO', 'Somalia'),
(200, 'ZA', 'South Africa'),
(201, 'GS', 'South Georgia South Sandwich Islands'),
(202, 'ES', 'Spain'),
(203, 'LK', 'Sri Lanka'),
(204, 'SH', 'St. Helena'),
(205, 'PM', 'St. Pierre and Miquelon'),
(206, 'SD', 'Sudan'),
(207, 'SR', 'Suriname'),
(208, 'SJ', 'Svalbard and Jan Mayen Islands'),
(209, 'SZ', 'Swaziland'),
(210, 'SE', 'Sweden'),
(211, 'CH', 'Switzerland'),
(212, 'SY', 'Syrian Arab Republic'),
(213, 'TW', 'Taiwan'),
(214, 'TJ', 'Tajikistan'),
(215, 'TZ', 'Tanzania, United Republic of'),
(216, 'TH', 'Thailand'),
(217, 'TG', 'Togo'),
(218, 'TK', 'Tokelau'),
(219, 'TO', 'Tonga'),
(220, 'TT', 'Trinidad and Tobago'),
(221, 'TN', 'Tunisia'),
(222, 'TR', 'Turkey'),
(223, 'TM', 'Turkmenistan'),
(224, 'TC', 'Turks and Caicos Islands'),
(225, 'TV', 'Tuvalu'),
(226, 'UG', 'Uganda'),
(227, 'UA', 'Ukraine'),
(228, 'AE', 'United Arab Emirates'),
(229, 'GB', 'United Kingdom'),
(230, 'US', 'United States'),
(231, 'UM', 'United States minor outlying islands'),
(232, 'UY', 'Uruguay'),
(233, 'UZ', 'Uzbekistan'),
(234, 'VU', 'Vanuatu'),
(235, 'VA', 'Vatican City State'),
(236, 'VE', 'Venezuela'),
(237, 'VN', 'Vietnam'),
(238, 'VG', 'Virgin Islands (British)'),
(239, 'VI', 'Virgin Islands (U.S.)'),
(240, 'WF', 'Wallis and Futuna Islands'),
(241, 'EH', 'Western Sahara'),
(242, 'YE', 'Yemen'),
(243, 'DRC', 'Republique democratique du Congo'),
(244, 'ZM', 'Zambia'),
(245, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Structure de la table `currencies`
--

CREATE TABLE `currencies` (
  `currency_id` int NOT NULL,
  `country_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `currency_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `currency_code` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `currencies`
--

INSERT INTO `currencies` (`currency_id`, `country_name`, `currency_name`, `currency_code`) VALUES
(1, 'Afghanistan', 'Afghan afghani', 'AFN'),
(2, 'Albania', 'Albanian lek', 'ALL'),
(3, 'Algeria', 'Algerian dinar', 'DZD'),
(6, 'Angola', 'Angolan kwanza', 'AOA'),
(10, 'Argentina', 'Argentine peso', 'ARS'),
(11, 'Armenia', 'Armenian dram', 'AMD'),
(12, 'Aruba', 'Aruban florin', 'AWG'),
(13, 'Australia', 'Australian dollar', 'AUD'),
(15, 'Azerbaijan', 'Azerbaijani manat', 'AZN'),
(16, 'Bahamas', 'Bahamian dollar', 'BSD'),
(17, 'Bahrain', 'Bahraini dinar', 'BHD'),
(18, 'Bangladesh', 'Bangladeshi taka', 'BDT'),
(19, 'Barbados', 'Barbadian dollar', 'BBD'),
(20, 'Belarus', 'Belarusian ruble', 'BYR'),
(22, 'Belize', 'Belize dollar', 'BZD'),
(24, 'Bermuda', 'Bermudian dollar', 'BMD'),
(25, 'Bhutan', 'Bhutanese ngultrum', 'BTN'),
(26, 'Bolivia', 'Bolivian boliviano', 'BOB'),
(27, 'Bosnia and Herzegovina', 'Bosnia and Herzegovi', 'BAM'),
(30, 'Brazil', 'Brazilian real', 'BRL'),
(33, 'Bulgaria', 'Bulgarian lev', 'BGN'),
(35, 'Burundi', 'Burundian franc', 'BIF'),
(36, 'Cambodia', 'Cambodian riel', 'KHR'),
(38, 'Canada', 'Canadian dollar', 'CAD'),
(39, 'Cape Verde', 'Cape Verdean escudo', 'CVE'),
(40, 'Cayman Islands', 'Cayman Islands dolla', 'KYD'),
(43, 'Chile', 'Chilean peso', 'CLP'),
(44, 'China', 'Chinese yuan', 'CNY'),
(47, 'Colombia', 'Colombian peso', 'COP'),
(48, 'Comoros', 'Comorian franc', 'KMF'),
(49, 'Congo', 'Congolese franc', 'CDF'),
(52, 'Costa Rica', 'Costa Rican', 'CRC'),
(54, 'Croatia (Hrvatska)', 'Croatian kuna', 'HRK'),
(55, 'Cuba', 'Cuban convertible pe', 'CUC'),
(57, 'Czech Republic', 'Czech koruna', 'CZK'),
(58, 'Denmark', 'Danish krone', 'DKK'),
(59, 'Djibouti', 'Djiboutian franc', 'DJF'),
(60, 'Dominica', 'East Caribbean dolla', 'XCD'),
(61, 'Dominican Republic', 'Dominican peso', 'DOP'),
(64, 'Egypt', 'Egyptian pound', 'EGP'),
(67, 'Eritrea', 'Eritrean nakfa', 'ERN'),
(69, 'Ethiopia', 'Ethiopian birr', 'ETB'),
(71, 'Falkland Islands', 'Falkland Islands pou', 'FKP'),
(73, 'Fiji Islands', 'Fiji Dollars', 'FJD'),
(79, 'Gabon', 'Central African CFA ', 'XAF'),
(80, 'Gambia The', 'Gambian dalasi', 'GMD'),
(81, 'Georgia', 'Georgian lari', 'GEL'),
(83, 'Ghana', 'Ghana cedi', 'GHS'),
(84, 'Gibraltar', 'Gibraltar pound', 'GIP'),
(90, 'Guatemala', 'Guatemalan quetzal', 'GTQ'),
(92, 'Guinea', 'Guinean franc', 'GNF'),
(94, 'Guyana', 'Guyanese dollar', 'GYD'),
(95, 'Haiti', 'Haitian gourde', 'HTG'),
(97, 'Honduras', 'Honduran lempira', 'HNL'),
(98, 'Hong Kong S.A.R.', 'Hong Kong dollar', 'HKD'),
(99, 'Hungary', 'Hungarian forint', 'HUF'),
(100, 'Iceland', 'Icelandic króna\n', 'ISK'),
(101, 'India', 'Indian rupee', 'INR'),
(102, 'Indonesia', 'Indonesian rupiah', 'IDR'),
(103, 'Iran', 'Iranian rial', 'IRR'),
(104, 'Iraq', 'Iraqi dinar', 'IQD'),
(106, 'Israel', 'Israeli new shekel', 'ILS'),
(108, 'Jamaica', 'Jamaican dollar', 'JMD'),
(109, 'Japan', 'Japanese yen', 'JPY'),
(111, 'Jordan', 'Jordanian dinar', 'JOD'),
(112, 'Kazakhstan', 'Kazakhstani tenge', 'KZT'),
(113, 'Kenya', 'Kenyan shilling', 'KES'),
(115, 'Korea North', 'North Korean won', 'KPW'),
(116, 'Korea South', 'Korea (South) Won', 'KRW'),
(117, 'Kuwait', 'Kuwaiti dinar', 'KWD'),
(118, 'Kyrgyzstan', 'Kyrgyzstani som', 'KGS'),
(119, 'Laos', 'Lao kip', 'LAK'),
(121, 'Lebanon', 'Lebanese pound', 'LBP'),
(122, 'Lesotho', 'Lesotho loti', 'LSL'),
(123, 'Liberia', 'Liberian dollar', 'LRD'),
(124, 'Libya', 'Libyan dinar', 'LYD'),
(128, 'Macau S.A.R.', 'Macanese pataca', 'MOP'),
(129, 'Macedonia', 'Macedonian denar', 'MKD'),
(130, 'Madagascar', 'Malagasy ariary', 'MGA'),
(131, 'Malawi', 'Malawian kwacha', 'MWK'),
(132, 'Malaysia', 'Malaysian ringgit', 'MYR'),
(133, 'Maldives', 'Maldivian rufiyaa', 'MVR'),
(134, 'Mali', 'West African CFA fra', 'XOF'),
(136, 'Man (Isle of)', 'Manx pound', 'IMP'),
(139, 'Mauritania', 'Mauritanian ouguiya', 'MRO'),
(140, 'Mauritius', 'Mauritian rupee', 'MUR'),
(142, 'Mexico', 'Mexican peso', 'MXN'),
(144, 'Moldova', 'Moldovan leu', 'MDL'),
(146, 'Mongolia', 'Mongolian tögrög', 'MNT'),
(148, 'Morocco', 'Moroccan dirham', 'MAD'),
(149, 'Mozambique', 'Mozambican metical', 'MZN'),
(150, 'Myanmar', 'Burmese kyat', 'MMK'),
(151, 'Namibia', 'Namibian dollar', 'NAD'),
(153, 'Nepal', 'Nepalese rupee', 'NPR'),
(154, 'Netherlands Antilles', 'Dutch Guilder', 'ANG'),
(157, 'New Zealand', 'New Zealand dollar', 'NZD'),
(158, 'Nicaragua', 'Nicaraguan córdoba', 'NIO'),
(160, 'Nigeria', 'Nigerian naira', 'NGN'),
(164, 'Norway', 'Norwegian krone', 'NOK'),
(165, 'Oman', 'Omani rial', 'OMR'),
(166, 'Pakistan', 'Pakistani rupee', 'PKR'),
(169, 'Panama', 'Panamanian balboa', 'PAB'),
(170, 'Papua new Guinea', 'Papua New Guinean ki', 'PGK'),
(171, 'Paraguay', 'Paraguayan guaraní\n', 'PYG'),
(172, 'Peru', 'Peruvian nuevo sol', 'PEN'),
(173, 'Philippines', 'Philippine peso', 'PHP'),
(175, 'Poland', 'Polish złoty\n', 'PLN'),
(178, 'Qatar', 'Qatari riyal', 'QAR'),
(180, 'Romania', 'Romanian leu', 'RON'),
(181, 'Russia', 'Russian ruble', 'RUB'),
(182, 'Rwanda', 'Rwandan franc', 'RWF'),
(183, 'Saint Helena', 'Saint Helena pound', 'SHP'),
(188, 'Samoa', 'Samoan tālā\n', 'WST'),
(191, 'Saudi Arabia', 'Saudi riyal', 'SAR'),
(193, 'Serbia', 'Serbian dinar', 'RSD'),
(194, 'Seychelles', 'Seychellois rupee', 'SCR'),
(195, 'Sierra Leone', 'Sierra Leonean leone', 'SLL'),
(196, 'Singapore', 'Singapore dollar\n', 'SGD'),
(200, 'Solomon Islands', 'Solomon Islands doll', 'SBD'),
(201, 'Somalia', 'Somali shilling', 'SOS'),
(202, 'South Africa', 'South African rand', 'ZAR'),
(204, 'South Sudan', 'South Sudanese pound', 'SSP'),
(205, 'Spain', 'Euro', 'EUR'),
(206, 'Sri Lanka', 'Sri Lankan rupee', 'LKR'),
(207, 'Sudan', 'Sudanese pound', 'SDG'),
(208, 'Suriname', 'Surinamese dollar', 'SRD'),
(210, 'Swaziland', 'Swazi lilangeni', 'SZL'),
(211, 'Sweden', 'Swedish krona', 'SEK'),
(212, 'Switzerland', 'Swiss franc', 'CHF'),
(213, 'Syria', 'Syrian pound', 'SYP'),
(214, 'Taiwan', 'New Taiwan dollar', 'TWD'),
(215, 'Tajikistan', 'Tajikistani somoni', 'TJS'),
(216, 'Tanzania', 'Tanzanian shilling', 'TZS'),
(217, 'Thailand', 'Thai baht', 'THB'),
(220, 'Tonga', 'Tongan paʻanga\n', 'TOP'),
(221, 'Trinidad And Tobago', 'Trinidad and Tobago ', 'TTD'),
(222, 'Tunisia', 'Tunisian dinar', 'TND'),
(223, 'Turkey', 'Turkish lira', 'TRY'),
(224, 'Turkmenistan', 'Turkmenistan manat', 'TMT'),
(227, 'Uganda', 'Ugandan shilling', 'UGX'),
(228, 'Ukraine', 'Ukrainian hryvnia', 'UAH'),
(229, 'United Arab Emirates', 'United Arab Emirates', 'AED'),
(230, 'United Kingdom', 'British pound', 'GBP'),
(231, 'United States', 'United States Dollar', 'USD'),
(233, 'Uruguay', 'Uruguayan peso', 'UYU'),
(234, 'Uzbekistan', 'Uzbekistani som', 'UZS'),
(235, 'Vanuatu', 'Vanuatu vatu', 'VUV'),
(237, 'Venezuela', 'Venezuelan bolívar\n', 'VEF'),
(238, 'Vietnam', 'Vietnamese dong\n', 'VND'),
(241, 'Wallis And Futuna Islands', 'CFP franc', 'XPF'),
(243, 'Yemen', 'Yemeni rial', 'YER'),
(244, 'Yugoslavia', 'Yugoslav dinar', 'YUM'),
(245, 'Zambia', 'Zambian kwacha', 'ZMW'),
(246, 'Zimbabwe', 'Botswana pula', 'BWP');

-- --------------------------------------------------------

--
-- Structure de la table `departments`
--

CREATE TABLE `departments` (
  `department_id` int NOT NULL,
  `department_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `company_id` int NOT NULL,
  `department_head` int DEFAULT '0',
  `added_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`, `company_id`, `department_head`, `added_by`, `created_at`) VALUES
(1, 'blanc', 11, 0, 68, '2023-09-25 13:45:04'),
(9, 'blo', 12, 0, 71, '2023-09-25 15:27:40'),
(10, 'blanc', 12, 0, 71, '2023-09-25 15:27:48'),
(13, 'Dev', 11, 0, 68, '2023-09-26 01:44:31'),
(14, 'Marketing', 17, 0, 86, '2023-09-30 09:09:36'),
(16, 'Finance', 11, 0, 68, '2023-10-18 17:17:20');

-- --------------------------------------------------------

--
-- Structure de la table `designations`
--

CREATE TABLE `designations` (
  `designation_id` int NOT NULL,
  `department_id` int NOT NULL,
  `company_id` int NOT NULL,
  `added_by` int NOT NULL,
  `designation_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `designations`
--

INSERT INTO `designations` (`designation_id`, `department_id`, `company_id`, `added_by`, `designation_name`, `created_at`) VALUES
(1, 13, 11, 68, 'Developpement webbb', '2023-09-26 01:33:35'),
(5, 9, 12, 71, 'ppol', '2023-09-26 01:35:53'),
(6, 13, 11, 68, 'informatique', '2023-09-26 01:44:43'),
(7, 14, 17, 86, 'Digital', '2023-09-30 09:10:02'),
(8, 14, 17, 86, 'Fictif', '2023-09-30 09:10:14'),
(9, 1, 11, 68, 'Web', '2023-10-11 13:36:56');

-- --------------------------------------------------------

--
-- Structure de la table `finance_accounts`
--

CREATE TABLE `finance_accounts` (
  `account_id` int NOT NULL,
  `account_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `account_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company_id` int NOT NULL,
  `added_by` int NOT NULL,
  `account_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `account_balance` decimal(65,2) NOT NULL,
  `account_opening_balance` decimal(65,2) NOT NULL,
  `account_number` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bank_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `finance_accounts`
--

INSERT INTO `finance_accounts` (`account_id`, `account_code`, `account_value`, `company_id`, `added_by`, `account_name`, `account_balance`, `account_opening_balance`, `account_number`, `bank_name`, `created_at`) VALUES
(1, 'XCPOpppp', '11115555', 11, 68, 'Linked-solution', 200000.00, 200000.00, '445566', 'RAWBANK', '2023-10-10 09:22:57'),
(3, 'XCPOpppp5966666', '22224444', 12, 71, 'regidesoo', 50000000.00, 5000000.00, '5588963', 'FBNBANK', '2023-10-10 09:47:42'),
(4, 'XCPOpppp2212121215455', '3333666', 11, 68, 'Linked-sol2', 500000.00, 500000.00, '666999', 'MPESA', '2023-10-10 15:15:46'),
(6, 'XCPOpppp8855', '1010102523', 11, 68, 'Linked-money', 800000.00, 800000.00, '888999666', 'EQUITYBCDC', '2023-10-14 11:51:19'),
(8, '#79MRR48VDA', 'hEJOA0kwezzeyAvDVA1P', 11, 68, 'Pema', 80000.00, 80000.00, '8889996663333', 'POOOOF', '2023-10-23 08:43:32');

-- --------------------------------------------------------

--
-- Structure de la table `finance_transactions`
--

CREATE TABLE `finance_transactions` (
  `transactions_id` int NOT NULL,
  `transactions_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `transactions_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `account_id` int NOT NULL,
  `company_id` int NOT NULL,
  `staff_id` int NOT NULL,
  `added_by` int NOT NULL,
  `entity_category_id` int NOT NULL,
  `transaction_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `transaction_type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `reference` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `amount` decimal(65,2) NOT NULL,
  `payement_method` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `finance_transactions`
--

INSERT INTO `finance_transactions` (`transactions_id`, `transactions_value`, `transactions_code`, `account_id`, `company_id`, `staff_id`, `added_by`, `entity_category_id`, `transaction_date`, `transaction_type`, `reference`, `description`, `amount`, `payement_method`, `created_at`) VALUES
(41, '123', NULL, 1, 11, 72, 68, 3, '2023-01-20', 'depense', '835708282', 'ok', 5000.00, 'cash', '2023-10-11 08:55:51'),
(47, '1255', NULL, 3, 12, 84, 71, 5, '2023-10-12', 'depense', '210244190', 'ok', 6000.00, 'carte_bancaire', '2023-10-12 10:51:16'),
(48, '8963', NULL, 3, 12, 83, 71, 4, '2023-10-12', 'depense', '445023359', 'ok', 1000.00, 'carte_bancaire', '2023-10-12 10:52:06'),
(49, '7845', NULL, 3, 12, 83, 71, 5, '2023-10-12', 'depense', '793643120', 'ok', 100.00, 'carte_bancaire', '2023-10-12 10:52:43'),
(50, '987456', NULL, 3, 12, 83, 71, 6, '2023-10-12', 'depot', '467507095', 'ok', 1500.00, 'cash', '2023-10-12 10:53:17'),
(52, '123654789', NULL, 4, 11, 82, 68, 3, '2023-10-12', 'depense', '889639326', 'ok', 8000.00, 'carte_bancaire', '2023-10-12 10:55:05'),
(53, '987564265', NULL, 3, 12, 84, 71, 6, '2023-08-15', 'depot', '742301926', 'ok', 6000.00, 'carte_bancaire', '2023-10-12 10:57:58'),
(54, 'nfnlndlvnmdnvmdnmvdvdvd58dv7dv4d5', NULL, 3, 12, 83, 71, 6, '2023-09-20', 'depot', '678020039', 'ok', 1200.00, 'carte_bancaire', '2023-10-12 11:01:10'),
(55, 'jdldlvndlmvnmdl,vùd,vùdvdv4dv74dv4dv4d6v4d4vdvd', NULL, 4, 11, 72, 68, 7, '2023-01-10', 'depot', '512712796', 'ok', 10000.00, 'cash', '2023-10-12 12:02:09'),
(56, 'ndkndkvbldvdvdv4v4ev64v6v', NULL, 1, 11, 85, 68, 2, '2023-10-17', 'depot', '947310542', 'ok', 4000.00, 'cheque', '2023-10-12 12:02:33'),
(57, 'jldldvnkdnvevev4ev48e75', NULL, 1, 11, 88, 68, 2, '2023-04-13', 'depot', '200511853', 'ok', 460.00, 'carte bancaire', '2023-10-12 12:03:05'),
(58, 'kshfigzjfzf98456e', NULL, 4, 11, 82, 68, 2, '2023-10-09', 'depot', '798810726', 'ok', 7000.00, 'carte bancaire', '2023-10-12 12:05:27'),
(60, 'kdhfiehfke7546', NULL, 6, 11, 88, 68, 8, '2023-10-12', 'depense', '559112062', 'ok', 1000.00, 'carte bancaire', '2023-10-14 11:53:27'),
(64, 'F9QpaJ27NyDYiIj', '#3OZIRN', 6, 11, 85, 68, 2, '2023-10-22', 'depot', '945496890', 'ok', 800.00, 'carte bancaire', '2023-10-23 12:43:58'),
(65, 'tJR5IEPbPRLmoDi', '#6U4PMK', 4, 11, 82, 68, 8, '2023-10-23', 'depense', '284572389', 'okkk', 800.00, 'carte bancaire', '2023-10-23 12:46:24');

-- --------------------------------------------------------

--
-- Structure de la table `membership_company`
--

CREATE TABLE `membership_company` (
  `membership_company_id` int NOT NULL,
  `company_id` int NOT NULL,
  `membership_plan_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `membership_company`
--

INSERT INTO `membership_company` (`membership_company_id`, `company_id`, `membership_plan_id`, `created_at`) VALUES
(1, 11, 1, '2023-10-26 10:51:19');

-- --------------------------------------------------------

--
-- Structure de la table `membership_invoices`
--

CREATE TABLE `membership_invoices` (
  `membership_invoices_id` int NOT NULL,
  `invoices_reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `company_id` int NOT NULL,
  `membership_plan_id` int NOT NULL,
  `invoice_month` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `membership_plan_price` int NOT NULL,
  `payement_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `transaction_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membership_plan`
--

CREATE TABLE `membership_plan` (
  `membership_plan_id` int NOT NULL,
  `membership_type_plan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `plan_duration` int NOT NULL,
  `total_employee` int NOT NULL,
  `membership_plan_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `membership_plan`
--

INSERT INTO `membership_plan` (`membership_plan_id`, `membership_type_plan`, `price`, `plan_duration`, `total_employee`, `membership_plan_name`, `created_at`) VALUES
(2, 'Mois', 500.00, 30, 20, 'Basique', '2023-10-26 10:47:43'),
(3, 'Annuel', 5050.00, 300, 2000, 'Basiques', '2023-10-26 10:49:16'),
(4, 'Mois', 600.00, 90, 90, 'test', '2023-10-26 13:07:36');

-- --------------------------------------------------------

--
-- Structure de la table `office_shifts`
--

CREATE TABLE `office_shifts` (
  `office_shift_id` int NOT NULL,
  `company_id` int NOT NULL,
  `added_by` int NOT NULL,
  `shift_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total_time` int NOT NULL,
  `monday_in_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `monday_out_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tuesday_in_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tuesday_out_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `wednesday_in_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `wednesday_out_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `thursday_in_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `thursday_out_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `friday_in_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `friday_out_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `saturday_in_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `saturday_out_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sunday_in_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sunday_out_time` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `office_shifts`
--

INSERT INTO `office_shifts` (`office_shift_id`, `company_id`, `added_by`, `shift_name`, `total_time`, `monday_in_time`, `monday_out_time`, `tuesday_in_time`, `tuesday_out_time`, `wednesday_in_time`, `wednesday_out_time`, `thursday_in_time`, `thursday_out_time`, `friday_in_time`, `friday_out_time`, `saturday_in_time`, `saturday_out_time`, `sunday_in_time`, `sunday_out_time`, `created_at`) VALUES
(8, 11, 68, '2jour/semaine', 16, '10:00 AM', '06:00 PM', '10:00 AM', '06:00 PM', '', '', '', '', '', '', '', '', '', '', '2023-09-26 11:41:46'),
(11, 11, 68, '5jours/semaine', 32, '08:30 AM', '04:30 PM', '08:30 AM', '04:30 PM', '10:00 AM', '06:00 PM', '08:30 AM', '04:30 PM', '', '', '', '', '', '', '2023-09-28 09:10:36'),
(12, 12, 71, '3 jours/semaine', 23, '08:30 AM', '04:30 PM', '08:30 AM', '03:00 PM', '08:30 AM', '04:30 PM', '', '', '', '', '', '', '', '', '2023-09-28 16:17:27'),
(13, 12, 71, '6jours/semaine', 48, '08:30 AM', '04:30 PM', '08:30 AM', '04:30 PM', '08:30 AM', '04:30 PM', '08:30 AM', '04:30 PM', '08:30 AM', '04:30 PM', '08:30 AM', '04:30 PM', '', '', '2023-09-28 16:23:33'),
(15, 11, 68, '4jours', 32, '08:30 AM', '04:30 PM', '08:30 AM', '04:30 PM', '10:30 AM', '06:30 PM', '10:00 AM', '06:00 PM', '', '', '', '', '', '', '2023-09-29 20:51:02'),
(16, 12, 71, '1', 18, '05:30 AM', '03:30 PM', '06:30 AM', '02:30 PM', '', '', '', '', '', '', '', '', '', '', '2023-09-29 21:12:17'),
(17, 17, 86, '2 jours', 16, '08:30 AM', '04:30 PM', '08:00 AM', '04:00 PM', '', '', '', '', '', '', '', '', '', '', '2023-09-30 09:12:25');

-- --------------------------------------------------------

--
-- Structure de la table `payslips`
--

CREATE TABLE `payslips` (
  `payslip_id` int NOT NULL,
  `payslip_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payslip_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `company_id` int DEFAULT NULL,
  `added_by` int DEFAULT NULL,
  `staff_id` int DEFAULT NULL,
  `salary_month` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `basic_salary` decimal(65,2) NOT NULL DEFAULT '0.00',
  `salary_imposable` decimal(65,2) NOT NULL,
  `net_before_taxes` int NOT NULL,
  `ipr` decimal(65,2) NOT NULL,
  `net_after_taxes` decimal(65,2) NOT NULL,
  `housing` int NOT NULL,
  `transport` decimal(65,2) NOT NULL,
  `cnss` int NOT NULL,
  `cnss_company` decimal(65,2) NOT NULL,
  `iere` int NOT NULL,
  `inpp` int NOT NULL,
  `onem` int NOT NULL,
  `salary_brut_company` decimal(65,2) NOT NULL,
  `total_other_payments` decimal(65,2) NOT NULL DEFAULT '0.00',
  `net_salary` decimal(65,2) NOT NULL DEFAULT '0.00',
  `pay_comments` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `is_payment` int DEFAULT NULL,
  `year_to_date` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `advance_salary_amount` decimal(65,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `payslips`
--

INSERT INTO `payslips` (`payslip_id`, `payslip_value`, `payslip_code`, `company_id`, `added_by`, `staff_id`, `salary_month`, `basic_salary`, `salary_imposable`, `net_before_taxes`, `ipr`, `net_after_taxes`, `housing`, `transport`, `cnss`, `cnss_company`, `iere`, `inpp`, `onem`, `salary_brut_company`, `total_other_payments`, `net_salary`, `pay_comments`, `is_payment`, `year_to_date`, `advance_salary_amount`, `created_at`) VALUES
(16, 'n7uQesymomKw6Xj', '#TDGW8N', 12, 71, 83, '2023-10', 150000.00, 150000.00, 142500, 42750.00, 99750.00, 45000, 15.27, 7500, 19500.00, 37500, 4500, 300, 256815.27, 0.00, 144765.27, 'ok', 1, '12-10-2023', NULL, '2023-10-12 10:24:07'),
(17, '6373rSrIfeqjriu', '#81BKHV', 12, 71, 84, '2023-10', 100.00, 100.00, 95, 5.80, 89.20, 30, 52.36, 5, 13.00, 25, 3, 0, 223.56, 0.00, 171.57, 'ok', 1, '12-10-2023', NULL, '2023-10-12 10:24:28'),
(21, 'ektGoCzfiTP1ZPQ', '#4MQYKL', 11, 68, 91, '2023-10', 6000.00, 375.00, 356, 30.59, 325.66, 113, 2.18, 19, 48.75, 0, 11, 1, 550.43, 0.00, 440.34, 'ok', 1, '25-10-2023', NULL, '2023-10-25 09:53:34'),
(22, 'kzqWCkO2vOxA24l', '#T3I6LI', 11, 68, 72, '2023-10', 5000.00, 1875.00, 1781, 378.52, 1402.73, 563, 6.55, 94, 243.75, 0, 56, 4, 2227.80, 0.00, 1451.78, 'ok', 1, '25-10-2023', NULL, '2023-10-25 11:15:12');

-- --------------------------------------------------------

--
-- Structure de la table `timesheet`
--

CREATE TABLE `timesheet` (
  `timesheet_id` int NOT NULL,
  `company_id` int NOT NULL,
  `added_by` int NOT NULL,
  `staff_id` int NOT NULL,
  `timesheet_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `clock_in` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `clock_out` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time_late` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `early_leaving` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `overtime` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `total_work` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total_rest` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total_sup` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `timesheet_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `timesheet`
--

INSERT INTO `timesheet` (`timesheet_id`, `company_id`, `added_by`, `staff_id`, `timesheet_date`, `clock_in`, `clock_out`, `time_late`, `early_leaving`, `overtime`, `total_work`, `total_rest`, `total_sup`, `timesheet_status`, `created_at`) VALUES
(4, 11, 68, 82, '2023-10-09', '10:00 AM', '08:00 PM', '0', '0', '0', '10', '0', '2', 'Present', '2023-10-17 11:43:58'),
(5, 11, 68, 72, '2023-10-17', '08:00 AM', '05:00 PM', '0', '0', '0', '9', '0', '1', 'Present', '2023-10-17 14:09:27'),
(6, 12, 71, 83, '2023-10-18', '07:00 AM', '04:00 PM', '0', '0', '0', '9', '0', '1', 'Present', '2023-10-18 05:56:37'),
(7, 12, 71, 83, '2023-10-17', '07:00 AM', '04:00 PM', '0', '0', '0', '9', '0', '1', 'Present', '2023-10-18 05:57:23'),
(8, 11, 68, 82, '2023-10-16', '08:30 AM', '05:30 PM', '0', '0', '0', '9', '0', '1', 'Present', '2023-10-18 08:57:33'),
(9, 11, 68, 72, '2023-10-16', '05:00 AM', '05:00 PM', '0', '0', '0', '12', '0', '4', 'Present', '2023-10-18 10:22:03'),
(10, 12, 71, 83, '2023-10-20', '07:00 AM', '02:00 PM', '0', '0', '0', '7', '1', '0', 'Present', '2023-10-18 10:30:04'),
(13, 11, 68, 91, '2023-10-18', '09:00 AM', '05:00 PM', '0', '0', '0', '8', '0', '0', 'Present', '2023-10-18 17:27:22'),
(15, 11, 68, 72, '2023-10-23', '08:00 AM', '04:00 PM', '0', '0', '0', '8', '0', '0', 'Present', '2023-10-23 10:41:48'),
(16, 11, 68, 82, '2023-10-23', '08:30 AM', '05:30 PM', '0', '0', '0', '9', '0', '1', 'Present', '2023-10-23 15:21:25'),
(17, 11, 68, 72, '2023-11-20', '08:00 AM', '05:00 PM', '0', '0', '0', '9', '0', '1', 'Present', '2023-11-25 00:08:06');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `emplyee_id` int DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `added_by` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `departement_id` int DEFAULT NULL,
  `designation_id` int DEFAULT NULL,
  `office_shift_id` int DEFAULT NULL,
  `children` int NOT NULL DEFAULT '0',
  `spouse` int NOT NULL DEFAULT '0',
  `poste_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contract_start` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contract_end` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `work_descricption` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `experience` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `basic_salary` decimal(65,2) DEFAULT NULL,
  `salary_type` int DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `marital_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bank_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bank_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cnss` int DEFAULT NULL,
  `contract_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ville` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_type_id` int DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `last_logout` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_logged_in` tinyint DEFAULT '0',
  `is_active` tinyint DEFAULT '0',
  `country_id` int DEFAULT NULL,
  `user_role_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `emplyee_id`, `company_id`, `added_by`, `name`, `email`, `username`, `birthday`, `gender`, `departement_id`, `designation_id`, `office_shift_id`, `children`, `spouse`, `poste_name`, `contract_start`, `contract_end`, `work_descricption`, `experience`, `basic_salary`, `salary_type`, `date_of_joining`, `marital_status`, `bank_name`, `bank_number`, `cnss`, `contract_type`, `ville`, `password`, `user_type_id`, `phone`, `address`, `image`, `last_login`, `last_logout`, `last_login_ip`, `is_logged_in`, `is_active`, `country_id`, `user_role_id`, `created_at`) VALUES
(34, NULL, NULL, NULL, 'Caleb Kiangebeni Dem', 'caalebs@gmail.com', 'mrfinker', '1750-07-22', NULL, NULL, NULL, NULL, 0, 0, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$fZHqgqr2SawPqmrEa.mo0errJj9rU9aj.kU4Fvs49OUxIoFVBFko.', 1, '145632', '1456324666', 'uploads/16950422953866853851169943641eagle-logo-design-inspiration-vector-conception-de-d-calibre-ic-ne-aile-148064393.jpg', '2023-10-26 11:41:45', '2023-10-27 03:13:35', '127.0.0.1', 0, 1, NULL, NULL, '2023-09-05 12:08:40'),
(67, NULL, NULL, NULL, 'simbaaaa', 'simba@gmail.com', 'simbangaa', '1800-06-17', NULL, NULL, NULL, NULL, 0, 0, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$FSJhv1IgU8BV9V1l0Mzyv.jQ8CBMBp/LRu6Xp6Z3y7CHGRSCHCJFG', 1, '123', '123', 'uploads/1695458695146727703697937812961eacb493774a5301453c709_Business meeting.png', '2023-10-18 12:00:02', '2023-10-18 12:03:31', '127.0.0.1', 0, 1, NULL, NULL, '2023-09-18 08:06:42'),
(68, NULL, 11, NULL, 'linked-solution', 'info@linked-solution.com', 'linkedSolution', NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 'RAWBANK', '11114444444', NULL, NULL, 'Kinshasa', '$2y$10$a5B/LVQjQLeVIacSoOJ6wOKVjWffYqSMPapjmE5O4Z02IEwCA6/.a', 3, '24382183153', 'Gombe, Kinshasa ', 'uploads/16983059081488629900670751003mrfinker_Manga_style_clean_lines_black_boy_24_years_intimidatin_59ad18b7-e847-4f4c-8a94-5d47996b8333.png', '2023-11-24 23:07:18', '2023-10-26 11:41:31', '127.0.0.1', 1, 1, 1, NULL, '2023-09-19 10:57:10'),
(71, NULL, 12, NULL, 'regideso', 'regideso@gmail.com', 'regideso', NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$1KEsIv6yu6Nq78hH5dGooOyacfCIScjCEQpfPUpI94NueW1G2Ov3W', 3, '24821831153', 'Gwani 5, Kinshasa Gombe', NULL, '2023-10-23 07:48:26', '2023-10-23 09:40:57', '127.0.0.1', 0, 1, 243, NULL, '2023-09-21 14:38:56'),
(72, 48569, 11, 68, 'Prisca Takask', 'taakaa@gmail.com', 'taka', '1940-06-25', 'Femme', 13, 6, 8, 5, 1, '', '', '', NULL, NULL, 5000.00, 1, NULL, 'Veuve/veuf', 'RAWBANK', '4444555889999', NULL, 'CDD', NULL, '$2y$10$fZHqgqr2SawPqmrEa.mo0errJj9rU9aj.kU4Fvs49OUxIoFVBFko.', 4, '2435869878', 'Gwani 5, Kinshasa Gombe', 'uploads/169538720415760524791216313866logo_eglise_ga.png', '2023-10-26 07:34:24', '2023-10-26 07:35:54', '127.0.0.1', 0, 1, 243, 4, '2023-09-22 01:20:04'),
(73, NULL, NULL, NULL, 'polila', 'poline@gmail.com', 'oly', NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$b/Fwa1Gw3GgUShRwRrLfoOJP/fs0/5HoUJc5lq0yqEtME.Ldb92Fu', 4, '243979276522', '123456', 'uploads/16953849698203197811706679453IMG_20221022_172618_394.jpg', NULL, NULL, NULL, 0, 0, NULL, NULL, '2023-09-22 12:16:09'),
(74, NULL, 13, NULL, 'Libanga', 'libanga@gmail.com', 'libanga', NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$6Ex1gc0vIJsfkfbyggewwe/R7I/.HwlN7zeQhP2xjapuvdhV48./G', 3, '243821831153', 'libanga@live.com', NULL, NULL, NULL, NULL, 0, 1, 70, NULL, '2023-09-22 13:15:15'),
(76, NULL, 15, NULL, 'snel', 'info@snel.com', 'snel', NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$b47FgR/ac1tHG2yW.O7YCuGhup.phIjILqTljXGI38DRxcl4cpoZO', 3, '243824444444', 'Gwani 5, Kinshasa Gombe', NULL, NULL, NULL, NULL, 0, 1, 72, NULL, '2023-09-25 10:49:01'),
(77, NULL, 16, NULL, 'dgrk', 'info@dgrk.com', 'dgrk', NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$JnlVnnQlM28kmf9pODwBWezR0gpFAREvhdwBwTK2nCSSTs.a/Hqd6', 3, '243821831153', 'Gwani 5, Kinshasa Gombe', NULL, NULL, NULL, NULL, 0, 1, 243, NULL, '2023-09-27 04:03:15'),
(82, 770883230, 11, 68, 'Gedeon gedeo', 'gedeon@gmail.com', 'gedeon', NULL, 'Homme', 13, 1, 11, 0, 0, '', '', '', NULL, NULL, 9000.00, 1, NULL, 'Veuve/veuf', NULL, NULL, NULL, 'CDI', NULL, '$2y$10$NqCJeuHSwm3HD0e1O/KmKusuEEuvGP.f.3VACvoVLTDvpIXgzNliG', 4, '243824444444', NULL, 'uploads/169823207819875885572116312863615d12d4ddc2a533720d25ec_Loading.png', '2023-10-25 13:56:25', '2023-10-25 13:57:15', '127.0.0.1', 0, 1, 51, 12, '2023-09-28 09:12:28'),
(83, 932108789, 12, 71, 'lipa mwamba', 'lipa@gmail.com', 'lipa', NULL, 'Femme', 9, 5, 12, 0, 0, '', '', '', NULL, NULL, 150000.00, 1, NULL, 'Veuve/veuf', NULL, NULL, NULL, 'CDD', NULL, '$2y$10$tAE3uYYKWWs6vCf5HBL5GuIuJuS0UoWCGYsFHhnt.an2ALj.ta5fi', 4, '0243000000', NULL, 'uploads/16959179181535039695479465829happy.png', NULL, NULL, NULL, 0, 1, 62, 11, '2023-09-28 16:18:38'),
(84, 412494351, 12, 71, 'arnold pelo', 'arnold@gmail.com', 'arnold', NULL, 'Homme', 9, 5, 13, 0, 0, '', '', '', NULL, NULL, 100.00, 1, NULL, 'Marier', NULL, NULL, NULL, 'CDD', NULL, '$2y$10$HPiiP1YeBORCyGyRrcUItu7RuQL12Xg85uB2C1Gi9FPm4okFn25xK', 4, '24300000', NULL, 'uploads/16959184451691361017742890645emberjs.png', '2023-09-29 10:03:59', '2023-09-29 10:04:15', '127.0.0.1', 0, 0, 77, 11, '2023-09-28 16:27:25'),
(85, 623871747, 11, 68, 'ebeyu ebeyaaaa', 'ebeya@gmail.com', 'ebeya', NULL, 'Homme', 13, 6, 11, 0, 0, '', '', '', NULL, NULL, 15000.00, 1, NULL, 'Marier', NULL, NULL, NULL, 'CDD', NULL, '$2y$10$PGPz2aRGgsXAMwOZ4UMHsepbVfYuWhGcIhIL1d9oKUD26pBCeK0ye', 4, '243991869947', NULL, 'uploads/169601947517407493821425758201680938563016.jpg', NULL, NULL, NULL, 0, 0, 243, 12, '2023-09-29 20:31:15'),
(86, NULL, 17, NULL, 'Mapa', 'mapa@gmail.com', 'mapa', NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$RSwq2pA3Iggzd3.0SDxcfOhWLpEfhKuhB2upV8OURJvKukZp6xtZm', 3, '243888888', 'Kintambo', NULL, '2023-09-30 08:06:28', '2023-09-30 08:26:43', '127.0.0.1', 0, 1, 243, NULL, '2023-09-30 09:03:37'),
(87, 672051338, 17, 86, 'kuluka Plamedi', 'plamedi@gmail.com', 'plamedi', NULL, 'Femme', 14, 7, 17, 0, 0, '', '', '', NULL, NULL, 5000.00, 1, NULL, 'Celibataire', NULL, NULL, NULL, 'CDI', NULL, '$2y$10$3R6/hIIW8SR9TN13MGrwyenzOYjonmFbddv8itMjirYijAijUjP8y', 4, '243819986678', 'Gwani', 'uploads/1696065271110897885961949696361b71abd64356d1317f36228_Mobile Marketing.png', NULL, NULL, NULL, 0, 1, 243, 13, '2023-09-30 09:14:31'),
(88, 805998656, 11, 68, 'Pringsley Pim', 'pring@gmail.com', 'pring', NULL, 'Homme', 1, 9, 11, 0, 0, '', '', '', NULL, NULL, 1800.00, 1, NULL, 'Celibataire', NULL, NULL, NULL, 'CDI', NULL, '$2y$10$z0W7dqN9MHr11uxvurVI6OVMFr9MgrAbHMd2Xb9EyXIzt7kZB0JWG', 4, '243821831153', NULL, 'uploads/1697031542203201791319866527fintech444 (2).png', NULL, NULL, NULL, 0, 0, 243, 12, '2023-10-11 13:39:02'),
(91, 794363623, 11, 68, 'bakajika paulin', 'paulin@gmail.com', 'paulin', NULL, 'Homme', 13, 1, 11, 15, 1, '', '', '', NULL, NULL, 6000.00, 1, NULL, 'Marier', NULL, NULL, NULL, 'CDD', NULL, '$2y$10$0/xNWPir5NNgMtLLjlz2E.pYtDqbADnv2QqeweO4nhyqgek0wwNF.', 4, '243821831153', NULL, 'uploads/16976451617863493701545228907mrfinker_Manga_style_clean_lines_black_boy_24_years_intimidatin_59ad18b7-e847-4f4c-8a94-5d47996b8333.png', NULL, NULL, NULL, 0, 0, 243, 4, '2023-10-18 16:06:01'),
(93, 390271029, 11, 68, 'test11 test', 'test111@test.com', 'test111', NULL, 'Femme', 13, 6, 8, 23, 1, '', '', '', NULL, NULL, 900.00, 1, NULL, 'Marier', NULL, NULL, NULL, 'CDD', NULL, '$2y$10$xRdBK11v99U4wCjsI2Z97uYAwAu0BuokpDTMd39yZshNyUT89Zb2S', 4, '243999999999', NULL, 'uploads/169813346215267671811990867324gros-plan-belle-fille-africaine-smiley.jpg', NULL, NULL, NULL, 0, 0, 5, 14, '2023-10-24 07:44:22'),
(95, 615688526, 11, 68, 'pilolo pilolo2', 'pilolo@gmail.com', 'pilolo', NULL, 'Homme', 13, 6, 8, 50, 6, '', '', '', NULL, NULL, 600.00, 1, NULL, 'Marier', NULL, NULL, NULL, 'CDD', NULL, '$2y$10$xunGqYQ4TffYeWks75Z43OSwmz7MXotglIWSVToA9.oVIjFtWZEwm', 4, '243555555555', NULL, 'uploads/169813509281080856020212768571680938563016.jpg', NULL, NULL, NULL, 0, 0, 10, 21, '2023-10-24 08:11:32');

-- --------------------------------------------------------

--
-- Structure de la table `users_role`
--

CREATE TABLE `users_role` (
  `id_role` int NOT NULL,
  `company_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `permissions` varchar(800) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `added_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users_role`
--

INSERT INTO `users_role` (`id_role`, `company_id`, `name`, `permissions`, `added_by`, `created_at`) VALUES
(4, 11, 'polllopppp', 'user_create, user_edit, user_liste, company_delete, privilege_edit', 68, '2023-09-23 05:09:10'),
(11, 12, 'po', 'admin_edit, company_edit', 71, '2023-09-25 15:45:56'),
(12, 11, 'plein', 'admin delete, company edit, privilege edit', 68, '2023-09-25 15:49:30'),
(13, 17, 'Marketing', 'admin create, company edit, privilege edit', 86, '2023-09-30 09:10:45'),
(14, 11, 'pongi', 'admin_edit, admin_delete, company_liste, privilege_create, privilege_edit, privilege_delete', 68, '2023-10-16 04:48:58'),
(21, 11, 'test', 'admin create, admin edit, admin delete', 68, '2023-10-20 07:51:56');

-- --------------------------------------------------------

--
-- Structure de la table `user_type`
--

CREATE TABLE `user_type` (
  `id_type` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_type`
--

INSERT INTO `user_type` (`id_type`, `name`, `created_at`) VALUES
(1, 'superadmin', '2023-09-01 08:35:56'),
(2, 'admin', '2023-09-01 08:35:56'),
(3, 'company', '2023-09-01 08:35:56'),
(4, 'staff', '2023-09-01 08:35:56');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `advanced_salary`
--
ALTER TABLE `advanced_salary`
  ADD PRIMARY KEY (`advanced_salary_id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `constants_dep_exp`
--
ALTER TABLE `constants_dep_exp`
  ADD PRIMARY KEY (`constants_id`);

--
-- Index pour la table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`currency_id`);

--
-- Index pour la table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Index pour la table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`designation_id`);

--
-- Index pour la table `finance_accounts`
--
ALTER TABLE `finance_accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Index pour la table `finance_transactions`
--
ALTER TABLE `finance_transactions`
  ADD PRIMARY KEY (`transactions_id`);

--
-- Index pour la table `membership_company`
--
ALTER TABLE `membership_company`
  ADD PRIMARY KEY (`membership_company_id`);

--
-- Index pour la table `membership_invoices`
--
ALTER TABLE `membership_invoices`
  ADD PRIMARY KEY (`membership_invoices_id`);

--
-- Index pour la table `membership_plan`
--
ALTER TABLE `membership_plan`
  ADD PRIMARY KEY (`membership_plan_id`);

--
-- Index pour la table `office_shifts`
--
ALTER TABLE `office_shifts`
  ADD PRIMARY KEY (`office_shift_id`);

--
-- Index pour la table `payslips`
--
ALTER TABLE `payslips`
  ADD PRIMARY KEY (`payslip_id`);

--
-- Index pour la table `timesheet`
--
ALTER TABLE `timesheet`
  ADD PRIMARY KEY (`timesheet_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_role`
--
ALTER TABLE `users_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id_type`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `advanced_salary`
--
ALTER TABLE `advanced_salary`
  MODIFY `advanced_salary_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `company`
--
ALTER TABLE `company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `constants_dep_exp`
--
ALTER TABLE `constants_dep_exp`
  MODIFY `constants_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `country`
--
ALTER TABLE `country`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT pour la table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `currency_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT pour la table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `designations`
--
ALTER TABLE `designations`
  MODIFY `designation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `finance_accounts`
--
ALTER TABLE `finance_accounts`
  MODIFY `account_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `finance_transactions`
--
ALTER TABLE `finance_transactions`
  MODIFY `transactions_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT pour la table `membership_company`
--
ALTER TABLE `membership_company`
  MODIFY `membership_company_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `membership_invoices`
--
ALTER TABLE `membership_invoices`
  MODIFY `membership_invoices_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `membership_plan`
--
ALTER TABLE `membership_plan`
  MODIFY `membership_plan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `office_shifts`
--
ALTER TABLE `office_shifts`
  MODIFY `office_shift_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `payslips`
--
ALTER TABLE `payslips`
  MODIFY `payslip_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `timesheet`
--
ALTER TABLE `timesheet`
  MODIFY `timesheet_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT pour la table `users_role`
--
ALTER TABLE `users_role`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id_type` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
