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

    public function test ($dni) {
        dd($dni);
    }
}
