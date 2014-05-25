<?php
namespace Page;

/**
 * Description of EsHeader
 *
 * @author Neithan
 */
class Header extends \Page
{
	/**
	 * @param \Template $template
	 */
	public function __construct($template)
	{
		$this->template = $template;
	}

	public function process()
	{
		// Add CSS files
		$this->template->loadCss('header');
		$this->template->loadCss('common');
		$this->template->loadCss('main');
		$this->template->loadCss('jquery-ui-1.10.3.custom');

		// Add JS files
		$this->template->loadJs('jquery-2.0.3');
		$this->template->loadJs('jquery-ui-1.10.3.custom');
		$this->template->loadJs('header');
	}
}
