<?php

namespace App\Http\Controllers\Api\Service;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

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

    public function update(UpdateServiceRequest $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $validatedData = $request->validated();

        if (empty($validatedData)) {
            return response()->json(['message' => 'No valid fields provided for update'], 422);
        }

        $service->update($validatedData);

        return response()->json([
            'message' => 'Service updated successfully',
            'service' => $service
        ]);
    }


    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'message' => 'Service not found'
            ], 404);
        }

        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully'
        ]);
    }
}
