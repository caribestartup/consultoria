<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->rol == "Administrador") {
            $topics=Topic::all();
            return view('topic.index',compact('topics'));
        }
        else {
            return view('error.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->rol == "Administrador") {
            return view('topic.create');
        }
        else {
            return view('error.403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->rol == "Administrador") {
            $this->validate($request, [
                'value' => 'required'
            ]);

            $topic =  new Topic();
            $topic->value=$request->get('value');

            $topic->save();
            $topic->interests()->sync($request->id);

            return redirect()->route('topics.index')->withSuccess(trans('app.success_store'));
        }
        else {
            return view('error.403');
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
        if (Auth::user()->rol == "Administrador") {
            //fetch post data
            $topic =  Topic::find($id);

            //pass posts data to view and load list view
            return view('topic.show', compact('topic','id'));
        }
        else {
            return view('error.403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->rol == "Administrador") {
            $topic=Topic::find($id);

            return view('topic.edit', compact('topic','id'));
        }
        else {
            return view('error.403');
        }
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
        if (Auth::user()->rol == "Administrador") {
            //validate post data
            $this->validate($request, [
                'value' => 'required'


            ]);
            $topic= Topic::find($id);
            $topic->value=$request->get('value');
            $topic->save();

            //store status message
            Session::flash('success_msg', 'Topic updated successfully!');

            return redirect()->route('topics.index')->with('success','Topic updated successfully');
        }
        else {
            return view('error.403');
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
        if (Auth::user()->rol == "Administrador") {
            $topic =  Topic::find($id);
            $topic->delete();
            return redirect()->route('topics.index')->with('success','Product deleted successfully');
        }
        else {
            return view('error.403');
        }
    }
}
