@extends('templates.main')
@section('title', 'Proyecto #' . $project->id)
@section('buttons')
<x-header.link route="{{ route('projects.index') }}" />
@endsection
@section('content')
<x-card.main class="border-light">
    <x-card.header header="Datos generales" />
    <x-card.body class="my-5">
        <x-inline-text title="Título" :text="$project->title" />
        <x-inline-text title="Descripción" :text="$project->description" />
    </x-card.body>
</x-card.main>

<x-card.main class="border-light">
    <x-card.header header="Tickets" />
    <x-card.body>
        <div id="project-tickets"></div>
    </x-card.body>
</x-card.main>
@endsection