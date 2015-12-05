<table class="table table-striped">
    <tr>
        <th>Player</th>
        <th>Word</th>
        <th>Datetime</th>
        <th>Score</th>
        <th>Action</th>
    </tr>
    <?php  foreach($games as $game): ?>
        <tr>
            <td><?= $game->username ?></td>
            <td><?= $game->word ?></td>
            <td><?= $game->start_datetime ?></td>
            <td><?= $game->score ?></td>
            <td>
                <form action="/admin.php" method="post">
                    <input type="hidden" name="gameId" value="<?= $game->id ?>">
                    <button type="submit" name="deleteGame" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
