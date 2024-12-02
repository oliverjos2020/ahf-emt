<?php
    

    setcookie('userRecord', '', time() - 3600, '/');
    setcookie('token', '', time() - 3600, '/');
    setcookie('cookieTimer', '', time() - 3600, '/');
    setcookie('regenerateToken', '', time() - 3600, '/');
    header('location:../index');
    // Check if the cookie is still set
    if (!isset($_COOKIE['userRecord'])) {
        // echo "Cookie 'userRecord' has been destroyed.";
        header('location:../index');
    }

    // session_destroy();
    // header('location:../index');
?>

