<?php

namespace App\Services;

use App\Form\Model\EventSearch;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EventService
{
    private readonly string $BASE_URL;

    public function __construct(private HttpClientInterface $httpClient)
    {
        $this->BASE_URL = "https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda";
    }

    public function getDataFromAPI(EventSearch $eventSearch)
    {
        $url = $this->BASE_URL;

        if ($eventSearch->getCity()) {
            $url .= '&refine.location_city=' . $eventSearch->getCity();
        }

        if ($eventSearch->getStartDate()) {
            $url .= '&refine.firstdate_begin=' . $eventSearch->getStartDate()->format('Y-m-d');
        }

        $data = $this->httpClient->request('GET', $url)->toArray();

        return $data['records'];
    }


}
