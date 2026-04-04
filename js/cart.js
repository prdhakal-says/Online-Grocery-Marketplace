let cart = JSON.parse(localStorage.getItem('cart')) || [];

function displayCart() {
  const container = document.getElementById('cart-items');
  const totalEl = document.getElementById('total-price');

  container.innerHTML = '';
  let total = 0;

  cart.forEach((item, index) => {
    total += item.price;

    const div = document.createElement('div');
    div.classList.add('card', 'p-3', 'mb-2');

    div.innerHTML = `
      <div class="d-flex justify-content-between">
        <span>${item.name} - $${item.price}</span>
        <button class="btn btn-danger btn-sm" onclick="removeItem(${index})">
          Remove
        </button>
      </div>
    `;

    container.appendChild(div);
  });

  totalEl.innerHTML = "Total: $" + total.toFixed(2);
}

function removeItem(index) {
  cart.splice(index, 1);
  localStorage.setItem('cart', JSON.stringify(cart));
  displayCart();
}

displayCart();