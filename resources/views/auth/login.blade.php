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
        <img class="mb-1" src="{{ asset('dist/img/logo.png') }}" alt="" width="300" >
        <h1 class="h3 mb-3 font-weight-normal">Acceder</h1>
        <label class="sr-only">Nombre de usuario</label>
        <input type="text" name="nombre" class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
            placeholder="Nombre de usuario" required autofocus>
        <label class="sr-only">Contraseña</label>
        <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
            placeholder="Contraseña" required>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="recuerdame" value="1"> Recordarme
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesión</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2021-<?php echo date('Y'); ?> </p>
    </form>
@endsection
