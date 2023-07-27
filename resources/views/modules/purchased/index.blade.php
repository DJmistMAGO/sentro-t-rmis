@extends('layouts.app')
@livewireStyles()

@section('title')
    Purchased Product | Create
@endsection

@section('content')
    <x-success></x-success>
    <x-errors></x-errors>
    @livewire('purchased.index')
@endsection

@livewireScripts()
