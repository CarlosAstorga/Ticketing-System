@extends('templates.main')
@section('title', $project->exists ? 'Editar proyecto' : 'Nuevo proyecto')
@section('buttons')
<x-header.link route="{{ route('projects.index') }}"></x-header.link>
<x-header.button />
@endsection
@section('content')
<x-card.main class="border-light">
    <x-card.header header="Datos generales" />
    <x-card.body class="my-md-3">
        <form id="form" method="POST" action="@if($project->exists) {{ route('projects.update', $project->id) }} @else {{ route('projects.store') }} @endif">
            @csrf
            @if($project->exists) @method('PUT') @endif
            <x-inline-input class="mb-3" label="Asunto" name="title" :value="$project->title" />
            <x-inline-input label="Descripción" name="description" :value="$project->description" type="textarea" />
        </form>
    </x-card.body>
</x-card.main>
@endsection