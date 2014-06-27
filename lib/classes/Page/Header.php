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
		$this->template->loadCss('jquery-ui-1.11.0.custom');

		// Add JS files
		$this->template->loadJs('jquery-2.1.1');
		$this->template->loadJs('jquery-ui-1.11.0.custom');
		$this->template->loadJs('header');
	}
}
