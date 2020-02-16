<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
* @IsGranted("ROLE_USER")
*/

class EventController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function home()
    {
        if($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('home');
        }

    }


    /**
     * @Route("/home", name="home")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $user = $this->getUser();

        $events = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findUser($user);

        $pagination = $paginator->paginate(
            $events, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('tele_comm/index.html.twig',  [
            'events' => $pagination
        ]);
    }

    /**
     * @Route("event/{id}/delete", name="event_delete")
     * @Security("is_granted('ROLE_USER')")
     */
    public function delete(Event $event,ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('DELETE',$event);
        $manager->remove($event);
        $manager->flush();
        $this->addFlash(
            'warning',
            'Votre événement a été supprimé.'
        );
        return $this->redirectToRoute('home');

    }



    /**
     * @Route ("/new", name="event_create")
     * @Route ("event/{id}/edit", name="event_edit")
     */
    public function form(Event $event = null, Request $request, ObjectManager $manager)
    {

        if (!$event) {
            $event = new Event();
        }
        else {
            $this->denyAccessUnlessGranted('EDIT',$event);
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
     * @Route("event/{id}/show", name="event_show")
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
