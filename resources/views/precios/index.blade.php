@extends('layouts.master')

@section('titulo', 'Calcular precio')

@section('header')
    <x-header titulo="Precios" localizacion="Precios" />
    
@endsection

@section('contenido')
    @livewire('precios.precio')
@endsection