@extends('layouts.tailwind')

@section('title', 'Dashboard')

@section('header')
<header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Dashboard</h1>
        <h2 class="text-2xl font-bold tracking-tight text-gray-800">Welcome {{ auth()->user()->name }}</h2>
    </div>
</header>
@endsection

@section('content')

@endsection
