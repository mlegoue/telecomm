<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */

class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="event_admin")
     */
    public function index (){

        $repo = $this->getDoctrine()->getRepository(Event::class);

        $events = $repo->findAll();

        return $this->render('admin/index.html.twig', [
            'events' => $events
        ]);
    }

    /**
     * @Route("/display", name="display_admin")
     */
    public function display (){
        $repo = $this->getDoctrine()->getRepository(Event::class);

        $events = $repo->findAll();


        return $this->render('admin/display.html.twig', [
            'events' => $events
        ]);

    }

    /**
     * @Route("/validation/{id}", name="event_validate")
     */
    public function validate (Event $event, ObjectManager $manager ){

        $event -> setOnline(true);

        $manager->persist($event);
        $manager->flush();


        return $this->render('tele_comm/show.html.twig', [
            'event' => $event
        ]);
    }
}
