<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $table = 'tours';

    protected $fillable = [
        'name', 'description', 'location', 'duration', 'price',
        'available_dates', 'image_url', 'status'
    ];

    protected $casts = [
        'available_dates' => 'array', // Преобразует JSON в массив
    ];

   
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
