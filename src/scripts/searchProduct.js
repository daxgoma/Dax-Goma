document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const productsContainer = document.getElementById('productsContainer');
    const products = Array.from(productsContainer.getElementsByClassName('article'));
    const noProductMessage = document.getElementById('noProductMessage');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.toLowerCase();

        // Reset the container to display all products first
        products.forEach(function(productElement) {
            productElement.style.display = 'block';
        });

        // Filter products based on the search term
        const visibleProducts = products.filter(function(productElement) {
            const productName = productElement.querySelector('h3').textContent.toLowerCase();
            return productName.includes(searchTerm);
        });

        // Hide products that don't match the search term
        products.forEach(function(productElement) {
            if (!visibleProducts.includes(productElement)) {
                productElement.style.display = 'none';
            }
        });

        // Remove any existing "No products found" message
        const existingMessage = productsContainer.querySelector('.no-products-message');
        if (existingMessage) {
            noProductMessage.style.display = 'none';
            productsContainer.style.display = 'grid'
        }

        // If no products are visible, show a "No products found" message
        //productsContainer.appendChild(noProductMessage);
        if (visibleProducts.length === 0) {
            noProductMessage.style.display = 'flex';
            productsContainer.style.display = 'flex'
        }
    });
});
