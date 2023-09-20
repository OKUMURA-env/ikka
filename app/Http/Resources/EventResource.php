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
            'display_driver_name' => $this->display_driver_name,
            'driver_id' => $this->driver_id,
            'driver_name' => $this->driver->name,
            'schedule_category_title' => $this->scheduleCategory->title,
            'color' => $this->scheduleCategory->color,
            'item' => $this->item,
            'pickup_location' =>  $this->pickup_location,
            'dropoff_location' =>  $this->dropoff_location,
            "file_path" => $this->file_path,
            'description' =>  $this->description,
        ];
    }
}
