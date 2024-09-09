document.addEventListener('DOMContentLoaded', function() {
    const editProductPopup = document.getElementById('editProduct');
    const editForm = document.getElementById('editForm');
    const editImageInput = document.getElementById('editImage');
    const editImageContainer = document.querySelector('#editImageContainer img');
    let currentProductId = null;

    // Handle Modifier button click
    document.querySelectorAll('.edit-product').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            currentProductId = this.dataset.productId;

            // Fetch product data from the server
            fetch('../src/php/getProduct.php?id=' + currentProductId)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Populate the form with product data
                        document.getElementById('editName').value = data.product.name;
                        document.getElementById('editDescription').value = data.product.description;
                        document.getElementById('editPrice').value = data.product.price;
                        document.getElementById('editCategory').value = data.product.category;
                        document.querySelector(`input[name="editVisibility"][value="${data.product.visibility}"]`).checked = true;
                        document.querySelector('#editImageContainer img').src = `../src/assets/media/${data.product.image}`;

                        // Show the popup
                        editProductPopup.style.display = 'flex';
                        document.body.style.overflow = 'hidden';
                    } else {
                        alert('Failed to load product data.');
                    }
                });
        });
    });


    // Update image preview when a new image is selected
    editImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                editImageContainer.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });


    // Handle form submission
    editForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        formData.append('id', currentProductId);

        fetch('../src/php/updateProduct.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Produit mis à jour avec succès.');
                location.reload(); // Reload the page to reflect changes
            } else {
                alert('Échec de la mise à jour du produit.');
            }
        });
    });

    // Handle cancel button
    document.getElementById('editProduct').querySelector('#cancelEdit').addEventListener('click', function() {
        editProductPopup.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    editProductPopup.addEventListener('click', function(event) {
        if (event.target === editProductPopup) {
            editProductPopup.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
});
