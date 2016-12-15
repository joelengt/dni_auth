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

class sociosController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function data (Request $req) {
        // Valores del formulario

        $dni_get = $req->input('dni');
        $codigo_get = $req->input('codigo');
        
        // Validando Campo de dni y codigo
        $userFound = Socio::where('numero_doc', $dni_get)
            ->where('codigo', $codigo_get)
            ->first();

        if(!is_null($userFound)) {
            // El usuario fue encontrado en la DB

            if($userFound->email == '') {
                // Si el campo email es blanco
                $data['codigo'] = $codigo_get;
                $data['dni'] = $dni_get;

                return view('process_success', $data);

            } else {
                // Si en campo email ya esta lleno
                return view('process_again');
            }
            
        } else {
            // El usuario no fue encontrado en la DB
            return view('process_fail');

        }

    }

}
