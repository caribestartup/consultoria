<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\PlanQuestionOption;
use App\PlanAnswer;
use App\PlanQuestion;
use App\Notification;

class TrainingController extends Controller
{
    public function show($id)
    {
        $question = PlanQuestion::where(array('email' => $email))->get();
        return view('training.index', compact('question'));
    }

    public function create(Request $request)
    {
        $email = $request->email;
        $id = $request->id;
        $url = '#';

        $exist_user = User::where(array('email' => $email))->get();

        if (sizeof($exist_user) > 0) {

            // sacarselo por una notificacion

        } else {

            // crear usuario nuevo
            $string = mb_split('@', $email);
            $name = $string[0];
            $pass = bcrypt($name);
            $rol = 'Evaluador';

            $dataUser['name'] = $name;
            $dataUser['email'] = $email;
            $dataUser['password'] = $pass;
            $dataUser['rol'] = $rol;
            $newUser = User::created($dataUser);

            // enviar correo
            Mail::to($email)->subject('Evaluar entrenamiento')->send('Visite nuestro sitio web para evaluar el plan de accion con el usuario '.$email.' contraseña '.$name.' por favor entre al siguiente link y logueese con las credenciales descritas: '.$url.'/'.$id );

        }
    }

    public function evaluation(Request $request)
    {

    }
}
