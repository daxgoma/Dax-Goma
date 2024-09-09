document.addEventListener('DOMContentLoaded', function() {
    const boutonCategorie = document.getElementById('categoryBtn');
    const closeCotegoriesBtn = document.getElementById('closeCotegoriesBtn');
    const gestionnaireCategorie = document.getElementById('categoryManager');
    const boutonNouvelleCategorie = document.getElementById('newCategorieBtn');
    const formulaireNouvelleCategorie = document.getElementById('newCategoryForm');
    const conteneurGestionnaireCategorie = document.getElementById('categoryManagerContainer');

    // Ouvrir le gestionnaire de catégories lorsque le bouton Catégories est cliqué
    boutonCategorie.addEventListener('click', function() {
        gestionnaireCategorie.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });

    // Fermer le gestionnaire de catégories en cliquant à l'extérieur du conteneur d'édition
    gestionnaireCategorie.addEventListener('click', function(event) {
        if (event.target === gestionnaireCategorie) {
            gestionnaireCategorie.style.display = 'none';
            document.body.style.overflow = 'auto';
            formulaireNouvelleCategorie.reset(); // Réinitialiser les champs du formulaire
            formulaireNouvelleCategorie.style.display = 'none'; // Masquer le gestionnaire de catégories
            conteneurGestionnaireCategorie.style.height = 'calc(100% - 145px)';
        }
    });

    closeCotegoriesBtn.addEventListener('click', function() {
        gestionnaireCategorie.style.display = 'none';
        document.body.style.overflow = 'auto';
        formulaireNouvelleCategorie.reset(); // Réinitialiser les champs du formulaire
        formulaireNouvelleCategorie.style.display = 'none'; // Masquer le gestionnaire de catégories
        conteneurGestionnaireCategorie.style.height = 'calc(100% - 145px)';
    });

    // Gérer le clic sur le bouton nouvelle catégorie
    boutonNouvelleCategorie.addEventListener('click', function() {
        formulaireNouvelleCategorie.style.display = 'flex';
        conteneurGestionnaireCategorie.style.height = 'calc(100% - 300px)';
    });
});

// Nouvelle catégorie et affichage des catégories
document.addEventListener('DOMContentLoaded', function() {
    const formulaireNouvelleCategorie = document.getElementById('newCategoryForm');
    const annulerAjoutCategorie = document.getElementById('cancelCategorieAddition');
    const gestionnaireCategorie = document.getElementById('categoryManager');
    const conteneurGestionnaireCategorie = document.getElementById('categoryManagerContainer');

    // Gérer la soumission du formulaire
    formulaireNouvelleCategorie.addEventListener('submit', function(event) {
        event.preventDefault();
    
        const formData = new FormData(formulaireNouvelleCategorie);
        const nomCategorie = formData.get('name').trim().toLowerCase();

        // Récupérer les catégories existantes et vérifier les doublons
        fetch('../src/data/categories.json')
            .then(response => response.json())
            .then(categories => {
                const doublon = categories.some(category => category.name.toLowerCase() === nomCategorie);

                if (doublon) {
                    alert('Cette catégorie existe déjà.');
                } else {
                    // Procéder à l'ajout de la catégorie s'il n'y a pas de doublon
                    fetch('../src/php/addCategory.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert('Catégorie ajoutée avec succès.');
                            // Stocker un indicateur dans localStorage pour garder `categoryManager` ouvert après le rechargement
                            localStorage.setItem('showCategoryManager', 'true');
                            location.reload(); // Recharger la page pour refléter les changements
                        } else {
                            alert('Échec de l\'ajout de la catégorie.');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur s\'est produite lors de l\'ajout de la catégorie.');
                    });
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des catégories:', error);
            });
    });
    
    // Après le rechargement de la page, vérifier si l'indicateur est défini pour afficher `categoryManager`
    if (localStorage.getItem('showCategoryManager') === 'true') {
        document.getElementById('categoryManager').style.display = 'flex';
        localStorage.removeItem('showCategoryManager'); // Effacer l'indicateur
    }

    // Gérer le clic sur le bouton annuler
    annulerAjoutCategorie.addEventListener('click', function() {
        formulaireNouvelleCategorie.reset(); // Réinitialiser les champs du formulaire
        formulaireNouvelleCategorie.style.display = 'none'; // Masquer le gestionnaire de catégories
        conteneurGestionnaireCategorie.style.height = 'calc(100% - 145px)';
    });
});

// Suppression de catégorie
document.addEventListener('DOMContentLoaded', function() {

    // Suppression de catégorie
    document.querySelectorAll('.deleteCategorie').forEach(bouton => {
        bouton.addEventListener('click', function() {
            const boutonConfirmation = this.nextElementSibling;
            if (boutonConfirmation.style.display === 'none') {
                boutonConfirmation.style.display = 'block';
                this.textContent = 'Annuler';
            } else {
                boutonConfirmation.style.display = 'none';
                this.textContent = 'Supprimer';
            }
        });
    });

    document.querySelectorAll('.confirmCategorieDeletion').forEach(bouton => {
        bouton.addEventListener('click', function() {
            const idCategorie = this.dataset.id;

            fetch('../src/php/deleteCategory.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: idCategorie })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Catégorie supprimée avec succès.');
                    // Stocker un indicateur dans localStorage pour garder `categoryManager` ouvert après rechargement
                    localStorage.setItem('showCategoryManager', 'true');
                    location.reload(); // Recharger la page pour refléter les changements
                } else {
                    alert('Échec de la suppression de la catégorie.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur s\'est produite lors de la suppression de la catégorie.');
            });
        });
    });

    // Après le rechargement de la page, vérifier si l'indicateur est défini pour afficher `categoryManager`
    if (localStorage.getItem('showCategoryManager') === 'true') {
        document.getElementById('categoryManager').style.display = 'flex';
        localStorage.removeItem('showCategoryManager'); // Effacer l'indicateur
    }
});

// search Category
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchCategory');
    const categoriesContainer = document.getElementById('categoryManagerContainer');
    const categories = Array.from(categoriesContainer.getElementsByClassName('categorie'));

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.toLowerCase();

        let hasVisibleCategory = false;

        categories.forEach(function(categoryElement) {
            const categoryName = categoryElement.querySelector('span').textContent.toLowerCase();

            if (categoryName.includes(searchTerm) || searchTerm === '') {
                categoryElement.style.display = 'flex';
                hasVisibleCategory = true;
            } else {
                categoryElement.style.display = 'none';
            }
        });

        // If no categories are visible, show the "No category" message
        let noCategoryMessage = categoriesContainer.querySelector('.no-category-message');
        if (!hasVisibleCategory) {
            if (!noCategoryMessage) {
                noCategoryMessage = document.createElement('div');
                noCategoryMessage.className = 'no-category-message font-bold text-xl text-gray-500 flex items-center justify-center w-full py-12';
                noCategoryMessage.textContent = 'Aucune catégorie trouvée';
                categoriesContainer.appendChild(noCategoryMessage);
            }
        } else if (noCategoryMessage) {
            noCategoryMessage.remove();
        }
    });
});
