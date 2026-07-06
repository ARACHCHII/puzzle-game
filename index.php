<?php
session_start();
// Game එක start උනාද බලනවා
if(!isset($_SESSION['board'])){
    $board = range(1, 8);
    $board[] = 0; // 0 = හිස් කෑල්ල
    shuffle($board);
    $_SESSION['board'] = $board;
    $_SESSION['moves'] = 0;
}

// Move එකක් ආවද
if(isset($_GET['move'])){
    $board = $_SESSION['board'];
    $moveIndex = $_GET['move'];
    $emptyIndex = array_search(0, $board);
    
    // අයිනේ තියෙන කෑලි විතරක් move කරන්න පුළුවන්
    $validMoves = [$emptyIndex-1, $emptyIndex+1, $emptyIndex-3, $emptyIndex+3];
    if(in_array($moveIndex, $validMoves)){
        $board[$emptyIndex] = $board[$moveIndex];
        $board[$moveIndex] = 0;
        $_SESSION['board'] = $board;
        $_SESSION['moves']++;
    }
}

// Reset button
if(isset($_GET['reset'])){
    session_destroy();
    header("Location: index.php");
    exit;
}

$board = $_SESSION['board'];
$moves = $_SESSION['moves'];
$won = ($board == [1,2,3,4,5,6,7,8,0]);
?>


<!DOCTYPE html>
<html>
<head>
<title>ATHK - Puzzle</title>
<style>
    body { 
        font-family: Arial; 
        background: #1a1a2e; 
        color: white; 
        text-align: center; 
        padding-top: 50px;
    }
    .game-board {
        display: grid;
        grid-template-columns: repeat(3, 100px);
        grid-template-rows: repeat(3, 100px);
        gap: 5px;
        width: 310px;
        margin: 20px auto;
    }
    .tile {
        width: 100px;
        height: 100px;
        background: #16213e;
        border: 2px solid #0f3460;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: bold;
        color: #e94560;
        text-decoration: none;
        transition: 0.2s;
    }
    .tile:hover { background: #0f3460; transform: scale(1.05); }
    .empty { background: transparent; border: 2px dashed #0f3460; }
    .win { color: #4ade80; font-size: 24px; }
    button { 
        padding: 10px 20px; 
        background: #e94560; 
        color: white; 
        border: none; 
        border-radius: 5px; 
        cursor: pointer;
        font-size: 16px;
    }
</style>
</head>
<body>

<h1>🧩 Api Thamai Hodatama Kare</h1>

<?php if($won): ?>
    <h2 class="win">අඩෝ දිනුවා! 🎉</h2>
    <h3>Moves: <?php echo $moves; ?></h3>
<?php else: ?>
    <h3>Moves: <?php echo $moves; ?></h3>
<?php endif; ?>

<div class="game-board">
<?php 
for($i = 0; $i < 9; $i++):
    if($board[$i] == 0): ?>
        <div class="tile empty"></div>
    <?php else: ?>
        <a href="index.php?move=<?php echo $i; ?>" class="tile">
            <?php echo $board[$i]; ?>
        </a>
    <?php endif;
endfor; ?>
</div>

<a href="index.php?reset=1"><button>New Game</button></a>

<p style="margin-top: 20px;">Hint: හිස් තැනට අයිනේ තියෙන number එක click කරන්න</p>

</body>
</html>









<?php
// Start date එක - game පටන් ගත්ත දවස
$start_date = "2026-07-04"; 
$today = date("Y-m-d");

// දවස් කීයක් ගිහින්ද කියලා count කරනවා
$days = floor((strtotime($today) - strtotime($start_date)) / (60 * 60 * 24));

// Level එක = ගෙවුණු දවස් + 1
$current_level = $days + 1;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Puzzle ATHK - Level <?php echo $current_level; ?></title>
    <style>
        body { text-align: center; font-family: Arial; background: #1a1a1a; color: white; }
        .level-box { font-size: 50px; margin-top: 100px; color: #00ff88; }
    </style>
</head>
<body>
    <div class="level-box">
        LEVEL <?php echo $current_level; ?>
    </div>
    <p>අද: <?php echo $today; ?></p>
    <p>Game එක පටන් අරන් දවස් <?php echo $days; ?>යි</p>
    
    <?php if($current_level == 1): ?>
        <h2>Level 1: 3x3 Puzzle</h2>
    <?php elseif($current_level == 2): ?>
        <h2>Level 2: 4x4 Puzzle</h2>
    <?php else: ?>
        <h2>Level <?php echo $current_level; ?>: <?php echo $current_level+2; ?>x<?php echo $current_level+2; ?> Puzzle</h2>
    <?php endif; ?>
</body>
</html>