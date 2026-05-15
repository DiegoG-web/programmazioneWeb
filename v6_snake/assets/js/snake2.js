$(document).ready(function () {
  console.log("Document loaded");

  const rows = 20;
  const cols = 20;
  const totalsCells = rows*cols;

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

  createBoard();
  initGame();

  function createBoard(){
    const gameBoard = $("#gameBoard");
    gameBoard.empty();

    for(let i=0; i< totalsCells; i++){
      const cell = $('<div></div>');
      cell.addClass('cell');
      cell.attr('data-index', i);
      gameBoard.append(cell);
    }
    $(".game-wrapper").append('<div id="gameMessage" class="game-message"></div>');
  }
  function initGame() {
    snake = [
      {x:8, y:10}, 
      {x:7, y:10},
      {x:7, y:9}
    ]

    direction = 'RIGHT';
    nextDirection = 'RIGHT';

    score = 0;
    speed = 120;
    gameRunning = false;
    gamePaused = false;
     
    bestScore = Number(localStorage.getItem('snakeBestScore')) || 0;
    $('#score').text(score);
    $('#bestScore').text(bestScore);
    $('#pauseButton').text('Pause');
    $('#gameMessage').text('');

    createFood();
    drawGame();
  }
  function createFood() {
    let newFood;
    do {
      newFood = {
        x: Math.floor(Math.random() * cols),
        y: Math.floor(Math.random() * rows),
      };
    } while(isFoodOnSnake(newFood));
    food = newFood;
  }
  function clearBoard() {
    $('.cell').removeClass('snake')
    .removeClass('snake-head')
    .removeClass('food')
    .removeClass('game-over-cell');
  }
  function drawGame() {
    clearBoard();
    drawSnake();
    drawFood();
  }
  function isFoodOnSnake(newFood){
    return snake.some(p => p.x === newFood.x && p.y === newFood.y);
  }
  function getCellIndex(x, y) {
      return y * cols + x;
  }
  function getCell(index){
    return $('.cell[data-index="'+index+'"]');
    // return $(`.cell[data-index="${index}"]`);
  }
  function drawSnake() {
    $.each(snake, function(index, part){
      const currenSIndex = getCellIndex(part.x, part.y);
      const currentSCell = getCell(currenSIndex);
      currentSCell.addClass(index===0?'snake-head':'snake'); 
    })
  }
  function drawFood(){
    const foodIndex = getCellIndex(food.x, food.y);
    const foodCell = getCell(foodIndex);
    foodCell.addClass('food');
  }
  function startGame() {
    if(gameRunning) return;
    gameRunning = true;
    gamePaused = false;
    clearInterval(gameInterval);
    gameInterval = setInterval(updateGame, speed);
  }
  function pauseGame() {
    if(!gameRunning) return;
    gamePaused = !gamePaused;
    if(gamePaused){
      clearInterval(gameInterval);
      $('#pauseButton').text('Resume');
      $('#gameMessage').text('Game Paused, Press Resume to continue.');
    }else{
      clearInterval(gameInterval);
      gameInterval = setInterval(updateGame, speed);
      $('#pauseButton').text('Pause');
      $('#gameMessage').text('');
    }
  }
  function restartGame() {
    clearInterval(gameInterval);
    initGame();
    startGame();
  }
  function endGame() {
    clearInterval(gameInterval);
    gameRunning = false;
    gamePaused = false;
    $('.cell').addClass('game-over-cell');
    drawSnake();
    drawFood();
    $('#pauseButton').text('Pause');
    $('#gameMessage').text('Game Over! Press Restart to play again.');
  }
  function isGameOver(head){
    const hitWall = head.x < 0 || head.x >= cols || head.y < 0 || head.y >= rows;
    const hitSelf = snake.some(p => p.x === head.x && p.y === head.y);
    return hitWall || hitSelf;
  }
  function updateBestScore() {
    if(score > bestScore){
      bestScore = score;
      localStorage.setItem('snakeBestScore', bestScore);
      $('#bestScore').text(bestScore);
    }
  }
  function increaseSpeed() {
    if(speed <= 60) return;
    speed -= 3;
    clearInterval(gameInterval);
    gameInterval = setInterval(updateGame, speed);
  }
  function updateGame() {
    direction = nextDirection;
    const head = {x: snake[0].x, y: snake[0].y};
    if (direction === 'UP') head.y-=1;
    if (direction === 'DOWN') head.y+=1;
    if (direction === 'LEFT') head.x-=1;
    if (direction === 'RIGHT') head.x+=1;

    if(isGameOver(head)){
      endGame();
      return;
    }
    snake.unshift(head);
    if(head.x === food.x && head.y === food.y){
      score += 10;
      $('#score').text(score);
      updateBestScore();
      createFood();
      increaseSpeed();
    }else{
      snake.pop();
    }
    drawGame();
  }
  $('#startButton').click(startGame);
  $('#pauseButton').click(pauseGame);
  $('#restartButton').click(restartGame);

  $(document).keydown(function(e){
    if(e.key === 'w'|| e.key === 'ArrowUp' && direction !== 'DOWN') nextDirection = 'UP';
    if(e.key === 's' || e.key === 'ArrowDown' && direction !== 'UP') nextDirection = 'DOWN';
    if(e.key === 'a' || e.key === 'ArrowLeft' && direction !== 'RIGHT') nextDirection = 'LEFT';
    if(e.key === 'd' || e.key === 'ArrowRight' && direction !== 'LEFT') nextDirection = 'RIGHT';
    if(e.key === ' ' && gameRunning) pauseGame();
    if(e.key === ' ' && !gameRunning) restartGame();
  });
});

