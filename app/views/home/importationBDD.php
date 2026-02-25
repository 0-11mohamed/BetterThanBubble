<?php

include_once(ROOT_DIR . 'app/core/config.php');

// Récupérer les données JSON envoyées par JavaScript
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !is_array($data)) {
    http_response_code(400);
    echo json_encode(['error' => 'Aucune donnée reçue']);
    exit;
}

$inserted = 0;
$errors = [];

// Préparer la requête DELETE pour vider la table
try {
    $stmtDelete = $db->prepare("DELETE FROM ONL_ENTREPRISE");
    $stmtDelete->execute();
} catch (PDOException $e) {
    $errors[] = "Erreur lors de la suppression des anciennes données: " . $e->getMessage();
}

// Préparer la requête d'insertion
$stmt = $db->prepare("INSERT INTO ONL_ENTREPRISE (SIREN, ENT_DATE_CREATION, ENT_ACTIVITE, ENT_CATEGORIE, ENT_ADRESSE, ENT_CODE_POSTAL, ENT_VILLE) VALUES (?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de préparation de la requête']);
    exit;
}

// Insérer chaque ligne de données
foreach ($data as $index => $row) {
    $siren = $row['siren'] ?? '';
    $ent_date_creation = isset($row['date_creation']) ?? '';
    $ent_activite = $row['activite_principale'] ?? '';
    $ent_categorie = $row['categorie_entreprise'] ?? '';
    $ent_adresse = $row['adresse'] ?? '';
    $ent_code_postal = $row['code_postal'] ?? '';
    $ent_ville = $row['ville'] ?? '';

    // Vérification des données requises (SIREN est obligatoire)
    if (empty($siren)) {
        $errors[] = "Ligne " . ($index + 1) . ": SIREN est obligatoire";
        continue;
    }

    try {
        $stmt->execute([
            $siren,
            $ent_date_creation,
            $ent_activite,
            $ent_categorie,
            $ent_adresse,
            $ent_code_postal,
            $ent_ville
        ]);
        $inserted++;
    } catch (PDOException $e) {
        $errors[] = "Ligne " . ($index + 1) . ": " . $e->getMessage();
    }
}


// Retourner le résultat
http_response_code(200);
echo json_encode([
    'success' => true,
    'inserted' => $inserted,
    'errors' => $errors,
    'message' => "$inserted entreprise(s) importée(s) avec succès"
]);

?>


