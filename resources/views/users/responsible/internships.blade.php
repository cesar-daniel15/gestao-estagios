@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Estágios</h1>
        @if ($internships->isEmpty())
            <p>Não há estágios disponíveis.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Estágio</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($internships as $internship)
                        <tr>
                            <td>{{ $internship->id }}</td>
                            <td>{{ $internship->name }}</td>
                            <td>
                                <a href="{{ route('internship.details', $internship->id) }}">Detalhes</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
