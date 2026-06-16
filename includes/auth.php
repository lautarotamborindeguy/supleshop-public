<?php
// Inicia a sessao apenas quando ela ainda nao foi iniciada.
function startSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Protege paginas privadas do painel administrativo.
function requireLogin(string $loginPath = '../login.php'): void
{
    startSession();

    if (empty($_SESSION['user_id'])) {
        header('Location: ' . $loginPath);
        exit;
    }
}

function isLoggedIn(): bool
{
    startSession();
    return !empty($_SESSION['user_id']);
}
