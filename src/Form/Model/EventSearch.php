<?php

namespace App\Form\Model;

class EventSearch
{
    private string $city;
    private \DateTime $startDate;

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }
    
}
