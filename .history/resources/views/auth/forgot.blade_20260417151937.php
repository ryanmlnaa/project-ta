@extends('layouts.app')
<form method="POST" action="{{ route('password.sendOtp') }}">
@csrf
<input type="email" name="email" placeholder="Masukkan Email" class="form-control">
<button class="btn btn-primary mt-2">Kirim OTP</button>
</form>
