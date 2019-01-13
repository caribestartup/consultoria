<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
//    use HasApiTokens;
    use Notifiable;
    use HasRoles;

//    protected $connection = 'empresa1';

    protected $table = 'users';

    protected $primaryKey = 'id';

//    public function __construct()
//    {
//        parent::__construct();
////        var_dump("Model User");
////        var_dump($this->connection);die;
//        $this->connection = Session::get('selected.database');
//    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'evaluation',
        'email',
        'password',
        'is_coach',
        'avatar',
        'boss_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//    public function roles()
//    {
//        return $this->belongsToMany(Role::class);
//    }
    public function roles_custom()
    {
        return $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            'model_id',
            'role_id'
        )->select('id','name');
    }

    public function boss()
    {
        return $this->belongsTo(User::class, 'boss_id');
    }

    /*public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function userVisibilities()
    {
        return $this->hasMany(UserVisibility::class);
    }

    public function boss()
    {
        return $this->hasOne(User::class);
    }

    public function interestUsers()
    {
        return $this->belongsToMany(Interest::class);
    }

    public function collaborations()
    {
        return $this->belongsToMany(ActionPlanConfiguration::class);
    }

    public function evaluations()
    {
        return $this->belongsToMany(EvaluationConfiguration::class );
    }

    public function actionPlanConfigurations()
    {
        return $this->hasMany(ActionPlanConfiguration::class);
    }

    public function coach()
    {
        return $this->hasMany(ActionPlanConfiguration::class);
    }

    public function interests()
    {
        return $this->hasMany(Interest::class);
    }

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id = null)
    {
        $commun = [
            'name'      => "required",
            'email'     => "required|email|unique:users,email,$id",
            'password'  => 'nullable|confirmed',
            'avatar'    => 'image',
            'role'      => 'required',
        ];

        if ($update) {
            return $commun;
        }

        return array_merge($commun, [
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /*
    |------------------------------------------------------------------------------------
    | Attributes
    |------------------------------------------------------------------------------------
    */
    public function setPasswordAttribute($value='')
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getAvatarUrlAttribute()
    {
        $value = $this->avatar;
        if (!$value) {
            return config('variables.avatar.public').'/'.config('variables.avatar.default');
        }

        return config('variables.avatar.public').$value;
    }

    /*
    |------------------------------------------------------------------------------------
    | Boot
    |------------------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::updating(function($user)
        {
            $original = $user->getOriginal();

            if (\Hash::check('', $user->password)) {
                $user->attributes['password'] = $original['password'];
            }
        });
    }

    public function fullName() {
        return $this->name . ' ' . $this->last_name;
    }

    public function departments(){
        return $this->belongsToMany(Department::class);
    }

    public function groups(){
        return $this->belongsToMany(Group::class);
    }
}
