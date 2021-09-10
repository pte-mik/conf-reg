ALTER TABLE `user`
  DROP INDEX `email`,
  DROP COLUMN `phone`;
ALTER TABLE `user`
  ADD COLUMN `guid` char(36) DEFAULT '' AFTER `id`,
  CHANGE COLUMN `created` `created` datetime DEFAULT NULL AFTER `guid`,
  CHANGE COLUMN `updated` `updated` timestamp NULL DEFAULT NULL AFTER `created`,
  CHANGE COLUMN `password` `password` char(128) DEFAULT NULL AFTER `updated`,
  CHANGE COLUMN `name` `name` varchar(16) DEFAULT '' AFTER `password`,
  CHANGE COLUMN `email` `email` varchar(255) DEFAULT NULL AFTER `name`,
  CHANGE COLUMN `group` `group` enum('admin','moderator','visitor') DEFAULT NULL AFTER `email`;