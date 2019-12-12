<?php

namespace App\Controller;

use App\Entity\Greeting;
use App\Service\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/", name="home.")
 */
class HomeController extends AbstractController
{

    /**
     * @Route("show/{id<\d+>}", name="show")
     * @param $id
     * @param MessageGenerator $messageGenerator
     */

    public function show($id, MessageGenerator $messageGenerator)
    {
        $em = $this->getDoctrine()->getRepository(Greeting::class);
        $message = $em->find($id);

        if (!$message) {
            throw $this->createNotFoundException(
                'No record found for id '.$id
            );
        } else {
            $messageGenerator->getMessage($message->getGreeting());
        }
    }


    /**
     * @Route("{msg?}", name="greeting")
     * @param $msg
     * @param MessageGenerator $messageGenerator
     */

    public function index($msg, MessageGenerator $messageGenerator)
    {
        $messageGenerator->getMessage($msg);
    }

    /**
     * @Route("post/{msg?}", name="post")
     * @param $msg
     * @param MessageGenerator $messageGenerator
     */

    public function post($msg, MessageGenerator $messageGenerator)
    {
        $em = $this->getDoctrine()->getManager();
        $post = new Greeting();
        $post->setUsername("ozgun");
        $post->setGreeting($msg);

        $em->persist($post);
        $em->flush();

        $messageGenerator->getMessage("Saved...");
    }

    /**
     * @Route("update/{id<\d+>}/{msg?}", name="update")
     * @param $id
     * @param $msg
     * @param MessageGenerator $messageGenerator
     */

    public function update($id, $msg, MessageGenerator $messageGenerator)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository(Greeting::class)->find($id);

        if (!$message) {
            throw $this->createNotFoundException(
                'No record found for id '.$id
            );
        } else {
            $message->setGreeting($msg);
            $em->flush();
            $messageGenerator->getMessage($id . " Updated...");
        }

    }

    /**
     * @Route("delete/{id<\d+>}", name="delete")
     * @param $id
     * @param MessageGenerator $messageGenerator
     */

    public function delete(Greeting $id, MessageGenerator $messageGenerator)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$id) {
            throw $this->createNotFoundException(
                'No record found for id '.$id
            );
        } else {
            $em->remove($id);
            $em->flush();
            $messageGenerator->getMessage($id . " Deleted...");
        }

    }
}
