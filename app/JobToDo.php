<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobToDo extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_COMPLETED = 1;
    /**
     * @var string[]
     */
    protected $fillable = [
        "user_id",
        "name",
        "status",
    ];
}
