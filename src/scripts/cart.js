document.addEventListener('DOMContentLoaded', function() {
    const cartButtons = document.querySelectorAll('#addToCart');

    // Helper function to update the button status
    function updateButtonStatus(button, action) {
        if (action === 'added') {
            button.classList.add('active');
        } else {
            button.classList.remove('active');
        }
    }

    // Function to toggle cart status
    function toggleCart(productId, button) {
        fetch('../src/php/cartManager.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `productId=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                updateButtonStatus(button, data.action);
            } else {
                console.error('Error updating cart:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Attach click event to all "Add to Cart" buttons
    cartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = button.closest('.article').dataset.productId;
            toggleCart(productId, button);
        });
    });
});
