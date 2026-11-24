@extends('layouts.auth2')
@section('title', 'Confirm password')

@section('content')
<div class="au-head">
    <span class="au-ico"><i class="fas fa-shield-halved"></i></span>
    <h1>Confirm your password</h1>
    <p>This is a secure area. Please confirm your password before continuing.</p>
</div>

@if($errors->any())
    <div class="au-alert"><i class="fas fa-circle-exclamation"></i><span>{{ $errors->first() }}</span></div>
@endif

<form method="POST" action="{{ route('password.confirm') }}" data-busy>
    @csrf
    <div class="fld">
        <input type="password" name="password" id="password" placeholder=" " required autofocus autocomplete="current-password">
        <label for="password">Password</label>
        <i class="fas fa-lock lead"></i>
        <button type="button" class="eye" data-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
    </div>
    <button type="submit" class="au-btn"><span>Confirm</span> <i class="fas fa-check"></i></button>
</form>
@endsection