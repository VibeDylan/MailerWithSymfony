<?php

namespace App\Controller;

use App\MailService\MailService;
use App\Form\ContactType;
use App\MailService\MailToDatabaseService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact")
     */
    public function create(Request $request, MailService $mail, MailToDatabaseService $message)
    {

        $form = $this->createForm(ContactType::class);
        $formView = $form->createView();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mail->sendMail($request);
            $message->saveMessage($request);
            $this->addFlash("success", "Votre message à bien était envoyé");
        }


        return $this->render('contact/index.html.twig', [
            'formView' => $formView
        ]);
    }
}
