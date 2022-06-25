<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorporateLead extends Model
{
   protected $fillable = [];
    protected $table = "corporate_lead";
    public function user()
     {
        return $this->belongsTo('App\User','user_id','id');
     }
     public function institution()
     {
        return $this->belongsTo('App\Institution','corporate_id','id');
     }
     public function course()
     {
        return $this->belongsTo('App\Certify','corporate_id','id');
     }
     
    
}
