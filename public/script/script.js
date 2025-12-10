
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

const activites = {
  'A': "Agriculture, sylviculture et pêche",
  'B': "Industries extractives",
  'C': "Industrie manufacturière",
  'D': "Production et distribution d'électricité, de gaz, de vapeur et d'air conditionné",
  'E': "Production et distribution d'eau ; assainissement, gestion des déchets et dépollution",
  'F': "Construction",
  'G': "Commerce ; réparation d'automobiles et de motocycles",
  'H': "Transports et entreposage",
  'I': "Hébergement et restauration",
  'J': "Information et communication",
  'K': "Activités financières et d'assurance",
  'L': "Activités immobilières",
  'M': "Activités spécialisées, scientifiques et techniques",
  'N': "Activités de services administratifs et de soutien",
  'O': "Administration publique",
  'P': "Enseignement",
  'Q': "Santé humaine et action sociale",
  'R': "Arts, spectacles et activités récréatives",
  'S': "Autres activités de services",
  'T': "Activités des ménages en tant qu'employeurs ; activités indifférenciées des ménages en tant que producteurs de biens et services pour usage propre",
  'U': "Activités extra-territoriales"
};

function convertActivityToCode(activityName) {
  const normalizedInput = activityName.toLowerCase().trim();
 
  for (const [code, fullName] of Object.entries(activites)) {
    if (fullName.toLowerCase().includes(normalizedInput) || normalizedInput.includes(fullName.toLowerCase())) {
      return code;
    }
  }
 
  return null;
}

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
      const activityCode = convertActivityToCode(elements.query.value.trim());
      if (activityCode) {
        url = 'https://recherche-entreprises.api.gouv.fr/search?age=1&per_page=10&section_activite_principale=' + activityCode;
      } else {
        url = 'https://recherche-entreprises.api.gouv.fr/search?age=1&per_page=10&section_activite_principale=' + elements.query.value.trim();
      }
      break;

    case 'nom':
      url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=10&q=' + elements.query.value.trim(); break;

    case 'region':
      url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=10&departement=' + elements.query.value.trim(); break;
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
