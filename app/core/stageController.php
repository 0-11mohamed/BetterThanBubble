<?php
session_start();

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
}

require_once(ROOT_DIR . 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'config.php');

if (!isset($_SESSION['typecompte']) || $_SESSION['typecompte'] != 3) {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['success' => false, 'message' => 'Accès non autorisé']);
    exit();
}

$action = $_POST['action'] ?? '';

try {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($action === 'ajouter') {
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $datedebut = $_POST['datedebut'] ?? '';
        $datefin = $_POST['datefin'] ?? '';
        $teletravail = $_POST['teletravail'] ?? 0;
        $entreprise = $_POST['entreprise'] ?? '';
        $adresse = $_POST['adresse'] ?? '';
        $cp = $_POST['cp'] ?? '';
        $ville = $_POST['ville'] ?? '';
        $tuteur = $_POST['tuteur'] ?? '';
        $mailtuteur = $_POST['mailtuteur'] ?? '';
        $teltuteur = $_POST['teltuteur'] ?? '';
        $sujet = $_POST['sujet'] ?? '';
        $taches = $_POST['taches'] ?? '';

        $sql = "INSERT INTO ONL_LISTESTAGE (
            LIS_NOM, LIS_PRENOM, LIS_DATEDEBUT, LIS_DATEFIN,
            LIS_TELETRAVAIL, LIS_ENTREPRISE, 
            LIS_ADRESSE, LIS_CP, LIS_VILLE, LIS_TUTEUR, 
            LIS_MAILTUTEUR, LIS_TELTUTEUR, LIS_SUJET, LIS_TACHES
        ) VALUES (
            :nom, :prenom, :datedebut, :datefin, :teletravail, :entreprise, 
            :adresse, :cp, :ville, :tuteur, 
            :mailtuteur, :teltuteur, :sujet, :taches
        )";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':datedebut' => $datedebut,
            ':datefin' => $datefin,
            ':teletravail' => $teletravail,
            ':entreprise' => $entreprise,
            ':adresse' => $adresse,
            ':cp' => $cp,
            ':ville' => $ville,
            ':tuteur' => $tuteur,
            ':mailtuteur' => $mailtuteur,
            ':teltuteur' => $teltuteur,
            ':sujet' => $sujet,
            ':taches' => $taches
        ]);
        
        header('Location: /stages?success=ajout');
        exit();
        
    } elseif ($action === 'supprimer') {
        $id = $_POST['id'] ?? 0;
        
        if ($id > 0) {
            $sql = "DELETE FROM ONL_LISTESTAGE WHERE LIS_ID = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(['success' => true, 'message' => 'Stage supprimé avec succès']);
        } else {
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(['success' => false, 'message' => 'ID invalide']);
        }
        exit();
    }

} catch (Exception $e) {
    if ($action === 'supprimer') {
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    } else {
        header('Location: /stages?error=' . urlencode($e->getMessage()));
    }
    exit();
}
?>