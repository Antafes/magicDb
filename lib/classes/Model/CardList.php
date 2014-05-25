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

	public function loadCards(array $filter = array())
	{
		$whereClause = '';
		$joins = '';

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

		$sql = '
			SELECT DISTINCT c.`cardId`
			FROM cards AS c
			'.$joins.'
			'.$whereClause.'
			ORDER BY `cardId`
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
