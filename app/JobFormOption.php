<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JobFormOption
 * @package App
 */
class JobFormOption extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['field_id', 'label', 'status', 'sorting'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobFormField(){
        return $this->belongsTo(JobFormField::class);
    }
}
