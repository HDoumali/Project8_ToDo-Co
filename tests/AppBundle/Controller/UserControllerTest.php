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