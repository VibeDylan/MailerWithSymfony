<?php

namespace App\Controller\Mail;

use App\Entity\Messages;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DepartementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MailService extends AbstractController
{

    private $departementRepository;

    public function __construct(DepartementRepository $departementRepository, MailerInterface $mailer)
    {
        $this->departementRepository = $departementRepository;
        $this->mailer = $mailer;
    }


    public function sendMail(Request $request, EntityManagerInterface $em)
    {
        $formSubmit = $request->get('contact');
        $whoResponsable = $this->departementRepository->find($formSubmit['departement']);

        $email = (new Email())
            ->from($formSubmit['mail'])
            ->to($whoResponsable->getResponsable())
            ->subject('Email de : ' . $formSubmit['name'] . ' ' . $formSubmit['prenom'])
            ->html($formSubmit['message']);

        $message = new Messages();
        $message->setSender($formSubmit['mail'])
            ->setReceiver($whoResponsable->getResponsable())
            ->setSubject('Email de : ' . $formSubmit['name'] . ' ' . $formSubmit['prenom'])
            ->setMessage($formSubmit['message']);


        $em->persist($message);
        $em->flush($message);

        $this->mailer->send($email);
    }
}
