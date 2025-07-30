<?php

namespace App\Http\Controllers\Api\Service;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();

        return response()->json([
            'services' => $services
        ]);
    }

    // only admin can create services
    public function store(StoreServiceRequest $request)
    {
        $user = $request->user();

        if (!$user->is_admin) {
            return response()->json(['message' => 'Unauthorized! Only admin can create services'], 403);
        }

        $service = Service::create($request->validated());

        return response()->json([
            'message' => 'Service created successfully',
            'service' => $service
        ], 201);
    }
}
