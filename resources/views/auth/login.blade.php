<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>
<body class="login-page">
  <div class="card">
    <h2>Login</h2>

    @if(!empty($registered))
      <p class="success">Account created. Login below.</p>
    @endif

    <form class="login-form" method="post" action="{{ route('login.submit') }}" autocomplete="off">
      @csrf
      <label class="form-field">
        <span>Username</span>
        <input name="username" value="{{ old('username', '') }}" required>
        @if($errors->has('username'))
          <p class="error">{!! implode('<br>', $errors->get('username')) !!}</p>
        @endif
      </label>
      <label class="form-field">
        <span>Password</span>
        <input name="password" type="password" required>
        @if($errors->has('password'))
          <p class="error">{!! implode('<br>', $errors->get('password')) !!}</p>
        @endif
      </label>
        <button type="submit">Login</button>
      </form>
       <div class="register-link">
         <a href="{{ route('register') }}">I don't have an account yet.</a>
        </div>
  </div>
</body>
</html>
