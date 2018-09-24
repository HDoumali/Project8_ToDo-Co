<?php 

namespace tests\AppBundle\Controller; 

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


Class TaskControllerTest extends WebTestCase
{
	private $client;

	public function setUp()
	{
		$this->client = static::createClient();
	}

	public function testListTask()
	{
		$client = $this->createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'test2';
        $form['_password'] = 'test2';

        $client->submit($form);

        $crawler = $client->followRedirect();

        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
		$crawler = $client->click($link);

		$this->assertSame(1, $crawler->filter('html:contains("Marquer comme faite")')->count());
	}

	public function testCreateTask()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/login');

		$form = $crawler->selectButton('Se connecter')->form();
		$form['_username'] = 'test2';
		$form['_password'] = 'test2';

		$client->submit($form);

		$crawler = $client->followRedirect();

		$link = $crawler->selectLink('Créer une nouvelle tâche')->link();
		$crawler = $client->click($link);

		$this->assertSame(200, $client->getResponse()->getStatusCode());

		$form = $crawler->selectButton('Ajouter')->form();
		$form['task[title]'] = 'Test create';
		$form['task[content]'] = 'Test create';

		$client->submit($form);

		$crawler = $client->followRedirect();

		$this->assertSame(1, $crawler->filter('div.alert.alert-success:contains("Superbe ! La tâche a été bien été ajoutée")')->count());
	}

	public function testEditTask()
	{
		$this->logIn();
        
		$crawler = $this->client->request('GET', '/tasks/29/edit');

		$this->assertSame(1, $crawler->filter('html:contains("Title")')->count());
		$this->assertSame(1, $crawler->filter('html:contains("Content")')->count());

		$form = $crawler->selectButton('Modifier')->form();
		$form['task[title]'] = 'Test edit';
		$form['task[content]'] = 'Test edit';

		$this->client->submit($form);

		$crawler = $this->client->followRedirect();

		$this->assertSame(1, $crawler->filter('div.alert.alert-success:contains("Superbe ! La tâche a bien été modifiée.")')->count()); 
	}

	public function testDeleteAnAssociatedTask()
	{
		$crawler = $this->client->request('GET', '/tasks/77/delete', array(), array(), array(
    		'PHP_AUTH_USER' => 'test2',
    		'PHP_AUTH_PW'   => 'test2',
		));

		$crawler = $this->client->followRedirect();

		$this->assertSame(1, $crawler->filter('div.alert.alert-success:contains("Superbe ! La tâche a bien été supprimée.")')->count());		
	}

	public function testDeleteAnUnassociatedTask()
	{
		$crawler = $this->client->request('GET', '/tasks/25/delete', array(), array(), array(
    		'PHP_AUTH_USER' => 'test2',
    		'PHP_AUTH_PW'   => 'test2',
		));

		$crawler = $this->client->followRedirect();

		$this->assertSame(1, $crawler->filter('div.alert.alert-success:contains("Superbe ! Vous ne pouvez pas supprimer cette tache.")')->count());	
	}

	public function testDeleteAnAnonymousTaskByUser()
	{
		$crawler = $this->client->request('GET', '/tasks/78/delete', array(), array(), array(
    		'PHP_AUTH_USER' => 'Hassan',
    		'PHP_AUTH_PW'   => 'hassan',
		));

		$crawler = $this->client->followRedirect();

		$this->assertSame(1, $crawler->filter('div.alert.alert-success:contains("Superbe ! Vous ne pouvez pas supprimer cette tache.")')->count());	
	}

	public function testDeleteAnAnonymousTaskByAdmin()
	{
		$crawler = $this->client->request('GET', '/tasks/78/delete', array(), array(), array(
    		'PHP_AUTH_USER' => 'test2',
    		'PHP_AUTH_PW'   => 'test2',
		));

		$crawler = $this->client->followRedirect();

		$this->assertSame(1, $crawler->filter('div.alert.alert-success:contains("Superbe ! La tâche a bien été supprimée.")')->count());	
	}

	Public function testToggleTask()
	{
		$this->logIn();

		$crawler = $this->client->request('GET', '/tasks/25/toggle');

		$this->assertSame(302, $this->client->getResponse()->getStatusCode()); //StatusCode 302 : Redirection d'URL non permanentes

		$crawler = $this->client->followRedirect();

		$this->assertSame(200, $this->client->getResponse()->getStatusCode());
		$this->assertSame(1, $crawler->filter('div.alert.alert-success:contains("a bien été marquée comme faite.")')->count());
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