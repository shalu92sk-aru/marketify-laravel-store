@extends('layouts.store')
@section('title','Store admin login')
@section('content')
<div class="admin-login-wrap"><form class="admin-login" method="POST" action="{{ route('admin.login.submit') }}">@csrf<span class="kicker">MARKETIFY STORE ADMIN</span><h1>Welcome back.</h1><p>Sign in to manage your store.</p><label>Email<input type="email" name="email" value="{{ old('email') }}" required autofocus></label><label>Password<input type="password" name="password" required></label>@error('email')<small class="error-text">{{ $message }}</small>@enderror<button class="dark-btn full-dark">Sign in →</button></form></div>
@endsection
