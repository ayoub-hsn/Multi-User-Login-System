@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to Multi-User Login System!</h1>
        <p class="lead">Log in to your account or register a new one to get started.</p>
        <hr class="my-4">
        <a class="btn btn-primary btn-lg mr-2" href="{{ route('login') }}" role="button">Login</a>
        <a class="btn btn-success btn-lg" href="{{ route('register') }}" role="button">Register</a>
    </div>
@endsection
