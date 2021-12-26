<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\DepartementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, DepartementRepository $departementRepository): Response
    {

        $form = $this->createForm(ContactType::class);

        $formView = $form->createView();


        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'formView' => $formView
        ]);
    }
}
