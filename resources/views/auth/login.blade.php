<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Login - SIMS Web App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <style>
        .login-container {
            height: 100vh;
        }

        .left-section {
            width: 50%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
        }

        .login-form {
            padding: 2rem;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin-top: 1rem;
        }

        .right-section {
            width: 50%;
            height: 100vh;
            background: url('{{ asset('assets/images/Frame 98699.png') }}') no-repeat center center;
            background-size: cover;
        }

        .login-container .row {
            margin: 0;
            height: 100vh;
        }

        @media (max-width: 767px) {
            .left-section {
                width: 100%;
            }

            .right-section {
                display: none;
            }
        }

        .btn-red {
            background-color: red;
            border: none;
            color: white;
            border-radius: 0;
        }

        .btn-red:hover {
            background-color: #ff0000;
        }

        .login-form h2 {
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h2 i {
            margin-right: 15px;
        }

        .form-control {
            border-radius: 0;
            padding-left: 35px;
            position: relative;
            font-size: 0.9rem;
            z-index: 1;
            min-height: 50px;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .form-control.error {
            border-color: red;
        }

        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            z-index: 2;
        }

        .password-container {
            position: relative;
        }

        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.1rem;
            z-index: 2;
        }

        .form-control:focus {
            padding-left: 35px;
        }

        .form-group {
            position: relative;
        }

        .input-icon,
        .eye-icon {
            z-index: 2;
        }

        .form-control {
            z-index: 1;
        }

        .text-danger {
            font-size: 0.8rem;
            color: #dc3545;
            margin-top: 0.5rem;
            margin-left: 35px;
        }
    </style>

</head>

<body>
    <div class="container-fluid p-0">
        <div class="row login-container">
            <div class="left-section">
                <div class="login-form">
                    <h2 class="mb-4">
                        <i class="fas fa-bag-shopping"></i> SIMS Web App
                    </h2>
                    <h4 class="mb-4">
                        Masuk Atau Buat Akun Untuk Memulai
                    </h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3 text-start position-relative">
                            <i class="fas fa-at input-icon"></i>
                            <input type="email" class="form-control @error('email') error @enderror" id="email"
                                name="email" placeholder="Masukkan email" value="{{ old('email') }}"
                                style="font-size: 0.9rem;">
                        </div>
                        <div class="mb-3 text-start position-relative password-container">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control @error('password') error @enderror"
                                id="password" name="password" placeholder="Masukkan password"
                                style="font-size: 0.9rem;">
                            <i class="fas fa-eye eye-icon" id="toggle-password"></i>
                        </div>
                        <button type="submit" class="btn btn-red w-100">Login</button>
                    </form>
                </div>
            </div>

            <div class="right-section"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("toggle-password").addEventListener("click", function() {
            var passwordField = document.getElementById("password");
            var icon = this;

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    </script>
</body>

</html>
