<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Masuk - Kas Buku</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 4 + tema dashboard (SB Admin 2) sebagai dasar agar serasi -->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* ============================================================
           Kas Buku - Login (design baru dari 0, mengikuti palet dashboard)
           Palet: primary #4e73df, gradasi #224abe, bg lembut #f8f9fc
           ============================================================ */
        :root {
            --primary: #4e73df;
            --primary-dark: #224abe;
            --primary-darker: #1a3ba0;
            --ink: #5a5c69;
            --ink-soft: #858796;
            --border: #e3e6f0;
            --bg-soft: #f8f9fc;
            --radius: 12px;
        }

        html,
        body {
            height: 100%;
        }

        body.login-body {
            margin: 0;
            font-family: 'Nunito', sans-serif;
            background: var(--bg-soft);
        }

        /* ---------- Layout utama ---------- */
        .login-wrapper {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(180deg, #f8f9fc 0%, #eef1f7 100%);
        }

        /* ---------- Panel kiri (branding) ---------- */
        .login-brand {
            position: relative;
            flex: 0 0 52%;
            max-width: 52%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3.5rem;
            overflow: hidden;
            background: linear-gradient(150deg, #4e73df 0%, #224abe 60%, #1a3ba0 100%);
            color: #fff;
        }

        /* ornamen lingkaran dekoratif */
        .login-brand::before,
        .login-brand::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
        }

        .login-brand::before {
            width: 420px;
            height: 420px;
            top: -120px;
            right: -120px;
        }

        .login-brand::after {
            width: 300px;
            height: 300px;
            bottom: -110px;
            left: -90px;
        }

        .brand-content {
            position: relative;
            z-index: 1;
            max-width: 460px;
        }

        .brand-logo {
            width: 76px;
            height: 76px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            font-size: 1.9rem;
            margin-bottom: 1.4rem;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18);
        }

        .brand-title {
            font-size: 2.1rem;
            font-weight: 800;
            margin-bottom: 0.6rem;
        }

        .brand-sub {
            font-size: 1rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.88);
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .brand-features {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .brand-features li {
            font-size: 0.95rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.95);
            padding: 0.55rem 0;
            display: flex;
            align-items: center;
        }

        .brand-features li i {
            margin-right: 0.8rem;
            color: #a4f0c8;
            font-size: 1.05rem;
        }

        /* ---------- Panel kanan (form) ---------- */
        .login-form {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .form-inner {
            width: 100%;
            max-width: 430px;
        }

        .mobile-logo {
            display: none;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 1.2rem;
        }

        .mobile-logo i {
            font-size: 1.3rem;
        }

        .form-inner h2 {
            font-size: 1.7rem;
            font-weight: 800;
            color: #2d3247;
            margin-bottom: 0.35rem;
        }

        .form-sub {
            color: var(--ink-soft);
            font-size: 0.95rem;
            margin-bottom: 1.8rem;
        }

        /* alert error */
        .login-alert {
            border-radius: var(--radius);
            border-left: 4px solid #e74a3b;
            background: #fdf3f2;
            color: #a03a2f;
            padding: 0.85rem 1rem;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        /* ---------- Input ---------- */
        .field {
            position: relative;
            margin-bottom: 1.2rem;
        }

        .field > label {
            display: block;
            font-size: 0.82rem;
            font-weight: 700;
            color: #4b4f63;
            letter-spacing: 0.02em;
            margin-bottom: 0.45rem;
        }

        .field .input-wrap {
            position: relative;
        }

        .field .input-icon {
            position: absolute;
            left: 1.05rem;
            top: 50%;
            transform: translateY(-50%);
            color: #b1b6c9;
            font-size: 0.9rem;
            pointer-events: none;
            z-index: 2;
        }

        .field .form-control {
            height: 50px;
            padding: 0.6rem 1rem 0.6rem 2.8rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            background: #fff;
            font-size: 0.95rem;
            color: var(--ink);
            box-shadow: 0 2px 6px rgba(20, 40, 100, 0.03);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field .form-control::placeholder {
            color: #c1c5d2;
        }

        .field .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.14);
        }

        /* input password + tombol lihat */
        .field.password .field-control {
            padding-right: 3rem;
        }

        .field .input-wrap .password-toggle {
            position: absolute;
            right: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #b1b6c9;
            cursor: pointer;
            font-size: 1rem;
            padding: 0.25rem;
            z-index: 2;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* ---------- Tombol ---------- */
        .btn-login {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: var(--radius);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(78, 115, 223, 0.35);
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, var(--primary-darker) 0%, var(--primary-dark) 100%);
            box-shadow: 0 10px 22px rgba(78, 115, 223, 0.42);
            color: #fff;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* ---------- Footer ---------- */
        .form-footer {
            margin-top: 1.6rem;
            text-align: center;
            color: var(--ink-soft);
            font-size: 0.82rem;
        }

        .form-footer strong {
            color: var(--primary);
        }

        /* ---------- Responsif ---------- */
        @media (max-width: 991.98px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-brand {
                flex: 0 0 auto;
                max-width: 100%;
                padding: 3rem 2rem;
                min-height: 300px;
            }

            .brand-content {
                max-width: 520px;
                text-align: center;
            }

            .brand-logo {
                margin-left: auto;
                margin-right: auto;
            }

            .brand-features li {
                justify-content: center;
            }

            .login-form {
                padding: 2.4rem 1.5rem;
            }

            .mobile-logo {
                display: flex;
            }
        }
    </style>
</head>

<body class="login-body">

    <div class="login-wrapper">

        <!-- Panel Branding -->
        <section class="login-brand">
            <div class="brand-content">
                <div class="brand-logo">
                    <i class="fas fa-book-open"></i>
                </div>
                <h1 class="brand-title">Kas Buku</h1>
                <p class="brand-sub">
                    Kelola pemasukan dan pengeluaran kas secara mudah, cepat, dan terpusat
                    dalam satu aplikasi.
                </p>
                <ul class="brand-features">
                    <li><i class="fas fa-check-circle"></i> Catat pemasukan harian secara simpel</li>
                    <li><i class="fas fa-check-circle"></i> Pantau pengeluaran kapan saja</li>
                    <li><i class="fas fa-check-circle"></i> Data tersimpan rapi dan aman</li>
                </ul>
            </div>
        </section>

        <!-- Panel Form -->
        <section class="login-form">
            <div class="form-inner">
                <div class="mobile-logo">
                    <i class="fas fa-book-open"></i> Kas Buku
                </div>

                <h2>Selamat Datang!</h2>
                <p class="form-sub">Silakan masuk untuk mengelola kas buku Anda.</p>

                @if ($errors->any())
                    <div class="login-alert">
                        <strong><i class="fas fa-exclamation-circle mr-1"></i> Masuk gagal:</strong>
                        <span>
                            @foreach ($errors->all() as $error)
                                {{ $error }}@if (!$loop->last) , @endif
                            @endforeach
                        </span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="field">
                        <label for="username">Username</label>
                        <div class="input-wrap">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username') }}" placeholder="Masukkan username"
                                autocomplete="username" autofocus required>
                        </div>
                    </div>

                    <div class="field password">
                        <label for="password">Kata Sandi</label>
                        <div class="input-wrap">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control field-control" id="password" name="password"
                                placeholder="Masukkan kata sandi" autocomplete="current-password" required>
                            <button type="button" class="password-toggle" id="passwordToggle" aria-label="Tampilkan kata sandi">
                                <i class="fas fa-eye" id="passwordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                </form>

                <p class="form-footer">
                    &copy; 2026 <strong>Kas Buku</strong> &mdash; Manajemen Keuangan Sederhana
                </p>
            </div>
        </section>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#passwordToggle').on('click', function () {
                const input = $('#password');
                const icon = $('#passwordIcon');
                const isHidden = input.attr('type') === 'password';
                input.attr('type', isHidden ? 'text' : 'password');
                icon.toggleClass('fa-eye', isHidden);
                icon.toggleClass('fa-eye-slash', !isHidden);
            });
        });
    </script>

</body>

</html>