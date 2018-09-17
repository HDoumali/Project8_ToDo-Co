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

		$user = new User();
		$user->setUsername('testLogin');
		$plainPassword = 'testlogin';
		$password = $client->getContainer()->get('security.password_encoder')->encodePassword($user, $plainPassword);
        $user->setPassword($password);
        $user->setEmail('testlogin@gmail.com');
        $user->setRoles(array('ROLE_USER'));

        $em = $client->getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = $user->getUsername();
        $form['_password'] = $plainPassword;

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