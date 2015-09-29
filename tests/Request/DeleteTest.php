<?php

namespace Jstewmc\Api\Request;

/**
 * Tests for the Delete class
 */
class DeleteTest extends \PHPUnit_Framework_TestCase
{	
	/* !getMethod() */
	
	/**
	 * getMethod() should return string
	 */
	public function test_getMethod_returnsString()
	{
		return $this->assertEquals(
			'DELETE', 
			(new Delete('http://example.com'))->getMethod()
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
		
		$this->assertEquals($options, (new Delete('http://example.com'))->getOptions());
		
		return;
	}
	
	/**
	 * getOptions() should return array if options do exist
	 */
	public function test_getOptions_returnsArray_ifOptionsDoExist()
	{
		$options = [CURLOPT_AUTOREFERER => true];
		
		$request = new Delete('http://example.com');
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
		
		$request = new Delete($url);
		
		$this->assertEquals($url, $request->getUrl());
	}
	
	
	/* !setOptions() */

	/**
	 * setOptions() should return self
	 */
	public function test_setOptions_returnsSelf()
	{
		$options = [CURLOPT_AUTOREFERER => true];
		
		$request = new Delete('http://example.com');
		
		$this->assertSame($request, $request->setOptions($options));
		$this->assertEquals($options, $request->getOptions());
		
		return;
	}
}
