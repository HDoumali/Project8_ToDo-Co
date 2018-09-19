<?php 

namespace tests\AppBundle\Controller; 

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

Class SecurityControllerTest extends WebTestCase
{	
	Private $client;

	public function setUp()
	{
		$this->client = static::createClient();
	}

	public function testHomepageIsUp()
	{
		$crawler = $this->client->request('GET', '/login');

		$this->assertSame(200, $this->client->getResponse()->getStatusCode());
		$this->assertSame(1, $crawler->filter('html:contains("Nom d\'utilisateur")')->count());
		$this->assertSame(1, $crawler->filter('html:contains("Mot de passe")')->count());
	}

	public function testLogin()
	{
		$this->logIn();

		$crawler = $this->client->request('GET', '/');

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
	}

	public function testInvalidCredentials()
	{
		$this->logIn();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'invalid';
        $form['_password'] = 'credentials';

        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-danger:contains("Invalid credentials")')->count());
	}

	public function testLogout()
	{
		$this->logIn();

		$this->client->request('GET', '/logout');

		$crawler = $this->client->followRedirect();

		$this->assertSame(302, $this->client->getResponse()->getStatusCode());		
	}

	public function logIn()
	{
		$session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('admin', null, $firewallName, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
	}

	public function tearDown()
	{
		$this->client = null;
	}
}