<!-- home.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Profile') }}</div>

                <div class="card-body">
                    <h4>Welcome, {{ $user->name }}</h4>
                    <p>Email: {{ $user->email }}</p>
                    <p>Avatar: <img src="{{ $user->avatar }}" alt="Avatar"></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection