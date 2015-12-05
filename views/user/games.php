<table class="table table-striped">
    <tr>
        <th>Player</th>
        <th>Word</th>
        <th>Datetime</th>
        <th>Score</th>
    </tr>
    <?php  foreach($games as $game): ?>
        <tr>
            <td><?= $game->username ?></td>
            <td><?= $game->word ?></td>
            <td><?= $game->start_datetime ?></td>
            <td><?= $game->score ?></td>
        </tr>
    <?php endforeach; ?>
</table>
