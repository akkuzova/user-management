<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;

class ScenarioTestFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $userMetadata = $manager->getClassMetadata(User::class);
        $userMetadata->setIdGenerator(new AssignedGenerator());
        $userMetadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        $groupMetadata = $manager->getClassMetadata(Group::class);
        $groupMetadata->setIdGenerator(new AssignedGenerator());
        $groupMetadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        $adminsGroup = new Group();
        $adminsGroup->setId(12);
        $adminsGroup->setName('deleted');
        $manager->persist($adminsGroup);

        $manager->flush();
    }
}