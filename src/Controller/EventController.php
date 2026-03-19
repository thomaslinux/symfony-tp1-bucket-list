<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventController extends AbstractController
{
    #[Route('/events', name: 'event_list')]
    public function list(): Response
    {

        $json = file_get_contents("https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda");
        $data = json_decode($json, true);

        return $this->render('event/list.html.twig', [
            'events' => $data['records']
        ]);
    }
}
