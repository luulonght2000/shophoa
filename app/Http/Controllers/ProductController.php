<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\StyleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = ProductModel::orderBy('id', 'DESC')->paginate(10);
        $category = CategoryModel::orderBy('id', 'DESC')->get();

        $last_id = $request->session()->get("last_product_id", 0);
        $last_product = $last_id ? ProductModel::findOrFail($last_id) : null;

        if ($key = request()->key) {
            $products = ProductModel::orderBy('id', 'DESC')->with('category')->where('name', 'like', '%' . $key . '%')->paginate(10);
        }

        return view('admin/product.index', ['products' => $products, 'category' => $category, 'last_product' => $last_product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CategoryModel::all();
        $styles = StyleModel::all();

        return view('admin/product.new', ['categories' => $categories, 'styles' => $styles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:50',
            'category_id' => 'required',
            'style_id' => 'required',
            'price' => 'required|max:30',
            'old_price' => 'required|max:30',
            'avatar' => 'mimes:jpeg, bmp, png, gif, jpg'
        ];

        $vaildator = Validator::make($request->all(), $rules);

        if ($vaildator->fails())
            return redirect()->route('product.create')->withErrors($vaildator)->withInput();
        else {
            $product = new ProductModel;

            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->style_id = $request->style_id;
            $product->size = $request->size;
            // $product->weight = $request->weight;
            $product->price = $request->price;
            $product->old_price = $request->old_price;
            $product->description = $request->description;
            $product->viewed = 100;
            $product->sold = 10;

            $product->save();

            $id = $product->id;
            $file = $request->avatar;

            $file->move("./uploads/", "$id.jpg");

            $request->session()->put("last_product_id", $id);

            return redirect()->route('product.index');
        }
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
        $product = ProductModel::findOrFail($id);
        $categories = CategoryModel::all();
        $styles = StyleModel::all();

        return view('admin/product.edit', ['product' => $product, 'categories' => $categories, 'styles' => $styles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:50',
            'category_id' => 'required',
            'style_id' => 'required',
            'price' => 'required|max:30',
            'old_price' => 'required|max:30',
            'avatar' => 'mimes:jpeg, bmp, png, gif, jpg'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return redirect()->route('product.edit', ['product' => $id])->withErrors($validator)->withInput();
        else {
            $product = ProductModel::findOrFail($id);

            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->style_id = $request->style_id;
            $product->size = $request->size;
            // $product->weight = $request->weight;
            $product->price = $request->price;
            $product->old_price = $request->old_price;
            $product->description = $request->description;
            $product->viewed = 150;
            $product->sold = 15;

            $product->save();

            $file = $request->avatar;
            if ($file)
                $file->move("./uploads/", "$id.jpg");

            $request->session()->put("last_product_id", $id);

            return redirect()->route('product.index');
        }
    }

    public function unactive($id)
    {
        ProductModel::where('id', $id)->update(['product_status' => 1]);
        return redirect()->route('product.index');
    }

    public function active($id)
    {
        ProductModel::where('id', $id)->update(['product_status' => 0]);
        return redirect()->route('product.index')->with('success', 'Kích hoạt thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = ProductModel::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index');
    }
}
