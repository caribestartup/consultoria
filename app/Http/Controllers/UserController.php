<?php

namespace App\Http\Controllers;

use App\Department;
use App\Group;
use Illuminate\Http\Request;
use App\User;
use App\Image;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

//    public function __construct()
//    {
//        if(Session::has('selected.database'))
//        {
//            Config::set('database.default',Session::get('selected.database'));
//        }
//    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $users = new User();
        $users = User::orderBy('id', 'desc')->paginate(12);
        // $roles = Role::all();
        // $selectedRoles = [];

        // dd($roles);

        // foreach ($roles as $role)
        // {
        //     if($request->has('role_search_check_'.$role->id) && strcmp($request->get('role_search_check_'.$role->id),"on") == 0)
        //     {
        //         array_push($selectedRoles, $role->id);
        //         $request->session()->put('role_search_check_'.$role->id, $request->get('role_search_check_'.$role->id));
        //     }
        //     else {
        //         $request->session()->remove('role_search_check_'.$role->id);
        //     }
        // }


        // $request->session()->put('search', $request->has('search') ? $request->get('search') : ($request->session()->has('search') ? $request->session()->get('search') : ''));
        //
        //
        // if(count($selectedRoles) > 0) {
        //     $users = $users
        //         ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        //         ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
        //         ->whereRaw('CONCAT(users.name," ", users.last_name) like \'%' . $request->session()->get('search') . '%\'')
        //         ->whereIn('roles.id', $selectedRoles)
        //         ->paginate(12);
        // }
        // else {
        //     $users = $users->whereRaw('CONCAT(users.name," ", users.last_name) like \'%' . $request->session()->get('search') . '%\'')->paginate(12);
        // }
        $roles=array();
        return view('users.index', compact('users', 'roles'));
        // return view('users.index', compact('users'));
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
