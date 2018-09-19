<?php 

namespace tests\AppBundle\Entity; 

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;

Class UserTest extends WebTestCase
{   
	public function testGetterAndSetterUser()
	{
		$user = new User;
		$user->setUsername('UserTest');
		$user->setPassword('usertest');
		$user->setEmail('usertest@gmail.com');
		$user->setRoles(array('ROLE_USER'));

		$this->assertSame('UserTest', $user->getUsername());
		$this->assertSame('usertest', $user->getPassword());
		$this->assertSame('usertest@gmail.com', $user->getEmail());
		$this->assertSame(array('ROLE_USER'), $user->getRoles());
		$this->assertNull($user->getSalt());
	}
}