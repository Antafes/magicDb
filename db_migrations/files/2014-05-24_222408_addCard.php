<?php

$DB_MIGRATION = array(

	'description' => function () {
		return 'Add translations for adding cards';
	},

	'up' => function ($migration_metadata) {

		$results = array();

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (57, 1, "addCard", "Karte hinzufügen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (58, 2, "addCard", "Add Card", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (81, 1, "card", "Karte", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (82, 2, "card", "Card", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (83, 1, "cardNameDe", "Kartenname Deutsch", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (84, 2, "cardNameDe", "Card name German", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (85, 1, "cardNameEn", "Kartenname Englisch", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (86, 2, "cardNameEn", "Card name English", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (87, 1, "createType", "neuen Typ erstellen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (88, 2, "createType", "Create new type", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (89, 1, "createCard", "neue Karte anlegen", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (90, 2, "createCard", "create new card", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (91, 1, "parentType", "Elterntyp", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (92, 2, "parentType", "Parent type", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (93, 1, "typeKey", "Typschlüssel (englisch, z.B. tribalEnchantment)", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (94, 2, "typeKey", "Type key (english, e.g. tribalEnchantment)", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (95, 1, "typeNameDe", "Typ Deutsch", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (96, 2, "typeNameDe", "Type German", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (97, 1, "typeNameEn", "Typ Englisch", 0)
		');

		$results[] = query_raw('
			INSERT INTO `translations` (`translationId`, `languageId`, `key`, `value`, `deleted`) VALUES (98, 2, "typeNameEn", "Type English", 0)
		');

		return !in_array(false, $results);

	},

	'down' => function ($migration_metadata) {

		$result = query_raw('
			DELETE FROM translations WHERE `translationId` BETWEEN 57 AND 98
		');

		return !!$result;

	}

);