@extends('layouts.master')

@section('header')
    <x-header titulo="Deudas" localizacion="Deudas" />
@endsection

@section('contenido')

    @livewire('deudas.detalles', ['deudor' => $deudor])

@endsection