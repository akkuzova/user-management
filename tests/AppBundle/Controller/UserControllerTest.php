<?php

namespace Tests\AppBundle\Controller;

use AppBundle\DataFixtures\ORM\ControllerTestFixtures;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadFixtures(array(
            ControllerTestFixtures::class
        ));
    }

    public function testGetAllUsers()
    {
        $client = $this->makeClient();

        $client->request('GET', '/users');

        $this->isSuccessful($client->getResponse());

        $actual = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(5, count($actual));
    }

    public function testGetUser()
    {
        $client = $this->makeClient();

        $client->request('GET', '/users/1');

        $this->isSuccessful($client->getResponse());

        $actual = json_decode($client->getResponse()->getContent(), true);
        $expected = [
            'id' => 1,
            'email' => 'i.ivanov@mail.ru',
            'first_name' => 'Ivan',
            'last_name' => 'Ivanov',
            'state' => 'active',
            'group' => [
                'id' => 1,
                'name' => 'admins'
            ]
        ];

        foreach ($expected as $key => $_) {
            $this->assertEquals($expected[$key], $actual[$key]);
        }
    }

    public function testPutUser()
    {
        $client = $this->makeClient();
        $userUrl = '/users/1';
        $client->request(
            'PUT',
            $userUrl, [
            'id' => 1,
            'email' => 'nactacia.a@gmail.com',
            'first_name' => 'Anastasia',
            'last_name' => 'Ivanova',
            'state' => 'active',
            'group' => [
                'id' => 2,
                'name' => 'admins'
            ]
        ]);

        $this->isSuccessful($client->getResponse());

        $actual = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($userUrl, $client->getResponse()->headers->get('location'));
        $expected = [
            'id' => 1,
            'email' => 'nactacia.a@gmail.com',
            'first_name' => 'Anastasia',
            'last_name' => 'Ivanova',
            'state' => 'active',
            'group' => [
                'id' => 2,
                'name' => 'dev'
            ]
        ];

        foreach ($expected as $key => $_) {
            $this->assertEquals($expected[$key], $actual[$key]);
        }
    }
}