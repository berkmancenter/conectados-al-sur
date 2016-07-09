<?php

use Migrations\AbstractSeed;

class DatabaseSeed extends AbstractSeed
{
    public function run()
    {
        $this->call('CitiesSeed');
        $this->call('CountriesSeed');
        $this->call('UsersSeed');
        #$this->call('ProjectsSeed');
    }
}