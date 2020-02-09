<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* @IsGranted("ROLE_USER")
*/

class TeleCommController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->redirectToRoute('tele_comm');

    }


    /**
     * @Route("/home", name="tele_comm")
     */
    public function index()
    {
        $user = $this->getUser();

        $repo = $this->getDoctrine()->getRepository(Event::class);

        $events = $repo->findBy(['addedBy'=>$user]);

        return $this->render('tele_comm/index.html.twig', [
            'controller_name' => 'TeleCommController',
            'events' => $events
        ]);
    }

    /**
     * @Route("/{id}/delete", name="event_delete")
     */
    public function delete(Event $event,ObjectManager $manager)
    {
        $manager->remove($event);
        $manager->flush();
        $this->addFlash(
            'warning',
            'Votre événement a bien été supprimé.'
        );


        return $this->redirectToRoute('tele_comm');

    }



    /**
     * @Route ("/new", name="event_create")
     * @Route ("/{id}/edit", name="event_edit")
     */
    public function form(Event $event = null, Request $request, ObjectManager $manager)
    {

        if (!$event) {
            $event = new Event();
        }

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$event->getId()) {
                $event->setStart(new \DateTime())
                    ->setOnline(false)
                    ->setAllDisplays(true)
                    ->setAddedBy($user);
            }

            $event->setOnline(false);

            $manager->persist($event);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre événement a bien été enregistré'
            );

            return $this->redirectToRoute('event_show', ['id' => $event->getId()]);
        }

        return $this->render('tele_comm/create.html.twig', [
            'formEvent' => $form->createView(),
            'editMode' => $event->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}", name="event_show")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Event::class);

        $event = $repo->find($id);

        return $this->render('tele_comm/show.html.twig', [
            'event' => $event
        ]);
    }







}
