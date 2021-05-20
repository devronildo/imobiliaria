@extends('web.master.master')

@section('content')

    <div class="container p-5">
    <h2 class="text-center text-front">Seu e-mail foi enviado com sucesso! Em breve entraremos em contato.</h2>
    <p class="text-center"><a href="{{ url()->previous() }}" class="text-front">... Continuar navegando!</a></p>
    </div>

@endsection