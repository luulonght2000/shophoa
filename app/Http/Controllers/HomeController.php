<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    public $sorting;
    public $pagesize;

    public $min_price;
    public $max_price;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->min_price = 1;
        $this->max_price = 10000000;
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

        return view('home.detail', ['product' => $product, 'categories' => $categories]);
    }

    public function productshop(Request $request)
    {
        $categories = CategoryModel::all();
        $count_product_category = DB::table('product_models')
        ->select('category_id', DB::raw('count(product_models.id) as SL'))
        ->where('product_models.product_status', 0)
        ->groupBy('product_models.category_id')->get();
        $min_price = ProductModel::min('price');
        $max_price = ProductModel::max('price');

        $filter_min_price = $request->min_price;
        $filter_max_price = $request->max_price;
        $sort_price = $request->sort_price;

        if($filter_min_price && $filter_max_price && $sort_price){
            if($filter_min_price >0 && $filter_max_price >0 && $sort_price === 'tăng dần')
            {
                $products = ProductModel::whereBetween('price',[$filter_min_price,$filter_max_price])->orderby('price', 'asc')->get();
            }elseif($filter_min_price >0 && $filter_max_price >0 && $sort_price === 'giảm dần'){
                $products = ProductModel::whereBetween('price',[$filter_min_price,$filter_max_price])->orderby('price', 'desc')->get();
            }
        }  
        elseif($sort_price === 'giảm dần'){
            $products = ProductModel::orderby('price', 'desc')->get();
        }
        else{
            $products = ProductModel::orderby('price', 'asc')->get();
        }
        
        return view('home.shop',compact('products','categories','min_price','max_price','filter_min_price','filter_max_price', 'sort_price', 'count_product_category'));
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

    public function product_detail($id){
        $product = ProductModel::findOrFail($id);
        $categories = CategoryModel::orderBy('id', 'DESC')->get();

        return view('home.product_detail', ['product' => $product, 'categories' => $categories]);
    }
}
