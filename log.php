<?php
session_start();
require_once 'Database.php';  // Utilisation de require_once

$db = new Database('users_db');
$conn = $db->getConnection();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Connexion
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                header('Location: admin.php');
                exit;
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Aucun compte trouvé avec cet email.";
        }
    } elseif (isset($_POST['register'])) {
        // Inscription
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);

        if ($stmt->execute()) {
            $error = "Inscription réussie. Vous pouvez maintenant vous connecter.";
        } else {
            $error = "Erreur lors de l'inscription. L'email est peut-être déjà utilisé.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion / Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Connexion / Inscription</h1>
    <?php if (!empty($error)) echo "<p>$error</p>"; ?>

    <h2>Connexion</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="login">Se connecter</button>
    </form>

    <h2>Inscription</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="register">S'inscrire</button>
    </form>
</body>
</html>