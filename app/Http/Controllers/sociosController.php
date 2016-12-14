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
        $user_find = Socio::where('numero_doc', $dni_get)
                    ->where('codigo', $codigo_get)
                    ->count();
                     
        if($user_find > 0) {
            // El usuario fue encontrado en la DB

            $data['codigo'] = $codigo_get;
            $data['dni'] = $dni_get;

            return view('process_success', $data);
            
        } else {
            // El usuario no fue encontrado en la DB
            return view('process_fail');

        }

    }

}
