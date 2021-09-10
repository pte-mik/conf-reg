ALTER TABLE `event`
  CHANGE COLUMN `participationRequired` `participationRequired` tinyint(1) DEFAULT NULL AFTER `website`;