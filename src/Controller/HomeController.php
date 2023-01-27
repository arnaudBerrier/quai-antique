<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('pages/home/index.html.twig');
    }

    #[Route('/about', 'about.index', methods:['GET'])]
    public function about(): Response
    {
        return $this->render('pages/home/about.html.twig');
    }
}
