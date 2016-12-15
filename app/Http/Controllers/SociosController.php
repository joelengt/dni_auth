<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Socio;

use App\Http\Requests\ValidatePartnerRequest;
use App\Http\Requests\ValidateFacebookRequest;

class SociosController extends Controller
{
    public function validateSocio (ValidatePartnerRequest $req) {
        // Values
        $codigo = $req->input('codigo');
        $dni = $req->input('dni');

        $userFound = Socio::where('codigo', $codigo)
            ->where('numero_doc', $dni)
            ->first();

        if(!is_null($userFound)) {
            // Evaluando existencia del campo email en el socio

            if($userFound->email == '') {
                $data['codigo'] = $codigo;
                $data['dni'] = $dni;

                // Render view: Processo success
                return view('process_success', $data);

            } else {
                // Render view: Processo again
                $data['message'] = 'El campo email '. $userFound->email .' ya se encuentra registrado en la DB';;
                return view('process_again', $data);
            }

        } else {
            // Render view: Processo fail
            $data['message'] = 'El usuario solicitado no fue encontrado 403';
            return view('process_again', $data);
        }
    }

    public function updateSocio (ValidateFacebookRequest $req) {
        // Value
        $codigo = $req->input('codigo');
        $dni = $req->input('dni');
        $email = $req->input('email');
        $name = $req->input('name');
        $avatar = $req->input('avatar');

        // Buscando Socio por Coincidencia, campo dni y codigo
        $userFound = Socio::where('numero_doc', $dni)
            ->where('codigo', $codigo)
            ->first();

        // Validando Existencia de Socio en la DB
        if(!is_null($userFound)) {
            $data['name'] = $name;
            $data['avatar'] = $avatar;

            // Validando campo email
            if($userFound->email !== '') {
                // Render view: Processo again
                $data['message'] = 'El campo email '. $userFound->email .' ya se encuentra registrado en la DB';
                return view('process_correct', $data);
            } else {
                // Si en campo email es blanco
                $userFound->email = $email;
                $userFound->save();

                // Render view: Processo Correct
                $data['message'] = 'Registramos tus datos de facebook exitosamente!';

                return view('process_correct', $data);
            }

        } else {
            // Render view: Processo fail
            $data['message'] = 'El usuario solicitado no fue encontrado 403';
            return view('process_again', $data);
        }

    }
}
