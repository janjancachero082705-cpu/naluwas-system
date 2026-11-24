@extends('layouts.auth2')
@section('title', 'Forgot password')

@section('content')
<div class="au-head">
    <span class="au-ico"><i class="fas fa-envelope-open-text"></i></span>
    <h1>Forgot password?</h1>
    <p>No problem. Enter your email and we will send you a link to choose a new one.</p>
</div>

@if(session('status'))
    <div class="au-alert ok"><i class="fas fa-circle-check"></i><span>{{ session('status') }}</span></div>
@endif
@if($errors->any())
    <div class="au-alert"><i class="fas fa-circle-exclamation"></i><span>{{ $errors->first() }}</span></div>
@endif

<form method="POST" action="{{ route('password.email') }}" data-busy>
    @csrf
    <div class="fld">
        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder=" " required autofocus autocomplete="username">
        <label for="email">Email</label>
        <i class="fas fa-envelope lead"></i>
    </div>
    <button type="submit" class="au-btn"><i class="fas fa-paper-plane"></i> <span>Email reset link</span></button>
    <a class="au-link au-back" href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Back to login</a>
</form>
@endsection