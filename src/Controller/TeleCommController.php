<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* @IsGranted("ROLE_USER")
*/

class TeleCommController extends AbstractController
{
    /**
     * @Route("/", name="tele_comm")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Event::class);

        $events = $repo->findAll();

        return $this->render('tele_comm/index.html.twig', [
            'controller_name' => 'TeleCommController',
            'events' => $events
        ]);
    }
}
