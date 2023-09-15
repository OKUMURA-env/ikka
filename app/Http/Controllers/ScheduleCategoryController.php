<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleCategory;

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
        return response()->json([
            'schedule_categories' => $schedule_categories,
        ]);
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
        return response()->json([
            'schedule_category' => $schedule_category
        ]);
    }

}
