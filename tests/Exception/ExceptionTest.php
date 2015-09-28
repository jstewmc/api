<?php

namespace Jstewmc\Api\Exception;

/**
 * Tests for the Exception\Exeption class
 */
class ExceptionTest extends \PHPUnit_Framework_TestCase
{
	/* !getOutput() */
	
	/**
	 * getOutput() should return false if output does not exist
	 */
	public function test_getOutput_returnsFalse_ifOutputDoesNotExist()
	{
		return $this->assertFalse((new Exception())->getOutput());
	}
	
	/**
	 * getOutput() should return string if output does exist
	 */
	public function test_getOutput_returnsString_ifOutputDoesExist()
	{
		$output = 'foo';
		
		$exception = new Exception();
		$exception->setOutput($output);
		
		$this->assertEquals($output, $exception->getOutput());
		
		return;
	}
	
	
	/* !getResponse() */
	
	/**
	 * getResponse() should return null if response does not exist
	 */
	public function test_getResponse_returnsNull_ifResponseDoesNotExist()
	{
		return $this->assertNull((new Exception())->getResponse());
	}
	
	/**
	 * getResponse() should return response if response does exist
	 */
	public function test_getResponse_returnsResponse_ifResponseDoesExist()
	{
		$response = new \Jstewmc\Api\Response();
		
		$exception = new Exception();
		$exception->setResponse($response);
		
		$this->assertSame($response, $exception->getResponse());
		
		return;
	}
	
	
	/* !getStatus() */
	
	/**
	 * getStatus() should return null if status does not exist
	 */
	public function test_getStatus_returnsNull_ifStatusDoesNotExist()
	{
		return $this->assertNull((new Exception())->getStatus());
	}
	
	/**
	 * getStatus() should return int if status does exist
	 */
	public function test_getStatus_returnsInt_ifStatusDoesExist()
	{
		$status = 500;
		
		$exception = new Exception();
		$exception->setStatus($status);
		
		$this->assertEquals($status, $exception->getStatus());
		
		return;
	}
	
	
	/* !setOutput() */	
	
	/**
	 * setOutput() should throw InvalidArgumentException if $output is not a string
	 */
	public function test_setOutput_throwsInvalidArgumentException_ifOutputIsNotAString()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		(new Exception())->setOutput(999);
		
		return;
	}
	
	/**
	 * setOutput() should return self if $output is string
	 */
	public function test_setOutput_returnsSelf_ifOutputIsString()
	{
		$output = 'foo';
		
		$exception = new Exception();
		
		$this->assertSame($exception, $exception->setOutput($output));
		$this->assertEquals($output, $exception->getOutput());
		
		return;
	}
	
	
	/* !setReponse() */
	
	/**
	 * setResponse() should return self
	 */
	public function test_setResponse_returnsSelf()
	{
		$response = new \Jstewmc\Api\Response();
		
		$exception = new Exception();
		
		$this->assertSame($exception, $exception->setResponse($response));
		$this->assertSame($response, $exception->getResponse());
		
		return;
	}
	
	
	/* !setStatus() */
	
	/**
	 * setStatus() should throw InvalidArgumentException if $status is not a positive
	 *     integer
	 */
	public function test_setStatus_throwsInvalidArgumentException_ifStatusIsNotInteger()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		(new Exception())->setStatus('foo');
		
		return;
	}
	
	/**
	 * setStatus() should return self if $status is a positive integer
	 */
	public function test_setStatus_returnsSelf_ifStatusIsInteger()
	{
		$status = 500;
		
		$exception = new Exception();
		
		$this->assertSame($exception, $exception->setStatus($status));
		$this->assertEquals($status, $exception->getStatus());
		
		return;
	}
}
