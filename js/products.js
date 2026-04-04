let allProducts = [];

fetch('data/products.json')
  .then(res => res.json())
  .then(data => {
    allProducts = data;
    displayProducts(data);
  });

function displayProducts(products) {
  const container = document.getElementById('product-list');
  container.innerHTML = '';

  products.forEach(product => {
    const col = document.createElement('div');
    col.classList.add('col-md-3');

    col.innerHTML = `
      <div class="card mb-4 shadow-sm">
        <img src="${product.image}" class="card-img-top" height="200">
        <div class="card-body text-center">
          <h5>${product.name}</h5>
          <p>$${product.price}</p>
          <button class="btn btn-success" onclick="addToCart('${product.name}', ${product.price})">
            Add to Cart
          </button>
        </div>
      </div>
    `;

    container.appendChild(col);
  });
}

function filterProducts(category) {
  if (category === 'All') {
    displayProducts(allProducts);
  } else {
    const filtered = allProducts.filter(p => p.category === category);
    displayProducts(filtered);
  }
}

function addToCart(name, price) {
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  cart.push({ name, price });
  localStorage.setItem('cart', JSON.stringify(cart));
  alert(name + " added to cart!");
}