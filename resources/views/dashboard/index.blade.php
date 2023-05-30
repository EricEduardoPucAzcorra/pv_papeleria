@extends('layouts.master')

@section('header')
    <x-header titulo="Tablero" localizacion="Dashboard" />
@endsection

@section('titulo', 'Panel de inicio')

@section('contenido')
    @livewire('dashboard')
@endsection
