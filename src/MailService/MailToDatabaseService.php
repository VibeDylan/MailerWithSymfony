<?php

namespace App\MailService;

use App\Entity\Messages;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MailToDatabaseService extends AbstractController
{

    public function saveMessage(Request $request, EntityManagerInterface $em, DepartementRepository $departementRepository)
    {

        $formSubmit = $request->get('contact');
        $whoResponsable = $departementRepository->find($formSubmit['departement']);

        $message = new Messages();
        $message->setSender($formSubmit['mail'])
            ->setReceiver($whoResponsable->getResponsable())
            ->setSubject('Email de : ' . $formSubmit['name'] . ' ' . $formSubmit['prenom'])
            ->setMessage($formSubmit['message']);

        $em->persist($message);
        $em->flush($message);
    }
}
