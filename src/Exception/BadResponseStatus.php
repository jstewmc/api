<?php

namespace Jstewmc\Api\Exception;

/**
 * A "bad response status" exception
 *
 * A "bad response status" exception is thrown when the server responds with a status
 * that isn't one of the following:
 *
 *     200  a successful GET request
 *     201  a successful POST request
 *     204  a successful DELETE request
 *     404  a not found
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class BadResponseStatus extends Exception
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
		parent::__construct("Response's status is not an accepted value");
	}
}
