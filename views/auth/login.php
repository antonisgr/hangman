<?php if(isset($message)): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= $message ?>
    </div>
<?php endif; ?>

<div class="col-sm-6">
    <form action="/auth.php" method="post">
        <div class="form-group">
            <label for="username">Username: </label>
            <input type="text" class="form-control" name="username" id="username" autofocus>
        </div>
        <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <input type="submit" class="btn btn-default" name="login" value="Login">
        <a href="/auth.php?register">Or register</a>
    </form>
</div>
