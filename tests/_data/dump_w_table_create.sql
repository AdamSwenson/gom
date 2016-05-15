# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.11)
# Database: gom_testing
# Generation Time: 2016-04-06 21:57:59 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

# Dump of table access_keys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `access_keys`;
CREATE TABLE `access_keys` (
  `id`             INT(10) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `access_key`     VARCHAR(255)
                   COLLATE utf8_unicode_ci NOT NULL,
  `student_id`     INT(10) UNSIGNED        NOT NULL,
  `exam_id`        INT(10) UNSIGNED        NOT NULL,
  `email_sent`     TINYINT(1)              NOT NULL DEFAULT '0',
  `access_expires` DATE                             DEFAULT NULL,
  `created_at`     TIMESTAMP               NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at`     TIMESTAMP               NOT NULL DEFAULT '0000-00-00 00:00:00',
  `student_info`   TEXT COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `access_keys_student_id_exam_id_unique` (`student_id`, `exam_id`),
  KEY `access_keys_access_key_index` (`access_key`),
  KEY `access_keys_student_id_index` (`student_id`),
  KEY `access_keys_exam_id_index` (`exam_id`),
  CONSTRAINT `access_keys_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `access_keys_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

INSERT INTO `access_keys` (`id`, `access_key`, `student_id`, `student_info`, `exam_id`, `email_sent`, `access_expires`, `created_at`, `updated_at`)
VALUES
  (1, '634b0f6bb2e56e46da6ab48d284d08b101ec1aa168cd715a9a0e570f5947135b', 1,
   '{\"studentName\":\"name1\", \"studentIdentifier\":\"identifier1\"}', 1, 0, '2019-01-01', NOW(), NOW());

# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id`         INT(10) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `user_id`    INT(10) UNSIGNED        NOT NULL,
  `element_id` INT(10) UNSIGNED        NOT NULL,
  `valence`    VARCHAR(255)
               COLLATE utf8_unicode_ci NOT NULL,
  `body`       TEXT COLLATE utf8_unicode_ci,
  `created_at` TIMESTAMP               NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP               NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_element_id_foreign` (`element_id`),
  CONSTRAINT `comments_element_id_foreign` FOREIGN KEY (`element_id`) REFERENCES `elements` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments`
  DISABLE KEYS */;

INSERT INTO `comments` (`id`, `user_id`, `element_id`, `valence`, `body`, `created_at`, `updated_at`)
VALUES
  (1, 1, 1, '0', 'comment1BodyText', NOW(), NOW()),
  (2, 1, 1, '1', 'comment2BodyText', NOW(), NOW()),
  (3, 1, 1, '2', 'comment3BodyText', NOW(), NOW()),
  (4, 1, 1, '3', 'comment4BodyText', NOW(), NOW()),
  (5, 1, 2, '0', 'comment5BodyText', NOW(), NOW()),
  (6, 1, 2, '1', 'comment6BodyText', NOW(), NOW()),
  (7, 1, 2, '2', 'comment7BodyText', NOW(), NOW()),
  (8, 1, 2, '3', 'comment8BodyText', NOW(), NOW()),
  (9, 1, 3, '0', 'comment9BodyText', NOW(), NOW()),
  (10, 1, 3, '1', 'comment10BodyText', NOW(), NOW()),
  (11, 1, 3, '2', 'comment11BodyText', NOW(), NOW()),
  (12, 1, 3, '3', 'comment12BodyText', NOW(), NOW()),
  (13, 1, 4, '0', 'comment13BodyText', NOW(), NOW()),
  (14, 1, 4, '1', 'comment14BodyText', NOW(), NOW()),
  (15, 1, 4, '2', 'comment15BodyText', NOW(), NOW()),
  (16, 1, 4, '3', 'comment16BodyText', NOW(), NOW()),
  (17, 1, 5, '0', 'comment17BodyText', NOW(), NOW()),
  (18, 1, 5, '1', 'comment18BodyText', NOW(), NOW()),
  (19, 1, 5, '2', 'comment19BodyText', NOW(), NOW()),
  (20, 1, 5, '3', 'comment20BodyText', NOW(), NOW()),
  (21, 1, 6, '0', 'comment21BodyText', NOW(), NOW()),
  (22, 1, 6, '1', 'comment22BodyText', NOW(), NOW()),
  (23, 1, 6, '2', 'comment23BodyText', NOW(), NOW()),
  (24, 1, 6, '3', 'comment24BodyText', NOW(), NOW()),
  (25, 1, 7, '0', 'comment25BodyText', NOW(), NOW()),
  (26, 1, 7, '1', 'comment26BodyText', NOW(), NOW()),
  (27, 1, 7, '2', 'comment27BodyText', NOW(), NOW()),
  (28, 1, 7, '3', 'comment28BodyText', NOW(), NOW()),
  (29, 1, 8, '0', 'comment29BodyText', NOW(), NOW()),
  (30, 1, 8, '1', 'comment30BodyText', NOW(), NOW()),
  (31, 1, 8, '2', 'comment31BodyText', NOW(), NOW()),
  (32, 1, 8, '3', 'comment32BodyText', NOW(), NOW()),
  (33, 1, 9, '0', 'comment33BodyText', NOW(), NOW()),
  (34, 1, 9, '1', 'comment34BodyText', NOW(), NOW()),
  (35, 1, 9, '2', 'comment35BodyText', NOW(), NOW()),
  (36, 1, 9, '3', 'comment36BodyText', NOW(), NOW()),
  (37, 1, 10, '0', 'comment37BodyText', NOW(), NOW()),
  (38, 1, 10, '1', 'comment38BodyText', NOW(), NOW()),
  (39, 1, 10, '2', 'comment39BodyText', NOW(), NOW()),
  (40, 1, 10, '3', 'comment40BodyText', NOW(), NOW()),
  (41, 1, 11, '0', 'comment41BodyText', NOW(), NOW()),
  (42, 1, 11, '1', 'comment42BodyText', NOW(), NOW()),
  (43, 1, 11, '2', 'comment43BodyText', NOW(), NOW()),
  (44, 1, 11, '3', 'comment44BodyText', NOW(), NOW()),
  (45, 1, 12, '0', 'comment45BodyText', NOW(), NOW()),
  (46, 1, 12, '1', 'comment46BodyText', NOW(), NOW()),
  (47, 1, 12, '2', 'comment47BodyText', NOW(), NOW()),
  (48, 1, 12, '3', 'comment48BodyText', NOW(), NOW()),
  (49, 1, 13, '0', 'comment49BodyText', NOW(), NOW()),
  (50, 1, 13, '1', 'comment50BodyText', NOW(), NOW()),
  (51, 1, 13, '2', 'comment51BodyText', NOW(), NOW()),
  (52, 1, 13, '3', 'comment52BodyText', NOW(), NOW()),
  (53, 1, 14, '0', 'comment53BodyText', NOW(), NOW()),
  (54, 1, 14, '1', 'comment54BodyText', NOW(), NOW()),
  (55, 1, 14, '2', 'comment55BodyText', NOW(), NOW()),
  (56, 1, 14, '3', 'comment56BodyText', NOW(), NOW()),
  (57, 1, 15, '0', 'comment57BodyText', NOW(), NOW()),
  (58, 1, 15, '1', 'comment58BodyText', NOW(), NOW()),
  (59, 1, 15, '2', 'comment59BodyText', NOW(), NOW()),
  (60, 1, 15, '3', 'comment60BodyText', NOW(), NOW()),
  (61, 1, 16, '0', 'comment61BodyText', NOW(), NOW()),
  (62, 1, 16, '1', 'comment62BodyText', NOW(), NOW()),
  (63, 1, 16, '2', 'comment63BodyText', NOW(), NOW()),
  (64, 1, 16, '3', 'comment64BodyText', NOW(), NOW()),
  (65, 1, 17, '0', 'comment65BodyText', NOW(), NOW()),
  (66, 1, 17, '1', 'comment66BodyText', NOW(), NOW()),
  (67, 1, 17, '2', 'comment67BodyText', NOW(), NOW()),
  (68, 1, 17, '3', 'comment68BodyText', NOW(), NOW()),
  (69, 1, 18, '0', 'comment69BodyText', NOW(), NOW()),
  (70, 1, 18, '1', 'comment70BodyText', NOW(), NOW()),
  (71, 1, 18, '2', 'comment71BodyText', NOW(), NOW()),
  (72, 1, 18, '3', 'comment72BodyText', NOW(), NOW()),
  (73, 1, 19, '0', 'comment73BodyText', NOW(), NOW()),
  (74, 1, 19, '1', 'comment74BodyText', NOW(), NOW()),
  (75, 1, 19, '2', 'comment75BodyText', NOW(), NOW()),
  (76, 1, 19, '3', 'comment76BodyText', NOW(), NOW()),
  (77, 1, 20, '0', 'comment77BodyText', NOW(), NOW()),
  (78, 1, 20, '1', 'comment78BodyText', NOW(), NOW()),
  (79, 1, 20, '2', 'comment79BodyText', NOW(), NOW()),
  (80, 1, 20, '3', 'comment80BodyText', NOW(), NOW()),
  (81, 1, 21, '0', 'comment81BodyText', NOW(), NOW()),
  (82, 1, 21, '1', 'comment82BodyText', NOW(), NOW()),
  (83, 1, 21, '2', 'comment83BodyText', NOW(), NOW()),
  (84, 1, 21, '3', 'comment84BodyText', NOW(), NOW()),
  (85, 1, 22, '0', 'comment85BodyText', NOW(), NOW()),
  (86, 1, 22, '1', 'comment86BodyText', NOW(), NOW()),
  (87, 1, 22, '2', 'comment87BodyText', NOW(), NOW()),
  (88, 1, 22, '3', 'comment88BodyText', NOW(), NOW()),
  (89, 1, 23, '0', 'comment89BodyText', NOW(), NOW()),
  (90, 1, 23, '1', 'comment90BodyText', NOW(), NOW()),
  (91, 1, 23, '2', 'comment91BodyText', NOW(), NOW()),
  (92, 1, 23, '3', 'comment92BodyText', NOW(), NOW()),
  (93, 1, 24, '0', 'comment93BodyText', NOW(), NOW()),
  (94, 1, 24, '1', 'comment94BodyText', NOW(), NOW()),
  (95, 1, 24, '2', 'comment95BodyText', NOW(), NOW()),
  (96, 1, 24, '3', 'comment96BodyText', NOW(), NOW()),
  (97, 1, 25, '0', 'comment97BodyText', NOW(), NOW()),
  (98, 1, 25, '1', 'comment98BodyText', NOW(), NOW()),
  (99, 1, 25, '2', 'comment99BodyText', NOW(), NOW()),
  (100, 1, 25, '3', 'comment100BodyText', NOW(), NOW()),
  (101, 1, 26, '0', 'comment101BodyText', NOW(), NOW()),
  (102, 1, 26, '1', 'comment102BodyText', NOW(), NOW()),
  (103, 1, 26, '2', 'comment103BodyText', NOW(), NOW()),
  (104, 1, 26, '3', 'comment104BodyText', NOW(), NOW()),
  (105, 1, 27, '0', 'comment105BodyText', NOW(), NOW()),
  (106, 1, 27, '1', 'comment106BodyText', NOW(), NOW()),
  (107, 1, 27, '2', 'comment107BodyText', NOW(), NOW()),
  (108, 1, 27, '3', 'comment108BodyText', NOW(), NOW()),
  (109, 1, 28, '0', 'comment109BodyText', NOW(), NOW()),
  (110, 1, 28, '1', 'comment110BodyText', NOW(), NOW()),
  (111, 1, 28, '2', 'comment111BodyText', NOW(), NOW()),
  (112, 1, 28, '3', 'comment112BodyText', NOW(), NOW()),
  (113, 1, 29, '0', 'comment113BodyText', NOW(), NOW()),
  (114, 1, 29, '1', 'comment114BodyText', NOW(), NOW()),
  (115, 1, 29, '2', 'comment115BodyText', NOW(), NOW()),
  (116, 1, 29, '3', 'comment116BodyText', NOW(), NOW()),
  (117, 1, 30, '0', 'comment117BodyText', NOW(), NOW()),
  (118, 1, 30, '1', 'comment118BodyText', NOW(), NOW()),
  (119, 1, 30, '2', 'comment119BodyText', NOW(), NOW()),
  (120, 1, 30, '3', 'comment120BodyText', NOW(), NOW()),
  (121, 1, 31, '0', 'comment121BodyText', NOW(), NOW()),
  (122, 1, 31, '1', 'comment122BodyText', NOW(), NOW()),
  (123, 1, 31, '2', 'comment123BodyText', NOW(), NOW()),
  (124, 1, 31, '3', 'comment124BodyText', NOW(), NOW()),
  (125, 1, 32, '0', 'comment125BodyText', NOW(), NOW()),
  (126, 1, 32, '1', 'comment126BodyText', NOW(), NOW()),
  (127, 1, 32, '2', 'comment127BodyText', NOW(), NOW()),
  (128, 1, 32, '3', 'comment128BodyText', NOW(), NOW()),
  (129, 1, 33, '0', 'comment129BodyText', NOW(), NOW()),
  (130, 1, 33, '1', 'comment130BodyText', NOW(), NOW()),
  (131, 1, 33, '2', 'comment131BodyText', NOW(), NOW()),
  (132, 1, 33, '3', 'comment132BodyText', NOW(), NOW()),
  (133, 1, 34, '0', 'comment133BodyText', NOW(), NOW()),
  (134, 1, 34, '1', 'comment134BodyText', NOW(), NOW()),
  (135, 1, 34, '2', 'comment135BodyText', NOW(), NOW()),
  (136, 1, 34, '3', 'comment136BodyText', NOW(), NOW()),
  (137, 1, 35, '0', 'comment137BodyText', NOW(), NOW()),
  (138, 1, 35, '1', 'comment138BodyText', NOW(), NOW()),
  (139, 1, 35, '2', 'comment139BodyText', NOW(), NOW()),
  (140, 1, 35, '3', 'comment140BodyText', NOW(), NOW()),
  (141, 1, 36, '0', 'comment141BodyText', NOW(), NOW()),
  (142, 1, 36, '1', 'comment142BodyText', NOW(), NOW()),
  (143, 1, 36, '2', 'comment143BodyText', NOW(), NOW()),
  (144, 1, 36, '3', 'comment144BodyText', NOW(), NOW()),
  (145, 1, 37, '0', 'comment145BodyText', NOW(), NOW()),
  (146, 1, 37, '1', 'comment146BodyText', NOW(), NOW()),
  (147, 1, 37, '2', 'comment147BodyText', NOW(), NOW()),
  (148, 1, 37, '3', 'comment148BodyText', NOW(), NOW()),
  (149, 1, 38, '0', 'comment149BodyText', NOW(), NOW()),
  (150, 1, 38, '1', 'comment150BodyText', NOW(), NOW()),
  (151, 1, 38, '2', 'comment151BodyText', NOW(), NOW()),
  (152, 1, 38, '3', 'comment152BodyText', NOW(), NOW()),
  (153, 1, 39, '0', 'comment153BodyText', NOW(), NOW()),
  (154, 1, 39, '1', 'comment154BodyText', NOW(), NOW()),
  (155, 1, 39, '2', 'comment155BodyText', NOW(), NOW()),
  (156, 1, 39, '3', 'comment156BodyText', NOW(), NOW()),
  (157, 1, 40, '0', 'comment157BodyText', NOW(), NOW()),
  (158, 1, 40, '1', 'comment158BodyText', NOW(), NOW()),
  (159, 1, 40, '2', 'comment159BodyText', NOW(), NOW()),
  (160, 1, 40, '3', 'comment160BodyText', NOW(), NOW()),
  (161, 1, 41, '0', 'comment161BodyText', NOW(), NOW()),
  (162, 1, 41, '1', 'comment162BodyText', NOW(), NOW()),
  (163, 1, 41, '2', 'comment163BodyText', NOW(), NOW()),
  (164, 1, 41, '3', 'comment164BodyText', NOW(), NOW()),
  (165, 1, 42, '0', 'comment165BodyText', NOW(), NOW()),
  (166, 1, 42, '1', 'comment166BodyText', NOW(), NOW()),
  (167, 1, 42, '2', 'comment167BodyText', NOW(), NOW()),
  (168, 1, 42, '3', 'comment168BodyText', NOW(), NOW()),
  (169, 1, 43, '0', 'comment169BodyText', NOW(), NOW()),
  (170, 1, 43, '1', 'comment170BodyText', NOW(), NOW()),
  (171, 1, 43, '2', 'comment171BodyText', NOW(), NOW()),
  (172, 1, 43, '3', 'comment172BodyText', NOW(), NOW()),
  (173, 1, 44, '0', 'comment173BodyText', NOW(), NOW()),
  (174, 1, 44, '1', 'comment174BodyText', NOW(), NOW()),
  (175, 1, 44, '2', 'comment175BodyText', NOW(), NOW()),
  (176, 1, 44, '3', 'comment176BodyText', NOW(), NOW()),
  (177, 1, 45, '0', 'comment177BodyText', NOW(), NOW()),
  (178, 1, 45, '1', 'comment178BodyText', NOW(), NOW()),
  (179, 1, 45, '2', 'comment179BodyText', NOW(), NOW()),
  (180, 1, 45, '3', 'comment180BodyText', NOW(), NOW()),
  (181, 1, 46, '0', 'comment181BodyText', NOW(), NOW()),
  (182, 1, 46, '1', 'comment182BodyText', NOW(), NOW()),
  (183, 1, 46, '2', 'comment183BodyText', NOW(), NOW()),
  (184, 1, 46, '3', 'comment184BodyText', NOW(), NOW()),
  (185, 1, 47, '0', 'comment185BodyText', NOW(), NOW()),
  (186, 1, 47, '1', 'comment186BodyText', NOW(), NOW()),
  (187, 1, 47, '2', 'comment187BodyText', NOW(), NOW()),
  (188, 1, 47, '3', 'comment188BodyText', NOW(), NOW()),
  (189, 1, 48, '0', 'comment189BodyText', NOW(), NOW()),
  (190, 1, 48, '1', 'comment190BodyText', NOW(), NOW()),
  (191, 1, 48, '2', 'comment191BodyText', NOW(), NOW()),
  (192, 1, 48, '3', 'comment192BodyText', NOW(), NOW()),
  (193, 1, 49, '0', 'comment193BodyText', NOW(), NOW()),
  (194, 1, 49, '1', 'comment194BodyText', NOW(), NOW()),
  (195, 1, 49, '2', 'comment195BodyText', NOW(), NOW()),
  (196, 1, 49, '3', 'comment196BodyText', NOW(), NOW()),
  (197, 1, 50, '0', 'comment197BodyText', NOW(), NOW()),
  (198, 1, 50, '1', 'comment198BodyText', NOW(), NOW()),
  (199, 1, 50, '2', 'comment199BodyText', NOW(), NOW()),
  (200, 1, 50, '3', 'comment200BodyText', NOW(), NOW());


/*!40000 ALTER TABLE `comments`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table element_assignments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `element_assignments`;

CREATE TABLE `element_assignments` (
  `id`          INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_id`     INT(10) UNSIGNED NOT NULL,
  `question_id` INT(10) UNSIGNED NOT NULL,
  `element_id`  INT(10) UNSIGNED NOT NULL,
  `subtask`     INT(10) UNSIGNED NOT NULL,
  `created_at`  TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at`  TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `el_assign_unique` (`exam_id`, `question_id`, `subtask`),
  UNIQUE KEY `element_assignments_exam_id_element_id_unique` (`exam_id`, `element_id`),
  KEY `element_assignments_element_id_foreign` (`element_id`),
  KEY `element_assignments_question_id_foreign` (`question_id`),
  CONSTRAINT `element_assignments_element_id_foreign` FOREIGN KEY (`element_id`) REFERENCES `elements` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `element_assignments_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `element_assignments_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `element_assignments` WRITE;
/*!40000 ALTER TABLE `element_assignments`
  DISABLE KEYS */;

INSERT INTO `element_assignments` (`id`, `exam_id`, `question_id`, `element_id`, `subtask`, `created_at`, `updated_at`)
VALUES
  (1, 1, 1, 1, 1, NOW(), NOW()),
  (2, 1, 1, 2, 2, NOW(), NOW()),
  (3, 1, 1, 3, 3, NOW(), NOW()),
  (4, 1, 1, 4, 4, NOW(), NOW()),
  (5, 1, 1, 5, 5, NOW(), NOW()),
  (6, 1, 2, 6, 1, NOW(), NOW()),
  (7, 1, 2, 7, 2, NOW(), NOW()),
  (8, 1, 2, 8, 3, NOW(), NOW()),
  (9, 1, 2, 9, 4, NOW(), NOW()),
  (10, 1, 2, 10, 5, NOW(), NOW()),
  (11, 1, 3, 11, 1, NOW(), NOW()),
  (12, 1, 3, 12, 2, NOW(), NOW()),
  (13, 1, 3, 13, 3, NOW(), NOW()),
  (14, 1, 3, 14, 4, NOW(), NOW()),
  (15, 1, 3, 15, 5, NOW(), NOW()),
  (16, 1, 4, 16, 1, NOW(), NOW()),
  (17, 1, 4, 17, 2, NOW(), NOW()),
  (18, 1, 4, 18, 3, NOW(), NOW()),
  (19, 1, 4, 19, 4, NOW(), NOW()),
  (20, 1, 4, 20, 5, NOW(), NOW()),
  (21, 1, 5, 21, 1, NOW(), NOW()),
  (22, 1, 5, 22, 2, NOW(), NOW()),
  (23, 1, 5, 23, 3, NOW(), NOW()),
  (24, 1, 5, 24, 4, NOW(), NOW()),
  (25, 1, 5, 25, 5, NOW(), NOW()),
  (26, 2, 6, 26, 1, NOW(), NOW()),
  (27, 2, 6, 27, 2, NOW(), NOW()),
  (28, 2, 6, 28, 3, NOW(), NOW()),
  (29, 2, 6, 29, 4, NOW(), NOW()),
  (30, 2, 6, 30, 5, NOW(), NOW()),
  (31, 2, 7, 31, 1, NOW(), NOW()),
  (32, 2, 7, 32, 2, NOW(), NOW()),
  (33, 2, 7, 33, 3, NOW(), NOW()),
  (34, 2, 7, 34, 4, NOW(), NOW()),
  (35, 2, 7, 35, 5, NOW(), NOW()),
  (36, 2, 8, 36, 1, NOW(), NOW()),
  (37, 2, 8, 37, 2, NOW(), NOW()),
  (38, 2, 8, 38, 3, NOW(), NOW()),
  (39, 2, 8, 39, 4, NOW(), NOW()),
  (40, 2, 8, 40, 5, NOW(), NOW()),
  (41, 2, 9, 41, 1, NOW(), NOW()),
  (42, 2, 9, 42, 2, NOW(), NOW()),
  (43, 2, 9, 43, 3, NOW(), NOW()),
  (44, 2, 9, 44, 4, NOW(), NOW()),
  (45, 2, 9, 45, 5, NOW(), NOW()),
  (46, 2, 10, 46, 1, NOW(), NOW()),
  (47, 2, 10, 47, 2, NOW(), NOW()),
  (48, 2, 10, 48, 3, NOW(), NOW()),
  (49, 2, 10, 49, 4, NOW(), NOW()),
  (50, 2, 10, 50, 5, NOW(), NOW()),
  (51, 3, 11, 51, 1, NOW(), NOW()),
  (52, 3, 11, 52, 2, NOW(), NOW()),
  (53, 3, 11, 53, 3, NOW(), NOW()),
  (54, 3, 11, 54, 4, NOW(), NOW()),
  (55, 3, 11, 55, 5, NOW(), NOW()),
  (56, 3, 12, 56, 1, NOW(), NOW()),
  (57, 3, 12, 57, 2, NOW(), NOW()),
  (58, 3, 12, 58, 3, NOW(), NOW()),
  (59, 3, 12, 59, 4, NOW(), NOW()),
  (60, 3, 12, 60, 5, NOW(), NOW()),
  (61, 3, 13, 61, 1, NOW(), NOW()),
  (62, 3, 13, 62, 2, NOW(), NOW()),
  (63, 3, 13, 63, 3, NOW(), NOW()),
  (64, 3, 13, 64, 4, NOW(), NOW()),
  (65, 3, 13, 65, 5, NOW(), NOW()),
  (66, 3, 14, 66, 1, NOW(), NOW()),
  (67, 3, 14, 67, 2, NOW(), NOW()),
  (68, 3, 14, 68, 3, NOW(), NOW()),
  (69, 3, 14, 69, 4, NOW(), NOW()),
  (70, 3, 14, 70, 5, NOW(), NOW()),
  (71, 3, 15, 71, 1, NOW(), NOW()),
  (72, 3, 15, 72, 2, NOW(), NOW()),
  (73, 3, 15, 73, 3, NOW(), NOW()),
  (74, 3, 15, 74, 4, NOW(), NOW()),
  (75, 3, 15, 75, 5, NOW(), NOW());

/*!40000 ALTER TABLE `element_assignments`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table element_scores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `element_scores`;

CREATE TABLE `element_scores` (
  `id`                    INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `element_assignment_id` INT(10) UNSIGNED NOT NULL,
  `student_id`            INT(10) UNSIGNED NOT NULL,
  `score`                 DOUBLE(8, 2)              DEFAULT NULL,
  `comment_text`          TEXT COLLATE utf8_unicode_ci,
  `created_at`            TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at`            TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `elassign_unique` (`element_assignment_id`, `student_id`),
  KEY `element_scores_student_id_foreign` (`student_id`),
  CONSTRAINT `element_scores_element_assignment_id_foreign` FOREIGN KEY (`element_assignment_id`) REFERENCES `element_assignments` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `element_scores_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `element_scores` WRITE;
/*!40000 ALTER TABLE `element_scores`
  DISABLE KEYS */;


INSERT INTO `element_scores` (`id`, `element_assignment_id`, `student_id`, `score`, `comment_text`, `created_at`, `updated_at`)
VALUES
  (1, 1, 1, 92.71, 'customText1', NOW(), NOW()),
  (2, 1, 2, 1.03, 'customText2', NOW(), NOW()),
  (3, 1, 3, 59.75, 'customText3', NOW(), NOW()),
  (4, 1, 4, 59.99, 'customText4', NOW(), NOW()),
  (5, 1, 5, 39.97, 'customText5', NOW(), NOW()),
  (6, 2, 1, 74.9, 'customText6', NOW(), NOW()),
  (7, 2, 2, 56.59, 'customText7', NOW(), NOW()),
  (8, 2, 3, 46.63, 'customText8', NOW(), NOW()),
  (9, 2, 4, 82.09, 'customText9', NOW(), NOW()),
  (10, 2, 5, 0.8, 'customText10', NOW(), NOW()),
  (11, 3, 1, 61.77, 'customText11', NOW(), NOW()),
  (12, 3, 2, 26.1, 'customText12', NOW(), NOW()),
  (13, 3, 3, 18.72, 'customText13', NOW(), NOW()),
  (14, 3, 4, 74.23, 'customText14', NOW(), NOW()),
  (15, 3, 5, 90.46, 'customText15', NOW(), NOW()),
  (16, 4, 1, 40.35, 'customText16', NOW(), NOW()),
  (17, 4, 2, 39.77, 'customText17', NOW(), NOW()),
  (18, 4, 3, 58.11, 'customText18', NOW(), NOW()),
  (19, 4, 4, 39.09, 'customText19', NOW(), NOW()),
  (20, 4, 5, 81.58, 'customText20', NOW(), NOW()),
  (21, 5, 1, 25.2, 'customText21', NOW(), NOW()),
  (22, 5, 2, 2.39, 'customText22', NOW(), NOW()),
  (23, 5, 3, 87.54, 'customText23', NOW(), NOW()),
  (24, 5, 4, 50.01, 'customText24', NOW(), NOW()),
  (25, 5, 5, 47.79, 'customText25', NOW(), NOW()),
  (51, 11, 1, 23.78, 'customText51', NOW(), NOW()),
  (52, 11, 2, 17.69, 'customText52', NOW(), NOW()),
  (53, 11, 3, 38.9, 'customText53', NOW(), NOW()),
  (54, 11, 4, 81.62, 'customText54', NOW(), NOW()),
  (55, 11, 5, 58.9, 'customText55', NOW(), NOW()),
  (56, 12, 1, 93.32, 'customText56', NOW(), NOW()),
  (57, 12, 2, 9.05, 'customText57', NOW(), NOW()),
  (58, 12, 3, 62.32, 'customText58', NOW(), NOW()),
  (59, 12, 4, 95.9, 'customText59', NOW(), NOW()),
  (60, 12, 5, 33.51, 'customText60', NOW(), NOW()),
  (61, 13, 1, 55.59, 'customText61', NOW(), NOW()),
  (62, 13, 2, 53.92, 'customText62', NOW(), NOW()),
  (63, 13, 3, 22.69, 'customText63', NOW(), NOW()),
  (64, 13, 4, 86.48, 'customText64', NOW(), NOW()),
  (65, 13, 5, 80.72, 'customText65', NOW(), NOW()),
  (66, 14, 1, 29.15, 'customText66', NOW(), NOW()),
  (67, 14, 2, 10.9, 'customText67', NOW(), NOW()),
  (68, 14, 3, 54.54, 'customText68', NOW(), NOW()),
  (69, 14, 4, 12.04, 'customText69', NOW(), NOW()),
  (70, 14, 5, 14.23, 'customText70', NOW(), NOW()),
  (71, 15, 1, 97.49, 'customText71', NOW(), NOW()),
  (72, 15, 2, 46.92, 'customText72', NOW(), NOW()),
  (73, 15, 3, 28.34, 'customText73', NOW(), NOW()),
  (74, 15, 4, 53.92, 'customText74', NOW(), NOW()),
  (75, 15, 5, 61.55, 'customText75', NOW(), NOW()),
  (76, 16, 1, 64.72, 'customText76', NOW(), NOW()),
  (77, 16, 2, 90.27, 'customText77', NOW(), NOW()),
  (78, 16, 3, 11.51, 'customText78', NOW(), NOW()),
  (79, 16, 4, 63.04, 'customText79', NOW(), NOW()),
  (80, 16, 5, 62.8, 'customText80', NOW(), NOW()),
  (81, 17, 1, 27.56, 'customText81', NOW(), NOW()),
  (82, 17, 2, 27.17, 'customText82', NOW(), NOW()),
  (83, 17, 3, 50.05, 'customText83', NOW(), NOW()),
  (84, 17, 4, 76.11, 'customText84', NOW(), NOW()),
  (85, 17, 5, 91.84, 'customText85', NOW(), NOW()),
  (86, 18, 1, 42.99, 'customText86', NOW(), NOW()),
  (87, 18, 2, 32.37, 'customText87', NOW(), NOW()),
  (88, 18, 3, 78.54, 'customText88', NOW(), NOW()),
  (89, 18, 4, 26.25, 'customText89', NOW(), NOW()),
  (90, 18, 5, 20.84, 'customText90', NOW(), NOW()),
  (91, 19, 1, 90.81, 'customText91', NOW(), NOW()),
  (92, 19, 2, 53.49, 'customText92', NOW(), NOW()),
  (93, 19, 3, 25.46, 'customText93', NOW(), NOW()),
  (94, 19, 4, 59.29, 'customText94', NOW(), NOW()),
  (95, 19, 5, 96.22, 'customText95', NOW(), NOW()),
  (96, 20, 1, 18.59, 'customText96', NOW(), NOW()),
  (97, 20, 2, 51.49, 'customText97', NOW(), NOW()),
  (98, 20, 3, 58.78, 'customText98', NOW(), NOW()),
  (99, 20, 4, 93.69, 'customText99', NOW(), NOW()),
  (100, 20, 5, 65.17, 'customText100', NOW(), NOW()),
  (101, 21, 1, 61.43, 'customText101', NOW(), NOW()),
  (102, 21, 2, 55.04, 'customText102', NOW(), NOW()),
  (103, 21, 3, 1.52, 'customText103', NOW(), NOW()),
  (104, 21, 4, 16.66, 'customText104', NOW(), NOW()),
  (105, 21, 5, 85.67, 'customText105', NOW(), NOW()),
  (106, 22, 1, 85.44, 'customText106', NOW(), NOW()),
  (107, 22, 2, 19.45, 'customText107', NOW(), NOW()),
  (108, 22, 3, 60.57, 'customText108', NOW(), NOW()),
  (109, 22, 4, 29.15, 'customText109', NOW(), NOW()),
  (110, 22, 5, 68.97, 'customText110', NOW(), NOW()),
  (111, 23, 1, 74.89, 'customText111', NOW(), NOW()),
  (112, 23, 2, 92.99, 'customText112', NOW(), NOW()),
  (113, 23, 3, 96.39, 'customText113', NOW(), NOW()),
  (114, 23, 4, 61.43, 'customText114', NOW(), NOW()),
  (115, 23, 5, 79.8, 'customText115', NOW(), NOW()),
  (116, 24, 1, 78.46, 'customText116', NOW(), NOW()),
  (117, 24, 2, 17.99, 'customText117', NOW(), NOW()),
  (118, 24, 3, 7.85, 'customText118', NOW(), NOW()),
  (119, 24, 4, 85.06, 'customText119', NOW(), NOW()),
  (120, 24, 5, 65.71, 'customText120', NOW(), NOW()),
  (121, 25, 1, 58.62, 'customText121', NOW(), NOW()),
  (122, 25, 2, 90.53, 'customText122', NOW(), NOW()),
  (123, 25, 3, 19.88, 'customText123', NOW(), NOW()),
  (124, 25, 4, 2.89, 'customText124', NOW(), NOW());

/*!40000 ALTER TABLE `element_scores`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table elements
# ------------------------------------------------------------

DROP TABLE IF EXISTS `elements`;

CREATE TABLE `elements` (
  `id`          INT(10) UNSIGNED             NOT NULL AUTO_INCREMENT,
  `user_id`     INT(10) UNSIGNED             NOT NULL,
  `elementName` VARCHAR(255)
                COLLATE utf8_unicode_ci      NOT NULL,
  `displayText` VARCHAR(255)
                COLLATE utf8_unicode_ci      NOT NULL,
  `commentText` TEXT COLLATE utf8_unicode_ci NOT NULL,
  `created_at`  TIMESTAMP                    NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at`  TIMESTAMP                    NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `elements_user_id_foreign` (`user_id`),
  CONSTRAINT `elements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `elements` WRITE;
/*!40000 ALTER TABLE `elements`
  DISABLE KEYS */;

INSERT INTO `elements` (`id`, `user_id`, `elementName`, `displayText`, `commentText`, `created_at`, `updated_at`)
VALUES
  (1, 1, 'Element1Name', 'Element1DisplayText', 'Element1CommentText', NOW(), NOW()),
  (2, 1, 'Element2Name', 'Element2DisplayText', 'Element2CommentText', NOW(), NOW()),
  (3, 1, 'Element3Name', 'Element3DisplayText', 'Element3CommentText', NOW(), NOW()),
  (4, 1, 'Element4Name', 'Element4DisplayText', 'Element4CommentText', NOW(), NOW()),
  (5, 1, 'Element5Name', 'Element5DisplayText', 'Element5CommentText', NOW(), NOW()),
  (6, 1, 'Element6Name', 'Element6DisplayText', 'Element6CommentText', NOW(), NOW()),
  (7, 1, 'Element7Name', 'Element7DisplayText', 'Element7CommentText', NOW(), NOW()),
  (8, 1, 'Element8Name', 'Element8DisplayText', 'Element8CommentText', NOW(), NOW()),
  (9, 1, 'Element9Name', 'Element9DisplayText', 'Element9CommentText', NOW(), NOW()),
  (10, 1, 'Element10Name', 'Element10DisplayText', 'Element10CommentText', NOW(), NOW()),
  (11, 1, 'Element11Name', 'Element11DisplayText', 'Element11CommentText', NOW(), NOW()),
  (12, 1, 'Element12Name', 'Element12DisplayText', 'Element12CommentText', NOW(), NOW()),
  (13, 1, 'Element13Name', 'Element13DisplayText', 'Element13CommentText', NOW(), NOW()),
  (14, 1, 'Element14Name', 'Element14DisplayText', 'Element14CommentText', NOW(), NOW()),
  (15, 1, 'Element15Name', 'Element15DisplayText', 'Element15CommentText', NOW(), NOW()),
  (16, 1, 'Element16Name', 'Element16DisplayText', 'Element16CommentText', NOW(), NOW()),
  (17, 1, 'Element17Name', 'Element17DisplayText', 'Element17CommentText', NOW(), NOW()),
  (18, 1, 'Element18Name', 'Element18DisplayText', 'Element18CommentText', NOW(), NOW()),
  (19, 1, 'Element19Name', 'Element19DisplayText', 'Element19CommentText', NOW(), NOW()),
  (20, 1, 'Element20Name', 'Element20DisplayText', 'Element20CommentText', NOW(), NOW()),
  (21, 1, 'Element21Name', 'Element21DisplayText', 'Element21CommentText', NOW(), NOW()),
  (22, 1, 'Element22Name', 'Element22DisplayText', 'Element22CommentText', NOW(), NOW()),
  (23, 1, 'Element23Name', 'Element23DisplayText', 'Element23CommentText', NOW(), NOW()),
  (24, 1, 'Element24Name', 'Element24DisplayText', 'Element24CommentText', NOW(), NOW()),
  (25, 1, 'Element25Name', 'Element25DisplayText', 'Element25CommentText', NOW(), NOW()),
  (26, 1, 'Element26Name', 'Element26DisplayText', 'Element26CommentText', NOW(), NOW()),
  (27, 1, 'Element27Name', 'Element27DisplayText', 'Element27CommentText', NOW(), NOW()),
  (28, 1, 'Element28Name', 'Element28DisplayText', 'Element28CommentText', NOW(), NOW()),
  (29, 1, 'Element29Name', 'Element29DisplayText', 'Element29CommentText', NOW(), NOW()),
  (30, 1, 'Element30Name', 'Element30DisplayText', 'Element30CommentText', NOW(), NOW()),
  (31, 1, 'Element31Name', 'Element31DisplayText', 'Element31CommentText', NOW(), NOW()),
  (32, 1, 'Element32Name', 'Element32DisplayText', 'Element32CommentText', NOW(), NOW()),
  (33, 1, 'Element33Name', 'Element33DisplayText', 'Element33CommentText', NOW(), NOW()),
  (34, 1, 'Element34Name', 'Element34DisplayText', 'Element34CommentText', NOW(), NOW()),
  (35, 1, 'Element35Name', 'Element35DisplayText', 'Element35CommentText', NOW(), NOW()),
  (36, 1, 'Element36Name', 'Element36DisplayText', 'Element36CommentText', NOW(), NOW()),
  (37, 1, 'Element37Name', 'Element37DisplayText', 'Element37CommentText', NOW(), NOW()),
  (38, 1, 'Element38Name', 'Element38DisplayText', 'Element38CommentText', NOW(), NOW()),
  (39, 1, 'Element39Name', 'Element39DisplayText', 'Element39CommentText', NOW(), NOW()),
  (40, 1, 'Element40Name', 'Element40DisplayText', 'Element40CommentText', NOW(), NOW()),
  (41, 1, 'Element41Name', 'Element41DisplayText', 'Element41CommentText', NOW(), NOW()),
  (42, 1, 'Element42Name', 'Element42DisplayText', 'Element42CommentText', NOW(), NOW()),
  (43, 1, 'Element43Name', 'Element43DisplayText', 'Element43CommentText', NOW(), NOW()),
  (44, 1, 'Element44Name', 'Element44DisplayText', 'Element44CommentText', NOW(), NOW()),
  (45, 1, 'Element45Name', 'Element45DisplayText', 'Element45CommentText', NOW(), NOW()),
  (46, 1, 'Element46Name', 'Element46DisplayText', 'Element46CommentText', NOW(), NOW()),
  (47, 1, 'Element47Name', 'Element47DisplayText', 'Element47CommentText', NOW(), NOW()),
  (48, 1, 'Element48Name', 'Element48DisplayText', 'Element48CommentText', NOW(), NOW()),
  (49, 1, 'Element49Name', 'Element49DisplayText', 'Element49CommentText', NOW(), NOW()),
  (50, 1, 'Element50Name', 'Element50DisplayText', 'Element50CommentText', NOW(), NOW()),
  (51, 2, 'Element51Name', 'Element51DisplayText', 'Element51CommentText', NOW(), NOW()),
  (52, 2, 'Element52Name', 'Element52DisplayText', 'Element52CommentText', NOW(), NOW()),
  (53, 2, 'Element53Name', 'Element53DisplayText', 'Element53CommentText', NOW(), NOW()),
  (54, 2, 'Element54Name', 'Element54DisplayText', 'Element54CommentText', NOW(), NOW()),
  (55, 2, 'Element55Name', 'Element55DisplayText', 'Element55CommentText', NOW(), NOW()),
  (56, 2, 'Element56Name', 'Element56DisplayText', 'Element56CommentText', NOW(), NOW()),
  (57, 2, 'Element57Name', 'Element57DisplayText', 'Element57CommentText', NOW(), NOW()),
  (58, 2, 'Element58Name', 'Element58DisplayText', 'Element58CommentText', NOW(), NOW()),
  (59, 2, 'Element59Name', 'Element59DisplayText', 'Element59CommentText', NOW(), NOW()),
  (60, 2, 'Element60Name', 'Element60DisplayText', 'Element60CommentText', NOW(), NOW()),
  (61, 2, 'Element61Name', 'Element61DisplayText', 'Element61CommentText', NOW(), NOW()),
  (62, 2, 'Element62Name', 'Element62DisplayText', 'Element62CommentText', NOW(), NOW()),
  (63, 2, 'Element63Name', 'Element63DisplayText', 'Element63CommentText', NOW(), NOW()),
  (64, 2, 'Element64Name', 'Element64DisplayText', 'Element64CommentText', NOW(), NOW()),
  (65, 2, 'Element65Name', 'Element65DisplayText', 'Element65CommentText', NOW(), NOW()),
  (66, 2, 'Element66Name', 'Element66DisplayText', 'Element66CommentText', NOW(), NOW()),
  (67, 2, 'Element67Name', 'Element67DisplayText', 'Element67CommentText', NOW(), NOW()),
  (68, 2, 'Element68Name', 'Element68DisplayText', 'Element68CommentText', NOW(), NOW()),
  (69, 2, 'Element69Name', 'Element69DisplayText', 'Element69CommentText', NOW(), NOW()),
  (70, 2, 'Element70Name', 'Element70DisplayText', 'Element70CommentText', NOW(), NOW()),
  (71, 2, 'Element71Name', 'Element71DisplayText', 'Element71CommentText', NOW(), NOW()),
  (72, 2, 'Element72Name', 'Element72DisplayText', 'Element72CommentText', NOW(), NOW()),
  (73, 2, 'Element73Name', 'Element73DisplayText', 'Element73CommentText', NOW(), NOW()),
  (74, 2, 'Element74Name', 'Element74DisplayText', 'Element74CommentText', NOW(), NOW()),
  (75, 2, 'Element75Name', 'Element75DisplayText', 'Element75CommentText', NOW(), NOW());

/*!40000 ALTER TABLE `elements`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table exam_kumi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exam_kumi`;

CREATE TABLE `exam_kumi` (
  `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_id`    INT(10) UNSIGNED NOT NULL,
  `kumi_id`    INT(10) UNSIGNED NOT NULL,
  `created_at` TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `exam_kumi_exam_id_foreign` (`exam_id`),
  KEY `exam_kumi_kumi_id_foreign` (`kumi_id`),
  CONSTRAINT `exam_kumi_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `exam_kumi_kumi_id_foreign` FOREIGN KEY (`kumi_id`) REFERENCES `kumis` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `exam_kumi` WRITE;
/*!40000 ALTER TABLE `exam_kumi`
  DISABLE KEYS */;

INSERT INTO `exam_kumi` (`id`, `exam_id`, `kumi_id`, `created_at`, `updated_at`)
VALUES
  (1, 1, 1, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (2, 2, 2, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (3, 3, 3, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (4, 2, 4, '2016-03-14 15:18:27', '2016-03-14 15:18:27');

/*!40000 ALTER TABLE `exam_kumi`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table exams
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exams`;
CREATE TABLE `exams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `released` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `previously_released` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `exams_user_id_foreign` (`user_id`),
  CONSTRAINT `exams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


LOCK TABLES `exams` WRITE;
/*!40000 ALTER TABLE `exams`
  DISABLE KEYS */;

INSERT INTO `exams` (`id`, `user_id`, `term`, `year`, `name`, `locked`, `released`, `created_at`, `updated_at`, `previously_released`)
VALUES
  (1, 1, 'Exam1Term', 1990, 'TestExam#1 5QuestionsWElements User1', 0, 0, NOW(), NOW(), 0),
  (2, 1, 'Exam2Term', 1990, 'TestExam#2 5QuestionsWElements User1', 0, 0, NOW(), NOW(), 0),
  (3, 2, 'Exam3Term', 1990, 'TestExam#3 5QuestionsWElements User2', 0, 0, NOW(), NOW(), 0),
  (4, 1, 'Exam4Term', 1990, 'TestExam#4 5QuestionsWElements User1', 0, 0, NOW(), NOW(), 0),
  (5, 1, 'Exam5Term', 1990, 'TestExam#5 NoQuestions User1', 0, 0, NOW(), NOW(), 0),
  (6, 1, 'Exam6Term', 1990, 'TestExam#6 5QuestionsNoElements User1', 0, 0, NOW(), NOW(), 0);

/*!40000 ALTER TABLE `exams`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id`         INT(10) UNSIGNED                 NOT NULL AUTO_INCREMENT,
  `connection` TEXT COLLATE utf8_unicode_ci     NOT NULL,
  `queue`      TEXT COLLATE utf8_unicode_ci     NOT NULL,
  `payload`    LONGTEXT COLLATE utf8_unicode_ci NOT NULL,
  `failed_at`  TIMESTAMP                        NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

# Dump of table feedback
# ------------------------------------------------------------

DROP TABLE IF EXISTS `feedback`;

CREATE TABLE `feedback` (
  `access_key`    VARCHAR(255)
                  COLLATE utf8_unicode_ci      NOT NULL,
  `content`       TEXT COLLATE utf8_unicode_ci NOT NULL,
  `created_at`    TIMESTAMP                    NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at`    TIMESTAMP                    NOT NULL DEFAULT '0000-00-00 00:00:00',
  `grade_display` TEXT COLLATE utf8_unicode_ci,
  `grade_calc`    TEXT COLLATE utf8_unicode_ci,
  PRIMARY KEY (`access_key`),
  KEY `feedback_access_key_index` (`access_key`),
  CONSTRAINT `feedback_access_key_foreign` FOREIGN KEY (`access_key`) REFERENCES `access_keys` (`access_key`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

INSERT INTO `feedback` (`access_key`, `content`, `created_at`, `updated_at`, `grade_display`, `grade_calc`)
VALUES
  ('634b0f6bb2e56e46da6ab48d284d08b101ec1aa168cd715a9a0e570f5947135b',
   '[{\"questionNumber\":1,\"questionId\":6,\"questionName\":\"Aut recusandae.\",\"questionAssignmentId\":6,\"elements\":{\"1\":{\"questionNumber\":1,\"subtask\":1,\"elementId\":26,\"elementAssignmentId\":26,\"elementName\":\"Sint non numquam.\",\"score\":0.84,\"average\":5.1369,\"comment\":\"Eum ut velit cum rerum ab. Maxime alias dolores autem voluptate eum. Quia esse maxime accusamus alias consequuntur sit. Accusamus dolores repellendus qui molestias.\"},\"2\":{\"questionNumber\":1,\"subtask\":2,\"elementId\":27,\"elementAssignmentId\":27,\"elementName\":\"Sint soluta et non.\",\"score\":0.28,\"average\":4.9965,\"comment\":\"Unde temporibus porro quod accusamus ea. Vel asperiores labore asperiores et culpa et dolores. Ipsum laudantium numquam quis.\"},\"3\":{\"questionNumber\":1,\"subtask\":3,\"elementId\":28,\"elementAssignmentId\":28,\"elementName\":\"Numquam veritatis.\",\"score\":4.67,\"average\":5.0482,\"comment\":\"Unde earum impedit voluptatibus qui dolor enim. Atque autem ut voluptas et facere quisquam quia. Ab quaerat officia ut eos ex voluptate iure.\"},\"4\":{\"questionNumber\":1,\"subtask\":4,\"elementId\":29,\"elementAssignmentId\":29,\"elementName\":\"Eveniet et sed et.\",\"score\":7.09,\"average\":4.6617,\"comment\":\"Animi facere officiis beatae et quidem ipsum. Dolorum eum molestiae at et similique dolores et expedita. A possimus consequatur sed repellat ut. Ipsa voluptatem repudiandae rerum autem.\"},\"5\":{\"questionNumber\":1,\"subtask\":5,\"elementId\":30,\"elementAssignmentId\":30,\"elementName\":\"Nesciunt saepe.\",\"score\":0.02,\"average\":4.8319,\"comment\":\"Aperiam et cupiditate architecto vel. Voluptatibus nostrum quos beatae consequatur sunt possimus. Qui ea repellendus dolorum vitae ab corrupti. Voluptate ullam corporis blanditiis corrupti.\"}},\"score\":64.9,\"average\":45.199},{\"questionNumber\":2,\"questionId\":7,\"questionName\":\"In assumenda qui.\",\"questionAssignmentId\":7,\"elements\":{\"1\":{\"questionNumber\":2,\"subtask\":1,\"elementId\":31,\"elementAssignmentId\":31,\"elementName\":\"Eum natus quidem.\",\"score\":4.58,\"average\":5.4708,\"comment\":\"Quidem qui dolores omnis non incidunt praesentium. Provident et unde voluptatem labore dignissimos reiciendis aut.\"},\"2\":{\"questionNumber\":2,\"subtask\":2,\"elementId\":32,\"elementAssignmentId\":32,\"elementName\":\"Quisquam rem.\",\"score\":0.78,\"average\":4.8605,\"comment\":\"Qui eos sed perspiciatis ut. Iste in accusantium labore dolorem. Incidunt repellat nemo sapiente incidunt sit sequi aut.\"},\"3\":{\"questionNumber\":2,\"subtask\":3,\"elementId\":33,\"elementAssignmentId\":33,\"elementName\":\"Nihil voluptates.\",\"score\":4.48,\"average\":5.383,\"comment\":\"Iusto esse vel sunt atque autem inventore. Ducimus consequatur ratione architecto sint veniam ipsa.\"},\"4\":{\"questionNumber\":2,\"subtask\":4,\"elementId\":34,\"elementAssignmentId\":34,\"elementName\":\"Quam deserunt ut.\",\"score\":3.57,\"average\":4.9138,\"comment\":\"Ipsam vitae accusamus quam sunt nostrum vitae aut. Voluptas adipisci ea totam quibusdam. Dolorem magnam natus consequatur sed quisquam aut molestiae. Et minima et id non qui cupiditate nisi.\"},\"5\":{\"questionNumber\":2,\"subtask\":5,\"elementId\":35,\"elementAssignmentId\":35,\"elementName\":\"Incidunt impedit.\",\"score\":3.8,\"average\":4.9498,\"comment\":\"Dignissimos eveniet fugiat repellendus asperiores. Quia nisi odio aut fuga sint debitis animi dignissimos. Nesciunt aut eveniet voluptas dolores.\\nFacere sunt pariatur ad et. Et nam id tempore in.\"}},\"score\":40.63,\"average\":44.5329},{\"questionNumber\":3,\"questionId\":8,\"questionName\":\"Ratione qui sequi.\",\"questionAssignmentId\":8,\"elements\":{\"1\":{\"questionNumber\":3,\"subtask\":1,\"elementId\":36,\"elementAssignmentId\":36,\"elementName\":\"Alias voluptas eum.\",\"score\":8.57,\"average\":5.7543,\"comment\":\"Tempore nam maiores voluptatem modi quos et quasi et. Aut tempora odit molestiae sed. Dicta illum sed eveniet reprehenderit dolores est qui. Deleniti modi aliquid nisi qui amet.\"},\"2\":{\"questionNumber\":3,\"subtask\":2,\"elementId\":37,\"elementAssignmentId\":37,\"elementName\":\"Laudantium sit non.\",\"score\":8.25,\"average\":4.8508,\"comment\":\"Numquam et unde autem nobis qui. Doloribus suscipit quibusdam explicabo sit quisquam. Necessitatibus illum aliquid voluptas quasi odit.\"},\"3\":{\"questionNumber\":3,\"subtask\":3,\"elementId\":38,\"elementAssignmentId\":38,\"elementName\":\"Aliquid sunt et.\",\"score\":2.5,\"average\":4.868,\"comment\":\"Harum molestiae quasi possimus porro error. Doloremque omnis iure nam eos libero consectetur. Unde eligendi cum aut magnam dolorem laboriosam et optio.\"},\"4\":{\"questionNumber\":3,\"subtask\":4,\"elementId\":39,\"elementAssignmentId\":39,\"elementName\":\"Eligendi quia.\",\"score\":9.76,\"average\":4.9763,\"comment\":\"Veritatis minima et iusto eum architecto quod. Voluptatum aperiam corporis fugiat molestiae. Culpa voluptatem omnis voluptas facilis.\"},\"5\":{\"questionNumber\":3,\"subtask\":5,\"elementId\":40,\"elementAssignmentId\":40,\"elementName\":\"Consequatur aliquid.\",\"score\":1.96,\"average\":4.9244,\"comment\":\"Quod occaecati sequi animi autem ut deleniti sit consequatur. Porro quos aut et assumenda delectus vero. Occaecati temporibus quis vitae ullam aut. Maxime sint cum eligendi at dolor temporibus.\"}},\"score\":99.72,\"average\":47.8591},{\"questionNumber\":4,\"questionId\":9,\"questionName\":\"Rerum est dolorem.\",\"questionAssignmentId\":9,\"elements\":{\"1\":{\"questionNumber\":4,\"subtask\":1,\"elementId\":41,\"elementAssignmentId\":41,\"elementName\":\"Expedita natus qui.\",\"score\":1.96,\"average\":4.7195,\"comment\":\"Sed nihil asperiores omnis. Corporis quis neque qui suscipit facilis beatae consequuntur. Ad ea laborum minima magni et molestias. Nihil voluptatum illum qui eius.\"},\"2\":{\"questionNumber\":4,\"subtask\":2,\"elementId\":42,\"elementAssignmentId\":42,\"elementName\":\"Eveniet molestiae.\",\"score\":6.75,\"average\":5.4833,\"comment\":\"Sit et et explicabo beatae ratione voluptate unde. Ut magnam ut porro quam et nulla aut. Molestiae fuga earum dolore nihil nostrum recusandae quia. Rerum adipisci minima voluptas alias officiis sed.\"},\"3\":{\"questionNumber\":4,\"subtask\":3,\"elementId\":43,\"elementAssignmentId\":43,\"elementName\":\"Eveniet accusamus.\",\"score\":5.46,\"average\":5.0247,\"comment\":\"Ut in beatae ex dignissimos ipsa velit qui neque. Eligendi quis consequatur est velit. Eligendi natus architecto possimus error quam modi vel sunt. Neque cupiditate quia veritatis delectus.\"},\"4\":{\"questionNumber\":4,\"subtask\":4,\"elementId\":44,\"elementAssignmentId\":44,\"elementName\":\"Repellat quo velit.\",\"score\":6.34,\"average\":4.8787,\"comment\":\"Magni eos architecto reprehenderit in aliquam. Sunt omnis voluptas laboriosam aspernatur. Iusto culpa rerum est suscipit consequatur.\"},\"5\":{\"questionNumber\":4,\"subtask\":5,\"elementId\":45,\"elementAssignmentId\":45,\"elementName\":\"Nisi voluptas.\",\"score\":4.52,\"average\":4.9129,\"comment\":\"Fugit quia fugiat nam et. Ipsam natus enim accusamus voluptas aspernatur esse aut. Et quae quia vel voluptatem. Sed enim rem numquam tempore harum et.\"}},\"score\":23.29,\"average\":46.4824},{\"questionNumber\":5,\"questionId\":10,\"questionName\":\"Molestiae facere.\",\"questionAssignmentId\":10,\"elements\":{\"1\":{\"questionNumber\":5,\"subtask\":1,\"elementId\":46,\"elementAssignmentId\":46,\"elementName\":\"Occaecati rem aut.\",\"score\":9.49,\"average\":5.3639,\"comment\":\"Blanditiis aliquid soluta placeat sunt. Porro molestiae totam quae voluptas quisquam. Voluptate modi voluptatem nihil quia cum unde.\"},\"2\":{\"questionNumber\":5,\"subtask\":2,\"elementId\":47,\"elementAssignmentId\":47,\"elementName\":\"Autem mollitia.\",\"score\":0.69,\"average\":4.6609,\"comment\":\"Libero alias accusantium ut hic sunt quaerat rem. At consequuntur exercitationem officia numquam aut harum ea. Accusantium vel iste ut voluptatem. Quam quo unde laudantium quo.\"},\"3\":{\"questionNumber\":5,\"subtask\":3,\"elementId\":48,\"elementAssignmentId\":48,\"elementName\":\"Incidunt impedit.\",\"score\":7.11,\"average\":5.5919,\"comment\":\"Repudiandae cupiditate a beatae illum. Aut magnam aliquid ratione debitis. Aut quo neque debitis aut excepturi exercitationem suscipit. Provident quisquam veritatis placeat illum nostrum sint sit.\"},\"4\":{\"questionNumber\":5,\"subtask\":4,\"elementId\":49,\"elementAssignmentId\":49,\"elementName\":\"Est occaecati.\",\"score\":8.01,\"average\":4.9827,\"comment\":\"Esse soluta et est doloribus minus ipsa. Aut et iste labore cum odit sunt. Fugit reiciendis nemo ut soluta omnis est. Ut odio autem iusto distinctio iure odio ipsam nam.\"},\"5\":{\"questionNumber\":5,\"subtask\":5,\"elementId\":50,\"elementAssignmentId\":50,\"elementName\":\"Voluptas est est.\",\"score\":5.89,\"average\":5.2466,\"comment\":\"Pariatur ut praesentium et. Ea explicabo dicta iusto facere et in odit. Dolorem asperiores est enim autem facilis quasi. Dolores at nam voluptatem impedit. Doloribus eligendi facilis sit odio saepe.\"}},\"score\":8.26,\"average\":47.965}]',
   NOW(), NOW(), 'A+', '98');

# Dump of table grade_assignments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `grade_assignments`;

CREATE TABLE `grade_assignments` (
  `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    INT(10) UNSIGNED NOT NULL,
  `exam_id`    INT(10) UNSIGNED NOT NULL,
  `grade_id`   INT(10) UNSIGNED NOT NULL,
  `min_score`  DOUBLE(8, 2)     NOT NULL,
  `created_at` TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `grade_assignments_exam_id_grade_id_unique` (`exam_id`, `grade_id`),
  KEY `grade_assignments_user_id_foreign` (`user_id`),
  CONSTRAINT `grade_assignments_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `grade_assignments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `grade_assignments` WRITE;
/*!40000 ALTER TABLE `grade_assignments`
  DISABLE KEYS */;

INSERT INTO `grade_assignments` (`id`, `user_id`, `exam_id`, `grade_id`, `min_score`, `created_at`, `updated_at`)
VALUES
  (1, 1, 1, 100, 48.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (2, 1, 1, 101, 46.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (3, 1, 1, 102, 45.00, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (4, 1, 1, 103, 43.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (5, 1, 1, 104, 41.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (6, 1, 1, 105, 40.00, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (7, 1, 1, 106, 38.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (8, 1, 1, 107, 36.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (9, 1, 1, 108, 35.00, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (10, 1, 1, 109, 33.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (11, 1, 1, 110, 31.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (12, 1, 1, 111, 30.00, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (13, 1, 1, 112, 25.00, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (27, 1, 3, 100, 48.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (28, 1, 3, 101, 46.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (29, 1, 3, 102, 45.00, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (30, 1, 3, 103, 43.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (31, 1, 3, 104, 41.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (32, 1, 3, 105, 40.00, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (33, 1, 3, 106, 38.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (34, 1, 3, 107, 36.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (35, 1, 3, 108, 35.00, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (36, 1, 3, 109, 33.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (37, 1, 3, 110, 31.50, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (38, 1, 3, 111, 30.00, '2016-02-16 17:57:14', '2016-02-16 17:57:14'),
  (39, 1, 3, 112, 25.00, '2016-02-16 17:57:14', '2016-02-16 17:57:14');

/*!40000 ALTER TABLE `grade_assignments`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table grades
# ------------------------------------------------------------

DROP TABLE IF EXISTS `grades`;

CREATE TABLE `grades` (
  `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

# Dump of table grading_times
# ------------------------------------------------------------

DROP TABLE IF EXISTS `grading_times`;

CREATE TABLE `grading_times` (
  `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_id`    INT(10) UNSIGNED NOT NULL,
  `student_id` INT(10) UNSIGNED NOT NULL,
  `seconds`    DOUBLE(8, 2)              DEFAULT NULL,
  `created_at` TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `grading_times_exam_id_student_id_unique` (`exam_id`, `student_id`),
  KEY `grading_times_student_id_foreign` (`student_id`),
  CONSTRAINT `grading_times_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `grading_times_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `grading_times` WRITE;
/*!40000 ALTER TABLE `grading_times`
  DISABLE KEYS */;

INSERT INTO `grading_times` (`id`, `exam_id`, `student_id`, `seconds`, `created_at`, `updated_at`)
VALUES
  (1, 1, 1, 431.47, NOW(), NOW()),
  (2, 1, 2, 3.68, NOW(), NOW()),
  (3, 1, 3, 247.25, NOW(), NOW()),
  (4, 1, 4, 111.67, NOW(), NOW()),
  (5, 1, 5, 485.07, NOW(), NOW()),
  (6, 3, 6, 279.68, NOW(), NOW()),
  (7, 3, 7, 216.44, NOW(), NOW()),
  (8, 3, 8, 336.97, NOW(), NOW()),
  (9, 3, 9, 164.10, NOW(), NOW()),
  (10, 3, 10, 449.66, NOW(), NOW());


/*!40000 ALTER TABLE `grading_times`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id`           BIGINT(20) UNSIGNED              NOT NULL AUTO_INCREMENT,
  `queue`        VARCHAR(255)
                 COLLATE utf8_unicode_ci          NOT NULL,
  `payload`      LONGTEXT COLLATE utf8_unicode_ci NOT NULL,
  `attempts`     TINYINT(3) UNSIGNED              NOT NULL,
  `reserved`     TINYINT(3) UNSIGNED              NOT NULL,
  `reserved_at`  INT(10) UNSIGNED                          DEFAULT NULL,
  `available_at` INT(10) UNSIGNED                 NOT NULL,
  `created_at`   INT(10) UNSIGNED                 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_reserved_at_index` (`queue`, `reserved`, `reserved_at`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

# Dump of table kumi_student
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kumi_student`;

CREATE TABLE `kumi_student` (
  `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kumi_id`    INT(10) UNSIGNED NOT NULL,
  `student_id` INT(10) UNSIGNED NOT NULL,
  `created_at` TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `kumi_student_kumi_id_foreign` (`kumi_id`),
  KEY `kumi_student_student_id_foreign` (`student_id`),
  CONSTRAINT `kumi_student_kumi_id_foreign` FOREIGN KEY (`kumi_id`) REFERENCES `kumis` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `kumi_student_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `kumi_student` WRITE;
/*!40000 ALTER TABLE `kumi_student`
  DISABLE KEYS */;

INSERT INTO `kumi_student` (`id`, `kumi_id`, `student_id`, `created_at`, `updated_at`)
VALUES
  (1, 1, 1, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (2, 1, 2, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (3, 1, 3, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (4, 1, 4, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (5, 1, 5, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (6, 1, 6, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (7, 1, 7, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (8, 1, 8, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (9, 1, 9, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (10, 1, 10, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (11, 1, 11, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (12, 2, 1, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (13, 2, 2, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (14, 2, 3, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (15, 2, 4, '2016-02-16 17:57:08', '2016-02-16 17:57:08'),
  (16, 2, 5, '2016-02-16 17:57:08', '2016-02-16 17:57:08');

/*!40000 ALTER TABLE `kumi_student`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table kumis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kumis`;

CREATE TABLE `kumis` (
  `id`         INT(10) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `user_id`    INT(10) UNSIGNED        NOT NULL,
  `year`       INT(11)                 NOT NULL,
  `nickname`   VARCHAR(255)
               COLLATE utf8_unicode_ci NOT NULL,
  `created_at` TIMESTAMP               NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP               NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kumis_user_id_year_nickname_unique` (`user_id`, `year`, `nickname`),
  CONSTRAINT `kumis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `kumis` WRITE;
/*!40000 ALTER TABLE `kumis`
  DISABLE KEYS */;

INSERT INTO `kumis` (`id`, `user_id`, `year`, `nickname`, `created_at`, `updated_at`)
VALUES
  (1, 1, 1994, 'Officia.', '2016-02-16 17:49:03', '2016-02-16 17:49:03'),
  (2, 1, 1984, 'Autem.', '2016-02-16 17:49:03', '2016-02-16 17:49:03'),
  (3, 1, 2005, 'Dolor.', '2016-02-16 17:49:03', '2016-02-16 17:49:03'),
  (4, 1, 2000, 'Est.', '2016-03-14 15:18:25', '2016-03-14 15:18:25');

/*!40000 ALTER TABLE `kumis`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` VARCHAR(255)
              COLLATE utf8_unicode_ci NOT NULL,
  `batch`     INT(11)                 NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations`
  DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
  ('2014_10_12_000000_create_users_table', 1),
  ('2014_10_12_100000_create_password_resets_table', 1),
  ('2015_07_17_172134_create_exams_table', 1),
  ('2015_07_17_172445_create_questions_table', 1),
  ('2015_07_17_172458_create_elements_table', 1),
  ('2015_07_17_173232_create_students_table', 1),
  ('2015_07_17_173233_create_question_assignment_table', 1),
  ('2015_07_17_173234_create_element__assignment_table', 1),
  ('2015_07_17_173620_create_element_scores_table', 1),
  ('2015_07_17_173638_create_question_scores_table', 1),
  ('2015_07_18_120935_create_kumis_table', 1),
  ('2015_07_18_121931_create_kumi_student_table', 1),
  ('2015_07_18_121949_create_exam_kumi_table', 1),
  ('2015_07_22_152434_create_comments_table', 1),
  ('2015_07_31_172413_create_jobs_table', 1),
  ('2015_08_02_134402_access_keys', 1),
  ('2015_08_02_155906_feedback', 1),
  ('2015_08_04_120147_stored_procedures', 1),
  ('2015_08_12_134810_create_grading_time_table', 1),
  ('2015_09_12_134746_create_failed_jobs_table', 1),
  ('2015_09_17_161132_waitlist', 1),
  ('2015_09_22_121713_add_maxscore_to_questions_table', 1),
  ('2015_09_22_144730_grades_table', 1),
  ('2015_09_22_144806_make_grade_assignments_table', 1),
  ('2015_10_13_190309_add_grade_fields_to_feedback', 1);

/*!40000 ALTER TABLE `migrations`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `emails`     VARCHAR(255)
               COLLATE utf8_unicode_ci NOT NULL,
  `token`      VARCHAR(255)
               COLLATE utf8_unicode_ci NOT NULL,
  `created_at` TIMESTAMP               NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_emails_index` (`emails`),
  KEY `password_resets_token_index` (`token`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

# Dump of table question_assignments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `question_assignments`;

CREATE TABLE `question_assignments` (
  `id`              INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_id`         INT(10) UNSIGNED NOT NULL,
  `question_id`     INT(10) UNSIGNED NOT NULL,
  `question_number` INT(10) UNSIGNED NOT NULL,
  `created_at`      TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at`      TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `question_assignments_exam_id_question_number_unique` (`exam_id`, `question_number`),
  UNIQUE KEY `question_assignments_exam_id_question_id_unique` (`exam_id`, `question_id`),
  KEY `question_assignments_question_id_foreign` (`question_id`),
  CONSTRAINT `question_assignments_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `question_assignments_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `question_assignments` WRITE;
/*!40000 ALTER TABLE `question_assignments`
  DISABLE KEYS */;

INSERT INTO `question_assignments` (`id`, `exam_id`, `question_id`, `question_number`, `created_at`, `updated_at`)
VALUES
  (1, 1, 1, 1, NOW(), NOW()),
  (2, 1, 2, 2, NOW(), NOW()),
  (3, 1, 3, 3, NOW(), NOW()),
  (4, 1, 4, 4, NOW(), NOW()),
  (5, 1, 5, 5, NOW(), NOW()),
  (6, 2, 6, 1, NOW(), NOW()),
  (7, 2, 7, 2, NOW(), NOW()),
  (8, 2, 8, 3, NOW(), NOW()),
  (9, 2, 9, 4, NOW(), NOW()),
  (10, 2, 10, 5, NOW(), NOW()),
  (11, 3, 11, 1, NOW(), NOW()),
  (12, 3, 12, 2, NOW(), NOW()),
  (13, 3, 13, 3, NOW(), NOW()),
  (14, 3, 14, 4, NOW(), NOW()),
  (15, 3, 15, 5, NOW(), NOW()),
  (16, 4, 16, 1, NOW(), NOW()),
  (17, 4, 17, 2, NOW(), NOW()),
  (18, 4, 18, 3, NOW(), NOW()),
  (19, 4, 19, 4, NOW(), NOW()),
  (20, 4, 20, 5, NOW(), NOW()),
  (21, 6, 1, 1, NOW(), NOW()),
  (22, 6, 2, 2, NOW(), NOW()),
  (23, 6, 3, 3, NOW(), NOW()),
  (24, 6, 4, 4, NOW(), NOW()),
  (25, 6, 5, 5, NOW(), NOW());

/*!40000 ALTER TABLE `question_assignments`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table question_scores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `question_scores`;

CREATE TABLE `question_scores` (
  `id`                     INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `question_assignment_id` INT(10) UNSIGNED NOT NULL,
  `student_id`             INT(10) UNSIGNED NOT NULL,
  `score`                  DOUBLE(8, 2)              DEFAULT NULL,
  `is_custom`              TINYINT(1)       NOT NULL DEFAULT '0',
  `created_at`             TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at`             TIMESTAMP        NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `question_scores_question_assignment_id_student_id_unique` (`question_assignment_id`, `student_id`),
  KEY `question_scores_question_assignment_id_index` (`question_assignment_id`),
  KEY `question_scores_student_id_index` (`student_id`),
  CONSTRAINT `question_scores_question_assignment_id_foreign` FOREIGN KEY (`question_assignment_id`) REFERENCES `question_assignments` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `question_scores_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `question_scores` WRITE;
/*!40000 ALTER TABLE `question_scores`
  DISABLE KEYS */;

INSERT INTO `question_scores` (`id`, `question_assignment_id`, `student_id`, `score`, `is_custom`, `created_at`, `updated_at`)
VALUES
  (1, 1, 1, 98.15, 0, NOW(), NOW()),
  (2, 1, 2, 43.26, 0, NOW(), NOW()),
  (3, 1, 3, 34.94, 0, NOW(), NOW()),
  (4, 1, 4, 16.47, 0, NOW(), NOW()),
  (5, 1, 5, 6.06, 0, NOW(), NOW()),
  (6, 2, 1, 18.42, 0, NOW(), NOW()),
  (7, 2, 2, 11.94, 0, NOW(), NOW()),
  (8, 2, 3, 46.13, 0, NOW(), NOW()),
  (9, 2, 4, 11.08, 0, NOW(), NOW()),
  (10, 2, 5, 84.29, 0, NOW(), NOW()),
  (11, 3, 1, 71.8, 0, NOW(), NOW()),
  (12, 3, 2, 28.37, 0, NOW(), NOW()),
  (13, 3, 3, 6.57, 0, NOW(), NOW()),
  (14, 3, 4, 56.73, 0, NOW(), NOW()),
  (15, 3, 5, 89.34, 0, NOW(), NOW()),
  (16, 4, 1, 71.29, 0, NOW(), NOW()),
  (17, 4, 2, 57.95, 0, NOW(), NOW()),
  (18, 4, 3, 62.64, 0, NOW(), NOW()),
  (19, 4, 4, 17.97, 0, NOW(), NOW()),
  (20, 4, 5, 63.54, 0, NOW(), NOW()),
  (21, 5, 1, 36.58, 0, NOW(), NOW()),
  (22, 5, 2, 10.01, 0, NOW(), NOW()),
  (23, 5, 3, 76.48, 0, NOW(), NOW()),
  (24, 5, 4, 94.83, 0, NOW(), NOW()),
  (25, 5, 5, 6.29, 0, NOW(), NOW());

/*!40000 ALTER TABLE `question_scores`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id`           INT(10) UNSIGNED             NOT NULL AUTO_INCREMENT,
  `user_id`      INT(10) UNSIGNED             NOT NULL,
  `questionName` VARCHAR(255)
                 COLLATE utf8_unicode_ci      NOT NULL,
  `questionText` TEXT COLLATE utf8_unicode_ci NOT NULL,
  `max_score`    DOUBLE(8, 2)                          DEFAULT NULL,
  `created_at`   TIMESTAMP                    NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at`   TIMESTAMP                    NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `questions_user_id_foreign` (`user_id`),
  CONSTRAINT `questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions`
  DISABLE KEYS */;

INSERT INTO `questions` (`id`, `user_id`, `questionName`, `questionText`, `max_score`, `created_at`, `updated_at`)
VALUES
  (1, 1, 'Exam1Question1', 'Exam1Question1 Text.', 100.00, NOW(), NOW()),
  (2, 1, 'Exam1Question2', 'Exam1Question2 Text.', 100.00, NOW(), NOW()),
  (3, 1, 'Exam1Question3', 'Exam1Question3 Text.', 100.00, NOW(), NOW()),
  (4, 1, 'Exam1Question4', 'Exam1Question4 Text.', 100.00, NOW(), NOW()),
  (5, 1, 'Exam1Question5', 'Exam1Question5 Text.', 100.00, NOW(), NOW()),
  (6, 1, 'Exam2Question1', 'Exam2Question1 Text.', 100.00, NOW(), NOW()),
  (7, 1, 'Exam2Question2', 'Exam2Question2 Text.', 100.00, NOW(), NOW()),
  (8, 1, 'Exam2Question3', 'Exam2Question3 Text.', 100.00, NOW(), NOW()),
  (9, 1, 'Exam2Question4', 'Exam2Question4 Text.', 100.00, NOW(), NOW()),
  (10, 1, 'Exam2Question5', 'Exam2Question5 Text.', 100.00, NOW(), NOW()),
  (11, 2, 'Exam3Question1', 'Exam3Question1 Text.', 100.00, NOW(), NOW()),
  (12, 2, 'Exam3Question2', 'Exam3Question2 Text.', 100.00, NOW(), NOW()),
  (13, 2, 'Exam3Question3', 'Exam3Question3 Text.', 100.00, NOW(), NOW()),
  (14, 2, 'Exam3Question4', 'Exam3Question4 Text.', 100.00, NOW(), NOW()),
  (15, 2, 'Exam3Question5', 'Exam3Question5 Text.', 100.00, NOW(), NOW()),
  (16, 1, 'Exam4Question1', 'Exam4Question1 Text.', 100.00, NOW(), NOW()),
  (17, 1, 'Exam4Question2', 'Exam4Question2 Text.', 100.00, NOW(), NOW()),
  (18, 1, 'Exam4Question3', 'Exam4Question3 Text.', 100.00, NOW(), NOW()),
  (19, 1, 'Exam4Question4', 'Exam4Question4 Text.', 100.00, NOW(), NOW()),
  (20, 1, 'Exam4Question5', 'Exam4Question5 Text.', 100.00, NOW(), NOW()),
  (21, 1, '', '', NULL, NOW(), NOW()),
  (22, 2, '', '', NULL, NOW(), NOW());

/*!40000 ALTER TABLE `questions`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table students
# ------------------------------------------------------------

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
  `id`                 INT(10) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `user_id`            INT(10) UNSIGNED        NOT NULL,
  `last_name`          VARCHAR(255)
                       COLLATE utf8_unicode_ci NOT NULL,
  `first_name`         VARCHAR(255)
                       COLLATE utf8_unicode_ci NOT NULL,
  `student_identifier` VARCHAR(255)
                       COLLATE utf8_unicode_ci          DEFAULT NULL,
  `email`              VARCHAR(255)
                       COLLATE utf8_unicode_ci          DEFAULT NULL,
  `created_at`         TIMESTAMP               NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at`         TIMESTAMP               NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `students_user_id_foreign` (`user_id`),
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students`
  DISABLE KEYS */;

INSERT INTO `students` (`id`, `user_id`, `last_name`, `first_name`, `student_identifier`, `email`, `created_at`, `updated_at`)
VALUES
  (1, 1, 'lastNameOfExisting1', 'firstNameOfExisting1', NULL, NULL, NOW(), NOW()),
  (2, 1, 'lastNameOfExisting2', 'firstNameOfExisting2', NULL, 'student2@email.com', NOW(), NOW()),
  (3, 1, 'lastNameOfExisting3', 'firstNameOfExisting3', '333333333', NULL, NOW(), NOW()),
  (4, 1, 'lastNameOfExisting4', 'firstNameOfExisting4', '444444444', 'student4@email.com', NOW(), NOW()),
  (5, 1, 'lastNameOfExisting5', 'firstNameOfExisting5', '555555555', 'student5@email.com', NOW(), NOW()),
  (6, 2, 'lastNameOfExisting6', 'firstNameOfExisting6', NULL, NULL, NOW(), NOW()),
  (7, 2, 'lastNameOfExisting7', 'firstNameOfExisting7', NULL, 'student7@email.com', NOW(), NOW()),
  (8, 2, 'lastNameOfExisting8', 'firstNameOfExisting8', '888888888', NULL, NOW(), NOW()),
  (9, 2, 'lastNameOfExisting9', 'firstNameOfExisting9', '999999999', 'student9@email.com', NOW(), NOW()),
  (10, 2, 'lastNameOfExisting10', 'firstNameOfExisting10', '000000000', 'student10@email.com', NOW(), NOW());

/*!40000 ALTER TABLE `students`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id`             INT(10) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `name`           VARCHAR(255)
                   COLLATE utf8_unicode_ci NOT NULL,
  `email`          VARCHAR(255)
                   COLLATE utf8_unicode_ci NOT NULL,
  `password`       VARCHAR(60)
                   COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` VARCHAR(100)
                   COLLATE utf8_unicode_ci          DEFAULT NULL,
  `created_at`     TIMESTAMP               NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at`     TIMESTAMP               NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users`
  DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES
  (1, 'scratchUser1', 'test2@gradeomatic.net', '$2y$10$3NpS4QoG1V0wlaXjo539detfBaYZ5A4YNfnZlrf58XTm5p5Ubj2he',
   '4JKPEctqZkio8YfwKj0OI081s0bNjaF8gTu4lpQbKG3SfmMqvOyOxljfwQ4D', '2016-02-16 17:48:55', '2016-04-06 12:36:18'),
  (2, 'scratchUser2', 'test@gradeomatic.net', '$2y$10$7mHcjF/8gjRw5fHFEWViZuU62bq4D.xVIEzXUMRLtsIdg5EouvaEm',
   'TosGVWzGGg1Fg51gqAs83eH1yw6SBH2oRvGJWyTHE6q2ZViJOpQFj8IHzjFE', '2016-02-16 17:48:54', '2016-02-22 13:29:27'),
  (3, 'scratchUser3', 'test3@gradeomatic.net', '$2y$10$/ZW8GPWYFi69p97uF3Xf6OjwjSjuwLSPv/lmmTRqr857yEOaQ3qui', NULL,
   '2016-02-16 17:48:55', '2016-02-16 17:48:55');

/*!40000 ALTER TABLE `users`
  ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table waitlist
# ------------------------------------------------------------

DROP TABLE IF EXISTS `waitlist`;

CREATE TABLE `waitlist` (
  `id`              INT(10) UNSIGNED             NOT NULL AUTO_INCREMENT,
  `email`           TEXT COLLATE utf8_unicode_ci NOT NULL,
  `requesterName`   TEXT COLLATE utf8_unicode_ci,
  `institutionType` TEXT COLLATE utf8_unicode_ci,
  `created_at`      TIMESTAMP                    NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at`      TIMESTAMP                    NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;


/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
