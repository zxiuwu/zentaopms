CREATE TABLE `zt_account` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `adminURI` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `extra` text NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `status` varchar(30) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `provider` (`provider`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_acl` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `objectType` char(30) NOT NULL,
  `objectID` mediumint(9) NOT NULL DEFAULT '0',
  `type` char(40) NOT NULL DEFAULT 'whitelist',
  `source` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_action` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `objectType` varchar(30) NOT NULL DEFAULT '',
  `objectID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `product` text NOT NULL,
  `project` mediumint(8) unsigned NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `actor` varchar(100) NOT NULL DEFAULT '',
  `action` varchar(80) NOT NULL DEFAULT '',
  `date` datetime NOT NULL,
  `comment` text NOT NULL,
  `extra` text,
  `read` enum('0','1') NOT NULL DEFAULT '0',
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `efforted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `actor` (`actor`),
  KEY `project` (`project`),
  KEY `action` (`action`),
  KEY `objectID` (`objectID`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_activity` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `process` mediumint(9) NOT NULL,
  `name` varchar(255) NOT NULL,
  `optional` varchar(255) NOT NULL,
  `tailorNorm` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `assignedBy` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `order` mediumint(8) DEFAULT '0',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_api` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product` varchar(255) NOT NULL DEFAULT '',
  `lib` int(10) unsigned NOT NULL DEFAULT '0',
  `module` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `path` varchar(255) NOT NULL DEFAULT '',
  `protocol` varchar(10) NOT NULL DEFAULT '',
  `method` varchar(10) NOT NULL DEFAULT '',
  `requestType` varchar(100) NOT NULL DEFAULT '',
  `responseType` varchar(100) NOT NULL DEFAULT '',
  `status` varchar(20) NOT NULL DEFAULT '',
  `owner` varchar(30) NOT NULL DEFAULT '0',
  `desc` mediumtext NULL,
  `version` smallint(5) unsigned NOT NULL DEFAULT '0',
  `params` text,
  `paramsExample` text,
  `responseExample` text,
  `response` text,
  `commonParams` text,
  `addedBy` varchar(30) NOT NULL DEFAULT '0',
  `addedDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL DEFAULT '0',
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_api_lib_release` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lib` int(10) unsigned NOT NULL DEFAULT '0',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `version` varchar(255) NOT NULL DEFAULT '',
  `snap` mediumtext NOT NULL,
  `addedBy` varchar(30) NOT NULL DEFAULT '0',
  `addedDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_apispec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `doc` int(10) unsigned NOT NULL DEFAULT '0',
  `module` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `path` varchar(255) NOT NULL DEFAULT '',
  `protocol` varchar(10) NOT NULL DEFAULT '',
  `method` varchar(10) NOT NULL DEFAULT '',
  `requestType` varchar(100) NOT NULL DEFAULT '',
  `responseType` varchar(100) NOT NULL DEFAULT '',
  `status` varchar(20) NOT NULL DEFAULT '',
  `owner` varchar(255) NOT NULL DEFAULT '0',
  `desc` mediumtext NULL,
  `version` smallint(5) unsigned NOT NULL DEFAULT '0',
  `params` text,
  `paramsExample` text,
  `responseExample` text,
  `response` text,
  `addedBy` varchar(30) NOT NULL DEFAULT '0',
  `addedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_apistruct` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lib` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  `type` varchar(50) NOT NULL DEFAULT '',
  `desc` mediumtext NOT NULL DEFAULT '',
  `version` smallint(5) unsigned NOT NULL DEFAULT '0',
  `attribute` text,
  `addedBy` varchar(30) NOT NULL DEFAULT '0',
  `addedDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL DEFAULT '0',
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_apistruct_spec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(50) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `attribute` text,
  `version` smallint(5) unsigned NOT NULL DEFAULT '0',
  `addedBy` varchar(30) NOT NULL DEFAULT '0',
  `addedDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_approval` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `flow` mediumint(8) NOT NULL,
  `objectType` varchar(30) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `nodes` mediumtext NOT NULL,
  `version` mediumint(9) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'doing',
  `result` varchar(20) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_approvalflow` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(100) NOT NULL,
  `desc` mediumtext NOT NULL,
  `version` mediumint(8) NOT NULL DEFAULT '1',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `type` varchar(30) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_approvalflowobject` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `root` int(8) NOT NULL,
  `flow` int(8) NOT NULL,
  `objectType` char(30) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `extra` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_approvalflowspec` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `flow` mediumint(8) NOT NULL,
  `version` mediumint(8) NOT NULL,
  `nodes` mediumtext NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_approvalnode` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `approval` mediumint(8) NOT NULL,
  `type` enum('review','cc') NOT NULL,
  `title` varchar(255) NOT NULL,
  `account` char(30) NOT NULL,
  `node` varchar(100) NOT NULL,
  `reviewType` varchar(100)  NOT NULL DEFAULT 'manual',
  `multipleType` enum('and','or') NOT NULL DEFAULT 'and',
  `prev` mediumtext NOT NULL,
  `next` mediumtext NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'wait',
  `result` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `opinion` mediumtext NOT NULL,
  `extra` mediumtext NOT NULL,
  `reviewedBy` char(30) NOT NULL,
  `reviewedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_reviewed_date` (`reviewedDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_approvalobject` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `approval` int(8) NOT NULL,
  `objectType` char(30) NOT NULL,
  `objectID` mediumint(8) NOT NULL,
  `extra` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_approvalrole` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `code` char(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `users` longtext NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_asset` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `group` varchar(128) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_assetlib` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `desc` mediumtext NOT NULL,
  `order` SMALLINT  UNSIGNED  NOT NULL  DEFAULT '0',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_attend` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `date` date NOT NULL,
  `signIn` time NOT NULL,
  `signOut` time NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL,
  `device` varchar(30) NOT NULL,
  `client` varchar(20) NOT NULL,
  `manualIn` time NOT NULL,
  `manualOut` time NOT NULL,
  `reason` varchar(30) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `reviewStatus` varchar(30) NOT NULL DEFAULT '',
  `reviewedBy` char(30) NOT NULL,
  `reviewedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attend` (`date`,`account`),
  KEY `account` (`account`),
  KEY `date` (`date`),
  KEY `status` (`status`),
  KEY `reason` (`reason`),
  KEY `reviewStatus` (`reviewStatus`),
  KEY `reviewedBy` (`reviewedBy`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_attendstat` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `month` char(10) NOT NULL DEFAULT '',
  `normal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `late` decimal(12,2) NOT NULL DEFAULT '0.00',
  `early` decimal(12,2) NOT NULL DEFAULT '0.00',
  `absent` decimal(12,2) NOT NULL DEFAULT '0.00',
  `trip` decimal(12,2) NOT NULL DEFAULT '0.00',
  `egress` decimal(12,2) NOT NULL DEFAULT '0.00',
  `lieu` decimal(12,2) NOT NULL DEFAULT '0.00',
  `paidLeave` decimal(12,2) NOT NULL DEFAULT '0.00',
  `unpaidLeave` decimal(12,2) NOT NULL DEFAULT '0.00',
  `timeOvertime` decimal(12,2) NOT NULL DEFAULT '0.00',
  `restOvertime` decimal(12,2) NOT NULL DEFAULT '0.00',
  `holidayOvertime` decimal(12,2) NOT NULL DEFAULT '0.00',
  `deserve` decimal(12,2) NOT NULL DEFAULT '0.00',
  `actual` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` char(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `attend` (`month`,`account`),
  KEY `account` (`account`),
  KEY `month` (`month`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_auditcl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `model` char(30) NOT NULL DEFAULT 'waterfall',
  `practiceArea` char(30) NOT NULL,
  `type` char(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `objectType` char(30) NOT NULL,
  `objectID` int(10) DEFAULT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `assignedBy` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_auditplan` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `dateType` char(30) DEFAULT NULL,
  `config` text,
  `objectID` mediumint(9) NOT NULL,
  `objectType` char(30) NOT NULL,
  `process` mediumint(9) NOT NULL,
  `processType` char(30) NOT NULL,
  `checkDate` date NOT NULL,
  `checkedBy` varchar(30) NOT NULL,
  `realCheckDate` date NOT NULL,
  `result` char(30) NOT NULL,
  `project` mediumint(8) unsigned NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `assignedBy` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `checkBy` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_auditresult` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `auditplan` mediumint(8) NOT NULL,
  `listID` mediumint(8) NOT NULL,
  `result` char(30) NOT NULL,
  `checkedBy` varchar(30) NOT NULL,
  `checkedDate` date NOT NULL,
  `comment` text NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `assignedBy` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_baseimage` (
  `id` smallint(7) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(255) NOT NULL DEFAULT '',
  `osType` varchar(50) NOT NULL DEFAULT '',
  `os` varchar(50) NOT NULL DEFAULT '',
  `osCategory` varchar(50) NOT NULL DEFAULT '',
  `osArch` varchar(50) NOT NULL DEFAULT '',
  `osLang` varchar(50) NOT NULL DEFAULT '',
  `suggestCore` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `suggestMemory` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `suggestVolume` mediumint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_baseimagebrowser` (
  `vmBackingID` int(10) NOT NULL,
  `browserID` int(10) NOT NULL,
  PRIMARY KEY (`vmBackingID`,`browserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_basicmeas` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `purpose` varchar(50) NOT NULL,
  `scope` char(30) NOT NULL,
  `object` char(30) NOT NULL,
  `name` varchar(90) NOT NULL,
  `code` char(30) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `configure` text,
  `params` text,
  `definition` text,
  `source` varchar(255) DEFAULT NULL,
  `collectType` varchar(30) NOT NULL,
  `collectConf` text NOT NULL,
  `execTime` varchar(30) NOT NULL,
  `collectedBy` varchar(10) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `order` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_block` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `module` varchar(20) NOT NULL,
  `type` char(30) NOT NULL,
  `title` varchar(100) NOT NULL,
  `source` varchar(20) NOT NULL,
  `block` varchar(30) NOT NULL,
  `params` text NOT NULL,
  `order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `grid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_vision_module_type_order` (`account`,`vision`,`module`,`type`,`order`),
  KEY `account` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_branch` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `product` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `default` enum('0','1') NOT NULL DEFAULT '0',
  `status` enum('active','closed') NOT NULL DEFAULT 'active',
  `desc` varchar(255) NOT NULL,
  `createdDate` date NOT NULL,
  `closedDate` date NOT NULL,
  `order` smallint(5) unsigned NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product` (`product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_browser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL DEFAULT '',
  `version` varchar(255) NOT NULL DEFAULT '',
  `lang` varchar(255) NOT NULL DEFAULT '',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_budget` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `stage` char(30) NOT NULL,
  `subject` mediumint(8) NOT NULL,
  `amount` char(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` mediumtext NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `lastEditedBy` char(30) NOT NULL,
  `lastEditedDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_bug` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `injection` mediumint(8) unsigned NOT NULL,
  `identify` mediumint(8) unsigned NOT NULL,
  `branch` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `module` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `execution` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `plan` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `story` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `storyVersion` smallint(6) NOT NULL DEFAULT '1',
  `task` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `toTask` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `toStory` mediumint(8) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `severity` tinyint(4) NOT NULL DEFAULT '0',
  `pri` tinyint(3) unsigned NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT '',
  `os` varchar(255) NOT NULL DEFAULT '',
  `browser` varchar(255) NOT NULL DEFAULT '',
  `hardware` varchar(30) NOT NULL,
  `found` varchar(30) NOT NULL DEFAULT '',
  `steps` mediumtext NOT NULL,
  `status` enum('active','resolved','closed') NOT NULL DEFAULT 'active',
  `subStatus` varchar(30) NOT NULL DEFAULT '',
  `color` char(7) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `activatedCount` smallint(6) NOT NULL,
  `activatedDate` datetime NOT NULL,
  `feedbackBy` varchar(100) NOT NULL,
  `notifyEmail` varchar(100) NOT NULL,
  `mailto` text,
  `openedBy` varchar(30) NOT NULL DEFAULT '',
  `openedDate` datetime NOT NULL,
  `openedBuild` varchar(255) NOT NULL,
  `assignedTo` varchar(30) NOT NULL DEFAULT '',
  `assignedDate` datetime NOT NULL,
  `deadline` date NOT NULL,
  `resolvedBy` varchar(30) NOT NULL DEFAULT '',
  `resolution` varchar(30) NOT NULL DEFAULT '',
  `resolvedBuild` varchar(30) NOT NULL DEFAULT '',
  `resolvedDate` datetime NOT NULL,
  `closedBy` varchar(30) NOT NULL DEFAULT '',
  `closedDate` datetime NOT NULL,
  `duplicateBug` mediumint(8) unsigned NOT NULL,
  `linkBug` varchar(255) NOT NULL,
  `case` mediumint(8) unsigned NOT NULL,
  `caseVersion` smallint(6) NOT NULL DEFAULT '1',
  `feedback` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `result` mediumint(8) unsigned NOT NULL,
  `repo` mediumint(8) unsigned NOT NULL,
  `mr` mediumint(8) unsigned NOT NULL,
  `entry` text NOT NULL,
  `lines` varchar(10) NOT NULL,
  `v1` varchar(40) NOT NULL,
  `v2` varchar(40) NOT NULL,
  `repoType` varchar(30) NOT NULL DEFAULT '',
  `issueKey` varchar(50) NOT NULL DEFAULT '',
  `testtask` mediumint(8) unsigned NOT NULL,
  `lastEditedBy` varchar(30) NOT NULL DEFAULT '',
  `lastEditedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `execution` (`execution`),
  KEY `status` (`status`),
  KEY `plan` (`plan`),
  KEY `story` (`story`),
  KEY `case` (`case`),
  KEY `toStory` (`toStory`),
  KEY `result` (`result`),
  KEY `assignedTo` (`assignedTo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_build` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `branch` varchar(255) NOT NULL DEFAULT '0',
  `execution` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `builds` varchar(255) NOT NULL,
  `name` char(150) NOT NULL,
  `scmPath` char(255) NOT NULL,
  `filePath` char(255) NOT NULL,
  `date` date NOT NULL,
  `stories` text NOT NULL,
  `bugs` text NOT NULL,
  `builder` char(30) NOT NULL DEFAULT '',
  `desc` mediumtext NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `execution` (`execution`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_burn` (
  `execution` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL,
  `task` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `estimate` float NOT NULL,
  `left` float NOT NULL,
  `consumed` float NOT NULL,
  `storyPoint` float NOT NULL,
  PRIMARY KEY (`execution`,`date`,`task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_case` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `execution` mediumint(8) unsigned NOT NULL,
  `branch` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `lib` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `module` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `path` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `story` mediumint(30) unsigned NOT NULL DEFAULT '0',
  `storyVersion` smallint(6) NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL,
  `precondition` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `pri` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `type` char(30) NOT NULL DEFAULT '1',
  `auto` varchar(10) NOT NULL DEFAULT 'no',
  `frame` varchar(10) NOT NULL,
  `stage` varchar(255) NOT NULL,
  `howRun` varchar(30) NOT NULL,
  `scriptedBy` varchar(30) NOT NULL,
  `scriptedDate` date NOT NULL,
  `scriptStatus` varchar(30) NOT NULL,
  `scriptLocation` varchar(255) NOT NULL,
  `status` char(30) NOT NULL DEFAULT '1',
  `subStatus` varchar(30) NOT NULL DEFAULT '',
  `color` char(7) NOT NULL,
  `frequency` enum('1','2','3') NOT NULL DEFAULT '1',
  `order` tinyint(30) unsigned NOT NULL DEFAULT '0',
  `openedBy` char(30) NOT NULL DEFAULT '',
  `openedDate` datetime NOT NULL,
  `reviewedBy` varchar(255) NOT NULL,
  `reviewedDate` date NOT NULL,
  `lastEditedBy` char(30) NOT NULL DEFAULT '',
  `lastEditedDate` datetime NOT NULL,
  `version` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `linkCase` varchar(255) NOT NULL,
  `fromBug` mediumint(8) unsigned NOT NULL,
  `fromCaseID` mediumint(8) unsigned NOT NULL,
  `fromCaseVersion` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `lastRunner` varchar(30) NOT NULL,
  `lastRunDate` datetime NOT NULL,
  `lastRunResult` char(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `story` (`story`),
  KEY `fromBug` (`fromBug`),
  KEY `module` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_casestep` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `case` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `version` smallint(3) unsigned NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL DEFAULT 'step',
  `desc` text NOT NULL,
  `expect` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `case` (`case`),
  KEY `version` (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_cfd` (
  `id` int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `execution` int(8) NOT NULL,
  `type` char(30) NOT NULL,
  `name` char(30) NOT NULL,
  `count` smallint NOT NULL,
  `date` date NOT NULL,
  UNIQUE KEY `execution_type_name_date` (`execution`,`type`,`name`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_cmcl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(30) NOT NULL,
  `title` int(11) NOT NULL,
  `contents` text NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `order` int(11) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_company` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(120) DEFAULT NULL,
  `phone` char(20) DEFAULT NULL,
  `fax` char(20) DEFAULT NULL,
  `address` char(120) DEFAULT NULL,
  `zipcode` char(10) DEFAULT NULL,
  `website` char(120) DEFAULT NULL,
  `backyard` char(120) DEFAULT NULL,
  `guest` enum('1','0') NOT NULL DEFAULT '0',
  `admins` char(255) DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_compile` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `job` mediumint(8) unsigned NOT NULL,
  `queue` mediumint(8) NOT NULL,
  `status` varchar(255) NOT NULL,
  `logs` text,
  `atTime` varchar(10) NOT NULL,
  `testtask` mediumint(8) unsigned NOT NULL,
  `tag` varchar(255) NOT NULL,
  `times` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `updateDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_config` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `owner` char(30) NOT NULL DEFAULT '',
  `module` varchar(30) NOT NULL,
  `section` char(30) NOT NULL DEFAULT '',
  `key` char(30) NOT NULL DEFAULT '',
  `value` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`vision`,`owner`,`module`,`section`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_cron` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `m` varchar(20) NOT NULL,
  `h` varchar(20) NOT NULL,
  `dom` varchar(20) NOT NULL,
  `mon` varchar(20) NOT NULL,
  `dow` varchar(20) NOT NULL,
  `command` text NOT NULL,
  `remark` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `buildin` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(20) NOT NULL,
  `lastTime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lastTime` (`lastTime`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `zt_dataview` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group` mediumint(8) unsigned NOT NULL,
  `name` varchar(155) NOT NULL,
  `code` varchar(50) NOT NULL,
  `view` varchar(57) NOT NULL,
  `sql` text NOT NULL,
  `fields` mediumtext NOT NULL,
  `objects` mediumtext NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_deploy` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `begin` datetime NOT NULL,
  `end` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` mediumtext NOT NULL,
  `status` varchar(20) NOT NULL,
  `owner` char(30) NOT NULL,
  `members` text NOT NULL,
  `notify` text NOT NULL,
  `cases` text NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `result` varchar(20) NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `zt_dimension` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  `code` varchar(45) NOT NULL,
  `desc` text NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL default '0',
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_chart` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `dimension` mediumint(8) unsigned NOT NULL DEFAULT 0,
  `type` varchar(30) NOT NULL,
  `group` mediumint(8) unsigned NOT NULL DEFAULT 0,
  `dataset` varchar(30) NOT NULL,
  `desc` text NOT NULL,
  `settings` mediumtext NOT NULL,
  `filters` mediumtext NOT NULL,
  `fields` mediumtext,
  `sql` mediumtext,
  `builtin` tinyint(1) unsigned NOT NULL,
  `objects` mediumtext NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_dashboard` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `dimension` int(8) NOT NULL default 0,
  `module` mediumint NOT NULL,
  `desc` mediumtext NOT NULL,
  `layout` mediumtext NOT NULL,
  `filters` mediumtext NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_dataset` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `sql` text NOT NULL,
  `fields` mediumtext NOT NULL,
  `objects` mediumtext NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_deployproduct` (
  `deploy` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL,
  `release` mediumint(8) unsigned NOT NULL,
  `package` varchar(255) NOT NULL,
  UNIQUE KEY `deploy_product_release` (`deploy`,`product`,`release`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_deployscope` (
  `deploy` mediumint(8) unsigned NOT NULL,
  `service` mediumint(8) unsigned NOT NULL,
  `hosts` text NOT NULL,
  `remove` text NOT NULL,
  `add` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_deploystep` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `deploy` mediumint(8) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `begin` datetime NOT NULL,
  `end` datetime NOT NULL,
  `stage` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `assignedTo` char(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `finishedBy` char(30) NOT NULL,
  `finishedDate` datetime NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_dept` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(60) NOT NULL,
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `path` char(255) NOT NULL DEFAULT '',
  `grade` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `order` smallint(4) unsigned NOT NULL DEFAULT '0',
  `position` char(30) NOT NULL DEFAULT '',
  `function` char(255) NOT NULL DEFAULT '',
  `manager` char(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  KEY `path` (`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_design` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `commit` text NOT NULL,
  `commitedBy` varchar(30) NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `assignedBy` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `story` char(30) NOT NULL,
  `desc` mediumtext NOT NULL,
  `version` smallint(6) NOT NULL,
  `type` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_designspec` (
  `design` mediumint(8) NOT NULL,
  `version` smallint(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` mediumtext NOT NULL,
  `files` varchar(255) NOT NULL,
  UNIQUE KEY `design` (`design`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_doc` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `project` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `lib` varchar(30) NOT NULL,
  `template` varchar(30) NOT NULL,
  `templateType` varchar(30) NOT NULL,
  `chapterType` varchar(30) NOT NULL,
  `module` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `parent` smallint(5) unsigned NOT NULL DEFAULT '0',
  `path` char(255) NOT NULL DEFAULT '',
  `grade` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `views` smallint(5) unsigned NOT NULL,
  `assetLib` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `assetLibType` varchar(30) NOT NULL DEFAULT '',
  `from` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fromVersion` smallint(6) NOT NULL DEFAULT '1',
  `draft` longtext NOT NULL,
  `collector` text NOT NULL,
  `addedBy` varchar(30) NOT NULL,
  `addedDate` datetime NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `approvedDate` date NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `mailto` text,
  `acl` varchar(10) NOT NULL DEFAULT 'open',
  `groups` varchar(255) NOT NULL,
  `users` text NOT NULL,
  `version` smallint(5) unsigned NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `execution` (`execution`),
  KEY `lib` (`lib`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_doccontent` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `doc` mediumint(8) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `digest` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `files` text NOT NULL,
  `type` varchar(10) NOT NULL,
  `version` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doc_version` (`doc`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_doclib` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `product` mediumint(8) unsigned NOT NULL,
  `project` mediumint(8) unsigned NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `name` varchar(60) NOT NULL,
  `baseUrl` varchar(255) NOT NULL DEFAULT '',
  `acl` varchar(10) NOT NULL DEFAULT 'open',
  `groups` varchar(255) NOT NULL,
  `users` text NOT NULL,
  `main` enum('0','1') NOT NULL DEFAULT '0',
  `collector` text NOT NULL,
  `desc` mediumtext NOT NULL,
  `order` tinyint(5) unsigned NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `execution` (`execution`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_domain` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL,
  `adminURI` varchar(255) NOT NULL,
  `resolverURI` varchar(255) NOT NULL,
  `register` varchar(255) NOT NULL,
  `expiredDate` datetime NOT NULL,
  `renew` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `domain` (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_durationestimation` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `stage` mediumint(9) NOT NULL,
  `workload` varchar(255) NOT NULL,
  `worktimeRate` varchar(255) NOT NULL,
  `people` varchar(255) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_effort` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `objectType` varchar(30) NOT NULL,
  `objectID` mediumint(8) unsigned NOT NULL,
  `product` text NOT NULL,
  `project` mediumint(8) unsigned NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `account` varchar(30) NOT NULL,
  `work` text,
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `date` date NOT NULL,
  `left` float NOT NULL,
  `consumed` float NOT NULL,
  `begin` smallint(4) unsigned zerofill NOT NULL,
  `end` smallint(4) unsigned zerofill NOT NULL,
  `extra` text NOT NULL,
  `order` tinyint unsigned NOT NULL DEFAULT '0',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `execution` (`execution`),
  KEY `objectID` (`objectID`),
  KEY `date` (`date`),
  KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_entry` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `account` varchar(30) NOT NULL DEFAULT '',
  `code` varchar(20) NOT NULL,
  `key` varchar(32) NOT NULL,
  `freePasswd` enum('0','1') NOT NULL DEFAULT '0',
  `ip` varchar(100) NOT NULL,
  `desc` mediumtext NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `calledTime` int(10) unsigned NOT NULL DEFAULT '0',
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_expect` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `userID` mediumint(8) NOT NULL,
  `project` mediumint(8) NOT NULL DEFAULT '0',
  `expect` text NOT NULL,
  `progress` text NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_extension` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `code` varchar(30) NOT NULL,
  `version` varchar(50) NOT NULL,
  `author` varchar(100) NOT NULL,
  `desc` mediumtext NOT NULL,
  `license` text NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'extension',
  `site` varchar(150) NOT NULL,
  `zentaoCompatible` varchar(100) NOT NULL,
  `installedTime` datetime NOT NULL,
  `depends` varchar(100) NOT NULL,
  `dirs` mediumtext NOT NULL,
  `files` mediumtext NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `name` (`name`),
  KEY `installedTime` (`installedTime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_faq` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `module` mediumint(9) NOT NULL,
  `product` mediumint(9) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `addedtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_feedback` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `product` mediumint(8) unsigned NOT NULL,
  `module` mediumint(8) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` char(30) NOT NULL,
  `solution` char(30) NOT NULL,
  `desc` text NOT NULL,
  `pri` tinyint unsigned NOT NULL DEFAULT 2,
  `status` varchar(30) NOT NULL,
  `subStatus` varchar(30) NOT NULL DEFAULT '',
  `public` enum('0','1') NOT NULL DEFAULT '0',
  `notify` enum('0','1') NOT NULL DEFAULT '0',
  `notifyEmail` varchar(100) NOT NULL,
  `source` varchar(255) NOT NULL,
  `likes` text NOT NULL,
  `result` mediumint(8) unsigned NOT NULL,
  `faq` mediumint(8) unsigned NOT NULL,
  `openedBy` char(30) NOT NULL,
  `openedDate` datetime NOT NULL,
  `reviewedBy` varchar(255) NOT NULL,
  `reviewedDate` datetime NOT NULL,
  `processedBy` char(30) NOT NULL,
  `processedDate` datetime NOT NULL,
  `closedBy` char(30) NOT NULL,
  `closedDate` datetime NOT NULL,
  `closedReason` varchar(30) NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `assignedTo` varchar(255) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `activatedBy` varchar(30) NOT NULL,
  `activatedDate` datetime NOT NULL,
  `feedbackBy` varchar(100) NOT NULL,
  `repeatFeedback` mediumint(8) NOT NULL DEFAULT 0,
  `mailto` varchar(255) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_feedbackview` (
  `account` char(30) NOT NULL,
  `product` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `account_product` (`account`,`product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_file` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pathname` char(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `extension` char(30) NOT NULL,
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `objectType` char(30) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `addedBy` char(30) NOT NULL DEFAULT '',
  `addedDate` datetime NOT NULL,
  `downloads` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `extra` varchar(255) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `objectType` (`objectType`),
  KEY `objectID` (`objectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_gapanalysis` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `account` varchar(30) NOT NULL,
  `role` varchar(20) NOT NULL,
  `analysis` mediumtext NOT NULL,
  `needTrain` enum('no','yes') NOT NULL DEFAULT 'no',
  `createdBy` char(30) DEFAULT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_account` (`project`,`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `name` char(30) NOT NULL,
  `role` char(30) NOT NULL DEFAULT '',
  `desc` char(255) NOT NULL DEFAULT '',
  `acl` text,
  `developer` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_grouppriv` (
  `group` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `module` char(30) NOT NULL DEFAULT '',
  `method` char(30) NOT NULL DEFAULT '',
  UNIQUE KEY `group` (`group`,`module`,`method`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_history` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `action` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `field` varchar(30) NOT NULL DEFAULT '',
  `old` text NOT NULL,
  `new` text NOT NULL,
  `diff` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `action` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_holiday` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `type` enum('holiday','working') NOT NULL DEFAULT 'holiday',
  `desc` mediumtext NOT NULL,
  `year` char(4) NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `year` (`year`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_host` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `assetID` mediumint(8) unsigned NOT NULL,
  `admin` smallint(5) unsigned NOT NULL DEFAULT '0',
  `serverRoom` mediumint(8) unsigned NOT NULL,
  `cabinet` varchar(128) NOT NULL,
  `serverModel` varchar(256) NOT NULL,
  `hardwareType` varchar(64) NOT NULL,
  `hostType` enum('physical','virtual') NOT NULL,
  `cpuBrand` varchar(128) NOT NULL,
  `cpuModel` varchar(128) NOT NULL,
  `cpuNumber` varchar(16) NOT NULL,
  `cpuCores` varchar(30) NOT NULL,
  `cpuRate` varchar(30) NOT NULL,
  `memory` varchar(30) NOT NULL,
  `diskType` varchar(30) NOT NULL,
  `diskSize` varchar(30) NOT NULL,
  `unit` enum('GB','TB') NOT NULL DEFAULT 'GB',
  `privateIP` varchar(128) NOT NULL,
  `publicIP` varchar(128) NOT NULL,
  `nic` varchar(128) NOT NULL,
  `mac` varchar(128) NOT NULL,
  `osName` varchar(64) NOT NULL,
  `osVersion` varchar(64) NOT NULL,
  `webserver` varchar(128) NOT NULL,
  `database` varchar(128) NOT NULL,
  `language` varchar(16) NOT NULL,
  `status` varchar(50) NOT NULL,
  `agentPort` varchar(10) NOT NULL,
  `instanceNum` tinyint(4) NOT NULL DEFAULT '0',
  `pri` smallint(5) unsigned NOT NULL DEFAULT '0',
  `heartbeatTime` datetime NOT NULL,
  `tags` varchar(50) NOT NULL DEFAULT '',
  `provider` varchar(255) NOT NULL DEFAULT '',
  `bridgeID` varchar(255) NOT NULL DEFAULT '',
  `cloudKey` varchar(255) NOT NULL DEFAULT '',
  `cloudSecret` varchar(255) NOT NULL DEFAULT '',
  `cloudRegion` varchar(255) NOT NULL DEFAULT '',
  `cloudNamespace` varchar(255) NOT NULL DEFAULT '',
  `cloudUser` varchar(255) NOT NULL DEFAULT '',
  `cloudAccount` varchar(255) NOT NULL DEFAULT '',
  `cloudPassword` varchar(255) NOT NULL DEFAULT '',
  `couldVPC` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_im_chat` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `gid` char(40) NOT NULL DEFAULT '',
  `name` varchar(60) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT 'group',
  `admins` varchar(255) NOT NULL DEFAULT '',
  `committers` varchar(255) NOT NULL DEFAULT '',
  `subject` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `public` enum('0','1') NOT NULL DEFAULT '0',
  `createdBy` varchar(30) NOT NULL DEFAULT '',
  `createdDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ownedBy` varchar(30) NOT NULL DEFAULT '',
  `editedBy` varchar(30) NOT NULL DEFAULT '',
  `editedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mergedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastActiveTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastMessage` int(11) unsigned NOT NULL DEFAULT '0',
  `lastMessageIndex` int(11) unsigned NOT NULL DEFAULT 0,
  `dismissDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pinnedMessages` text NOT NULL,
  `mergedChats` text NOT NULL DEFAULT '',
  `adminInvite` enum('0','1') NOT NULL DEFAULT '0',
  `avatar` text NOT NULL DEFAULT '',
  `archiveDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`),
  KEY `name` (`name`),
  KEY `type` (`type`),
  KEY `public` (`public`),
  KEY `createdBy` (`createdBy`),
  KEY `editedBy` (`editedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_im_chat_message_index` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `gid` char(40) NOT NULL,
  `tableName` char(64) NOT NULL,
  `start` int(11) unsigned NOT NULL,
  `end` int(11) unsigned NOT NULL,
  `startIndex` int(11) unsigned NOT NULL,
  `endIndex` int(11) unsigned NOT NULL,
  `startDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `endDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `count` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chattable` (`gid`,`tableName`),
  KEY `start` (`start`),
  KEY `end` (`end`),
  KEY `startDate` (`startDate`),
  KEY `endDate` (`endDate`),
  KEY `chatstartindex` (`gid`,`startIndex`),
  KEY `chatendindex` (`gid`,`endIndex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_im_chatuser` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cgid` char(40) NOT NULL DEFAULT '',
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `order` smallint(5) NOT NULL DEFAULT '0',
  `star` enum('0','1') NOT NULL DEFAULT '0',
  `hide` enum('0','1') NOT NULL DEFAULT '0',
  `mute` enum('0','1') NOT NULL DEFAULT '0',
  `freeze` enum('0','1') NOT NULL DEFAULT '0',
  `join` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `quit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `category` varchar(40) NOT NULL DEFAULT '',
  `lastReadMessage` int(11) unsigned NOT NULL DEFAULT '0',
  `lastReadMessageIndex` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chatuser` (`cgid`,`user`),
  KEY `cgid` (`cgid`),
  KEY `user` (`user`),
  KEY `order` (`order`),
  KEY `star` (`star`),
  KEY `hide` (`hide`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_im_client` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `version` char(30) NOT NULL DEFAULT '',
  `desc` varchar(100) NOT NULL DEFAULT '',
  `changeLog` text NOT NULL,
  `strategy` varchar(10) NOT NULL DEFAULT '',
  `downloads` text NOT NULL,
  `createdDate` datetime NOT NULL,
  `createdBy` varchar(30) NOT NULL DEFAULT '',
  `editedDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL DEFAULT '',
  `status` enum('released','wait') NOT NULL DEFAULT 'wait',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_im_conference` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `rid` char(40) NOT NULL DEFAULT '',
  `cgid` char(40) NOT NULL DEFAULT '',
  `status` enum('closed','open') NOT NULL DEFAULT 'closed',
  `participants` text NOT NULL,
  `invitee` text NOT NULL,
  `openedBy` mediumint(8) NOT NULL DEFAULT '0',
  `openedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_im_conferenceaction` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `rid` char(40) NOT NULL DEFAULT '',
  `type` enum('create','invite','join','leave','close','publish') NOT NULL DEFAULT 'create',
  `data` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `device` char(40) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_im_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gid` char(40) NOT NULL DEFAULT '',
  `cgid` char(40) NOT NULL DEFAULT '',
  `user` varchar(30) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `index` int(11) unsigned NOT NULL DEFAULT 0,
  `type` enum('normal','broadcast','notify','bulletin','botcommand') NOT NULL DEFAULT 'normal',
  `content` text NOT NULL,
  `contentType` enum('text','plain','emotion','image','file','object','code') NOT NULL DEFAULT 'text',
  `data` text NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `mgid` (`gid`),
  KEY `mcgid` (`cgid`),
  KEY `muser` (`user`),
  KEY `mtype` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_im_message_backup` (
  `id` int(11) unsigned NOT NULL,
  `gid` char(40) NOT NULL DEFAULT '',
  `cgid` char(40) NOT NULL DEFAULT '',
  `user` varchar(30) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `index` int(11) unsigned NOT NULL DEFAULT 0,
  `type` enum('normal','broadcast','notify') NOT NULL DEFAULT 'normal',
  `content` text NOT NULL,
  `contentType` enum('text','plain','emotion','image','file','object','code') NOT NULL DEFAULT 'text',
  `data` text NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_im_message_index` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tableName` char(64) NOT NULL,
  `start` int(11) unsigned NOT NULL,
  `end` int(11) unsigned NOT NULL,
  `startDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `endDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `chats` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tableName` (`tableName`),
  KEY `start` (`start`),
  KEY `end` (`end`),
  KEY `startDate` (`startDate`),
  KEY `endDate` (`endDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_im_messagestatus` (
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `message` int(11) unsigned NOT NULL,
  `status` enum('waiting','sent','readed','deleted') NOT NULL DEFAULT 'waiting',
  UNIQUE KEY `user` (`user`,`message`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_im_queue` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(30) NOT NULL,
  `content` text NOT NULL,
  `addDate` datetime NOT NULL,
  `processDate` datetime NOT NULL,
  `result` text NOT NULL,
  `status` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_im_userdevice` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `device` char(40) NOT NULL DEFAULT 'default',
  `deviceID` char(40) NOT NULL DEFAULT '',
  `token` char(64) NOT NULL DEFAULT '',
  `validUntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastLogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastLogout` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userdevice` (`user`,`device`),
  KEY `user` (`user`),
  KEY `lastLogin` (`lastLogin`),
  KEY `lastLogout` (`lastLogout`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_intervention` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `activity` mediumint(8) NOT NULL,
  `status` char(30) NOT NULL,
  `partake` text NOT NULL,
  `begin` date NOT NULL,
  `realBegin` date NOT NULL,
  `situation` varchar(255) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project` (`project`,`activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_issue` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `resolvedBy` varchar(30) NOT NULL,
  `project` varchar(255) NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `desc` mediumtext NOT NULL,
  `pri` char(30) NOT NULL,
  `severity` char(30) NOT NULL,
  `type` char(30) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `deadline` date NOT NULL,
  `resolution` char(30) NOT NULL,
  `resolutionComment` text NOT NULL,
  `objectID` varchar(255) NOT NULL,
  `resolvedDate` date NOT NULL,
  `status` varchar(30) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `lib` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `from` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `version` smallint(6) NOT NULL DEFAULT '1',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `activateBy` varchar(30) NOT NULL,
  `activateDate` date NOT NULL,
  `closedBy` varchar(30) NOT NULL,
  `closedDate` date NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `assignedBy` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `approvedDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_job` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `repo` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL,
  `frame` varchar(20) NOT NULL,
  `engine` varchar(20) NOT NULL,
  `server` mediumint(8) unsigned NOT NULL,
  `pipeline` varchar(500) NOT NULL,
  `triggerType` varchar(255) NOT NULL,
  `sonarqubeServer` mediumint(8) unsigned NOT NULL,
  `projectKey` varchar(255) NOT NULL,
  `svnDir` varchar(255) NOT NULL,
  `atDay` varchar(255) DEFAULT NULL,
  `atTime` varchar(10) DEFAULT NULL,
  `customParam` text NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `lastExec` datetime DEFAULT NULL,
  `lastStatus` varchar(255) DEFAULT NULL,
  `lastTag` varchar(255) DEFAULT NULL,
  `lastSyncDate` datetime DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_kanban` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `space` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `owner` varchar(30) NOT NULL,
  `team` text NOT NULL,
  `desc` mediumtext NOT NULL,
  `acl` char(30) NOT NULL DEFAULT 'open',
  `whitelist` text NOT NULL,
  `archived` enum('0','1') NOT NULL DEFAULT '1',
  `performable` enum('0','1') NOT NULL DEFAULT '0',
  `status` enum('active','closed') NOT NULL DEFAULT 'active',
  `order` mediumint(8) NOT NULL DEFAULT '0',
  `displayCards` smallint(6) NOT NULL DEFAULT '0',
  `showWIP` enum('0','1') NOT NULL DEFAULT '1',
  `fluidBoard` enum('0','1') NOT NULL DEFAULT '0',
  `colWidth` smallint(4) NOT NULL DEFAULT '264',
  `minColWidth` smallint(4) NOT NULL DEFAULT '200',
  `maxColWidth` smallint(4) NOT NULL DEFAULT '384',
  `object` varchar(255) NOT NULL,
  `alignment` varchar(10) NOT NULL DEFAULT 'center',
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `lastEditedBy` char(30) NOT NULL,
  `lastEditedDate` datetime NOT NULL,
  `closedBy` char(30) NOT NULL,
  `closedDate` datetime NOT NULL,
  `activatedBy` char(30) NOT NULL,
  `activatedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_kanbancard` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `kanban` mediumint(8) unsigned NOT NULL,
  `region` mediumint(8) unsigned NOT NULL,
  `group` mediumint(8) unsigned NOT NULL,
  `fromID` mediumint(8) unsigned NOT NULL,
  `fromType` varchar(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'doing',
  `pri` mediumint(8) unsigned NOT NULL,
  `assignedTo` text NOT NULL,
  `desc` mediumtext NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `estimate` float unsigned NOT NULL,
  `progress` float unsigned NOT NULL DEFAULT '0',
  `color` char(7) NOT NULL,
  `acl` char(30) NOT NULL DEFAULT 'open',
  `whitelist` text NOT NULL,
  `order` mediumint(8) NOT NULL DEFAULT '0',
  `archived` enum('0','1') NOT NULL DEFAULT '0',
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `lastEditedBy` char(30) NOT NULL,
  `lastEditedDate` datetime NOT NULL,
  `archivedBy` char(30) NOT NULL,
  `archivedDate` datetime NOT NULL,
  `assignedBy` char(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_kanbancell` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `kanban` mediumint(8) NOT NULL,
  `lane` mediumint(8) NOT NULL,
  `column` mediumint(8) NOT NULL,
  `type` char(30) NOT NULL,
  `cards` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_group` (`kanban`,`type`,`lane`,`column`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_kanbancolumn` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `parent` mediumint(8) NOT NULL DEFAULT '0',
  `type` char(30) NOT NULL,
  `region` mediumint(8) unsigned NOT NULL,
  `group` mediumint(8) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `color` char(30) NOT NULL,
  `limit` smallint(6) NOT NULL DEFAULT '-1',
  `order` mediumint(8) NOT NULL DEFAULT '0',
  `archived` enum('0','1') NOT NULL DEFAULT '0',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_kanbangroup` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `kanban` mediumint(8) unsigned NOT NULL,
  `region` mediumint(8) unsigned NOT NULL,
  `order` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_kanbanlane` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `execution` mediumint(8) NOT NULL DEFAULT '0',
  `type` char(30) NOT NULL,
  `region` mediumint(8) unsigned NOT NULL,
  `group` mediumint(8) unsigned NOT NULL,
  `groupby` char(30) NOT NULL,
  `extra` char(30) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `color` char(30) NOT NULL,
  `order` smallint(6) NOT NULL DEFAULT '0',
  `lastEditedTime` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_kanbanregion` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `space` mediumint(8) unsigned NOT NULL,
  `kanban` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `order` mediumint(8) NOT NULL DEFAULT '0',
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `lastEditedBy` char(30) NOT NULL,
  `lastEditedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_kanbanspace` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `owner` varchar(30) NOT NULL,
  `team` text NOT NULL,
  `desc` mediumtext NOT NULL,
  `acl` char(30) NOT NULL DEFAULT 'open',
  `whitelist` text NOT NULL,
  `status` enum('active','closed') NOT NULL DEFAULT 'active',
  `order` mediumint(8) NOT NULL DEFAULT '0',
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `lastEditedBy` char(30) NOT NULL,
  `lastEditedDate` datetime NOT NULL,
  `closedBy` char(30) NOT NULL,
  `closedDate` datetime NOT NULL,
  `activatedBy` char(30) NOT NULL,
  `activatedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_lang` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(30) NOT NULL,
  `module` varchar(30) NOT NULL,
  `section` varchar(30) NOT NULL,
  `key` varchar(60) NOT NULL,
  `value` text NOT NULL,
  `system` enum('0','1') NOT NULL DEFAULT '1',
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  PRIMARY KEY (`id`),
  UNIQUE KEY `lang` (`lang`,`module`,`section`,`key`,`vision`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_leave` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `year` char(4) NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `start` time NOT NULL,
  `finish` time NOT NULL,
  `hours` float(4,1) unsigned NOT NULL DEFAULT '0.0',
  `backDate` datetime NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '',
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `reviewedBy` char(30) NOT NULL,
  `reviewedDate` datetime NOT NULL,
  `level` tinyint(3) NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `reviewers` text NOT NULL,
  `backReviewers` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `year` (`year`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `createdBy` (`createdBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_lieu` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `year` char(4) NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `start` time NOT NULL,
  `finish` time NOT NULL,
  `hours` float(4,1) unsigned NOT NULL DEFAULT '0.0',
  `overtime` char(255) NOT NULL,
  `trip` char(255) NOT NULL,
  `desc` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '',
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `reviewedBy` char(30) NOT NULL,
  `reviewedDate` datetime NOT NULL,
  `level` tinyint(3) NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `reviewers` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `year` (`year`),
  KEY `status` (`status`),
  KEY `createdBy` (`createdBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_log` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `objectType` varchar(30) NOT NULL,
  `objectID` mediumint(8) unsigned NOT NULL,
  `action` mediumint(8) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `url` varchar(255) NOT NULL,
  `contentType` varchar(30) NOT NULL,
  `data` text NOT NULL,
  `result` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `objectType` (`objectType`),
  KEY `obejctID` (`objectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_measqueue` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `mid` mediumint(8) unsigned NOT NULL,
  `status` varchar(255) NOT NULL,
  `logs` text,
  `execTime` varchar(10) NOT NULL,
  `params` text,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `updateDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_measrecords` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `mid` mediumint(8) NOT NULL,
  `measCode` char(50) NOT NULL DEFAULT '',
  `project` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `params` text NOT NULL,
  `year` char(4) NOT NULL,
  `month` char(6) NOT NULL,
  `week` char(8) NOT NULL,
  `day` char(8) NOT NULL,
  `value` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `project` (`project`),
  KEY `time` (`year`,`month`,`day`,`week`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_meastemplate` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `model` char(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_meeting` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) NOT NULL,
  `execution` mediumint(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `begin` time NOT NULL,
  `end` time NOT NULL,
  `dept` mediumint(8) NOT NULL,
  `mode` varchar(255) NOT NULL,
  `host` varchar(30) NOT NULL,
  `participant` text NOT NULL,
  `date` date NOT NULL,
  `room` int(11) NOT NULL,
  `minutes` text NOT NULL,
  `minutedBy` varchar(30) NOT NULL,
  `minutedDate` datetime NOT NULL,
  `objectType` varchar(30) NOT NULL,
  `objectID` mediumint(8) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_meetingroom` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position` varchar(30) NOT NULL,
  `seats` int(11) NOT NULL,
  `equipment` varchar(255) NOT NULL,
  `openTime` varchar(255) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_module` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `root` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `branch` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` char(60) NOT NULL DEFAULT '',
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `path` char(255) NOT NULL DEFAULT '',
  `grade` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `type` char(30) NOT NULL,
  `from` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `owner` varchar(30) NOT NULL,
  `collector` text NOT NULL,
  `short` varchar(30) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `root` (`root`),
  KEY `type` (`type`),
  KEY `path` (`path`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_mr` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `hostID` mediumint(8) unsigned NOT NULL,
  `sourceProject` varchar(50) NOT NULL,
  `sourceBranch` varchar(100) NOT NULL,
  `targetProject` varchar(50) NOT NULL,
  `targetBranch` varchar(100) NOT NULL,
  `mriid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `assignee` varchar(255) NOT NULL,
  `reviewer` varchar(255) NOT NULL,
  `approver` varchar(255) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `status` char(30) NOT NULL,
  `mergeStatus` char(30) NOT NULL,
  `approvalStatus` char(30) NOT NULL,
  `needApproved` enum('0','1') NOT NULL DEFAULT '0',
  `needCI` enum('0','1') NOT NULL DEFAULT '0',
  `repoID` mediumint(8) unsigned NOT NULL,
  `jobID` mediumint(8) unsigned NOT NULL,
  `compileID` mediumint(8) unsigned NOT NULL,
  `compileStatus` char(30) NOT NULL,
  `removeSourceBranch` enum('0','1') NOT NULL DEFAULT '0',
  `synced` enum('0','1') NOT NULL DEFAULT '1',
  `syncError` varchar(255) NOT NULL,
  `hasNoConflict` enum('0','1') NOT NULL DEFAULT '0',
  `diffs` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_mrapproval` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `mrID` mediumint(8) unsigned NOT NULL,
  `account` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `action` char(30) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_nc` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `auditplan` mediumint(8) NOT NULL,
  `listID` mediumint(8) NOT NULL,
  `title` varchar(255) NOT NULL,
  `desc` mediumtext NOT NULL,
  `type` char(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `severity` char(30) NOT NULL,
  `deadline` date NOT NULL,
  `resolvedBy` varchar(30) NOT NULL,
  `resolution` char(30) NOT NULL,
  `resolvedDate` date NOT NULL,
  `closedBy` varchar(30) NOT NULL,
  `closedDate` date NOT NULL,
  `parent` mediumint(8) unsigned NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `assignedDate` date NOT NULL,
  `activateDate` date NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_notify` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `objectType` varchar(50) NOT NULL,
  `objectID` mediumint(8) unsigned NOT NULL,
  `action` mediumint(9) NOT NULL,
  `toList` varchar(255) NOT NULL,
  `ccList` text NOT NULL,
  `subject` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `sendTime` datetime NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'wait',
  `failReason` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `objectType_toList_status` (`objectType`,`toList`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_oauth` (
  `account` varchar(30) NOT NULL,
  `openID` varchar(255) NOT NULL,
  `providerType` varchar(30) NOT NULL,
  `providerID` mediumint(8) unsigned NOT NULL,
  KEY `account` (`account`),
  KEY `providerType` (`providerType`),
  KEY `providerID` (`providerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_object` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) NOT NULL,
  `from` mediumint(8) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` char(30) NOT NULL,
  `version` varchar(255) NOT NULL,
  `type` enum('reviewed','taged') NOT NULL,
  `range` text NOT NULL,
  `data` text NOT NULL,
  `storyEst` char(30) NOT NULL,
  `taskEst` char(30) NOT NULL,
  `requestEst` char(30) NOT NULL,
  `testEst` char(30) NOT NULL,
  `devEst` char(30) NOT NULL,
  `designEst` char(30) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_opportunity` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `source` char(30) NOT NULL,
  `type` char(30) NOT NULL,
  `strategy` char(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `impact` mediumint(8) NOT NULL,
  `chance` mediumint(8) NOT NULL,
  `ratio` mediumint(8) NOT NULL,
  `pri` char(30) NOT NULL,
  `identifiedDate` date NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `assignedDate` date NOT NULL,
  `approvedDate` date NOT NULL,
  `prevention` mediumtext NOT NULL,
  `plannedClosedDate` date NOT NULL,
  `actualClosedDate` date NOT NULL,
  `lib` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `from` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `version` smallint(6) NOT NULL DEFAULT '1',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `activatedBy` varchar(30) NOT NULL,
  `activatedDate` datetime NOT NULL,
  `closedBy` varchar(30) NOT NULL,
  `closedDate` datetime NOT NULL,
  `canceledBy` varchar(30) NOT NULL,
  `canceledDate` datetime NOT NULL,
  `cancelReason` char(30) NOT NULL,
  `hangupedBy` varchar(30) NOT NULL,
  `hangupedDate` datetime NOT NULL,
  `resolution` mediumtext NOT NULL,
  `resolvedBy` varchar(30) NOT NULL,
  `resolvedDate` datetime NOT NULL,
  `lastCheckedBy` varchar(30) NOT NULL,
  `lastCheckedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_overtime` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `year` char(4) NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `start` time NOT NULL,
  `finish` time NOT NULL,
  `hours` float(4,1) unsigned NOT NULL DEFAULT '0.0',
  `leave` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '',
  `rejectReason` varchar(100) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `reviewedBy` char(30) NOT NULL,
  `reviewedDate` datetime NOT NULL,
  `level` tinyint(3) NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `reviewers` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `year` (`year`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `createdBy` (`createdBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_pipeline` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `account` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `private` char(32) DEFAULT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_planstory` (
  `plan` mediumint(8) unsigned NOT NULL,
  `story` mediumint(8) unsigned NOT NULL,
  `order` mediumint(9) NOT NULL,
  UNIQUE KEY `plan_story` (`plan`,`story`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_process` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `model` char(30) NOT NULL DEFAULT 'waterfall',
  `name` varchar(255) NOT NULL,
  `type` char(30) NOT NULL,
  `abbr` char(30) NOT NULL,
  `desc` mediumtext NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `order` mediumint(9) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `assignedBy` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_product` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `program` mediumint(8) unsigned NOT NULL,
  `name` varchar(90) NOT NULL,
  `code` varchar(45) NOT NULL,
  `shadow` tinyint(1) unsigned NOT NULL,
  `bind` enum('0','1') NOT NULL DEFAULT '0',
  `line` mediumint(8) NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'normal',
  `status` varchar(30) NOT NULL DEFAULT '',
  `subStatus` varchar(30) NOT NULL DEFAULT '',
  `desc` mediumtext NOT NULL,
  `PO` varchar(30) NOT NULL,
  `QD` varchar(30) NOT NULL,
  `RD` varchar(30) NOT NULL,
  `feedback` varchar(30) NOT NULL,
  `ticket` varchar(30) NOT NULL,
  `acl` enum('open','private','custom') NOT NULL DEFAULT 'open',
  `whitelist` text NOT NULL,
  `reviewer` text NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `createdVersion` varchar(20) NOT NULL,
  `order` mediumint(8) unsigned NOT NULL,
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `acl` (`acl`),
  KEY `order` (`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_productplan` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `product` mediumint(8) unsigned NOT NULL,
  `branch` varchar(255) NOT NULL DEFAULT '0',
  `parent` mediumint(9) NOT NULL DEFAULT '0',
  `title` varchar(90) NOT NULL,
  `status` enum('wait','doing','done','closed') NOT NULL DEFAULT 'wait',
  `desc` mediumtext NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `order` text NOT NULL,
  `closedReason` varchar(20) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `end` (`end`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_programactivity` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `process` mediumint(8) NOT NULL,
  `activity` mediumint(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `reason` varchar(255) NOT NULL,
  `result` char(30) NOT NULL,
  `linkedBy` char(30) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_programoutput` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `process` mediumint(8) NOT NULL,
  `activity` mediumint(8) NOT NULL,
  `output` mediumint(8) NOT NULL,
  `content` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `result` char(30) NOT NULL,
  `linkedBy` char(30) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_programprocess` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `process` mediumint(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` char(30) NOT NULL,
  `abbr` char(30) NOT NULL,
  `desc` text NOT NULL,
  `reason` varchar(255) NOT NULL,
  `linkedBy` char(30) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_programreport` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `template` mediumint(8) NOT NULL,
  `project` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `content` text NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_project` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) NOT NULL DEFAULT '0',
  `model` char(30) NOT NULL,
  `type` char(30) NOT NULL DEFAULT 'sprint',
  `lifetime` char(30) NOT NULL DEFAULT '',
  `budget` varchar(30) NOT NULL DEFAULT '0',
  `budgetUnit` char(30) NOT NULL DEFAULT 'CNY',
  `attribute` varchar(30) NOT NULL DEFAULT '',
  `percent` float unsigned NOT NULL DEFAULT '0',
  `milestone` enum('0','1') NOT NULL DEFAULT '0',
  `output` text NOT NULL,
  `auth` char(30) NOT NULL,
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL,
  `grade` tinyint(3) unsigned NOT NULL,
  `name` varchar(90) NOT NULL,
  `code` varchar(45) NOT NULL,
  `hasProduct` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `realBegan` date NOT NULL,
  `realEnd` date NOT NULL,
  `days` smallint(5) unsigned NOT NULL,
  `status` varchar(10) NOT NULL,
  `subStatus` varchar(30) NOT NULL DEFAULT '',
  `pri` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `desc` mediumtext NOT NULL,
  `version` smallint(6) NOT NULL,
  `parentVersion` smallint(6) NOT NULL,
  `planDuration` int(11) NOT NULL,
  `realDuration` int(11) NOT NULL,
  `openedBy` varchar(30) NOT NULL DEFAULT '',
  `openedDate` datetime NOT NULL,
  `openedVersion` varchar(20) NOT NULL,
  `lastEditedBy` varchar(30) NOT NULL DEFAULT '',
  `lastEditedDate` datetime NOT NULL,
  `closedBy` varchar(30) NOT NULL DEFAULT '',
  `closedDate` datetime NOT NULL,
  `canceledBy` varchar(30) NOT NULL DEFAULT '',
  `canceledDate` datetime NOT NULL,
  `suspendedDate` date NOT NULL,
  `PO` varchar(30) NOT NULL DEFAULT '',
  `PM` varchar(30) NOT NULL DEFAULT '',
  `QD` varchar(30) NOT NULL DEFAULT '',
  `RD` varchar(30) NOT NULL DEFAULT '',
  `team` varchar(90) NOT NULL,
  `acl` char(30) NOT NULL DEFAULT 'open',
  `whitelist` text NOT NULL,
  `order` mediumint(8) unsigned NOT NULL,
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `division` enum('0','1') NOT NULL DEFAULT '1',
  `displayCards` smallint(6) NOT NULL DEFAULT '0',
  `fluidBoard` enum('0','1') NOT NULL DEFAULT '0',
  `multiple` enum('0', '1') NOT NULL DEFAULT '1',
  `colWidth` smallint(4) NOT NULL DEFAULT '264',
  `minColWidth` smallint(4) NOT NULL DEFAULT '200',
  `maxColWidth` smallint(4) NOT NULL DEFAULT '384',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  KEY `begin` (`begin`),
  KEY `end` (`end`),
  KEY `status` (`status`),
  KEY `acl` (`acl`),
  KEY `order` (`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_projectadmin` (
  `group` smallint(6) NOT NULL,
  `account` char(30) NOT NULL,
  `programs` text NOT NULL,
  `projects` text NOT NULL,
  `products` text NOT NULL,
  `executions` text NOT NULL,
  UNIQUE KEY `group_account` (`group`, `account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_projectcase` (
  `project` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `product` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `case` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `count` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `version` smallint(6) NOT NULL DEFAULT '1',
  `order` smallint(6) unsigned NOT NULL,
  UNIQUE KEY `project` (`project`,`case`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_projectproduct` (
  `project` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL,
  `branch` mediumint(8) unsigned NOT NULL,
  `plan` varchar(255) NOT NULL,
  PRIMARY KEY (`project`,`product`,`branch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_projectspec` (
  `project` mediumint(8) NOT NULL,
  `version` smallint(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `milestone` enum('0','1') NOT NULL DEFAULT '0',
  `begin` date NOT NULL,
  `end` date NOT NULL,
  UNIQUE KEY `project` (`project`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_projectstory` (
  `project` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `product` mediumint(8) unsigned NOT NULL,
  `branch` mediumint(8) unsigned NOT NULL,
  `story` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `version` smallint(6) NOT NULL DEFAULT '1',
  `order` smallint(6) unsigned NOT NULL,
  UNIQUE KEY `project` (`project`,`story`),
  KEY `story` (`story`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_relation` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) NOT NULL,
  `product` mediumint(8) NOT NULL,
  `execution` mediumint(8) NOT NULL,
  `AType` char(30) NOT NULL,
  `AID` mediumint(8) NOT NULL,
  `AVersion` char(30) NOT NULL,
  `relation` char(30) NOT NULL,
  `BType` char(30) NOT NULL,
  `BID` mediumint(8) NOT NULL,
  `BVersion` char(30) NOT NULL,
  `extra` char(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `relation` (`product`,`relation`,`AType`,`BType`,`AID`,`BID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_relationoftasks` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `execution` mediumint(8) unsigned NOT NULL,
  `pretask` mediumint(8) unsigned NOT NULL,
  `condition` enum('begin','end') NOT NULL,
  `task` mediumint(8) unsigned NOT NULL,
  `action` enum('begin','end') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `relationoftasks` (`execution`,`task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_release` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` varchar(255) NOT NULL,
  `product` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `branch` varchar(255) NOT NULL,
  `shadow` mediumint(8) unsigned NOT NULL default '0',
  `build` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `marker` enum('0','1') NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `stories` text NOT NULL,
  `bugs` text NOT NULL,
  `leftBugs` text NOT NULL,
  `desc` mediumtext NOT NULL,
  `mailto` text,
  `notify` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'normal',
  `subStatus` varchar(30) NOT NULL DEFAULT '',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `build` (`build`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_repo` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `product` varchar(255) NOT NULL,
  `projects` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `prefix` varchar(100) NOT NULL,
  `encoding` varchar(20) NOT NULL,
  `SCM` varchar(10) NOT NULL,
  `client` varchar(100) NOT NULL,
  `serviceHost`  varchar(50) NOT NULL,
  `serviceProject`  varchar(100) NOT NULL,
  `commits` mediumint(8) unsigned NOT NULL,
  `account` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `encrypt` varchar(30) NOT NULL DEFAULT 'plain',
  `acl` text NOT NULL,
  `synced` tinyint(1) NOT NULL DEFAULT '0',
  `lastSync` datetime NOT NULL,
  `desc` text NOT NULL,
  `extra` char(30) NOT NULL,
  `preMerge` enum('0','1') NOT NULL DEFAULT '0',
  `job` mediumint(8) unsigned NOT NULL,
  `fileServerUrl` text,
  `fileServerAccount` varchar(40) NOT NULL DEFAULT '',
  `fileServerPassword` varchar(100) NOT NULL DEFAULT '',
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_repobranch` (
  `repo` mediumint(8) unsigned NOT NULL,
  `revision` mediumint(8) unsigned NOT NULL,
  `branch` varchar(255) NOT NULL,
  UNIQUE KEY `repo_revision_branch` (`repo`,`revision`,`branch`),
  KEY `branch` (`branch`),
  KEY `revision` (`revision`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_repofiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `repo` mediumint(8) unsigned NOT NULL,
  `revision` mediumint(8) unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `parent` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `action` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `path` (`path`),
  KEY `parent` (`parent`),
  KEY `repo` (`repo`),
  KEY `revision` (`revision`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_repohistory` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `repo` mediumint(9) NOT NULL,
  `revision` varchar(40) NOT NULL,
  `commit` mediumint(8) unsigned NOT NULL,
  `comment` text NOT NULL,
  `committer` varchar(100) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `repo` (`repo`),
  KEY `revision` (`revision`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_report` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `dimension` int(8) NOT NULL default 0,
  `module` varchar(100) NOT NULL,
  `sql` text NOT NULL,
  `vars` text NOT NULL,
  `langs` text NOT NULL,
  `params` text NOT NULL,
  `step` tinyint(1) NOT NULL DEFAULT '2',
  `desc` text NOT NULL,
  `addedBy` char(30) NOT NULL,
  `addedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_researchplan` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `customer` varchar(255) NOT NULL,
  `stakeholder` varchar(255) NOT NULL,
  `objective` varchar(255) NOT NULL,
  `begin` datetime NOT NULL,
  `end` datetime NOT NULL,
  `location` varchar(255) NOT NULL,
  `team` varchar(255) NOT NULL,
  `method` enum('','videoConference','interview','questionnaire','telephoneInterview') NOT NULL,
  `outline` mediumtext NOT NULL,
  `schedule` mediumtext NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_researchreport` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `relatedPlan` mediumint(8) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(30) NOT NULL,
  `content` mediumtext NOT NULL,
  `customer` varchar(255) NOT NULL,
  `researchObjects` varchar(255) NOT NULL,
  `begin` datetime NOT NULL,
  `end` datetime NOT NULL,
  `location` varchar(255) NOT NULL,
  `method` enum('','videoConference','interview','questionnaire','telephoneInterview') NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_review` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `object` mediumint(8) NOT NULL,
  `template` mediumint(8) NOT NULL,
  `doc` mediumint(8) DEFAULT NULL,
  `docVersion` smallint(6) NOT NULL,
  `status` char(30) NOT NULL,
  `reviewedBy` varchar(255) NOT NULL,
  `auditedBy` varchar(255) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `deadline` date NOT NULL,
  `lastReviewedBy` varchar(255) DEFAULT NULL,
  `lastReviewedDate` date NOT NULL,
  `lastAuditedBy` varchar(255) NOT NULL,
  `lastAuditedDate` date NOT NULL,
  `lastEditedBy` varchar(255) NOT NULL,
  `lastEditedDate` date NOT NULL,
  `result` char(30) NOT NULL,
  `auditResult` char(30) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_reviewcl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `object` char(30) NOT NULL,
  `category` char(30) NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `order` mediumint(8) DEFAULT '0',
  `status` varchar(30) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `assignedBy` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_reviewissue` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `review` mediumint(8) NOT NULL,
  `approval` mediumint(8) NOT NULL,
  `injection` mediumint(8) NOT NULL,
  `identify` mediumint(8) NOT NULL,
  `type` char(30) NOT NULL DEFAULT 'review',
  `listID` mediumint(8) NOT NULL,
  `title` varchar(255) NOT NULL,
  `opinion` varchar(255) NOT NULL,
  `opinionDate` date NOT NULL,
  `status` char(30) NOT NULL,
  `resolution` char(30) NOT NULL,
  `resolutionBy` char(30) NOT NULL,
  `resolutionDate` date NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_reviewlist` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `object` char(30) NOT NULL,
  `category` char(30) NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `assignedBy` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_reviewresult` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `review` mediumint(8) NOT NULL,
  `type` char(30) NOT NULL DEFAULT 'review',
  `result` char(30) NOT NULL,
  `opinion` text NOT NULL,
  `reviewer` char(30) NOT NULL,
  `remainIssue` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `consumed` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reviewer` (`review`,`reviewer`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_risk` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` varchar(255) NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `source` char(30) NOT NULL,
  `category` char(30) NOT NULL,
  `strategy` char(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `impact` char(30) NOT NULL,
  `probability` char(30) NOT NULL,
  `rate` char(30) NOT NULL,
  `pri` char(30) NOT NULL,
  `identifiedDate` date NOT NULL,
  `prevention` mediumtext NOT NULL,
  `remedy` mediumtext NOT NULL,
  `plannedClosedDate` date NOT NULL,
  `actualClosedDate` date NOT NULL,
  `lib` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `from` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `version` smallint(6) NOT NULL DEFAULT '1',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `resolution` mediumtext NOT NULL,
  `resolvedBy` varchar(30) NOT NULL,
  `activateBy` varchar(30) NOT NULL,
  `activateDate` date NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `closedBy` varchar(30) NOT NULL,
  `closedDate` date NOT NULL,
  `cancelBy` varchar(30) NOT NULL,
  `cancelDate` date NOT NULL,
  `cancelReason` char(30) NOT NULL,
  `hangupBy` varchar(30) NOT NULL,
  `hangupDate` date NOT NULL,
  `trackedBy` varchar(30) NOT NULL,
  `trackedDate` date NOT NULL,
  `assignedDate` date NOT NULL,
  `approvedDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_riskissue` (
  `risk` mediumint(8) unsigned NOT NULL,
  `issue` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `risk_issue` (`risk`,`issue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_score` (
  `id` bigint(12) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(30) NOT NULL,
  `module` varchar(30) NOT NULL DEFAULT '',
  `method` varchar(30) NOT NULL,
  `desc` varchar(250) NOT NULL DEFAULT '',
  `before` int(11) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL DEFAULT '0',
  `after` int(11) NOT NULL DEFAULT '0',
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `model` (`module`),
  KEY `method` (`method`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_searchdict` (
  `key` smallint(5) unsigned NOT NULL,
  `value` char(3) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_searchindex` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `objectType` char(20) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `object` (`objectType`,`objectID`),
  KEY `addedDate` (`addedDate`),
  FULLTEXT KEY `content` (`content`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_serverroom` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `line` varchar(20) NOT NULL,
  `bandwidth` varchar(128) NOT NULL,
  `provider` varchar(128) NOT NULL,
  `owner` varchar(30) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_service` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `external` enum('0','1') NOT NULL DEFAULT '0',
  `port` smallint(5) unsigned NOT NULL,
  `entry` varchar(255) NOT NULL,
  `deploy` varchar(255) NOT NULL,
  `version` varchar(64) NOT NULL,
  `color` char(7) NOT NULL,
  `desc` mediumtext,
  `dept` varchar(128) NOT NULL,
  `devel` varchar(30) NOT NULL,
  `qa` varchar(30) NOT NULL,
  `ops` varchar(30) NOT NULL,
  `hosts` text,
  `softName` varchar(128) NOT NULL,
  `softVersion` varchar(128) NOT NULL,
  `type` varchar(20) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `path` char(255) NOT NULL DEFAULT '',
  `grade` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_solutions` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `contents` text NOT NULL COMMENT '问题描述',
  `support` text NOT NULL COMMENT '是否需要高层支持',
  `measures` text NOT NULL COMMENT '解决建议',
  `type` char(30) NOT NULL,
  `addedBy` varchar(30) NOT NULL,
  `addedDate` date NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_sqlview` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  `code` varchar(45) NOT NULL,
  `sql` text NOT NULL,
  `desc` text NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_stage` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `percent` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_stakeholder` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `objectID` mediumint(8) NOT NULL,
  `objectType` char(30) NOT NULL,
  `user` char(30) NOT NULL,
  `type` char(30) NOT NULL,
  `key` enum('0','1') NOT NULL,
  `from` char(30) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` date NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  KEY `objectID` (`objectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_story` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `parent` mediumint(9) NOT NULL DEFAULT '0',
  `product` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `branch` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `module` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `plan` text,
  `source` varchar(20) NOT NULL,
  `sourceNote` varchar(255) NOT NULL,
  `fromBug` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `feedback` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'story',
  `category` varchar(30) NOT NULL DEFAULT 'feature',
  `pri` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `estimate` float unsigned NOT NULL,
  `status` enum('','changing','active','draft','closed','reviewing') NOT NULL DEFAULT '',
  `subStatus` varchar(30) NOT NULL DEFAULT '',
  `color` char(7) NOT NULL,
  `stage` enum('','wait','planned','projected','developing','developed','testing','tested','verified','released','closed') NOT NULL DEFAULT 'wait',
  `stagedBy` char(30) NOT NULL,
  `mailto` text,
  `lib` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fromStory` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fromVersion` smallint(6) NOT NULL DEFAULT '1',
  `openedBy` varchar(30) NOT NULL DEFAULT '',
  `openedDate` datetime NOT NULL,
  `assignedTo` varchar(30) NOT NULL DEFAULT '',
  `assignedDate` datetime NOT NULL,
  `approvedDate` date NOT NULL,
  `lastEditedBy` varchar(30) NOT NULL DEFAULT '',
  `lastEditedDate` datetime NOT NULL,
  `changedBy` VARCHAR(30) NOT NULL,
  `changedDate` DATETIME NOT NULL,
  `reviewedBy` varchar(255) NOT NULL,
  `reviewedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `closedBy` varchar(30) NOT NULL DEFAULT '',
  `closedDate` datetime NOT NULL,
  `closedReason` varchar(30) NOT NULL,
  `activatedDate` datetime NOT NULL,
  `toBug` mediumint(8) unsigned NOT NULL,
  `childStories` varchar(255) NOT NULL,
  `linkStories` varchar(255) NOT NULL,
  `linkRequirements` varchar(255) NOT NULL,
  `twins` varchar(255) NOT NULL,
  `duplicateStory` mediumint(8) unsigned NOT NULL,
  `version` smallint(6) NOT NULL DEFAULT '1',
  `storyChanged` enum('0','1') NOT NULL DEFAULT '0',
  `feedbackBy` varchar(100) NOT NULL,
  `notifyEmail` varchar(100) NOT NULL,
  `URChanged` enum('0','1') NOT NULL DEFAULT '0',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `status` (`status`),
  KEY `assignedTo` (`assignedTo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_storyestimate` (
  `story` mediumint(9) NOT NULL,
  `round` smallint(6) NOT NULL,
  `estimate` text NOT NULL,
  `average` float NOT NULL,
  `openedBy` varchar(30) NOT NULL,
  `openedDate` datetime NOT NULL,
  UNIQUE KEY `story` (`story`,`round`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_storyreview` (
  `story` mediumint(9) NOT NULL,
  `version` smallint(6) NOT NULL,
  `reviewer` varchar(30) NOT NULL,
  `result` varchar(30) NOT NULL,
  `reviewDate` datetime NOT NULL,
  UNIQUE KEY `story` (`story`,`version`,`reviewer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_storyspec` (
  `story` mediumint(9) NOT NULL,
  `version` smallint(6) NOT NULL,
  `title` varchar(255) NOT NULL,
  `spec` mediumtext NOT NULL,
  `verify` mediumtext NOT NULL,
  `files` text NOT NULL,
  UNIQUE KEY `story` (`story`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_storystage` (
  `story` mediumint(8) unsigned NOT NULL,
  `branch` mediumint(8) unsigned NOT NULL,
  `stage` varchar(50) NOT NULL,
  `stagedBy` char(30) NOT NULL,
  UNIQUE KEY `story_branch` (`story`,`branch`),
  KEY `story` (`story`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_suitecase` (
  `suite` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL,
  `case` mediumint(8) unsigned NOT NULL,
  `version` smallint(5) unsigned NOT NULL,
  UNIQUE KEY `suitecase` (`suite`,`case`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_task` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `parent` mediumint(8) NOT NULL DEFAULT '0',
  `execution` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `module` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `design` mediumint(8) unsigned NOT NULL,
  `story` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `storyVersion` smallint(6) NOT NULL DEFAULT '1',
  `designVersion` smallint(6) unsigned NOT NULL,
  `fromBug` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fromIssue` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `feedback` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `mode` varchar(10) NOT NULL,
  `pri` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `estimate` float unsigned NOT NULL,
  `consumed` float unsigned NOT NULL,
  `left` float unsigned NOT NULL,
  `deadline` date NOT NULL,
  `status` enum('wait','doing','done','pause','cancel','closed') NOT NULL DEFAULT 'wait',
  `subStatus` varchar(30) NOT NULL DEFAULT '',
  `color` char(7) NOT NULL,
  `mailto` text,
  `desc` mediumtext NOT NULL,
  `version` smallint(6) NOT NULL,
  `openedBy` varchar(30) NOT NULL,
  `openedDate` datetime NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `estStarted` date NOT NULL,
  `realStarted` datetime NOT NULL,
  `finishedBy` varchar(30) NOT NULL,
  `finishedDate` datetime NOT NULL,
  `finishedList` text NOT NULL,
  `canceledBy` varchar(30) NOT NULL,
  `canceledDate` datetime NOT NULL,
  `closedBy` varchar(30) NOT NULL,
  `closedDate` datetime NOT NULL,
  `planDuration` int(11) NOT NULL,
  `realDuration` int(11) NOT NULL,
  `closedReason` varchar(30) NOT NULL,
  `lastEditedBy` varchar(30) NOT NULL,
  `lastEditedDate` datetime NOT NULL,
  `activatedDate` datetime NOT NULL,
  `order` mediumint(8) NOT NULL DEFAULT 0,
  `repo` mediumint(8) unsigned NOT NULL,
  `mr` mediumint(8) unsigned NOT NULL,
  `entry` varchar(255) NOT NULL,
  `lines` varchar(10) NOT NULL,
  `v1` varchar(40) NOT NULL,
  `v2` varchar(40) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  PRIMARY KEY (`id`),
  KEY `execution` (`execution`),
  KEY `story` (`story`),
  KEY `parent` (`parent`),
  KEY `assignedTo` (`assignedTo`),
  KEY `order` (`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_taskestimate` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `task` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `left` float unsigned NOT NULL DEFAULT '0',
  `consumed` float unsigned NOT NULL,
  `account` char(30) NOT NULL DEFAULT '',
  `work` text,
  `order` tinyint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `task` (`task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_taskspec` (
  `task` mediumint(8) NOT NULL,
  `version` smallint(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `estStarted` date NOT NULL,
  `deadline` date NOT NULL,
  UNIQUE KEY `task` (`task`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_taskteam` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `task` mediumint(8) unsigned NOT NULL,
  `account` char(30) NOT NULL,
  `estimate` decimal(12,2) NOT NULL,
  `consumed` decimal(12,2) NOT NULL,
  `left` decimal(12,2) NOT NULL,
  `transfer` char(30) NOT NULL,
  `status` enum('wait','doing','done') NOT NULL DEFAULT 'wait',
  `order` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `task` (`task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_team` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `root` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `type` enum('project','task','execution') NOT NULL DEFAULT 'project',
  `account` char(30) NOT NULL DEFAULT '',
  `role` char(30) NOT NULL DEFAULT '',
  `position` varchar(30) NOT NULL,
  `limited` char(8) NOT NULL DEFAULT 'no',
  `join` date NOT NULL DEFAULT '0000-00-00',
  `days` smallint(5) unsigned NOT NULL,
  `hours` float(3,1) unsigned NOT NULL DEFAULT '0.0',
  `estimate` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `consumed` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `left` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `order` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `team` (`root`,`type`,`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_testreport` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL,
  `tasks` varchar(255) NOT NULL,
  `builds` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `owner` char(30) NOT NULL,
  `members` text NOT NULL,
  `stories` text NOT NULL,
  `bugs` text NOT NULL,
  `cases` text NOT NULL,
  `report` text NOT NULL,
  `objectType` varchar(20) NOT NULL,
  `objectID` mediumint(8) unsigned NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_testresult` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `run` mediumint(8) unsigned NOT NULL,
  `case` mediumint(8) unsigned NOT NULL,
  `version` smallint(5) unsigned NOT NULL,
  `job` mediumint(8) unsigned NOT NULL,
  `compile` mediumint(8) unsigned NOT NULL,
  `caseResult` char(30) NOT NULL,
  `stepResults` text NOT NULL,
  `lastRunner` varchar(30) NOT NULL,
  `date` datetime NOT NULL,
  `duration` float NOT NULL,
  `xml` text NOT NULL,
  `deploy` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `case` (`case`),
  KEY `version` (`version`),
  KEY `run` (`run`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_testrun` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `task` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `case` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `version` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `assignedTo` char(30) NOT NULL DEFAULT '',
  `lastRunner` varchar(30) NOT NULL,
  `lastRunDate` datetime NOT NULL,
  `lastRunResult` char(30) NOT NULL,
  `status` char(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `task` (`task`,`case`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_testsuite` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` mediumtext NOT NULL,
  `type` varchar(20) NOT NULL,
  `order` SMALLINT  UNSIGNED  NOT NULL  DEFAULT '0',
  `addedBy` char(30) NOT NULL,
  `addedDate` datetime NOT NULL,
  `lastEditedBy` char(30) NOT NULL,
  `lastEditedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product` (`product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_testtask` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `product` mediumint(8) unsigned NOT NULL,
  `name` char(90) NOT NULL,
  `execution` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `build` char(30) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `owner` varchar(30) NOT NULL,
  `pri` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `realFinishedDate` datetime NOT NULL,
  `mailto` text,
  `desc` mediumtext NOT NULL,
  `report` text NOT NULL,
  `status` enum('blocked','doing','wait','done') NOT NULL DEFAULT 'wait',
  `testreport` mediumint(8) unsigned NOT NULL,
  `auto` varchar(10) NOT NULL DEFAULT 'no',
  `subStatus` varchar(30) NOT NULL DEFAULT '',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `build` (`build`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `zt_ticket` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `product` mediumint(8) unsigned NOT NULL,
  `module` mediumint(8) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL,
  `desc` text NOT NULL,
  `openedBuild` varchar(255) NOT NULL,
  `feedback` mediumint(8) NOT NULL,
  `assignedTo` varchar(255) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `realStarted` datetime NOT NULL,
  `startedBy` varchar(255) NOT NULL,
  `startedDate` datetime NOT NULL,
  `deadline` date NOT NULL,
  `pri` tinyint unsigned NOT NULL DEFAULT '0',
  `estimate` float unsigned NOT NULL,
  `consumed` float unsigned NOT NULL,
  `left` float unsigned NOT NULL,
  `status` varchar(30) NOT NULL,
  `openedBy` varchar(30) NOT NULL,
  `openedDate` datetime NOT NULL,
  `activatedCount` int(10) NOT NULL,
  `activatedBy` varchar(30) NOT NULL,
  `activatedDate` datetime NOT NULL,
  `closedBy` varchar(30) NOT NULL,
  `closedDate` datetime NOT NULL,
  `closedReason` varchar(30) NOT NULL,
  `finishedBy` varchar(30) NOT NULL,
  `finishedDate` datetime NOT NULL,
  `resolvedBy` varchar(30) NOT NULL,
  `resolvedDate` datetime NOT NULL,
  `resolution` varchar(1000) NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `repeatTicket` mediumint(8) NOT NULL DEFAULT '0',
  `mailto` varchar(255) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  key `product` (`product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `zt_ticketsource` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ticketId` mediumint(8) unsigned NOT NULL,
  `customer` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `notifyEmail` varchar(100) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  key `ticketId` (`ticketId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_ticketrelation` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `ticketId` mediumint unsigned NOT NULL,
  `objectId` mediumint NOT NULL,
  `objectType` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ticketId` (`ticketId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_todo` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `date` date NOT NULL,
  `begin` smallint(4) unsigned zerofill NOT NULL,
  `end` smallint(4) unsigned zerofill NOT NULL,
  `feedback` mediumint(8) unsigned NOT NULL,
  `type` char(15) NOT NULL,
  `cycle` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `idvalue` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `pri` tinyint(3) unsigned NOT NULL,
  `name` char(150) NOT NULL,
  `desc` mediumtext NOT NULL,
  `status` enum('wait','doing','done','closed') NOT NULL DEFAULT 'wait',
  `private` tinyint(1) NOT NULL,
  `config` varchar(255) NOT NULL,
  `assignedTo` varchar(30) NOT NULL DEFAULT '',
  `assignedBy` varchar(30) NOT NULL DEFAULT '',
  `assignedDate` datetime NOT NULL,
  `finishedBy` varchar(30) NOT NULL DEFAULT '',
  `finishedDate` datetime NOT NULL,
  `closedBy` varchar(30) NOT NULL DEFAULT '',
  `closedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `assignedTo` (`assignedTo`),
  KEY `finishedBy` (`finishedBy`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_traincategory` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL DEFAULT '',
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `path` char(255) NOT NULL DEFAULT '',
  `grade` tinyint(3) NOT NULL,
  `order` mediumint(8) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  KEY `path` (`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_traincontents` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `course` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL,
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `path` char(255) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `order` mediumint(8) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_traincourse` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `category` mediumint(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  `teacher` varchar(30) NOT NULL DEFAULT '',
  `desc` mediumtext NOT NULL,
  `createdBy` varchar(255) NOT NULL,
  `createdDate` date NOT NULL,
  `editedBy` varchar(255) NOT NULL,
  `editedDate` date NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_trainplan` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `place` varchar(255) NOT NULL,
  `trainee` text NOT NULL,
  `lecturer` varchar(20) NOT NULL,
  `type` enum('inside','outside') NOT NULL DEFAULT 'inside',
  `status` varchar(20) NOT NULL,
  `summary` mediumtext NOT NULL,
  `createdBy` char(30) DEFAULT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_trainrecords` (
  `user` char(30) NOT NULL,
  `objectId` mediumint(8) unsigned NOT NULL,
  `objectType` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`user`,`objectId`,`objectType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_trip` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('trip','egress') NOT NULL DEFAULT 'trip',
  `customers` varchar(20) NOT NULL,
  `name` char(30) NOT NULL,
  `desc` text NOT NULL,
  `year` char(4) NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `start` time NOT NULL,
  `finish` time NOT NULL,
  `from` char(50) NOT NULL,
  `to` char(50) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `year` (`year`),
  KEY `createdBy` (`createdBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `company` mediumint(8) unsigned NOT NULL,
  `type` char(30) NOT NULL DEFAULT 'inside',
  `dept` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `account` char(30) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `role` char(10) NOT NULL DEFAULT '',
  `realname` varchar(100) NOT NULL DEFAULT '',
  `pinyin` varchar(255) NOT NULL DEFAULT '',
  `nickname` char(60) NOT NULL DEFAULT '',
  `commiter` varchar(100) NOT NULL,
  `avatar` text NOT NULL,
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `gender` enum('f','m') NOT NULL DEFAULT 'f',
  `email` char(90) NOT NULL DEFAULT '',
  `skype` char(90) NOT NULL DEFAULT '',
  `qq` char(20) NOT NULL DEFAULT '',
  `mobile` char(11) NOT NULL DEFAULT '',
  `phone` char(20) NOT NULL DEFAULT '',
  `weixin` varchar(90) NOT NULL DEFAULT '',
  `dingding` varchar(90) NOT NULL DEFAULT '',
  `slack` varchar(90) NOT NULL DEFAULT '',
  `whatsapp` varchar(90) NOT NULL DEFAULT '',
  `address` char(120) NOT NULL DEFAULT '',
  `zipcode` char(10) NOT NULL DEFAULT '',
  `nature` text NOT NULL,
  `analysis` text NOT NULL,
  `strategy` text NOT NULL,
  `join` date NOT NULL DEFAULT '0000-00-00',
  `visits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `visions` varchar(20) NOT NULL DEFAULT 'rnd,lite',
  `ip` char(15) NOT NULL DEFAULT '',
  `last` int(10) unsigned NOT NULL DEFAULT '0',
  `fails` tinyint(5) NOT NULL DEFAULT '0',
  `locked` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `feedback` enum('0','1') NOT NULL DEFAULT '0',
  `ranzhi` char(30) NOT NULL DEFAULT '',
  `ldap` char(30) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `scoreLevel` int(11) NOT NULL DEFAULT '0',
  `resetToken` varchar(50) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `clientStatus` enum('online','away','busy','offline','meeting') NOT NULL DEFAULT 'offline',
  `clientLang` varchar(10) NOT NULL DEFAULT 'zh-cn',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`),
  KEY `dept` (`dept`),
  KEY `email` (`email`),
  KEY `commiter` (`commiter`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_usercontact` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `listName` varchar(60) NOT NULL,
  `userList` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_usergroup` (
  `account` char(30) NOT NULL DEFAULT '',
  `group` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `project` text NOT NULL,
  UNIQUE KEY `account` (`account`,`group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_userquery` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `module` varchar(30) NOT NULL,
  `title` varchar(90) NOT NULL,
  `form` text NOT NULL,
  `sql` text NOT NULL,
  `shortcut` enum('0','1') NOT NULL DEFAULT '0',
  `common` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `module` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_usertpl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `type` char(30) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `public` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_userview` (
  `account` char(30) NOT NULL,
  `programs` mediumtext NOT NULL,
  `products` mediumtext NOT NULL,
  `projects` mediumtext NOT NULL,
  `sprints` mediumtext NOT NULL,
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_vm` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostID` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `osCategory` varchar(50) NOT NULL DEFAULT '',
  `osType` varchar(50) NOT NULL DEFAULT '',
  `osArch` varchar(50) NOT NULL DEFAULT '',
  `osLang` varchar(50) NOT NULL DEFAULT '',
  `osCpu` tinyint(2) NOT NULL DEFAULT 0,
  `osMemory` smallint(6) NOT NULL DEFAULT 0,
  `osDisk` smallint(6) NOT NULL DEFAULT 0,
  `status` varchar(50) NOT NULL DEFAULT '',
  `destroyAt` datetime DEFAULT NULL,
  `macAddress` varchar(255) NOT NULL DEFAULT '',
  `workspace` varchar(255) NOT NULL DEFAULT '',
  `templateID` int(10) unsigned NOT NULL DEFAULT '0',
  `baseImageID` int(10) unsigned NOT NULL DEFAULT '0',
  `baseImagePath` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `heatbeat` datetime DEFAULT NULL,
  `vncPort` int(10) NOT NULL DEFAULT 0,
  `instance` varchar(255) NOT NULL DEFAULT '',
  `eip` varchar(255) NOT NULL DEFAULT '',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `public` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_vmtemplate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `hostID` int(10) unsigned NOT NULL DEFAULT '0',
  `templateName` varchar(255) NOT NULL DEFAULT '',
  `osType` varchar(50) NOT NULL DEFAULT '',
  `osCategory` varchar(50) NOT NULL DEFAULT '',
  `osVersion` varchar(50) NOT NULL DEFAULT '',
  `osLang` varchar(50) NOT NULL,
  `cpuCoreNum` smallint(4) NOT NULL DEFAULT 0,
  `memorySize` int NOT NULL DEFAULT 0,
  `diskSize` int NOT NULL DEFAULT 0,
  `osArch` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_webhook` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(15) NOT NULL DEFAULT 'default',
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `contentType` varchar(30) NOT NULL DEFAULT 'application/json',
  `sendType` enum('sync','async') NOT NULL DEFAULT 'sync',
  `products` text NOT NULL,
  `executions` text NOT NULL,
  `params` varchar(100) NOT NULL,
  `actions` text NOT NULL,
  `desc` text NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_weeklyreport` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `weekStart` date NOT NULL,
  `pv` float(9,2) NOT NULL,
  `ev` float(9,2) NOT NULL,
  `ac` float(9,2) NOT NULL,
  `sv` float(9,2) NOT NULL,
  `cv` float(9,2) NOT NULL,
  `staff` smallint(5) unsigned NOT NULL,
  `progress` varchar(255) NOT NULL,
  `workload` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `week` (`project`,`weekStart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workestimation` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL,
  `scale` decimal(10,2) unsigned NOT NULL,
  `productivity` decimal(10,2) unsigned NOT NULL,
  `duration` decimal(10,2) unsigned NOT NULL,
  `unitLaborCost` decimal(10,2) unsigned NOT NULL,
  `totalLaborCost` decimal(10,2) unsigned NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `dayHour` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflow` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent` varchar(30) NOT NULL,
  `child` varchar(30) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'flow',
  `navigator` varchar(10) NOT NULL,
  `app` varchar(20) NOT NULL,
  `position` varchar(30) NOT NULL,
  `module` varchar(30) NOT NULL,
  `table` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `titleField` varchar(30) NOT NULL,
  `contentField` text NOT NULL,
  `flowchart` text NOT NULL,
  `js` text NOT NULL,
  `css` text NOT NULL,
  `order` smallint(5) unsigned NOT NULL,
  `buildin` tinyint(1) unsigned NOT NULL,
  `administrator` text NOT NULL,
  `desc` text NOT NULL,
  `version` varchar(10) NOT NULL DEFAULT '1.0',
  `status` varchar(10) NOT NULL DEFAULT 'wait',
  `approval` enum('enabled', 'disabled') NOT NULL DEFAULT 'disabled',
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`app`,`module`,`vision`),
  KEY `type` (`type`),
  KEY `app` (`app`),
  KEY `module` (`module`),
  KEY `order` (`order`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflowaction` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) NOT NULL,
  `action` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` enum('single','batch') NOT NULL DEFAULT 'single',
  `batchMode` enum('same','different') NOT NULL DEFAULT 'different',
  `extensionType` varchar(10) NOT NULL DEFAULT 'override' COMMENT 'none | extend | override',
  `open` varchar(20) NOT NULL,
  `position` enum('menu','browseandview','browse','view') NOT NULL DEFAULT 'browseandview',
  `layout` char(20) NOT NULL,
  `show` enum('dropdownlist','direct') NOT NULL DEFAULT 'dropdownlist',
  `order` smallint(5) unsigned NOT NULL,
  `buildin` tinyint(1) unsigned NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'custom',
  `virtual` tinyint(1) unsigned NOT NULL,
  `conditions` text NOT NULL,
  `verifications` text NOT NULL,
  `hooks` text NOT NULL,
  `linkages` text NOT NULL,
  `js` text NOT NULL,
  `css` text NOT NULL,
  `toList` char(255) NOT NULL,
  `blocks` text NOT NULL,
  `desc` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'enable',
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`module`,`action`,`vision`),
  KEY `module` (`module`),
  KEY `action` (`action`),
  KEY `order` (`order`)
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflowdatasource` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('system','sql','func','option','lang','category') NOT NULL DEFAULT 'option',
  `name` varchar(30) NOT NULL,
  `code` varchar(30) NOT NULL,
  `datasource` text NOT NULL,
  `view` varchar(20) NOT NULL,
  `keyField` varchar(50) NOT NULL,
  `valueField` varchar(50) NOT NULL,
  `buildin` tinyint(1) unsigned NOT NULL,
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflowfield` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) NOT NULL,
  `field` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'varchar',
  `length` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `control` varchar(20) NOT NULL,
  `expression` text NOT NULL,
  `options` text NOT NULL,
  `default` varchar(100) NOT NULL,
  `rules` varchar(255) NOT NULL,
  `placeholder` varchar(100) NOT NULL,
  `order` smallint(5) unsigned NOT NULL,
  `searchOrder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `exportOrder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `canExport` enum('0','1') NOT NULL DEFAULT '0',
  `canSearch` enum('0','1') NOT NULL DEFAULT '0',
  `isValue` enum('0','1') NOT NULL DEFAULT '0',
  `readonly` enum('0','1') NOT NULL DEFAULT '0',
  `buildin` tinyint(1) unsigned NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'custom',
  `desc` text NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`module`,`field`),
  KEY `module` (`module`),
  KEY `field` (`field`),
  KEY `order` (`order`)
) ENGINE=InnoDB AUTO_INCREMENT=360 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflowlabel` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) NOT NULL,
  `action` varchar(30) NOT NULL DEFAULT 'browse',
  `code` varchar(30) NOT NULL,
  `label` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `orderBy` text NOT NULL,
  `order` tinyint(3) NOT NULL,
  `buildin` tinyint(1) unsigned NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'custom',
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflowlayout` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) NOT NULL,
  `action` varchar(50) NOT NULL,
  `field` varchar(50) NOT NULL,
  `order` smallint(5) unsigned NOT NULL,
  `width` smallint(5) NOT NULL,
  `position` text NOT NULL,
  `readonly` enum('0','1') NOT NULL DEFAULT '0',
  `mobileShow` enum('0','1') NOT NULL DEFAULT '1',
  `summary` varchar(20) NOT NULL,
  `defaultValue` text NOT NULL,
  `layoutRules` varchar(255) NOT NULL,
  `vision` varchar(10) NOT NULL DEFAULT 'rnd',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`module`,`action`,`field`,`vision`),
  KEY `module` (`module`),
  KEY `action` (`action`),
  KEY `order` (`order`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflowlinkdata` (
  `objectType` varchar(30) NOT NULL,
  `objectID` mediumint(8) unsigned NOT NULL,
  `linkedType` varchar(30) NOT NULL,
  `linkedID` mediumint(8) unsigned NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  UNIQUE KEY `unique` (`objectType`,`objectID`,`linkedType`,`linkedID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflowrelation` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `prev` varchar(30) NOT NULL,
  `next` varchar(30) NOT NULL,
  `field` varchar(50) NOT NULL,
  `actions` varchar(20) NOT NULL,
  `actionCodes` text NOT NULL,
  `buildin` enum('0','1') NOT NULL DEFAULT '0',
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflowrelationlayout` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `prev` varchar(30) NOT NULL,
  `next` varchar(30) NOT NULL,
  `action` varchar(50) NOT NULL,
  `field` varchar(50) NOT NULL,
  `order` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`prev`,`next`,`action`,`field`),
  KEY `prev` (`prev`),
  KEY `next` (`next`),
  KEY `action` (`action`),
  KEY `order` (`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflowreport` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) NOT NULL COMMENT 'module name',
  `name` varchar(100) NOT NULL COMMENT 'report name',
  `type` enum('pie','line','bar') NOT NULL DEFAULT 'pie' COMMENT 'report type',
  `countType` enum('sum','count') NOT NULL DEFAULT 'sum' COMMENT 'report count method',
  `displayType` enum('value','percent') NOT NULL DEFAULT 'value' COMMENT 'report display method',
  `dimension` varchar(130) NOT NULL COMMENT 'dimension field code of zt_workflowfield',
  `fields` text NOT NULL COMMENT 'count fileds code of zt_workflowfield,use comma split',
  `order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflowrule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('system','regex','func') NOT NULL DEFAULT 'regex',
  `name` varchar(30) NOT NULL,
  `rule` text NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflowsql` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) NOT NULL,
  `field` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `sql` text NOT NULL,
  `vars` text NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`),
  KEY `field` (`field`),
  KEY `action` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_workflowversion` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) NOT NULL,
  `version` varchar(10) NOT NULL,
  `fields` text NOT NULL,
  `actions` text NOT NULL,
  `layouts` text NOT NULL,
  `sqls` text NOT NULL,
  `labels` text NOT NULL,
  `table` text NOT NULL,
  `datas` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `moduleversion` (`module`,`version`),
  KEY `module` (`module`),
  KEY `version` (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `zt_zoutput` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `activity` mediumint(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `optional` char(20) NOT NULL,
  `tailorNorm` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `order` mediumint(8) DEFAULT '0',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_dayactions` AS SELECT
 1 AS `actions`,
 1 AS `day`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_daybugopen` AS SELECT
 1 AS `bugopen`,
 1 AS `day`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_daybugresolve` AS SELECT
 1 AS `bugresolve`,
 1 AS `day`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_dayeffort` AS SELECT
 1 AS `consumed`,
 1 AS `date`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_daystoryclose` AS SELECT
 1 AS `storyclose`,
 1 AS `day`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_daystoryopen` AS SELECT
 1 AS `storyopen`,
 1 AS `day`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_daytaskfinish` AS SELECT
 1 AS `taskfinish`,
 1 AS `day`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_daytaskopen` AS SELECT
 1 AS `taskopen`,
 1 AS `day`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_dayuserlogin` AS SELECT
 1 AS `userlogin`,
 1 AS `day`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_executionsummary` AS SELECT
 1 AS `execution`,
 1 AS `estimate`,
 1 AS `consumed`,
 1 AS `left`,
 1 AS `number`,
 1 AS `undone`,
 1 AS `totalReal`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_productbugs` AS SELECT
 1 AS `product`,
 1 AS `bugs`,
 1 AS `resolutions`,
 1 AS `seriousBugs`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_productstories` AS SELECT
 1 AS `product`,
 1 AS `stories`,
 1 AS `undone`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_projectbugs` AS SELECT
 1 AS `execution`,
 1 AS `bugs`,
 1 AS `resolutions`,
 1 AS `seriousBugs`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_projectstories` AS SELECT
 1 AS `execution`,
 1 AS `stories`,
 1 AS `undone`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_projectsummary` AS SELECT
 1 AS `project`,
 1 AS `estimate`,
 1 AS `consumed`,
 1 AS `left`,
 1 AS `number`,
 1 AS `undone`,
 1 AS `totalReal`*/;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ztv_projectteams` AS SELECT
 1 AS `execution`,
 1 AS `teams`*/;
SET character_set_client = @saved_cs_client;
/*!50001 DROP VIEW IF EXISTS `view_datasource_10`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_datasource_10` AS select `zt_build`.`id` AS `id`,`zt_build`.`name` AS `name` from `zt_build` where (`zt_build`.`deleted` = '0') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_datasource_11`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_datasource_11` AS select `zt_module`.`id` AS `id`,`zt_module`.`name` AS `name` from `zt_module` where (`zt_module`.`deleted` = '0') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_datasource_12`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_datasource_12` AS select `zt_productplan`.`id` AS `id`,`zt_productplan`.`title` AS `title` from `zt_productplan` where (`zt_productplan`.`deleted` = '0') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_datasource_4`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_datasource_4` AS select `zt_story`.`id` AS `id`,`zt_story`.`title` AS `title` from `zt_story` where (`zt_story`.`deleted` = '0') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_datasource_41`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_datasource_41` AS select `zt_case`.`id` AS `id`,`zt_case`.`title` AS `title` from `zt_case` where (`zt_case`.`deleted` = '0') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_datasource_46`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_datasource_46` AS select `zt_task`.`id` AS `id`,`zt_task`.`name` AS `name` from `zt_task` where ((`zt_task`.`deleted` = '0') and (`zt_task`.`vision` = 'lite')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_datasource_5`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_datasource_5` AS select `zt_task`.`id` AS `id`,`zt_task`.`name` AS `name` from `zt_task` where ((`zt_task`.`deleted` = '0') and (`zt_task`.`vision` = 'rnd')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_datasource_6`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_datasource_6` AS select `zt_bug`.`id` AS `id`,`zt_bug`.`title` AS `title` from `zt_bug` where (`zt_bug`.`deleted` = '0') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_dayactions`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_dayactions` AS select count(0) AS `actions`,left(`zt_action`.`date`,10) AS `day` from `zt_action` group by left(`zt_action`.`date`,10) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_daybugopen`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_daybugopen` AS select count(0) AS `bugopen`,left(`zt_action`.`date`,10) AS `day` from `zt_action` where ((`zt_action`.`objectType` = 'bug') and (`zt_action`.`action` = 'opened')) group by left(`zt_action`.`date`,10) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_daybugresolve`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_daybugresolve` AS select count(0) AS `bugresolve`,left(`zt_action`.`date`,10) AS `day` from `zt_action` where ((`zt_action`.`objectType` = 'bug') and (`zt_action`.`action` = 'resolved')) group by left(`zt_action`.`date`,10) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_dayeffort`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_dayeffort` AS select round(sum(`zt_effort`.`consumed`),1) AS `consumed`,`zt_effort`.`date` AS `date` from `zt_effort` group by `zt_effort`.`date` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_daystoryclose`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_daystoryclose` AS select count(0) AS `storyclose`,left(`zt_action`.`date`,10) AS `day` from `zt_action` where ((`zt_action`.`objectType` = 'story') and (`zt_action`.`action` = 'closed')) group by left(`zt_action`.`date`,10) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_daystoryopen`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_daystoryopen` AS select count(0) AS `storyopen`,left(`zt_action`.`date`,10) AS `day` from `zt_action` where ((`zt_action`.`objectType` = 'story') and (`zt_action`.`action` = 'opened')) group by left(`zt_action`.`date`,10) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_daytaskfinish`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_daytaskfinish` AS select count(0) AS `taskfinish`,left(`zt_action`.`date`,10) AS `day` from `zt_action` where ((`zt_action`.`objectType` = 'task') and (`zt_action`.`action` = 'finished')) group by left(`zt_action`.`date`,10) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_daytaskopen`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_daytaskopen` AS select count(0) AS `taskopen`,left(`zt_action`.`date`,10) AS `day` from `zt_action` where ((`zt_action`.`objectType` = 'task') and (`zt_action`.`action` = 'opened')) group by left(`zt_action`.`date`,10) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_dayuserlogin`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_dayuserlogin` AS select count(0) AS `userlogin`,left(`zt_action`.`date`,10) AS `day` from `zt_action` where ((`zt_action`.`objectType` = 'user') and (`zt_action`.`action` = 'login')) group by left(`zt_action`.`date`,10) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_executionsummary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_executionsummary` AS select `zt_task`.`execution` AS `execution`,sum(if((`zt_task`.`parent` >= '0'),`zt_task`.`estimate`,0)) AS `estimate`,sum(if((`zt_task`.`parent` >= '0'),`zt_task`.`consumed`,0)) AS `consumed`,sum(if(((`zt_task`.`status` <> 'cancel') and (`zt_task`.`status` <> 'closed') and (`zt_task`.`parent` >= '0')),`zt_task`.`left`,0)) AS `left`,count(0) AS `number`,sum(if(((`zt_task`.`status` <> 'done') and (`zt_task`.`status` <> 'closed')),1,0)) AS `undone`,sum((if((`zt_task`.`parent` >= '0'),`zt_task`.`consumed`,0) + if(((`zt_task`.`status` <> 'cancel') and (`zt_task`.`status` <> 'closed') and (`zt_task`.`parent` >= '0')),`zt_task`.`left`,0))) AS `totalReal` from `zt_task` where (`zt_task`.`deleted` = '0') group by `zt_task`.`execution` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_productbugs`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_productbugs` AS select `zt_bug`.`product` AS `product`,count(0) AS `bugs`,sum(if((`zt_bug`.`resolution` = ''),0,1)) AS `resolutions`,sum(if((`zt_bug`.`severity` <= 2),1,0)) AS `seriousBugs` from `zt_bug` where (`zt_bug`.`deleted` = '0') group by `zt_bug`.`product` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_productstories`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_productstories` AS select `zt_story`.`product` AS `product`,count('*') AS `stories`,sum(if((`zt_story`.`status` = 'closed'),0,1)) AS `undone` from `zt_story` where (`zt_story`.`deleted` = '0') group by `zt_story`.`product` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_projectbugs`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_projectbugs` AS select `zt_bug`.`execution` AS `execution`,count(0) AS `bugs`,sum(if((`zt_bug`.`resolution` = ''),0,1)) AS `resolutions`,sum(if((`zt_bug`.`severity` <= 2),1,0)) AS `seriousBugs` from `zt_bug` where (`zt_bug`.`deleted` = '0') group by `zt_bug`.`execution` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_projectstories`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_projectstories` AS select `t1`.`project` AS `execution`,count('*') AS `stories`,sum(if((`t2`.`status` = 'closed'),0,1)) AS `undone` from ((`zt_projectstory` `t1` left join `zt_story` `t2` on((`t1`.`story` = `t2`.`id`))) left join `zt_project` `t3` on((`t1`.`project` = `t3`.`id`))) where ((`t2`.`deleted` = '0') and (`t3`.`type` in ('sprint','stage'))) group by `t1`.`project` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_projectsummary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_projectsummary` AS select `zt_task`.`project` AS `project`,sum(if((`zt_task`.`parent` >= '0'),`zt_task`.`estimate`,0)) AS `estimate`,sum(if((`zt_task`.`parent` >= '0'),`zt_task`.`consumed`,0)) AS `consumed`,sum(if(((`zt_task`.`status` <> 'cancel') and (`zt_task`.`status` <> 'closed') and (`zt_task`.`parent` >= '0')),`zt_task`.`left`,0)) AS `left`,count(0) AS `number`,sum(if(((`zt_task`.`status` <> 'done') and (`zt_task`.`status` <> 'closed')),1,0)) AS `undone`,sum((if((`zt_task`.`parent` >= '0'),`zt_task`.`consumed`,0) + if(((`zt_task`.`status` <> 'cancel') and (`zt_task`.`status` <> 'closed') and (`zt_task`.`parent` >= '0')),`zt_task`.`left`,0))) AS `totalReal` from `zt_task` where (`zt_task`.`deleted` = '0') group by `zt_task`.`project` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `ztv_projectteams`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ztv_projectteams` AS select `zt_team`.`root` AS `execution`,count('*') AS `teams` from `zt_team` where (`zt_team`.`type` = 'execution') group by `zt_team`.`root` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
