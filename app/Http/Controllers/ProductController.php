<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddImagesRequest;
use App\Http\Requests\ProductRequest;
use App\Models\CategoryModel;
use App\Models\ImagesProductModel;
use App\Models\ProductModel;
use App\Models\StyleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

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

        if ($key = request()->key) {
            $products = ProductModel::orderBy('id', 'DESC')->with('category')->where('name', 'like', '%' . $key . '%')->paginate(10);
        }

        return view('admin/product.index', ['products' => $products, 'category' => $category]);
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
    public function store(ProductRequest $request)
    {
        $vaildator = Validator::make($request->all());

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
            $product->sold = 0;

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
    public function update(ProductRequest $request, $id)
    {
        $validator = Validator::make($request->all());

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
            $product->sold = 0;

            $product->save();

            $file = $request->avatar;
            if ($file)
                $file->move("./uploads/", "$id.jpg");

            $request->session()->put("last_product_id", $id);

            return redirect()->route('product.index');
        }
    }

    public function view_add_images(Request $request, $id){
        $product = ProductModel::findOrFail($id);
        $images = ImagesProductModel::where('product_id', $id)->first();
        $product_id = $id;

        return view('admin.product.add_images', ['product' => $product, 'images' => $images, 'product_id'=>$product_id]);
    }

    public function add_images(AddImagesRequest $request){
        // $this->validate($request, [
        //     'filename' => 'required',
        //     'filename.*' => 'mimes:jpeg, bmp, png, gif, jpg'
        // ]); 
        $i=1;
        $id= $request->product_id;
        if($request->hasfile('filename'))
        {
            foreach($request->file('filename') as $file)
            {
                $name="$id-$i.jpg";
                $file->move(public_path().'/files/', $name);  
                $data[] = $name;  
                $i++;
            }
        }
        $file= new ImagesProductModel();
        // $file->filenames=json_encode($data);
        $file->product_id=$id;
        $file->save();
        return back()->with('success', 'Your files has been successfully added');
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
    public function destroy(Request $request, $id)
    {
        $product = ProductModel::findOrFail($id);
        $product->delete();
        ImagesProductModel::where('product_id', $id)->delete();
        $image_uploads_path = public_path("uploads/$id.jpg"); 
        if(File::exists($image_uploads_path)) {
            File::delete($image_uploads_path);
        }
        for($i=1; $i<10; $i++){
            $image_files_path = public_path("files/$id-$i.jpg");
            if(File::exists($image_files_path)) {
                File::delete($image_files_path);
            }
        }

        return redirect()->route('product.index');
    }



    //=================================API PRODUCT=====================
    public function api_product_detail($id){
        $product = ProductModel::findOrFail($id);
        return response()->json([$product, 'OK']);
    }

    public function api_product_create(Request $request){
        $product = new ProductModel;

            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->style_id = $request->style_id;
            $product->size = $request->size;
            $product->price = $request->price;
            $product->old_price = $request->old_price;
            $product->description = $request->description;
            $product->viewed = 100;
            $product->sold = 0;

            $product->save();

            return response()->json($product);
    }

    public function api_product_update(Request $request, $id){
        $product = ProductModel::findOrFail($id);

        $product->product_status = $request->product_status;
        $product->update();

        return response()->json($product);
    }

    public function api_product_delete($id){
        $product = ProductModel::findOrFail($id);
        $product->delete();

        return response()->json([$product, "OK"]);
    }
}
