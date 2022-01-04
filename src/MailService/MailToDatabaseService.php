<?php

namespace App\MailService;

use App\Entity\Contact;
use App\Entity\Messages;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class MailToDatabaseService
{

    protected $departementRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;
    private $logger;

    public function __construct(EntityManagerInterface $em, DepartementRepository $departementRepository, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->departementRepository = $departementRepository;
        $this->logger = $logger;
    }

    public function saveMessageFromContactRequest(Contact $contactRequest)
    {

        $this->logger->info("Departement choisis : " . $contactRequest->getDepartement()->getName());

        $message = new Messages();
        $message->setSender($contactRequest->getMail())
            ->setReceiver($contactRequest->getDepartement()->getResponsable())
            ->setSubject($contactRequest->getObject())
            ->setMessage($contactRequest->getMessage())
            ->setDepartement($contactRequest->getDepartement());

        $this->em->persist($message);
        $this->em->flush($message);
    }
}
