<h2>Reset Password</h2>

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <label>Password Baru:</label>
    <input type="password" name="password" required>
    <br>
    <label>Konfirmasi Password:</label>
    <input type="password" name="password_confirmation" required>
    <br>
    <button type="submit">Reset Password</button>
</form>

@error('password') <p style="color:red">{{ $message }}</p> @enderror
@if (session('status')) <p style="color:green">{{ session('status') }}</p> @endif
