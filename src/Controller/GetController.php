<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GetController extends AbstractController
{
    /**
     * @Route("/get", name="get")
     */
    public function index(Request $request)
    {


        return $this->render('get/index.html.twig', [
            'controller_name' => 'GetController',
        ]);
    }
}
