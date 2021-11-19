<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'document',
        'status'
    ];

    //attributes
    public function getCreatedAtAttribute()
    {
        return date_format(date_create($this->attributes['created_at']), 'Y/m/d H:i');
    }

    //relationships
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function numbers(){
        return $this->hasMany(Number::class, 'customer_id');
    }
}
