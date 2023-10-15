<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleCategory;
use App\Http\Resources\ScheduleCategoryResource;

class ScheduleCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedule_categories = ScheduleCategory::all();
        return ScheduleCategoryResource::collection($schedule_categories);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule_category = ScheduleCategory::create($request->post());
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScheduleCategory $schedule_category)
    {
        $schedule_category = $schedule_category->update([
            "title" => $request->title,
            "color" => $request->color,
        ]);
        return response()->json($schedule_category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScheduleCategory $schedule_category)
    {
        $schedule_category->delete();
    }

}
