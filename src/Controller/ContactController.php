<?php

namespace App\Controller;

use App\Controller\Mail\MailService;
use App\Form\ContactType;
use App\Repository\DepartementRepository;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{


    private $departementRepository;
    private $mailer;

    public function __construct(DepartementRepository $departementRepository, MailerInterface $mailer)
    {
        $this->departementRepository = $departementRepository;
        $this->mailer = $mailer;
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
    {

        $form = $this->createForm(ContactType::class);

        $formView = $form->createView();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mail = new MailService($this->departementRepository, $this->mailer);
            $mail->sendMail($request);

            $this->addFlash("success", "Votre message à bien était envoyé");

            return $this->redirectToRoute("homepage");
        }

        return $this->render('contact/index.html.twig', [
            'formView' => $formView
        ]);
    }
}
