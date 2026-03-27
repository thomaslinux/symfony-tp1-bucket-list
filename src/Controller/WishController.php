<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\Model\WishSearch;
use App\Form\WishSearchType;
use App\Form\WishType;
use App\Repository\CategoryRepository;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function PHPUnit\Framework\throwException;

#[Route('/wishes', name: 'wish_')]
final class WishController extends AbstractController
{
    #[Route('', name: 'list')]
    #[Route('/category/{id}', name: 'list_by_category', requirements: ['id' => '\d+'])]
    public function list(
        WishRepository $wishRepository,
        Request        $request
    ): Response
    {

        $wishSearch = new WishSearch();
        $wishForm = $this->createForm(WishSearchType::class, $wishSearch);
        $wishForm->handleRequest($request);

        $wishes = $wishRepository->findWishesBySearch($wishSearch);

        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes,
            'wishForm' => $wishForm
        ]);
    }

    #[Route("/create", 'create', methods: ['POST', 'GET'])]
    #[Route("/add", 'add', methods: ['POST', 'GET'])]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);
        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            // appel à des services
            $wish->setIsPublished(true);
            $wish->setDateCreated(new \DateTime());

            $wish->setAuthor($this->getUser());
            $entityManager->persist($wish);
            $entityManager->flush();

//            $this->addFlash('sucess', 'Wish' . $wish->getTitle() . 'added !');
            $this->addFlash('success', 'Idea successfully added!');
            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }

        return $this->render('wish/create.html.twig', [
            'wishForm' => $wishForm->createView()
        ]);
    }


    #[Route("/update/{id}", 'update', methods: ['POST', 'GET'])]
    public function update(
        int                    $id,
        WishRepository         $wishRepository,
        Request                $request,
        EntityManagerInterface $entityManager
    )
    {
        $wish = $wishRepository->find($id);
        if ($this->getUser() !== $wish->getAuthor()) {
            throw $this->createAccessDeniedException('Not your wish');
        }
        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $entityManager->persist($wish);;
            $entityManager->flush();
            $this->addFlash('success', 'Wish updated !');

            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }

        return $this->render('wish/update.html.twig', [
            'wishForm' => $wishForm
        ]);

    }

    #[Route("/delete/{id}", 'delete', methods: ['POST', 'GET'])]
    public function delete(
        int                    $id,
        WishRepository         $wishRepository,
        Request                $request,
        EntityManagerInterface $entityManager

    )
    {
        $wish = $wishRepository->find($id);

        if ($this->getUser() !== $wish->getAuthor() && !$this->isGranted("ROLE_ADMIN")) {
            throw $this->createAccessDeniedException('Deletion not allowed');
        }

        $entityManager->remove($wish);
        $entityManager->flush();

        $this->addFlash('success', 'Wish deleted !');
        return $this->redirectToRoute('wish_list');

    }

    #[Route('/detail/{id}', name: 'detail', requirements: ['id' => '[0-9]+'])]
    public function detail(Wish $id, WishRepository $wishRepository): Response
    {
//        $wish = $wishRepository->find($id);

        return $this->render('wish/detail.html.twig', [
            'wish' => $id
        ]);
    }
}
