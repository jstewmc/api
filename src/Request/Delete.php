<?php

namespace Jstewmc\Api\Request;

/**
 * A DELETE request
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Delete extends Request
{
	/* !Protected properties */
	
	/**
	 * @var  string  the request's http method
	 * @since  0.1.0
	 */
	protected $method = self::METHOD_DELETE;	
}
