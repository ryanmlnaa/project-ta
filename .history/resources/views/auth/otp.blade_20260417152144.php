@extends('lay')

<form method="POST" action="{{ route('password.verifyOtp') }}">
@csrf
<input type="text" name="otp" placeholder="Masukkan OTP" class="form-control">
<button class="btn btn-success mt-2">Verifikasi</button>
</form>
