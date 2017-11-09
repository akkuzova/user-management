<?php

namespace Tests\AppBundle\Controller;

use AppBundle\DataFixtures\ORM\ScenarioTestFixtures;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class UserControllerScenarioTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadFixtures(array(
            ScenarioTestFixtures::class
        ));
    }

    public function testCreateUsersIncludedInGroup()
    {
        $client = $this->makeClient();
        //check db is empty
        $client->request('GET', '/users');
        $this->isSuccessful($client->getResponse());
        $actual = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(0, count($actual));

        //create group
        $client->request('POST', '/groups',
            [
                'id' => 12,
                'name' => 'vipGroup'
            ]
        );
        $groupUrl = $client->getResponse()->headers->get('location');
        $actual = json_decode($client->getResponse()->getContent(), true);
        $groupId = $actual['id'];
        //create user in group
        $user = [
            'id' => 1,
            'email' => 'rabbit@wonderland.com',
            'first_name' => 'Alisa',
            'last_name' => 'Liddell',
            'state' => 'active',
            'group' => [
                'id' => $groupId,
                'name' => 'vipGroup'
            ]
        ];
        $client->request('POST', '/users', $user);
        $userUrl = $client->getResponse()->headers->get('location');

        //update user
        $client->request('PUT', $userUrl,
            [
                'id' => 1,
                'email' => 'rabbit@wonderland.com',
                'first_name' => 'Alisa',
                'last_name' => 'Liddell',
                'state' => 'non-active',
                'group' => [
                    'id' => 12,
                    'name' => 'vipGroup'
                ]
            ]
        );

        //check user
        $client->request('GET', $userUrl);
        $actual = json_decode($client->getResponse()->getContent(), true);
        $expected = [
            'email' => 'rabbit@wonderland.com',
            'first_name' => 'Alisa',
            'last_name' => 'Liddell',
            'state' => 'non-active',
            'group' => ['id' => 12, 'name' => 'deleted']
        ];

        foreach ($expected as $key => $_) {
            $this->assertEquals($expected[$key], $actual[$key]);
        }

        //check new group don't has users
        $client->request('GET', $groupUrl);
        $this->assertEquals(['id' => $groupId, 'name' => 'vipGroup', 'users' => []],
            json_decode($client->getResponse()->getContent(), true)
        );

        //check old group has Alisa
        $client->request('GET', '/groups/12');
        $actual = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Alisa', $actual['users'][0]['first_name']);
    }
}