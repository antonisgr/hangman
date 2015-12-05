<?php if(isset($message)): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= $message ?>
    </div>
<?php endif; ?>

<div class="col-sm-7">
    <form action="/auth.php" method="post">
        <div class="form-group">
            <label for="name">Name* <span class="text-muted">(Only letters, up to 20): </span></label>
            <input type="text" class="form-control" name="name" id="name" autofocus>
        </div>
        <div class="form-group">
            <label for="username">Username* <span class="text-muted"> (Only numbers, english letters, or '_', up to 20): </span></label>
            <input type="text" class="form-control" name="username" id="username" autofocus>
        </div>
        <div class="form-group">
            <label for="password">Password* <span class="text-muted">(up to 20): </span></label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <input type="submit" class="btn btn-default" name="register" value="Register">
    </form>
</div>
