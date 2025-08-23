@extends('layouts.app')

@section('title', 'Tech Lead Dashboard')

@section('content')
<h2>Welcome Tech Lead {{ auth()->user()->name }}</h2>
<p>You can manage tickets and comments here.</p>
@endsection
