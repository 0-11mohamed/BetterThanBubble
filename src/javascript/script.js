let url = 'url';

document.addEventListener('DOMContentLoaded', () => {
    const filter = document.getElementById('filter');
    const query = document.getElementById('query');

    query.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
        event.preventDefault();

        const filterValue = filter.value;
        const queryText = query.value;

        console.log("Filtre :", filterValue);
        console.log("Texte :", queryText);

        editURL(filterValue, queryText);
    }
    });
});

function editURL(filterValue, queryText) {
  switch (filterValue) {
    case 'activite':
      url = 'https://anime-db.p.rapidapi.com/anime?page=1&size=20&search=' + queryText.trim() + '&sortBy=ranking&sortOrder=asc';  break;

    case 'taille':
      url = 'https://anime-db.p.rapidapi.com/anime/by-id/' + parseInt(queryText, 10); break;
      
    case 'region':
      url = 'https://anime-db.p.rapidapi.com/anime/by-ranking/' + queryText; break;
    /*https://recherche-entreprises.api.gouv.fr/search?region=[region]&categorie_entreprise=[taille]&section_activite_principale=[activite]&page=[page]&per_page=[per_page]*/
    default:
      url = 'https://recherche-entreprises.api.gouv.fr/search?page=1&per_page=10';
  }
}