<?php

namespace Tests\AppBundle\Controller;


use AppBundle\DataFixtures\ORM\ControllerTestFixtures;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

class ExceptionTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        $this->loadFixtures(array(
            ControllerTestFixtures::class
        ));
        $this->client = $this->makeClient();


    }

    public function testInvalidEmail()
    {
        $this->client->request('PUT', '/users/1',
            [
                'id' => 1,
                'email' => 'i.ivanov@ru',
                'first_name' => 'Ivan',
                'last_name' => 'Ivanov',
                'state' => 'active',
                'group' => [
                    'id' => 1,
                    'name' => 'admins'
                ]
            ]
        );

        $this->assertEquals(
            '{"children":{"id":{},"email":{"errors":["This value is not a valid email address."]},"first_name":{},"last_name":{},"creation_date":{},"state":{},"group":{}}}',
            $this->client->getResponse()->getContent());
        $this->assertStatusCode(400, $this->client);
    }

    public function testEmptyFields()
    {
        $this->client->request('PUT', '/users/1',
            [
                'id' => 1,
                'email' => 'i.ivanov@mail.ru',
                'first_name' => '',
                'last_name' => 'Ivanov',
                'state' => '',
                'group' => [
                    'id' => 1,
                    'name' => 'admins'
                ]
            ]
        );

        $this->assertEquals(
            '{"children":{"id":{},"email":{},"first_name":{"errors":["This value should not be blank."]},"last_name":{},"creation_date":{},"state":{"errors":["This value should not be blank."]},"group":{}}}',
            $this->client->getResponse()->getContent());
        $this->assertStatusCode(400, $this->client);
    }

    public function testDuplicateEmail()
    {
        $this->client->request('POST', '/users',
            [
                'id' => 1,
                'email' => 'i.ivanov@mail.ru',
                'first_name' => 'Ivan',
                'last_name' => 'Ivanov',
                'state' => 'active',
                'group' => [
                    'id' => 1,
                    'name' => 'admins'
                ]
            ]
        );

        $this->assertEquals(
            '{"children":{"id":{},"email":{"errors":["Email is already exists"]},"first_name":{},"last_name":{},"creation_date":{},"state":{},"group":{}}}',
            $this->client->getResponse()->getContent());
        $this->assertStatusCode(400, $this->client);
    }

    public function testDuplicateGroupName()
    {
        $this->client->request('POST', '/groups',
            [
                'id' => 1,
                'name' => 'admins'
            ]
        );

        $this->assertEquals(
            '{"children":{"id":{},"name":{"errors":["Group with this name already exists"]}}}',
            $this->client->getResponse()->getContent());
        $this->assertStatusCode(400, $this->client);
    }
}