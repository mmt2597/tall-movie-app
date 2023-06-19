<?php

namespace App\Services\TMDB;

class PersonService extends TMDBService
{
    public function __construct()
    {
        $this->setCollectionKey('person');
        parent::__construct();
    }

    public function getPerson($id)
    {
        return $this->send('GET', '/' . $id);
    }
}