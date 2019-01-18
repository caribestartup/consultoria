<?php

namespace App\Http\Controllers;

use App\Chatbot;
use App\Topic;
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $approachOptions = ['Plan de acción', 'Intereses', 'Microcontenidos', 'Grupos', 'Reuniones'];
        $chatbot=Chatbot::find($id);
        return view('chatbot.edit', compact('chatbot','id', 'approachOptions'));
    }

    public function show($id)
    {
        //fetch post data
        $chatbot =  Chatbot::find($id);
        //pass posts data to view and load list view
        return view('chatbot.show', compact('chatbot','id'));
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
            'default_response' => 'required',
            'approach' => 'required'
        ]);


        $chatbot =  new chatbot();
        $chatbot->name=$request->get('name');
        $chatbot->description=$request->get('description');
        $chatbot->approach=$request->get('approach');
        $chatbot->default_response=$request->get('default_response');

        $chatbot->save();

        return redirect()->route('chatbot.index')->withSuccess(trans('app.success_store'));
//        return back()->withSuccess(trans('app.success_store'));

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
        
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'default_response' => 'required',
            'approach' => 'required',
        ]);

        $data = $request->all();

        $chatbot= Chatbot::find($id);
        $chatbot->update($data);

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

        // return redirect()->route('chatbot.index')->withSuccess(trans('app.success_store'));
        return redirect()->route('chatbot.index')->with('success','Chatbot deleted successfully');
    }
}
