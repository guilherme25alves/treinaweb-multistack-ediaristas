@extends('app')

@section('titulo', 'Criar Diarista')

@section('conteudo')

          <h1>Criar Diarista</h1>

          <form 
               action="{{ route('diaristas.store') }}" 
               method="POST"
               enctype="multipart/form-data" 
           > <!-- com essa propriedade e valor do enctype o arquivo será enviado! -->
               @include('_form')
          </form>

@endsection
