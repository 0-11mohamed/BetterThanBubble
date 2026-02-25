<?php

function parseDate($value) {
    $value = trim($value);

    if ($value === '' || strtoupper($value) === 'NULL') {
        return null;
    }

    // Format FR jj/mm/yyyy
    if (preg_match('#^(\d{2})/(\d{2})/(\d{4})$#', $value, $m)) {
        return $m[3] . '-' . $m[2] . '-' . $m[1];
    }

    // Format déjà SQL yyyy-mm-dd
    if (preg_match('#^\d{4}-\d{2}-\d{2}$#', $value)) {
        return $value;
    }

    return null;
}


if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === 0) {
    $fileTmpPath = $_FILES['csv_file']['tmp_name'];

    try {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("
            INSERT INTO ONL_LISTESTAGE (
                LIS_NOM, LIS_PRENOM, LIS_DATEDEBUT, LIS_DATEFIN,
                LIS_TELETRAVAIL, LIS_ADRESSE, LIS_ENTREPRISE, LIS_CP, LIS_VILLE,
                LIS_TUTEUR, LIS_MAILTUTEUR, LIS_TELTUTEUR, LIS_SUJET, LIS_TACHES
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");


        $db->beginTransaction();

        if (($handle = fopen($fileTmpPath, "r")) !== FALSE) {
            $header = fgetcsv($handle, 1000, ";");
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                // S'assure qu'il y a bien 15 colonnes
                if (count($data) < 14) continue;
                echo "exec  !";
                $stmt->execute([
                    trim($data[0]), // LIS_NOM
                    trim($data[1]), // LIS_PRENOM
                    parseDate($data[2]), // LIS_DATEDEBUT
                    parseDate($data[3]), // LIS_DATEFIN
                    (int)$data[4],
                    trim($data[5]), // LIS_ADRESSE
                    trim($data[6]), // LIS_ENTREPRISE
                    trim($data[7]), // LIS_CP
                    trim($data[8]), // LIS_VILLE
                    trim($data[9]), // LIS_TUTEUR
                    trim($data[10]), // LIS_MAILTUTEUR
                    trim($data[11]), // LIS_TELTUTEUR
                    trim($data[12]), // LIS_SUJET
                    trim($data[13])  // LIS_TACHES
                ]);
            }
            fclose($handle);
        }

        $db->commit();
        echo "Importation réussie !";
    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        echo "Erreur lors de l'importation : " . $e->getMessage();
    }
} else {
    echo "Aucun fichier CSV reçu.";
}
