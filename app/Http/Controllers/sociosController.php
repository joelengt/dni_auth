<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Socio;

use App\Http\Requests\ValidatePartnerRequest;

class sociosController extends Controller
{
    public function validateSocio (ValidatePartnerRequest $req) {

        if($req->fails()) {
            return redirect(url('/'))->withErrors($req);
        } else {
            // Opteniendo Valores del formulario
            $dniGet = $req->input('dni');
            $codigoGet = $req->input('codigo');

            $message = '';

            // Evaluando que los campos no llegen vacios
            if($dniGet !== '' && $codigoGet !== '') {

                // Buscando Socio por coincicencia, Campo de dni
                $userFound = Socio::where('codigo', $codigoGet)
                    ->first();

                // Validando Exitencia de Socio por codigo en le DB
                if(!is_null($userFound)) {

                    // El usuario fue encontrado en la DB
                    if($userFound->numero_doc == $dniGet) {
                        // El campo de dni exite en el socio evaluado

                        // Evaluando existencia del campo email en el socio
                        if($userFound->email == '') {
                            // Si el campo email es blanco
                            $data['codigo'] = $codigoGet;
                            $data['dni'] = $dniGet;

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

                        // El usuario por codigo no fue encontrado en la DB
                        $message = 'El campo dni, es incorrecto';

                        // Render view: Processo Fail
                        $data['message'] = $message;
                        return view('process_fail', $data);

                    }

                } else {
                    // El usuario por codigo no fue encontrado en la DB
                    $message = 'El campo codigo, es incorrecto';

                    // Render view: Processo Fail
                    $data['message'] = $message;
                    return view('process_fail', $data);

                }

            } else {

                // Render view: Processo Fail
                $message = 'Los campos codigo y dni son obligatorios';
                $data['message'] = $message;
                return view('process_fail', $data);

            }
        }

    }

    public function updateSocio (Request $req) {

        $params = $req->all();

        // Obteniendo Valores de parametros
        $codigoGet = $params['codigo'];
        $dniGet = $params['dni'];
        $emailGet = $params['email'];

        // Obteniendos informacion del usuario
        $nameGet = $params['name'];
        $avatarGet = $params['avatar'];

        $message = '';

        // Buscando Socio por Coincidencia, campo dni y codigo
        $userFound = Socio::where('numero_doc', $dniGet)
            ->where('codigo', $codigoGet)
            ->first();

        // Validando Existencia de Socio en la DB
        if(!is_null($userFound)) {

            // Validando campo email
            if($userFound->email !== '') {
                // Si el campo email esta lleno

                // Render view: Processo again
                $message = 'El campo email '. $userFound->email .' ya se encuentra registrado en la DB';
                $data['message'] = $message;
                $data['name'] = $nameGet;
                $data['avatar'] = $avatarGet;

                return view('process_correct', $data);

            } else {
                // Si en campo email es blanco
                $userFound->email = $emailGet;
                $userFound->save();


                // Render view: Processo Correct
                $message = 'Registramos tus datos de facebook exitosamente!';
                $data['message'] = $message;
                $data['name'] = $nameGet;
                $data['avatar'] = $avatarGet;

                return view('process_correct', $data);
                // return response()->json(['status' => 'error', 'message' => 'an error has occurred']);
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
