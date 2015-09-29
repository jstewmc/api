<?php

namespace Jstewmc\Api\Request;

/**
 * Tests for the Request\Get class
 */
class PostTest extends \PHPUnit_Framework_TestCase
{	
	/* !getData() */
	
	/**
	 * getData() should return array if data does not exist
	 */
	public function test_getData_returnsArray_ifDataDoesNotExist()
	{
		return $this->assertEquals([], (new Post('http://example.com'))->getData());
	}
	
	/**
	 * getData() should return array if data does exist
	 */
	public function test_getData_returnsArray_ifDataDoesExist()
	{
		$data = ['foo' => 'bar', 'baz' => 'qux'];
		
		$request = new Post('http://example.com');
		$request->setData($data);
		
		$this->assertEquals($data, $request->getData());
		
		return;
	}
	
	
	/* !getMethod() */
	
	/**
	 * getMethod() should return string
	 */
	public function test_getMethod_returnsString()
	{
		return $this->assertEquals(
			'POST', 
			(new Post('http://example.com'))->getMethod()
		);
	}
	
	
	/* !getOptions() */
	
	/**
	 * getOptions() should return array if options do not exist
	 */
	public function test_getOptions_returnsArray_ifOptionsDoNotExist()
	{
		$options = [
			CURLOPT_HEADER         => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER     => [
				'Accept: application/json',
				'Content-type: application/json'
			]
		];
		
		$this->assertEquals($options, (new Post('http://example.com'))->getOptions());
		
		return;
	}
	
	/**
	 * getOptions() should return array if options do exist
	 */
	public function test_getOptions_returnsArray_ifOptionsDoExist()
	{
		$options = [CURLOPT_AUTOREFERER => true];
		
		$request = new Post('http://example.com');
		$request->setOptions($options);
		
		$this->assertEquals($options, $request->getOptions());
		
		return;
	}
	
	
	/* !getUrl() */
	
	/**
	 * getUrl() should return string (keep in mind, a url is required on 
	 *     instantiation as a constructor argument; it'll always exist)
	 */
	public function test_getUrl_returnsString()
	{
		$url = 'http://example.com';
		
		$request = new Post($url);
		
		$this->assertEquals($url, $request->getUrl());
	}
	
	
	/* !setData() */
	
	/**
	 * setData() should return self
	 */
	public function test_setData_returnsSelf()
	{
		$data = ['foo' => 'bar', 'baz' => 'qux'];
		
		$request = new Post('http://example.com');
		
		$this->assertSame($request, $request->setData($data));
		$this->assertEquals($data, $request->getData());
		
		return;
	}
	
	
	/* !setOptions() */

	/**
	 * setOptions() should return self
	 */
	public function test_setOptions_returnsSelf()
	{
		$options = [CURLOPT_AUTOREFERER => true];
		
		$request = new Post('http://example.com');
		
		$this->assertSame($request, $request->setOptions($options));
		$this->assertEquals($options, $request->getOptions());
		
		return;
	}
}
