<?php

namespace Jstewmc\Api\Response;

/**
 * An API response
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 * @sinec      0.2.0  update from concrete to abstract class
 */
abstract class Response
{
	/* !Protected properties */
	
	/**
	 * @var  mixed[]  the response's data as an associative array
	 * @since  0.1.0
	 */
	protected $data = [];

	
	/* !Get methods */

	/**
	 * Gets the response's data
	 *
	 * @return  mixed[]
	 */
	public function getData()
	{
		return $this->data;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the response's data
	 *
	 * @param  mixed[]  the response's data
	 * @return  self
	 * @since  0.1.0
	 */
	public function setData(Array $data)
	{
		$this->data = $data;
		
		return $this;
	}
	
	
	/* !Public methods */
	
	/**
	 * Parses the service's output
	 *
	 * @param  $output  string  the service's output
	 * @return  bool
	 * @throws  InvalidArgumentException  if $output is not a string
	 * @since  0.1.0
	 * @since  0.2.0  update from concrete to abstract method
	 */
	abstract public function parse($output);
}
