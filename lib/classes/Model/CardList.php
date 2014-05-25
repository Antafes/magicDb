<?php
namespace Model;

/**
 * Description of CardList
 *
 * @author Neithan
 */
class CardList
{
	protected $cards = array();

	public function loadCards(array $filter = array(), array $sorting = array())
	{
		$whereClause = '';
		$joins = '';
		$orderBy = 'c.cardId ASC';

		if ($filter)
		{
			$whereClause .= 'WHERE ';
		}

		foreach ($filter as $key => $values)
		{
			if ($whereClause != 'WHERE ')
			{
				$whereClause .= ' AND ';
			}

			switch ($key) {
				case 'card':
					$whereClause .= '(c.nameDe LIKE "%'.sqlval($values, false).'%"';
					$whereClause .= ' OR c.nameEn LIKE "%'.sqlval($values, false).'%")';
					break;
				case 'rarities':
					$whereClause .= 'c.rarity IN('.implode(', ', sqlval($values)).')';
					break;
				case 'types':
					$joins .= 'JOIN type_to_card AS t2c USING (cardId) ';
					$whereClause .= 't2c.typeId IN ('.implode(', ', sqlval($values)).')';
					break;
				case 'colors':
					$joins .= 'JOIN color_to_card AS c2c USING (cardId) ';
					$whereClause .= 'c2c.colorId IN ('.implode(', ', sqlval($values)).')';
					break;
			}
		}

		if ($sorting)
		{
			$translator = \Translator::getInstance();

			if ($sorting['sort'] != 'type' && $sorting['sort'] != 'color' && $sorting['sort'] != 'rarity')
			{
				$orderBy = 'c.'.sqlval($sorting['sort'], false).' '.sqlval($sorting['order'], false);
			}
			elseif ($sorting['sort'] == 'type')
			{
				if (!strpos($joins, 'type_to_card'))
				{
					$joins .= 'JOIN type_to_card AS t2c USING (cardId) ';
				}

				$joins .= 'JOIN types AS t on (t.typeId = t2c.typeId AND !t.parent) ';
				$joins .= 'JOIN translations AS tr ON (tr.key = t.name AND tr.languageId = '
					.sqlval($translator->getCurrentLanguage()).')';
				$orderBy = 'tr.value '.sqlval($sorting['order'], false);

			}
			elseif ($sorting['sort'] == 'color')
			{
				if (!strpos($joins, 'color_to_card'))
				{
					$joins .= 'JOIN color_to_card AS c2c USING (cardId) ';
				}

				$joins .= 'JOIN colors AS co USING (colorId) ';
				$joins .= 'JOIN translations AS tr ON (tr.key = co.name AND tr.languageId = '
					.sqlval($translator->getCurrentLanguage()).')';
				$orderBy = 'tr.value '.sqlval($sorting['order'], false);
			}
			elseif ($sorting['sort'] == 'rarity')
			{
				$joins .= 'JOIN translations AS tr ON (tr.key = c.rarity AND tr.languageId = '
					.sqlval($translator->getCurrentLanguage()).')';
			}
		}

		$sql = '
			SELECT DISTINCT c.`cardId`
			FROM cards AS c
			'.$joins.'
			'.$whereClause.'
			ORDER BY '.$orderBy.'
		';
		$data = query($sql, true);

		foreach ($data as $row)
		{
			$card = new Card();
			$card->loadByCardId($row['cardId']);
			$this->cards[] = $card;
		}
	}

	public function getCards()
	{
		return $this->cards;
	}
}
