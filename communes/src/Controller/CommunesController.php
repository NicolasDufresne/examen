<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommunesController extends AbstractController
{
    /**
     * @Route("/communes", name="communes")
     */
    public function index()
    {
        return $this->render('communes/index.html.twig', [
            'controller_name' => 'CommunesController',
        ]);
    }
}
