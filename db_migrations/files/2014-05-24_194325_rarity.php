<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Add rarity translations';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (41, 1, "rarity", "Seltenheit", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (42, 2, "rarity", "Rarity", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (43, 1, "common", "Gewöhnlich", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (44, 2, "common", "Common", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (45, 1, "uncommon", "Selten", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (46, 2, "uncommon", "Uncommon", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (47, 1, "rare", "Rar", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (48, 2, "rare", "Rare", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (49, 1, "mythicRare", "Mythisch", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (50, 2, "mythicRare", "Mythic", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$result = query_raw('
			DELETE FROM translations WHERE `translationId` BETWEEN 41 AND 50
		');

		return !!$result;

	}

);