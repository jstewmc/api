<?php

namespace Jstewmc\Api;

/**
 * Tests for the Client class
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{	
	/* !execute() */
		
	/**
	 * execute() should throw a ServiceUnavailable exception if the service is 
	 *     unreachable (or unavailable)
	 */
	public function test_execute_throwsServiceUnavailable_ifServiceIsUnavailable()
	{
		$this->setExpectedException('Jstewmc\\Api\\Exception\\ServiceUnavailable');
		
		// the plan: send a request to a domain that couldn't possibly exist
		
		$request = new Request('http://KznXUgApqBCVpnRhoJyNJlpnfyIoLv.com');
		
		$response = new Response();
		
		$client = new Client($request, $response);
		
		$client->execute();
		
		return;
	}
	
	/**
	 * execute() should throw a BadResponseStatus exception if the service responds
	 *     with an invalid http status code
	 */
	public function test_execute_throwsBadResponseStatus_ifStatusIsInvalid()
	{
		$this->setExpectedException('Jstewmc\\Api\\Exception\\BadResponseStatus');
		
		// the plan: send a request to a domain that is redirected, because the API
		//     only expects 2XX and 400 status codes; for example, "www.github.com" 
		//     redirects to "github.com"
		//
		
		$request = new Request('http://www.github.com');
		
		$response = new Response();
		
		$client = new Client($request, $response);
		
		$client->execute();
		
		return;
	}
	
	/**
	 * execute() should throw a BadResponseFormat exception if the service responds
	 *     with an invalid response format
	 */
	public function test_execute_throwsBadResponseFormat_ifFormatIsInvalid()
	{
		$this->setExpectedException('Jstewmc\\Api\\Exception\\BadResponseFormat');
		
		// the plan: send a request to a functioning website, because the website
		//     will return HTML, not json; "https://www.google.com" sounds good
		//
		
		$request = new Request('https://www.google.com');
		
		$response = new Response();
		
		$client = new Client($request, $response);
		
		$client->execute();	
		
		return;
	}
	
	/**
	 * execute() should throw an EntityNotFound exception if the service responds 
	 *     with json and a 404 http status code
	 */
	public function test_execute_throwsEntityNotFound_ifEntityNotFound()
	{
		$this->setExpectedException('Jstewmc\\Api\\Exception\\EntityNotFound');
		
		// the plan: send a request to an open API but for a resource that does not
		//     exist; most public APIs require an authorization token; however, it
		//     appears that Facebook will check the authenticity of the id before it
		//     authorizes you
		//
		
		$request = new Request('https://graph.facebook.com/KznXUgApqBCVpnRhoJyNJl');
		
		$response = new Response();
		
		$client = new Client($request, $response);
		
		$client->execute();
		
		return;
	}
	
	/**
	 * execute() should return void if everything goes ok
	 *
	 * Keep in mind, this test requires a Facebook Graph API access token; the 
	 *     token below will expire Sep 28, 2015 at 7:00pm. 
	 *
	 * @see https://developers.facebook.com/tools/explorer for a new token
	 */
	public function test_execute_returnsVoid_ifOk()
	{
		$token = 'CAACEdEose0cBAGHN1YCAC0RvRi1ZA3OmbUIryZAgZBrDZCkk6ZAunPUCXeNoDXGPFHHYaDMJyz4AFZCDXtVwHLbZBtop8h3XTAn8w4m5Cb3Km6iWOjbFA8RpXd1BbFp2YINJ7RzkxBOw4YoDy7r8ZBP1B4bJxCAJPB7qFxb74kZCO7xbcskMkwPCQNF8ZBCuvrwlAaLZCUElqcBZC6LAIZBZAQbiM6';
		
		$request = new Request(
			"https://graph.facebook.com/v2.4/me?fields=id%2Cname&access_token=$token"
		);
		
		$response = new Response();
		
		$client = new Client($request, $response);
		
		// set expectations
		// these are taken from Facebook's Graph Explorer
		//
		$expected = [
			'id' => 10100242434925333,
			'name' => 'Jack Clayton'
		];
		
		$this->assertNull($client->execute());
		$this->assertEquals($expected, $client->getResponse()->getData());
		
		return;
	}
	
	/* !getRequest() */
	
	/**
	 * getRequest() should return request, a constructor injected dependency
	 */
	public function test_getRequest_returnsRequest()
	{
		$request = new Request('http://example.com');
		
		$response = new Response();
		
		$client = new Client($request, $response);
		
		$this->assertSame($request, $client->getRequest());
		
		return;
	}
	
	/**
	 * getResponse() should return response, a constructor injected dependency
	 */
	public function test_getResponse_returnsResponse()
	{
		$request = new Request('http://example.com');
		
		$response = new Response();
		
		$client = new Client($request, $response);
		
		$this->assertSame($response, $client->getResponse());
		
		return;
	}
	 
}
