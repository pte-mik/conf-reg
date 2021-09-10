CREATE TABLE `submission` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `attachments` json DEFAULT NULL,
  `eventId` int unsigned DEFAULT NULL,
  `userId` int unsigned DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `imageCaption` varchar(255) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `keywords` json DEFAULT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `status` enum('draft','underReview','declined','accepted') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `authors` json DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `log` json NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;