<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderPlaceRequest;
use App\Http\Requests\UpdateClientRequest;
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
use phpDocumentor\Reflection\Types\This;

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
    public function update(UpdateClientRequest $request, $id)
    {
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

        return redirect()->route('profile.edit', ['profile' => $user->id])->with('success', 'C???p nh???t th??ng tin th??nh c??ng!');
    }

    public function save_cart(Request $request)
    {
        if($request->session()->has('shipping_id')){
            session()->flash('error', 'Vui l??ng thanh to??n ????n h??ng tr?????c!');
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
            session()->flash('error', 'Vui l??ng thanh to??n ????n h??ng tr?????c!');
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
            session()->flash('error', 'Vui l??ng thanh to??n ????n h??ng tr?????c!');
            return Redirect::to('/payment');
        }else{
            $cart_count = Cart::count();
            if ($cart_count == 0) {
                session()->flash('error', 'Ch??a c?? s???n ph???m n??o trong gi??? h??ng!');
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
            'shipping_phone' => 'required|min:10|numeric',
            'shipping_note' => 'required'
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
            session()->flash('error', 'Ch??a c?? s???n ph???m n??o trong gi??? h??ng!');
            return Redirect::to('/show-cart');
        } else {
            $categories = CategoryModel::orderBy('id', 'DESC')->get();
            $contents = Cart::content();
            $shipping_id = $request->session()->get("shipping_id", 0);
            return view('home.client.payment', ['categories' => $categories, 'contents' => $contents, 'shipping_id'=>$shipping_id]);
        }
    }

    public function order_place(OrderPlaceRequest $request)
    {
        $categories = CategoryModel::orderBy('id', 'DESC')->get();

        //insert payment_method
        $data = array();
        $data['payment_option'] = $request->payment_option;
        $data['payment_status'] = $request->payment_option === 'Thanh to??n khi nh???n h??ng' ? '??ang ch??? x??? l??' : '???? thanh to??n';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        if(Auth::check()){
            $order_data['user_id'] = Auth::id();
        }elseif(session()->get('id')){
            $order_data['user_id'] = session()->get('id');
        }
        $order_data['shipping_id'] = $request->session()->get("shipping_id", 0);
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::subtotal();
        $order_data['order_status'] = "??ang ch??? x??? l??";
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

        //update sold_product
        $this->update_sold();


        if ($data['payment_option'] === "B???ng ATM") {
            $this->checkout_atm();
        } elseif ($data['payment_option'] === "Thanh to??n khi nh???n h??ng") {
            session()->flash('success', 'Mua h??ng th??nh c??ng! Ch??ng t??i s??? li??n h??? b???n s???m nh???t. C???m ??n qu?? kh??ch!');
            Cart::destroy();
            $request->session()->forget('shipping_id');
            return view('home.client.handcash', ['categories' => $categories]);
        }

        // return Redirect('/payment');
    }

    public function checkout_atm()
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/checkout";
        $vnp_TmnCode = "WVZVD7UH";//M?? website t???i VNPAY 
        $vnp_HashSecret = "YAPPWUGUNVNRGADJEPHWYKIIPBVHCMYV"; //Chu???i b?? m???t

        $vnp_TxnRef = '4324'; //M?? ????n h??ng. Trong th???c t??? Merchant c???n insert ????n h??ng v??o DB v?? g???i m?? n??y sang VNPAY
        $vnp_OrderInfo = 'Thanh to??n ????n h??ng';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = 20000 * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['payment_atm'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
    }

    public function update_sold(){
        $count = $this->count_product();
        foreach($count as $key=>$v_count){
            $id = $v_count->product_id;
            $count = $v_count->SL;
            DB::table('product_models')->where('id', $id)->update(['sold' => $count]);
        }
    }

    public function count_product(){
        $count = DB::table('tbl_order_details')
        ->select('tbl_order_details.product_id',  DB::raw('sum(product_sales_quantity) as SL'))->groupBy('tbl_order_details.product_id')->get();
        return $count;
    }

    public function delete_order(Request $request, $id){
        session()->flash('success', 'H???y ????n h??ng th??nh c??ng!');
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
