<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->start,
            'end' => $this->end,
            'all_day' => $this->all_day,
            'schedule_category_id' => $this->schedule_category_id,
            'driver_id' => $this->driver_id,
            'driver_name' => $this->driver->name,
            'schedule_category_title' => $this->scheduleCategory->title,
            'item' => $this->item,
            'pickup_location' =>  $this->pickup_location,
            'dropoff_location' =>  $this->dropoff_location,
            'description' =>  $this->description,
        ];
    }
}
