<?php

namespace App\Service;

use App\Models\ChecklistItem;
use Exception;

class ChecklistItemService
{
    protected $model;

    public function __construct()
    {
        $this->model = new ChecklistItem();
    }

    public function index()
    {
        return $this->model->get();
    }

    public function show($checklistId, $id)
    {
        return $this->model->whereHas('checklist', function ($query) use ($checklistId) {
            $query->where('user_id', auth()->user()->id)
                ->where('id', $checklistId);
        })->findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $checklistItem = $this->show($data['checklist_id'], $id);
        $checklistItem->update($data);
        return $checklistItem;

    }
}
