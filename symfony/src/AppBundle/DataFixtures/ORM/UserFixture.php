<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class UserFixture implements FixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (['foo', 'bar'] as $value) {
            $user = new User();
            $user->setUsername($value);
            $user->setToken($value);
            $manager->persist($user);
        }
        $manager->flush();
    }
}