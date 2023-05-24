@extends('layouts.master')

@section('titulo', 'Vender productos')

@section('contenido')
    <div class="row">
        @livewire('ventas.ventas')
        @livewire('ventas.cuenta')
    </div>
@endsection