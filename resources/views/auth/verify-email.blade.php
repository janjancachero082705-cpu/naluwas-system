@extends('layouts.auth2')
@section('title', 'Verify email')

@section('content')
<div class="au-head">
    <span class="au-ico"><i class="fas fa-envelope-circle-check"></i></span>
    <h1>Verify your email</h1>
    <p>Thanks for signing up! Please click the link we just emailed to you. If you did not receive it, we will gladly send another.</p>
</div>

@if (session('status') == 'verification-link-sent')
    <div class="au-alert ok"><i class="fas fa-circle-check"></i><span>A new verification link has been sent to your email address.</span></div>
@endif

<form method="POST" action="{{ route('verification.send') }}" data-busy>
    @csrf
    <button type="submit" class="au-btn"><i class="fas fa-paper-plane"></i> <span>Resend verification email</span></button>
</form>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="au-link au-back" style="background:none;border:0;width:100%;cursor:pointer;font:inherit"><i class="fas fa-right-from-bracket"></i> Log out</button>
</form>
@endsection