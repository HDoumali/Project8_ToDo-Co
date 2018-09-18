<?php 

namespace tests\AppBundle\Controller; 

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;

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
}