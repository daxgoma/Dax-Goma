let newProductBtn = document.getElementById('newProductBtn');
let productFormPopup = document.getElementById('productFormPopup');

if (newProductBtn && productFormPopup) {
    newProductBtn.addEventListener('click', function() {
        productFormPopup.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });

    productFormPopup.addEventListener('click', function(event) {
        if (event.target === productFormPopup) {
            productFormPopup.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    productFormPopup.querySelector('#cancelNewProduct').addEventListener('click', function() {
        productFormPopup.style.display = 'none';
        document.body.style.overflow = 'auto'; // Re-enable scrolling
    });
}








// Image handler

document.getElementById('image').addEventListener('change', function(event) {
    const fileInput = event.target;
    const imageContainer = document.querySelector('.image-container img');
    const label = document.querySelector('.image-container label');

    if (fileInput.files && fileInput.files[0]) {
        const file = fileInput.files[0];

        // Create a URL for the selected image file
        const imageURL = URL.createObjectURL(file);

        // Update the image source to display the selected image
        imageContainer.src = imageURL;

        // Update the label's inner text to the name of the selected image
        label.innerText = "Changer l'image";
    }
});








// Get the form element
let productForm = document.getElementById('productForm');

// Attach an event listener to the form submission
productForm.addEventListener('submit', function(event) {
    // Prevent the default form submission
    event.preventDefault();

    // Create a FormData object
    var formData = new FormData(productForm);

    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Define the type of request, the URL, and if it's asynchronous
    xhr.open('POST', '../src/php/newProduct.php', true);

    // Define what happens on successful data submission
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                alert(response.message);
                // Optionally, reset the form or close the popup
                productForm.reset();
                const imageContainer = document.querySelector('.image-container img');
                imageContainer.src = ''
                productFormPopup.style.display = 'none'; // Close the popup
                document.body.style.overflow = 'auto';   // Restore scrolling
                location.reload();
            } else {
                alert(response.message);
            }
        } else {
            alert('Une erreur est survenue. Veuillez réessayer.');
        }
    };

    // Define what happens in case of an error
    xhr.onerror = function () {
        alert('Erreur de réseau. Veuillez vérifier votre connexion.');
    };

    // Send the data
    xhr.send(formData);
});
