<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Add amount translations';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (51, 1, "amount", "Menge", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (52, 2, "amount", "Amount", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (53, 1, "normal", "Normal", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (54, 2, "normal", "Normal", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (55, 1, "foiled", "Foiled", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (56, 2, "foiled", "Foiled", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$result = query_raw('
			DELETE FROM translations WHERE `translationId` BETWEEN 50 AND 56
		');

		return !!$result;

	}

);