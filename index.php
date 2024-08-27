<?php 
include("./_game.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Memory Game</h1>
        <div id="game-settings">
            <label for="pair-count">Nombre de paires :</label>
            <select id="pair-count">
                <option value="3">3 paires</option>
                <option value="6" selected>6 paires</option>
                <option value="12">12 paires</option>
            </select>
            <button id="start-game">Commencer le jeu</button>
        </div>
        <div id="game-board" class="game-board hidden"></div>
        <div id="scoreboard" class="hidden">
            <h2>Classement</h2>
            <ol id="leaderboard"></ol>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
