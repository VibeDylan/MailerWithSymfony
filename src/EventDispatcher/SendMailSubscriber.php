<?php

namespace App\EventDispatcher;


use App\Event\SendMailEvent;
use App\Repository\DepartementRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendMailSubscriber implements EventSubscriberInterface {

    private $departementRepository;

    public function __construct(DepartementRepository $departementRepository, MailerInterface $mailer) {
        $this->departementRepository = $departementRepository;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            'send.mail' => 'sendMail'
        ];
    }

    public function sendMail(Request $request) {

        $formSubmit = $request->get('contact');
        $whoResponsable = $this->departementRepository->find($formSubmit['departement']);

        $email = (new Email())
            ->from($formSubmit['mail'])
            ->to($whoResponsable->getResponsable())
            ->subject($formSubmit['object'])
            ->html($formSubmit['message']);


        $this->mailer->send($email);
    }
}