<?php

namespace App\Http\Controllers;

use App\Chatbot;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function index(Request $request)
    {
        $chatbots = Chatbot::all();
        return view('chatbot.index', compact('chatbots'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $approachOptions = ['Plan de acción',  'Intereses', 'Microcontenidos', 'Grupos', 'Reuniones'];
        return view('chatbot.create', compact('approachOptions'));
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
            'name' => 'required',
            'description' => 'required',
            'approach' => 'required'
        ]);


        $chatbot =  new chatbot();
        $chatbot->name=$request->get('name');
        $chatbot->description=$request->get('description');
        $chatbot->approach=$request->get('approach');

        $chatbot->save();

        return redirect()->route('chatbot.index')->withSuccess(trans('app.success_store'));
//        return back()->withSuccess(trans('app.success_store'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $approachOptions = ['Plan de acción',  'Intereses', 'Microcontenidos', 'Grupos', 'Reuniones'];
        $chatbot=Chatbot::find($id);
        return view('chatbot.edit', compact('chatbot','id', 'eventsOptions'));
    }

    public function show($id)
    {
        //fetch post data
        $chatbot =  Chatbot::find($id);
        //pass posts data to view and load list view
        return view('chatbot.show', compact('chatbot','id'));
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
            'name' => 'name',
            'description' => 'required',
            'approach' => 'required',


        ]);
        $chatbot= Chatbot::find($id);
        $chatbot->value=$request->get('name');
        $chatbot->value=$request->get('description');
        $chatbot->value=$request->get('approach');

        $chatbot->save();


        //store status message
        Session::flash('success_msg', 'Chatbot updated successfully!');

        return redirect()->route('chatbot.index')->with('success','Chatbot updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chatbot=  Chatbot::find($id);

        $chatbot->delete();

        //store status message


        return redirect()->route('chatbot.index')->with('success','Chatbot deleted successfully');
    }
}
