<?php

namespace Jstewmc\Api;

/**
 * An API request
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Request
{
	/* !Constants */
	
	/**
	 * @var  string  the http delete method
	 * @since  0.1.0
	 */
	const METHOD_DELETE = 'DELETE';
	
	/**
	 * @var  string  the http get method
	 * @since  0.1.0
	 */
	const METHOD_GET = 'GET';
	
	/**
	 * @var  string  the http put method 
	 * @since  0.1.0
	 */
	const METHOD_PUT = 'PUT';
	
	/**
	 * @var  string  the http post method
	 * @since  0.1.0
	 */
	const METHOD_POST = 'POST';
	
	
	/* !Protected properties */
	
	/**
	 * @var  mixed[]  the request's data as an associaive array
	 * @since  0.1.0
	 */
	protected $data = [];
	
	/**
	 * @var  string  the request's http method; defaults to "GET"
	 * @since  0.1.0
	 */
	protected $method = self::METHOD_GET;
	
	/**
	 * @var  mixed[]  the request's options indexed by curl_setopt() constants or 
	 *     their integer equivalents (defaults to no header, save the output as a
	 *     string, and send/accept json)
	 * @see  http://php.net/manual/en/function.curl-setopt.php  curl_setopt() man
	 * @since  0.1.0
	 */
	protected $options = [
		CURLOPT_HEADER         => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER     => [
			'Accept: application/json',
			'Content-type: application/json'
		]
	];
	
	/**
	 * @var  string  the request's url
	 * @since  0.1.0
	 */
	protected $url;
	
	
	/* !Get methods */
	
	/**
	 * Gets the request's data
	 *
	 * @return  mixed[]  the request's data
	 * @since  0.1.0
	 */
	public function getData()
	{
		return $this->data;
	}
	
	/**
	 * Gets the request's method
	 *
	 * @return  string  the request's http method
	 * @since  0.1.0
	 */
	public function getMethod()
	{
		return $this->method;
	}
	
	/**
	 * Gets the request's options
	 *
	 * @return  mixed[]  the request's curl options
	 * @since  0.1.0
	 */
	public function getOptions()
	{
		return $this->options;
	}
	
	/**
	 * Gets the request's url
	 *
	 * @return  string  the request's url
	 * @since  0.1.0
	 */
	public function getUrl()
	{
		return $this->url;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the requests's data
	 *
	 * @param  mixed[]  $data  the request's data
	 * @return  self
	 * @since  0.1.0
	 */
	public function setData(Array $data)
	{
		$this->data = $data;
		
		return $this;
	}
	
	/**
	 * Sets the request's method
	 *
	 * @param  string  the request's method
	 * @return  self
	 * @throws  InvalidArgumentException  if $method is not a string
	 * @since  0.1.0
	 */
	public function setMethod($method)
	{
		if ( ! is_string($method)) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, method, to be a string"
			);
		}
		
		$this->method = $method;
		
		return $this;
	}
	
	/**
	 * Sets the request's options
	 *
	 * @param  mixed[]  the request's options
	 * @return  self
	 * @since  0.1.0
	 */
	public function setOptions(Array $options)
	{
		$this->options = $options;
		
		return $this;
	}
	
	
	/* !Magic methods */
	
	/**
	 * Called when the object is constructed
	 *
	 * @param  string  $url  the request's url
	 * @return  self
	 * @throws  InvalidArgumentException  if $url is not a string
	 * @since   0.1.0
	 */
	public function __construct($url)
	{
		if ( ! is_string($url)) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, url, to be a string"
			);	
		}
		
		$this->url = $url;
		
		return;
	}
}
