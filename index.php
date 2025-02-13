<?php
session_start();
require_once 'Database.php';
require_once 'QuizManager.php';

$db = new Database();
$quizManager = new QuizManager($db);

$themes = $quizManager->getThemes();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Choisissez un thème</h1>
    <div class="themes">
        <?php foreach ($themes as $theme): ?>
            <a href="quiz.php?theme=<?php echo $theme; ?>" class="theme-btn"><?php echo ucfirst($theme); ?></a>
        <?php endforeach; ?>
    </div>
    <a href="log.php" class="admin-btn">Admin</a>
</body>
</html>