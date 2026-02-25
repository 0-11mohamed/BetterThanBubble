<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    try {
        $stmt = $db->prepare("SELECT * FROM ONL_COMPTE WHERE COM_EMAIL = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION['error_message'] = "Mot de passe ou adresse mail incorrect.";
            header('Location: login');
            exit();
        }
        
        if ($email === $user['COM_EMAIL'] && password_verify($password, $user['COM_MOT_DE_PASSE'])) {
            $_SESSION['user_id'] = $user['COM_ID'];
            $_SESSION['email'] = $user['COM_EMAIL'];
            $_SESSION['prenom'] = $user['COM_PRENOM'];      
            $_SESSION['nom'] = $user['COM_NOM'];     
            $_SESSION['typecompte'] = $user['TYPE_COMPTE_ID'];
            header('Location: home');
            exit;
        } else {
            $_SESSION['error_message'] = "Mot de passe ou adresse mail incorrect.";
            header('Location: login');
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur de connexion : " . $e->getMessage();
        header('Location: login');
        exit();
    }

} else {
    $_SESSION['error_message'] = "Méthode de requête non autorisée.";
    header('Location: login');
    exit();
}
?>
