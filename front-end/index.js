let cartCount = 0;

function addToCart(item) {
    cartCount++;
    document.getElementById('cart-count').innerText = `(${cartCount})`;
    alert(`${item} añadido al carrito`);
}
