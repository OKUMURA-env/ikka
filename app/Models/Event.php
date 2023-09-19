<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'start',
        'end',
        'schedule_category_id',
        'driver_id',
        'all_day',
        'item',
        'pickup_location',
        'dropoff_location',
        'description'
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
