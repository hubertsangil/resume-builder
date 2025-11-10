<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-box">
            <h2 class="auth-title">Login</h2>

            @if(!empty($registered))
                <p class="text-green-400 mb-4">Account created. Login below.</p>
            @endif

            <form method="post" action="{{ route('login.submit') }}" autocomplete="off" class="auth-form">
                @csrf
                <div class="form-group-auth">
                    <label class="form-label-auth">
                        <span>Username</span>
                        <input name="username" value="{{ old('username', '') }}" required class="form-input-auth">
                        @if($errors->has('username'))
                            <p class="error">{!! implode('<br>', $errors->get('username')) !!}</p>
                        @endif
                    </label>
                </div>
                <div class="form-group-auth">
                    <label class="form-label-auth">
                        <span>Password</span>
                        <input name="password" type="password" required class="form-input-auth">
                                                @if($errors->has('password'))
                            <p class="error">{!! implode('<br>', $errors->get('password')) !!}</p>
                        @endif
                    </label>
                </div>
                <div class="auth-submit-btn-wrapper">
                    <button type="submit" class="auth-submit-btn">
                        Login
                    </button>
                </div>
            </form>
</body>
</html>
                    </label>
                </div>
            </form>
            <div class="mt-6 text-center">
                <a href="{{ route('register') }}" class="text-resume-light hover:underline">
                    I don't have an account yet.
                </a>
            </div>
        </div>
    </div>
</body>
</html>
