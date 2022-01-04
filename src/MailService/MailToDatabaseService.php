<?php

namespace App\MailService;

use App\Entity\ContactRequest;
use App\Entity\Messages;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MailToDatabaseService
{

    protected $departementRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em, DepartementRepository $departementRepository)
    {
        $this->em = $em;
        $this->departementRepository = $departementRepository;
    }

    public function saveMessageFromContactRequest(ContactRequest $contactRequest)
    {

        $message = new Messages();
        $message->setSender($contactRequest->getMail())
            ->setReceiver($contactRequest->getDepartement()->getResponsable())
            ->setSubject($contactRequest->getObject())
            ->setMessage($contactRequest->getMessage())
            ->setDepartement($contactRequest->getDepartement())
            ->setDepartementname($contactRequest->getDepartement()->getName());

        $this->em->persist($message);
        $this->em->flush($message);
    }
}
