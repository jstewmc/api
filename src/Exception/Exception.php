<?php

namespace Jstewmc\Api\Exception;

/**
 * An API exception
 *
 * The API library uses exceptions to identify what went wrong in an API request.
 * Generally, errors and exceptions are grouped into service-, response-, and body-
 * level errors.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Exception extends \RuntimeException
{
	/* !Protected properties */
	
	/**
	 * @var  string|false  the service's string output or false if the service is
	 *     unavailable (defaults to false)
	 * @since  0.1.0
	 */
	protected $output = false;
	
	/**
	 * @var  Jstewmc\Api\Response\Response|null  the service's response or null if 
	 *    the service was unavailable or the response was bad
	 * @since  0.1.0
	 */
	protected $response;
	
	/**
	 * @var  int|null  the service's http status code or null if the service was
	 *     unavailable
	 * @since  0.1.0
	 */
	protected $status;	
	
	
	/* !Get methods */
	
	/**
	 * Gets the exception's output
	 *
	 * @return  string|false
	 * @since  0.1.0
	 */
	public function getOutput()
	{
		return $this->output;
	}
	
	/**
	 * Gets the exception's response
	 *
	 * @return  Jstewmc\Api\Response\Response|null
	 * @since  0.1.0
	 */
	public function getResponse()
	{
		return $this->response;
	}
	
	/**
	 * Gets the exception's status code
	 * 
	 * @return  int|null
	 * @since  0.1.0
	 */
	public function getStatus()
	{
		return $this->status;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the exception's output
	 *
	 * @param  string|false  $output  the service's output
	 * @return  self
	 * @throws  InvalidArgumentException  if $output is neither a string nor false
	 * @since  0.1.0
	 */
	public function setOutput($output) 
	{
		if ( ! is_string($output) && $output !== false) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, output, to be a string or false"
			);
		}
		
		$this->output = $output;
		
		return $this;	
	}
	
	/**
	 * Sets the exception's response
	 *
	 * @param  Jstewmc\Api\Response  $response  the service's response
	 * @return  self
	 * @since  0.1.0
	 */
	public function setResponse(\Jstewmc\Api\Response\Response $response) 
	{
		$this->response = $response;
		
		return $this;
	}
	
	/**
	 * Sets the exception's status
	 *
	 * @param  int  $status  the service's http status code
	 * @return  self
	 * @since  0.1.0
	 */
	public function setStatus($status)
	{
		if ( ! is_numeric($status) || ! is_int(+$status) || $status < 0) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, status, to be a positive "
					. "integer"
			);
		}
		
		$this->status = $status;
		
		return $this;
	}
}
