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

	public function loadCards()
	{
		$sql = '
			SELECT `cardId`
			FROM cards
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
