@extends('auth.master')

@section('titulo', 'Acceder')

@section('content')
    <form class="form-signin" action="{{ route('acceder') }}" method="POST" autocomplete="off">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('nombre') }}
                {{ $errors->first('password') }}
            </div>
        @endif
        <img class="mb-1" src="{{ asset('dist/img/jordana-circle.png') }}" alt="" width="190" >
        <h1 class="h3 mb-3 font-weight-normal" style="font-size: 15px">Acceder</h1>
        <label class="sr-only">Nombre de usuario</label>
        <input type="text" name="nombre" class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
            placeholder="Nombre de usuario" required autofocus style="margin-bottom: 10px">
        <label class="sr-only">Contraseña</label>
        <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
            placeholder="Contraseña" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesión</button>
        <p class="mt-5 mb-3 text-muted"><strong>Copyright &copy; 2023-<?php echo date('Y') ?> <a href="#" style="text-decoration: none"> <br> L|<strong>E</strong></a>.</strong>
            Punto de venta</p>
    </form>
@endsection
