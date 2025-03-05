<?php

namespace App\Service;

use App\Models\Checklist;

class CheclistService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Checklist();
    }

    public function index()
    {
        return $this->model->get();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $checklist = $this->show($id);
        $checklist->update($data);
        return $checklist;
    }

    public function destroy($id)
    {
        $checklist = $this->show($id);
        $checklist->delete();
        return $checklist;
    }
}
