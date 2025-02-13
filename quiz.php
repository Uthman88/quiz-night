<?php
session_start();
require_once 'Database.php';
require_once 'QuizManager.php';

$theme = $_GET['theme'];
$db = new Database();
$quizManager = new QuizManager($db);

$questions = $quizManager->getQuestions($theme);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score = 0;
    foreach ($questions as $question) {
        $userAnswer = $_POST['q' . $question['id']];
        if ($userAnswer == $question['bonne_reponse']) {
            $score++;
        }
    }
    $_SESSION['score'] = $score;
    $_SESSION['total'] = count($questions);
    header('Location: result.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz - <?php echo ucfirst($theme); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Quiz sur <?php echo ucfirst($theme); ?></h1>
    <form method="post">
        <?php foreach ($questions as $question): ?>
            <div class="question">
                <p><?php echo $question['question']; ?></p>
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <label>
                        <input type="radio" name="q<?php echo $question['id']; ?>" value="<?php echo $i; ?>">
                        <?php echo $question['reponse' . $i]; ?>
                    </label>
                <?php endfor; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit">Soumettre</button>
    </form>
</body>
</html>