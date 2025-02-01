<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Job extends Model
{
    use HasFactory, HasUuids, Searchable;

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
        'work_condition',
        'business_id'
    ];

    public function business()
    {
        $this->hasOne(Business::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'location' => $this->location,
        ];
    }
}
