<?php
namespace Page;

/**
 * Description of Index
 *
 * @author Neithan
 */
class Index extends \Page
{
	public function __construct()
	{
		parent::__construct('index');
	}

	public function process()
	{
		$filter = array();

		if ($_GET['search'])
		{
			if ($_GET['card'])
			{
				$filter['card'] = $_GET['card'];
			}

			if ($_GET['types'])
			{
				$filter['types'] = $_GET['types'];
			}

			if ($_GET['colors'])
			{
				$filter['colors'] = $_GET['colors'];
			}

			if ($_GET['rarity'])
			{
				$filter['rarity'] = $_GET['rarity'];
			}
		}

		$this->loadCards($filter);
	}

	protected function loadCards(array $filter)
	{
		$cardList = new \Model\CardList();
		$cardList->loadCards($filter);
		$this->template->assign('cardList', $cardList);
		$typeList = new \Model\TypeList();
		$typeList->loadTypes();
		$this->template->assign('typeList', $typeList);
		$colorList = new \Model\ColorList();
		$colorList->loadColors();
		$this->template->assign('colorList', $colorList);
	}
}
