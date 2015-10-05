<?php

namespace Jstewmc\Api\Response;

/**
 * An XML response
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.2.0
 */
class Xml extends Response
{
	/** !Public methods */
	
	/**
	 * Parses the service's output
	 *
	 * @param   string  $output  the service's output
	 * @return  self
	 * @throws  InvalidArgumentException  if $output is not a string
	 * @since   0.2.0
	 * @see     http://php.net/manual/en/book.simplexml.php#105330  soloman at
	 *     textgrid dot com's comment on PHP's SimpleXML man page on how to convert
	 *     XML to an associative array
	 */	
	public function parse($output)
	{
		if ( ! is_string($output)) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, output, to be a string"
			);
		}
		
		// load the output into a simple xml object
		$xml = @simplexml_load_string($output);
		
		// if the xml was well-formed
		if ($xml !== false) {
			// encode the xml object as json
			$json = json_encode($xml);
			$data = json_decode($json, true);
			// if the data is valid json
			if ($data !== null) {
				// great success!
				$this->data = $data;	
				$isValid = true;
			} else {
				// otherwise, the json was invalid
				$isValid = false;	
			}
		} else {
			// otherwise, the xml was mal-formed
			$isValid = false;
		}
		
		return $isValid;
	}
} 
