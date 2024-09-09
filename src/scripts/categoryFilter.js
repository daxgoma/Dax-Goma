document.addEventListener('DOMContentLoaded', function() {
    const categoryItems = document.querySelectorAll('#categoryUl li');
    const products = document.querySelectorAll('#productsContainer .article');

    categoryItems.forEach(item => {
        item.addEventListener('click', function() {
            const selectedCategory = item.getAttribute('data-category');

            // Loop through each product
            products.forEach(product => {
                const productCategory = product.getAttribute('data-category');

                // Show product if it matches the selected category or if 'Tout' is selected
                if (selectedCategory === 'all' || productCategory === selectedCategory) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });

            // Optional: Add an active class to highlight the selected category
            categoryItems.forEach(li => li.classList.remove('bg-black', 'text-white'));
            item.classList.add('bg-black', 'text-white');
        });
    });
});
