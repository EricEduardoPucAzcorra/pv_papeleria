@extends('layouts.master')

@section('titulo', 'Lista de deudas')

@section('header')
    <x-header titulo="Deudas" localizacion="Deudas" />
    
@endsection

@section('contenido')

    @livewire('deudas.deuda')

@endsection