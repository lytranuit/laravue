<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['mail', 'description', 'deleted'];
    protected $table = 'schedule';
    /**
     * Get all of the video's comments.
     */
    public function job()
    {
        return $this->hasOne('App\Laravue\Models\Job');
    }
}
