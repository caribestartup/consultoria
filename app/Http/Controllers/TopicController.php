<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics=Topic::all();
        return view('topic.index',compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('topic.create');
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


        $topic =  new Topic();
        $topic->value=$request->get('value');


        $topic->save();
        $topic->interests()->sync($request->id);
//

        return redirect()->route('topics.index')->withSuccess(trans('app.success_store'));
//        return back()->withSuccess(trans('app.success_store'));
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
        $topic =  Topic::find($id);

        //pass posts data to view and load list view
        return view('topic.show', compact('topic','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $topic=Topic::find($id);

        return view('topic.edit', compact('topic','id'));

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
        $topic= Topic::find($id);
        $topic->value=$request->get('value');
        $topic->save();


        //store status message
        Session::flash('success_msg', 'Topic updated successfully!');

        return redirect()->route('topics.index')->with('success','Topic updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic =  Topic::find($id);
        $topic->micro_contents()->detach();
        $topic->interests()->detach();

        echo ($topic->value);
        $topic->delete();

        //store status message


        return redirect()->route('topics.index')->with('success','Product deleted successfully');
    }
}
