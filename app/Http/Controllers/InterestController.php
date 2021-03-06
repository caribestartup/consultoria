<?php

namespace App\Http\Controllers;

use App\Interest;
use Illuminate\Support\Facades\Session;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InterestController extends Controller
{


    public function index(Request $request)
    {
        $interests = Interest::paginate(12);
        return view('interest.index', compact('interests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $interests = Interest::all();
        $topics=Topic::all();

        return view('interest.create', compact('interests'),compact('topics'));
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
            'title' => 'required',
            'importance_level',
            'knowledge_valuation',
            'expiration_date' ,
            'objectives' => 'required',
            'public' ,
            'reminders',
            'reminders_period'
        ]);

        $interests =  new Interest();
        $interests->title=$request->get('title');
        $interests->expiration_date=$request->get('expiration_date');
        $interests->objectives=$request->get('objectives');
        $interests->knowledge_valuation=$request->get('knowledge_valuation');
        $interests->importance_level=$request->get('importance_level');
        $interests->reminders=$request->get('reminders');

        if($interests->reminders == true){
            if($request->get('reminders_period') == 1){
                $interests->reminders_value = \DateTime::createFromFormat('H:i', $request->get('reminders_value_hour'))->getTimestamp();
            }
            else if($request->get('reminders_period') == 2){
                $interests->reminders_value = $request->get('reminders_value_day');
            }
            else if($request->get('reminders_period') == 3){
                $interests->reminders_value = $request->get('reminders_value_month');
            }
            else{
                $interests->reminders_value = $request->get('reminders_value_year');
            }
        }

        $interests->reminders_period=$request->get('reminders_period');
        $interests->user_id=Auth::user()->id;
        $interests->save();

        DB::table('user_interest')->insert([
            'user_id' =>  $interests->user_id,
            'interest_id' => $interests->id

        ]);

        $interests->topics()->sync($request->topic);

        return redirect()->route('interests.index')->withSuccess(trans('app.success_store'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $interests =  \App\Interest::find($id);
        $interestss = Interest::all();
        $topics = Topic::all();

        //load form view
        return view('interest.edit', compact('topics'), compact('interests','id'),compact('interestss'));
    }

    public function show($id)
    {
        //fetch post data
        $interests =  \App\Interest::find($id);
        $topics = Topic::all();

        //pass posts data to view and load list view
        return view('interest.show', compact('interests','id'), compact('topics'));
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
            'title' => 'required',
            'importance_level' => '',
            'knowledge_valuation' => '',
            'expiration_date' => '',
            'objectives' => 'required',
            'public' => '',
            'reminders' => '',
            'reminders_period' => ''
        ]);

        $interests= Interest::find($id);
        $interests->title=$request->get('title');
        $interests->expiration_date=$request->get('expiration_date');
        $interests->objectives=$request->get('objectives');
        $interests->knowledge_valuation=$request->get('knowledge_valuation');
        $interests->importance_level=$request->get('importance_level');
        $interests->reminders=$request->get('reminders');

        if($interests->reminders == true){
            if($request->get('reminders_period') == 1){
                $interests->reminders_value = \DateTime::createFromFormat('H:i', $request->get('reminders_value_hour'))->getTimestamp();
            }
            else if($request->get('reminders_period') == 2){
                $interests->reminders_value = $request->get('reminders_value_day');
            }
            else if($request->get('reminders_period') == 3){
                $interests->reminders_value = $request->get('reminders_value_month');
            }
            else{
                $interests->reminders_value = $request->get('reminders_value_year');
            }
        }

        $interests->reminders_period=$request->get('reminders_period');
        $interests->user_id=Auth::user()->id;
        $interests->save();

        DB::table('user_interest')->insert([
            'user_id' =>  $interests->user_id,
            'interest_id' => $interests->id

        ]);

        $interests->topics()->sync($request->topic);

        //store status message
        Session::flash('success_msg', 'Interest updated successfully!');

        return redirect()->route('interests.index')->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //update post data
        $interests =  \App\Interest::find($id);
        $interests->topics()->detach();

        $interests->delete();

        return redirect()->route('interests.index')->with('success','Product deleted successfully');
    }
}
