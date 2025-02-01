<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'guest';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'location',
        'cv',
        'job_id'
    ];

    public function jobs()
    {
        $this->hasMany(Job::class);
    }
}
