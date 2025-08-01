<?php

namespace App\Http\Controllers\Api\Service;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Services\ServiceServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

class ServiceController extends Controller
{
    public function __construct(
        private ServiceServices $serviceServices
    ) {}
    public function index()
    {
        // get all services for customers
        $services = $this->serviceServices->getServices();

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

        try {
            $service = Service::create($request->validated());

            return response()->json([
                'message' => 'Service created successfully',
                'service' => $service
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // only admin can update services
    public function update(UpdateServiceRequest $request, $id)
    {
        $user = $request->user();
        if (!$user->is_admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $service = Service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        try {
            $service->update($request->validated());

            return response()->json([
                'message' => 'Service updated successfully',
                'service' => $service
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Service updated successfully',
            'service' => $service
        ]);
    }

    // only admin can delete services
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
