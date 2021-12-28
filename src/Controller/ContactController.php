<?php

namespace App\Controller;

use App\Controller\Mail\MailService;
use App\Form\ContactType;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{


    private $departementRepository;
    private $mailer;
    private $em;

    public function __construct(DepartementRepository $departementRepository, MailerInterface $mailer, EntityManagerInterface $em)
    {
        $this->departementRepository = $departementRepository;
        $this->mailer = $mailer;
        $this->em = $em;
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function create(Request $request)
    {

        $form = $this->createForm(ContactType::class);
        $formView = $form->createView();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mail = new MailService($this->departementRepository, $this->mailer, $this->em);
            $mail->sendMail($request, $this->em);

            $this->addFlash("success", "Votre message à bien était envoyé");

            return $this->redirectToRoute("homepage");
        }

        return $this->render('contact/index.html.twig', [
            'formView' => $formView
        ]);
    }
}
