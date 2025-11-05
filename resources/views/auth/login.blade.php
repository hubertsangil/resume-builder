<?php
require_once '../public/config.php';
session_start();
$errors = [
    'username' => [],
    'password' => []
];
$registered = isset($_GET['registered']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate inputs
    if ($username === '') {
        $errors['username'][] = 'Enter username.';
    }
    if ($password === '') {
        $errors['password'][] = 'Enter password.';
    }

    // If inputs are valid, check database
    if (empty($errors['username']) && empty($errors['password'])) {
        $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE username = :u');
        $stmt->execute([':u' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $errors['username'][] = 'Username not found.';
        } elseif (!password_verify($password, $user['password_hash'])) {
            $errors['password'][] = 'Incorrect password.';
        } else {
            // Successful login
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            header('Location: resume.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body class="login-page">
  <div class="card">
    <h2>Login</h2>
  
    <?php if ($registered): ?>
      <p class="success">Account created. Login below.</p>
    <?php endif; ?>

    <form class="login-form" method="post" action="login.php" autocomplete="off">
      <label class="form-field">
        <span>Username</span>
        <input name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
            <?php if (!empty($errors['username'])): ?>
              <p class="error"><?php echo implode('<br>', $errors['username']); ?></p>
            <?php endif; ?>
      </label>
      <label class="form-field">
        <span>Password</span>
        <input name="password" type="password" required>
        <?php if (!empty($errors['password'])): ?>
          <p class="error"><?php echo implode('<br>', $errors['password']); ?></p>
        <?php endif; ?>
      </label>
        <button type="submit">Login</button>
      </form>
       <div class="register-link">
         <a href="register.php">I don't have an account yet.</a>
        </div>
  </div>
</body>
</html>
