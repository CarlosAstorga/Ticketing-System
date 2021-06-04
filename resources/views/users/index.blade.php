@extends('templates.main')
@section('title', 'Usuarios')
@section('buttons')
<x-header.link route="{{ route('admin.users.create') }}" link="Nuevo" />
@endsection
@section('component', 'users')