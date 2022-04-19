/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

INSERT INTO `misc` (`id`, `object`, `attribute`, `value`, `description`) VALUES
	(1, 'main_page', 'title', 'BTS Test Title', 'Page Title for main page'),
	(2, 'main_page', 'heading', 'BTS Test Heading', 'Page Heading for main page'),
	(3, 'admin_page', 'title', 'BTS Test Admin Title', 'Page Title for admin page'),
	(4, 'admin_page', 'heading', 'BTS Test Admin Heading', 'Page Heading for admin page'),
	(5, 'mobile_main_page', 'title', 'BTS Test Title Mobile', 'Page Title for mobile main page'),
	(6, 'mobile_main_page', 'heading', 'BTS Test Heading Mobile', 'Page Heading for mobile main page'),
	(7, 'ranking_page', 'title', 'BTS Test Ranking Title', 'Page Title for ranking page'),
	(8, 'ranking_page', 'heading', 'BTS Test Ranking Heading', 'Page Heading for ranking page'),
	(9, 'beer_rank', 'min_rate', '0', 'Min value for rating'),
	(10, 'beer_rank', 'max_rate', '10', 'Max value for rating'),
	(11, 'motd', 'activation', '1', 'Activation status of motd'),
	(12, 'strike_add', 'amount_normal', '1', 'Amount of a normal strike'),
	(13, 'strike_add', 'amount_event', '5', 'Amount of a event strike'),
	(14, 'strike_del', 'amount_normal', '3', 'Amount of a normal deletion'),
	(15, 'strike_del', 'amount_event', '5', 'Amount of a event deletion'),
	(16, 'general', 'version', 'v3.0', 'BTS version');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
