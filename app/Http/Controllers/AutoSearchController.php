<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\User;
use Illuminate\Http\Request;

class AutoSearchController extends Controller
{
    public function index()
    {
        return view('test.searchDemo');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = ProductModel::select("name as value", "id")
                    ->where('name', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
    
        return response()->json($data);
    }

    public function bookList(){
        $books = ProductModel::get();
        return view('test.list',compact('books'));
    }
 
    public function bookEdit ($id){
         $bookData = ProductModel::find($id);
         return response()->json([
            'status' =>200,
            'bookdata' =>$bookData,
        ]);
    }
 
    public function bookUpdate(Request $request){
        $bookData = ProductModel::find($request->book_id);
        dd($bookData);
    }

    public function start(){
        return view('test.start');
    }
}
