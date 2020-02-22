<?php

namespace App\Controller;

use App\Entity\Display;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_MODERATOR")
 */
class ModerationController extends AbstractController
{



    /**
     * @Route("/admin/online", name="online_admin")
     */
    public function online (){
        $repo = $this->getDoctrine()->getRepository(Event::class);

        $events = $repo->findAll();


        return $this->render('moderation/online.html.twig', [
            'events' => $events
        ]);

    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index (){
        $qb = $this->getDoctrine()->getRepository(Event::class)
            ->createQueryBuilder('e');
        $nbEvts = $qb->select('COUNT(e)')
            ->andWhere('e.online = false')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $nbEvtsOnline = $this->getDoctrine()->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->select('COUNT(e)')
            ->andWhere('e.online = true')
            ->getQuery()
            ->getSingleScalarResult();

        $nbDisplayOn = $this->getDoctrine()->getRepository(Display::class)
            ->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->andWhere('d.active = true')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $nbDisplay = $this->getDoctrine()->getRepository(Display::class)
            ->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $nbUsers = $this->getDoctrine()->getRepository(User::class)
            ->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->getQuery()
            ->getSingleScalarResult()
        ;


        $role = "ROLE_ADMIN";

        $nbAdmin = $this->getDoctrine()->getRepository(User::class)
            ->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', '%"'.'ROLE_ADMIN'.'"%')
            ->getQuery()
            ->getSingleScalarResult()
        ;


        return $this->render('admin/index.html.twig', [
            'nbEvnts' => $nbEvts,
            'nbEvntsOnline' => $nbEvtsOnline,
            'nbDisplayOn' => $nbDisplayOn,
            'nbDisplay' => $nbDisplay,
            'nbUsers' => $nbUsers,
            'nbAdmin' => $nbAdmin,
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

    /**
     * @Route("/admin/events", name="event_admin")
     */
    public function moderation (){

        $repo = $this->getDoctrine()->getRepository(Event::class);

        $events = $repo->findAll();

        return $this->render('moderation/moderation.html.twig', [
            'events' => $events
        ]);
    }
}
