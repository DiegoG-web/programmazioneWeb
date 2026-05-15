$(document).ready(function () {
  const canvas = $("#gameCanvas")[0];
  const ctx = canvas.getContext("2d");

  const boxSize = 20;
  const rows = canvas.height / boxSize;
  const columns = canvas.width / boxSize;

  let snake;
  let food;
  let direction;
  let nextDirection;
  let score;
  let bestScore;
  let gameInterval;
  let gameRunning;
  let gamePaused;
  let speed;

  function initGame() {
    snake = [
      { x: 8, y: 10 },
      { x: 7, y: 10 },
      { x: 6, y: 10 }
    ];

    direction = "RIGHT";
    nextDirection = "RIGHT";

    score = 0;
    speed = 120;
    gameRunning = false;
    gamePaused = false;

    bestScore = Number(localStorage.getItem("snakeBestScore")) || 0;

    $("#score").text(score);
    $("#bestScore").text(bestScore);
    $("#pauseButton").text("Pause");

    createFood();
    drawGame();
  }

  function startGame() {
    if (gameRunning) {
      return;
    }

    gameRunning = true;
    gamePaused = false;

    clearInterval(gameInterval);
    gameInterval = setInterval(updateGame, speed);
  }

  function pauseGame() {
    if (!gameRunning) {
      return;
    }

    gamePaused = !gamePaused;

    if (gamePaused) {
      clearInterval(gameInterval);
      $("#pauseButton").text("Resume");
    } else {
      clearInterval(gameInterval);
      gameInterval = setInterval(updateGame, speed);
      $("#pauseButton").text("Pause");
    }
  }

  function restartGame() {
    clearInterval(gameInterval);
    initGame();
    startGame();
  }

  function updateGame() {
    direction = nextDirection;

    const head = {
      x: snake[0].x,
      y: snake[0].y
    };

    if (direction === "UP") {
      head.y -= 1;
    }

    if (direction === "DOWN") {
      head.y += 1;
    }

    if (direction === "LEFT") {
      head.x -= 1;
    }

    if (direction === "RIGHT") {
      head.x += 1;
    }

    if (isGameOver(head)) {
      endGame();
      return;
    }

    snake.unshift(head);

    if (head.x === food.x && head.y === food.y) {
      score += 10;

      $("#score").text(score);

      updateBestScore();
      createFood();
      increaseSpeed();
    } else {
      snake.pop();
    }

    drawGame();
  }

  function drawGame() {
    clearCanvas();
    drawBoard();
    drawFood();
    drawSnake();
  }

  function clearCanvas() {
    ctx.fillStyle = "#e5e7eb";
    ctx.fillRect(0, 0, canvas.width, canvas.height);
  }

  function drawBoard() {
    for (let y = 0; y < rows; y++) {
      for (let x = 0; x < columns; x++) {
        ctx.fillStyle = "#f9fafb";
        ctx.fillRect(
          x * boxSize,
          y * boxSize,
          boxSize,
          boxSize
        );

        ctx.strokeStyle = "#d1d5db";
        ctx.lineWidth = 1;
        ctx.strokeRect(
          x * boxSize,
          y * boxSize,
          boxSize,
          boxSize
        );
      }
    }
  }

  function drawSnake() {
    $.each(snake, function (index, part) {
      ctx.fillStyle = index === 0 ? "#16a34a" : "#22c55e";

      ctx.fillRect(
        part.x * boxSize,
        part.y * boxSize,
        boxSize,
        boxSize
      );

      ctx.strokeStyle = "#14532d";
      ctx.lineWidth = 2;

      ctx.strokeRect(
        part.x * boxSize,
        part.y * boxSize,
        boxSize,
        boxSize
      );

      ctx.lineWidth = 1;
    });
  }

  function drawFood() {
    ctx.fillStyle = "#ef4444";

    ctx.beginPath();

    ctx.arc(
      food.x * boxSize + boxSize / 2,
      food.y * boxSize + boxSize / 2,
      boxSize / 2.5,
      0,
      Math.PI * 2
    );

    ctx.fill();

    ctx.strokeStyle = "#991b1b";
    ctx.lineWidth = 2;
    ctx.stroke();

    ctx.lineWidth = 1;
  }

  function createFood() {
    let newFood;

    do {
      newFood = {
        x: Math.floor(Math.random() * columns),
        y: Math.floor(Math.random() * rows)
      };
    } while (isFoodOnSnake(newFood));

    food = newFood;
  }

  function isFoodOnSnake(newFood) {
    return snake.some(function (part) {
      return part.x === newFood.x && part.y === newFood.y;
    });
  }

  function isGameOver(head) {
    const hitWall =
      head.x < 0 ||
      head.x >= columns ||
      head.y < 0 ||
      head.y >= rows;

    const hitSnake = snake.some(function (part) {
      return part.x === head.x && part.y === head.y;
    });

    return hitWall || hitSnake;
  }

  function endGame() {
    clearInterval(gameInterval);

    gameRunning = false;
    gamePaused = false;

    drawGame();

    ctx.fillStyle = "rgba(0, 0, 0, 0.55)";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    ctx.fillStyle = "#ffffff";
    ctx.font = "32px Arial";
    ctx.textAlign = "center";
    ctx.fillText("Game Over", canvas.width / 2, canvas.height / 2 - 12);

    ctx.font = "18px Arial";
    ctx.fillText(
      "Click Restart to play again",
      canvas.width / 2,
      canvas.height / 2 + 24
    );
  }

  function updateBestScore() {
    if (score > bestScore) {
      bestScore = score;
      localStorage.setItem("snakeBestScore", bestScore);
      $("#bestScore").text(bestScore);
    }
  }

  function increaseSpeed() {
    if (speed <= 60) {
      return;
    }

    speed -= 3;

    clearInterval(gameInterval);
    gameInterval = setInterval(updateGame, speed);
  }

  $(document).on("keydown", function (event) {
    const key = event.key.toLowerCase();

    if (
      key === "arrowup" ||
      key === "arrowdown" ||
      key === "arrowleft" ||
      key === "arrowright" ||
      key === " "
    ) {
      event.preventDefault();
    }

    if ((key === "arrowup" || key === "w") && direction !== "DOWN") {
      nextDirection = "UP";
    }

    if ((key === "arrowdown" || key === "s") && direction !== "UP") {
      nextDirection = "DOWN";
    }

    if ((key === "arrowleft" || key === "a") && direction !== "RIGHT") {
      nextDirection = "LEFT";
    }

    if ((key === "arrowright" || key === "d") && direction !== "LEFT") {
      nextDirection = "RIGHT";
    }

    if (key === " ") {
      pauseGame();
    }
  });

  $("#startButton").on("click", function () {
    startGame();
  });

  $("#pauseButton").on("click", function () {
    pauseGame();
  });

  $("#restartButton").on("click", function () {
    restartGame();
  });

  initGame();
});