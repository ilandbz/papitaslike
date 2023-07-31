<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $data['title'] = 'Bienvenidos, Papitas Huanuqueñas Like';
        return view('app', $data);
    }
    
}
