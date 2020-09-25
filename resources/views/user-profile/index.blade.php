@extends('layouts.app')

@section('content')
    <h1>User profile</h1>
    <div>{{ Auth::user()->name }}</div>
@endsection
