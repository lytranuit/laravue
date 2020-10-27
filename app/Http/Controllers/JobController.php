<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Laravue\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as Validator;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return JobResource::collection(Job::all());
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
            $Job= new Job();
            foreach ($Job->getFillable() as $key) {
                if (isset($params[$key])) {
                    $Job->{$key} = $params[$key];
                } else {
                    continue;
                }
            }
            $Job->save();
            return new JobResource($Job);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Job  $Job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $Job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Job  $Job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $Job)
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
    public function update(Request $request, Job $Job)
    {
        if ($Job === null) {
            return response()->json(['error' => 'Job not found'], 404);
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
            foreach ($Job->getFillable() as $key) {
                if (isset($params[$key])) {
                    $Job->{$key} = $params[$key];
                } else {
                    continue;
                }
            }
            $Job->save();
        }

        return new JobResource($Job);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Job  $Job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $Job)
    {
        try {
            $Job->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
