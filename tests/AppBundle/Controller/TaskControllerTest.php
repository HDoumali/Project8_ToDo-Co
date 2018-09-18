<?php 

namespace tests\AppBundle\Controller; 

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;

Class TaskControllerTest extends WebTestCase
{
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
		$client = static::createClient();
		$crawler = $client->request('GET', '/login');

		$form = $crawler->selectButton('Se connecter')->form();
		$form['_username'] = 'test2';
		$form['_password'] = 'test2';

		$client->submit($form);

		$crawler = $client->followRedirect();
        
		$crawler = $client->request('GET', '/tasks/29/edit');

		$this->assertSame(1, $crawler->filter('html:contains("Title")')->count());
		$this->assertSame(1, $crawler->filter('html:contains("Content")')->count());

		$form = $crawler->selectButton('Modifier')->form();
		$form['task[title]'] = 'Test edit';
		$form['task[content]'] = 'Test edit';

		$client->submit($form);

		$crawler = $client->followRedirect();

		$this->assertSame(1, $crawler->filter('div.alert.alert-success:contains("Superbe ! La tâche a bien été modifiée.")')->count()); 
	}
}