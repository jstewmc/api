<?php

namespace Jstewmc\Api;

/**
 * An API client
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Client
{
	/* !Protected properties */
	
	/**
	 * @var  Resource  the client's curl handle
	 * @since  0.1.0
	 */
	protected $ch;
	
	/**
	 * @var  null|false|string  null if a request has not been sent; false if a
	 *     request was sent but the service was unreachable or unavailable; and,
	 *     a string if the service responded
	 * @since  0.1.0
	 */
	protected $output;
	
	
	/* !Magic methods */
	
	/**
	 * Called when the client is constructed
	 *
	 * @return  self
	 * @since  0.1.0
	 */
	public function __construct()
	{
		// if curl is (somehow) not installed, short-circuit
		if ( ! function_exists('curl_init')) {
			throw new \BadMethodCallException(
				__METHOD__."() expects the cURL extension to be installed"
			);
		}
		
		$this->ch = curl_init();
		
		return;
	}	
	
	/**
	 * Called when the client is destructed
	 * 
	 * @return  void
	 * @since  0.1.0
	 */
	public function __destruct()
	{
		curl_close($this->ch);
		
		return;
	}
	
	
	/* !Public methods */
	
	/**
	 * "Receives" the service's response
	 *
	 * I say "receives" because the client has already received the service's raw
	 * output. It just hasn't been processed yet. 
	 *
	 * @param   Jstewmc\Api\Response  $response  the response to "receive"
	 * @return  Jstewmc\Api\Response
	 * @throws  Jstewmc\Api\Exception\ServiceUnavailable  if the service cannot be
	 *     reached (because of the request's settings) or is unavailable (because of 
	 *     the service's status)
	 * @throws  Jstewmc\Api\Exception\BadResponseStatus  if the response's status 
	 *     code is not an allowed value (accepts 2XX and 404)
	 * @throws  Jstewmc\Api\Exception\BadResponseFormat  if the service's response 
	 *     is not a valid json string
	 * @throws  Jstewmc\Api\Exception\EntityNotFound  if the service responds 404
	 * @since   0.1.0
	 */
	public function receive($response)
	{
		// if the service was unreachable or unavailable, short-circuit
		if ($this->output === false) {
			throw new Exception\ServiceUnavailable(
				curl_error($this->ch), 
				curl_errno($this->ch)
			);
		}
		
		// get the response's status and define the valid values
		$status   = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
		$statuses = [200, 201, 204, 404];
		
		// if the service responded with an invalid http status code, short-circuit
		if ( ! in_array((int) $status, $statuses)) {
			throw (new Exception\BadResponseStatus())
				->setOutput($this->output)
				->setStatus($status);
		}
		
		// if output actually exists
		if (strlen($this->output)) {
			// if the output cannot be parsed, short-circuit
			if ( ! $response->parse($this->output)) {
				throw (new Exception\BadResponseFormat())
					->setOutput($this->output)
					->setStatus($status);
			}
		}
		
		// if the server responded 404, short-circuit
		if ($status === 404) {
			throw (new Exception\EntityNotFound())
				->setOutput($this->output)
				->setStatus($status)
				->setResponse($response);
		}
		
		return $response;
	}
	
	/**
	 * Sends the request to the service
	 *
	 * @param  Jstewmc\Api\Request\Request  $request  the request to send
	 * @return  self
	 * @since   0.1.0
	 */
	public function send($request)
	{
		// set the request's url
		curl_setopt($this->ch, CURLOPT_URL, $request->getUrl());
		
		// set the request's method
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $request->getMethod());
		
		// if the request is a POST or PUT request
		if ($request instanceof Request\Post || $request instanceof Request\Put) {
			// if the request has data
			if ($request->getData()) {
				curl_setopt(
					$this->ch, 
					CURLOPT_POSTFIELDS, 
					json_encode($request->getData())
				);	
			}
		}
		
		// set the request's other options
		curl_setopt_array($this->ch, $request->getOptions());
		
		// execute the request
		$this->output = curl_exec($this->ch);
		
		return $this;
	}		
}
