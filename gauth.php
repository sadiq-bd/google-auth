<?php
use Sadiq\GoogleAuth;
session_start();

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/GoogleAuth.php';

$gauth = new GoogleAuth();

$gauth->setClientId(OAUTH_CLIENT_ID);
$gauth->setClientSecret(OAUTH_CLIENT_SECRET);
$gauth->setRedirectUri(OAUTH_REDIRECT_URI);

if (!empty($_GET['logout'])) {
    session_unset();
    session_regenerate_id();
    header('Location: /index.php');
    exit;
}

if (!empty($_GET['code'])) {
    
    $token = $gauth->fetchAccessTokenWithAuthCode($_GET['code']);
    $gauth->setAccessToken($token);
    $user = $gauth->getUserInfo(true);

    if (!empty($user->name)) {

        $_SESSION['google_is_logged_in'] = 1;
        $_SESSION['google_user'] = $user;

        header('Location: /index.php');
        exit;
    } else {
        die('Something went wrong :(');
    }

} else {
    $gauth->redirectToAuthPage();
}

