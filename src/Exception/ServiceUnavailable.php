<?php

namespace Jstewmc\Api\Exception;

/**
 * A "service unavailable" exception
 *
 * A "service unavailable" exception is thrown by the API client when a connection 
 * to the server cannot be established. Usually, when a connection cannot be 
 * established, the request's options are incorrect or the service is down.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class ServiceUnavailable extends Exception
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
		parent::__construct("Service is unreachable or unavailable");
		
		return;
	}
}
