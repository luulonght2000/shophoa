<?php

namespace App\Http\Controllers;

use App\Models\StyleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StyleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $styles = StyleModel::orderBy('id', 'DESC')->paginate(5);
        return view('admin.style.index', ['styles' => $styles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.style.new');
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
            'name' => "required|max:50|unique:style_models"
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return redirect()->route('style.create')->withErrors($validator)->withInput();
        else {
            $style = new StyleModel();
            $style->name = $request->name;
            $style->description = $request->description;

            $style->save();

            return redirect()->route('style.index');
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
        $style = StyleModel::findorFail($id);
        return view('admin/style.edit', ['style' => $style]);
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
            'name' => 'required|max:30'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return redirect()->route('style.edit', ['style' => $id])->withErrors($validator)->withInput();
        else {
            $style = StyleModel::find($id);
            $style->name = $request->name;
            $style->description = $request->description;

            $style->save();

            return redirect()->route('style.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $style = StyleModel::findOrFail($id);
        $style->delete();

        return redirect()->route('style.index');
    }
}
