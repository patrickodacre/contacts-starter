<?php

namespace App\Http\Controllers;

use DB;
use App\Category;
use App\Contact;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Category::whereNotNull('created_at');
        
        if ($request->has('include_contacts')) {
            $query->with('contacts');
        }

        return $query->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $category       = new Category();
        
        $data           = $request->input();
        $category->name = $data['name'];

        if (!empty($data['description'])) {
            $category->description = $data['description'];
        }

        if ($category->save()) {
            $response = [
                'message' => 'Category created.',
                'category' => $category,
                'links' => [
                    'category' => 'http://crudstarter.app/api/v1/categories/' . $category->id
                ]
            ];
            return response()->json($response, 201);
        } else {
            $response = [
                'message' => 'Category could not be created.',
                'category' => $category
            ];
            return response()->json($response, 304);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data           = $request->input();

        if (!empty($data['name'])) {
            $category->name = $data['name'];
        }

        if (!empty($data['description'])) {
            $category->description = $data['description'];
        }

        if ($category->save()) {
            $response = [
                'message' => 'Category updated.',
                'category' => $category,
                'links' => [
                    'category' => 'http://crudstarter.app/api/v1/categories/' . $category->id
                ]
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Category could not be updated.',
                'category' => $category
            ];
            return response()->json($response, 304);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {

        // move all contacts to uncategorized
        DB::table('contacts')->where('category_id', $category->id)->update(['category_id' => 1]);

        if ($category->delete()) {
            $response = [
                'message' => 'Category deleted.',
                'category' => $category,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Category could not be deleted.',
                'category' => $category,
                'links' => [
                    'category' => 'http://crudstarter.app/api/v1/categories/' . $category->id
                ]
            ];
            return response()->json($response, 304);
        }
    }
}
