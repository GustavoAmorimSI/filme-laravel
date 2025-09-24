@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($exercise) ? 'Editar Exercício' : 'Adicionar Exercício' }}</h1>

        <form method="POST" action="{{ isset($exercise) ? route('exercises.update', $exercise) : route('exercises.store') }}">
            @csrf
            @if(isset($exercise))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="nome">Nome da atividade</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $exercise->nome ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="duracao">Duração (minutos)</label>
                <input type="number" class="form-control" id="duracao" name="duracao" value="{{ old('duracao', $exercise->duracao ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="calorias_gastas">Calorias gastas</label>
                <input type="number" class="form-control" id="calorias_gastas" name="calorias_gastas" value="{{ old('calorias_gastas', $exercise->calorias_gastas ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" class="form-control" id="data" name="data" value="{{ old('data', isset($exercise) ? $exercise->data->toDateString() : '') }}" required>
            </div>

            <button type="submit" class="btn btn-success mt-2">
                {{ isset($exercise) ? 'Atualizar' : 'Salvar' }}
            </button>

            <a href="{{ route('exercises.index') }}" class="btn btn-secondary mt-2">Cancelar</a>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger mt-2">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
