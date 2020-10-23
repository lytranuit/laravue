<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Laravue\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
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
            $Category = new Category();
            foreach ($Category->getFillable() as $key) {
                if (isset($params[$key])) {
                    $Category->{$key} = $params[$key];
                } else {
                    continue;
                }
            }
            $Category->save();
            return new CategoryResource($Category);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $Category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $Category)
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
    public function update(Request $request, Category $Category)
    {
        if ($Category === null) {
            return response()->json(['error' => 'Category not found'], 404);
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
            foreach ($Category->getFillable() as $key) {
                if (isset($params[$key])) {
                    $Category->{$key} = $params[$key];
                } else {
                    continue;
                }
            }
            $Category->save();
        }

        return new CategoryResource($Category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $Category)
    {
        try {
            $Category->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
