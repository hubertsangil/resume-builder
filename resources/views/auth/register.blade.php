<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-page">
  <div class="auth-container">
    <div class="auth-box">
      <h2 class="auth-title">Register</h2>

      <form class="auth-form" method="post" action="{{ route('register.submit') }}" autocomplete="off">
        @csrf
        <div class="form-group-auth">
          <label class="form-label-auth">
            Username
            <input type="text" name="username" value="{{ old('username', '') }}" class="auth-input" required>
          </label>
          @foreach ($errors->get('username', []) as $err)
            <div class="error">{{ $err }}</div>
          @endforeach
        </div>

        <div class="form-group-auth">
          <label class="form-label-auth">
            Password
            <input type="password" name="password" class="auth-input" required>
          </label>
          @foreach ($errors->get('password', []) as $err)
            <div class="error">{{ $err }}</div>
          @endforeach
        </div>

        <button type="submit" class="auth-submit">Create account</button>
      </form>
  </div>
        <div class="auth-link mt-6 text-center">
      <p><a href="{{ route('login') }}">Already have an account? Login</a></p>
    </div>
</body>
</html>
