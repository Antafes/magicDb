<?php
namespace Model;

/**
 * Description of ColorList
 *
 * @author Neithan
 */
class ColorList
{
	/**
	 * @var array
	 */
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

	/**
	 * @return array
	 */
	public function getColors()
	{
		return $this->colors;
	}

	public function getColorsJson()
	{
		$colors = array();
		$translator = \Translator::getInstance();

		/** @var Color $color */
		foreach ($this->colors as $color)
		{
			$colors[$color->getColorId()] = $translator->getTranslation($color->getColor());
		}

		return json_encode($colors);
	}
}
