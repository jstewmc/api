<?php

namespace Jstewmc\Api\Response;

/**
 * Tests for the Response\Xml class
 */
class XmlTest extends \PHPUnit_Framework_TestCase
{
	/* !getData() */
	
	/**
	 * getData() should return an array if data does not exist
	 */
	public function test_getData_returnsArray_ifDataDoesNotExist()
	{
		return $this->assertEquals([], (new Xml())->getData());
	}

	/**
	 * getData() should return an array if data does exist
	 */
	public function test_getData_returnsArray_ifDataDoesExist()
	{
		$data = ['foo' => 'bar', 'baz' => 'qux'];
		
		$response = new Xml();
		$response->setData($data);
		
		$this->assertEquals($data, $response->getData());
		
		return;
	}


	/* !parse() */
	
	/**
	 * parse() should throw an InvalidArgumentException if $output is not a string
	 */
	public function test_parse_throwsInvalidArgumentException_ifOutputIsNotString()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		(new Xml())->parse(999);
		
		return;
	}
	
	/**
	 * parse() should return false if output is mal-formed xml
	 */
	public function test_parse_returnsFalse_ifOutputIsInvalidXml()
	{
		return $this->assertFalse((new Xml())->parse('<foo>'));
	}
	
	/**
	 * parse() should return true if output if well-formed xml
	 */
	public function test_parse_returnsTrue_ifOutputIsValidXml()
	{
		$xml = '<?xml version="1.0" encoding="UTF-8"?>'
			. '<foo>'
			. 	'<bar>'
			.		'baz'
			.   '</bar>'
			.   '<bar>'
			.		'qux'
			.	'</bar>'
			. '</foo>' ;
		
		$data = ['bar' => ['baz', 'qux']];
		
		$response = new Xml();
		
		$this->assertTrue($response->parse($xml));
		$this->assertEquals($data, $response->getData());
		
		return;
	}
	

	/* !setData() */
	
	/**
	 * setData() should return self
	 */
	public function test_setData_returnsSelf()
	{
		$data = ['foo' => 'bar'];
		
		$response = new Xml();
		
		$this->assertSame($response, $response->setData($data));
		$this->assertEquals($data, $response->getData());
		
		return;
	}
}
