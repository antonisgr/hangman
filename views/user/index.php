<div class="jumbotron"><h2><?php $game->drawWord() ?></h2></div>

<div class="panel panel-default">
    <div class="panel-heading">Hello, <?= $game->player->name ?>!</div>
    <div class="panel-body">
        <div class="col-sm-8 col-sm-offset-2 margin-bottom-40">
            <label for="life">Life: </label>
            <div class="progress">
                <div id="life" class="progress-bar progress-bar-success progress-bar-striped active" style="width: <?= $game->life ?>%">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <label for="letters-tried">Letters Tried: </label><br>
            <output id="letters-tried" class="well well-sm clearfix">&nbsp;
                <?php foreach ($game->triedLetters as $triedLetter) {
                    echo $triedLetter . ' ';
                } ?>
            </output><br>
        </div>
        <div class="col-sm-4">
            <label for="score">Score: </label><br>
            <output  id="score" class="well well-sm"><?= $game->score ?></output><br>
        </div>
        <div class="col-sm-4">
            <label for="wrong-tries">Wrong Tries: </label><br>
            <output id="wrong-tries" class="well well-sm"><?= $game->wrongTries ?></output><br>
        </div>

    </div>
    <div class="panel-footer clearfix">
        <div class="col-sm-12">
            <?php if(isset($message)): ?>
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <?php if($game->isWon()): ?>
                <div class="alert alert-success" role="alert">
                    Congratulations you have won! Do you want to start
                    <form action="/index.php" method="post" class="show-inline">
                        <input type="submit" name="start-new" value="New" class="btn btn-warning btn-sm">
                    </form>
                    game?
                </div>
            <?php elseif($game->isLost()): ?>
                <div class="alert alert-danger" role="alert">
                    Game Over. The word was: <strong><?= $game->word->word ?></strong>. Do you want to start
                    <form action="/index.php" method="post" class="show-inline">
                        <input type="submit" name="start-new" value="New" class="btn btn-success btn-sm">
                    </form>
                    game?
                </div>
            <?php else: ?>
                <form action="/index.php" method="post" accept-charset="utf-8" class="form-inline">
                    <div class="form-group">
                        <label for="letter">Give Letter:</label>
                        <input id="letter" name="letter" type="text" maxlength="1" size="1" class="form-control" autofocus>
                    </div>

                    <input type="submit" name="guess" value="Guess!" class="btn btn-default">
                    <input type="submit" name="abort-and-new" value="Start New" class="btn btn-success pull-right">
                </form>
            <?php endif ?>
        </div>
    </div>
</div>
