<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/hello', name: 'main_hello')]
    public function hello(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/', name: 'main_home')]
    public function home(): Response
    {
        $username = '<strong>Thomas</strong>';
        return $this->render('main/home.html.twig', [
            'user' => $username
        ]);
    }

    #[Route("/about", 'main_about_us')]
    public function about(): Response
    {
        return $this->render('main/about.html.twig');
    }
}
