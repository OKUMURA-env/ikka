<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'color',
    ];

     /**
     * リレーション
     * カテゴリーとリレーション
     */
     public function scheduleCategory()
     {
         return $this->belongsTo(ScheduleCategory::class);
     }

    /**
     * ドライバーとリレーション
     */
     public function driver()
     {
         return $this->belongsTo(Driver::class);
     }
}
