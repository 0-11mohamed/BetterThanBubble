let url = 'url';

const tailles = {
  GE: "Grande Entreprise",
  ETI: "Entreprise de Taille Intermédiaire",
  MPE: "Micro Petite Entreprise"
};

document.addEventListener('DOMContentLoaded', () => {
    const filter = document.getElementById('filter');
    const query = document.getElementById('query');

    query.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
        const filterValue = filter.value;
        const queryText = query.value;

        fetchEntreprise(filterValue, queryText);
    }
    });
});

function editURL(filterValue, queryText) {
  switch (filterValue) {
    case 'activite':
      url = 'https://recherche-entreprises.api.gouv.fr/search?age=1&per_page=10&section_activite_principale=' + queryText.trim();  break;

    case 'taille':
      url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=10&categorie_entreprise=' + queryText.trim(); break;
      
    case 'region':
      url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=10&region=' + queryText.trim(); break;
    /*https://recherche-entreprises.api.gouv.fr/search?region=[region]&categorie_entreprise=[taille]&section_activite_principale=[activite]&page=[page]&per_page=[per_page]*/
    default:
      url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=10';
  }
}

async function fetchEntreprise(filterValue, queryText) {
  const container = document.getElementById("result");
  const template = document.getElementById("entrepriseTemplate");

  Array.from(container.children).forEach(child => {
    if (child.tagName.toLowerCase() !== 'template') {
      child.remove();
    }
  });

  editURL(filterValue, queryText);

  const response = await fetch(url);
  const jsonData = await response.json();

  const entrepriseList = jsonData.results || [];

  if (entrepriseList.length === 0) {
    const message = document.createElement('p');
    message.textContent = "Aucune entreprise trouvée.";
    message.style.fontWeight = 'bold';
    message.style.textAlign = 'center';
    message.style.marginTop = '2rem';
    container.appendChild(message);
    return;
  }

  entrepriseList.forEach(entreprise => {
    const clone = template.content.cloneNode(true);

    clone.getElementById("nom_complet").textContent = entreprise.nom_complet || "N/A";
    clone.getElementById("siren").textContent = entreprise.siren || "N/A";
    clone.getElementById("categorie_entreprise").textContent = tailles[entreprise.categorie_entreprise] || "N/A";
    clone.getElementById("activite_principale").textContent = entreprise.activite_principale || "N/A";
    clone.getElementById("date_creation").textContent = entreprise.date_creation || "N/A";

    container.appendChild(clone);
  });
}


