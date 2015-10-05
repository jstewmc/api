<?php

namespace Jstewmc\Api\Response;

/**
 * A JSON response
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Json extends Response
{	
	/* !Public methods */
	
	/**
	 * Parses the service's output
	 *
	 * @param   $output  string  the service's output
	 * @return  bool
	 * @throws  InvalidArgumentException  if $output is not a string
	 * @since   0.1.0
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
		$data = json_decode($output, true);
		
		// if the json is valid
		if ($data !== null) {
			$this->data = $data;
			$isValid = true;
		} else {
			$isValid = false;
		}
		
		return $isValid;
	}
}
