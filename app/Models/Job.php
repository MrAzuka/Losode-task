<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'job';

    protected $fillable = [
        'title',
        'company',
        'description',
        'location',
        'category',
        'salary',
        'benefits',
        'type',
        'work_condition'
    ];

    public function business()
    {
        $this->hasOne(Business::class);
    }
}
