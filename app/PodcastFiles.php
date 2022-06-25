<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PodcastFiles extends Model
{
   protected $table = 'podcast_files';
     protected $fillable = [
       'user_id',
       'file_name',
        'file',
    ];
   
     public function user()
    {
        return $this->belongsTo('App\User');
    }
}
