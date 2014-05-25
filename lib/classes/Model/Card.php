<?php
namespace Model;

/**
 * Description of Card
 *
 * @author Neithan
 */
class Card
{
	protected $cardId;
	protected $nameDe;
	protected $nameEn;
	protected $rarity;
	protected $amount;
	protected $foiled;
	protected $types;
	protected $colors;

	public static function create($nameDe, $nameEn, $rarity, $amount, $foiled, $types, $colors)
	{
		$sql = '
			INSERT INTO cards
			SET nameDe = '.sqlval($nameDe).',
				nameEn = '.sqlval($nameEn).',
				rarity = '.sqlval($rarity).',
				amount = '.sqlval($amount).',
				foiled = '.sqlval($foiled).'
		';
		$cardId = query($sql);

		$sql = '
			INSERT INTO type_to_card (`cardId`, `typeId`, sorting)
			VALUES ';

		foreach ($types as $type)
		{
			$sql .= '('.sqlval($cardId).', '.sqlval($type['id']).', '.sqlval($type['sorting']).'), ';
		}

		query(substr($sql, 0, -2));

		$sql = '
			INSERT INTO color_to_card (`cardId`, `colorId`)
			VALUES ';

		foreach ($colors as $color)
		{
			$sql .= '('.sqlval($cardId).', '.sqlval($color).'), ';
		}

		query(substr($sql, 0, -2));
	}

	public function loadByCardId($cardId)
	{
		$sql = '
			SELECT
				cardId,
				nameDe,
				nameEn,
				rarity,
				amount,
				foiled
			FROM cards
			WHERE `cardId` = '.sqlval($cardId).'
		';
		$data = query($sql);

		$this->cardId = $data['cardId'];
		$this->nameDe = $data['nameDe'];
		$this->nameEn = $data['nameEn'];
		$this->rarity = $data['rarity'];
		$this->amount = $data['amount'];
		$this->foiled = $data['foiled'];
		$this->loadTypes();
		$this->loadColors();
	}

	protected function loadTypes()
	{
		$sql = '
			SELECT `typeId`
			FROM type_to_card
			WHERE `cardId` = '.sqlval($this->cardId).'
			ORDER BY sorting
		';
		$types = query($sql, true);

		if ($types)
		{
			foreach ($types as $type)
			{
				$typeObject = new Type();
				$typeObject->loadByTypeId($type['typeId']);
				$this->types[] = $typeObject;
			}
		}
	}

	protected function loadColors()
	{
		$sql = '
			SELECT `colorId`
			FROM color_to_card
			WHERE `cardId` = '.sqlval($this->cardId).'
		';
		$colors = query($sql, true);

		foreach ($colors as $color)
		{
			$colorObject = new Color();
			$colorObject->loadByColorId($color['colorId']);
			$this->colors[] = $colorObject;
		}
	}

	public function getCardId()
	{
		return $this->cardId;
	}

	public function getNameDe()
	{
		return $this->nameDe;
	}

	public function getNameEn()
	{
		return $this->nameEn;
	}

	public function getRarity()
	{
		return $this->rarity;
	}

	public function getAmount()
	{
		return $this->amount;
	}

	public function getFoiled()
	{
		return $this->foiled;
	}

	public function getType()
	{
		if (!$this->types)
		{
			return '';
		}

		$translator = \Translator::getInstance();
		$type = $translator->getTranslation($this->getMainType()->getName());
		$subTypes = array();

		foreach ($this->getSubTypes() as $subType)
		{
			$subTypes[] = $translator->getTranslation($subType->getName());
		}

		if ($subTypes)
		{
			$type .= ' - '.implode(', ', $subTypes);
		}

		return $type;
	}

	/**
	 * @return Type
	 */
	public function getMainType()
	{
		foreach ($this->types as $type)
		{
			if (!$type->getParent())
			{
				return $type;
			}
		}
	}

	/**
	 * @return Type
	 */
	public function getSubTypes()
	{
		$subTypes = array();

		foreach ($this->types as $type)
		{
			if ($type->getParent())
			{
				$subTypes[] = $type;
			}
		}

		return $subTypes;
	}

	public function getColor()
	{
		$translator = \Translator::getInstance();
		$colors = '';

		foreach ($this->colors as $color)
		{
			$colors .= $translator->getTranslation($color->getColor()).', ';
		}

		return substr($colors, 0, -2);
	}
}
