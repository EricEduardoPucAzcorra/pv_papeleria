@extends('layouts.master')

@section('titulo', 'Lista de productos')

@section('header')
    <x-header titulo="Productos" localizacion="Productos" />
    
@endsection

@section('contenido')

    @livewire('productos.productos')

@endsection