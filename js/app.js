fetch('data/products.json')
  .then(res => res.json())
  .then(data => displayProducts(data));

function displayProducts(products) {
  const container = document.getElementById('featured-products');
  if (!container) return;

  products.slice(0, 4).forEach(product => {
    const col = document.createElement('div');
    col.classList.add('col-md-3');

    col.innerHTML = `
      <div class="card shadow-sm mb-4">
        <img src="${product.image}" class="card-img-top" height="200" style="object-fit:cover;">
        <div class="card-body text-center">
          <h5 class="card-title">${product.name}</h5>
          <p class="card-text">$${product.price}</p>
          <button class="btn btn-success" onclick="addToCart('${product.name}', ${product.price})">
            Add to Cart
          </button>
        </div>
      </div>
    `;

    container.appendChild(col);
  });
}

function addToCart(name, price) {
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  cart.push({ name, price });
  localStorage.setItem('cart', JSON.stringify(cart));
  alert(name + " added to cart!");
}