@extends('layouts.master')

@section('titulo', 'Lista de usuarios')

@section('header')
    <x-header titulo="Usuarios" localizacion="Usuarios" />

@endsection

@section('contenido')

    @livewire('usuarios.usuarios')

@endsection
