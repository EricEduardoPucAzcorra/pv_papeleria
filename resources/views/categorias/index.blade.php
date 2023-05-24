@extends('layouts.master')

@section('titulo', 'Categorias')

@section('header')
    <x-header titulo="Categorias" localizacion="Categorias" />
@endsection

@section('contenido')
    @livewire('categorias.categoria')
@endsection