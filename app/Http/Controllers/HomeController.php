<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Titulo;
use App\User;
use App\Carrera;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function log(){
        return view('layouts.log');
    }

    public function showTitulos(){
        if(Auth::user()->admin){
            $titulos = Titulo::withTrashed()->orderBy('created_at','desc')->get();
        }else{
            $titulos = Titulo::orderBy('created_at','desc')->get();
        }
        $location = 'Lista de titulos';
        $carreras = Carrera::get();
        if($carreras->isEmpty()){
            return redirect("/carrera/show")->with('error', 'No se registraron carreras! Agregue una por favor.');
        }
        return view('abmTitulos.list', compact('titulos','location', 'carreras'));
    }
    
    public function createTitulo(){
        $location = 'Creacion de nuevo titulo';
        $carreras = Carrera::get();
        if($carreras->isEmpty()){
            return redirect("/carrera/show")->with('error', 'No se registraron carreras! Agregue una por favor.');
        }
        return view('abmTitulos.create', compact('location','carreras'));
    }

    public function showTitulo($id){
        $titulo = Titulo::withTrashed()->get()->find($id);
        $carreras = Carrera::get();
        if($titulo->trashed())
            return back()->with('error', 'Titulo eliminado, para restaurarlo, contactese con el administrador');
        return view('abmTitulos.show',compact('titulo','carreras'));
    }
    
    public function showCarreras(){
        $c = null;
        $carreras = Carrera::get();
        if(isset(request()->id)){
            $c = Carrera::get()->find(request()->id);
        }
        return view('abmCarreras.list',compact('carreras','c'));        
    }

    public function showCarrera($id){
        $c = Carrera::withTrashed()->get()->find($id);
        if($c->trashed())
            return back();
        return view('abmCarreras.edit',compact('c'));        
        
    }

    public function listUsers(){
        if(!Auth::user()->admin)
            return redirect()->home();
        $users = User::withTrashed()->get();
        return view("auth.list",compact('users'));
    }

    public function editUser($id){
        if(!Auth::user()->admin)
            return redirect()->home();
        $users = User::withTrashed()->get();
        $u = $users->find($id);
        return view("auth.list", compact('u','users'));
    }
}
