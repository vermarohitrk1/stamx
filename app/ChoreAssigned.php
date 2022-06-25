<?php

namespace App;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

class ChoreAssigned extends Model
{
   protected $table = 'chore_assigned';
   protected $fillable = [
        'id',
        'chore_id',
        'user_id',
        'date',
        'is_completed',
    ];
   public static $priority_color = [
        'High' => 'danger',
//        'High' => 'warning',
        'medium' => 'primary',
        'Low' => 'info',
    ];
}
