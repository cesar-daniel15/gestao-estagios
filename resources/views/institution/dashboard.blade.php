@extends('institution.layouts.default-institution')

@section('title', 'Gestão Estágios | Institution Dashboard')

@section('page-name', 'Home Dashboard')

@section('content')
    <h1 class="mt-10 font-extrabold text-sky-400">Bem-vindo</h1> <br>
    <div class="flex justify-center items-center">
        <img src="{{ asset('images/banner.jpg') }}" alt="Descrição da imagem" class="w-[60%] h-auto object-cover object-center">
    </div>
@endsection
