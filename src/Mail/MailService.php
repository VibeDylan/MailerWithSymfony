<?php

namespace App\Controller\Mail;

use App\Entity\Messages;
use Symfony\Component\Mime\Email;
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

    public function sendMail(Request $request)
    {
        $formSubmit = $request->get('contact');
        $whoResponsable = $this->departementRepository->find($formSubmit['departement']);

        $email = (new Email())
            ->from($formSubmit['mail'])
            ->to($whoResponsable->getResponsable())
            ->subject('Email de : ' . $formSubmit['name'] . ' ' . $formSubmit['prenom'])
            ->html($formSubmit['message']);


        $this->mailer->send($email);
    }
}
