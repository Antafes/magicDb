<?php
namespace Model;

/**
 * Description of Color
 *
 * @author Neithan
 */
class Color
{
	protected $colorId;
	protected $color;

	public function loadByColorId($colorId)
	{
		$sql = '
			SELECT
				`colorId`,
				color
			FROM colors
			WHERE `colorId` = '.sqlval($colorId).'
		';
		$data = query($sql);

		$this->colorId = $data['colorId'];
		$this->color   = $data['color'];
	}

	public function getColorId()
	{
		return $this->colorId;
	}

	public function getColor()
	{
		return $this->color;
	}
}
