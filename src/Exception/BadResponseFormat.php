<?php

namespace Jstewmc\Api\Exception;

/**
 * A "bad response format" exception
 *
 * A "bad response format" exception is thrown by the API client when the response is
 * not valid json.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class BadResponseFormat extends Exception
{
	/* !Magic methods */
	
	/**
	 * Called when the exception is constructed
	 *
	 * @return  self
	 * @since  0.1.0
	 */
	public function __construct()
	{
		parent::__construct("Response's format is not an accepted value");
	}
}
