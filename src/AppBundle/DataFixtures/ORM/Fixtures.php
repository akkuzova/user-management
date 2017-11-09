<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;

class Fixtures extends Fixture
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
        $adminsGroup->setId(1);
        $adminsGroup->setName('admins');
        $manager->persist($adminsGroup);

        $devGroup = new Group();
        $devGroup->setId(2);
        $devGroup->setName('dev');
        $manager->persist($devGroup);

        $admin = new User();
        $admin->setId(1);
        $admin->setEmail('i.ivanov@mail.ru');
        $admin->setFirstName('Ivan');
        $admin->setLastName('Ivanov');
        $admin->setState('active');
        $admin->setGroup($adminsGroup);
        $manager->persist($admin);

        for ($i = 2; $i <= 5; $i++) {
            $user = new User();
            $user->setId($i);
            $user->setEmail("i.ivanov_$i@mail.ru");
            $user->setFirstName("Ivan$i");
            $user->setLastName("Ivanov$i");
            $user->setState('active');
            $user->setGroup($devGroup);
            $manager->persist($user);
        }
        
        $manager->flush();
    }
}