@extends('templates.main')
@section('title', 'Proyectos')
@section('buttons')
<x-header.link route="{{ route('projects.create') }}" link="Nuevo" />
@endsection
@section('component', 'projects')