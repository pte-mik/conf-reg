ALTER TABLE `user`
  DROP COLUMN `guid`;
ALTER TABLE `user`
  CHANGE COLUMN `group` `group` enum('admin','moderator','visitor') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL AFTER `id`,
  CHANGE COLUMN `created` `created` datetime DEFAULT NULL AFTER `group`,
  CHANGE COLUMN `updated` `updated` timestamp NOT NULL AFTER `created`,
  CHANGE COLUMN `name` `name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `updated`,
  CHANGE COLUMN `email` `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `name`,
  CHANGE COLUMN `password` `password` char(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `email`,
  ADD COLUMN `phone` varchar(255) DEFAULT NULL AFTER `password`,
  ADD UNIQUE KEY `email` (`email`);