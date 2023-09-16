<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'display_name',
        'other'
    ];

    /**
     * リレーション
     * イベントとリレーション
     */

     public function events()
     {
         return $this->hasMany(Event::class);
     }
}
