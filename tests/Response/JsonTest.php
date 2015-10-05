<?php

namespace Jstewmc\Api;

/**
 * Tests for the Response class
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
	/* !getData() */
	
	/**
	 * getData() should return array if data does not exist
	 */
	public function test_getData_returnsArray_ifDataDoesNotExist()
	{
		return $this->assertEquals([], (new Response())->getData());
	}
	
	/**
	 * getData() should return array if data does exist
	 */
	public function test_getData__returnsArray_ifDataDoesExist()
	{
		$data = ['foo' => 'bar'];
		
		$response = new Response();
		$response->setData($data);
		
		$this->assertEquals($data, $response->getData());
		
		return;
	}
	
	/* !parse() */
	
	/**
	 * parse() should throw InvalidArgumentException if $output is not a string
	 */
	public function test_parse_throwsInvalidArgumentException_ifOutputIsNotAString()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		(new Response())->parse(999);
		
		return;
	}
	
	/**
	 * parse() should return self if $output is invalid json
	 */
	public function test_parse_returnsSelf_ifOutputIsInvalid()
	{
		$output = '{foo:}';
		
		$response = new Response();
		
		$this->assertSame($response, $response->parse($output));
		$this->assertNull($response->getData());
		
		return;
	}
	
	/**
	 * parse() should return self if $output is valid json
	 */
	public function test_parse_returnsSelf_ifOutputIsValid()
	{
		$output = '{"foo":"bar"}';
		
		$response = new Response();
		
		$this->assertSame($response, $response->parse($output));
		$this->assertEquals(['foo' => 'bar'], $response->getData());
		
		return;
	}
	
	
	/* !setData() */
	
	/**
	 * setData() should return self
	 */
	public function test_setData_returnsSelf()
	{
		$data = ['foo' => 'bar'];
		
		$response = new Response();
		
		$this->assertSame($response, $response->setData($data));
		$this->assertEquals($data, $response->getData());
		
		return;
	}
		
}
