<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChecklistRequest;
use App\Service\CheclistService;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\Check;

class ChecklistController extends Controller
{
    protected $checklistService;

    public function __construct(CheclistService $checklistService)
    {
        $this->middleware('auth:api');
        $this->checklistService = $checklistService;
    }

    public function index()
    {
        try {
            $data = $this->checklistService->index();
            return response()->json([
                'message' => 'Success get all checklist',
                'data'    => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function store(ChecklistRequest $request) {
        try {
            $userId = auth()->user()->id;
            $request->merge(['user_id' => $userId]);
            $request->validated();
            $data = $this->checklistService->store($request->all());
            return response()->json([
                'message' => 'Checklist created successfully',
                'data'    => $data
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = $this->checklistService->show($id);
            return response()->json([
                'message' => 'Checklist found',
                'data'    => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $this->checklistService->update($request->all(), $id);
            return response()->json([
                'message' => 'Checklist updated successfully',
                'data'    => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->checklistService->destroy($id);
            return response()->json([
                'message' => 'Checklist deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
