<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

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
                'all_day',
            )
            // FullCalendarの表示範囲のみ表示
            ->where('end', '>', $start)
            ->where('start', '<', $end)
            ->get();
            
           
        return response()->json($events);
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
        return response()->json($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return response()->json($event);
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
        ]);
        return response()->json($event);
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
