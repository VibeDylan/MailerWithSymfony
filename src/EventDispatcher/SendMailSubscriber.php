<?php

namespace App\EventDispatcher;


use App\Event\SendMailEvent;

use App\Repository\DepartementRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendMailSubscriber implements EventSubscriberInterface {

    private $departementRepository;
    private $mailer;

    public function __construct(DepartementRepository $departementRepository, MailerInterface $mailer) {
        $this->departementRepository = $departementRepository;
        $this->mailer = $mailer;
    }
    public static function getSubscribedEvents(): array
    {
        return [
            'send.mail' => 'sendMail'
        ];
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMail(SendMailEvent $event) {

        $data = $event->getInfo();
        $whoResponsable = $this->departementRepository->find($data['departement']);
       //  dd($event);

        $email = (new Email())
            ->from($data['mail'])
            ->to($whoResponsable->getResponsable())
            ->subject($data['object'])
            ->html($data['message']);


        $this->mailer->send($email);
    }
}