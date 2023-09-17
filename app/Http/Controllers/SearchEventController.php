<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class SearchEventController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $all_events = Event::query()->get();

        $events = [];
        foreach($all_events as $event){
            $each_event = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'all_day' => $event->all_day,
                'schedule_category_id' => $event->schedule_category_id,
                'driver_id' => $event->driver_id,
                'driver_name' => $event->driver->name,
                'schedule_category_title' => $event->scheduleCategory->title,
            ];

            $events[] = $each_event;
        }
        return response()->json($events);
    }
}
