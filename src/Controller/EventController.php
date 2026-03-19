<?php

namespace App\Controller;

use App\Services\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventController extends AbstractController
{
    #[Route('/events', name: 'event_list')]
    public function list(EventService $eventService): Response
    {

        $events = $eventService->getDataFromAPI();
        return $this->render('event/list.html.twig', [
            'events' => $events
        ]);
    }
}
