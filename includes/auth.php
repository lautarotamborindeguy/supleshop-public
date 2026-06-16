<?php
// Inicia la sesión solo cuando todavía no fue iniciada.
function startSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Protege páginas privadas del panel administrativo.
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
