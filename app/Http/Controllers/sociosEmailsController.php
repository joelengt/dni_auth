<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\Http\Requests;
use App\Socio;

class SociosEmailsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function data (Request $req) {
        // Valores del formulario
        $codigo_get = $_POST['codigo'];
        $dni_get = $_POST['dni'];
        $email_get = $_POST['email'];

        $userFound = Socio::where('numero_doc', $dni_get)
                    ->where('codigo', $codigo_get)
                    ->first();
        
        if(!is_null($userFound)) {

            if($userFound->email !== '') {
                // Si el campo email es blanco
                return view('process_again');

            } else {
                // Si en campo email ya esta lleno
                $userFound->email = $email_get;
                $userFound->save();

                return view('process_correct');
            }

        } else {
            // El usuario no fue encontrado en la DB
            return view('process_fail');

        }

    }

}
