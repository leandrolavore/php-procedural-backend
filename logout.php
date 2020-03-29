<?php
    session_start();

    //if(isset($_SESSION['id'])){
        $_SESSION = array();
        if(isset($_COOKIE[session_name()])){
            setcookie(session_name(), '', time() - 3600);
            setcookie('username','', time() - 3600);
        }
        session_destroy();
    //}
    $login_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php ';
    header('Location: ' . $login_url);
?>