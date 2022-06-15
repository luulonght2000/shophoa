<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class OderController extends Controller
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
        $userInfo = DB::table('tbl_order')
            ->join('users', 'users.id', '=', 'tbl_order.user_id')
            ->join('shipping_models', 'shipping_models.id', '=', 'tbl_order.shipping_id')
            ->join('tbl_payment', 'tbl_payment.payment_id', '=', 'tbl_order.payment_id')
            ->select('users.*', 'shipping_models.*', 'tbl_payment.*')
            ->where('tbl_order.order_id', '=', $id)
            ->first();

        $order_id=DB::table('tbl_order')->where('tbl_order.order_id', '=', $id)->first();

        $order_by_id = DB::table('tbl_order')
            ->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
            ->where('tbl_order.order_id', $id)
            ->select('tbl_order.*', 'tbl_order_details.*')->get();
            
        return view('admin.order.view_order', ['userInfo'=> $userInfo, 'order_by_id' => $order_by_id, 'order_id'=>$order_id]);

    }

    public function order_status(Request $request, $id){
        $order_status = $request->shipping;
        DB::table('tbl_order')->where('order_id', $id)->update(['order_status' => $order_status]);
        return Redirect::to('/admin/manage-order');
    }

    public function unactive($id)
    {
        DB::table('tbl_payment')->where('payment_id', $id)->update(['payment_status' => "Đang chờ xử lý"]);
        return redirect()->back()->with('error', 'Đơn hàng chưa thanh toán!');
    }

    public function active($id)
    {
        DB::table('tbl_payment')->where('payment_id', $id)->update(['payment_status' => "Đã thanh toán"]);
        return redirect()->back()->with('success', 'Đơn hàng đã thanh toán thành công!');
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
    }

    public function manage_order()
    {
        $all_order = DB::table('tbl_order')
            ->join('users', 'tbl_order.user_id', '=', 'users.id')
            ->join('tbl_payment', 'tbl_payment.payment_id', '=', 'tbl_order.payment_id')
            ->select('tbl_order.*', 'users.name', 'tbl_payment.payment_status')
            ->orderby('tbl_order.order_id', 'desc')->paginate(5);
        return view('admin.order.manage_order', ['all_order' => $all_order]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order_id = DB::table('tbl_order')->where('order_id', $id)->delete();
        return Redirect::to('/admin/manage-order');
    }
}
