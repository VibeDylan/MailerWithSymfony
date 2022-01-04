<?php

namespace App\EventDispatcher;


use App\Entity\ContactRequest;
use App\Event\SendMailEvent;

use App\Repository\DepartementRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
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


        $contactRequest = $event->getInfo();

        $email = (new Email())
            ->from($contactRequest->getMail())
            ->to($contactRequest->getDepartement()->getResponsable())
            ->subject($contactRequest->getObject())
            ->html($contactRequest->getMessage());


        $this->mailer->send($email);
    }
}