<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login HRIS PRO</title>
    <link rel="stylesheet" href="../css/hris-login-style.css">
</head>

<link rel="stylesheet" href="css/base.css">
<link rel="stylesheet" href="css/sidebar.css">
<link rel="stylesheet" href="css/components.css">

<body>
    <div class="card hris-login-card">
        <div class="hris-login-logo">
            <h2>HRIS PRO</h2>
        </div>



        <form action="{{ route('login.post') }}" method="POST">

            {{-- untuk melindungi aplikasi dari serangan Cross-Site Request Forgery  --}}
            @csrf

            <div class="hris-login-form-group">
                <label for="hris-login-email">Email</label>
                <input type="text" id="hris-login-email" name="email" placeholder="Masukkan email Anda" required
                    value="{{ old('email') }}" class="@error('email') is-invalid @enderror">

            </div>
            <div class="hris-login-form-group">
                <label for="hris-login-password">Password</label>
                <input type="password" id="hris-login-password" name="password" placeholder="Masukkan password Anda"
                    required class="@error('password') is-invalid @enderror">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong style="color: var(--danger-color)">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary hris-login-btn" onclick="">Login</button>
        </form>

        <div class="hris-login-forgot-password">
            <a href="#">Lupa Password?</a>
        </div>
    </div>

    <!-- Link JS Files (Harus di akhir body) -->
    <script src="js/data.js"></script>
    <script src="js/core.js"></script>
    <script src="js/render.js"></script>

</body>

</html>
