@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-gray-900">{{ __('messages.welcome_title') }}</h1>
        <p class="mt-4 text-lg text-gray-600">{{ __('messages.welcome_subtitle') }}</p>
    </div>
@endsection
