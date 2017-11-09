<?php

namespace Tests\AppBundle\Controller;

use AppBundle\DataFixtures\ORM\ControllerTestFixtures;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class GroupControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadFixtures(array(
            ControllerTestFixtures::class
        ));
    }

    public function testGetAllGroups()
    {
        $client = $this->makeClient();

        $client->request('GET', '/groups');

        $this->isSuccessful($client->getResponse());

        $actual = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(2, count($actual));
    }

    public function testGetGroup()
    {
        $client = $this->makeClient();

        $client->request('GET', '/groups/2');

        $this->isSuccessful($client->getResponse());

        $actual = json_decode($client->getResponse()->getContent(), true);
        $expected = [
            'id' => 2,
            'name' => 'dev'
        ];

        foreach ($expected as $key => $_) {
            $this->assertEquals($expected[$key], $actual[$key]);
        }

        $this->assertEquals(4, count($actual['users']));
    }

    public function testPutGroup()
    {
        $client = $this->makeClient();
        $groupUrl = '/groups/2';
        $client->request('PUT', $groupUrl, ['id' => 2, 'name' => 'developers']);

        $this->isSuccessful($client->getResponse());

        $actual = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($groupUrl, $client->getResponse()->headers->get('location'));
        $expected = [
            'id' => 2,
            'name' => 'developers'
        ];

        foreach ($expected as $key => $_) {
            $this->assertEquals($expected[$key], $actual[$key]);
        }

        $this->assertEquals(4, count($actual['users']));
    }
}