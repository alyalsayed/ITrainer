@extends('layouts.master')

@section('title', 'To-Do List')

@section('content')
<div class="container mx-auto mt-8">
@livewire('todo-list')
</div>
@endsection
