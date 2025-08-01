<?php

namespace App\Services;

use App\Models\Service;

class ServiceServices
{
    public function __construct()
    {
        //
    }

    public function getServices()
    {
        return Service::all();
    }
}
