<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoryModel::orderBy('id', 'DESC')->paginate(5);

        if ($key = request()->key) {
            $categories = CategoryModel::orderBy('id', 'DESC')->where('name', 'like', '%' . $key . '%')->paginate(10);
        }

        return view('admin/category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/category.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // $category = new CategoryModel;
        // $category->name = $request->name;
        // $category->feature = $request->feature;
        // $category->description = $request->description;

        // $category->save();
        CategoryModel::query()->create($request->all());

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = CategoryModel::findOrFail($id);
        return view('admin/category.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = CategoryModel::find($id);
        $category->name = $request->name;
        $category->feature = $request->feature;
        $category->description = $request->description;

        $category->save();

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = CategoryModel::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index');
    }
}
