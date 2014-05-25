<?php
namespace Model;

/**
 * Description of TypeList
 *
 * @author Neithan
 */
class TypeList
{
	protected $typeList = array();

	public function loadTypes()
	{
		$translator = \Translator::getInstance();
		$sql = '
			SELECT t.`typeId`
			FROM types AS t
			JOIN translations AS tr ON (tr.`key` = t.`name`)
			WHERE tr.`languageId` = '.sqlval($translator->getCurrentLanguage()).'
			ORDER BY tr.`value`
		';
		$data = query($sql, true);

		foreach ($data as $row)
		{
			$type = new Type();
			$type->loadByTypeId($row['typeId']);
			$this->typeList[] = $type;
		}
	}

	public function getTypeList()
	{
		$types = array();

		foreach ($this->typeList as $type)
		{
			if (!$type->getParent())
			{
				$types[] = array(
					'main' => $type,
					'sub'  => $this->getSubTypes($type->getTypeId()),
				);
			}
		}

		return $types;
	}

	public function getSubTypes($parentId)
	{
		$subTypes = array();

		foreach ($this->typeList as $type)
		{
			if ($type->getParent() == $parentId)
			{
				$subTypes[] = $type;
			}
		}

		return $subTypes;
	}

	public function getAsArray()
	{
		$translator = \Translator::getInstance();
		$types = array();

		foreach ($this->typeList as $type)
		{
			if (!$type->getParent())
			{
				$typeArray = array(
					'main' => array(
						'id'   => $type->getTypeId(),
						'key'  => $type->getName(),
						'name' => $translator->getTranslation($type->getName()),
					),
				);
				$subTypeArray = $this->getSubTypesAsArray($type->getTypeId());

				if ($subTypeArray)
				{
					$typeArray['sub'] = $subTypeArray;
				}

				$types[] = $typeArray;
			}
		}

		return $types;
	}

	public function getSubTypesAsArray($parentId)
	{
		$translator = \Translator::getInstance();
		$subTypes = array();

		foreach ($this->typeList as $type)
		{
			if ($type->getParent() == $parentId)
			{
				$subTypes[] = array(
					'id'   => $type->getTypeId(),
					'name' => $translator->getTranslation($type->getName()),
				);
			}
		}

		return $subTypes;
	}
}
