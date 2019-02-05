<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();
        return view('group.index',compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('group.create');
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

        $group =  new Group();
        $group->value=$request->get('value');

        $group->save();

        return redirect()->route('groups.index')->withSuccess(trans('app.success_store'));
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
        $group =  Group::find($id);

        //pass posts data to view and load list view
        return view('group.show', compact('group','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::find($id);

        return view('group.edit', compact('group','id'));
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
        $group= Group::find($id);
        $group->value=$request->get('value');
        $group->save();

        //store status message
        Session::flash('success_msg', 'Group updated successfully!');

        return redirect()->route('groups.index')->with('success','Group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group =  Group::find($id);

        $group->delete();

        return redirect()->route('groups.index')->with('success','Group deleted successfully');
    }

    public function search(Request $request) {
        $search = $request->search;
        $but = $request->get('but', null);

        $whereName = [
            ['value', 'like', "%$search%"]
        ];

        if($but) {
            $butId = ['id', '<>', $but];
            $whereName[] = $butId;
            $whereLName[] = $butId;
            $whereFullName .= " AND id <> $but";
        }

        $groups = Group::where($whereName)->get(['id', 'value']);

        return view('components.group-dropdown-item', compact('groups'));
    }
}
