<?php

namespace App\Http\Controllers;

use App\Department;
use App\Group;
use Illuminate\Http\Request;
use App\User;
use App\Image;
use App\Notification;
use App\MicroContent;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $users = new User();
        $users = User::orderBy('id', 'desc')->paginate(12);

        $roles=array();
        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    public function approve($id, $micro_content_id, $notificarion_id)
    {
        $microContents = MicroContent::join('micro_content_user', 'micro_content_user.micro_content_id', '=', 'micro_contents.id')
                    ->join('users', 'micro_content_user.user_id', '=', 'users.id')
                    ->where('micro_content_user.user_id', $id)
                    ->where('micro_content_user.micro_content_id', $micro_content_id)
                    ->where('micro_content_user.approve_coach', false)
                    ->select('micro_contents.id',
                            'micro_contents.title',
                            'micro_contents.approve',
                            'micro_contents.public',
                            'micro_contents.type',
                            'micro_contents.user_id')
                    ->first();

        $user = User::find($id);

        $result = DB::table('micro_contents')
        ->join('questions', 'micro_contents.id', '=', 'questions.micro_content_id')
        ->join('answer_user_question', 'questions.id', '=', 'answer_user_question.question_id')
        ->where(array('answer_user_question.is_correct' => true, 'answer_user_question.user_id' => $id, 'micro_contents.id' => $microContents->id))
        ->sum('questions.points');

        $total = DB::table('micro_contents')
                    ->join('questions', 'micro_contents.id', '=', 'questions.micro_content_id')
                    ->where('micro_contents.id', $micro_content_id)
                    ->sum('questions.points');

        if (Notification::find($notificarion_id)->user_id == Auth::user()->id) {
            return view('users.coach.show', compact('microContents', 'total', 'result', 'notificarion_id', 'user'));
        }
        else {
            return view('error.404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $roles = Role::all();
        $departments = Department::all();
        $groups = Group::all();
        return view('users.create',compact('departments', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, User::rules());

        $data = $request->all();
        if(array_key_exists('avatar', $data)) {
            $avatar_filename = save_avatar($data['avatar'], $data['crop_x'], $data['crop_y'], $data['crop_width'], $data['crop_height']);
            $data['avatar'] = $avatar_filename;
        }

        $user = User::create($data);

        // DB::table('model_has_roles')->insert([
        //     'role_id' => $data['role'],
        //     'model_type' => 'App\User',
        //     'model_id' => $user->id
        // ]);

        $user->groups()->sync($request->group);
        $user->departments()->sync($request->department);

        return redirect()->route('users.index')->withSuccess(trans('users.user_success_create'));
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
        // $roles = Role::all();
        // $userRoleId = $user->roles[0]->id;
        $roles = array('' => 'Sin selecionar', 'Administrador' => 'Administrador', 'Jefe' => 'Jefe', 'Empleado' => 'Empleado');
        $departments = Department::all();
        $groups = Group::all();

        return view('users.edit', compact('user', 'departments', 'groups'));
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
        $this->validate($request, User::rules(true, $id));

        $data = $request->all();
        $need_delete_old = false;
        if(array_key_exists('avatar', $data))
        {
            $avatar_filename = save_avatar($data['avatar'], $data['crop_x'], $data['crop_y'], $data['crop_width'], $data['crop_height']);
            $data['avatar'] = $avatar_filename;
            $need_delete_old = true;
        }

        $user = User::findOrFail($id);

        if($user->avatar && $need_delete_old)
        {
            delete_avatar_file($user->avatar);
        }

        if(array_key_exists('is_coach', $data) === false)
            $data['is_coach'] = false;

        $user->update($data);

//        DB::table('model_has_roles')->insert([
//            'role_id' => $data['role'],
//            'model_type' => 'App\User',
//            'model_id' => $user->id
//        ]);
        // Los usuarios solo tienen un rol
        // DB::table('model_has_roles')->where('model_id', $user->id)->update(['role_id' => $data['role']]);

        return redirect()->route('users.index')->withSuccess(trans('users.user_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->avatar)
        {
            delete_avatar_file($user->avatar);
        }

        // User::destroy($id);
        $user->delete();

        return back()->withSuccess(trans('users.user_success_delete'));
    }

    public function search(Request $request) {
        $search = $request->search;
        $coach = $request->get('coach', 0);
        $but = $request->get('but', null);

        $whereName = [
            ['name', 'like', "%$search%"]
        ];

        $whereLName = [
            ['last_name', 'like', "%$search%"]
        ];

        $whereFullName = 'CONCAT(users.name," ", users.last_name) like \'%' . $search . '%\'';

        if($but) {
            $butId = ['id', '<>', $but];
            $whereName[] = $butId;
            $whereLName[] = $butId;
            $whereFullName .= " AND id <> $but";
        }

        if($coach == 1) {
            $isCoach = ['is_coach', '=', 1];
            $whereName[] = $isCoach;
            $whereLName[] = $isCoach;
            $whereFullName .= " AND is_coach = 1";
        }

        $users = User::where($whereName)
            ->orWhere($whereLName)
            ->orWhereRaw($whereFullName)
            ->get(['id', 'name', 'last_name', 'avatar']);


        return view('components.user-dropdown-item', compact('users'));
    }

}
