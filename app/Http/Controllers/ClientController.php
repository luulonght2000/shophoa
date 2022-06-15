<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ShippingModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        $user = User::findOrFail($id);
        $products = ProductModel::orderBy('id', 'DESC')->paginate(12);
        $categories = CategoryModel::orderBy('id', 'DESC')->get();

        return view('home.profile_client', ['user' => $user, 'categories' => $categories, 'products' => $products]);
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
            'sex' => 'required',
            'email' => 'required|string|email|max:255',
            'avatar' => 'mimes:jpeg, bmp, png, gif, jpg'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return redirect()->route('profile.edit', ['profile' => $id])->withErrors($validator)->withInput();
        else {

            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->DOB = $request->DOB;
            $user->sex = $request->sex;
            $user->address = $request->address;

            $user->save();

            $file = $request->avatar;
            if ($file)
                $file->move("./uploads_user/", "$id.jpg");

            return redirect()->route('profile.edit', ['profile' => $user->id])->with('success', 'Cập nhật thông tin thành công!');
        }
    }

    public function save_cart(Request $request)
    {
        if($request->session()->has('shipping_id')){
            return Redirect::to('/payment');
        }else{
            $productId = $request->productid_hidden;
            $quantity = $request->qty;

            $product_info = DB::table('product_models')->where('id', $productId)->first();

            $data['id'] = $product_info->id;
            $data['qty'] = $quantity;
            $data['name'] = $product_info->name;
            $data['price'] = $product_info->price;
            $data['weight'] = $product_info->price;
            $data['options']['image'] = $product_info->id;
            Cart::add($data);

            return Redirect::to('/show-cart');
        }
    }

    public function show_cart(Request $request)
    {
        if($request->session()->has('shipping_id')){
            session()->flash('error', 'Vui lòng thanh toán đơn hàng trước!');
            return Redirect::to('/payment');
        }else{
            $categories = CategoryModel::orderBy('id', 'DESC')->get();
            return view('home.client.show_cart', ['categories' => $categories]);
        }
    }

    public function update_cart_quantity(Request $request)
    {
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId, $qty);
        return Redirect::to('/show-cart');
    }

    public function delete_to_cart($rowId)
    {
        Cart::update($rowId, 0);
        return Redirect::to('/show-cart');
    }

    public function checkout(Request $request)
    {
        if($request->session()->has('shipping_id')){
            session()->flash('error', 'Vui lòng thanh toán đơn hàng trước!');
            return Redirect::to('/payment');
        }else{
            $cart_count = Cart::count();
            if ($cart_count == 0) {
                session()->flash('error', 'Chưa có sản phẩm nào trong giỏ hàng!');
                return Redirect::to('/show-cart');
            } else {
                $shipping_id = $request->session()->get("shipping_id", 0);
                $categories = CategoryModel::orderBy('id', 'DESC')->get();
                $contents = Cart::content();
                return view('home.client.checkout', ['categories' => $categories, 'contents' => $contents, 'shipping_id' => $shipping_id]);
            }
        }
    }

    public function save_checkout_user(Request $request)
    {
        $rules = [
            'shipping_email' => 'required|string|email|max:255',
            'shipping_phone' => 'required|min:10|numeric'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return redirect('/checkout')->withErrors($validator)->withInput();
        else {
            $data = new ShippingModel();

            $data->shipping_name = $request->shipping_name;
            $data->shipping_address = $request->shipping_address;
            $data->shipping_phone = $request->shipping_phone;
            $data->shipping_email = $request->shipping_email;
            $data->shipping_note = $request->shipping_note;

            $data->save();

            $id = $data->id;
            $request->session()->put("shipping_id", $id);
            return Redirect('/payment');
        }
    }

    public function payment(Request $request)
    {
        $cart_count = Cart::count();

        if ($cart_count == 0) {
            session()->flash('error', 'Chưa có sản phẩm nào trong giỏ hàng!');
            return Redirect::to('/show-cart');
        } else {
            $categories = CategoryModel::orderBy('id', 'DESC')->get();
            $contents = Cart::content();
            $shipping_id = $request->session()->get("shipping_id", 0);
            return view('home.client.payment', ['categories' => $categories, 'contents' => $contents, 'shipping_id'=>$shipping_id]);
        }
    }

    public function order_place(Request $request)
    {
        $categories = CategoryModel::orderBy('id', 'DESC')->get();

        //insert payment_method
        $data = array();
        $data['payment_option'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['user_id'] = Auth::id();
        $order_data['shipping_id'] = $request->session()->get("shipping_id", 0);
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::subtotal();
        $order_data['order_status'] = "Đang chờ xử lý";
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //insert order_detail
        $content = Cart::content();
        foreach ($content as $v_content) {
            $order_d_data = array();
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }

        if ($data['payment_option'] === "Bằng ATM") {
            echo "Thanh toán bằng ATM";
        } elseif ($data['payment_option'] === "Thanh toán khi nhận hàng") {
            session()->flash('success', 'Mua hàng thành công! Chúng tôi sẽ liên hệ bạn sớm nhất. Cảm ơn quý khách!');
            Cart::destroy();
            $request->session()->forget('shipping_id');
            return view('home.client.handcash', ['categories' => $categories]);
        }

        // return Redirect('/payment');
    }

    public function delete_order(Request $request, $id){
        session()->flash('success', 'Hủy đơn hàng thành công!');
        $categories = CategoryModel::orderBy('id', 'DESC')->get();
        ShippingModel::findOrFail($id)->delete();
        $request->session()->forget('shipping_id');
        return Redirect::to('/show-cart');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}