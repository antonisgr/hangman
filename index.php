<?php
/**
 * Game Controller
 */

require_once 'includes/common.inc.php';

// check if user is logged in
if (!Auth::isLoggedin()) {
    buildView('auth/login');
    exit;
}

// if a game is not already running get a random word from db, and the logged in user
if(!isset($_SESSION['game'])) {
    $word =  Word::selectRandom($db);
    $player = Auth::user();
    $game = new Game($player, $word); // init game

    $_SESSION['game'] = serialize($game); // save to session
}
else {
    $game = unserialize($_SESSION['game']);
}

// if 'Games' is clicked, show all games saved in db
if(isset($_GET['games'])) {
    $games = $db->raw('
        SELECT games.id, username, word, start_datetime, score FROM games
        INNER JOIN users ON user_id=users.id
        INNER JOIN words ON word_id=words.id;
    ');
    buildView('user/games', compact('games'));
    exit;
}

// if 'Guess' is clicked, guess letter
if(isset($_POST['guess'])) {
    $letter = $_POST['letter'];
    if (Validator::notEmpty($letter) && Validator::isAlpha($letter) && Validator::maxLength($letter, 1)) {
        try {
            $game->guessLetter($letter);
            $_SESSION['game'] = serialize($game); //sync game obj with session
        }catch (Exception $e) {
            $message = $e->getMessage();
            buildView('user/index', compact('game', 'message'));
            exit;
        }

        header('Location: .');
        exit;
    }
    else {
        $message = 'Insert letter only!';
        buildView('user/index', compact('game', 'message'));
    }
}

// if 'Start New' is clicked, unset session to start new game without saving
if(isset($_POST['abort-and-new'])) {
    unset($_SESSION['game']);
    header('Location: .');
    exit;
}

// if 'New' is clicked when game is over, save it to db and unset game in session to start new
if (isset($_POST['start-new'])) {
    $db->insert('games', [
        'user_id' => $game->player->id,
        'word_id' => $game->word->id,
        'start_datetime' => date('Y-m-d h:i:s a', time()),
        'score' => $game->score
    ]);

    unset($_SESSION['game']);
    header('Location: .');
    exit;
}

buildView('user/index', compact('game'));
