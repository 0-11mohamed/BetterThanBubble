let url = 'url';
let allEntreprises = []; // Stocke toutes les entreprises récupérées
let displayedCount = 0; // Nombre d'entreprises actuellement affichées
const ITEMS_PER_PAGE = 9; // Nombre d'entreprises à afficher par batch

const elements = {
  filter: null,
  query: null,
  container: null,
  radios: null
};

const tailles = {
  GE: "Grande Entreprise",
  ETI: "Entreprise de Taille Intermédiaire",
  PME: "Micro Petite Entreprise"
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
  
  // Initialiser l'emoji du bouton thème
  updateThemeButton();
  
  if (elements.query) {
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
  }
});

function editURL() {
  const checkedRadio = document.querySelector('input[name="taille"]:checked');

  switch (elements.filter.value) {
    case 'activite':
      const activityCode = convertActivityToCode(elements.query.value.trim());
      if (activityCode) {
        url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=25&section_activite_principale=' + activityCode;
      } else {
        url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=25&section_activite_principale=' + elements.query.value.trim();
      }
      break;

    case 'nom':
      url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=25&q=' + elements.query.value.trim(); 
      break;

    case 'departement':
      url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=25&departement=' + elements.query.value.trim(); 
      break;
      
    default:
      url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=25';
  }
  
  if(checkedRadio != null){
    url += '&categorie_entreprise=' + checkedRadio.value;
  }

  console.log(url);
  return url;
}

async function fetchEntreprise(filterValue, queryText) {
  const container = document.getElementById("result");
  
  // Réinitialiser les variables de pagination
  allEntreprises = [];
  displayedCount = 0;
  
  // Nettoyer le conteneur (garder seulement le template)
  Array.from(container.children).forEach(child => {
    if (child.tagName.toLowerCase() !== 'template') {
      child.remove();
    }
  });
  
  // Supprimer le bouton "Afficher plus" s'il existe
  const existingButton = document.getElementById('loadMoreBtn');
  if (existingButton) {
    existingButton.remove();
  }
  
  editURL();
  
  try {
    const response = await fetch(url);
    const jsonData = await response.json();
    allEntreprises = jsonData.results || [];
    
    if (allEntreprises.length === 0) {
      const message = document.createElement('p');
      message.textContent = "Aucune entreprise trouvée.";
      message.style.fontWeight = 'bold';
      message.style.textAlign = 'center';
      message.style.marginTop = '2rem';
      container.appendChild(message);
      return;
    }
    
    console.log(`Total d'entreprises trouvées : ${allEntreprises.length}`);
    
    // Afficher les 9 premières entreprises
    displayNextBatch();
    
  } catch (error) {
    console.error("Erreur lors de la récupération des données:", error);
    const message = document.createElement('p');
    message.textContent = "Erreur lors de la recherche.";
    message.style.fontWeight = 'bold';
    message.style.textAlign = 'center';
    message.style.marginTop = '2rem';
    message.style.color = 'red';
    container.appendChild(message);
  }
}

function displayNextBatch() {
  const container = document.getElementById("result");
  const template = document.getElementById("entrepriseTemplate");
  
  // Calculer le nombre d'entreprises à afficher
  const endIndex = Math.min(displayedCount + ITEMS_PER_PAGE, allEntreprises.length);
  
  // Afficher le lot suivant (9 entreprises max)
  for (let i = displayedCount; i < endIndex; i++) {
    const entreprise = allEntreprises[i];
    const clone = template.content.cloneNode(true);
    
    clone.getElementById("nom_complet").textContent = entreprise.nom_complet || "N/A";
    clone.getElementById("siren").textContent = entreprise.siren || "N/A";
    clone.getElementById("categorie_entreprise").textContent = tailles[entreprise.categorie_entreprise] || "N/A";
    
    // Conversion de la date YYYY-MM-DD vers JJ/MM/YYYY
    const dateCreation = entreprise.date_creation;
    if (dateCreation && dateCreation !== "N/A") {
      const [year, month, day] = dateCreation.split('-');
      clone.getElementById("date_creation").textContent = `${day}/${month}/${year}`;
    } else {
      clone.getElementById("date_creation").textContent = "N/A";
    }
    
    container.appendChild(clone);
  }
  
  // Mettre à jour le compteur
  displayedCount = endIndex;
  
  // Gérer l'affichage du bouton "Afficher plus"
  updateLoadMoreButton();
}

function updateLoadMoreButton() {
  const container = document.getElementById("result");
  let loadMoreBtn = document.getElementById('loadMoreBtn');
  
  // Supprimer l'ancien bouton s'il existe
  if (loadMoreBtn) {
    loadMoreBtn.remove();
  }
  
  // Créer un nouveau bouton seulement s'il reste des entreprises
  if (displayedCount < allEntreprises.length) {
    const remaining = allEntreprises.length - displayedCount;
    
    loadMoreBtn = document.createElement('button');
    loadMoreBtn.id = 'loadMoreBtn';
    loadMoreBtn.textContent = `Afficher plus (${remaining} restante${remaining > 1 ? 's' : ''})`;
    loadMoreBtn.className = 'inputStyle';
    loadMoreBtn.style.display = 'block';
    loadMoreBtn.style.margin = '2rem auto';
    loadMoreBtn.style.cursor = 'pointer';
    
    loadMoreBtn.addEventListener('click', () => {
      displayNextBatch();
    });
    
    container.parentNode.insertBefore(loadMoreBtn, container.nextSibling);
  }
}

function toggleTheme() {
  const html = document.documentElement;
  const currentTheme = html.getAttribute('data-theme');
  const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
  
  html.setAttribute('data-theme', newTheme);
  localStorage.setItem('theme', newTheme);
  
  updateThemeButton();
}

function updateThemeButton() {
  const toggleBtn = document.getElementById('themeToggle');
  if (toggleBtn) {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    toggleBtn.textContent = currentTheme === 'dark' ? '☀️' : '🌙';
  }
}