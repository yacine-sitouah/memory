document.addEventListener('DOMContentLoaded', function() {
    const startButton = document.getElementById('start-game');
    const pairCountSelect = document.getElementById('pair-count');
    const gameBoard = document.getElementById('game-board');
    const leaderboardElement = document.getElementById('leaderboard');
    const scoreboard = document.getElementById('scoreboard');

    let cards = [];
    let flippedCards = [];
    let matchedCards = [];
    let moves = 0;

    startButton.addEventListener('click', function() {
        const pairCount = parseInt(pairCountSelect.value);
        startGame(pairCount);
    });

    function startGame(pairCount) {
        gameBoard.classList.remove('hidden');
        scoreboard.classList.add('hidden');
        gameBoard.innerHTML = '';
        moves = 0;
        matchedCards = [];
        cards = generateCards(pairCount);
        shuffle(cards);
        createGameBoard(cards);
    }

    function generateCards(pairCount) {
        const cardValues = [];
        for (let i = 1; i <= pairCount; i++) {
            cardValues.push(i);
            cardValues.push(i);
        }
        return cardValues;
    }

    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    function createGameBoard(cards) {
        gameBoard.style.gridTemplateColumns = `repeat(${Math.sqrt(cards.length)}, 1fr)`;
        cards.forEach((value, index) => {
            const card = document.createElement('div');
            card.classList.add('card');
            card.dataset.value = value;
            card.dataset.index = index;
            card.addEventListener('click', handleCardClick);
            gameBoard.appendChild(card);
        });
    }

    function handleCardClick(event) {
        const clickedCard = event.target;
        if (flippedCards.length < 2 && !clickedCard.classList.contains('flipped')) {
            flipCard(clickedCard);
            flippedCards.push(clickedCard);
            if (flippedCards.length === 2) {
                checkForMatch();
            }
        }
    }

    function flipCard(card) {
        card.classList.add('flipped');
        card.textContent = card.dataset.value;
    }

    function checkForMatch() {
        const [card1, card2] = flippedCards;
        if (card1.dataset.value === card2.dataset.value) {
            matchedCards.push(card1, card2);
            if (matchedCards.length === cards.length) {
                setTimeout(endGame, 1000);
            }
        } else {
            setTimeout(() => {
                card1.classList.remove('flipped');
                card1.textContent = '';
                card2.classList.remove('flipped');
                card2.textContent = '';
            }, 1000);
        }
        flippedCards = [];
    }

    function endGame() {
        alert(`Bravo ! Vous avez terminé en ${moves} coups.`);
        updateLeaderboard(moves);
        displayLeaderboard();
    }

    function updateLeaderboard(score) {
        let leaderboard = JSON.parse(localStorage.getItem('leaderboard')) || [];
        leaderboard.push(score);
        leaderboard.sort((a, b) => a - b);
        leaderboard = leaderboard.slice(0, 10);
        localStorage.setItem('leaderboard', JSON.stringify(leaderboard));
    }

    function displayLeaderboard() {
        leaderboardElement.innerHTML = '';
        const leaderboard = JSON.parse(localStorage.getItem('leaderboard')) || [];
        leaderboard.forEach(score => {
            const li = document.createElement('li');
            li.textContent = `Score: ${score} coups`;
            leaderboardElement.appendChild(li);
        });
        scoreboard.classList.remove('hidden');
    }
});
