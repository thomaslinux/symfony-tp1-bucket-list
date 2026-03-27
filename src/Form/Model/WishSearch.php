<?php

namespace App\Form\Model;

class WishSearch
{
    // TODO ajouter la validation des champs
    private ?string $title = null;
    private ?\DateTime $dateCreated = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDateCreated(): ?\DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?\DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

}
