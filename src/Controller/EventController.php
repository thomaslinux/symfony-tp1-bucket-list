<?php

namespace App\Controller;

use App\Form\EventSearchType;
use App\Form\Model\EventSearch;
use App\Services\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventController extends AbstractController
{
    #[Route('/events', name: 'event_list')]
    public function list(EventService $eventService, Request $request): Response
    {

        $eventSearch = new EventSearch();
        $eventForm = $this->createForm(EventSearchType::class, $eventSearch);
        $eventForm->handleRequest($request);

        dump($eventSearch);

        $events = $eventService->getDataFromAPI($eventSearch);

        return $this->render('event/list.html.twig', [
            'events' => $events,
            'eventForm' => $eventForm
        ]);
    }
}
