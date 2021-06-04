@extends('templates.main')
@section('title', 'Roles')
@section('buttons')
<x-header.link route="{{ route('roles.create') }}" link="Nuevo" />
@endsection
@section('component', 'roles')