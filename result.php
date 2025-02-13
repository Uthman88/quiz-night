<?php
session_start();
if (!isset($_SESSION['score'])) {
    header('Location: index.php');
    exit;
}

$score = $_SESSION['score'];
$total = $_SESSION['total'];
unset($_SESSION['score']);
unset($_SESSION['total']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Résultats</h1>
    <p>Vous avez répondu correctement à <?php echo $score; ?> questions sur <?php echo $total; ?>.</p>
    <a href="index.php" class="back-btn">Choisir un nouveau thème</a>
</body>
</html>