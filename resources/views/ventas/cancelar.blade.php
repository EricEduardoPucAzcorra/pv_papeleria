@extends('layouts.master')

@section('titulo', 'Cancelar ventas')

@section('header')
    <x-header titulo="Cancelar venta" localizacion="Ventas" />
@endsection

@section('contenido')
    @livewire('ventas.cancelar-venta')
@endsection
