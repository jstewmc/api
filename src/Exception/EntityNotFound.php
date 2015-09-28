<?php

namespace Jstewmc\Api\Exception;

/**
 * An "entity not found" exception
 *
 * An "entity not found" exception will be thrown by the API client if, well, the 
 * identified entity cannot be found.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class EntityNotFound extends Exception
{
	/* !Magic methods */
	
	/**
	 * Called when the exception is constructed
	 *
	 * @return  self
	 * @sicne  0.1.0
	 */
	public function __construct()
	{
		parent::__construct("Entity not found");
		
		return;
	}
}
