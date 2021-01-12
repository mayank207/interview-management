<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'tag',
    ];
    // Get Tehcnology
    public function getTechnology()
    {
        return $this->belongsToMany(Technology::class);
    }
}
