<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\BaseResource;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return BaseResource
     */
    public function index()
    {
        $categories = Category::with('child')
            ->where('category_id', null)
            ->get();
        return $this->success(CategoryResource::collection($categories));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     *
     * @return Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     *
     * @return Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param Category $category
     *
     * @return Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     *
     * @return Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
