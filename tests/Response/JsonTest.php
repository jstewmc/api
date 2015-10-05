<?php

namespace Jstewmc\Api\Response;

/**
 * Tests for the Json class
 */
class JsonTest extends \PHPUnit_Framework_TestCase
{
	/* !getData() */
	
	/**
	 * getData() should return array if data does not exist
	 */
	public function test_getData_returnsArray_ifDataDoesNotExist()
	{
		return $this->assertEquals([], (new Json())->getData());
	}
	
	/**
	 * getData() should return array if data does exist
	 */
	public function test_getData__returnsArray_ifDataDoesExist()
	{
		$data = ['foo' => 'bar'];
		
		$response = new Json();
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
		
		(new Json())->parse(999);
		
		return;
	}
	
	/**
	 * parse() should return false if $output is invalid json
	 */
	public function test_parse_returnsFalse_ifOutputIsInvalid()
	{
		$output = '{foo:}';
		
		$response = new Json();
		
		$this->assertFalse($response->parse($output));
		$this->assertEquals([], $response->getData());
		
		return;
	}
	
	/**
	 * parse() should return true if $output is valid json
	 */
	public function test_parse_returnsSelf_ifOutputIsValid()
	{
		$output = '{"foo":"bar"}';
		
		$response = new Json();
		
		$this->assertTrue($response->parse($output));
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
		
		$response = new Json();
		
		$this->assertSame($response, $response->setData($data));
		$this->assertEquals($data, $response->getData());
		
		return;
	}
		
}
