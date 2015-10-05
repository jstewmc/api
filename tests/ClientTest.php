<?php

namespace Jstewmc\Api;

/**
 * Tests for the Client class
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{	
	/* !Protected properties */
	
	/**
	 * @var  Jstewmc\Url\Url  the request's url
	 */
	protected $url;
	
	
	/* !Magic methods */
	
	/**
	 * Called before each test
	 *
	 * @return  void
	 */
	public function setUp()
	{
		$this->url = new \Jstewmc\Url\Url('http://localhost:8000');
		
		return;
	}
	
	
	/* !receive() */
		
	/**
	 * receive() should throw a ServiceUnavailable exception if the service is 
	 *     unreachable (or unavailable)
	 */
	public function test_receive_throwsServiceUnavailable_ifNoService()
	{
		$this->setExpectedException('Jstewmc\\Api\\Exception\\ServiceUnavailable');
		
		(new Client())
			->send(new Request\Get('http://x.x.x.x'))
			->receive(new Response\Json());
		
		return;
	}
	
	/**
	 * receive() should throw a BadResponseStatus exception if the service responds
	 *     with an invalid http status code
	 */
	public function test_receive_throwsBadResponseStatus_ifBadStatus()
	{
		$this->setExpectedException('Jstewmc\\Api\\Exception\\BadResponseStatus');
		
		$this->url->getQuery()->setParameter('code', 301);
		
		(new Client())
			->send(new Request\Get((string) $this->url))
			->receive(new Response\Json());
		
		return;
	}
	
	/**
	 * receive() should throw a BadResponseFormat exception if the service responds
	 *     with an invalid response format
	 */
	public function test_receive_throwsBadResponseFormat_ifBadFormat()
	{
		$this->setExpectedException('Jstewmc\\Api\\Exception\\BadResponseFormat');
		
		$this->url
			->getQuery()
				->setParameter('code', 200)
				->setParameter('format', 'json')
				->setParameter('output', '{"foo":}');
		
		(new Client())
			->send(new Request\Get((string) $this->url))
			->receive(new Response\Json());
		
		return;
	}
	
	/**
	 * execute() should throw an EntityNotFound exception if the service responds 
	 *     with json and a 404 http status code
	 */
	public function test_receive_throwsEntityNotFound_ifEntityIsNotFound()
	{
		$this->setExpectedException('Jstewmc\\Api\\Exception\\EntityNotFound');
		
		$this->url->getQuery()->setParameter('code', 404);
		
		(new Client())
			->send(new Request\Get((string) $this->url))
			->receive(new Response\Json());
			
		return;
	}
	
	/**
	 * execute() should return response if entity is found
	 */
	public function test_receive_returnsResponse_ifEntityIsFound()
	{
		$this->url
			->getQuery()
				->setParameter('code', 200)
				->setParameter('format', 'json')
				->setParameter('output', '{"foo":"bar"}');
		
		return $this->assertEquals(
			(new Response\Json())->setData(['foo' => 'bar']), 
			(new Client())
				->send(new Request\Get((string) $this->url))
				->receive(new Response\Json())
		);
	}
	
	
	/* !send() */
	
	/**
	 * send() should return self if the service is unavailable
	 */
	public function test_send_returnsSelf_ifNoService()
	{
		$request = new Request\Get('http://x.x.x.x');
		
		$client = new Client();
		
		$this->assertSame($client, $client->send($request));
		
		return;	
	}
	
	/**
	 * send() should return self if the response status is bad
	 */
	public function test_send_returnsSelf_ifStatusIsBad()
	{
		$this->url->getQuery()->setParameter('code', 301);
		
		$request = new Request\Get((string) $this->url);
		
		$client = new Client();
		
		$this->assertSame($client, $client->send($request));
		
		return;
	}
	
	/**
	 * send() should return self if the response format is bad
	 */
	public function test_send_returnsSelf_ifFormatIsBad()
	{
		$this->url
			->getQuery()
				->setParameter('code', 200)
				->setParameter('format', 'json')
				->setParameter('output', '{foo:}');
		
		$request = new Request\Get((string) $this->url);
		
		$client = new Client();
		
		$this->assertSame($client, $client->send($request));
		
		return;
	}
	
	/**
	 * send() should return self if the entity is not found
	 */
	public function test_send_returnsSelf_ifEntityIsNotFound()
	{
		$this->url->getQuery()->setParameter('code', 404);
			
		$request = new Request\Get((string) $this->url);
		
		$client = new Client();
		
		$this->assertSame($client, $client->send($request));
		
		return;
	}
	
	/**
	 * send() should return self if the entity is found
	 *
	 * @group  foo
	 */
	public function test_send_returnsSelf_ifEntityIsFound()
	{
		$this->url
			->getQuery()
				->setParameter('code', 200)
				->setParameter('format', 'json')
				->setParameter('output', '{"foo":"bar"}');
				
		$request = new Request\Get((string) $this->url);
		
		$client = new Client();
		
		$this->assertSame($client, $client->send($request));
		
		return;
	}
}
