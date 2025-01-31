<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Business extends Model
{
    use HasFactory, HasUuids, HasApiTokens;

    protected $table = 'business';
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    protected $hidden = [
        'password'
    ];

    public function jobs()
    {
        $this->hasMany(Job::class);
    }
}
