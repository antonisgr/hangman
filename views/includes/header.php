<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hangman</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">
    <link rel="stylesheet" href="https://bootswatch.com/yeti/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">

    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="header clearfix">
            <nav>
                <ul class="nav nav-pills pull-right">
                    <li <?= ($_SERVER['PHP_SELF'] === '/index.php' && empty($_GET) ) ? 'class=active' : '' ?>><a href="/">Play</a></li>
                    <li <?= (isset($_GET['games'])) ? 'class=active' : '' ?>><a href="?games">Games</a></li>
                    <?php if(Auth::isLoggedin() && Auth::user()->isAdmin): ?>
                        <li <?= ($_SERVER['PHP_SELF'] === '/admin.php') ? 'class=active' : '' ?>><a href="/admin.php">Admin</a></li>
                    <?php endif; ?>
                    <?php if(Auth::isLoggedin()): ?>
                        <li>
                            <form action="/auth.php" method="post">
                                <input type="submit" name="logout" value="Logout" class="btn btn-link">
                            </form>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <h3 class="text-muted">Hangman</h3>
        </div>
        <div class="row marketing">
            <div class="col-sm-12">
