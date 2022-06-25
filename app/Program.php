<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Program extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'data', 
        
    ];
   protected $table = "programs";
   public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function program_category()
    {
        return $this->belongsTo('App\ProgramCategory','category_id	','id');
    }
    
}
