<?php 

include_once __DIR__ . '/helper.php';
include_once __DIR__ . '/constant.php';
include_once __DIR__ . '/env.php';

$sessionLifetime = 1800;
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? null) == 443);

session_set_cookie_params([
	'lifetime' => $sessionLifetime,
	'path' => '/',
	'secure' => $isHttps,
	'httponly' => true,
	'samesite' => 'Lax',
]);

session_start();

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $sessionLifetime) {
	$_SESSION = [];
	if (ini_get('session.use_cookies')) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
	}
	session_destroy();
	session_start();
}

$_SESSION['last_activity'] = time();

if (session_id() !== '') {
	$params = session_get_cookie_params();
	setcookie(session_name(), session_id(), time() + $sessionLifetime, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}