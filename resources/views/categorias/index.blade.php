@extends('layouts.master')

@section('titulo', 'Categorías')

@section('header')
    <x-header titulo="Categorías" localizacion="Categorías" />
@endsection

@section('contenido')
    @livewire('categorias.categoria')
@endsection