<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
   protected $fillable = [
        'user_id',
        'name',
        'icon',
    ];
protected $table = "task_categories";
    public function getDetails($id)
    {
    	return self::find($id);
    }
    public static function getCourseCategories()
    {
    	//return self::select('task_categories.id','task_categories.name','task_categories.icon')->join('taskies as c','c.category','task_categories.id')->groupBy('task_categories.id','task_categories.name','task_categories.icon')->get();
    }
    public function task()
    {
        return $this->belongTo('App\Task', 'type', 'id');
    }
}
