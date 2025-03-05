<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Service\ChecklistItemService;
use Exception;
use Illuminate\Http\Request;

class ChecklistItemController extends Controller
{
    protected $checklistItemService;
    public function __construct(ChecklistItemService $checklistItemService)
    {
        $this->middleware('auth:api');
        $this->checklistItemService = $checklistItemService;
    }

    public function index()
    {
        try {
            $data = $this->checklistItemService->index();
            return response()->json([
                'message' => 'Checklist items fetched successfully',
                'data'    => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request, $checklistId)
    {
        try {
            $validated = $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);
            $checklist = Checklist::where('user_id', auth()->user()->id)->find($checklistId);
            if (!$checklist) {
                return response()->json([
                    'message' => 'Checklist not found'
                ], 404);
            }

            $validated['checklist_id'] = $checklistId;
            $data                      = $this->checklistItemService->store($validated);
            return response()->json([
                'message' => 'Checklist item created successfully',
                'data'    => $data
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($checklistId, $itemId)
    {
        try {
            $data = $this->checklistItemService->show($checklistId, $itemId);
            if (!$data) {
                return response()->json([
                    'message' => 'Checklist item not found'
                ], 404);
            }
            return response()->json([
                'message' => 'Checklist item fetched successfully',
                'data'    => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $checklistId, $itemId)
    {
        try {
            $validated = $request->validate([
                'title'       => 'sometimes|string|max:255',
                'description' => 'nullable|string',
            ]);
            $checklist = $this->checklistItemService->show($checklistId, $itemId);
            if (!$checklist) {
                return response()->json([
                    'message' => 'Checklist not found'
                ], 404);
            }
            $validated['checklist_id'] = $checklistId;
            $data = $this->checklistItemService->update($validated, $itemId);
            return response()->json([
                'message' => 'Checklist item updated successfully',
                'data'    => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($checklistId, $itemId)
    {
        try {
            $checklist = $this->checklistItemService->show($checklistId, $itemId);
            if (!$checklist) {
                return response()->json([
                    'message' => 'Checklist item not found'
                ], 404);
            }
            $checklist->delete();
            return response()->json([
                'message' => 'Checklist item deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function complete($checklistId, $itemId)
    {
        try {
            $checklist = $this->checklistItemService->show($checklistId, $itemId);
            if (!$checklist) {
                return response()->json([
                    'message' => 'Checklist item not found'
                ], 404);
            }
            $checklist->update(['status' => true]);
            return response()->json([
                'message' => 'Checklist item completed successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function incomplete($checklistId, $itemId)
    {
        try {
            $checklist = $this->checklistItemService->show($checklistId, $itemId);
            if (!$checklist) {
                return response()->json([
                    'message' => 'Checklist item not found'
                ], 404);
            }
            $checklist->update(['status' => false]);
            return response()->json([
                'message' => 'Checklist item marked incomplete successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
