<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function eventGet(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');


        // 登録処理
        $events =  Event::query()
            ->select(
                // FullCalendarの形式に合わせる
                'id',
                'start',
                'end',
                'title',
                'schedule_category_id',
                'driver_id',
                'all_day',
            )
            // FullCalendarの表示範囲のみ表示
            ->where('end', '>', $start)
            ->where('start', '<', $end)
            ->get();
            
            return EventResource::collection($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = Event::create($request->post());
        return new EventResource($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $event = Event::where("id",$request->id)->update([
            "title" => $request->title,
            "start" => $request->start,
            "end" => $request->end,
            "schedule_category_id" => $request->schedule_category_id,
            "driver_id" => $request->driver_id,
            "all_day" => $request->all_day,
        ]);
        return new EventResource($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
    }
}
