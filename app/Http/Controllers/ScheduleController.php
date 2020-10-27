<?php

namespace App\Http\Controllers;

use App\Http\Resources\ScheduleResource;
use App\Laravue\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as Validator;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ScheduleResource::collection(Schedule::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $Schedule= new Schedule();
            foreach ($Schedule->getFillable() as $key) {
                if (isset($params[$key])) {
                    $Schedule->{$key} = $params[$key];
                } else {
                    continue;
                }
            }
            $Schedule->save();
            return new ScheduleResource($Schedule);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Schedule  $Schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $Schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Schedule  $Schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $Schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $Schedule)
    {
        if ($Schedule === null) {
            return response()->json(['error' => 'Schedule not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            foreach ($Schedule->getFillable() as $key) {
                if (isset($params[$key])) {
                    $Schedule->{$key} = $params[$key];
                } else {
                    continue;
                }
            }
            $Schedule->save();
        }

        return new ScheduleResource($Schedule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Schedule  $Schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $Schedule)
    {
        try {
            $Schedule->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
