<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class EventService
{
    private readonly string $BASE_URL;

    public function __construct(private HttpClientInterface $httpClient)
    {
        $this->BASE_URL = "https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda&refine.firstdate_begin=2026-03-01";
    }

    public function getDataFromAPI()
    {
        $data = $this->httpClient->request('GET', $this->BASE_URL)->toArray();

        return $data['records'];
    }


}
