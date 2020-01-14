<?php

namespace App\DataFixtures;

use App\Entity\Display;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i<=20; $i++){
            $user = new User();
            $user->setUsername("user$i")
                ->setEmail("user$i@ec-m.fr")
                ->setPassword("testtest")
                ->setFirstName("User$i")
                ->setLastName("Utilisateur$i");
            $manager->persist($user);

            $display = new Display();
            $display->setName("écran $i")
                    ->setToken("https://telecomm.ginfo.ec-m.fr/display/$i");
            if($i > 10) {
                $display->setActive(true);
            } else {
                $display->setActive(false);
            }
            $manager->persist($display);

            for($j = 1; $j<=3; $j++){
                $event = new Event();
                $event->setName("Evénement $j")
                      ->setLocation("Amphi 1")
                      ->setStart(new \DateTime())
                      ->setEnd(new \DateTime())
                      ->setAddedBy($user);
                if($j == 3){
                    $event->setOnline(false);
                } else {
                    $event->setOnline(true);
                }
                if($j == 2){
                    $event->setAllDisplays(true);
                } else {
                    $event->setAllDisplays(false)
                          ->addDisplay($display);
                }
                $manager->persist($event);
            }
        }

        $manager->flush();
    }
}
