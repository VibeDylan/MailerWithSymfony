<?php

namespace App\Controller;

use App\Event\SendMailEvent;
use App\Form\ContactType;
use App\MailService\MailToDatabaseService;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{

    /**
     * @Route("/", name="contact")
     */
    public function create(Request $request, MailToDatabaseService $message, EventDispatcherInterface $eventDispatcher)
    {

        $form = $this->createForm(ContactType::class);
        $formView = $form->createView();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $message->saveMessage($request);

            $emailEvent = new SendMailEvent($request->get('contact'));
            $eventDispatcher->dispatch($emailEvent, 'send.mail');


            $this->addFlash("success", "Votre message à bien était envoyé");
        }


        return $this->render('contact/index.html.twig', [
            'formView' => $formView
        ]);
    }
}
