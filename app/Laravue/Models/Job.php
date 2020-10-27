<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['name', 'description', 'deleted'];
    protected $table = 'job';
    /**
     * Get all of the video's comments.
     */
    public function schedules()
    {
        return $this->hasMany('App\Laravue\Models\Schedule');
    }
}
