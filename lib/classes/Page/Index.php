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
		$filter  = array();
		$sorting = array();

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

		if ($_GET['sort'])
		{
			$sorting['sort']  = $_GET['sort'];
			$sorting['order'] = $_GET['order'];
		}

		$this->loadCards($filter, $sorting);
		$this->template->loadJs('jquery.editRow');
		$this->template->loadJs('jquery.sortableTypes');
		$this->template->loadJs('index');
	}

	protected function loadCards(array $filter, array $sorting)
	{
		$cardList = new \Model\CardList();
		$cardList->loadCards($filter, $sorting);
		$this->template->assign('cardList', $cardList);
		$typeList = new \Model\TypeList();
		$typeList->loadTypes();
		$this->template->assign('typeList', $typeList);
		$colorList = new \Model\ColorList();
		$colorList->loadColors();
		$this->template->assign('colorList', $colorList);
	}
}
