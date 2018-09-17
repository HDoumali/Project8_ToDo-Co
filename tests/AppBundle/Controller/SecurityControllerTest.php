<?php 

namespace tests\AppBundle\Controller; 

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

Class SecurityControllerTest extends WebTestCase
{
	public function testHomepageIsUp()
	{
		$client = static::createClient();
		$client->request('GET', '/login');

		$this->assertSame(200, $client->getResponse()->getStatusCode());
	}
}