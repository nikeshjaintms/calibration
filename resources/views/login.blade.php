<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .main-container {
            display: flex;
            height: 100vh;
        }

        /* LEFT SIDE */
        .left-side {
            width: 50%;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .left-side img {
            width: 250px;
            margin-bottom: 15px;
        }

        .left-side h2 {
            font-size: 32px;
            color: #111;
            font-weight: 600;
        }

        .left-side p {
            color: #666;
            font-size: 15px;
        }

        /* RIGHT SIDE */
        .right-side {
            width: 50%;
            background: linear-gradient(135deg, #0047ff, #005eff);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .login-box {
            width: 360px;
            padding: 40px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .login-box h3 {
            color: #fff;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
            height: 45px;
        }

        .form-control::placeholder {
            color: #e5e5e5;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
            box-shadow: none;
            border: 1px solid #fff;
        }

        .btn-login {
            width: 100%;
            background: #00c6ff;
            border: none;
            height: 45px;
            color: #fff;
            font-weight: 600;
            border-radius: 6px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #00aee6;
        }

        /* ERROR MESSAGE */
        label.error {
            color: #ffb3b3;
            font-size: 13px;
            margin-top: 5px;
            display: block;
            text-align: left;
        }

        .form-control.is-invalid {
            border: 1px solid #ff4d4d;
        }

        @media(max-width: 768px) {
            .left-side {
                display: none;
            }

            .right-side {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="main-container">

        <!-- LEFT -->
        <div class="left-side">
            <!-- Replace with your logo -->
            <img src="{{ asset('logo/image.png') }}" alt="Logo">

            <h2>Welcome to AUTOMAC</h2>
            <p>Excellence in Technology Solutions</p>
        </div>

        <!-- RIGHT -->
        <div class="right-side">

            <div class="login-box">

                <h3>Admin Login</h3>

                <form method="POST" action="{{ route('login.submit') }}" id="loginform">
                    @csrf
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                     @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <input type="email"
                            class="form-control"
                            placeholder="Email"
                            id="email"
                            name="email">
                    </div>

                    <div class="mb-3">
                        <input type="password"
                            class="form-control"
                            placeholder="Password"
                            id="password"
                            name="password">
                    </div>

                    <button type="submit" class="btn-login">
                        Login
                    </button>

                </form>

            </div>

        </div>

    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#loginform').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },

                messages: {
                    email: {
                        required: "Please enter your email",
                        email: "Enter a valid email address"
                    },

                    password: {
                        required: "Please enter your password",
                        minlength: "Password must be at least 6 characters"
                    }
                },

                errorElement: 'label',

                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },

                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });

        });
    </script>

</body>

</html>
