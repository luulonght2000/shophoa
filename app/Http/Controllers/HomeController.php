<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = ProductModel::orderBy('id', 'DESC')->paginate(12);
        $productFeatureds = ProductModel::orderBy('sold', 'DESC')->limit(6)->get();
        $categories = CategoryModel::orderBy('id', 'DESC')->get();

        return view('home', ['products' => $products, 'productFeatureds' => $productFeatureds, 'categories' => $categories]);
    }

    public function productDetail($id)
    {
        $product = ProductModel::findOrFail($id);
        $categories = CategoryModel::orderBy('id', 'DESC')->get();

        // foreach ($product as $key => $value) {
        //     $category_id = $value->category_id;
        // }

        return view('home.detail', ['product' => $product, 'categories' => $categories]);
    }

    public function blog()
    {
        $product = ProductModel::all();
        $categories = CategoryModel::orderBy('id', 'DESC')->get();
        return view('home.blog', ['product' => $product, 'categories' => $categories]);
    }

    public function contact()
    {
        $product = ProductModel::all();
        $categories = CategoryModel::orderBy('id', 'DESC')->get();
        return view('home.contact', ['product' => $product, 'categories' => $categories]);
    }

    public function category_page($id)
    {
        $products = ProductModel::orderBy('id', 'DESC')->where('category_id', $id)->get();
        $categories = CategoryModel::orderBy('id', 'DESC')->get();
        $category = CategoryModel::findOrFail($id);

        return view('home.category_page', ['products' => $products, 'categories' => $categories, 'category' => $category]);
    }
}
