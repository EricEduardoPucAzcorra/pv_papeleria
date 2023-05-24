@extends('layouts.master')

@section('header')
    <x-header titulo="Home" localizacion="Dashboard" />
@endsection

@section('titulo', 'Panel de inicio')

@section('contenido')
    @livewire('dashboard')
@endsection
