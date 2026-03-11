<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wishes', name: 'wish_')]
final class WishController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy(['isPublished' => true], ['dateCreated' => 'DESC']);

        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes
        ]);
    }

    #[Route('/{id}', name: 'detail', requirements: ['id' => '[0-9]+'])]
    public function detail(Wish $id, WishRepository $wishRepository): Response
    {
//        $wish = $wishRepository->find($id);

        return $this->render('wish/detail.html.twig', [
            'wish' => $id
        ]);
    }
}
