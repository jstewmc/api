<?php

namespace Jstewmc\Api\Request;

/**
 * A POST request
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Post extends Request
{
	/* !Protected properties */
	
	/**
	 * @var  mixed[]  the request's data as an associaive array
	 * @since  0.1.0
	 */
	protected $data = [];
	
	/**
	 * @var  string  the request's http method
	 * @since  0.1.0
	 */
	protected $method = self::METHOD_POST;
	
	
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
}
