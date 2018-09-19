<?php 

namespace tests\AppBundle\Entity; 

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;

Class TaskTest extends WebTestCase
{   
	public function testGetterAndSetterTask()
	{
		$user = new User;
		$user->setUsername('UserTest');
		$user->setPassword('usertest');
		$user->setEmail('usertest@gmail.com');
		$user->setRoles(array('ROLE_USER'));

		$task = new Task;
		$task->setTitle('TaskTest');
		$task->setContent('TaskTest');
		$task->SetUser($user);

		$this->assertSame('TaskTest', $task->getTitle());
		$this->assertSame('TaskTest', $task->getContent());
		$this->assertSame($user->getId(), $task->getUser()->getId());
	}
}