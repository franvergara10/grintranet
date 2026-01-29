/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `grintranet` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `grintranet`;

INSERT IGNORE INTO `holidays` (`id`, `name`, `date`, `description`, `created_at`, `updated_at`) VALUES
	(7, 'Navidad', '2025-12-25', NULL, '2026-01-23 08:02:35', '2026-01-23 08:02:35');

INSERT IGNORE INTO `schedule_templates` (`id`, `name`, `description`, `active_days`, `created_at`, `updated_at`) VALUES
	(1, 'Horario Escolar', 'Horario general para el curso 25/26', '["1", "2", "3", "4", "5"]', '2026-01-26 11:09:09', '2026-01-26 11:09:09');

INSERT IGNORE INTO `time_slots` (`id`, `schedule_template_id`, `name`, `start_time`, `end_time`, `order`, `created_at`, `updated_at`) VALUES
	(8, 1, '1a', '08:15:00', '09:15:00', 0, '2026-01-26 11:10:24', '2026-01-26 11:10:24'),
	(9, 1, '2a', '09:15:00', '10:15:00', 1, '2026-01-26 11:10:24', '2026-01-26 11:10:24'),
	(10, 1, '3a', '10:15:00', '11:15:00', 2, '2026-01-26 11:10:24', '2026-01-26 11:10:24'),
	(11, 1, 'RECREO', '11:15:00', '11:45:00', 3, '2026-01-26 11:10:24', '2026-01-26 11:10:24'),
	(12, 1, '4a', '11:45:00', '12:45:00', 4, '2026-01-26 11:10:24', '2026-01-26 11:10:24'),
	(13, 1, '5a', '12:45:00', '13:45:00', 5, '2026-01-26 11:10:24', '2026-01-26 11:10:24'),
	(14, 1, '6a', '13:45:00', '14:45:00', 6, '2026-01-26 11:10:24', '2026-01-26 11:10:24');

INSERT IGNORE INTO `zonas` (`id`, `nombre`, `planta`, `created_at`, `updated_at`) VALUES
	(1, 'SUM', 'Baja', '2026-01-26 12:22:58', '2026-01-26 12:22:58'),
	(2, 'w', '1a', '2026-01-26 12:32:06', '2026-01-26 12:32:06');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
