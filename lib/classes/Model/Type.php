<?php
namespace Model;

/**
 * Description of Type
 *
 * @author Neithan
 */
class Type
{
	protected $typeId;
	protected $name;
	protected $parent;

	/**
	 * @param string  $name
	 * @param integer $parent
	 * @return \self
	 */
	public static function create($name, $parent)
	{
		$sql = '
			INSERT INTO types
			SET name = '.sqlval($name).',
				parent = '.sqlval($parent).'
		';
		$typeId = query($sql);
		$type = new self();
		$type->loadByTypeId($typeId);

		return $type;
	}

	/**
	 * @param integer $typeId
	 */
	public function loadByTypeId($typeId)
	{
		$sql = '
			SELECT
				`typeId`,
				`name`,
				parent
			FROM types
			WHERE `typeId` = '.sqlval($typeId).'
		';
		$data = query($sql);

		$this->typeId = $data['typeId'];
		$this->name   = $data['name'];
		$this->parent = $data['parent'];
	}

	/**
	 * @return integer
	 */
	public function getTypeId()
	{
		return (int) $this->typeId;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getParent()
	{
		return $this->parent;
	}
}
