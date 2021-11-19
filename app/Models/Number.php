<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Number extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'number',
        'status'
    ];

    //attributes
    public function getCreatedAtAttribute()
    {
        return date_format(date_create($this->attributes['created_at']), 'Y/m/d H:i');
    }

    //relationships
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function preferences(){
        return $this->hasMany(NumberPreferences::class, 'number_id', 'id');
    }
}
