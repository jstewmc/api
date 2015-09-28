<?php

namespace Jstewmc\Api;

/**
 * An API response
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Response
{
	/* !Protected properties */
	
	/**
	 * @var  mixed[]|null  the response's data as an associative array or null if 
	 *     the response is invalid json
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
	 * @return  self
	 * @throws  InvalidArgumentException  if $output is not a string
	 * @since  0.1.0
	 */
	public function parse($output)
	{
		// if $output is not a string, short-circuit
		if ( ! is_string($output)) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, output, to be a string"
			);	
		}
		
		// decode the json output as an associative array
		$this->data = json_decode($output, true);
		
		return $this;
	}
}
