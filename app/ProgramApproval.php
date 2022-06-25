<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProgramApproval extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question', 
        
    ];
   protected $table = "program_approvals";
   public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
