<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Add translations for some sub types';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (99, 1, "human", "Mensch", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (100, 2, "human", "Human", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (101, 1, "soldier", "Soldat", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (102, 2, "soldier", "Soldier", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (103, 1, "elemental", "Elementarwesen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (104, 2, "elemental", "Elemental", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (105, 1, "beast", "Bestie", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (106, 2, "beast", "Beast", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (107, 1, "giant", "Riese", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (108, 2, "giant", "Giant", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (109, 1, "warrior", "Krieger", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (110, 2, "warrior", "Warrior", 0)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (9, "human", 3)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (10, "soldier", 3)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (11, "elemental", 3)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (12, "beast", 3)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (13, "giant", 3)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (14, "warrior", 3)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			DELETE FROM translations WHERE `translationId` BETWEEN 99 AND 110
		');

		$results[] = query_raw('
			DELETE FROM types WHERE `typeId` BETWEEN 9 AND 14
		');

		return !in_array(false, $results);

	}

);