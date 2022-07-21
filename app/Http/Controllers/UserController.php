<?php

namespace App\Http\Controllers;

use App\Models\Social;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::orderBy('id', 'DESC')->where('is_admin', 0)->paginate(10);
        // $user_admins = User::orderBy('id', 'DESC')->where('is_admin', 1)->paginate(10);

        // if ($key = request()->key) {
        //     $users = User::orderBy('id', 'DESC')->where('name', 'like', '%' . $key . '%')->paginate(10);
        // }
        if(request()->ajax()){
            $users = User::orderBy('id', 'DESC')->get(); 
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function($user){
                    $role = $user->is_admin;
                    if($role === 1){
                        return "<p style='color: red'>Admin</p>";
                    }elseif($role === 2){
                        return "Nhân viên";
                    }else{
                        return "Khách hàng";
                    }
                })
                ->addColumn('avatar', function($user){
                    if(file_exists(public_path("./uploads_user/$user->id.jpg"))){
                        return '<img width="100" height="100" src="/uploads_user/'.$user->id.'.jpg" alt="">';
                    }else{
                        return '<img width="100" height="100" src="/uploads/no_photo.png"alt="">';
                    }
                })
                ->addColumn('action', 'admin/user/user-action')
                ->rawColumns(['avatar', 'action', 'role'])->make(true);
        }
        return view('admin/user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/user.new');
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|min:10|numeric',
            'sex' => 'required',
            'DOB' => 'required|before:' . now()->toDateString(),
        ];

        $vaildator = Validator::make($request->all(), $rules);

        if ($vaildator->fails())
            return redirect()->back()->withErrors($vaildator)->withInput();
        else {
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->DOB = $request->DOB;
            $user->sex = $request->sex;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->is_admin = 2;

            $user->save();

            return redirect()->route('user.index');
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
        $user = User::findOrFail($id);
        return view('admin/user.edit', ['user' => $user]);
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
            'email' => 'required|string|email|max:255|unique:users',
            'avatar' => 'mimes:jpeg, bmp, png, gif, jpg'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return redirect()->route('user.edit')->withErrors($validator)->withInput();
        else {
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;

            $user->save();

            $file = $request->avatar;
            if ($file)
                $file->move("./uploads_user/", "$id.jpg");

            return redirect()->route('user.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Social::where('user', $request->id)->delete();
        $user = User::findOrFail($request->id)->delete();
        return Response()->json($user);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $remember = $request->remember;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            if (Auth::user()->role == 1) {
                return view('admin.index');
            } else {
                return view('admin');
            }
        }
    }
}
