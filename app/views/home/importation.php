<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<section id="importation">
    <h2>Importation CSV</h2>
    <div>
        <button id="importButton">Importer un fichier CSV</button>
        <input type="file" id="fileInput" accept=".csv" style="display:none;">
        <button id="sendToBDD">Envoyer dans la BDD</button>
    </div>
    
</section>
<script>


    document.addEventListener('DOMContentLoaded', () => {
        const importButton = document.getElementById('importButton');
        const fileInput = document.getElementById('fileInput');
        const sendToBDD = document.getElementById('sendToBDD');
        let selectedFile = null;

        // Ouvre le sélecteur de fichier
        importButton.addEventListener('click', () => {
            fileInput.click();
        });

        // Récupère le fichier sélectionné
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                selectedFile = e.target.files[0];
                alert(`Fichier sélectionné : ${selectedFile.name}`);
            }
        });

        // Envoie le CSV au serveur
        sendToBDD.addEventListener('click', () => {
            if (!selectedFile) {
                alert('Veuillez sélectionner un fichier CSV avant.');
                return;
            }

            const formData = new FormData();
            formData.append('csv_file', selectedFile);

            fetch('insertion', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
            })
            .catch(error => {
                console.error('Erreur :', error);
            });
        });
    });
</script>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
