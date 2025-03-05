<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    protected $table = 'check_list_items';
    protected $fillable = [
        'checklist_id',
        'title',
        'description',
        'status'
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}
