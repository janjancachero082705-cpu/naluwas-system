@extends('layouts.auth2')
@section('title', 'Reset password')

@section('content')
<div class="au-head">
    <span class="au-ico"><i class="fas fa-unlock-keyhole"></i></span>
    <h1>Reset password</h1>
    <p>If you have a manual reset link, enter your email and new password below.</p>
</div>

@if($errors->any())
    <div class="au-alert"><i class="fas fa-circle-exclamation"></i><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ route('manual.password.update') }}" data-busy>
    @csrf
    <div class="fld">
        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder=" " required autofocus autocomplete="username">
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
    <a class="au-link au-back" href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Back to login</a>
</form>
@endsection