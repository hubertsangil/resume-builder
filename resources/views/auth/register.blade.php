<?php
require_once '../public/config.php';
session_start();

$errors = [
    'username' => [],
    'password' => []
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Username validation
    if ($username === '') {
        $errors['username'][] = 'Enter a username.';
    } elseif (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $username)) {
        $errors['username'][] = 'Username must be 3–30 letters, numbers, or underscore.';
    }

    // Password validation
    if ($password === '') {
        $errors['password'][] = 'Enter a password.';
    } elseif (strlen($password) < 6) {
        $errors['password'][] = 'Password must be at least 6 characters.';
    }

    // Insert into database if no errors
    if (empty($errors['username']) && empty($errors['password'])) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (:u, :p)');
        try {
            $stmt->execute([':u' => $username, ':p' => $hash]);
            header('Location: login.php?registered=1');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23505') {
                $errors['username'][] = 'Username already taken.';
            } else {
                error_log('Registration error: ' . $e->getMessage());
                $errors['username'][] = 'Registration failed.';
            }
        }
    }
}

?>
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

    <form class="register-form" method="post" action="register.php" autocomplete="off">
      <label class="form-field">
        <span>Username</span>
        <input name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
        <?php foreach ($errors['username'] as $err): ?>
        <div class="error"><?php echo htmlspecialchars($err); ?></div>
    <?php endforeach; ?>
      </label>
      <label class="form-field">
        <span>Password</span>
        <input name="password" type="password" required>
        <?php foreach ($errors['password'] as $err): ?>
        <div class="error"><?php echo htmlspecialchars($err); ?></div>
    <?php endforeach; ?>
      </label>
      <button type="submit">Create account</button>
    </form>
    <div class="login-link">
      <p><a href="login.php">Already have an account? Login</a></p>
    </div>
  </div>
</body>
</html>
