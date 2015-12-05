<?php
/**
 * Auth Controller
 */

require_once 'includes/common.inc.php';

use Validator as V;

// if 'Logout' is clicked
if (isset($_POST['logout'])) {
    Auth::logout();
    header('Location: /');
    exit;
}

// if 'Login' is clicked
if(isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $user = User::getUser($username, $db);

    // if username exists, check password
    if($user) {
        $auth = new Auth($db, $user);
        if ($auth->login($_POST['password'])) {
            if ($user->isAdmin) {
                header('Location: /admin.php');
                exit;
            }
            header('Location: /');
            exit;
        }
    }
}

// if 'Register' is clicked
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // validate input
    if (V::notEmpty($name) && V::isAlpha($name) && V::maxLength($name, 20) &&
        V::notEmpty($username) && V::isUsername($username) && V::maxLength($username, 20) &&
        V::notEmpty($password)  && V::maxLength($password, 20))
    {
        // if input ok register user and force login
        $user = new User($name, $username, $password);
        $auth = new Auth($db, $user);
        $password = $auth->register();
        /*echo '<pre>';
        var_dump($auth);
        echo '</pre>';exit;*/
        $auth->forceLogin($password);

        header('Location: /');
        exit;
    }
    else {
        $message = 'Correct your input and try again.';
        buildView('auth/register', compact('message'));
        exit;
    }
}

// if 'Or register' is clicked
if (isset($_GET['register'])) {
    buildView('auth/register');
    exit;
}

// nothing to see here if u r logged in
if (Auth::isLoggedin()) {
    header('Location: /');
    exit;
}

$message = 'Wrong username or password';
buildView('auth/login', compact('message'));
exit;
