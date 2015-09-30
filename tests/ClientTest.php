<?php

namespace Jstewmc\Api;

/**
 * Tests for the Client class
 *
 * These tests are a little hackish! I couldn't find a public API that didn't require
 * an access token to test against, and I didn't want to hardcode an access token 
 * into the tests. 
 *
 * As a result, most of the tests consist of finagling a public, high-traffic website
 * like google, github, or facebook to test what we need.
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{	
	/**
	 * @var  string  the url for a "bad" response format (since the client expects
	 *     json, any normal website will do, because the server will return HTML,
	 *     not json)
	 */
	protected $urlBadFormat = 'https://www.google.com';
	
	/**
	 * @var  string  the url for an "bad" response status (since the client expects
	 *     a 2XX or 404 status code, a request to a domain that is redirected, a 
	 *     3XX status code, should suffice) (in a quick search, I found that 
     *     "http://www.github.com" will redirect to "http://github.com")
     */
    protected $urlBadStatus = 'http://www.github.com';
    
    /**
	 * @var  string  the url for an "entity found" (aka, "ok") response (you must
	 *     see https://developers.facebook.com/tools/explorer for a new url)
	 */
    protected $urlFound = 'https://graph.facebook.com/v2.4/me?fields=id%2Cname&access_token=CAACEdEose0cBAKg2i3ddtCQyo4OcpQ47biEr4MhNOcIctnB8qSok7jTE3xGyVbfM3x3CSNgPe76dQ5k9qJslkG6R1SzOQoOHqlO7AcVnqqAkDcQLwkwoFEpKSRa7LC8JUgaI4naIft85BJwSjxx82F8oOWFeXn0VesfQXZAb4SV8pDoZBh9Hq1eCjNJM9NK3tSPR4bIZBSzKqyX8z7T';
	
	/**
	 * @var  string  the url for an unavailable service
	 */
	protected $urlNoService = 'http://KznXUgApqBCVpnRhoJyNJlpnfyIoLv.com';
	
	/**
	 * @var  string  the url for an "entity not found" (most public API's require a
	 *     access token; however, in a quick search, Facebook's Graph API seems to
	 *     authenticate the entity before it authorizes the user, and it'll respond
	 *     with a 404 for an unauthentic entity id)
	 */
	protected $urlNotFound = 'https://graph.facebook.com/KznXUgApqBCVpnRhoJyNJl';
	
	
	/* !receive() */
		
	/**
	 * receive() should throw a ServiceUnavailable exception if the service is 
	 *     unreachable (or unavailable)
	 */
	public function test_receive_throwsServiceUnavailable_ifNoService()
	{
		$this->setExpectedException('Jstewmc\\Api\\Exception\\ServiceUnavailable');
		
		(new Client())
			->send(new Request\Get($this->urlNoService))
			->receive(new Response());
		
		return;
	}
	
	/**
	 * receive() should throw a BadResponseStatus exception if the service responds
	 *     with an invalid http status code
	 */
	public function test_receive_throwsBadResponseStatus_ifBadStatus()
	{
		$this->setExpectedException('Jstewmc\\Api\\Exception\\BadResponseStatus');
		
		(new Client())
			->send(new Request\Get($this->urlBadStatus))
			->receive(new Response());
		
		return;
	}
	
	/**
	 * receive() should throw a BadResponseFormat exception if the service responds
	 *     with an invalid response format
	 */
	public function test_receive_throwsBadResponseFormat_ifBadFormat()
	{
		$this->setExpectedException('Jstewmc\\Api\\Exception\\BadResponseFormat');
		
		(new Client())
			->send(new Request\Get($this->urlBadFormat))
			->receive(new Response());
		
		return;
	}
	
	/**
	 * execute() should throw an EntityNotFound exception if the service responds 
	 *     with json and a 404 http status code
	 */
	public function test_receive_throwsEntityNotFound_ifEntityIsNotFound()
	{
		$this->setExpectedException('Jstewmc\\Api\\Exception\\EntityNotFound');
		
		(new Client())
			->send(new Request\Get($this->urlNotFound))
			->receive(new Response());
			
		return;
	}
	
	/**
	 * execute() should return response if entity is found
	 */
	public function test_receive_returnsResponse_ifEntityIsFound()
	{
		return $this->assertEquals(
			(new Response())
				->setData([
					'id' => 10100242434925333,
					'name' => 'Jack Clayton'
				]), 
			(new Client())
				->send(new Request\Get($this->urlFound))
				->receive(new Response())
		);
	}
	
	
	/* !send() */
	
	/**
	 * send() should return self if the service is unavailable
	 */
	public function test_send_returnsSelf_ifNoService()
	{
		$request = new Request\Get($this->urlNoService);
		
		$client = new Client();
		
		$this->assertSame($client, $client->send($request));
		
		return;	
	}
	
	/**
	 * send() should return self if the response status is bad
	 */
	public function test_send_returnsSelf_ifStatusIsBad()
	{
		$request = new Request\Get($this->urlBadStatus);
		
		$client = new Client();
		
		$this->assertSame($client, $client->send($request));
		
		return;
	}
	
	/**
	 * send() should return self if the response format is bad
	 */
	public function test_send_returnsSelf_ifFormatIsBad()
	{
		$request = new Request\Get($this->urlBadFormat);
		
		$client = new Client();
		
		$this->assertSame($client, $client->send($request));
		
		return;
	}
	
	/**
	 * send() should return self if the entity is not found
	 */
	public function test_send_returnsSelf_ifEntityIsNotFound()
	{
		$request = new Request\Get($this->urlNotFound);
		
		$client = new Client();
		
		$this->assertSame($client, $client->send($request));
		
		return;
	}
	
	/**
	 * send() should return self if the entity is found
	 */
	public function test_send_returnsSelf_ifEntityIsFound()
	{
		$request = new Request\Get($this->urlFound);
		
		$client = new Client();
		
		$this->assertSame($client, $client->send($request));
		
		return;
	}
}
