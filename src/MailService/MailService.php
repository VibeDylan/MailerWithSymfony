<?php

namespace App\MailService;

use Symfony\Component\Mime\Email;
use App\Repository\DepartementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;


class MailService
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
            ->subject($formSubmit['mail'])
            ->html($formSubmit['message']);


        $this->mailer->send($email);
    }
}
