// script.js
document.addEventListener('DOMContentLoaded', () => {
    const gameSelect = document.getElementById('gameName');
    const scoreHistoryTable = document.getElementById('scoreHistory').querySelector('tbody');

    // Fetch and populate game names
    fetch('fetch_games.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(game => {
                const option = document.createElement('option');
                option.value = game.id;
                option.textContent = game.name;
                gameSelect.appendChild(option);
            });
        });

    // Fetch and display score history
    fetch('fetch_scores.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(score => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${score.game_name}</td>
                    <td>${score.player_name}</td>
                    <td>${score.score}</td>
                    <td>${score.date}</td>
                `;
                scoreHistoryTable.appendChild(row);
            });
        });
});
