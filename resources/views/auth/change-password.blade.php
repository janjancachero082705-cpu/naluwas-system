@extends('layouts.auth2')
@section('title', 'Change password')

@section('content')
<div class="au-head">
    <span class="au-ico"><i class="fas fa-key"></i></span>
    <h1>Change password</h1>
    <p>Enter your email and choose a new password.</p>
</div>

@if(session('success'))
    <div class="au-alert ok"><i class="fas fa-circle-check"></i><span>{{ session('success') }}</span></div>
@endif
@if($errors->any())
    <div class="au-alert"><i class="fas fa-circle-exclamation"></i><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ route('password.update') }}" data-busy>
    @csrf
    <div class="fld">
        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder=" " required autofocus autocomplete="username">
        <label for="email">Email address</label>
        <i class="fas fa-envelope lead"></i>
    </div>
    <div class="fld">
        <input type="password" name="password" id="password" placeholder=" " required autocomplete="new-password">
        <label for="password">New password</label>
        <i class="fas fa-lock lead"></i>
        <button type="button" class="eye" data-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
    </div>
    <div class="fld">
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder=" " required autocomplete="new-password">
        <label for="password_confirmation">Confirm password</label>
        <i class="fas fa-lock lead"></i>
        <button type="button" class="eye" data-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
    </div>
    <button type="submit" class="au-btn"><i class="fas fa-rotate"></i> <span>Change password</span></button>
    <a class="au-link au-back" href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Back to login</a>
</form>
@endsection