<?php
namespace Model;

/**
 * Description of Card
 *
 * @author Neithan
 */
class Card
{
	/**
	 * @var integer
	 */
	protected $cardId;

	/**
	 * @var string
	 */
	protected $nameDe;

	/**
	 * @var string
	 */
	protected $nameEn;

	/**
	 * @var string
	 */
	protected $rarity;

	/**
	 * @var integer
	 */
	protected $amount;

	/**
	 * @var integer
	 */
	protected $foiled;

	/**
	 * @var array
	 */
	protected $types;

	/**
	 * @var array
	 */
	protected $colors;

	/**
	 *
	 * @param string  $nameDe
	 * @param string  $nameEn
	 * @param string  $rarity
	 * @param integer $amount
	 * @param integer $foiled
	 * @param array   $types
	 * @param array   $colors
	 */
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

	/**
	 * @param integer $cardId
	 */
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

	/**
	 * @return integer
	 */
	public function getCardId()
	{
		return $this->cardId;
	}

	/**
	 * @return string
	 */
	public function getNameDe()
	{
		return $this->nameDe;
	}

	/**
	 * @return string
	 */
	public function getNameEn()
	{
		return $this->nameEn;
	}

	/**
	 * @return string
	 */
	public function getRarity()
	{
		return $this->rarity;
	}

	/**
	 * @return integer
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @return integer
	 */
	public function getFoiled()
	{
		return $this->foiled;
	}

	/**
	 * @return string
	 */
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

	/**
	 * @return string
	 */
	public function getTypeJson()
	{
		if (!$this->types)
		{
			return json_encode(array());
		}

		$types = array();
		$types['mainType'] = $this->getMainType()->getTypeId();
		$types['subTypes'] = array();

		/** @var Type $subType */
		foreach ($this->getSubTypes() as $subType)
		{
			$types['subTypes'][] = $subType->getTypeId();
		}

		return json_encode($types);
	}

	/**
	 * @return string
	 */
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

	/**
	 * @return string
	 */
	public function getColorIds()
	{
		$colorIds = '';

		/** @var Color $color */
		foreach ($this->colors as $color)
		{
			$colorIds .= $color->getColorId().'-';
		}

		return substr($colorIds, 0, -1);
	}

	public function update($nameDe, $nameEn, $types, $colors, $rarity, $amount, $foiled)
	{
		$sql = '
			UPDATE cards
			SET `nameDe` = '.sqlval($nameDe).',
				`nameEn` = '.sqlval($nameEn).',
				rarity = '.sqlval($rarity).',
				amount = '.sqlval($amount).',
				foiled = '.sqlval($foiled).'
			WHERE `cardId` = '.sqlval($this->cardId).'
		';
		query($sql);
		$this->nameDe = $nameDe;
		$this->nameEn = $nameEn;
		$this->rarity = $rarity;
		$this->amount = $amount;
		$this->foiled = $foiled;
		$this->updateColors($colors);
		$this->updateTypes($types);
	}

	/**
	 * @param array $colors
	 */
	protected function updateColors($colors)
	{
		$sql = '
			DELETE FROM color_to_card
			WHERE `cardId` = '.sqlval($this->cardId).'
		';
		query($sql);

		$sql = '
			INSERT INTO color_to_card (`cardId`, `colorId`)
			VALUES';

		foreach ($colors as $color)
		{
			$sql .= ' ('.sqlval($this->cardId).', '.sqlval($color).')';
		}

		query($sql);
		unset($this->colors);
		$this->loadColors();
	}

	protected function updateTypes($types)
	{
		$sql = '
			DELETE FROM type_to_card
			WHERE `cardId` = '.sqlval($this->cardId).'
		';
		query($sql);

		$sql = '
			INSERT INTO type_to_card (`cardId`, `typeId`, sorting)
			VALUES';

		foreach ($types as $type)
		{
			$sql .= '('.sqlval($this->cardId).', '.sqlval($type['id']).', '.sqlval($type['sorting'])
				.')';
		}

		query($sql);
		unset($this->types);
		$this->loadTypes();
	}
}
