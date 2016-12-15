<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index (Request $request) {

        //dd(config('book.PI'));
        //dd(env('BOOK_CLASS'));

        return view('welcome');
    }

    public function test ($typeQuery) {
        //dd($dni);

        if(!is_null($typeQuery)) {

            $values = [
                'fruits' => ['watermelon','blueberry','strowberry'],
                'people' => ['juan', 'mark'],
                'figures' => 'something',
                'someone' => [
                    'name' => 'joel',
                    'age' => 20,
                    'twitter' => 'joelengt',
                    'website' => 'http://joelgt.com',
                    'avatar' => 'image.png'
                ]
            ];

            return response()->json($values);

        } else {
            dd('Error');
        }

    }

    public function getP (Request $req) {
        $name = $req->input('name');
        dd($name);
    }

    public function getParams (Request $req) {
        // Request Params
        $name = $req->input('codigo');
        $lastName = $req->input('dni');
        $age = $req->input('age');
        $email = $req->input('email');
        $watter = $req->input('watter');

        if(!is_null($name)) {
            console.log('Valor');
        }
    }

    public function getBuilderNotes($method, $parameters) {
        parent::__call($method, $parameters);

    }
}
