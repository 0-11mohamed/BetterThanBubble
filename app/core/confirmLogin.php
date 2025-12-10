<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    try {
        $stmt = $db->prepare("SELECT * FROM ONL_COMPTE WHERE COM_EMAIL = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            exit();
        }
        
        if ($email === $user['COM_EMAIL'] && $password === $user['COM_MOT_DE_PASSE']) {
            $_SESSION['user_id'] = $user['COM_ID'];
            $_SESSION['email'] = $user['COM_EMAIL'];
            $_SESSION['prenom'] = $user['COM_PRENOM'];      
            $_SESSION['nom'] = $user['COM_NOM'];     
            header('Location: home');
            exit;
        } else {
        }

    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

} else {
}
