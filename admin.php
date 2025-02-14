<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: log.php');
    exit;
}

require_once 'Database.php';
require_once 'Question.php';

$db = new Database();
$questionManager = new Question($db);

// Gestion des actions (ajout, modification, suppression)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action === 'add_theme') {
        // Ajout d'un nouveau thème
        $theme = $_POST['new_theme'];
        $theme = strtolower($theme); // Normaliser le nom du thème
        $sql = "CREATE TABLE $theme (
            id INT AUTO_INCREMENT PRIMARY KEY,
            question TEXT NOT NULL,
            reponse1 VARCHAR(255) NOT NULL,
            reponse2 VARCHAR(255) NOT NULL,
            reponse3 VARCHAR(255) NOT NULL,
            reponse4 VARCHAR(255) NOT NULL,
            bonne_reponse INT NOT NULL
        )";
        if ($db->getConnection()->query($sql)) {
            header('Location: admin.php'); // Recharger la page après l'ajout
            exit;
        } else {
            $error = "Erreur lors de la création du thème.";
        }
    } else {
        $theme = $_POST['theme'];
        $data = $_POST;

        switch ($action) {
            case 'add':
                $questionManager->addQuestion($theme, $data);
                break;
            case 'edit':
                $questionManager->editQuestion($theme, $data);
                break;
            case 'delete':
                $questionManager->deleteQuestion($theme, $data['id']);
                break;
        }
        header('Location: admin.php');  // Recharger la page après l'action
        exit;
    }
}

$themes = $questionManager->getThemes();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Admin Panel</h1>
    <a href="log.php" class="back-btn">Retour à la connexion</a>

    <!-- Formulaire pour ajouter un thème -->
    <h2>Ajouter un thème</h2>
    <form method="post">
        <input type="text" name="new_theme" placeholder="Nom du thème" required>
        <button type="submit" name="action" value="add_theme">Ajouter Thème</button>
    </form>

    <!-- Formulaire pour ajouter une question -->
    <h2>Ajouter une question</h2>
    <form method="post">
        <select name="theme">
            <?php foreach ($themes as $theme): ?>
                <option value="<?php echo $theme; ?>"><?php echo ucfirst($theme); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="question" placeholder="Question" required>
        <input type="text" name="reponse1" placeholder="Réponse 1" required>
        <input type="text" name="reponse2" placeholder="Réponse 2" required>
        <input type="text" name="reponse3" placeholder="Réponse 3" required>
        <input type="text" name="reponse4" placeholder="Réponse 4" required>
        <select name="bonne_reponse">
            <option value="1">Réponse 1</option>
            <option value="2">Réponse 2</option>
            <option value="3">Réponse 3</option>
            <option value="4">Réponse 4</option>
        </select>
        <button type="submit" name="action" value="add">Ajouter Question</button>
    </form>

    <!-- Tableau des questions existantes -->
    <h2>Questions existantes</h2>
    <table>
        <thead>
            <tr>
                <th>Thème</th>
                <th>Question</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($themes as $theme): ?>
                <?php
                $questions = $questionManager->getQuestions($theme);
                foreach ($questions as $question): ?>
                    <tr>
                        <td><?php echo ucfirst($theme); ?></td>
                        <td><?php echo $question['question']; ?></td>
                        <td>
                            <!-- Formulaire pour modifier une question -->
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="theme" value="<?php echo $theme; ?>">
                                <input type="hidden" name="id" value="<?php echo $question['id']; ?>">
                                <input type="text" name="question" value="<?php echo $question['question']; ?>" required>
                                <input type="text" name="reponse1" value="<?php echo $question['reponse1']; ?>" required>
                                <input type="text" name="reponse2" value="<?php echo $question['reponse2']; ?>" required>
                                <input type="text" name="reponse3" value="<?php echo $question['reponse3']; ?>" required>
                                <input type="text" name="reponse4" value="<?php echo $question['reponse4']; ?>" required>
                                <select name="bonne_reponse">
                                    <option value="1" <?php echo $question['bonne_reponse'] == 1 ? 'selected' : ''; ?>>Réponse 1</option>
                                    <option value="2" <?php echo $question['bonne_reponse'] == 2 ? 'selected' : ''; ?>>Réponse 2</option>
                                    <option value="3" <?php echo $question['bonne_reponse'] == 3 ? 'selected' : ''; ?>>Réponse 3</option>
                                    <option value="4" <?php echo $question['bonne_reponse'] == 4 ? 'selected' : ''; ?>>Réponse 4</option>
                                </select>
                                <button type="submit">Modifier</button>
                            </form>

                            <!-- Formulaire pour supprimer une question -->
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="theme" value="<?php echo $theme; ?>">
                                <input type="hidden" name="id" value="<?php echo $question['id']; ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>