<?php
$pageTitle = 'Iniciar sesión';
$error = '';
$username = '';

require_once 'includes/db.php';
require_once 'includes/auth.php';

startSession();

if (isLoggedIn()) {
    header('Location: admin/dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Completa usuario y contraseña.';
    } else {
        $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = :username LIMIT 1');
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();

        $validPassword = $user && password_verify($password, $user['password']);
        $legacyPassword = $user && hash_equals(hash('sha256', $password), $user['password']);

        if ($validPassword || $legacyPassword) {
            if ($legacyPassword) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');
                $updateStmt->bindValue(':password', $newHash);
                $updateStmt->bindValue(':id', $user['id'], PDO::PARAM_INT);
                $updateStmt->execute();
            }

            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header('Location: admin/dashboard.php');
            exit;
        }

        $error = 'Usuario o contraseña incorrectos.';
    }
}

require_once 'includes/header.php';
?>

<main class="main-content page-shell">
    <section class="auth-section" aria-labelledby="login-title">
        <h1 id="login-title">Acceso administrativo</h1>

        <?php if ($error !== ''): ?>
            <p class="alert-error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form class="form-card" action="login.php" method="post">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?php echo htmlspecialchars($username); ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>

            <button class="btn btn-primary" type="submit">Entrar</button>
        </form>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
