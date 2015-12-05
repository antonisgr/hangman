<?php
/**
 * Administrator Controller
 */

require_once 'includes/common.inc.php';

// go away if not logged in
if (!Auth::isLoggedin()) {
    buildView('auth/login');
    exit;
}
// or not admin
if (!Auth::user()->isAdmin) {
    header('Location: /auth.php');
    exit;
}

// if 'Manage games' is clicked show all games
if (isset($_GET['games'])) {
    $games = $db->raw('
        SELECT games.id, username, word, start_datetime, score FROM games
        INNER JOIN users ON user_id=users.id
        INNER JOIN words ON word_id=words.id;
    ');
    buildView('admin/games', compact('games'));
    exit;
}

// if 'Delete' is clicked delete game
if (isset($_POST['deleteGame'])) {
    $db->delete('games', $_POST['gameId']);
    header('Location: /admin.php?games');
    exit;
}

// if 'Manage Words' is clicked show all words
if (isset($_GET['words'])){
    $words = $db->selectAll('words');
    buildView('admin/words', compact('words'));
    exit;
}

// if 'Delete' is clicked delete word
if (isset($_POST['deleteWord'])) {
    $db->delete('words', $_POST['wordId']);
    header('Location: /admin.php?words');
    exit;
}

// if 'Add' is clicked add new word
if (isset($_POST['addWord'])) {
    $word = $_POST['word'];
    if (Validator::isAlpha($word) && Validator::maxLength($word, 20)) {
        $db->insert('words', ['word' => mb_strtoupper($word)]);
        header('Location: /admin.php?words');
        exit;
    }
    else {
        $words = $db->selectAll('words');
        $message = 'Only letters and length < 20 please.';
        buildView('admin/words', compact('words', 'message'));
        exit;
    }
}

// if admin edits word, update it with AJAX
if (isset($_POST['name'])) {
    $newValue = $_POST['value'];

    if (Validator::isAlpha($newValue) && Validator::maxLength($newValue, 20)) {
        $db->update('words', ['word' =>  mb_strtoupper($newValue)], $_POST['pk']);
        http_response_code(200);
        exit;
    }
    else {
        http_response_code(400);
        header('Content-type: application/json');
        echo json_encode('Only letters and length < 20 please.');
        exit;
    }
}

buildView('admin/index');
