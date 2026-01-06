<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | Monitoring App</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/corporate-ui-dashboard.css?v=1.0.0') }}">

    <style>
        body {
            /* Gradasi Latar Belakang yang lebih modern */
            background: linear-gradient(135deg, #1e1b4b 0%, #29b05fff 100%);
            font-family: 'Open Sans', sans-serif;
        }

        .login-card {
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .logo-img {
            height: 100px;
            width: auto;
            filter: drop-shadow(0px 8px 12px rgba(0, 0, 0, 0.15));
            transition: transform 0.3s ease;
        }

        .logo-img:hover {
            transform: scale(1.05);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #d2d6da;
        }

        .form-control:focus {
            border-color: #2e29b0;
            box-shadow: 0 0 0 2px rgba(46, 41, 176, 0.2);
        }

        .btn-login {
            background: linear-gradient(135deg, #29b051ff 0%, #1e1b4b 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
            color: #fff;
            filter: brightness(1.2);
        }

        .input-group-text {
            border-radius: 0 10px 10px 0 !important;
            cursor: pointer;
            background-color: white;
        }

        .alert {
            border-radius: 10px;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <main class="d-flex align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7">

                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" class="logo-img" alt="Logo Aplikasi">
                    </div>

                    <div class="card login-card p-2">
                        <div class="card-body p-4">
                            <h3 class="text-center fw-bold text-dark mb-2">Monitoring App</h3>
                            <p class="text-center text-muted mb-4">Silakan masuk untuk melanjutkan</p>

                            @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label small fw-bold">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label small fw-bold">Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                                        <span class="input-group-text" id="togglePassword">
                                            <i class="fa fa-eye text-muted"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label small" for="remember">Ingat Saya</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-login w-100">Sign In</button>
                            </form>
                        </div>
                    </div>

                    <div class="text-center mt-4 text-white-50">
                        <p class="small">&copy; {{ date('Y') }} Puskesmas Pekapuran Laut. <br> PKL Willy.</p>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script untuk Toggle Password Visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle Icon
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>