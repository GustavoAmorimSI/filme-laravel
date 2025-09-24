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
                <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                       id="nome" name="nome" 
                       value="{{ old('nome', $exercise->nome ?? '') }}" 
                       pattern="[A-Za-zÀ-ÿ\s\-]+" 
                       title="Somente letras, espaços e hífens são permitidos" 
                       required>
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="duracao">Duração (minutos)</label>
                <input type="number" class="form-control @error('duracao') is-invalid @enderror" 
                       id="duracao" name="duracao" 
                       value="{{ old('duracao', $exercise->duracao ?? '') }}" 
                       min="1" required>
                @error('duracao')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="calorias_gastas">Calorias gastas</label>
                <input type="number" class="form-control @error('calorias_gastas') is-invalid @enderror" 
                       id="calorias_gastas" name="calorias_gastas" 
                       value="{{ old('calorias_gastas', $exercise->calorias_gastas ?? '') }}" 
                       min="0" required>
                @error('calorias_gastas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" class="form-control @error('data') is-invalid @enderror" 
                       id="data" name="data" 
                       value="{{ old('data', isset($exercise) ? $exercise->data->toDateString() : '') }}" 
                       max="{{ date('Y-m-d') }}" 
                       required>
                @error('data')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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

    <script>
    // Validação em tempo real para o campo nome
    document.getElementById('nome').addEventListener('input', function(e) {
        // Remove números e caracteres especiais, mantém apenas letras, espaços, hífens e acentos
        this.value = this.value.replace(/[^A-Za-zÀ-ÿ\s\-]/g, '');
    });

    // Validação antes do envio do formulário
    document.querySelector('form').addEventListener('submit', function(e) {
        const nomeField = document.getElementById('nome');
        const nomeValue = nomeField.value.trim();
        
        // Verifica se contém números
        if (/\d/.test(nomeValue)) {
            e.preventDefault();
            alert('O nome da atividade não pode conter números. Use apenas letras.');
            nomeField.focus();
            return false;
        }
        
        // Verifica se contém caracteres especiais (exceto hífens)
        if (/[^A-Za-zÀ-ÿ\s\-]/.test(nomeValue)) {
            e.preventDefault();
            alert('Remova os caracteres especiais do nome da atividade.');
            nomeField.focus();
            return false;
        }
    });
    </script>
@endsection