<?php
session_start();
include_once 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    try {
        $stmt = $db->prepare("SELECT * FROM COMPTE WHERE COM_EMAIL = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Email introuvable.";
            exit();
        }
        
        if ($email === $user['COM_EMAIL'] && $password === $user['COM_MDP']) {
            $_SESSION['user_id'] = $user['COM_ID'];
            $_SESSION['email'] = $user['COM_EMAIL'];
            $_SESSION['prenom'] = $user['COM_PRENOM'];
            //echo "Connexion réussit";
            header('Location: ../../index.php');
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }

    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

} else {
    echo "Méthode de requête non autorisée.";
}
?>