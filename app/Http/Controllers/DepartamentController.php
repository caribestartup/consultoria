<?php

namespace App\Http\Controllers;

use App\Departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DepartamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departaments=Departments::all();
        return view('departament.index',compact('departaments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departament.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'value' => 'required'
        ]);

        $department =  new Departments();
        $department->value=$request->get('value');

        $department->save();

        return redirect()->route('departament.index')->withSuccess(trans('app.success_store'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //fetch post data
        $department =  Departments::find($id);

        //pass posts data to view and load list view
        return view('departament.show', compact('department','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department=Departments::find($id);

        return view('departament.edit', compact('department','id'));
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
        //validate post data
        $this->validate($request, [
            'value' => 'required'
        ]);
        $department= Departments::find($id);
        $department->value=$request->get('value');
        $department->save();

        //store status message
        Session::flash('success_msg', 'Department updated successfully!');

        return redirect()->route('departament.index')->with('success','Departament updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department =  Departments::find($id);

        $department->delete();

        return redirect()->route('departament.index')->with('success','Department deleted successfully');
    }
}
