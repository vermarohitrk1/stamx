<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    protected $table = 'podcasts';
     protected $fillable = [
       'user_id',
        'title',
        'description',
        'image',
        'file',
        'parent_episode_id',
        'episode',
    ];
   
     public function user()
    {
        return $this->belongsTo('App\User');
    }
}
