SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `article_category` (
  `article_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `article_category` (`article_id`, `category_id`) VALUES
(2, 1),
(8, 1);

CREATE TABLE `artykul` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `published_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `artykul` (`id`, `title`, `content`, `published_at`) VALUES
(2, 'KsiÄ…Å¼ka adresowa', 'Na etapie uczenia siÄ™ C++ stworzyÅ‚am ksiÄ…Å¼kÄ™ adresowa do tworzenia kontaktÃ³w. UÅ¼ytkownik musi siÄ™ zarejestrowaÄ‡, Å¼eby nastÄ™pnie mieÄ‡ dostÄ™p do swoich kontaktÃ³w. MoÅ¼e je dodawaÄ‡, edytowaÄ‡ oraz usuwaÄ‡. W razie potrzeby moÅ¼e wyszukaÄ‡ osobÄ™ po imieniu lub nazwisku. \r\n<a href=\"https://github.com/AgataDF/NEW_ksiazkaobiektowo\"> LINK DO GITHUB </a>', '2023-01-17'),
(8, 'BudÅ¼et osobisty', 'KolejnÄ… aplikacjÄ…, ktÃ³rÄ… zaprogramowaÅ‚am w C++, jest aplikacja do prowadzenia budÅ¼etu osobistego. UÅ¼ytkownik po uprzedniej rejestracji ma moÅ¼liwoÅ›Ä‡ kontrolowania swojego budÅ¼etu (dodawania przychodÃ³w i wydatkÃ³w). Program pokazuje saldo z wybranych okresÃ³w. \r\n<a href=\"https://github.com/AgataDF/MyFinanceApp\"> LINK DO GITHUB </a>', '2023-01-17');

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'C++'),
(5, 'CSS'),
(2, 'HTML'),
(6, 'PHP');

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'agata', '$2y$10$ODf7htGvvxUT4fSrtyer0uI4CxXCknQ0K2dk2d8ZyA4tUjEm4KWIy');


ALTER TABLE `article_category`
  ADD PRIMARY KEY (`article_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

ALTER TABLE `artykul`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `TITLE` (`title`);

ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);


ALTER TABLE `artykul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `article_category`
  ADD CONSTRAINT `article_category_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `artykul` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `article_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
