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
		$this->loadCards();
	}

	protected function loadCards()
	{
		$cardList = new \Model\CardList();
		$cardList->loadCards();
		$this->template->assign('cardList', $cardList);
	}
}
