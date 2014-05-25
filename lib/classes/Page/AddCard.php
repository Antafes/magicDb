<?php
namespace Page;

/**
 * Description of AddCard
 *
 * @author Neithan
 */
class AddCard extends \Page
{
	public function __construct()
	{
		parent::__construct('addCard');
	}

	public function process()
	{
		if ($_POST['createCard'])
		{
			$this->createCard(
				$_POST['cardNameDe'], $_POST['cardNameEn'], $_POST['types'], $_POST['rarity'],
				$_POST['colors'], $_POST['amount'], $_POST['foiled'], $_POST['createCard']
			);
		}

		$typeList = new \Model\TypeList();
		$typeList->loadTypes();
		$this->template->assign('typeList', json_encode($typeList->getAsArray()));
		$colorList = new \Model\ColorList();
		$colorList->loadColors();
		$this->template->assign('colorList', $colorList);

		$this->template->loadJs('addCard');
		$this->template->loadJs('jquery.sortableTypes');
	}

	protected function createCard($cardNameDe, $cardNameEn, $types, $rarity, $colors, $amount, $foiled,
		$salt)
	{
		if (!$salt || $salt != $_SESSION['formSalts']['createCard'])
			return;

		if (!$cardNameDe || !$cardNameEn || !$types || !$rarity ||!$colors || !isset($amount)
			|| !is_numeric($amount)|| !isset($foiled) || !is_numeric($foiled))
		{
			return;
		}

		$preparedTypes = array();
		foreach (explode('-', $types) as $key => $type)
		{
			$preparedTypes[] = array(
				'id'      => $type,
				'sorting' => $key,
			);
		}

		\Model\Card::create($cardNameDe, $cardNameEn, $rarity, $amount, $foiled, $preparedTypes, $colors);

		redirect('index.php?page=AddCard');
	}
}
