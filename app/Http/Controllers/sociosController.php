<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Socio;

use App\Http\Requests\ValidatePartnerRequest;
use App\Http\Requests\ValidateFacebookRequest;

class sociosController extends Controller
{
    public function validateSocio (ValidatePartnerRequest $req) {
        // Values
        //$params = $req->all();
        $codigo = $req->input('codigo');
        $dni = $req->input('dni');

        // $value = $req->
        // query uri
        // age = $req->query('dni');

        $message = '';

        $userFound = Socio::where('codigo', $codigo)
            ->where('numero_doc', $dni)
            ->first();

        if(!is_null($userFound)) {
            // Evaluando existencia del campo email en el socio
            if($userFound->email == '') {
                // Si el campo email es blanco
                $data['codigo'] = $codigo;
                $data['dni'] = $dni;

                // Render view: Processo success
                return view('process_success', $data);

            } else {
                // Si en campo email ya esta lleno
                // Render view: Processo again
                $message = 'El campo email '. $userFound->email .' ya se encuentra registrado en la DB';

                // Render view: Processo Fail
                $data['message'] = $message;
                return view('process_again', $data);
            }

        } else {
            // throw new \Exception('Partner has not been found');

            // El usuario no fue encontrado en la DB
            // Render view: Processo fail
            $message = 'El usuario solicitado no fue encontrado 403';
            $data['message'] = $message;

            return view('process_again', $data);
        }
    }

    public function updateSocio (ValidateFacebookRequest $req) {
        // Value
        $params = $req->all();
        $codigo = $params['codigo'];
        $dni = $params['dni'];
        $email = $params['email'];
        $name = $params['name'];
        $avatar = $params['avatar'];

        $message = '';

        // Buscando Socio por Coincidencia, campo dni y codigo
        $userFound = Socio::where('numero_doc', $dni)
            ->where('codigo', $codigo)
            ->first();

        // Validando Existencia de Socio en la DB
        if(!is_null($userFound)) {
            // Validando campo email
            if($userFound->email !== '') {
                // Render view: Processo again
                $message = 'El campo email '. $userFound->email .' ya se encuentra registrado en la DB';

                $data['message'] = $message;
                $data['name'] = $name;
                $data['avatar'] = $avatar;

                return view('process_correct', $data);

            } else {
                // Si en campo email es blanco
                $userFound->email = $email;
                $userFound->save();

                // Render view: Processo Correct
                $message = 'Registramos tus datos de facebook exitosamente!';

                $data['message'] = $message;
                $data['name'] = $name;
                $data['avatar'] = $avatar;

                return view('process_correct', $data);
            }

        } else {
            // El usuario no fue encontrado en la DB
            // Render view: Processo fail
            $message = 'El usuario solicitado no fue encontrado 403';
            $data['message'] = $message;

            return view('process_again', $data);

        }

    }
}
