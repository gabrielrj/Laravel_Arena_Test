<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NumberPreferences extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number_id',
        'name',
        'value'
    ];

    //attributes
    public function getCreatedAtAttribute()
    {
        return date_format(date_create($this->attributes['created_at']), 'Y/m/d H:i');
    }

    //relationships
    public function number(){
        return $this->belongsTo(Number::class, 'number_id');
    }
}
