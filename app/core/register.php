<?php

$com_nom =isset($_POST['nom']) ? trim($_POST['nom']) : '';
$com_prenom =isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
$com_email  =isset($_POST['email']) ? trim($_POST['email']) : '';
$com_mdp    =isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($com_prenom) || empty($com_email) || empty($com_nom) || empty($com_mdp) ) {
    echo "<script>alert('Veuillez remplir tous les champs obligatoires.'); window.history.back();</script>";
    exit();
}

try{
    $stmtCheck = $db->prepare("SELECT COUNT(*) FROM ONL_COMPTE WHERE COM_EMAIL = :email");
    $stmtCheck->execute([':email' => $com_email]);
    if ($stmtCheck->fetchColumn() > 0) {
        echo "<script>alert('Cette adresse e-mail est déjà utilisée.'); window.history.back();</script>";
        exit();
    }


    $stmt = $db->prepare("INSERT INTO ONL_COMPTE (TYPE_COMPTE_ID, COM_NOM, COM_PRENOM, COM_MOT_DE_PASSE, COM_EMAIL) VALUES (1, :nom,:prenom, :password,:email)");
    $stmt->execute([
        ':nom' => $com_nom,
        ':prenom' => $com_prenom,
        ':email' => $com_email,
        ':password' => $com_mdp
    ]);

    $_SESSION['user_id'] = $db->lastInsertId();
    $_SESSION['nom'] = $com_nom;
    $_SESSION['prenom'] = $com_prenom;
    $_SESSION['email'] = $com_email;
   
    header('Location: home');
    exit;
}catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
}