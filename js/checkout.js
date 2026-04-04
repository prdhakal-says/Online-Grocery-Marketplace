let cart = JSON.parse(localStorage.getItem('cart')) || [];

function displaySummary() {
  const container = document.getElementById('cart-summary');
  let total = 0;

  cart.forEach(item => {
    total += item.price;

    const div = document.createElement('div');
    div.innerHTML = `${item.name} - $${item.price}`;
    container.appendChild(div);
  });

  container.innerHTML += `<h4>Total: $${total.toFixed(2)}</h4>`;
}

function placeOrder() {
  fetch('/grocerystore/place_order.php',  {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(cart)
  })
  .then(res => res.text())
  .then(data => {
    alert("Order placed successfully!");
    localStorage.removeItem('cart');
    window.location = "index.php";
  });
}

displaySummary();