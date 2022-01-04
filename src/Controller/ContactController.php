<?php

namespace App\Controller;

use App\Entity\ContactRequest;
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
    public function create(Request $request, MailToDatabaseService $mailToDatabaseService, EventDispatcherInterface $eventDispatcher)
    {
        $contactRequest = new ContactRequest();
        $form = $this->createForm(ContactType::class, $contactRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mailToDatabaseService->saveMessageFromContactRequest($contactRequest);

            $emailEvent = new SendMailEvent($contactRequest);
            $eventDispatcher->dispatch($emailEvent, 'send.mail');

            $this->addFlash("success", "Votre message à bien était envoyé");
        }


        return $this->render('contact/index.html.twig', [
            'formView' => $form->createView()
        ]);
    }
}
