@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1>Meus Exercícios</h1>

        <a href="{{ route('exercises.create') }}" class="btn btn-primary mb-3">Adicionar Exercício</a>

        <form method="GET" action="{{ route('exercises.index') }}" class="mb-3">
            <input type="date" name="data_inicio" value="{{ request('data_inicio') }}">
            <input type="text" name="nome" placeholder="Tipo de exercício" value="{{ request('nome') }}">
            <button type="submit" class="btn btn-secondary">Filtrar</button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Atividade</th>
                    <th>Duração (min)</th>
                    <th>Calorias</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exercises as $ex)
                    <tr>    
                        <td>
                            @if($ex->data instanceof \Carbon\Carbon)
                                {{ $ex->data->format('d/m/Y') }}
                            @else
                                {{ $ex->data ? \Carbon\Carbon::parse($ex->data)->format('d/m/Y') : 'N/A' }}
                            @endif
                        </td>
                        
                        <td>{{ $ex->nome }}</td>
                        <td>{{ $ex->duracao }}</td>
                        <td>{{ $ex->calorias_gastas }}</td>
                        <td>
                            <a href="{{ route('exercises.edit', $ex) }}" class="btn btn-sm btn-warning">Editar</a>

                            <form action="{{ route('exercises.destroy', $ex) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Tem certeza que quer remover este exercício?')"
                                    class="btn btn-sm btn-danger">
                                    Remover
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $exercises->links() }}

    </div>
@endsection