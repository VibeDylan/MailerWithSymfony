<?php

namespace App\MailService;

use App\Entity\Messages;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MailToDatabaseService
{

    public function __construct(EntityManagerInterface $em, DepartementRepository $departementRepository)
    {
        $this->em = $em;
        $this->departementRepository = $departementRepository;
    }

    public function saveMessage(Request $request)
    {
        $formSubmit = $request->get('contact');
        $whoResponsable = $this->departementRepository->find($formSubmit['departement']);

        $message = new Messages();
        $message->setSender($formSubmit['mail'])
            ->setReceiver($whoResponsable->getResponsable())
            ->setSubject($formSubmit['mail'])
            ->setMessage($formSubmit['message']);

        $this->em->persist($message);
        $this->em->flush($message);
    }
}
