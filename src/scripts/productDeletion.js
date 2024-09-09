document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.deleteProduct');
    const popup = document.getElementById('productDeletion');
    const cancelButton = document.querySelector('#cancelDeletionBtn');
    const confirmButton = document.querySelector('#deleteBtn');
    let productIdToDelete = null;

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            productIdToDelete = this.getAttribute('data-product-id');
            popup.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    });

    cancelButton.addEventListener('click', function() {
        popup.style.display = 'none';
        productIdToDelete = null;
        document.body.style.overflow = 'auto';
    });

    popup.addEventListener('click', function(event) {
        if (event.target === popup) {
            popup.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    confirmButton.addEventListener('click', function() {
        if (productIdToDelete) {
            // Make an AJAX request to delete the product
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../src/php/productDeletion.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    location.reload(); // Reload the page to reflect the deletion
                    alert('Le produit a ete suprimer.')
                } else {
                    alert('Erreur lors de la suppression du produit. Veuillez réessayer.');
                }
            };
            xhr.send('id=' + encodeURIComponent(productIdToDelete));
        }
    });
});
