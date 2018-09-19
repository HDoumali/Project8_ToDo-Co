<?php 

namespace tests\AppBundle\Controller; 

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


Class UserControllerTest extends WebTestCase
{
	private $client;

	public function setUp()
	{
		$this->client = static::createClient();
	}

	public function testAccessListByAdmin()
	{
		$this->logInAdmin();

		$crawler = $this->client->request('GET', '/users');

		$this->assertSame(1,$crawler->filter('html:contains("Liste des utilisateurs")')->count());
	}

	public function testAccessListByUser()
	{
		$this->logInUser();

		$crawler = $this->client->request('GET', '/users');

		$this->assertSame(403, $this->client->getResponse()->getStatusCode());
	}

	public function testCreateUserByAdmin()
	{
		$this->logInAdmin();

		$crawler = $this->client->request('GET', '/');

		$this->assertSame(1, $crawler->filter('html:contains("Créer un utilisateur")')->count());

		$link = $crawler->selectLink('Créer un utilisateur')->link();
		$crawler = $this->client->click($link);

		$this->assertSame(200, $this->client->getResponse()->getStatusCode());

		$form = $crawler->selectButton('Ajouter')->form();
		$form['user[username]'] = 'UserTest';
		$form['user[password][first]'] = 'usertest';
		$form['user[password][second]'] = 'usertest';
		$form['user[email]'] = 'usertest@gmail.com';
		$form['user[roles]'] = 'ROLE_USER';

		$this->client->submit($form);

		$crawler = $this->client->followRedirect();

		$this->assertSame(200, $this->client->getResponse()->getStatusCode());
		$this->assertSame(1, $crawler->filter('div.alert.alert-success:contains("Superbe ! L\'utilisateur a bien été ajouté.")')->count());
	}

	public function logInAdmin()
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

	public function logInUser()
	{
		$session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('admin', null, $firewallName, array('ROLE_USER'));
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