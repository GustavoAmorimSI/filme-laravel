@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Editar Exercício</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('exercises.update', $exercise) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Exercício *</label>
                                <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                       id="nome" name="nome" value="{{ old('nome', $exercise->nome) }}" required>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="duracao" class="form-label">Duração (minutos) *</label>
                                <input type="number" class="form-control @error('duracao') is-invalid @enderror" 
                                       id="duracao" name="duracao" value="{{ old('duracao', $exercise->duracao) }}" min="1" required>
                                @error('duracao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="calorias_gastas" class="form-label">Calorias Gastas *</label>
                                <input type="number" class="form-control @error('calorias_gastas') is-invalid @enderror" 
                                       id="calorias_gastas" name="calorias_gastas" value="{{ old('calorias_gastas', $exercise->calorias_gastas) }}" min="1" required>
                                @error('calorias_gastas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="data" class="form-label">Data do Exercício *</label>
                                <input type="date" class="form-control @error('data') is-invalid @enderror" 
                                       id="data" name="data" value="{{ old('data', $exercise->data->format('Y-m-d')) }}" required>
                                @error('data')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('exercises.index') }}" class="btn btn-secondary me-md-2">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Atualizar Exercício</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection