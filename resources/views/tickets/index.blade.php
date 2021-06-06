@extends('templates.main')
@section('title', 'Tickets')
@section('buttons')
<x-header.link route="{{ route('tickets.create') }}" link="Nuevo" />
@endsection
@section('component', 'tickets')