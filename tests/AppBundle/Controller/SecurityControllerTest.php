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

	public function testHomepage()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/login');

		$this->assertSame(1, $crawler->filter('html:contains("Nom d\'utilisateur")')->count());
		$this->assertSame(1, $crawler->filter('html:contains("Mot de passe")')->count());
	}
}