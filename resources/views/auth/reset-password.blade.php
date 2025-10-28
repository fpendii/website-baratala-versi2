<h2>Reset Password</h2>

{{-- ✅ Pesan sukses --}}
@if (session('status'))
    <div style="background-color:#d4edda; color:#155724; border:1px solid #c3e6cb; padding:10px; border-radius:5px; margin-bottom:10px;">
        {{ session('status') }}
    </div>
@endif

{{-- ✅ Pesan error umum --}}
@if ($errors->any())
    <div style="background-color:#f8d7da; color:#721c24; border:1px solid #f5c6cb; padding:10px; border-radius:5px; margin-bottom:10px;">
        <ul style="margin:0; padding-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
