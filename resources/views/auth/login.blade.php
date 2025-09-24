<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login — Aplikasi</title>

<!-- CDN: Bootstrap 5, Font Awesome, Google Fonts, jQuery -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
  body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial}
  .card{border-radius:12px}
  .input-group-text{background:#fff;border-right:0}
  .form-control{border-left:0}
  .brand{font-weight:700;letter-spacing:.3px}
</style>
</head>
<body class="bg-light">

<div class="container">
  <div class="row justify-content-center align-items-center vh-100">
    <div class="col-12 col-md-8 col-lg-5">
      <div class="text-center mb-4">
        <h3 class="brand"><i class="fa-solid fa-rocket me-2"></i>Baratala Auth</h3>
        <p class="text-muted small">Masuk untuk mengelola rencana kerja. Aman, cepat, dan manusiawi.</p>
      </div>

      <div class="card shadow-sm">
        <div class="card-body p-4">

          <!-- status / errors -->
          @if(session('status'))
            <div class="alert alert-success mb-3">{{ session('status') }}</div>
          @endif

          @if(session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger mb-3">
              <ul class="mb-0 small">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('login.attempt') }}" novalidate>
            @csrf

            <div class="mb-3">
              <label class="form-label">Email atau Username</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input autocomplete="username" required autofocus name="login" value="{{ old('login') }}"
                       class="form-control" placeholder="email@domain.com atau username">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Kata Sandi</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                <input id="password" autocomplete="current-password" required name="password" type="password"
                       class="form-control" placeholder="••••••••">
                <button type="button" class="btn btn-outline-secondary input-group-text" id="togglePwd" title="Tampilkan/Sembunyikan">
                  <i class="fa-regular fa-eye" id="eyeIcon"></i>
                </button>
              </div>
              <div class="form-text small">Minimal 6 karakter. Aktifkan 2FA di profil untuk keamanan ekstra.</div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label small" for="remember">Ingat saya</label>
              </div>
              <a href="#" class="small">Lupa kata sandi?</a>
            </div>

            <!-- rate-limit hint -->
            @if(session('throttle'))
              <div class="alert alert-warning small">Terlalu banyak percobaan. Coba lagi setelah {{ session('throttle') }} detik.</div>
            @endif

            <div class="d-grid mb-3">
              <button class="btn btn-primary" type="submit">
                <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk
              </button>
            </div>

            <div class="text-center small text-muted mb-3">atau masuk dengan</div>

            <div class="d-flex gap-2">
              <a href="#" class="btn btn-outline-dark w-100"><i class="fa-brands fa-google me-2"></i>Google</a>
              <a href="#" class="btn btn-outline-dark w-100"><i class="fa-brands fa-github me-2"></i>GitHub</a>
            </div>

          </form>
        </div>

        <div class="card-footer text-center small text-muted">
          Belum punya akun? <a href="#">Daftar</a>
        </div>
      </div>

      <p class="text-center small text-muted mt-3">Login aman. IP dan percobaan dibatasi.</p>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // toggle password
  $('#togglePwd').on('click', function(){
    const pwd = $('#password');
    const icon = $('#eyeIcon');
    if(pwd.attr('type') === 'password'){ pwd.attr('type','text'); icon.removeClass('fa-regular').addClass('fa-solid'); }
    else { pwd.attr('type','password'); icon.removeClass('fa-solid').addClass('fa-regular'); }
  });

  // optional: basic client-side validation (visual)
  $('form').on('submit', function(e){
    const login = $.trim($('[name=login]').val());
    const pwd = $.trim($('[name=password]').val());
    if(!login || !pwd){
      e.preventDefault();
      alert('Isi semua kolom login dan password.');
    }
  });
</script>
</body>
</html>
