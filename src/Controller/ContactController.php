<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\DepartementRepository;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{


    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, DepartementRepository $departementRepository, MailerInterface $mailer)
    {

        $form = $this->createForm(ContactType::class);

        $formView = $form->createView();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $formSubmit = $request->get('contact');
            $whoResponsable = $departementRepository->find($formSubmit['departement']);

            $email = (new Email())
                ->from($formSubmit['mail'])
                ->to($whoResponsable->getResponsable())
                ->subject('Email de : ' . $formSubmit['name'] . ' ' . $formSubmit['prenom'])
                ->html($formSubmit['message']);

            $mailer->send($email);

            $this->addFlash('success', "Votre message à bien était envoyer");

            return $this->redirectToRoute("homepage");
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'formView' => $formView
        ]);
    }
}
