@extends('layouts.app')
@livewireStyles()

@section('content')
    <x-success></x-success>
    <x-errors></x-errors>
    @livewire('damage.index')
@endsection

@livewireScripts()
