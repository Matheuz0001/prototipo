@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Submeter Trabalho - {{ $event->title }}</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('works.store', $event) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Título do Trabalho *</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="abstract" class="form-label">Resumo *</label>
                            <textarea class="form-control" id="abstract" name="abstract" 
                                      rows="5" required>{{ old('abstract') }}</textarea>
                            <small class="text-muted">Mínimo 100 caracteres</small>
                        </div>

                        <div class="mb-3">
                            <label for="work_type_id" class="form-label">Tipo de Trabalho *</label>
                            <select class="form-control" id="work_type_id" name="work_type_id" required>
                                <option value="">Selecione o tipo</option>
                                @foreach(\App\Models\WorkType::all() as $workType)
                                    <option value="{{ $workType->id }}" 
                                        {{ old('work_type_id') == $workType->id ? 'selected' : '' }}>
                                        {{ $workType->type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="advisor" class="form-label">Orientador</label>
                            <input type="text" class="form-control" id="advisor" name="advisor" 
                                   value="{{ old('advisor') }}">
                        </div>

                        <div class="mb-3">
                            <label for="co_authors" class="form-label">Coautores</label>
                            <input type="text" class="form-control" id="co_authors" name="co_authors" 
                                   value="{{ old('co_authors') }}">
                            <small class="text-muted">Separe os nomes com vírgula</small>
                        </div>

                        <div class="mb-3">
                            <label for="work_file" class="form-label">Arquivo do Trabalho *</label>
                            <input type="file" class="form-control" id="work_file" name="work_file" 
                                   accept=".pdf,.doc,.docx" required>
                            <small class="text-muted">Formatos aceitos: PDF, DOC, DOCX (Máx: 10MB)</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Submeter Trabalho</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection