<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\CategoryModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = RoleModel::orderBy('id', 'ASC')->paginate(5);
        $category = CategoryModel::orderBy('id', 'DESC')->get();

        if ($key = request()->key) {
            $roles = RoleModel::orderBy('id', 'DESC')->where('name', 'like', '%' . $key . '%')->paginate(10);
        }

        return view('admin.roles.index', ['roles' => $roles, 'category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CategoryModel::all();

        return view('admin.roles.new', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = new RoleModel();

            $role->name = $request->name;

            $role->save();

            return redirect()->route('role.index')->with("success", "Thêm thành công");
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
        $role = RoleModel::findOrFail($id);
        $categories = CategoryModel::all();

        return view('admin.roles.edit', ['role' => $role, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role = RoleModel::findOrFail($id);

            $role->name = $request->name;

            $role->save();

            return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = RoleModel::findOrFail($id);
        $role->delete();

        return back()->with("success", "Xóa thành công");
    }
}
