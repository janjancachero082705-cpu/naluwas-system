@extends('layouts.auth2')
@section('title', 'Reset password')

@section('content')
<div class="au-head">
    <span class="au-ico"><i class="fas fa-lock-open"></i></span>
    <h1>Set a new password</h1>
    <p>Choose a strong password for your account.</p>
</div>

@if($errors->any())
    <div class="au-alert"><i class="fas fa-circle-exclamation"></i><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ route('password.store') }}" data-busy>
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <div class="fld">
        <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}" placeholder=" " required autofocus autocomplete="username">
        <label for="email">Email</label>
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
    <button type="submit" class="au-btn"><span>Reset password</span> <i class="fas fa-check"></i></button>
</form>
@endsection