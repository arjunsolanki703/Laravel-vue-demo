<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'engineer_user_id',
        'address',
        'city',
        'state',
        'zip',
        'county',
        'project_name',
        'client_po',
        'project_number',
        'project_notes',
        'type',
        'status',
    ];

    public function run()
    {
        Projects::factory()
                ->count(50)
                ->hasPosts(1)
                ->create();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}