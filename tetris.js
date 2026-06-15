const canvas = document.getElementById('tetris');
const context = canvas.getContext('2d');
const scale = 20;
context.scale(scale, scale);

let score = 0;
let board = Array.from({ length: 20 }, () => Array(10).fill(0));

const pieces = [
    [[1, 1, 1], [0, 1, 0]], // T
    [[1, 1], [1, 1]], // O
    [[1, 1, 0], [0, 1, 1]], // Z
    [[0, 1, 1], [1, 1, 0]], // S
    [[1, 1, 1, 1]], // I
];

let currentPiece;
let position = { x: 3, y: 0 };

function randomPiece() {
    const index = Math.floor(Math.random() * pieces.length);
    return pieces[index];
}

function draw() {
    context.clearRect(0, 0, canvas.width, canvas.height);
    board.forEach((row, y) => {
        row.forEach((value, x) => {
            if (value) {
                context.fillStyle = 'white';
                context.fillRect(x, y, 1, 1);
            }
        });
    });
    drawPiece();
}

function drawPiece() {
    currentPiece.forEach((row, y) => {
        row.forEach((value, x) => {
            if (value) {
                context.fillStyle = 'red';
                context.fillRect(position.x + x, position.y + y, 1, 1);
            }
        });
    });
}

function update() {
    position.y++;
    if (collision()) {
        position.y--;
        merge();
        clearLines();
        currentPiece = randomPiece();
        position = { x: 3, y: 0 };
        if (collision()) {
            alert("Game Over!");
            resetGame();
        }
    }
    draw();
    setTimeout(update, 1000);
}

function collision() {
    for (let y = 0; y < currentPiece.length; y++) {
        for (let x = 0; x < currentPiece[y].length; x++) {
            if (currentPiece[y][x] && (board[y + position.y] && board[y + position.y][x + position.x]) !== 0) {
                return true;
            }
        }
    }
    return false;
}

function merge() {
    currentPiece.forEach((row, y) => {
        row.forEach((value, x) => {
            if (value) {
                board[y + position.y][x + position.x] = value;
            }
        });
    });
}

function clearLines() {
    board = board.filter(row => row.some(value => value === 0));
    const linesCleared = 20 - board.length;
    score += linesCleared;
    document.getElementById('score').textContent = score;
    for (let i = 0; i < linesCleared; i++) {
        board.unshift(Array(10).fill(0));
    }
}

function resetGame() {
    board = Array.from({ length: 20 }, () => Array(10).fill(0));
    score = 0;
    document.getElementById('score').textContent = score;
    update();
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
        position.x--;
        if (collision()) position.x++;
    } else if (e.key === 'ArrowRight') {
        position.x++;
        if (collision()) position.x--;
    } else if (e.key === 'ArrowDown') {
        position.y++;
        if (collision()) position.y--;
    }
});

currentPiece = randomPiece();
update();
