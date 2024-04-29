<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    protected $fillable = [
        'title',
        'user_id',
        'no_rooms',
        'no_beds',
        'no_bathrooms',
        'square_meters',
        'img',
        'visible',
        'address',
        'latitude',
        'longitude',
        'price',
        'description'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function leads() {
        return $this->hasMany(Lead::class);
    }

    public function services(){
        return $this->belongsToMany(Service::class);
    }

    public function sponsors(){
        return $this->belongsToMany(Sponsor::class);
    }
}
