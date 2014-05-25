<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Add basic types';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (1, "instant", 0)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (2, "sorcery", 0)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (3, "creature", 0)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (4, "enchantmentCreature", 0)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (5, "tribalEnchantment", 0)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (6, "enchantment", 0)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (7, "artifact", 0)
		');

		$results[] = query_raw('
			INSERT INTO `types` (`typeId`, `name`, `parent`) VALUES (8, "equipment", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (23, 1, "type", "Typ", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (24, 2, "type", "Type", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (25, 1, "instant", "Spontanzauber", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (26, 2, "instant", "Instant", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (27, 1, "sorcery", "Hexerei", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (28, 2, "sorcery", "Sorcery", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (29, 1, "creature", "Kreatur", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (30, 2, "creature", "Creature", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (31, 1, "enchantmentCreature", "Verzauberungskreatur", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (32, 2, "enchantmentCreature", "Enchantment Creature", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (33, 1, "tribalEnchantment", "Stammesverzauberung", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (34, 2, "tribalEnchantment", "Tribal Enchantment", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (35, 1, "enchantment", "Verzauberung", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (36, 2, "enchantment", "Enchantment", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (37, 1, "artifact", "Artefakt", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (38, 2, "artifact", "Artifact", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (39, 1, "equipment", "Ausrüstung", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (40, 2, "equipment", "Equipment", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			DELETE FROM translations WHERE `translationId` BETWEEN 23 AND 40
		');

		$results[] = query_raw('
			TRUNCATE TABLE types
		');

		return !in_array(false, $results);

	}

);