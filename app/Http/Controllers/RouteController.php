<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    //
    public function __invoke()
    {
        return view('dashboard.index');
    }

    public function productos()
    {
        return view('productos.index');
    }

    public function categorias()
    {
        return view('categorias.index');
    }

    public function ventas()
    {
        return view('ventas.index');
    }

    public function cancelacion()
    {
        return view('ventas.cancelar');
    }

    public function precios()
    {
        return view('precios.index');
    }

    public function deudas()
    {
        return view('deudas.index');
    }

    public function deudasShow($deudor)
    {
        return view('deudas.show', compact('deudor'));
    }

    public function usuarios(){
        return view('usuarios.usuarios');
    }
}
