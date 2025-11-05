<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body class="register-page">
  <div class="card">
    <h2>Register</h2>

    <form class="register-form" method="post" action="{{ route('register.submit') }}" autocomplete="off">
      @csrf
      <label class="form-field">
        <span>Username</span>
        <input name="username" value="{{ old('username', '') }}" required>
        @foreach ($errors->get('username', []) as $err)
        <div class="error">{{ $err }}</div>
        @endforeach
      </label>
      <label class="form-field">
        <span>Password</span>
        <input name="password" type="password" required>
        @foreach ($errors->get('password', []) as $err)
        <div class="error">{{ $err }}</div>
        @endforeach
      </label>
      <button type="submit">Create account</button>
    </form>
    <div class="login-link">
      <p><a href="{{ route('login') }}">Already have an account? Login</a></p>
    </div>
  </div>
</body>
</html>
