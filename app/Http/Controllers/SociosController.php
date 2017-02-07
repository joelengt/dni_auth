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
        // Request params values
        $dni = $req->input('dni');

        // Search Partner on DataBase
        $userFound = Socio::where('numero_doc', $dni)
            ->first();

        if(!is_null($userFound)) {
            // Evaluando existencia del campo email en el socio

            if($userFound->email == '') {

                $data['dni'] = $dni;    

                // Render view: Processo success
                return response()->json($data);

            } else {
                // Render view: Processo again
                $data['message'] = 'El campo email '. $userFound->email .' ya se encuentra registrado en la DB';

                return response()->json($data);
            }

        } else {
            // Render view: Processo fail
            $data['message'] = 'El usuario solicitado no fue encontrado 403';
            return response()->json($data);
        }
    }

    public function updateSocio (ValidateFacebookRequest $req) {
        // Request Params
        $dni = $req->input('dni');
        $email = $req->input('email');
        $name = $req->input('name');
        $avatar = $req->input('avatar');

        // Search Partner on DB by numero_doc and codigo
        $userFound = Socio::where('numero_doc', $dni)
            ->first();

        // Validate if data partner exit on DB
        if(!is_null($userFound)) {
            $data['name'] = $name;
            $data['avatar'] = $avatar;

            // Validate attribute email
            if($userFound->email !== '') {
                // Render view: Processo again
                $data['message'] = 'El campo email '. $userFound->email .' ya se encuentra registrado en la DB';
                return response()->json($data);

            } else {
                // If attribute is blank
                $userFound->email = $email;
                $userFound->save();

                // Render view: Process Correct
                $data['message'] = 'Registramos tus datos de facebook exitosamente!';

                return response()->json($data);
            }

        } else {
            // Render view: Processo fail
            $data['message'] = 'El usuario solicitado no fue encontrado 403';
            return response()->json($data);
        }

    }
}
