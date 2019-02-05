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
        'boss_id',
        'rol'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function boss()
    {
        return $this->belongsTo(User::class, 'boss_id');
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
            'rol'      => 'required',
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

    public function microContents()
    {
        return $this->belongsToMany(MicroContent::class);
    }
}
