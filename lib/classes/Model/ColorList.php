<?php
namespace Model;

/**
 * Description of ColorList
 *
 * @author Neithan
 */
class ColorList
{
	protected $colors = array();

	public function loadColors()
	{
		$sql = '
			SELECT `colorId`
			FROM colors
		';
		$data = query($sql, true);

		foreach ($data as $row)
		{
			$color = new Color();
			$color->loadByColorId($row['colorId']);
			$this->colors[] = $color;
		}
	}

	public function getColors()
	{
		return $this->colors;
	}
}
