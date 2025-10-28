<h2>Lupa Password</h2>

@if (session('status'))
    <p style="color: green">{{ session('status') }}</p>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <label>Email:</label>
    <input type="email" name="email" required>
    @error('email') <p style="color:red">{{ $message }}</p> @enderror
    <button type="submit">Kirim Link Reset</button>
</form>
