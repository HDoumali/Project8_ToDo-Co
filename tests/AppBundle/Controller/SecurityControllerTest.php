<?php 

namespace tests\AppBundle\Controller; 

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;

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

	public function testLogin()
	{
		$client = $this->createClient();
        $crawler = $client->request('GET', '/login');

		$form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'test2';
        $form['_password'] = 'test2';

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
	}

	public function testInvalidCredentials()
	{
		$client = $this->createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'invalid';
        $form['_password'] = 'credentials';

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-danger:contains("Invalid credentials")')->count());
	}
}