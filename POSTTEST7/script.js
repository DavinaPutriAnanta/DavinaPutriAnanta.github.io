function loadContent(page) {
    const contentArea = document.getElementById('content-area');

    fetch(page)
        .then(response => response.text())
        .then(data => {
            contentArea.innerHTML = data;
            if (document.body.classList.contains('dark-mode')) {
                contentArea.classList.add('dark-mode');
            } else {
                contentArea.classList.remove('dark-mode');
            }
        })
        .catch(error => {
            contentArea.innerHTML = "<p>Error loading page.</p>";
            console.error('Error:', error);
        });
}

document.addEventListener('DOMContentLoaded', function() {
    loadContent('home.html');
});
function addToCart(productName, productPrice) {
    alert(`${productName} added to cart. Price: $${productPrice}`);
}
function toggleMenu() {
    const navbarLinks = document.getElementById('navbar-links');
    navbarLinks.style.display = (navbarLinks.style.display === 'block') ? 'none' : 'block';
}
function toggleDarkMode() {
    const body = document.body;
    body.classList.toggle('dark-mode');
    const background = document.getElementById('content-area');
    background.classList.toggle('dark-mode');
}
