<?php
/**
 * Gravatar Facade for Laravel 5.0.
 *
 * @author    MyBB Group
 * @version   2.0.0
 * @package   mybb/gravatar
 * @copyright Copyright (c) 2015, MyBB Group
 * @license   http://www.mybb.com/licenses/bsd3 BSD-3
 * @link      http://www.mybb.com
 */

namespace MyBB\Gravatar\Facades;

use Illuminate\Support\Facades\Facade;

class GravatarFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'gravatar';
	}
}
