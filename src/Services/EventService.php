<?php

namespace App\Services;

class EventService
{
    private readonly string $BASE_URL;

    public function __construct()
    {
        $this->BASE_URL = "https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda";
    }

    public function getDataFromAPI()
    {
        $json = file_get_contents($this->BASE_URL);
        $data = json_decode($json, true);

        return $data['records'];
    }


}
