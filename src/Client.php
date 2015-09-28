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
	 * @var  Jstewmc\Api\Request  the api request
	 * @since  0.1.0
	 */
	protected $request;
	
	/**
	 * @var  Jstewmc\Api\Response  the api response
	 * @since  0.1.0
	 */
	protected $response;
	
	
	/* !Get methods */
	
	/**
	 * Gets the client's request
	 *
	 * @return  Jstewmc\Api\Request
	 * @since  0.1.0
	 */
	public function getRequest()
	{
		return $this->request;
	}
	
	/**
	 * Gets the client's response
	 *
	 * @return  Jstewmc\Api\Response
	 * @since  0.1.0
	 */
	public function getResponse()
	{
		return $this->response;
	}
	
	/* !Magic methods */
	
	/**
	 * Called when the client is constructed
	 *
	 * @return  self
	 * @since  0.1.0
	 */
	public function __construct(Request $request, Response $response)
	{
		// if curl is (somehow) not installed, short-circuit
		if ( ! function_exists('curl_init')) {
			throw new \BadMethodCallException(
				__METHOD__."() expects the cURL extension to be installed"
			);
		}
		
		$this->request  = $request;
		$this->response = $response;
		
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
	 * Executes the api request
	 *
	 * I'll send the request to the service and parse its output. Of course, with
	 * anything over a network, tons of things can go wrong. For most errors, I'll 
	 * attempt to throw an appropriately named exception.
	 *
	 * @return  void
	 * @throws  Jstewmc\Api\Exception\ServiceUnavailable  if the service cannot be
	 *     reached (because of settings) or is unavailable (because of status)
	 * @throws  Jstewmc\Api\Exception\BadResponseStatus  if the response's status 
	 *     code is not an allowed value (accepts 2XX and 404)
	 * @throws  Jstewmc\Api\Exception\BadResponseFormat  if the service's response 
	 *     is not a valid json string
	 * @throws  Jstewmc\Api\Exception\EntityNotFound  if the service responds 404
	 * @since   0.1.0
	 */
	public function execute()
	{
		// send the request
		$output = $this->send();
		
		// if the service was reachable and available
		if ($output !== false) {
			// if the service responded with an expected http status code
			$status = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
			if (in_array((int) $status, [200, 201, 204, 404])) {
				// if the service's response is valid json
				if (json_decode($output) !== null) {
					// parse the output
					$this->response->parse($output);
					// if the service responded 404, the entity was not found
					if ($status == 404) {
						throw (new Exception\EntityNotFound())
							->setOutput($output)
							->setStatus($status)
							->setResponse($this->response);
					}
				} else {
					// otherwise, the response format is bad
					throw (new Exception\BadResponseFormat())
						->setOutput($output)
						->setStatus($status);
				}
			} else {
				// otherwise, the response status is unexpected
				throw (new Exception\BadResponseStatus())
					->setOutput($output)
					->setStatus($status);
			}
		} else {
			// otherwise, the service was unreachable or unavailable
			throw new Exception\ServiceUnavailable(
				curl_error($this->ch), 
				curl_errno($this->ch)
			);
		}
		
		return;
	}
		
		
	/* !Protected methods */
	
	/**
	 * Sends the API request to the service
	 *
	 * @return  string|false
	 * @since   0.1.0
	 */
	protected function send()
	{
		$output = false;
		
		// set the request's url
		curl_setopt($this->ch, CURLOPT_URL, $this->request->getUrl());
		
		// set the request's method
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->request->getMethod());
		
		// if the request has data, set it as json
		if ( ! empty($this->request->getData())) {
			curl_setopt(
				$this->ch, 
				CURLOPT_POSTFIELDS, 
				json_encode($this->request->getData())
			);	
		}
		
		// set the request's other options
		curl_setopt_array($this->ch, $this->request->getOptions());
		
		// execute the request
		$output = curl_exec($this->ch);
		
		return $output;
	}		
}
