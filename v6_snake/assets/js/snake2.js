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

  function drawGame() {
    //clearBoard();
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
});