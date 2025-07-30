<?php

namespace App\Http\Controllers\Api\Service;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();

        return response()->json([
            'services' => $services
        ]);
    }
}
