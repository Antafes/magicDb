<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Add colors';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			INSERT INTO `colors` (`colorId`, `color`) VALUES (1, "none")
		');

		$results[] = query_raw('
			INSERT INTO `colors` (`colorId`, `color`) VALUES (2, "red")
		');

		$results[] = query_raw('
			INSERT INTO `colors` (`colorId`, `color`) VALUES (3, "blue")
		');

		$results[] = query_raw('
			INSERT INTO `colors` (`colorId`, `color`) VALUES (4, "white")
		');

		$results[] = query_raw('
			INSERT INTO `colors` (`colorId`, `color`) VALUES (5, "black")
		');

		$results[] = query_raw('
			INSERT INTO `colors` (`colorId`, `color`) VALUES (6, "green")
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (9, 1, "color", "Farbe", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (10, 2, "color", "Color", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (11, 1, "none", "Keine", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (12, 2, "none", "None", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (13, 1, "red", "Rot", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (14, 2, "red", "Red", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (15, 1, "blue", "Blau", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (16, 2, "blue", "Blue", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (17, 1, "white", "Weiß", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (18, 2, "white", "White", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (19, 1, "black", "Schwarz", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (20, 2, "black", "Black", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (21, 1, "green", "Grün", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (22, 2, "green", "Green", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			DELETE FROM translations WHERE `translationId` BETWEEN 9 AND 22
		');

		$results[] = query_raw('
			TRUNCATE TABLE colors
		');

		return !in_array(false, $results);

	}

);