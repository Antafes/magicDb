<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Initial tables';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			CREATE TABLE languages (
				languageId INT UNSIGNED NOT NULL AUTO_INCREMENT,
				language VARCHAR(255) NOT NULL COLLATE "utf8_general_ci",
				iso2code CHAR(2) NOT NULL COLLATE "utf8_bin",
				deleted TINYINT(1) NOT NULL,
				PRIMARY KEY (`languageId`)
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			CREATE TABLE translations (
				translationId INT UNSIGNED NOT NULL AUTO_INCREMENT,
				languageId INT UNSIGNED NOT NULL,
				`key` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci",
				`value` TEXT NOT NULL COLLATE "utf8_general_ci",
				deleted TINYINT(1) NOT NULL,
				PRIMARY KEY (`translationId`)
			)
			COLLATE="utf8_bin"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			CREATE TABLE `cards` (
				`cardId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`nameDe` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci",
				`nameEn` VARCHAR(255) NOT NULL COLLATE "utf8_general_ci",
				`rarity` ENUM("common","uncommon","rare","mythicRare") NOT NULL DEFAULT "common",
				`amount` INT NOT NULL,
				`foiled` INT NOT NULL,
				PRIMARY KEY (`cardId`),
				UNIQUE INDEX `nameDe` (`nameDe`),
				UNIQUE INDEX `nameEn` (`nameEn`)
			)
			COLLATE="utf8_general_ci"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			CREATE TABLE `colors` (
				`colorId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`color` VARCHAR(255) NOT NULL,
				PRIMARY KEY (`colorId`)
			)
			COLLATE="utf8_general_ci"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			CREATE TABLE `color_to_card` (
				`cardId` INT UNSIGNED NOT NULL,
				`colorId` INT UNSIGNED NOT NULL,
				PRIMARY KEY (`cardId`, `colorId`),
				CONSTRAINT `cardIdColor` FOREIGN KEY (`cardId`) REFERENCES `cards` (`cardId`) ON UPDATE CASCADE ON DELETE CASCADE,
				CONSTRAINT `colorId` FOREIGN KEY (`colorId`) REFERENCES `colors` (`colorId`) ON UPDATE CASCADE ON DELETE CASCADE
			)
			COLLATE="utf8_general_ci"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			CREATE TABLE `types` (
				`typeId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(255) NOT NULL,
				`parent` INT UNSIGNED NOT NULL,
				PRIMARY KEY (`typeId`),
				INDEX `parent` (`parent`)
			)
			COLLATE="utf8_general_ci"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			CREATE TABLE `type_to_card` (
				`cardId` INT UNSIGNED NOT NULL,
				`typeId` INT UNSIGNED NOT NULL,
				`sorting` INT NOT NULL,
				PRIMARY KEY (`cardId`, `typeId`),
				CONSTRAINT `cardIdType` FOREIGN KEY (`cardId`) REFERENCES `cards` (`cardId`) ON UPDATE CASCADE ON DELETE CASCADE,
				CONSTRAINT `typeId` FOREIGN KEY (`typeId`) REFERENCES `types` (`typeId`) ON UPDATE CASCADE ON DELETE CASCADE
			)
			COLLATE="utf8_general_ci"
			ENGINE=InnoDB
		');

		$results[] = query_raw('
			INSERT INTO languages (languageId, language, iso2code)
			VALUES (1, "german", "de"), (2, "english", "en")
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (1, 1, "german", "Deutsch", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (2, 2, "german", "Deutsch", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (3, 1, "english", "English", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (4, 2, "english", "English", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (5, 1, "title", "Magic the Gathering Kartendatenbank", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (6, 2, "title", "Magic the Gather card database", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (7, 1, "index", "Startseite", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (8, 2, "index", "Index", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			DROP TABLE `type_to_card`
		');

		$results[] = query_raw('
			DROP TABLE `color_to_card`
		');

		$results[] = query_raw('
			DROP TABLE `cards`
		');

		$results[] = query_raw('
			DROP TABLE `colors`
		');

		$results[] = query_raw('
			DROP TABLE `types`
		');

		$results[] = query_raw('
			DROP TABLE `translations`
		');

		$results[] = query_raw('
			DROP TABLE `languages`
		');

		return !in_array(false, $results);

	}

);