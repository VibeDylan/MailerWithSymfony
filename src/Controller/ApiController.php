<?php

namespace App\Controller;



use App\Entity\Contact;
use App\Repository\DepartementRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ApiController extends AbstractController
{
    /**
     *@Route("/api", name="api")
     */
    public function index(DepartementRepository $departementRepository): Response
    {
        $departments = $departementRepository->findAll();

        return $this->json($departments, 200, [],   ['groups' => 'departement:read']);
    }

    /**
     *@Route("/api/postmail", name="api_postmail", methods={"POST"})
     *
     */
    public function postMail(Request $request) {

        $request->request->get('contact', 'default category');


        return $this->json($departments, 200, [],   ['groups' => 'departement:read']);
    }

}
