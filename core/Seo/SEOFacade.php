<?php
namespace Core\Seo;

use Illuminate\Support\Facades\Facade;

class SEOFacade extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'seo'; }

}