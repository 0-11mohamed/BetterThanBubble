let url = 'url';

const elements = {
  filter: null,
  query: null,
  container: null,
  radios: null
};

const tailles = {
  GE: "Grande Entreprise",
  ETI: "Entreprise de Taille Intermédiaire",
  MPE: "Micro Petite Entreprise"
};

document.addEventListener('DOMContentLoaded', () => {
  elements.filter = document.getElementById('filter');
  elements.query = document.getElementById('query');
  elements.container = document.getElementById('result');
  elements.radios = document.querySelectorAll('input[name="taille"]');
  
  elements.query.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
      const checkedRadio = document.querySelector('input[name="taille"]:checked');
      const sizeValue = checkedRadio ? checkedRadio.value : null;
      const filterValue = elements.filter.value;
      const queryText = elements.query.value.trim();
      
      console.log("Taille:", sizeValue, "Filtre:", filterValue, "Recherche:", queryText);
      
      fetchEntreprise(filterValue, queryText, sizeValue);
    }
  });
});

function editURL() {
  const checkedRadio = document.querySelector('input[name="taille"]:checked');

  switch (elements.filter.value) {
    case 'activite':
      url = 'https://recherche-entreprises.api.gouv.fr/search?age=1&per_page=10&section_activite_principale=' + elements.query.value.trim(); break;

    case 'nom':
      url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=10&q=' + elements.query.value.trim(); break;

    case 'region':
      url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=10&region=' + elements.query.value.trim(); break;
    /*https://recherche-entreprises.api.gouv.fr/search?region=[region]&categorie_entreprise=[taille]&section_activite_principale=[activite]&page=[page]&per_page=[per_page]*/
    default:
      url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=10';

      if(checkedRadio != null){
      url += '&categorie_entreprise=' + checkedRadio.value;
      }
  }

  return url;
}

async function fetchEntreprise(filterValue, queryText) {
  const container = document.getElementById("result");
  const template = document.getElementById("entrepriseTemplate");

  Array.from(container.children).forEach(child => {
    if (child.tagName.toLowerCase() !== 'template') {
      child.remove();
    }
  });

  editURL();

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

