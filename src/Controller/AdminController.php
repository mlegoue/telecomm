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
 * @IsGranted("ROLE_ADMIN")
 */

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/administrator", name="list_admin")
     */
    public function admin (){

        $repo = $this->getDoctrine()->getRepository(User::class);

        $users = $repo->findAll();
        $useronline = $this->getUser();

        return $this->render('admin/admin.html.twig', [
            'users' => $users,
            'userOnline' => $useronline
        ]);
    }

    /**
     * @Route("admin/{id}/nameadmin", name="name_admin")
     */

    public function nameadmin(User $user,ObjectManager $manager)
    {

        $user -> setRoles(["ROLE_ADMIN"]);

        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'success',
            ($user->getFullName()) . ' est maintenant administrateur.'
        );


        return $this->redirectToRoute('list_admin');

    }

    /**
     * @Route("admin/{id}/blockadmin", name="block_admin")
     */

    public function blockadmin(User $user,ObjectManager $manager)
    {
        $useronline = $this->getUser();
        if (($user->getRoles()[0]) == "ROLE_ADMIN"){
            if ($user->getId() == $useronline->getId()){
                $this->addFlash(
                    'warning',
                    'Vous ne pouvez pas vous destituer vous-même.'
                );
            } else {
                $user -> setRoles(["ROLE_USER"]);
                $this->addFlash(
                    'warning',
                    'Vous avez destitué ' . ($user->getFullName()) . ' de son rôle d\'administrateur.'
                );
                $manager->persist($user);
                $manager->flush();
            }
        }else{
            $this->addFlash(
                'warning',
                ($user->getFullName()) . ' n\'est pas administrateur.'
            );
        }


        return $this->redirectToRoute('list_admin');

    }

    /**
     * @Route("/admin/display", name="display_admin")
     */
    public function display (){
        $repo = $this->getDoctrine()->getRepository(Display::class);

        $displays = $repo->findAll();


        return $this->render('admin/display.html.twig', [
            'displays' => $displays
        ]);

    }

    /**
     * @Route("admin/{id}/namemoderator", name="name_moderator")
     */

    public function namemoderator(User $user,ObjectManager $manager)
    {
        $useronline = $this->getUser();
        if ($user->getId() != $useronline->getId()) {
            $user->setRoles(["ROLE_MODERATOR"]);

            $this->addFlash(
                'success',
                ($user->getFullName()) . ' est maintenant modérateur.'
            );
            $manager->persist($user);
            $manager->flush();
        }else{
            $this->addFlash(
                'warning',
                'Vous ne pouvez pas vous rétrograder vous-même.'
            );
        }


        return $this->redirectToRoute('list_admin');

    }

    /**
     * @Route("admin/{id}/blockmoderator", name="block_moderator")
     */

    public function blockmoderator(User $user,ObjectManager $manager)
    {
        if ($user->getRoles()[0] == "ROLE_MODERATOR"){
            $user -> setRoles(["ROLE_USER"]);
            $this->addFlash(
                'warning',
                'Vous avez destitué ' . ($user->getFullName()) . ' de son rôle de modérateur.'
            );
            $manager->persist($user);
            $manager->flush();
        } else {
            $this->addFlash(
                'warning',
                ($user->getFullName()) . ' n\'est pas modérateur.'
            );
        }





        return $this->redirectToRoute('list_admin');

    }
}
