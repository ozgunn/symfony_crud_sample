<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\VarDumper\VarDumper;


/**
 * @Route("/form", name="form.")
 */

class FormController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(Request $request)
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('form/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash("notice", "User created...");
            return $this->redirectToRoute("form.list");
        }

        return $this->render('form/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, $id)
    {
        //$user = new User();

        $edit = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $edit);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            //$em->persist($user);
            $em->flush();
            $this->addFlash("notice", "User updated...");
            return $this->redirectToRoute("form.list");
        }

        return $this->render('form/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(User $id)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$id) {
            throw $this->createNotFoundException(
                'No record found for id '.$id
            );
        } else {
            $em->remove($id);
            $em->flush();
        }

        $this->addFlash("notice", "User deleted...");
        return $this->redirectToRoute("form.list");
    }
}
